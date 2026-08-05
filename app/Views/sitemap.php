<?php
require_once '../app/Views/sessionstart.php';

$css = ["css/sitemap.css"];

require_once '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Site Map</h1>

        <div id="map">
            <div id="user_loggedout">
                <h4><u>Logged Out User</u></h4>
                <ul>
                    <li><a href="home">Home</a></li>
                    <li><a href="docs">Docs</a></li>
                    <li><a href="feedback">Feedback</a></li>
                    <li><a href="sitemap">Site Map</a></li>
                    <li><a href="login">Login</a></li>
                    <li><a href="register">Register</a></li>
                </ul>
            </div>

            <div id="user_loggedin">
                <h4><u>Logged In User</u></h4>
                <ul>
                    <li><a href="home">Home</a></li>
                    <li><a href="docs">Docs</a></li>
                    <li><a href="feedback">Feedback</a></li>
                    <li><a href="sitemap">Site Map</a></li>
                    <li><a href="logout">Log Out</a></li>
                    <li><a href="dashboard">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once '../app/Views/footer.php'; ?>
