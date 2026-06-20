<?php
require '../app/Views/sessionstart.php';
require_once("../app/Config/Database_Connection.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    function test_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    function test_field_name($input, $length)
    {
        if(empty($input))
        {
            $_SESSION['add_contact_error'] = "Field Name cannot be empty!";
            header("Location: dashboard");
            exit();
        }
        else if(strlen($input) > $length)
        {
            $_SESSION['add_contact_error'] = "Field Name cannot be more than $length characters!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\d/", $input))
        {
            $_SESSION['add_contact_error'] = "Field Name cannot contain digits!";
            header("Location: dashboard");
            exit();
        }
        else if(preg_match_all("/\W/", $input))
        {
            $_SESSION['add_contact_error'] = "Field Name cannot contain special characters!";
            header("Location: dashboard");
            exit();
        }

        //return $input;
    }

    $firstname = test_input($_POST['firstname']);

    if(empty($firstname))
    {
        $_SESSION['firstname_error'] = "First Name cannot be empty!";
        header("Location: dashboard");
        exit();
    }
    else if(strlen($firstname) > 100)
    {
        $_SESSION['firstname_error'] = "First Name cannot be more than 100 characters!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\d/", $firstname))
    {
        $_SESSION['firstname_error'] = "First Name cannot contain digits!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\s/", $firstname))
    {
        $_SESSION['firstname_error'] = "First Name cannot contain whitespaces!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\W/", $firstname))
    {
        $_SESSION['firstname_error'] = "First Name cannot contain special characters!";
        header("Location: dashboard");
        exit();
    }

    $middlename = test_input($_POST['middlename']);

    if(strlen($middlename) > 100)
    {
        $_SESSION['middlename_error'] = "Middle Name cannot be more than 100 characters!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\d/", $middlename))
    {
        $_SESSION['middlename_error'] = "Middle Name cannot contain digits!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\s/", $middlename))
    {
        $_SESSION['middlename_error'] = "Middle Name cannot contain whitespaces!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\W/", $middlename))
    {
        $_SESSION['middlename_error'] = "Middle Name cannot contain special characters!";
        header("Location: dashboard");
        exit();
    }

    $lastname = test_input($_POST['lastname']);

    if(strlen($lastname) > 100)
    {
        $_SESSION['lastname_error'] = "Last Name cannot be more than 100 characters!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\d/", $lastname))
    {
        $_SESSION['lastname_error'] = "Last Name cannot contain digits!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\s/", $lastname))
    {
        $_SESSION['lastname_error'] = "Last Name cannot contain whitespaces!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\W/", $lastname))
    {
        $_SESSION['lastname_error'] = "Last Name cannot contain special characters!";
        header("Location: dashboard");
        exit();
    }

    $nickname = test_input($_POST['nickname']);

    if(strlen($nickname) > 100)
    {
        $_SESSION['nickname_error'] = "Nick Name cannot be more than 100 characters!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\d/", $nickname))
    {
        $_SESSION['nickname_error'] = "Nick Name cannot contain digits!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\s/", $nickname))
    {
        $_SESSION['nickname_error'] = "Nick Name cannot contain whitespaces!";
        header("Location: dashboard");
        exit();
    }
    else if(preg_match_all("/\W/", $nickname))
    {
        $_SESSION['nickname_error'] = "Nick Name cannot contain special characters!";
        header("Location: dashboard");
        exit();
    }

    $gender = test_input($_POST['gender']);

    if(empty($gender))
    {
        $_SESSION['gender_error'] = "Gender cannot be empty!";
        header("Location: dashboard");
        exit();
    }
    else if(($gender != 'male') && ($gender != 'female'))
    {
        $_SESSION['gender_error'] = "Gender should be either male or female";
        header("Location: dashboard");
        exit();
    }

    $mobnum = test_input($_POST['mobnum']);
    //var_dump($mobnum);
    if(!empty($mobnum) && !preg_match("/^\d{10}$/", $mobnum))
    {
        $_SESSION['mobile_error'] = "Mobile Number must contain 10 digits!";
        header("Location: dashboard");
        exit();
    }

    $landnum = test_input($_POST['landnum']);

    if(!empty($landnum) && !preg_match("/^\d{10}$/", $landnum))
    {
        $_SESSION['landline_error'] = "Landline Number must contain 10 digits!";
        header("Location: dashboard");
        exit();
    }

    if(empty($mobnum) && empty($landnum))
    {
        $_SESSION['add_contact_error'] = "Please provide either mobile or landline number!";
        header("Location: dashboard");
        exit();
    }

    $address = test_input($_POST['address']);

    if(strlen($address) > 500)
    {
        $_SESSION['address_error'] = "Address cannot contain more than 500 characters!";
        header("Location: dashboard");
        exit();
    }

    $relationship = test_input($_POST['relationship']);

    if(strlen($relationship) > 100)
    {
        $_SESSION['relationship_error'] = "Relationship cannot contain more than 100 characters!";
        header("Location: dashboard");
        exit();
    }

    $token = $_SESSION['user_token'];
    // sql query
    $sql = "SELECT id FROM user WHERE token='{$token}'";

    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $id = $row['id'];

        // sql query to insert new contact of currently logged in user into contacts table in contact_manager_db
        $sql = "INSERT INTO contacts(user_id, first_name, middle_name, last_name, nickname, gender, mobile_number,     landline_number,addr, relationship)
                VALUES($id, '$firstname', '$middlename', '$lastname', '$nickname', '$gender', '$mobnum', '$landnum', '$address', '$relationship')";

        try
        {
            $result = $conn->query($sql);
            if($result === TRUE)
            {
                $_SESSION['add_contact_success'] = "Contact added successfully";
                header("Location: dashboard");
                exit();
            }
        }
        catch(mysqli_sql_exception $e)
        {
            if($e->getCode() == 1062)
            {
                $_SESSION['add_contact_error'] = "Mobile or Landline Number Already Exists!";
                header("Location: dashboard");
                exit();
            }
            else
            {
                $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later!";
                header("Location: dashboard");
                exit();
            }
        }
    }
/*
    if(isset($_POST['custom_fields_present']) && $_POST['custom_fields_present'] == 1)
    {
        if(isset($_POST['custom_fields_number']) && $_POST['custom_fields_number'] != 0)
        {
            $custom_fields_number = (int)test_input($_POST['custom_fields_number']);
            for($i = 1; $i < ($custom_fields_number * 2); $i = $i+2)
            {
               $customFieldName = test_input($_POST['customInputElement' . $i]);
               test_field_name($customFieldName, 100);
               $customFieldValue = test_input($_POST['customInputElement' . $i+1]);
               if(strlen($customFieldValue) > 500)
                {
                    $_SESSION['add_contact_error'] = "Field Value cannot be more than 500 characters!";
                    header("Location: dashboard");
                    exit();
                }

                // sql statement to insert additional fields into additional_fields table in contact_manager_db database
                $sql = "INSERT INTO additional_fields(userID, field_name, field_value) 
                        VALUES($id, '$customFieldName', '$customFieldValue')";

               try
               {
                    $result = $conn->query($sql);
                    /*
                    if($result === TRUE)
                    {
                        $_SESSION['add_contact_success'] = "Contact added successfully";
                        header("Location: dashboard");
                        exit();
                    }
                    *//*
               }
               catch(mysqli_sql_exception $e)
               {
                /*
                    if($e->getCode() == 1062)
                    {
                        $_SESSION['add_contact_error'] = "Mobile or Landline Number Already Exists!";
                        header("Location: dashboard");
                        exit();
                    }
                    else
                    {
                        *//*
                        $_SESSION['add_contact_error'] = "Error Adding Contact. Please try again later!";
                        header("Location: dashboard");
                        exit();
                    //}
               }
            }

            $_SESSION['add_contact_success'] = "Contact added successfully";
            header("Location: dashboard");
            exit();
        }
    }*/
}
?>
