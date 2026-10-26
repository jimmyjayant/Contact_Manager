<?php
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile("../app/Filters/validationFilters.php");
    requireFile('../app/Filters/IsLoggedIn.php');
    requireFile('../app/Filters/IsPost.php');
    requireFile('../app/Filters/csrf.php');

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    IsLoggedIn(false);

    IsPost('changepassword', 'change', false);

    csrf('changepassword', 'change');

    // Loop through the key value pairs in $_POST superglobal array
    foreach($_POST as $x => $y)
    {
        // Check and sanitize the user input that is form data
        $$x = sanitize_input($y);
        // Put form data in a session variable array in case validation fails
        // $_SESSION['changepassword']['formData'][$x] = $y;
    }

    // Validate user provided form data
    validatePassword('change', $oldpass, 'oldpass');
    validatePassword('change', $newpass, 'newpass');

    // Display validation errors if exists
    DisplayValidationErrors('change', 'change', false);

    $token = $_SESSION['user_token'];

    // sql query
    $sql = "SELECT user_password FROM user WHERE token='{$token}'";

    try
    {
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            $_SESSION['changepassword']['error'] = "Database server unavailable. Please try again later!";
            header("Location: change");
            exit();
        }
            $result = $conn->query($sql);

            if($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();

                if(password_verify($oldpass, $row['user_password']))
                {
                    $newpass = password_hash($newpass, PASSWORD_DEFAULT);
                    $ChangePasswordQuery = 
                    "UPDATE user SET user_password = '$newpass' WHERE token='{$token}'";

                    try
                    {
                        $ChangePasswordResult = $conn->query($ChangePasswordQuery);

                        if($ChangePasswordResult)
                        {
                            $_SESSION['changepassword']['success'] = "Password Changed Successfully!";
                            header("Location: change");
                            exit();
                        }
                    }
                    catch(mysqli_sql_exception $e)
                    {
                        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
                        $_SESSION['changepassword']['error'] = "Unable to change password. Please try again later!";
                        header("Location: change");
                        exit();
                    }
                }
                else
                {
                    $_SESSION['changepassword']['error'] = "Wrong Password!";
                    header("Location: change");
                    exit();
                }
            }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['changepassword']['error'] = "Please try again later!";
        header("Location: change");
        exit();
    }
?>
