<?php
    requireFile('../app/Views/sessionstart.php');
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Block direct access to this webpage
    if(!isset($_SESSION['user_token']))
    {
        header("Location: login");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['change_password_error'] = "Request Method is not POST!";
        header("Location: changepassword");
        exit();
    }

    // Check and sanitize the user input that is form data
    $old_password = sanitize_input($_POST['oldpass']);
    $new_password = sanitize_input($_POST['newpass']);

    // Validate user provided form data
    validate_password($old_password, 'changepassword', 'oldpass');
    validate_password($new_password, 'changepassword', 'newpass');

    $token = $_SESSION['user_token'];

    // sql query
    $sql = "SELECT user_password FROM user WHERE token='{$token}'";

    try
    {
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            $_SESSION['change_password_error'] = "Database server unavailable. Please try again later!";
            header("Location: changepassword");
            exit();
        }
            $result = $conn->query($sql);

            if($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();

                if(password_verify($old_password, $row['user_password']))
                {
                    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $ChangePasswordQuery = "UPDATE user SET user_password = '$new_password_hash' WHERE token='{$token}'";

                    try
                    {
                        $ChangePasswordResult = $conn->query($ChangePasswordQuery);

                        if($ChangePasswordResult)
                        {
                            $_SESSION['change_password_success'] = "Password Changed Successfully!";
                            header("Location: changepassword");
                            exit();
                        }
                    }
                    catch(mysqli_sql_exception $e)
                    {
                        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
                        $_SESSION['change_password_error'] = "Unable to change password. Please try again later!";
                        header("Location: changepassword");
                        exit();
                    }
                }
                else
                {
                    $_SESSION['change_password_error'] = "Wrong Password!";
                    header("Location: changepassword");
                    exit();
                }
            }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['change_password_error'] = "Please try again later!";
        header("Location: changepassword");
        exit();
    }
?>
