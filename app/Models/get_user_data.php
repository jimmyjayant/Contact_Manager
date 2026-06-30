<?php
// PHP Script for Login Page
require '../app/Views/sessionstart.php';
require_once("../app/Config/Database_Connection.php");

ini_set("display_errors", 0);

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

    $email = test_input($_POST['email']);

    if(empty($email))
    {
        $_SESSION['email_error'] = "Email cannot be empty!";
        header("Location: login");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['email_error'] = "Invalid Email Address!";
        header("Location: login");
        exit();
    }

    $pass = test_input($_POST['pass']);

    if(empty($pass))
    {
        $_SESSION['pass_error'] = "Password cannot be empty!";
        header("Location: login");
        exit();
    }
    else if(strlen($pass) < 6 || strlen($pass) > 12)
    {
        $_SESSION['pass_error'] = "Password Length must be between 6-12";
        header("Location: login");
        exit();
    }

    // sql statement to insert new user into user table in contact_manager_db database
    $sql = "SELECT * FROM user WHERE email='{$email}'";

    try
    {
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            //var_dump($result);
            $row = $result->fetch_assoc();
            //var_dump($row);

            // Verify the password
            if(password_verify($pass, $row['user_password']))
            {           
                $_SESSION['user_token'] = $row['token'];
                $_SESSION['username'] = $row['firstname'];
                header("Location: dashboard");
                exit();
            }
            else
            {
                $_SESSION['login_error'] = "Wrong Credentials!";
                header("Location: login");
                exit();
            }
        }
        else
        {
            $_SESSION['login_error'] = "Wrong Credentials!";
            header("Location: login");
            exit();
        }

        $_SESSION['login_error'] = "Error Logging User. Please try again later!";
        header("Location: login");
        exit();
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['login_error'] = "Wrong Credentials!";
        header("Location: login");
        exit();
    }
}
?>
