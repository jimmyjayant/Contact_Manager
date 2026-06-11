<!DOCTYPE HTML>
<html lang="en-IN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Jimmy Jayant">
        <meta name="keywords" content="contacts, manage contacts, store contacts">
        <meta name="description" content="Contact Manager is an online platform that lets you store your contact information in the way you want.">
        <title>Contact Manager</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/footer.css">
        <script src="script/script.js"></script>
        <?php
            if(isset($css))
            {
                echo "<link rel='stylesheet' href='{$css}'>";
            }
        ?>
        <link rel="icon" href="images/favicon.ico">
    </head>
    <body>
        <div class="main">
            <div class="header">
                <div id="hambergurmenu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

                <div class="sitelogo">
                    <a href="index" target="_self">
                        <img src="images/contact_mng.png" alt="Site Logo">
                    </a>
                </div>

                <div class="heading">Contact Manager</div>
                
                <div class="login">
                    <div class="user">
                        <div class="head"></div>
                        <div class="body"></div>
                    </div>

                    <div class="userstatus">
                        <?php 
                            if(!isset($_SESSION['user_token']))
                            {
                                echo "<a href='login' alt='Login'>Login</a>";
                                echo "<a href='register' alt='Register'>Signup</a>";
                            }
                            else
                            {
                                echo "<a alt='Current User'>Hi! {$_SESSION['username']}</a>";
                                echo "<a href='dashboard' alt='User Dashboard'>Dashboard</a>";
                                echo "<a href='changepassword' alt='Change Password'>Change Password</a>";
                                echo "<a href='logout' alt='Logout' style='cursor:pointer;'>Logout</a>";
                            }
                        ?>                            
                    </div>
                </div>
            </div>

            <div id="navbar">
                <a href="#"><span id="closebutton">X</span></a>
                <a href="index" target="_self">Home</a>
                <?php
                    if(isset($_SESSION['user_token']))
                    {
                        echo "<a href='dashboard' target='_self'>Dashboard</a>";
                    }
                ?>
                <a href="docs" target="_self">Docs</a>
                <a href="feedback" target="_self">Feedback</a>
                <a href="sitemap" target="_self">Site Map</a>
            </div>
