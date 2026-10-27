<?php
    if(!empty($_SESSION['add']['formData']))
    {
        $custom_fields_number = $_SESSION['add']['formData']['custom_fields_number'];
        for($i = 1; $i < ($custom_fields_number * 2); $i = $i+2)
        {
            echo "<div class='row'>";
            echo "<div class='dropCustomElement'><span title='Remove the custom field'>X</span></div>";

            $customFieldName = 'customInputElement' . $i;
            $customFieldValue = $_SESSION['add']['formData'][$customFieldName];

            $customInputElement = <<< EOT
                <div class="col25">
                    <input type="text" name="{$customFieldName}" maxlength="100" 
                    placeholder="Enter field name here" required value="{$customFieldValue}">
                </div>
EOT;
echo $customInputElement;

            // Show custom input field validation error 
            echo showValidationError('add', $customFieldName);

            $customFieldName = 'customInputElement' . $i+1;
            $customFieldValue = $_SESSION['add']['formData'][$customFieldName];

            $customInputElement = <<< EOT
                <div class="col75">
                    <input type="text" name="{$customFieldName}" maxlength="500" 
                    placeholder="Enter field value here" required value="{$customFieldValue}">
                </div>
EOT;
echo $customInputElement; 

            // Show custom input field validation error 
            echo showValidationError('add', $customFieldName);

            echo "</div>";
            echo "</div>";
        }
    }
?>
