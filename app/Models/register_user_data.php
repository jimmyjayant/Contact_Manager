<?php
    requireFile('../app/Views/sessionstart.php');
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['registration_error'] = "Request Method is not POST!";
        header("Location: register");
        exit();
    }

    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['registration_error'] = "Session expired. Please refresh the webpage!";
        header("Location: register");
        exit();
    }

    // Check and sanitize the user input that is form data
    $fname = sanitize_input($_POST['fname']);
    $lname = sanitize_input($_POST['lname']);
    $email = sanitize_input($_POST['email']);
    $pass = sanitize_input($_POST['pass']);
    $contact = sanitize_input($_POST['contact']);

    // Validate user provided form data
    validate_firstname($fname, 100, 'register', false, false);
    validate_lastname($lname, 100, 'register', false, false);
    validate_email($email, 'register', false, false);
    validate_mobile_number($contact, 'register', false);
    validate_password($pass, 'register', 'pass');


    // Convert plain text password to hash
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    // user token
    $token = bin2hex(random_bytes(32));

    // sql statement to insert new user into user table in contact_manager_db database
    $sql = "INSERT INTO user(firstname, lastname, email, user_password, contact, token) 
            VALUES('$fname', '$lname', '$email', '$pass', $contact, '$token')";

    try
    {
        $conn = $GLOBALS['conn'];
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
