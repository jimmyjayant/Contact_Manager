<?php
    // PHP Script for deleting contact of a logged in user
    requireFile("../app/Views/sessionstart.php");
    requireFile("../app/Config/Database_Connection.php");
    requireFile('../app/Helpers/sanitize_input_helper.php');

    ini_set("display_errors", 0);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if($_SERVER['REQUEST_METHOD'] !== 'GET')
    {
        $data['status'] = "error";
        $data['data'] = "Request Method is not GET!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }

    if(!isset($_SESSION['user_token']))
    {
        $data['status'] = "error";
        $data['data'] = "Please login!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }

    $token = $_SESSION['user_token'];
    // sql query
    $sql = "SELECT id FROM user WHERE token='{$token}'";

    try
    {
        $conn = $GLOBALS['conn'];
        if(!$conn)
        {
            $data['status'] = "error";
            $data['data'] = "Database server unavailable. Please try again later!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }

        $result = $conn->query($sql);

        if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];

            $contact_id = sanitize_input($_GET['id']);
            
            $sql = "DELETE FROM contacts WHERE user_id={$user_id} AND form_number={$contact_id}";

            $result = $conn->query($sql);

            if($result === TRUE)
            {
                $data['status'] = "success";
                $data['data'] = "Contact deleted successfully!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                $data['status'] = "error";
                $data['data'] = "Unable to delete contact. Please try again later!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
        }
        else
        {
            $data['status'] = "error";
            $data['data'] = "Cannot find logged in user. Please try again later!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
        $data['status'] = "error";
        $data['data'] = "Database server unavailable. Please try again later!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }
?>
