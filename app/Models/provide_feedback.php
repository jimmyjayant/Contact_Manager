<?php
    // PHP Script for Feedback Page
    requireFile("../app/Views/sessionstart.php");
    requireFile("../app/Config/Database_Connection.php");

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['feedback_error'] = "Request Method is not POST!";
        header("Location: feedback");
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
        header("Location: feedback");
        exit();
    }
    else if(strlen($fname) > 100)
    {
        $_SESSION['fname_error'] = "First Name cannot be more than 100 characters!";
        header("Location: feedback");
        exit();
    }
    else if(preg_match_all("/\d/", $fname))
    {
        $_SESSION['fname_error'] = "First Name cannot contain digits!";
        header("Location: feedback");
        exit();
    }
    else if(preg_match_all("/\s/", $fname))
    {
        $_SESSION['fname_error'] = "First Name cannot contain whitespaces!";
        header("Location: feedback");
        exit();
    }
    else if(preg_match_all("/\W/", $fname))
    {
        $_SESSION['fname_error'] = "First Name cannot contain special characters!";
        header("Location: feedback");
        exit();
    }

    $lname = test_input($_POST['lname']);

    if(empty($lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot be empty!";
        header("Location: feedback");
        exit();
    }
    else if(strlen($lname) > 100)
    {
        $_SESSION['lname_error'] = "Last Name cannot be more than 100 characters!";
        header("Location: feedback");
        exit();
    }
    else if(preg_match_all("/\d/", $lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot contain digits!";
        header("Location: feedback");
        exit();
    }
    else if(preg_match_all("/\s/", $lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot contain whitespaces!";
        header("Location: feedback");
        exit();
    }
    else if(preg_match_all("/\W/", $lname))
    {
        $_SESSION['lname_error'] = "Last Name cannot contain special characters!";
        header("Location: feedback");
        exit();
    }

    $mob = test_input($_POST['mob']);

    if(empty($mob))
    {
        $_SESSION['contact_error'] = "Contact cannot be empty!";
        header("Location: feedback");
        exit();
    }
    else if(strlen($mob) < 10)
    {
        $_SESSION['contact_error'] = "Contact must be of 10 digits!";
        header("Location: feedback");
        exit();
    }
    else if(!preg_match("/^\d{10}$/", $mob))
    {
        $_SESSION['contact_error'] = "Contact must contain digits!";
        header("Location: feedback");
        exit();
    }

    $email = test_input($_POST['email']);

    if(empty($email))
    {
        $_SESSION['email_error'] = "Email cannot be empty!";
        header("Location: feedback");
        exit();
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['email_error'] = "Invalid Email Address!";
        header("Location: feedback");
        exit();
    }

    $subject = test_input($_POST['subject']);

    if(empty($subject))
    {
        $_SESSION['subject_error'] = "Subject cannot be empty!";
        header("Location: feedback");
        exit();
    }
    else if(strlen($subject) > 150)
    {
        $_SESSION['subject_error'] = "Subject cannot be more than 150 characters!";
        header("Location: feedback");
        exit();
    }

    $msg = test_input($_POST['msg']);

    if(empty($msg))
    {
        $_SESSION['msg_error'] = "Message cannot be empty!";
        header("Location: feedback");
        exit();
    }
    else if(strlen($msg) > 5000)
    {
        $_SESSION['msg_error'] = "Message cannot be more than 5000 characters!";
        header("Location: feedback");
        exit();
    }

    // sql statement to insert feedback into feedback table in contact_manager_db database
    $sql = "INSERT INTO feedback(firstname, lastname, contact, email, subject, msg) 
            VALUES('$fname', '$lname', $mob, '$email', '$subject', '$msg')";

    try
    {
        if(!$conn)
        {
            $_SESSION['feedback_error'] = "Database server unavailable. Please try again later!";
            header("Location: feedback");
            exit();
        }

        $result = $conn->query($sql);
        if($result === true)
        {
            $_SESSION['feedback_success'] = "Feedback submitted successfully!";
            header("Location: feedback");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['feedback_error'] = "Error submitting feedback. Please try again later!";
        header("Location: feedback");
        exit();
    }
?>
