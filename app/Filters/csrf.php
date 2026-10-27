<?php

function csrf(string $key, string $redirect, $isJSON = true)
{
    if(!isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
    {
        if($isJSON)
        {
            $data['status'] = "error";
            $data['data'] = "Session expired. Please refresh the webpage!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
        else
        {
            $_SESSION[$key]['error'] = "Session expired. Please refresh the webpage!";
            header("Location: $redirect");
            exit();
        }
    }
}
?>
