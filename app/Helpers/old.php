<?php
declare(strict_types=1);

function old(string $page, string $fieldName)
{
    if(isset($_SESSION[$page]['formData']))
    {
        if(array_key_exists($fieldName, $_SESSION[$page]['formData']))
        {
            $value = sanitize_input($_SESSION[$page]['formData'][$fieldName]);
            return $value;
        }
    }
    else
    {
        if($fieldName == 'gender')
        {
            return "male";
        }
    }
}
?>
