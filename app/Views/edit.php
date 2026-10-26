<?php
requireFile('../app/Helpers/sanitize_input_helper.php');
requireFile("../app/Filters/validationFilters.php");
requireFile('../app/Helpers/showValidationError.php');
requireFile('../app/Helpers/old.php');

$GLOBALS['css'] = ["css/edit.css"];

$GLOBALS['js'] = ["script/edit.js"];

requireFile('../app/Views/headerandnavbar.php');

requireFile('../app/Filters/IsLoggedIn.php');

IsLoggedIn(false);

if(empty($_SESSION['edit']['formData']))
{
    header("Location: show");
    exit();
}
?>

<div class="content">
    <div class="intro">
        <h1>Edit Contact</h1>

        <div id="edit_contact">
            <?php
                if(isset($_SESSION['edit']['error']))
                {
                    echo "<div class='error'>";
                    echo "<p>" . $_SESSION['edit']['error'] . "</p></div>";
                    unset($_SESSION['edit']['error']);
                }
                else if(isset($_SESSION['edit']['success']))
                {
                    echo "<div class='success'>";
                    echo "<p>" . $_SESSION['edit']['success'] . "</p></div>";
                    unset($_SESSION['edit']['success']);
                }
            ?>

            <form method="post" action="edit" id="editForm">
                <div class="row">
                    <div class="col25">
                        <label for="firstname">First Name*</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="firstname" name="firstname" 
                        value="<?= old('edit', 'firstname'); ?>" maxlength="100" required>
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'firstname'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="middlename">Middle Name</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="middlename" name="middlename" 
                        value="<?= old('edit', 'middlename'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'middlename'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="lastname">Last Name</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="lastname" name="lastname" 
                        value="<?= old('edit', 'lastname'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'lastname'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="nickname">Nickname</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="nickname" name="nickname" 
                        value="<?= old('edit', 'nickname'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'nickname'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label>Gender</label>
                    </div>
                    <div class="col75 radio">
                        <div>
                            <input type="radio" id="male" name="gender" value="male"
                            <?php
                                $value = old('edit', 'gender');
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
                                $value = old('edit', 'gender');
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
                    <?= showValidationError('edit', 'gender'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="mobile">Mobile Number</label>
                    </div>
                    <div class="col75">
                        <input type="tel" id="mobile" name="mobile" 
                        value="<?= old('edit', 'mobile'); ?>" pattern="[0-9]{10}">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'mobile'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="landline">Landline Number</label>
                    </div>
                    <div class="col75">
                        <input type="tel" id="landline" name="landline" 
                        value="<?= old('edit', 'landline'); ?>" pattern="[0-9]{8}">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'landline'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="address">Address</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="address" name="address" 
                        value="<?= old('edit', 'address'); ?>" maxlength="500">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'address'); ?>
                </div>

                <div class="row">
                    <div class="col25">
                        <label for="relationship">Relationship</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="relationship" name="relationship" 
                        value="<?= old('edit', 'relationship'); ?>" maxlength="100">
                    </div>
                </div>

                <div class="row">
                    <?= showValidationError('edit', 'relationship'); ?>
                </div>

                <?php
                    if(!empty($_SESSION['edit']['formData']['custom_fields_number']))
                    {
                        // $n depicts the number of pairs of custom fields present
                        $n = $_SESSION['edit']['formData']['custom_fields_number'];

                        $html = <<< EOT
                        <div class="row">
                            <div class="col25">
                                <label>Edit Custom Fields</label>
                                <input type="hidden" id="custom_fields_present" name="custom_fields_present" value="1">
                                <input type="hidden" id="custom_fields_number" name="custom_fields_number" 
                                value="{$n}">
                            </div>
                        </div>
EOT;
echo $html;

                        for($i = 1, $j = 1; $i <= ($n*2), $j <= $n; $i+=2, $j++)
                        {
                            echo "<div class='row'>";
                            echo "<div class='dropCustomElement'><span title='Remove the custom field'>X</span></div>";
                        
                            $fieldName = 'fieldName' . $j;
                            $fieldValue = $_SESSION['edit']['formData'][$fieldName];
                            $customFieldName = 'customInputElement' . $i;
                            $customFieldValue = 
                            $_SESSION['edit']['formData'][$customFieldName];

                            $customInputElement = <<< EOT
                            <div class="col25">
                                <input type="hidden" name="$fieldName" value="$fieldValue">
                                <input type="text" name="{$customFieldName}" maxlength="100" 
                                placeholder="Enter field name here" required value="{$customFieldValue}">
                            </div>
EOT;
echo $customInputElement;

                            // Show custom input field validation error 
                            echo showValidationError('edit', $customFieldName);

                            $customFieldName = 'customInputElement' . $i+1;
                            $customFieldValue = 
                            $_SESSION['edit']['formData'][$customFieldName];

                            $customInputElement = <<< EOT
                            <div class="col75">
                                <input type="text" name="{$customFieldName}" maxlength="500" 
                                placeholder="Enter field value here" required value="{$customFieldValue}">
                            </div>
EOT;
echo $customInputElement; 

                            // Show custom input field validation error 
                            echo showValidationError('edit', $customFieldName);

                            echo "</div>";
                        }  
                    }
                ?>
                <input type="hidden" name="form_number" value="<?= old('edit', 'form_number') ?? '0'; ?>">

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <input type="submit" value="Edit">
                <input type="reset" value="Reset" form="editForm">
            </form>
        </div>
    </div>
</div>
</div>

<script src="script/dropCustomElement.js"></script>

<?php requireFile('../app/Views/footer.php'); ?>
<?php unset($_SESSION['edit']['formData']); ?>
