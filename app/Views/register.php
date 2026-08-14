<?php
require_once '../app/Views/sessionstart.php';

$css = ["css/register.css"];

require_once '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>SignUp</h1>

        <?php
            if(isset($_SESSION['registration_error']))
            {
                echo "<div class='center'><span class='red_font'>" . $_SESSION['registration_error'] . "</span></div>";
                unset($_SESSION['registration_error']);
            }
        ?>

        <form method="post" action="register_user_data">
            <div class="row">
                <div class="col25">
                    <label for="fname">First Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="fname" name="fname" maxlength="100" placeholder="Enter your First Name" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['fname_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['fname_error'] . "</span></div>";
                        unset($_SESSION['fname_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="lname">Last Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="lname" name="lname" maxlength="100" placeholder="Enter your Last Name" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['lname_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['lname_error'] . "</span></div>";
                        unset($_SESSION['lname_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="email">Email Address</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['email_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['email_error'] . "</span></div>";
                        unset($_SESSION['email_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="pass">Password</label>
                </div>
                <div class="col75">
                    <input type="password" id="pass" name="pass" minlength="6" maxlength="12" placeholder="Enter your password" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['pass_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['pass_error'] . "</span></div>";
                        unset($_SESSION['pass_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="contact">Contact</label>
                </div>
                <div class="col75">
                    <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" placeholder="Enter Your contact number" required>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['contact_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['contact_error'] . "</span></div>";
                        unset($_SESSION['contact_error']);
                    }
                ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require_once '../app/Views/footer.php'; ?>
