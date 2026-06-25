<?php
require '../app/Views/sessionstart.php';
$css = "css/dashboard.css";
$showAddContactDiv = 0;
//print_r($_SESSION);

foreach($_SESSION as $key => $value)
{
    if(preg_match("/error/i", $key) || preg_match("/success/i", $key))
    {
        if(isset($value))
        {
            $showAddContactDiv = 1;
        }
    }
}

if(isset($_SESSION['form_data']))
{
    print_r($_SESSION['form_data']);
}

function old(string $inputFieldName)
{
    if(isset($_SESSION['form_data']))
    {
        if(array_key_exists($inputFieldName, $_SESSION['form_data']))
        {
            $value = $_SESSION['form_data'][$inputFieldName];
            unset($_SESSION['form_data'][$inputFieldName]);
            return $value;
        }
    }
    else
    {
        if($inputFieldName == 'gender')
        {
            return "male";
        }
        else
        {
            return "";
        }
    }
}


$js = "script/dashboard.js";
require '../app/Views/headerandnavbar.php';

if($showAddContactDiv == 1)
{
    //echo "Match Found!";
    echo "<script>var display_add_contact_div = 1;</script>";
}
else
{
    //echo "Not Found!";
    echo "<script>var display_add_contact_div = 0;</script>";
}
//$errorFound = null;
// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}
?>

<div class="content">
    <div class="intro">
        <h1>Dashboard</h1>

        <div class="contact">
            <div id="searchdiv">
                <div id="firstchild">
                    <input type="text" name="searchtext">
                    <button type="button" id="search">Search</button>
                </div>

                <div id="secondchild">
                    <button type="button" id="add">Add</button>
                    <button type="button" id="filter">Filter</button>
                </div>                
            </div>

            <div id="add_contact" class="hide">
                <div id="cross_div"><button type="button" id="cross_button">X</button></div>
                <h4>Add Contacts</h4>

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

                <form method="post" action="add_user_contact">
                    <div class="row">
                        <div class="col25">
                            <label for="firstname">First Name*</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="firstname" name="firstname" value="<?= old('firstname'); ?>" maxlength="100" required>
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
                            <input type="text" id="middlename" name="middlename" value="<?= old('middlename'); ?>" maxlength="100">
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
                            <input type="text" id="lastname" name="lastname" value="<?= old('lastname'); ?>" maxlength="100">
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
                            <input type="text" id="nickname" name="nickname" value="<?= old('nickname'); ?>" maxlength="100">
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
                                    $value = old('gender');
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
                                    $value = old('gender');
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
                            <input type="tel" id="mobnum" name="mobnum" value="<?= old('mobnum'); ?>" pattern="[0-9]{10}">
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
                            <input type="tel" id="landnum" name="landnum" value="<?= old('landnum'); ?>">
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
                            <input type="text" id="address" name="address" value="<?= old('address'); ?>" maxlength="500">
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
                            <input type="text" id="relationship" name="relationship" value="<?= old('relationship'); ?>" maxlength="100">
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

                    <input type="submit" value="Add">
                    <input type="reset" value="Reset">
                </form>
            </div>

            <div id="filter_contact"></div>

            <div id="contact_data">
                <div id="result"></div>
                <div id="pagination">
                    <button type="button" id="previous_page">&lt;</button>
                    <input type="number" id="page_number" min="1" step="1" value="1">
                    <button type="button" id="next_page">&gt;</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>
<?php unset($_SESSION['form_data']); ?>
