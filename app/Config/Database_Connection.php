<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_manager_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try
{
    $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);

    return $GLOBALS['conn'];
}
catch(mysqli_sql_exception $e)
{
    error_log($e->getMessage(), 3, "../writable/logs/error_log.txt");
    return false;
}
?>
