<?php
declare(strict_types=1);

function showValidationError(string $page, string $fieldName) : String
{
    if(!empty($_SESSION[$page]['validationErrors'][$fieldName]) && 
    count($_SESSION[$page]['validationErrors'][$fieldName]) > 0)
    {
        $err = "<div>";
        foreach($_SESSION[$page]['validationErrors'][$fieldName] as $error)
        {
            $err += "<span class='red_font'>";
            $err += sanitize_input($error);
            $err += "</span><br>";
        }
        $err += "</div>";
        unset($_SESSION[$page]['validationErrors'][$fieldName]);
        return $err;
    }

    return "";
}
?>
