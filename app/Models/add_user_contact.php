<?php
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");
    requireFile('../app/Filters/IsLoggedIn.php');

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    IsLoggedIn(false);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['add']['error'] = "Request Method is not POST!";
        header("Location: add");
        exit();
    }

    // Checking CSRF Token
    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['add']['error'] = "Session expired. Please refresh the webpage!";
        header("Location: login");
        exit();
    }

    // Loop through the key value pairs in $_POST superglobal array
    foreach($_POST as $x => $y)
    {
        // Check and sanitize the user input that is form data
        $$x = sanitize_input($y);
        // Put form data in a session variable array in case validation fails
        $_SESSION['add']['formData'][$x] = $y;
    }

    // Validate user provided form data
    validateFirstname('add', $firstname, 100, false);
    validateMiddlename('add', $middlename, 100, false);    
    validateLastname('add', $lastname, 100, false);    
    validateNickname('add', $nickname, 100, false);
    validateGender('add', $gender);
    validateMobile('add', $mobile);
    validateLandline('add', $landline);
    validateAddress('add', $address, true);
    validateRelationship('add', $relationship, true);

    // Validate custom fields if present
    validateCustomInputFields('add', 100, 500, false);

    // Display validation errors if they exist
    DisplayValidationErrors('add', 'add', false);


    // If both mobile number and landline number are empty
    if(empty($mobile) && empty($landline))
    {
        $_SESSION['add']['error'] = "Please provide either mobile or landline number!";
        header("Location: add");
        exit();
    }

    $mobile = empty($mobile) ? "NULL" : "'$mobile'";
    $landline = empty($landline) ? "NULL" : "'$landline'";


    $token = $_SESSION['user_token'];
    // sql query
    $sql = "SELECT id FROM user WHERE token='{$token}'";

    try
    {
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            throw new Exception('Database server unavailable. Please try again later!');
        }

        $result = $conn->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $id = $row['id'];

            // sql query to insert new contact of currently logged in user into contacts table in contact_manager_db
            $sql = "INSERT INTO contacts(user_id, first_name, middle_name, last_name, nickname, gender,     mobile_number, landline_number, addr, relationship)
                    VALUES($id, '$firstname', '$middlename', '$lastname', '$nickname', '$gender', $mobile, $landline, '$address', '$relationship')";

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
                    $_SESSION['add']['error'] = "Mobile or Landline Number Already Exists!";
                    header("Location: add");
                    exit();
                }
                else
                {
                    $_SESSION['add']['error'] = "Error Adding Contact. Please try again later!";
                    header("Location: add");
                    exit();
                }
            }
        }
        else
        {
            $_SESSION['add']['error'] = "Error Adding Contact. Please try again later!";
            header("Location: add");
            exit();
        }

        // If custom fields are present in form
    
        if(!empty($_SESSION['add']['formData']['custom_fields_present']) && 
            $_SESSION['add']['formData']['custom_fields_present'] == 1)
        {
            if(!empty($_SESSION['add']['formData']['custom_fields_number']) && 
            $_SESSION['add']['formData']['custom_fields_number'] > 0)
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
                    $_SESSION['add']['error'] = 
                    "Main Contact Info added. Error adding additional info. Please try again later!";
                    header("Location: add");
                    exit();
                }

                $custom_fields_number = $_SESSION['add']['formData']['custom_fields_number'];
                for($i = 1; $i < ($custom_fields_number * 2); $i = $i+2)
                {
                    $customFieldName = $_SESSION['add']['formData']['customInputElement' . $i];
                    $customFieldValue = $_SESSION['add']['formData']['customInputElement' . $i+1];

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
                            $_SESSION['add']['error'] = "Additional info Already Exists!";
                            header("Location: add");
                            exit();
                        }
                        else
                        {
                            $_SESSION['add']['error'] = "Error Adding additional info. Please try again later!";
                            header("Location: add");
                            exit();
                        }
                    }
                }

                $_SESSION['add']['success'] = "Contact added successfully";
                unset($_SESSION['add']['formData']);
                header("Location: add");
                exit();
            }
        }
        else
        {
            $_SESSION['add']['success'] = "Contact added successfully";
            unset($_SESSION['add']['formData']);
            header("Location: add");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['add']['error'] = "Database server unavailable. Please try again later!";
        header("Location: add");
        exit();
    }
?>
