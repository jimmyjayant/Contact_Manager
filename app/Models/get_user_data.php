<?php
    // PHP Script for Login Page
    requireFile('../app/Views/sessionstart.php');
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile('../app/Filters/validationFilters.php');

    // Do not display the error to the user
    ini_set("display_errors", 0);

    // Report MySQL Database errors
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['login_error'] = "Request Method is not POST!";
        header("Location: login");
        exit();
    }

    /* If the session variable csrf_token and post variable csrf_token are not set OR 
        both of these variables are not equal to one another, then 
    */
    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) && 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION['login_error'] = "Session expired. Please refresh the webpage!";
        header("Location: login");
        exit();
    }

    $email = sanitize_input($_POST['email']);
    $pass = sanitize_input($_POST['pass']);

    // Validate email
    validate_email($email, 'login', false, false);
    
    // Validate password
    validate_password($pass, 'login', 'pass');

    // sql statement to get particular user record from user table in contact_manager_db database
    $sql = "SELECT user_password FROM user WHERE email='{$email}'";

    try
    {
        //global $conn;
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            $_SESSION['login_error'] = "Database server unavailable. Please try again later!";
            header("Location: login");
            exit();
        }

        $result = $conn->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();

            // Verify the password
            if(password_verify($pass, $row['user_password']))
            {
                // Update the token field of the respective user id with a new one
                $token = bin2hex(random_bytes(32));
                $UpdateTokenQuery = "UPDATE user SET token='{$token}' WHERE email='{$email}'";

                try
                {
                    $result = $conn->query($UpdateTokenQuery);

                    if($result === TRUE)
                    {
                        // Again retrieve that particular user record with newly inserted token
                        $RetrieveUserRecordWithToken = "SELECT firstname, token FROM user WHERE email='{$email}' 
                                                        AND token='{$token}'";

                        try
                        {
                            $result = $conn->query($RetrieveUserRecordWithToken);

                            if($result->num_rows == 1)
                            {
                                $row = $result->fetch_assoc();

                                $_SESSION['user_token'] = $row['token'];
                                $_SESSION['username'] = $row['firstname'];
                                header("Location: dashboard");
                                exit();
                            }
                        }
                        catch(mysqli_sql_exception $e)
                        {
                            error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
                            $_SESSION['login_error'] = "Database server unavailable. Please try again later!";
                            header("Location: login");
                            exit();
                        }
                    }
                    else
                    {
                        $_SESSION['login_error'] = "Database server unavailable. Please try again later!";
                        header("Location: login");
                        exit();
                    }
                }
                catch(mysqli_sql_exception $e)
                {
                    error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
                    $_SESSION['login_error'] = "Database server unavailable. Please try again later!";
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
        }
        else
        {
            $_SESSION['login_error'] = "Wrong Credentials!";
            header("Location: login");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['login_error'] = "Wrong Credentials!";
        header("Location: login");
        exit();
    }
?>
