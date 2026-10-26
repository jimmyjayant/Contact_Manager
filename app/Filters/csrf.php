<?php

function csrf(string $key, string $redirect)
{
    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        $_SESSION[$key]['error'] = "Session expired. Please refresh the webpage!";
        header("Location: $redirect");
        exit();
    }
}
?>
