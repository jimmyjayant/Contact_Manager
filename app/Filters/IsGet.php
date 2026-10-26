<?php

function IsGet(string $key = "", string $redirect = "", $isJSON = true)
{
    if($_SERVER['REQUEST_METHOD'] !== 'GET')
    {
        if($isJSON)
        {
            $data['status'] = "error";
            $data['data'] = "Request Method is not GET!";
            $data = json_encode($data);
            header("Content-Type: application/json");
            echo $data;
            exit();
        }
        else
        {
            $_SESSION[$key]['error'] = "Request Method is not GET!";
            header("Location: $redirect");
            exit();
        }       
    }
}
?>
