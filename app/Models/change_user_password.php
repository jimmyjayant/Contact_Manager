<?php
require '../app/Views/sessionstart.php';
require_once("../app/Config/Database_Connection.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    function test_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    $old_password = test_input($_POST['oldpass']);

    $new_password = test_input($_POST['newpass']);

    if(empty($old_password))
    {
        $_SESSION['oldpass_error'] = "Old Password cannot be empty!";
        header("Location: changepassword");
        exit();
    }
    else if(strlen($old_password) < 6 || strlen($old_password) > 12)
    {
        $_SESSION['oldpass_error'] = "Old Password must be 6-12 characters long!";
        header("Location: changepassword");
        exit();
    }

    if(empty($new_password))
    {
        $_SESSION['newpass_error'] = "New Password cannot be empty!";
        header("Location: changepassword");
        exit();
    }
    else if(strlen($new_password) < 6 || strlen($new_password) > 12)
    {
        $_SESSION['newpass_error'] = "New Password must be 6-12 characters long!";
        header("Location: changepassword");
        exit();
    }

    $token = $_SESSION['user_token'];

    // sql query
    $sql = "SELECT * FROM user WHERE token='{$token}'";

    try
    {
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
                    error_log($e->getMessage(), 0, "../writable/logs/");
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
        $_SESSION['change_password_error'] = "Please try again later!";
        header("Location: changepassword");
        exit();
    }
}
?>
