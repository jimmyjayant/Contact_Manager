<?php
    // Validation filters for validation of form data

    function validateFirstname(string $key, string $firstname, $length = 100, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($firstname))
        {
            $_SESSION[$key]['validationErrors']['firstname'][] = "First Name cannot be empty!";
        }
        else if(strlen($firstname) > $length)
        {
            $_SESSION[$key]['validationErrors']['firstname'][] = "First Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $firstname))
        {
            $_SESSION[$key]['validationErrors']['firstname'][] = "First Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $firstname))
        {
            $_SESSION[$key]['validationErrors']['firstname'][] = "First Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $firstname))
        {
            $_SESSION[$key]['validationErrors']['firstname'][] = "First Name cannot contain special characters!";
        }
    }


    function validateMiddlename(string $key, string $middlename, $length = 100, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($middlename))
        {
            $_SESSION[$key]['validationErrors']['middlename'][] = "Middle Name cannot be empty!";
        }
        else if(strlen($middlename) > $length)
        {
            $_SESSION[$key]['validationErrors']['middlename'][] = "Middle Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $middlename))
        {
            $_SESSION[$key]['validationErrors']['middlename'][] = "Middle Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $middlename))
        {
            $_SESSION[$key]['validationErrors']['middlename'][] = "Middle Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $middlename))
        {
            $_SESSION[$key]['validationErrors']['middlename'][] = "Middle Name cannot contain special characters!";
        }
    }


    function validateLastname(string $key, string $lastname, $length = 100, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($lastname))
        {
            $_SESSION[$key]['validationErrors']['lastname'][] = "Last Name cannot be empty!";
        }
        else if(strlen($lastname) > $length)
        {
            $_SESSION[$key]['validationErrors']['lastname'][] = "Last Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $lastname))
        {
            $_SESSION[$key]['validationErrors']['lastname'][] = "Last Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $lastname))
        {
            $_SESSION[$key]['validationErrors']['lastname'][] = "Last Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $lastname))
        {
            $_SESSION[$key]['validationErrors']['lastname'][] = "Last Name cannot contain special characters!";
        }
    }

    function validateNickname(string $key, string $nickname, $length = 100, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($nickname))
        {
            $_SESSION[$key]['validationErrors']['nickname'][] = "Nick Name cannot be empty!";
        }
        else if(strlen($nickname) > $length)
        {
            $_SESSION[$key]['validationErrors']['nickname'][] = "Nick Name cannot be more than $length characters!";
        }
        else if(preg_match_all("/\d/", $nickname))
        {
            $_SESSION[$key]['validationErrors']['nickname'][] = "Nick Name cannot contain digits!";
        }
        else if(preg_match_all("/\s/", $nickname))
        {
            $_SESSION[$key]['validationErrors']['nickname'][] = "Nick Name cannot contain whitespaces!";
        }
        else if(preg_match_all("/\W/", $nickname))
        {
            $_SESSION[$key]['validationErrors']['nickname'][] = "Nick Name cannot contain special characters!";
        }
    }

    function validateGender(string $key, string $gender)
    {
        if(empty($gender))
        {
            $_SESSION[$key]['validationErrors']['gender'][] = "Gender cannot be empty!";
        }
        else if(($gender != 'male') && ($gender != 'female'))
        {
            $_SESSION[$key]['validationErrors']['gender'][] = "Gender should be either male or female";
        }
    }

    function validateMobile(string $key, string $number)
    {
        if(!empty($number) && !preg_match("/^\d{10}$/", $number))
        {
            $_SESSION[$key]['validationErrors']['mobile'][] = "Mobile Number must contain 10 digits!";
        }
    }


    function validateLandline(string $key, int $number)
    {
        if(!empty($number) && !preg_match("/^\d{8}$/", $number))
        {
            $_SESSION[$key]['validationErrors']['landline'][] = "Landline Number must contain 8 digits!";
        }
    }

    function validateEmail(string $key, string $email, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($email))
        {
            $_SESSION[$key]['validationErrors']['email'][] = "Email cannot be empty!";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $_SESSION[$key]['validationErrors']['email'][] = "Invalid Email Address!";
        }
    }


    function validateMessage(string $key, string $message, $canBeEmpty = false, $name = '')
    {
        $value = strtolower($name);

        if(!$canBeEmpty && empty($message))
        {
            $_SESSION[$key]['validationErrors'][$value][] = " $name cannot be empty!";
        }
        else if(strlen($message) > 150)
        {
            $_SESSION[$key]['validationErrors'][$value][] = "$name cannot be more than 150 characters!";
        }
    }


    function validatePassword(string $key, string $password, string $inputField = 'password')
    {
        if(empty($password))
        {
            $_SESSION[$key]['validationErrors'][$inputField][] = "Password cannot be empty!";
        }
        else if(strlen($password) < 6 || strlen($password) > 12)
        {
            $_SESSION[$key]['validationErrors'][$inputField][] = "Password Length must be between 6-12";
        }   
    }


    function validateAddress(string $key, string $address, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($address))
        {
            $_SESSION[$key]['validationErrors']['address'][] = "Address cannot be empty!";
        }
        else if(strlen($address) > 500)
        {
            $_SESSION[$key]['validationErrors']['address'][] = "Address cannot be more than 500 characters!";
        }
    }



    function validateRelationship(string $key, string $relationship, $canBeEmpty = false)
    {
        if(!$canBeEmpty && empty($relationship))
        {
            $_SESSION[$key]['validationErrors']['relationship'][] = " Relationship cannot be empty!";
        }
        else if(strlen($relationship) > 100)
        {
            $_SESSION[$key]['validationErrors']['relationship'][] = "Relationship cannot be more than 100 characters!";
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



    function validateCustomInputFields(string $key, $nameLength = 100, $valueLength = 500, $canBeEmpty = false)
    {
        if(!empty($_SESSION[$key]['formData']['custom_fields_present']) &&
            $_SESSION[$key]['formData']['custom_fields_present'] == 1)
        {
            if(!empty($_SESSION[$key]['formData']['custom_fields_number']) &&
            $_SESSION[$key]['formData']['custom_fields_number'] > 0)
            {
                $array = array_keys($_SESSION[$key]['formData']);
                $fieldarray = [];
                foreach($array as $x)
                {
                    if(str_contains($x, 'fieldName'))
                    {
                        $fieldarray[] = str_replace('fieldName', '', $x);
                    }
                }

                foreach($fieldarray as $n)
                {
                    $customFieldName = $_SESSION[$key]['formData']['customInputElement' . ($n*2)-1];
                    
                    // Validate Custom Input Field Name
                    if(!$canBeEmpty && empty($customFieldName))
                    {
                        $_SESSION[$key]['validationErrors']['customInputElement' . ($n*2)-1][] = 
                        "customInputElement{($n*2)-1} cannot be empty!";
                    }
                    else if(strlen($customFieldName) > $nameLength)
                    {
                        $_SESSION[$key]['validationErrors']['customInputElement' . ($n*2)-1][] = 
                        "customInputElement{($n*2)-1} cannot be more than $nameLength characters!";
                    }

                    $element = 'customInputElement' . ($n*2);
                    $customFieldValue = $_SESSION[$key]['formData'][$element];

                    // Validate Custom Input Field Value
                    if(!$canBeEmpty && empty($customFieldValue))
                    {
                        $_SESSION[$key]['validationErrors'][$element][] = 
                        "$element cannot be empty!";
                    }
                    else if(strlen($customFieldValue) > $valueLength)
                    {
                        $_SESSION[$key]['validationErrors'][$element][] = 
                        "$element cannot be more than $valueLength characters!";
                    }
                }
            }
        }
    }



    function DisplayValidationErrors(string $key, string $redirect = '', $isJSON = true)
    {
        if(!empty($_SESSION[$key]['validationErrors']))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = $_SESSION[$key]['validationErrors'];
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
