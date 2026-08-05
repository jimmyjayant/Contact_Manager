<?php
    require_once '../app/Views/sessionstart.php';
    require_once "../app/Config/Database_Connection.php";

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $_SESSION['registration_error'] = "Request Method is not POST!";
        header("Location: register");
        exit();
    }

    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['registration_error'] = "Session expired. Please refresh the webpage!";
        header("Location: register");
        exit();
    }

    function test_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    $fname = test_input($_POST['fname']);

    if(empty($fname))
    {
        $_SESSION['fname_error'] = "First Name cannot be empty!";
        header("Location: register");
        exit();
    }

    if(strlen($fname) > 100)
    {
        $_SESSION['fname_error'] = "First Name cannot be more than 100 characters!";
        header("Location: register");
        exit();
    }

    if(preg_match_all("/\d/", $fname))
    {
        $_SESSION['fname_error'] = "First Name cannot contain digits!";
        header("Location: register");
        exit();
    }

    if(preg_match_all("/\s/", $fname))
    {
        $_SESSION['fname_error'] = "First Name cannot contain whitespaces!";
        header("Location: register");
        exit();
    }

    if(preg_match_all("/\W/", $fname))
    {
        $_SESSION['fname_error'] = "First Name cannot contain special characters!";
        header("Location: register");
        exit();
    }

    $lname = test_input($_POST['lname']);

    if(empty($lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot be empty!";
        header("Location: register");
        exit();
    }

    if(strlen($lname) > 100)
    {
        $_SESSION['lname_error'] = "Last Name cannot be more than 100 characters!";
        header("Location: register");
        exit();
    }

    if(preg_match_all("/\d/", $lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot contain digits!";
        header("Location: register");
        exit();
    }

    if(preg_match_all("/\s/", $lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot contain whitespaces!";
        header("Location: register");
        exit();
    }

    if(preg_match_all("/\W/", $lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot contain special characters!";
        header("Location: register");
        exit();
    }

    $email = test_input($_POST['email']);

    if(empty($email))
    {
        $_SESSION['email_error'] = "Email cannot be empty!";
        header("Location: register");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['email_error'] = "Invalid Email Address!";
        header("Location: register");
        exit();
    }

    $pass = test_input($_POST['pass']);

    if(empty($pass))
    {
        $_SESSION['pass_error'] = "Password cannot be empty!";
        header("Location: register");
        exit();
    }
    else if(strlen($pass) < 6 || strlen($pass) > 12)
    {
        $_SESSION['pass_error'] = "Password Length must be between 6-12";
        header("Location: register");
        exit();
    }

    $contact = test_input($_POST['contact']);

    if(empty($contact))
    {
        $_SESSION['contact_error'] = "Contact cannot be empty!";
        header("Location: register");
        exit();
    }
    else if(!preg_match("/^\d{10}$/", $contact))
    {
        $_SESSION['contact_error'] = "Contact must contain 10 digits!";
        header("Location: register");
        exit();
    }

    // Convert plain text password to hash
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    // user token
    $token = bin2hex(random_bytes(32));

    // sql statement to insert new user into user table in contact_manager_db database
    $sql = "INSERT INTO user(firstname, lastname, email, user_password, contact, token) 
            VALUES('$fname', '$lname', '$email', '$pass', $contact, '$token')";

    try
    {
        if(!$conn)
        {
            $_SESSION['registration_error'] = "Database server unavailable. Please try again later!";
            header("Location: register");
            exit();
        }

        $result = $conn->query($sql);
        if($result === true)
        {
            $_SESSION['user_token'] = $token;
            $_SESSION['username'] = $fname;
            header("Location: dashboard");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        //echo $e->getMessage();
        if($e->getCode() == 1062)
        {
            error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
            $_SESSION['registration_error'] = "Email Already Exists!";
            header("Location: register");
            exit();
        }
        else
        {
            error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
            $_SESSION['registration_error'] = "Error Registering User. Please try again later!";
            header("Location: register");
            exit();
        }
    }
?>
