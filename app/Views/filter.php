<?php
requireFile('../app/Views/sessionstart.php');

$css = ["css/filter.css", "css/table.css"];

$js = ["script/filter.js"];

requireFile('../app/Views/headerandnavbar.php');

// Block direct access to this webpage
if(!isset($_SESSION['user_token']))
{
    header("Location: login");
    exit();
}
?>

<div class="content">
    <div class="intro">
        <h1>Filter Contacts</h1>

        <div class="contact">
            <!-- Filter Contacts -->
            <div id="filter_contact">

                <div id="filter_contact_error" class="center red"></div>
                <div id="filter_contact_success" class="center green"></div>

                <form id="filter_form">
                    <div class="row">
                        <div class="col25">
                            <label for="filter_firstname">First Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="filter_firstname" name="filter_firstname" maxlength="100">
                        </div>
                    </div>

                   <!-- <div id="filter_firstname_error" class="row"></div> -->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_middlename">Middle Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="filter_middlename" name="filter_middlename" maxlength="100">
                        </div>
                    </div>

                    <!--<div id="filter_middlename_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_lastname">Last Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="filter_lastname" name="filter_lastname" maxlength="100">
                        </div>
                    </div>

                    <!--<div id="filter_lastname_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_nickname">Nickname</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="filter_nickname" name="filter_nickname" maxlength="100">
                        </div>
                    </div>

                    <!--<div id="filter_nickname_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label>Gender</label>
                        </div>
                        <div class="col75 radio">
                            <div>
                                <input type="radio" id="filter_male" name="filter_gender" value="male" checked>
                                <label for="filter_male">Male</label>
                            </div>
                            <div>
                                <input type="radio" id="filter_female" name="filter_gender" value="female">
                                <label for="filter_female">Female</label>
                            </div>
                        </div>
                    </div>

                    <!--<div id="filter_gender_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_mobnum">Mobile Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="filter_mobnum" name="filter_mobnum" pattern="[0-9]{10}">
                        </div>
                    </div>

                    <!--<div id="filter_mobnum_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_landnum">Landline Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="filter_landnum" name="filter_landnum" pattern="[0-9]{8}">
                        </div>
                    </div>

                    <!--<div id="filter_landnum_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_address">Address</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="filter_address" name="filter_address" maxlength="500">
                        </div>
                    </div>

                    <!--<div id="filter_address_error" class="row"></div>-->

                    <div class="row">
                        <div class="col25">
                            <label for="filter_relationship">Relationship</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="filter_relationship" name="filter_relationship" maxlength="100">
                        </div>
                    </div>

                    <!--<div id="filter_relationship_error" class="row"></div>-->

                    <!--
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
                    -->

                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="submit" value="Filter" id="filter_submit_button">
                    <input type="reset" value="Reset" id="filter_reset_button">
                </form>
            </div>

            <div id="contact_data" class="hide">
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

<?php requireFile('../app/Views/footer.php'); ?>
