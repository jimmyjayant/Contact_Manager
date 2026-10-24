<?php
    requireFile('../app/Helpers/sanitize_input_helper.php');
    requireFile('../app/Helpers/showValidationError.php');
    requireFile('../app/Helpers/old.php');
    requireFile('../app/Filters/IsLoggedIn.php');

    $GLOBALS['css'] = ["css/add.css"];

    $GLOBALS['js'] = ["script/add.js"];

    requireFile('../app/Views/headerandnavbar.php');

    IsLoggedIn(false);
?>

<div class="content">
    <div class="intro">
        <h1>Add Contacts</h1>
        <span>Fields marked with * are required.</span>

        <div class="contact">
            <div id="add_contact">

                <?php
                    if(isset($_SESSION['add']['error']))
                    {
                        echo "<div class='error'>";
                        echo "<p>" . $_SESSION['add']['error'] . "</p></div>";
                        unset($_SESSION['add']['error']);
                    }
                    else if(isset($_SESSION['add']['success']))
                    {
                        echo "<div class='success'>";
                        echo "<p>" . $_SESSION['add']['success'] . "</p></div>";
                        unset($_SESSION['add']['success']);
                    }
                ?>

                <form method="post" action="add" id="addForm">
                    <div class="row">
                        <div class="col25">
                            <label for="firstname">First Name*</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="firstname" name="firstname" 
                            value="<?= old('add', 'firstname'); ?>" maxlength="100" required>
                            <br>
                            <span>Max 100 characters|Alphabets only</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'firstname'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="middlename">Middle Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="middlename" name="middlename" 
                            value="<?= old('add', 'middlename'); ?>" maxlength="100">
                            <br>
                            <span>Max 100 characters|Alphabets only</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'middlename'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="lastname">Last Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="lastname" name="lastname" 
                            value="<?= old('add', 'lastname'); ?>" maxlength="100">
                            <br>
                            <span>Max 100 characters|Alphabets only</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'lastname'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="nickname">Nickname</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="nickname" name="nickname" 
                            value="<?= old('add', 'nickname'); ?>" maxlength="100">
                            <br>
                            <span>Max 100 characters|Alphabets only</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'nickname'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label>Gender</label>
                        </div>
                        <div class="col75 radio">
                            <div>
                                <input type="radio" id="male" name="gender" value="male" 
                                <?php 
                                    $value = old('add', 'gender');
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
                                    $value = old('add', 'gender');
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
                        <?= showValidationError('add', 'gender'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="mobile">Mobile Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="mobile" name="mobile" 
                            value="<?= old('add', 'mobile'); ?>" pattern="[0-9]{10}">
                            <br>
                            <span>Exact 10 digits|Omit +91</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'mobile'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="landline">Landline Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="landline" name="landline" 
                            value="<?= old('add', 'landline'); ?>" pattern="[0-9]{8}">
                            <br>
                            <span>Exact 8 digits</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'landline'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="address">Address</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="address" name="address" 
                            value="<?= old('add', 'address'); ?>" maxlength="500">
                            <br>
                            <span>Max 500 characters</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'address'); ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="relationship">Relationship</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="relationship" name="relationship" 
                            value="<?= old('add', 'relationship'); ?>" maxlength="100">
                            <br>
                            <span>Max 100 characters</span>
                        </div>
                    </div>

                    <div class="row">
                        <?= showValidationError('add', 'relationship'); ?>
                    </div>

                    <div class="row" id="add_custom_fields_div">
                        <div class="col25">
                            <label for="add_custom_fields">Add Custom Fields</label>
                        </div>
                        <div class="col75">
                            <button type="button" id="add_custom_fields">+</button>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" id="custom_fields_present" name="custom_fields_present" value="0">
                        <input type="hidden" id="custom_fields_number" name="custom_fields_number" value="0">
                    </div>

                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="submit" value="Add">
                    <input type="reset" value="Reset" form="addForm">
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
<?php unset($_SESSION['add']['formData']); ?>
