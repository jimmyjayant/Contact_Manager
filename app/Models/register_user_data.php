<?php
    declare(strict_types=1);

    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['register']['error'] = "Request Method is not POST!";
        header("Location: register");
        exit();
    }

    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['register']['error'] = "Session expired. Please refresh the webpage!";
        header("Location: register");
        exit();
    }

    // Check and sanitize the user input that is form data
    $fname = sanitize_input($_POST['firstname']);
    $lname = sanitize_input($_POST['lastname']);
    $email = sanitize_input($_POST['email']);
    $pass = sanitize_input($_POST['password']);
    $contact = sanitize_input($_POST['mobile']);

    // Put form data in a session variable array in case validation fails
    foreach($_POST as $x => $y)
    {
        $_SESSION['register']['formData'][$x] = $y;
    }

    // Validate user provided form data
    validateFirstname('register', $fname, 100, false);
    validateLastname('register', $lname, 100, false);
    validateEmail('register', $email, false);
    validatePassword('register', $pass);
    validateMobile('register', $contact);

    // if(!empty($_SESSION['register']))
    // {
    //     print_r($_SESSION['register']);
    // // var_dump(!($_SESSION['register']));
    // }
    // else
    // {
    //     echo "not found";
    // }
    // exit();
    // Redirect to show validation errors
    DisplayValidationErrors('register', 'register', false);


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
            $_SESSION['register']['error'] = "Database server unavailable. Please try again later!";
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
            $_SESSION['register']['error'] = "Email Already Exists!";
            header("Location: register");
            exit();
        }
        else
        {
            error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
            $_SESSION['register']['error'] = "Error Registering User. Please try again later!";
            header("Location: register");
            exit();
        }
    }
?>
