<?php
//require_once '../app/Views/sessionstart.php';

if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}

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
            // Delete all session variables
            session_unset();

            // Delete the session cookie from the user's browser
            //setcookie("PHPSESSID", "", time() - 3600, "/");

            // session.use_cookies specifies whether the session will be stored in cookie on client side. Default is true
            if(ini_get("session.use_cookies"))
            {
                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    "",
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            // Delete the physical session file from server's temporary location
            session_destroy();

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
