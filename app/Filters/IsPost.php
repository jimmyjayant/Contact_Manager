<?php

function IsPost(string $key = "", string $redirect = "", $isJSON = true)
{
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        if($isJSON)
        {
            $data['status'] = "error";
            $data['data'] = "Request Method is not POST!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
        else
        {
            $_SESSION[$key]['error'] = "Request Method is not POST!";
            header("Location: $redirect");
            exit();
        }       
    }
}
?>
