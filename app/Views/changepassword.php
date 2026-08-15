<?php
requireFile('../app/Views/sessionstart.php');

$css = ["css/changepassword.css"];

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
        <h1>Change Password</h1>

        <?php
            if(isset($_SESSION['change_password_error']))
            {
                echo "<div class='center'><span class='red_font'>" . $_SESSION['change_password_error'] . "</span></div>";
                unset($_SESSION['change_password_error']);
            }
            else if(isset($_SESSION['change_password_success']))
            {
                echo "<div class='center'><span class='green_font'>" . $_SESSION['change_password_success'] . "</span></div>";
                unset($_SESSION['change_password_success']);
            }
        ?>

        <form method="post" action="change_user_password">
            <div class="row">
                <div class="col25"><label for="oldpass">Old Password</label></div>
                <div class="col75">
                    <input type="password" id="oldpass" name="oldpass" minlength="6" maxlength="12" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['oldpass_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['oldpass_error'] . "</span></div>";
                        unset($_SESSION['oldpass_error']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25"><label for="newpass">New Password</label></div>
                <div class="col75">
                    <input type="password" id="newpass" name="newpass" minlength="6" maxlength="12" required>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['newpass_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['newpass_error'] . "</span></div>";
                        unset($_SESSION['newpass_error']);
                    }
                ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>

    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
