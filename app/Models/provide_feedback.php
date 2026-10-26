<?php
    declare(strict_types=1);

    // PHP Script for Feedback Page
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile('../app/Filters/validationFilters.php');
    requireFile('../app/Filters/IsPost.php');
    requireFile('../app/Filters/csrf.php');

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    IsPost('feedback', 'feedback', false);

    csrf('feedback', 'feedback');

    // Loop through the key value pairs in $_POST superglobal array
    foreach($_POST as $x => $y)
    {
        // Check and sanitize the user input that is form data
        $$x = sanitize_input($y);
        // Put form data in a session variable array in case validation fails
        $_SESSION['feedback']['formData'][$x] = $y;
    }

    // Validate user provided form data
    validateFirstname('feedback', $firstname, 100, false);
    validateLastname('feedback', $lastname, 100, false);
    validateMobile('feedback', $mobile);
    validateEmail('feedback', $email, false);
    validateMessage('feedback', $subject, false, 'Subject');
    validateMessage('feedback', $message, false, 'Message');

    // Redirect to show validation errors
    DisplayValidationErrors('feedback', 'feedback', false);

    // sql statement to insert feedback into feedback table in contact_manager_db database
    $sql = "INSERT INTO feedback(firstname, lastname, contact, email, subject, msg) 
            VALUES('$firstname', '$lastname', $mobile, '$email', '$subject', '$message')";

    try
    {
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            $_SESSION['feedback']['error'] = "Database server unavailable. Please try again later!";
            header("Location: feedback");
            exit();
        }

        $result = $conn->query($sql);
        if($result === true)
        {
            unset($_SESSION['feedback']['formData']);
            $_SESSION['feedback']['success'] = "Feedback submitted successfully!";
            header("Location: feedback");
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $_SESSION['feedback']['error'] = "Error submitting feedback. Please try again later!";
        header("Location: feedback");
        exit();
    }
?>
