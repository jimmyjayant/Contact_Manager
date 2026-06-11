<?php
require '../app/Views/sessionstart.php';
require_once("../app/Config/Database_Connection.php");

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    function test_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    $fname = test_input($_POST['fname']);

    if(empty($fname) || $fname == '')
    {
        $_SESSION['fname_error'] = "First Name cannot be empty!";
        header("Location: register");
        exit();
    }

    $lname = test_input($_POST['lname']);

    if(empty($lname) || $lname == '')
    {
        $_SESSION['lname_error'] = "Last Name cannot be empty!";
        header("Location: register");
        exit();
    }

    $email = test_input($_POST['email']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['email_error'] = "Invalid Email Address!";
        header("Location: register");
        exit();
    }

    $pass = test_input($_POST['pass']);

    if(empty($pass) || $pass == '')
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
    else if(strlen($contact) < 10)
    {
        $_SESSION['contact_error'] = "Contact must be of 10 digits!";
        header("Location: register");
        exit();
    }

    //echo "$fname $lname $email $pass $contact";

    // Convert plain text password to hash
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    // user token
    $token = bin2hex(random_bytes(32));

    // sql statement to insert new user into user table in contact_manager_db database
    $sql = "INSERT IGNORE INTO user(firstname, lastname, email, user_password, contact, token) 
            VALUES('$fname', '$lname', '$email', '$pass', $contact, '$token')";

    $result = $conn->query($sql);

    if($result === true)
    {
        $_SESSION['user_token'] = $token;
        $_SESSION['username'] = $fname;
        header("Location: dashboard");
        exit();
    }
    else
    {
        $_SESSION['registration_error'] = "Error Registering User. Please try again later!";
        header("Location: register");
        exit();
    }
}
?>
