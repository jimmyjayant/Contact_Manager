<?php
    // Block direct access to this webpage
    function IsLoggedIn($isJSON = true)
    {
        if(!isset($_SESSION['user_token']))
        {
            if($isJSON)
            {
                $data['status'] = "error";
                $data['data'] = "Please login!";
                $data = json_encode($data);
                header("Content-Type: application/json");
                echo $data;
                exit();
            }
            else
            {
                header("Location: login");
                exit();
            }
        }
    }
?>
