<?php
requireFile('../app/Helpers/sanitize_input_helper.php');
requireFile('../app/Helpers/showValidationError.php');
requireFile('../app/Helpers/old.php');

$GLOBALS['css'] = ["css/login.css"];

requireFile('../app/Views/headerandnavbar.php');
?>

<div class="content">
    <div class="intro">
        <h1>Login</h1>
        <span>Fields marked with * are required.</span>

        <?php
            if(!empty($_SESSION['login']['error']))
            {
                echo "<div class='error'>";
                echo "<p>" . $_SESSION['login']['error'] . "</p>";
                echo "</div>";
                unset($_SESSION['login']['error']);
            }
        ?>

        <form method="post" action="login">
            <div class="row">
                <div class="col25"><label for="email">Email*</label></div>
                <div class="col75">
                    <input type="email" id="email" name="email" required 
                    value="<?= old('login', 'email'); ?>"  maxlength="100">
                    <br>
                    <span>Max 100 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('login', 'email'); ?>
            </div>

            <div class="row">
                <div class="col25"><label for="password">Password*</label></div>
                <div class="col75">
                    <input type="password" id="password" name="password" minlength="6" maxlength="12" required>
                    <br>
                    <span>Min 6 characters|Max 12 characters</span>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?= showValidationError('login', 'password'); ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
<?php unset($_SESSION['login']['formData']); ?>
