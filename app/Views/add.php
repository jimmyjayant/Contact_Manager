<?php
    require_once '../app/Views/sessionstart.php';

    $css = ["css/add.css"];

    function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    function add_old(string $inputFieldName)
    {
        if(isset($_SESSION['add_form_data']))
        {
            if(array_key_exists($inputFieldName, $_SESSION['add_form_data']))
            {
                $value = sanitize($_SESSION['add_form_data'][$inputFieldName]);
                return $value;
            }
        }
        else
        {
            if($inputFieldName == 'gender')
            {
                return "male";
            }
        }
    }

    $js = ["script/add.js"];

    require_once '../app/Views/headerandnavbar.php';

    // Block direct access to this webpage
    if(!isset($_SESSION['user_token']))
    {
        header("Location: login");
        exit();
    }
?>

<div class="content">
    <div class="intro">
        <h1>Add Contacts</h1>

        <div class="contact">
            <div id="add_contact">

                <?php
                    if(isset($_SESSION['add_contact_error']))
                    {
                        echo "<div class='center'><span class='red_font'>" . $_SESSION['add_contact_error'] . "</span></div>";
                        unset($_SESSION['add_contact_error']);
                    }
                    else if(isset($_SESSION['add_contact_success']))
                    {
                        echo "<div class='center'><span class='green_font'>" . $_SESSION['add_contact_success'] . "</span></div>";
                        unset($_SESSION['add_contact_success']);
                    }
                ?>

                <form method="post" action="add_user_contact" id="addForm">
                    <div class="row">
                        <div class="col25">
                            <label for="firstname">First Name*</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="firstname" name="firstname" value="<?= add_old('firstname'); ?>" maxlength="100" required>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['firstname_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['firstname_error'] . "</span></div>";
                                unset($_SESSION['firstname_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="middlename">Middle Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="middlename" name="middlename" value="<?= add_old('middlename'); ?>" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['middlename_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['middlename_error'] . "</span></div>";
                                unset($_SESSION['middlename_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="lastname">Last Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="lastname" name="lastname" value="<?= add_old('lastname'); ?>" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['lastname_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['lastname_error'] . "</span></div>";
                                unset($_SESSION['lastname_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="nickname">Nickname</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="nickname" name="nickname" value="<?= add_old('nickname'); ?>" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['nickname_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['nickname_error'] . "</span></div>";
                                unset($_SESSION['nickname_error']);
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
                                    $value = add_old('gender');
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
                                    $value = add_old('gender');
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
                            if(isset($_SESSION['gender_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['gender_error'] . "</span></div>";
                                unset($_SESSION['gender_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="mobnum">Mobile Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="mobnum" name="mobnum" value="<?= add_old('mobnum'); ?>" pattern="[0-9]{10}">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['mobile_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['mobile_error'] . "</span></div>";
                                unset($_SESSION['mobile_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="landnum">Landline Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="landnum" name="landnum" value="<?= add_old('landnum'); ?>" pattern="[0-9]{8}">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['landline_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['landline_error'] . "</span></div>";
                                unset($_SESSION['landline_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="address">Address</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="address" name="address" value="<?= add_old('address'); ?>" maxlength="500">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['address_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['address_error'] . "</span></div>";
                                unset($_SESSION['address_error']);
                            }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col25">
                            <label for="relationship">Relationship</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="relationship" name="relationship" value="<?= add_old('relationship'); ?>" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <?php
                            if(isset($_SESSION['relationship_error']))
                            {
                                echo "<div><span class='red_font'>" . $_SESSION['relationship_error'] . "</span></div>";
                                unset($_SESSION['relationship_error']);
                            }
                        ?>
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

<?php require_once '../app/Views/footer.php'; ?>
<?php 
    unset($_SESSION['add_form_data']); 
?>
