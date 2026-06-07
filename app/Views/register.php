<?php
require '../app/Views/sessionstart.php';
$css = "css/register.css";
require '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>SignUp</h1>

        <form method="post" action="register_user_data">
            <div class="row">
                <div class="col25">
                    <label for="fname">First Name</label>
                </div>
                <div class="col25">
                    <input type="text" id="fname" placeholder="Enter your First Name" required>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="lname">Last Name</label>
                </div>
                <div class="col25">
                    <input type="text" id="lname" placeholder="Enter your Last Name" required>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="email">Email Address</label>
                </div>
                <div class="col25">
                    <input type="email" id="email" placeholder="Enter Your Email" required>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="pass">Password</label>
                </div>
                <div class="col25">
                    <input type="password" id="pass" placeholder="Enter your password" required>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="contact">Contact</label>
                </div>
                <div class="col25">
                    <input type="number" id="contact" placeholder="Enter Your contact number" required>
                </div>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>