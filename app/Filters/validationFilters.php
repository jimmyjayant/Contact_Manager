<?php
    // Validation filters for validation of form data

    function validateFirstname(string $key, string $firstname, $length = 100, $canBeEmpty = false)
    {
        // $_SESSION[$key]['firstname'] = [];

        if(!$canBeEmpty && empty($firstname))
        {
            $_SESSION[$key]['firstname'][] = "First Name cannot be empty!";
        }
        else if(strlen($firstname) > $length)
        {
            $_SESSION[$key]['firstname'][] = "First Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $firstname))
        {
            $_SESSION[$key]['firstname'][] = "First Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $firstname))
        {
            $_SESSION[$key]['firstname'][] = "First Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $firstname))
        {
            $_SESSION[$key]['firstname'][] = "First Name cannot contain special characters!";
        }
    }


    function validateMiddlename(string $key, string $middlename, $length = 100, $canBeEmpty = false)
    {
        // $_SESSION[$key]['middlename'] = [];

        if(!$canBeEmpty && empty($middlename))
        {
            $_SESSION[$key]['middlename'][] = "Middle Name cannot be empty!";
        }
        else if(strlen($middlename) > $length)
        {
            $_SESSION[$key]['middlename'][] = "Middle Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $middlename))
        {
            $_SESSION[$key]['middlename'][] = "Middle Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $middlename))
        {
            $_SESSION[$key]['middlename'][] = "Middle Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $middlename))
        {
            $_SESSION[$key]['middlename'][] = "Middle Name cannot contain special characters!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['middlename_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }


    function validateLastname(string $key, string $lastname, $length = 100, $canBeEmpty = false)
    {
        // $_SESSION[$key]['lastname'] = [];

        if(!$canBeEmpty && empty($lastname))
        {
            $_SESSION[$key]['lastname'][] = "Last Name cannot be empty!";
        }
        else if(strlen($lastname) > $length)
        {
            $_SESSION[$key]['lastname'][] = "Last Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $lastname))
        {
            $_SESSION[$key]['lastname'][] = "Last Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $lastname))
        {
            $_SESSION[$key]['lastname'][] = "Last Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $lastname))
        {
            $_SESSION[$key]['lastname'][] = "Last Name cannot contain special characters!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['lastname_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }

    function validateNickname(string $key, string $nickname, $length = 100, $canBeEmpty = false)
    {
        // $_SESSION[$key]['nickname'] = [];

        if(!$canBeEmpty && empty($nickname))
        {
            $_SESSION[$key]['nickname'][] = "Nick Name cannot be empty!";
        }
        else if(strlen($nickname) > $length)
        {
            $_SESSION[$key]['nickname'][] = "Nick Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $nickname))
        {
            $_SESSION[$key]['nickname'][] = "Nick Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $nickname))
        {
            $_SESSION[$key]['nickname'][] = "Nick Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $nickname))
        {
            $_SESSION[$key]['nickname'][] = "Nick Name cannot contain special characters!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['nickname_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }


    /*
    function test_field_input($key, $input, $length = 100, $redirect, $canBeEmpty = false)
        {
            switch($key)
            {
                case 'firstname':
                    $msg = 'First Name';
                    $canBeEmpty = false;
                    break;

                case 'middlename':
                    $msg = 'Middle Name';
                    $canBeEmpty = true;
                    break;

                case 'lastname':
                    $msg = 'Last Name';
                    $canBeEmpty = true;
                    break;

                case 'nickname':
                    $msg = 'Nick Name';
                    $canBeEmpty = true;
                    break;

                case 'gender':
                    $msg = 'Gender';
                    $canBeEmpty = false;
                    break;

                case 'mobnum':
                    $msg = 'Mobile Number';
                    $canBeEmpty = true;
                    break;

                case 'landnum':
                    $msg = 'Landline Number';
                    $canBeEmpty = true;
                    break;

                case 'address':
                    $msg = 'Address';
                    $length = 500;
                    $canBeEmpty = true;
                    break;

                case 'relationship':
                    $msg = 'Relationship';
                    $canBeEmpty = true;
                    break;
            }


            if(!$canBeEmpty && empty($input))
            {
                $_SESSION[$key . '_error'] = "$msg cannot be empty!";
                header("Location: $redirect");
                exit();
            }
            else if(strlen($input) > $length)
            {
                $_SESSION[$key . '_error'] = "$msg cannot be more than $length characters!";
                header("Location: $redirect");
                exit();
            }
            else if(preg_match_all("/\d/", $input))
            {
                $_SESSION[$key . '_error'] = "$msg cannot contain digits!";
                header("Location: $redirect");
                exit();
            }
            else if(preg_match_all("/\s/", $input))
            {
                $_SESSION[$key . '_error'] = "$msg cannot contain whitespaces!";
                header("Location: $redirect");
                exit();
            }
            else if(preg_match_all("/\W/", $input))
            {
                $_SESSION[$key . '_error'] = "$msg cannot contain special characters!";
                header("Location: $redirect");
                exit();
            }
        }
    */

    function validateGender(string $key, string $gender)
    {
        // $_SESSION[$key]['gender'] = [];

        if(empty($gender))
        {
            $_SESSION[$key]['gender'][] = "Gender cannot be empty!";
        }
        else if(($gender != 'male') && ($gender != 'female'))
        {
            $_SESSION[$key]['gender'][] = "Gender should be either male or female";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['gender_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }

    function validateMobile(string $key, string $number)
    {
        // $_SESSION[$key]['mobile'] = [];

        if(!empty($number) && !preg_match("/^\d{10}$/", $number))
        {
            $_SESSION[$key]['mobile'][] = "Mobile Number must contain 10 digits!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['mobile_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }


    function validateLandline(string $key, int $number)
    {
        // $_SESSION[$key]['landline'] = [];

        if(!empty($number) && !preg_match("/^\d{8}$/", $number))
        {
            $_SESSION[$key]['landline'][] = "Landline Number must contain 8 digits!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['landline_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }

    function validateEmail(string $key, string $email, $canBeEmpty = false)
    {
        // $_SESSION[$key]['email'] = [];

        if(!$canBeEmpty && empty($email))
        {
            $_SESSION[$key]['email'][] = "Email cannot be empty!";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $_SESSION[$key]['email'][] = "Invalid Email Address!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $_SESSION['email_error'] = $msg;
                header("Location: $redirect");
                exit();
            }
        }        */
    }


    function validateMessage(string $key, string $message, $canBeEmpty = false, $name = '')
    {
        $value = strtolower($name);
        // $_SESSION[$key][$value] = [];

        if(!$canBeEmpty && empty($message))
        {
            $_SESSION[$key][$value][] = " $name cannot be empty!";
        }
        else if(strlen($message) > 150)
        {
            $_SESSION[$key][$value][] = "$name cannot be more than 150 characters!";
        }
/*
        if(isset($msg))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $msg;
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $name = strtolower($name);
                $key = "$name" . "_error";
                $_SESSION[$key] = $msg;
                header("Location: $redirect");
                exit();
            }
        }*/
    }


    function validatePassword(string $key, string $password)
    {
        // $_SESSION[$key]['password'] = [];

        if(empty($password))
        {
            $_SESSION[$key]['password'][] = "Password cannot be empty!";
        }
        else if(strlen($password) < 6 || strlen($password) > 12)
        {
            $_SESSION[$key]['password'][] = "Password Length must be between 6-12";
        }   
    }


    function testFieldName($input, $length, string $redirect = '', string $error = '')
    {
        $input = sanitize_input($input);

        if(empty($input))
        {
            $key = "$error" . "_contact_error";
            $_SESSION[$key] = "Field Name cannot be empty!";
            header("Location: $redirect");
            exit();
        }
        else if(strlen($input) > $length)
        {
            $key = "$error" . "_contact_error";
            $_SESSION[$key] = "Field Name cannot be more than $length characters!";
            header("Location: $redirect");
            exit();
        }
        else if(preg_match_all("/\d/", $input))
        {
            $key = "$error" . "_contact_error";
            $_SESSION[$key] = "Field Name cannot contain digits!";
            header("Location: $redirect");
            exit();
        }
        else if(preg_match_all("/\W/", $input))
        {
            $key = "$error" . "_contact_error";
            $_SESSION[$key] = "Field Name cannot contain special characters!";
            header("Location: $redirect");
            exit();
        }
    }

    function DisplayValidationErrors(string $key, string $redirect = '', $isJSON = true)
    {
        if(!empty($_SESSION[$key]))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $_SESSION[$key];
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                header("Location: $redirect");
                exit();
            }
        }
    }
?>
