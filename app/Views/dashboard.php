<?php
require '../app/Views/sessionstart.php';

$css = ["css/dashboard.css"];

//$js = ["script/dashboard.js"];

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
        <h1>Dashboard</h1>

        <div class="contact">
            <div>
                <img src="images/contacts.png" alt="Show Contacts">
                <br>
                <a href="show" target="_self">Show Contacts</a>
            </div>

            <div>
                <img src="images/add.png" alt="Add Contacts">
                <br>
                <a href="add" target="_self">Add Contacts</a>
            </div>
<!--
            <div>
                <img src="images/edit.png" alt="Edit Contacts">
                <br>
                <a href="edit" target="_self">Edit Contacts</a>
            </div>
-->
            <div>
                <img src="images/filter.png" alt="Filter Contacts">
                <br>
                <a href="filter" target="_self">Filter Contacts</a>
            </div>

            <div>
                <img src="images/search.png" alt="Search Contacts">
                <br>
                <a href="search" target="_self">Search Contacts</a>
            </div>
        </div>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>
