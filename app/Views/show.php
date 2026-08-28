<?php
requireFile('../app/Views/sessionstart.php');

$GLOBALS['css'] = ["css/show.css", "css/table.css"];

$GLOBALS['js'] = ["script/show.js"];

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
        <h1>Show Contacts</h1>

        <div id="total_contacts"></div>

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

<?php requireFile('../app/Views/footer.php'); ?>
