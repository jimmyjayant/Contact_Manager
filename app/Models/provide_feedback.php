<?php
    // PHP Script for Feedback Page
    requireFile("../app/Views/sessionstart.php");
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        $_SESSION['feedback_error'] = "Request Method is not POST!";
        header("Location: feedback");
        exit();
    }

    // Check and sanitize the user input that is form data
    $fname = sanitize_input($_POST['fname']);
    $lname = sanitize_input($_POST['lname']);
    $mob = sanitize_input($_POST['mob']);
    $email = sanitize_input($_POST['email']);
    $subject = sanitize_input($_POST['subject']);
    $msg = sanitize_input($_POST['msg']);

    // Validate user provided form data
    validate_firstname($fname, 100, 'feedback', false, false);
    validate_lastname($lname, 100, 'feedback', true, false);
    validate_mobile_number($mob, 'feedback', false);
    validate_email($email, 'feedback', false, false);
    validate_message($subject, 'feedback', false, false, 'Subject');
    validate_message($msg, 'feedback', false, false, 'Message');


    // sql statement to insert feedback into feedback table in contact_manager_db database
    $sql = "INSERT INTO feedback(firstname, lastname, contact, email, subject, msg) 
            VALUES('$fname', '$lname', $mob, '$email', '$subject', '$msg')";

    try
    {
        $conn = $GLOBALS['conn'];
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
