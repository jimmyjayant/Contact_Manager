<?php
requireFile('../app/Helpers/sanitize_input_helper.php');
requireFile('../app/Helpers/showValidationError.php');
requireFile('../app/Helpers/old.php');

$GLOBALS['css'] = ["css/register.css"];

requireFile('../app/Views/headerandnavbar.php');
?>

<div class="content">
    <div class="intro">
        <h1>SignUp</h1>
        <span>Fields marked with * are required.</span>

        <?php
            if(!empty($_SESSION['register']['error']))
            {
                echo "<div class='error'><p>";
                echo $_SESSION['register']['error'];
                echo "</p></div>";
                unset($_SESSION['register']['error']);
            }
        ?>

        <form method="post" action="register">
            <div class="row">
                <div class="col25">
                    <label for="firstname">First Name*</label>
                </div>
                <div class="col75">
                    <input type="text" id="firstname" name="firstname" maxlength="100" 
                    placeholder="Enter your First Name" required
                    value="<?= old('register', 'firstname'); ?>">
                    <br>
                    <span>Max 100 characters|Alphabets only</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('register', 'firstname'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="lastname">Last Name*</label>
                </div>
                <div class="col75">
                    <input type="text" id="lastname" name="lastname" maxlength="100" 
                    placeholder="Enter your Last Name" required 
                    value="<?= old('register', 'lastname'); ?>">
                    <br>
                    <span>Max 100 characters|Alphabets only</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('register', 'lastname'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="email">Email Address*</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" name="email" placeholder="Enter Your Email" required 
                    value="<?= old('register', 'email'); ?>" maxlength="100">
                    <br>
                    <span>Max 100 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('register', 'email'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="password">Password*</label>
                </div>
                <div class="col75">
                    <input type="password" id="password" name="password" minlength="6" maxlength="12" 
                    placeholder="Enter your password" required>
                    <br>
                    <span>Min 6 characters|Max 12 characters</span>
                </div>
            </div>

            <div class="row">
                <?= showValidationError('register', 'password'); ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="mobile">Contact</label>
                </div>
                <div class="col75">
                    <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" 
                    placeholder="Enter Your mobile number" required 
                    value="<?= old('register', 'mobile'); ?>">
                    <br>
                    <span>Exact 10 digits|Omit +91</span>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?= showValidationError('register', 'mobile'); ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
<?php unset($_SESSION['register']['formData']); ?>
