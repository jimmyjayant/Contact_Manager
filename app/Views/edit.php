<?php
require '../app/Views/sessionstart.php';

$css = ["css/edit.css"];

$js = ["script/edit.js"];

require '../app/Views/headerandnavbar.php';

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
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

            <form method="post" action="edit_user_contact">
                <div class="row">
                    <div class="col25">
                        <label for="edit_firstname">First Name*</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="edit_firstname" name="edit_firstname" 
                        value="<?php
                            if(isset($_SESSION['form_data']['first_name']))
                            {
                                echo $_SESSION['form_data']['first_name'];
                                unset($_SESSION['form_data']['first_name']);
                            }
                        ?>" 
                        maxlength="100" required>
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
                        <label for="edit_middlename">Middle Name</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="edit_middlename" name="edit_middlename" 
                        value="<?php
                            if(isset($_SESSION['form_data']['middle_name']))
                            {
                                echo $_SESSION['form_data']['middle_name'];
                                unset($_SESSION['form_data']['middle_name']);
                            }
                        ?>" 
                        maxlength="100">
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
                        <label for="edit_lastname">Last Name</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="edit_lastname" name="edit_lastname" 
                        value="<?php
                            if(isset($_SESSION['form_data']['last_name']))
                            {
                                echo $_SESSION['form_data']['last_name'];
                                unset($_SESSION['form_data']['last_name']);
                            }
                        ?>" 
                        maxlength="100">
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
                        <label for="edit_nickname">Nickname</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="edit_nickname" name="edit_nickname" 
                        value="<?php
                            if(isset($_SESSION['form_data']['nickname']))
                            {
                                echo $_SESSION['form_data']['nickname'];
                                unset($_SESSION['form_data']['nickname']);
                            }
                        ?>" 
                        maxlength="100">
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
                            <input type="radio" id="edit_male" name="edit_gender" value="male"
                            <?php
                                if(isset($_SESSION['form_data']['gender']) && 
                                    $_SESSION['form_data']['gender'] == 'male')
                                {
                                    echo " checked";
                                    unset($_SESSION['form_data']['gender']);
                                }
                            ?>
                            >
                            <label for="edit_male">Male</label>
                        </div>
                        <div>
                            <input type="radio" id="edit_female" name="edit_gender" value="female"
                            <?php
                                if(isset($_SESSION['form_data']['gender']) && 
                                    $_SESSION['form_data']['gender'] == 'female')
                                {
                                    echo " checked";
                                    unset($_SESSION['form_data']['gender']);
                                }
                            ?>
                            >
                            <label for="edit_female">Female</label>
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
                        <label for="edit_mobnum">Mobile Number</label>
                    </div>
                    <div class="col75">
                        <input type="tel" id="edit_mobnum" name="edit_mobnum" 
                        value="<?php
                            if(isset($_SESSION['form_data']['mobile_number']))
                            {
                                echo $_SESSION['form_data']['mobile_number'];
                                unset($_SESSION['form_data']['mobile_number']);
                            }
                        ?>" 
                        pattern="[0-9]{10}">
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
                        <label for="edit_landnum">Landline Number</label>
                    </div>
                    <div class="col75">
                        <input type="tel" id="edit_landnum" name="edit_landnum" 
                        value="<?php
                            if(isset($_SESSION['form_data']['landline_number']))
                            {
                                echo $_SESSION['form_data']['landline_number'];
                                unset($_SESSION['form_data']['landline_number']);
                            }
                        ?>" 
                        pattern="[0-9]{8}">
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
                        <label for="edit_address">Address</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="edit_address" name="edit_address" 
                        value="<?php
                            if(isset($_SESSION['form_data']['addr']))
                            {
                                echo $_SESSION['form_data']['addr'];
                                unset($_SESSION['form_data']['addr']);
                            }
                        ?>" 
                        maxlength="500">
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
                        <label for="edit_relationship">Relationship</label>
                    </div>
                    <div class="col75">
                        <input type="text" id="edit_relationship" name="edit_relationship" 
                        value="<?php
                            if(isset($_SESSION['form_data']['relationship']))
                            {
                                echo $_SESSION['form_data']['relationship'];
                                unset($_SESSION['form_data']['relationship']);
                            }
                        ?>" 
                        maxlength="100">
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
                    if(/*array_key_exists('1', $_SESSION['additional_fields'])*/
                        !empty($_SESSION['additional_fields']))
                    {

                        $counter = (int)array_key_last($_SESSION['additional_fields']);
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
                            $html = <<< EOT
                            <div class="row">
                                <div class="col25">
                                    <input type="text" id="fieldName$n" name="fieldName$n" 
                                    value="{$_SESSION['additional_fields'][$n]['field_name']}"
                                    title="Field Name">
                                    </input>
                                </div>
                                <div class="col75">
                                    <input type="text" id="fieldValue$n" name="fieldValue$n" 
                                    value="{$_SESSION['additional_fields'][$n]['field_value']}"
                                    title="Field Value">
                                    </input>
                                </div>
                            </div>
EOT;
echo $html;
$n++;
                        }

                        unset($_SESSION['additional_fields']);
                    }
?>
                <input type="hidden" name="edit_form_number" 
                value="<?php 
                        if(isset($_SESSION['form_data']['form_number']))
                        {
                            echo $_SESSION['form_data']['form_number'];
                            unset($_SESSION['form_data']['form_number']);
                        }
                      ?>">

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <input type="submit" value="Edit">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>
