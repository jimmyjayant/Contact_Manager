<?php
// PHP Script for getting details of a particular contact of logged in user
require_once "../app/Views/sessionstart.php";
require_once "../app/Config/Database_Connection.php";

ini_set("display_errors", 0);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($_SERVER['REQUEST_METHOD'] !== 'GET')
{
    $data['status'] = 'error';
    $data['data'] = "Request Method is not GET.";
    echo json_encode($data);
    header("Content-Type: application/json");
    exit();
}
else
{
    if(!isset($_SESSION['user_token']))
    {
        $data['status'] = "error";
        $data['data'] = "Please login!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        exit();
    }

    if(!isset($_GET['id']))
    {
        $data['status'] = 'error';
        $data['data'] = "URL query parameter 'id' is not set!";
        echo json_encode($data);
        header("Content-Type: application/json");
        exit();
    }
    else
    {
        function test_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        $id = test_input($_GET['id']);
        
        $token = $_SESSION['user_token'];
        // sql query
        $sql = "SELECT id FROM user WHERE token='{$token}'";

        try
        {
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

            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $user_id = $row['id'];

                $sql = "SELECT * FROM contacts WHERE user_id={$user_id} AND form_number={$id}";

                $result = $conn->query($sql);

                if($result->num_rows == 1)
                {
                    ob_start();

                    require_once "../app/Views/edit.php";

                    //$html = file_get_contents("../app/Views/edit.php");

                    $data['data'] = ob_get_contents();
                    ob_end_clean();

                    $data['status'] = 'success';
                    $data = json_encode($data);
                    header("Content-Type: application/json");
                    echo $data;
                    exit();
                }
                else
                {
                    $data['status'] = "error";
                    $data['data'] = "Contact details not found. Please check provided edit id!";
                    $data = json_encode($data);
                    header("Content-Type: application/json");
                    echo $data;
                    exit();
                }
            }
            else
            {
                $data['status'] = "error";
                $data['data'] = "Database server unavailable. Please try again later!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
        }
        catch(mysqli_sql_exception $e)
        {
            // code here
        }
    }
}
?>
