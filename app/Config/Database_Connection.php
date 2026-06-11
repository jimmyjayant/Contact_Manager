<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_manager_db";

try
{
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error)
    {
        throw new Exception("Database Connection Failed!");
    }
    //echo "Database Connection Successful";
}
catch(Exception $e)
{
    $error = "Database Connection Failed!";
}
?>
