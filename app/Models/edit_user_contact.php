<?php
    // PHP Script for deleting contact of a logged in user
    requireFile("../app/Views/sessionstart.php");
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(!isset($_SESSION['user_token']))
    {
        $_SESSION['edit_contact_error'] = "Please login!";
        header("Location: edit");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['edit_contact_error'] = "Request Method is not POST!";
        header("Location: edit");
        exit();
    }

    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['edit_contact_error'] = "CSRF Token does not match!";
        header("Location: edit");
        exit();
    }

    function test_edit_field_name($input, $length, $n)
    {
        $input = trim($input);

        if(empty($input))
        {
            $_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error'] = 
            "Field Name cannot be empty!";
            header("Location: edit");
            exit();
        }
        else if(strlen($input) > $length)
        {
            $_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error'] = 
            "Field Name cannot be more than $length characters!";
            header("Location: edit");
            exit();
        }
        else if(preg_match_all("/\d/", $input))
        {
            $_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error'] = 
            "Field Name cannot contain digits!";
            header("Location: edit");
            exit();
        }
        else if(preg_match_all("/\W/", $input))
        {
            $_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error'] = 
            "Field Name cannot contain special characters!";
            header("Location: edit");
            exit();
        }

        //return $input;
    }


    // Putting all form data in a session variable
    $_SESSION['edit_form_data']['form_number'] = $_POST['form_number'];
    $_SESSION['edit_form_data']['first_name'] = $_POST['first_name'];
    $_SESSION['edit_form_data']['middle_name'] = $_POST['middle_name'];
    $_SESSION['edit_form_data']['last_name'] = $_POST['last_name'];
    $_SESSION['edit_form_data']['nickname'] = $_POST['nickname'];
    $_SESSION['edit_form_data']['gender'] = $_POST['gender'];
    $_SESSION['edit_form_data']['mobile_number'] = $_POST['mobile_number'];
    $_SESSION['edit_form_data']['landline_number'] = $_POST['landline_number'];
    $_SESSION['edit_form_data']['addr'] = $_POST['addr'];
    $_SESSION['edit_form_data']['relationship'] = $_POST['relationship'];

    if(isset($_POST['custom_fields_present']) && $_POST['custom_fields_present'] == 1)
    {
        if(isset($_POST['custom_fields_number']) && $_POST['custom_fields_number'] != 0)
        {
            $custom_fields_number = sanitize_input(($_POST['custom_fields_number']));
            $n = 1;
            while($n <= $custom_fields_number)
            {
                $fieldName = "fieldName$n";
                if(!empty($_POST[$fieldName]))
                {
                    $_SESSION['edit_form_data']['additional_fields'][$n]['field_name'] = 
                    sanitize_input($_POST[$fieldName]);
                
                    $fieldValue = "fieldValue$n";
                    $_SESSION['edit_form_data']['additional_fields'][$n]['field_value'] = 
                    sanitize_input($_POST[$fieldValue]);
                }

                $n++;
            }
        }
    }

    // Check and sanitize the user input that is form data
    $firstname = sanitize_input($_POST['first_name']);
    $middlename = sanitize_input($_POST['middle_name']);
    $lastname = sanitize_input($_POST['last_name']);
    $nickname = sanitize_input($_POST['nickname']);
    $gender = sanitize_input($_POST['gender']);
    $mobnum = sanitize_input($_POST['mobile_number']);
    $landnum = sanitize_input($_POST['landline_number']);
    $address = sanitize_input($_POST['addr']);
    $relationship = sanitize_input($_POST['relationship']);
    // Form Number
    $formNumber = sanitize_input($_POST['form_number']);


    // Validate user provided form data
    validate_firstname($firstname, 100, 'edit', false, false);
    validate_middlename($middlename, 100, 'edit', true, false);
    validate_lastname($lastname, 100, 'edit', true, false);
    validate_nickname($nickname, 100, 'edit', true, false);
    validate_gender($gender, 'edit', false);
    validate_mobile_number($mobnum, 'edit', false);    
    validate_landline_number($landnum, 'edit', false);


    if(empty($mobnum) && empty($landnum))
    {
        $_SESSION['edit_contact_error'] = "Please provide either mobile or landline number!";
        header("Location: edit");
        exit();
    }

    $mobnum = empty($mobnum) ? "NULL" : "'$mobnum'";
    $landnum = empty($landnum) ? "NULL" : "'$landnum'";


    if(strlen($address) > 500)
    {
        $_SESSION['address_error'] = "Address cannot contain more than 500 characters!";
        header("Location: edit");
        exit();
    }


    if(strlen($relationship) > 100)
    {
        $_SESSION['relationship_error'] = "Relationship cannot contain more than 100 characters!";
        header("Location: edit");
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
            $_SESSION['edit_contact_error'] = "Database server unavailable. Please try again later!";
            header("Location: edit");
            exit();
        }

        $result = $conn->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $id = $row['id'];

            // sql query to update contact record of a particular logged in user 
            $sql = "UPDATE contacts 
                    SET first_name='$firstname',
                        middle_name='$middlename',
                        last_name='$lastname',
                        nickname='$nickname',
                        gender='$gender',
                        mobile_number=$mobnum,
                        landline_number=$landnum,
                        addr='$address',
                        relationship='$relationship'
                    WHERE user_id=$id 
                    AND form_number=$formNumber";

            try
            {
                $result = $conn->query($sql);
            }
            catch(mysqli_sql_exception $e)
            {/*
                if($e->getCode() == 1062)
                {
                    $_SESSION['edit_contact_error'] = "Mobile or Landline Number Already Exists!";
                    header("Location: edit");
                    exit();
                }
                else
                {*/
                    $_SESSION['edit_contact_error'] = "Error Editing Contact. Please try again later!";
                    header("Location: edit");
                    exit();
                //}
            }
        }
        else
        {
            $_SESSION['edit_contact_error'] = "Error Editing Contact. Please try again later!";
            header("Location: edit");
            exit();
        }

        // If custom fields are present in form

        if(isset($_POST['custom_fields_present']) && $_POST['custom_fields_present'] == 1)
        {
            if(isset($_POST['custom_fields_number']) && $_POST['custom_fields_number'] != 0)
            {
                $custom_fields_number = sanitize_input($_POST['custom_fields_number']);
                $n = 1;
                while($n <= $custom_fields_number)
                {
                    $fieldName = "fieldName$n";
                    $fieldName = sanitize_input($_POST[$fieldName]);
                    test_edit_field_name($fieldName, 100, $n);


                    $fieldValue = "fieldValue$n";
                    $fieldValue = sanitize_input($_POST[$fieldValue]);
                    $fieldValue = sanitize_input($fieldValue);

                    if(empty($fieldValue))
                    {
                        $_SESSION['edit_form_data']['additional_fields'][$n]['field_value_error'] = 
                        "Field Value cannot be empty!";
                        header("Location: edit");
                        exit();
                    }
                    else if(strlen($fieldValue) > 500)
                    {
                        $_SESSION['edit_form_data']['additional_fields'][$n]['field_value_error'] = 
                        "Field Value cannot be more than 500 characters!";
                        header("Location: edit");
                        exit();
                    }


                    $sql = "UPDATE additional_fields
                            SET field_name='$fieldName',
                                field_value='$fieldValue'
                            WHERE userID={$id} 
                            AND form_no={$formNumber}";

                    try
                    {
                        $result = $conn->query($sql);
                        if($result === TRUE)
                        {
                            $n++;
                        }
                    }
                    catch(mysqli_sql_exception $e)
                    {
                        $_SESSION['edit_contact_error'] = "Error Editing Contact. Please try again later!";
                        header("Location: edit");
                        exit();
                    }
                }

                $_SESSION['edit_contact_success'] = "Contact edited successfully";
                header("Location: edit");
                exit();
            }
        }
        else
        {
            $_SESSION['edit_contact_success'] = "Contact edited successfully";
            header("Location: edit");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['edit_contact_error'] = "Please try again later!";
        header("Location: edit");
        exit();
    }
?>
