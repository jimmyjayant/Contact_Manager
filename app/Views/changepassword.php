<?php
requireFile('../app/Views/sessionstart.php');
requireFile('../app/Helpers/sanitize_input_helper.php');
requireFile('../app/Helpers/showValidationError.php');

$GLOBALS['css'] = ["css/changepassword.css"];

requireFile('../app/Views/headerandnavbar.php');

requireFile('../app/Filters/IsLoggedIn.php');

IsLoggedIn(false);
?>

<div class="content">
    <div class="intro">
        <h1>Change Password</h1>
        <span>Fields marked with * are required.</span>

        <?php
            if(!empty($_SESSION['changepassword']['error']))
            {
                echo "<div class='error'>";
                echo "<p>" . $_SESSION['changepassword']['error'] . "</p></div>";
                unset($_SESSION['changepassword']['error']);
            }
            else if(isset($_SESSION['changepassword']['success']))
            {
                echo "<div class='success'>";
                echo "<p>" . $_SESSION['changepassword']['success'] . "</p></div>";
                unset($_SESSION['changepassword']['success']);
            }
        ?>

        <form method="post" action="change">
            <div class="row">
                <div class="col25"><label for="oldpass">Old Password*</label></div>
                <div class="col75">
                    <input type="password" id="oldpass" name="oldpass" minlength="6" maxlength="12" required>
                    <br>
                    <span>Min 6 characters|Max 12 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('change', 'oldpass'); ?>
            </div>

            <div class="row">
                <div class="col25"><label for="newpass">New Password*</label></div>
                <div class="col75">
                    <input type="password" id="newpass" name="newpass" minlength="6" maxlength="12" required>
                    <br>
                    <span>Min 6 characters|Max 12 characters</span>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?= showValidationError('change', 'newpass'); ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>

    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
