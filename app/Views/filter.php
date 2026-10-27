<?php
// requireFile('../app/Views/sessionstart.php');

$GLOBALS['css'] = ["css/filter.css", "css/table.css"];

$GLOBALS['js'] = ["script/filter.js"];

requireFile('../app/Views/headerandnavbar.php');

requireFile('../app/Filters/IsLoggedIn.php');

IsLoggedIn(true);
?>

<div class="content">
    <div class="intro">
        <h1>Filter Contacts</h1>

        <div class="contact">
            <!-- Filter Contacts -->
            <div id="filter_contact">

                <div id="filter_contact_error" class="error"></div>
                <div id="filter_contact_success" class="success"></div>

                <form id="filter_form">
                    <div class="row">
                        <div class="col25">
                            <label for="firstname">First Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="firstname" name="firstname" maxlength="100">
                        </div>
                    </div>

                   <div id="firstname_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="middlename">Middle Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="middlename" name="middlename" maxlength="100">
                        </div>
                    </div>

                    <div id="middlename_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="lastname">Last Name</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="lastname" name="lastname" maxlength="100">
                        </div>
                    </div>

                    <div id="lastname_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="nickname">Nickname</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="nickname" name="nickname" maxlength="100">
                        </div>
                    </div>

                    <div id="nickname_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label>Gender</label>
                        </div>
                        <div class="col75 radio">
                            <div>
                                <input type="radio" id="male" name="gender" value="male" checked>
                                <label for="male">Male</label>
                            </div>
                            <div>
                                <input type="radio" id="female" name="gender" value="female">
                                <label for="female">Female</label>
                            </div>
                        </div>
                    </div>

                    <div id="gender_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="mobile">Mobile Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}">
                        </div>
                    </div>

                    <div id="mobile_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="landline">Landline Number</label>
                        </div>
                        <div class="col75">
                            <input type="tel" id="landline" name="landline" pattern="[0-9]{8}">
                        </div>
                    </div>

                    <div id="landline_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="address">Address</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="address" name="address" maxlength="500">
                        </div>
                    </div>

                    <div id="address_error" class="row error"></div>

                    <div class="row">
                        <div class="col25">
                            <label for="relationship">Relationship</label>
                        </div>
                        <div class="col75">
                            <input type="text" id="relationship" name="relationship" maxlength="100">
                        </div>
                    </div>

                    <div id="relationship_error" class="row error"></div>

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
                <div id="result">
                    <div id="table_with_contacts" class="hide">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan='2'>Action</th>
                                    <th>Serial Number</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Nickname</th>
                                    <th>Gender</th>
                                    <th>Mobile Number</th>
                                    <th>Landline Number</th>
                                    <th>Address</th>
                                    <th>Relationship</th>
                                    <th>Created At</th>
                                    <th>Additional Fields</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div id="additional_fields_table" class="hide">
                        <div><button id="close_additional_fields_table">X</button></div>
                        <table>
                            <thead>
                                <th colspan=2>Additional Fields Table</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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
