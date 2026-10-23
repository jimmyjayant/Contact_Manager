<?php
declare(strict_types=1);

function showValidationError(string $page, string $fieldName)
{
    if(!empty($_SESSION[$page]['validationErrors'][$fieldName]) && 
    count($_SESSION[$page]['validationErrors'][$fieldName]) > 0)
    {
        $err = "<div class='error'>";
        foreach($_SESSION[$page]['validationErrors'][$fieldName] as $error)
        {
            $err .= "<p>";
            $err .= sanitize_input($error);
            $err .= "</p>";
        }
        $err .= "</div>";
        unset($_SESSION[$page]['validationErrors'][$fieldName]);
        return $err;
    }

    return "";
}
?>
