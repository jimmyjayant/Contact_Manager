<?php
    requireFile('../app/Views/sessionstart.php');
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // If the user is not logged in, then
    if(!isset($_SESSION['user_token']))
    {
        header("Location: login");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['add_contact_error'] = "Request Method is not POST!";
        header("Location: add");
        exit();
    }

    // Checking CSRF Token
    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['add_contact_error'] = "Session expired. Please refresh the webpage!";
        header("Location: login");
        exit();
    }

    // Putting all form data in a session variable
    $_SESSION['add_form_data']['firstname'] = $_POST['firstname'];
    $_SESSION['add_form_data']['middlename'] = $_POST['middlename'];
    $_SESSION['add_form_data']['lastname'] = $_POST['lastname'];
    $_SESSION['add_form_data']['nickname'] = $_POST['nickname'];
    $_SESSION['add_form_data']['gender'] = $_POST['gender'];
    $_SESSION['add_form_data']['mobnum'] = $_POST['mobnum'];
    $_SESSION['add_form_data']['landnum'] = $_POST['landnum'];
    $_SESSION['add_form_data']['address'] = $_POST['address'];
    $_SESSION['add_form_data']['relationship'] = $_POST['relationship'];

    // Check and sanitize the user input that is form data
    $firstname = sanitize_input($_POST['firstname']);
    $middlename = sanitize_input($_POST['middlename']);
    $lastname = sanitize_input($_POST['lastname']);
    $nickname = sanitize_input($_POST['nickname']);
    $gender = sanitize_input($_POST['gender']);
    $mobnum = sanitize_input($_POST['mobnum']);
    $landnum = sanitize_input($_POST['landnum']);
    $address = sanitize_input($_POST['address']);
    $relationship = sanitize_input($_POST['relationship']);

/*
    $user_contact = [
        'firstname' => $firstname,
        'middlename' => $middlename,
        'lastname' => $lastname,
        'nickname' => $nickname,
        'gender' => $gender,
        'mobnum' => $mobnum,
        'landnum' => $landnum,
        'address' => $address,
        'relationship' => $relationship
    ];

    foreach($user_contact as $key => $value)
    {
        test_field_input($key, $value, $length, "add", $canBeEmpty = false);
    }
*/

    // Validate user provided form data
    validate_firstname($firstname, 100, 'add', false, false);
    validate_middlename($middlename, 100, 'add', true, false);    
    validate_lastname($lastname, 100, 'add', true, false);    
    validate_nickname($nickname, 100, 'add', true, false);
    validate_gender($gender, 'add', false);
    validate_mobile_number($mobnum, 'add', false);    
    validate_landline_number($landnum, 'add', false);

    if(empty($mobnum) && empty($landnum))
    {
        $_SESSION['add_contact_error'] = "Please provide either mobile or landline number!";
        header("Location: add");
        exit();
    }

    $mobnum = empty($mobnum) ? "NULL" : "'$mobnum'";
    $landnum = empty($landnum) ? "NULL" : "'$landnum'";


    if(strlen($address) > 500)
    {
        $_SESSION['address_error'] = "Address cannot contain more than 500 characters!";
        header("Location: add");
        exit();
    }

    if(strlen($relationship) > 100)
    {
        $_SESSION['relationship_error'] = "Relationship cannot contain more than 100 characters!";
        header("Location: add");
        exit();
    }

    $token = $_SESSION['user_token'];
    // sql query
    $sql = "SELECT id FROM user WHERE token='{$token}'";

    try
    {
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            $_SESSION['add_contact_error'] = "Database server unavailable. Please try again later!";
            header("Location: add");
            exit();
        }

        $result = $conn->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $id = $row['id'];

            // sql query to insert new contact of currently logged in user into contacts table in contact_manager_db
            $sql = "INSERT INTO contacts(user_id, first_name, middle_name, last_name, nickname, gender, mobile_number,     landline_number, addr, relationship)
                    VALUES($id, '$firstname', '$middlename', '$lastname', '$nickname', '$gender', $mobnum, $landnum, '$address', '$relationship')";

            try
            {
                $result = $conn->query($sql);
                if($result === TRUE)
                {
                    $last_insert_id = $conn->insert_id;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                if($e->getCode() == 1062)
                {
                    $_SESSION['add_contact_error'] = "Mobile or Landline Number Already Exists!";
                    header("Location: add");
                    exit();
                }
                else
                {
                    $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later!";
                    header("Location: add");
                    exit();
                }
            }
        }
        else
        {
            $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later!";
            header("Location: add");
            exit();
        }

        // If custom fields are present in form
    
        if(isset($_POST['custom_fields_present']) && $_POST['custom_fields_present'] == 1)
        {
            if(isset($_POST['custom_fields_number']) && $_POST['custom_fields_number'] != 0)
            {
                $sql = "SELECT form_number FROM contacts WHERE form_number = $last_insert_id";

                try
                {
                    $result = $conn->query($sql);
                    if($result->num_rows == 1)
                    {
                        $row = $result->fetch_assoc();
                        $formNumber = $row['form_number'];
                    }
                }
                catch(mysqli_sql_exception $e)
                {
                    $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later!";
                    header("Location: add");
                    exit();
                }

                $custom_fields_number = sanitize_input($_POST['custom_fields_number']);
                for($i = 1; $i < ($custom_fields_number * 2); $i = $i+2)
                {
                $customFieldName = test_input($_POST['customInputElement' . $i]);
                test_field_name($customFieldName, 100);
                $customFieldValue = test_input($_POST['customInputElement' . $i+1]);
                if(strlen($customFieldValue) > 500)
                    {
                        $_SESSION['add_contact_error'] = "Field Value cannot be more than 500 characters!";
                        header("Location: add");
                        exit();
                    }

                    // sql statement to insert additional fields into additional_fields table in contact_manager_db database
                    $sql = "INSERT INTO additional_fields(userID, form_no, field_name, field_value) 
                            VALUES($id, $formNumber, '$customFieldName', '$customFieldValue')";

                try
                {
                        $result = $conn->query($sql);
                }
                catch(mysqli_sql_exception $e)
                {
                        if($e->getCode() == 1062)
                        {
                            $_SESSION['add_contact_error'] = "Mobile or Landline Number Already Exists!";
                            header("Location: add");
                            exit();
                        }
                        else
                        {
                            $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later1!";
                            header("Location: add");
                            exit();
                        }
                }
                }

                $_SESSION['add_contact_success'] = "Contact added successfully";
                header("Location: add");
                exit();
            }
        }
        else
        {
            $_SESSION['add_contact_success'] = "Contact added successfully";
            header("Location: add");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['add_contact_error'] = "Please try again later!";
        header("Location: add");
        exit();
    }
?>
