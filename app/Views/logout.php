<?php
require_once '../app/Views/sessionstart.php';
require_once "../app/Config/Database_Connection.php";

ini_set("display_errors", 0);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if(!isset($_SESSION['user_token']))
{
    /*
    $data['status'] = "error";
    $data['data'] = "Please login!";
    $data = json_encode($data);
    header("Content-Type: application/json");
    echo $data;
    */
    echo "<script>alert('Please login!');</script>";
    exit();
}

$token = $_SESSION['user_token'];
// sql query
$sql = "SELECT id FROM user WHERE token='{$token}'";

try
{
    if(!$conn)
    {
        /*
        $data['status'] = "error";
        $data['data'] = "Database server unavailable. Please try again later!";
        $data = json_encode($data);
        header("Content-Type: application/json");
        echo $data;
        */
        echo "<script>alert('Database server unavailable. Please try again later!');</script>";
        exit();
    }

    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        $sql = "UPDATE user SET token='' WHERE id={$user_id}";

        $result = $conn->query($sql);

        if($result === TRUE)
        {
            session_unset();
            session_destroy();

            // Delete the cookie
            setcookie("PHPSESSID", "", time() - 3600, "/");

            header("Location: index");
            exit();
        }
    }
}
catch(mysqli_sql_exception $e)
{
    error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
    /*
    $data['status'] = "error";
    $data['data'] = "Database server unavailable. Please try again later!";
    $data = json_encode($data);
    header("Content-Type: application/json");
    echo $data;
    */
    echo "<script>alert('Database server unavailable. Please try again later!');</script>";
    exit();
}
?>
