<?php
    if(!empty($_SESSION['add']['formData']['custom_fields_number']))
    {
        // $n depicts the number of pairs of custom fields present
        $n = $_SESSION['add']['formData']['custom_fields_number'];

        $array = array_keys($_SESSION['add']['formData']);
        $fieldarray = [];
        foreach($array as $x)
        {
            if(str_contains($x, 'fieldName'))
            {
                $fieldarray[] = str_replace('fieldName', '', $x);
            }
        }

        foreach($fieldarray as $n)
        {
            echo "<div class='row'>";
            echo "<div class='dropCustomElement'><span title='Remove the custom field'>X</span></div>";
        
            $fieldName = 'fieldName' . $n;

            $fieldValue = $_SESSION['add']['formData'][$fieldName] ?? '';
            
            $customFieldName = 'customInputElement' . ($n*2)-1;
            $customFieldValue = 
            $_SESSION['add']['formData'][$customFieldName];

            $customInputElement = <<< EOT
            <div class="col25">
                <input type="hidden" name="$fieldName" value="$fieldValue">
                <input type="text" name="{$customFieldName}" maxlength="100" 
                placeholder="Enter field name here" required value="{$customFieldValue}">
            </div>
EOT;
echo $customInputElement;

            // Show custom input field validation error 
            echo showValidationError('add', $customFieldName);

            $customFieldName = 'customInputElement' . ($n*2);
            $customFieldValue = 
            $_SESSION['add']['formData'][$customFieldName];

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
        }
    }
?>
