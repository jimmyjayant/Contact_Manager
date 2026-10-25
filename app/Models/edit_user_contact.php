<?php
    // PHP Script for editing contact of a logged in user
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");
    requireFile('../app/Filters/IsLoggedIn.php');

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    IsLoggedIn(false);
    
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['edit']['error'] = "Request Method is not POST!";
        header("Location: edit");
        exit();
    }

    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['edit']['error'] = "CSRF Token does not match!";
        header("Location: edit");
        exit();
    }

    // Loop through the key value pairs in $_POST superglobal array
    foreach($_POST as $x => $y)
    {
        // Check and sanitize the user input that is form data
        $$x = sanitize_input($y);
        // Put form data in a session variable array in case validation fails
        $_SESSION['edit']['formData'][$x] = $y;
    }
    // echo "<pre>";
    // print_r($_SESSION['edit']['formData']);
    // print_r(array_keys($_SESSION['edit']['formData']));
    // echo "</pre>";
    // exit();

    // $arrayKeys = array_keys($_SESSION['edit']['formData']);

    // foreach($arrayKeys as $x => $y)
    // {
    //     if(!preg_match_all("/customInputElement/", $y))
    //     {
    //         unset($arrayKeys[$x]);
    //     }
    // }

    // echo "<pre>";
    // print_r($arrayKeys);
    // echo "</pre>";
    // exit();

    // foreach($arrayKeys as $x)
    // {
    //     if(array_key_exists($x, $_SESSION['edit']['formData']))
    //     {
    //         $_SESSION['edit']['formData'][$x] = $_SESSION['edit']['formData'][$x];
    //         unset($_SESSION['edit']['formData'][$x]);
    //     }
    // }

    // echo "<pre>";
    // print_r($_SESSION['edit']['formData']);
    // echo "</pre>";
    // exit();

    // Validate user provided form data
    validateFirstname('edit', $firstname, 100, false);
    validateMiddlename('edit', $middlename, 100, false);
    validateLastname('edit', $lastname, 100, false);
    validateNickname('edit', $nickname, 100, false);
    validateGender('edit', $gender);
    validateMobile('edit', $mobile);    
    validateLandline('edit', $landline);
    validateAddress('edit', $address, false);
    validateRelationship('edit', $relationship, false);

    // Validate custom fields if present
    validateCustomInputFields('edit', 100, 500, false);

    // Display validation errors if they exist
    DisplayValidationErrors('edit', 'edit', false);


    if(empty($mobile) && empty($landline))
    {
        $_SESSION['edit']['error'] = "Please provide either mobile or landline number!";
        header("Location: edit");
        exit();
    }

    $mobile = empty($mobile) ? "NULL" : "'$mobile'";
    $landline = empty($landline) ? "NULL" : "'$landline'";

    $token = $_SESSION['user_token'];
    $formNumber = $_SESSION['edit']['formData']['form_number'];

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

            // sql query to update contact record of a particular logged in user 
            $sql = "UPDATE contacts 
                    SET first_name='$firstname',
                        middle_name='$middlename',
                        last_name='$lastname',
                        nickname='$nickname',
                        gender='$gender',
                        mobile_number=$mobile,
                        landline_number=$landline,
                        addr='$address',
                        relationship='$relationship'
                    WHERE user_id=$id 
                    AND form_number=$formNumber";

            try
            {
                $result = $conn->query($sql);
            }
            catch(mysqli_sql_exception $e)
            {
                $_SESSION['edit']['error'] = "Error Editing Contact. Please try again later!";
                header("Location: edit");
                exit();
            }
        }
        else
        {
            $_SESSION['edit']['error'] = "Error Editing Contact. Please try again later!";
            header("Location: edit");
            exit();
        }

        // If custom fields are present in form
        if(!empty($_SESSION['edit']['formData']['custom_fields_present']) 
            && $_SESSION['edit']['formData']['custom_fields_present'] == 1)
        {
            if(!empty($_SESSION['edit']['formData']['custom_fields_number']) 
                && $_SESSION['edit']['formData']['custom_fields_number'] > 0)
            {
                $custom_fields_number = $_SESSION['edit']['formData']['custom_fields_number'];
                for($i = 1; $i < ($custom_fields_number * 2); $i = $i+2)
                {
                    $customFieldName = $_SESSION['edit']['formData']['customInputElement' . $i];
                    $customFieldValue = $_SESSION['edit']['formData']['customInputElement' . $i+1];

                    // sql statement to update additional fields into additional_fields table 
                    // in contact_manager_db database
                    $sql = "UPDATE additional_fields
                            SET field_name='$customFieldName',
                                field_value='$customFieldValue'
                            WHERE userID={$id} 
                            AND form_no={$formNumber}";

                    try
                    {
                        $result = $conn->query($sql);
                    }
                    catch(mysqli_sql_exception $e)
                    {
                        if($e->getCode() == 1062)
                        {
                            $_SESSION['edit']['error'] = "Additional info Already Exists!";
                            header("Location: edit");
                            exit();
                        }
                        else
                        {
                            $_SESSION['edit']['error'] = "Error editing additional info. Please try again later!";
                            header("Location: edit");
                            exit();
                        }
                    }
                }

                $_SESSION['edit']['success'] = "Contact edited successfully";
                unset($_SESSION['edit']['formData']);
                header("Location: edit");
                exit();
            }
        }
        else
        {
            $_SESSION['edit']['success'] = "Contact edited successfully";
            unset($_SESSION['edit']['formData']);
            header("Location: edit");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['edit']['error'] = "Database server unavailable. Please try again later!";
        header("Location: edit");
        exit();
    }
?>
