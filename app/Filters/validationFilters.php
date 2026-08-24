<?php
    // Validation filters for validation of form data

    function validate_firstname(string $firstname, 
                                $length = 100, 
                                string $redirect = '', 
                                $canBeEmpty = false, 
                                $isJSON = true)
    {
        if(!$canBeEmpty && empty($firstname))
        {
            $msg = "First Name cannot be empty!";
        }
        else if(strlen($firstname) > $length)
        {
            $msg = "First Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $firstname))
        {
            $msg = "First Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $firstname))
        {
            $msg = "First Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $firstname))
        {
            $msg = "First Name cannot contain special characters!";
        }

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
            $_SESSION['firstname_error'] = $msg;
            header("Location: $redirect");
            exit();
        }
    }


    function validate_middlename(string $middlename, 
                                $length = 100, 
                                string $redirect = '', 
                                $canBeEmpty = false, 
                                $isJSON = true)
    {
        if(!$canBeEmpty && empty($middlename))
        {
            $msg = "Middle Name cannot be empty!";
        }
        else if(strlen($middlename) > $length)
        {
            $msg = "Middle Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $middlename))
        {
            $msg = "Middle Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $middlename))
        {
            $msg = "Middle Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $middlename))
        {
            $msg = "Middle Name cannot contain special characters!";
        }

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
            $_SESSION['firstname_error'] = $msg;
            header("Location: $redirect");
            exit();
        }
    }


    function validate_lastname(string $lastname, 
                               $length = 100, 
                               string $redirect = '', 
                               $canBeEmpty = false, 
                               $isJSON = true)
    {
        if(!$canBeEmpty && empty($lastname))
        {
            $msg = "Last Name cannot be empty!";
        }
        else if(strlen($lastname) > $length)
        {
            $msg = "Last Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $lastname))
        {
            $msg = "Last Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $lastname))
        {
            $msg = "Last Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $lastname))
        {
            $msg = "Last Name cannot contain special characters!";
        }

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
            $_SESSION['firstname_error'] = $msg;
            header("Location: $redirect");
            exit();
        }
    }

    function validate_nickname(string $nickname, 
                                $length = 100, 
                                string $redirect = '', 
                                $canBeEmpty = false, 
                                $isJSON = true)
    {
        if(!$canBeEmpty && empty($nickname))
        {
            $msg = "Nick Name cannot be empty!";
        }
        else if(strlen($nickname) > $length)
        {
            $msg = "Nick Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $nickname))
        {
            $msg = "Nick Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $nickname))
        {
            $msg = "Nick Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $nickname))
        {
            $msg = "Nick Name cannot contain special characters!";
        }

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
            $_SESSION['firstname_error'] = $msg;
            header("Location: $redirect");
            exit();
        }
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

    function validate_gender(string $gender, string $redirect = '', $isJSON = true)
    {
        if(empty($gender))
        {
            $msg = "Gender cannot be empty!";
        }
        else if(($gender != 'male') && ($gender != 'female'))
        {
            $msg = "Gender should be either male or female";
        }

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
    }

    function validate_mobile_number($number, string $redirect = '', $isJSON = true)
    {
        if(!empty($number) && !preg_match("/^\d{10}$/", $number))
        {
            $msg = "Mobile Number must contain 10 digits!";
        }

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
    }


    function validate_landline_number($number, string $redirect = '', $isJSON = true)
    {
        if(!empty($number) && !preg_match("/^\d{8}$/", $number))
        {
            $msg = "Landline Number must contain 8 digits!";
        }

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
    }

    function validate_email($email, string $redirect = '', $canBeEmpty = false, $isJSON = true)
    {
        if(!$canBeEmpty && empty($email))
        {
            $msg = "Email cannot be empty!";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $msg = "Invalid Email Address!";
        }

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
    }


    function validate_message($message, string $redirect = '', $canBeEmpty = false, $isJSON = true, $name = '')
    {
        if(!$canBeEmpty && empty($message))
        {
            $msg = " $name cannot be empty!";
        }
        else if(strlen($message) > 150)
        {
            $msg = "$name cannot be more than 150 characters!";
        }


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
            $_SESSION[$name . '_error'] = $msg;
            header("Location: $redirect");
            exit();
        }
    }


    function validate_password($password, string $redirect = '', string $error = 'password')
    {
        if(empty($password))
        {
            $_SESSION[$error . '_error'] = "Password cannot be empty!";
            header("Location: $redirect");
            exit();
        }
        else if(strlen($password) < 6 || strlen($password) > 12)
        {
            $_SESSION[$error . '_error'] = "Password Length must be between 6-12";
            header("Location: $redirect");
            exit();
        }   
    }


    function test_field_name($input, $length)
    {
        $input = sanitize_input($input);

        if(empty($input))
        {
            $_SESSION['add_contact_error'] = "Field Name cannot be empty!";
            header("Location: add");
            exit();
        }
        else if(strlen($input) > $length)
        {
            $_SESSION['add_contact_error'] = "Field Name cannot be more than $length characters!";
            header("Location: add");
            exit();
        }
        else if(preg_match_all("/\d/", $input))
        {
            $_SESSION['add_contact_error'] = "Field Name cannot contain digits!";
            header("Location: add");
            exit();
        }
        else if(preg_match_all("/\W/", $input))
        {
            $_SESSION['add_contact_error'] = "Field Name cannot contain special characters!";
            header("Location: add");
            exit();
        }
    }
?>
