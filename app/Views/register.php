<?php
require '../app/Views/sessionstart.php';
$css = "css/register.css";
require '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>SignUp</h1>

        <?php
            if(isset($_SESSION['registration_error']))
            {
                echo "<div><span style='color:red;'>" . $_SESSION['registration_error'] . "</span></div>";
                $_SESSION['registration_error'] = NULL;
            }
        ?>

        <form method="post" action="register_user_data">
            <div class="row">
                <div class="col25">
                    <label for="fname">First Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="fname" name="fname" placeholder="Enter your First Name" required>
                    <?php
                        if(isset($_SESSION['fname_error']))
                        {
                            echo "<div><span style='color:red;'>" . $_SESSION['fname_error'] . "</span></div>";
                            //echo "<script>console.log('{$_SESSION['fname_error']}');</script>";
                            $_SESSION['fname_error'] = NULL;
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="lname">Last Name</label>
                </div>
                <div class="col75">
                    <input type="text" id="lname" name="lname" placeholder="Enter your Last Name" required>
                    <?php
                        if(isset($_SESSION['lname_error']))
                        {
                            echo "<div><span style='color:red;'>" . $_SESSION['lname_error'] . "</span></div>";
                            $_SESSION['fname_error'] = NULL;
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="email">Email Address</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
                    <?php
                        if(isset($_SESSION['email_error']))
                        {
                            echo "<div><span style='color:red;'>" . $_SESSION['email_error'] . "</span></div>";
                            $_SESSION['fname_error'] = NULL;
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="pass">Password</label>
                </div>
                <div class="col75">
                    <input type="password" id="pass" name="pass" minlength="6" maxlength="12" placeholder="Enter your password" required>
                    <?php
                        if(isset($_SESSION['pass_error']))
                        {
                            echo "<div><span style='color:red;'>" . $_SESSION['pass_error'] . "</span></div>";
                            $_SESSION['fname_error'] = NULL;
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col25">
                    <label for="contact">Contact</label>
                </div>
                <div class="col75">
                    <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" placeholder="Enter Your contact number" required>
                    <?php
                        if(isset($_SESSION['contact_error']))
                        {
                            echo "<div><span style='color:red;'>" . $_SESSION['contact_error'] . "</span></div>";
                            $_SESSION['fname_error'] = NULL;
                        }
                    ?>
                </div>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>
