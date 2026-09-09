<?php
requireFile('../app/Views/sessionstart.php');
requireFile('../app/Filters/IsLoggedIn.php');

IsLoggedIn(true);

$GLOBALS['css'] = ["css/logout.css"];
$GLOBALS['js'] = ["script/logout.js"];

requireFile('../app/Views/headerandnavbar.php');
?>

<div class="content">
    <div class="intro">
        <h1>Logout</h1>

        <div id="status">
            Logging Out, Please wait.....
        </div>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
