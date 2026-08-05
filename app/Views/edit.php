<?php
require_once '../app/Views/sessionstart.php';

$css = ["css/edit.css"];

$js = ["script/edit.js"];

require_once '../app/Views/headerandnavbar.php';

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}

if(empty($_SESSION['edit_form_data']))
{
    header("Location: show");
    exit();
}

function sanitize($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function edit_old(string $inputFieldName)
{
    if(isset($_SESSION['edit_form_data']))
    {
        if(array_key_exists($inputFieldName, $_SESSION['edit_form_data']))
        {
            $value = sanitize($_SESSION['edit_form_data'][$inputFieldName]);    
            return $value;
        }
    }
}
?>

<div class="content">
    <div class="intro">
        <h1>Edit Contact</h1>

        <div id="edit_contact">
            <?php
                if(isset($_SESSION['edit_contact_error']))
                {
                    echo "<div class='center'><span class='red_font'>" . $_SESSION['edit_contact_error'] . "</span></div>";
                    unset($_SESSION['edit_contact_error']);
                }
                else if(isset($_SESSION['edit_contact_success']))
                {
                    echo "<div class='center'><span class='green_font'>" . $_SESSION['edit_contact_success'] . "</span></div>";
                    unset($_SESSION['edit_contact_success']);
                }
            ?>

            <form method="post" action="edit_user_contact" id="editForm">
                <div class="row">
                    <div class="col25">
                        <label for="first_name">First Name*</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="first_name" name="first_name" 
                        value="<?= edit_old('first_name'); ?>" maxlength="100" required>
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_firstname_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_firstname_error'] . "</span></div>";
                            unset($_SESSION['edit_firstname_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="middle_name">Middle Name</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="middle_name" name="middle_name" 
                        value="<?= edit_old('middle_name'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_middlename_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_middlename_error'] . "</span></div>";
                            unset($_SESSION['edit_middlename_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="last_name">Last Name</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="last_name" name="last_name" 
                        value="<?= edit_old('last_name'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_lastname_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_lastname_error'] . "</span></div>";
                            unset($_SESSION['edit_lastname_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="nickname">Nickname</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="nickname" name="nickname" 
                        value="<?= edit_old('nickname'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_nickname_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_nickname_error'] . "</span></div>";
                            unset($_SESSION['edit_nickname_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label>Gender</label>
                    </div>
                    <div class="col75 radio">
                        <div>
                            <input type="radio" id="male" name="gender" value="male"
                            <?php
                                $value = edit_old('gender');
                                if($value == 'male')
                                {
                                    echo " checked";
                                }
                                else
                                {
                                    echo "";
                                }
                            ?>>
                            <label for="male">Male</label>
                        </div>
                        <div>
                            <input type="radio" id="female" name="gender" value="female" 
                            <?php
                                $value = edit_old('gender');
                                if($value == 'female')
                                {
                                    echo " checked";
                                }
                                else
                                {
                                    echo "";
                                }
                            ?>>
                            <label for="female">Female</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_gender_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_gender_error'] . "</span></div>";
                            unset($_SESSION['edit_gender_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="mobile_number">Mobile Number</label>
                    </div>
                    <div class="col75">
                        <input type="tel" id="mobile_number" name="mobile_number" 
                        value="<?= edit_old('mobile_number'); ?>" pattern="[0-9]{10}">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_mobile_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_mobile_error'] . "</span></div>";
                            unset($_SESSION['edit_mobile_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="landline_number">Landline Number</label>
                    </div>
                    <div class="col75">
                        <input type="tel" id="landline_number" name="landline_number" 
                        value="<?= edit_old('landline_number'); ?>" pattern="[0-9]{8}">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_landline_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_landline_error'] . "</span></div>";
                            unset($_SESSION['edit_landline_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="addr">Address</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="addr" name="addr" 
                        value="<?= edit_old('addr'); ?>" maxlength="500">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_address_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_address_error'] . "</span></div>";
                            unset($_SESSION['edit_address_error']);
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="relationship">Relationship</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="relationship" name="relationship" 
                        value="<?= edit_old('relationship'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?php
                        if(isset($_SESSION['edit_relationship_error']))
                        {
                            echo "<div><span class='red_font'>" . $_SESSION['edit_relationship_error'] . "</span></div>";
                            unset($_SESSION['edit_relationship_error']);
                        }
                    ?>
                </div>

                <?php
                    if(!empty($_SESSION['edit_form_data']['additional_fields']))
                    {
                        $counter = (int)array_key_last($_SESSION['edit_form_data']['additional_fields']);

                        $n = 1;

                        $html = <<< EOT
                        <div class="row">
                            <div class="col25">
                                <label>Edit Custom Fields</label>
                                <input type="hidden" id="custom_fields_present" name="custom_fields_present" value="1">
                                <input type="hidden" id="custom_fields_number" name="custom_fields_number" 
                                value="{$counter}">
                            </div>
                        </div>
EOT;
echo $html;

                        while($n <= $counter)
                        {
                            $fieldName = "fieldName$n";
                            $fieldValue = "fieldValue$n";


                            $inputFieldName = 
                            htmlspecialchars($_SESSION['edit_form_data']['additional_fields'][$n]['field_name']);
                            $inputFieldValue = 
                            htmlspecialchars($_SESSION['edit_form_data']['additional_fields'][$n]['field_value']);


                            if(!empty($_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error']))
                            {
                                $formNameError = 
                                $_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error'];
                                unset($_SESSION['edit_form_data']['additional_fields'][$n]['field_name_error']);
                            }

                            if(!empty($_SESSION['edit_form_data']['additional_fields'][$n]['field_value_error']))
                            {
                                $formValueError = 
                                $_SESSION['edit_form_data']['additional_fields'][$n]['field_value_error'];
                                unset($_SESSION['edit_form_data']['additional_fields'][$n]['field_value_error']);
                            }

                            if(isset($formNameError))
                            {
                                echo "<div class='row'>";
                                echo "<div><span class='red_font'>" . $formNameError . "</span></div>";
                                echo "</div>";
                            }

                            if(isset($formValueError))
                            {
                                echo "<div class='row'>";
                                echo "<div><span class='red_font'>" . $formValueError . "</span></div>";
                                echo "</div>";
                            }

                            $html = <<< EOT
                            <div class="row">
                                <div class="col25">
                                    <input type="text" id="$fieldName" name="$fieldName" 
                                    value="$inputFieldName" title="Field Name" required>
                                    </input>
                                </div>
                                <div class="col75">
                                    <input type="text" id="$fieldValue" name="$fieldValue" 
                                    value="$inputFieldValue" title="Field Value" required>
                                    </input>
                                </div>
                            </div>
EOT;
echo $html;

$n++;
                        }

                        unset($_SESSION['edit_form_data']['additional_fields']);
                    }
                ?>
                <input type="hidden" name="form_number" value="<?= edit_old('form_number'); ?>">

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <input type="submit" value="Edit">
                <input type="reset" value="Reset" form="editForm">
            </form>
        </div>
    </div>
</div>
</div>

<?php require_once '../app/Views/footer.php'; ?>

<?php
    unset($_SESSION['edit_form_data']);
?>
