<?php
requireFile('../app/Views/sessionstart.php');
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
                echo "<div class='center'><span class='red_font'>"; 
                print_r($_SESSION['register']['error']);
                echo "</span></div>";
                unset($_SESSION['register']['error']);
            }
        ?>

        <form method="post" action="/register">
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
                <?=
                    // if(!empty($_SESSION['register']['firstname']) && 
                    // count($_SESSION['register']['firstname']) > 0)
                    // {
                    //     echo "<div>";
                    //     foreach($_SESSION['register']['firstname'] as $error)
                    //     {
                    //         echo "<span class='red_font'>$error</span><br>";
                    //     }
                    //     echo "</div>";
                    //     unset($_SESSION['register']['firstname']);
                    // }

                    showValidationError('register', 'firstname');
                ?>
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
                <?=
                    // if(!empty($_SESSION['register']['lastname']) && 
                    // count($_SESSION['register']['lastname']) > 0)
                    // {
                    //     echo "<div>";
                    //     foreach($_SESSION['register']['lastname'] as $error)
                    //     {
                    //         echo "<span class='red_font'>$error</span><br>";
                    //     }
                    //     echo "</div>";
                    //     unset($_SESSION['register']['lastname']);
                    // }

                    showValidationError('register', 'lastname');
                ?>
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
                <?=
                    // if(!empty($_SESSION['register']['email']) && 
                    // count($_SESSION['register']['email']) > 0)
                    // {
                    //     echo "<div>";
                    //     foreach($_SESSION['register']['email'] as $error)
                    //     {
                    //         echo "<span class='red_font'>$error</span><br>";
                    //     }
                    //     echo "</div>";
                    //     unset($_SESSION['register']['email']);
                    // }

                    showValidationError('register', 'email');
                ?>
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
                <?=
                    // if(!empty($_SESSION['register']['password']) && 
                    // count($_SESSION['register']['password']) > 0)
                    // {
                    //     echo "<div>";
                    //     foreach($_SESSION['register']['password'] as $error)
                    //     {
                    //         echo "<span class='red_font'>$error</span><br>";
                    //     }
                    //     echo "</div>";
                    //     unset($_SESSION['register']['password']);
                    // }

                    showValidationError('register', 'password');
                ?>
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
                <?=
                    // if(!empty($_SESSION['register']['mobile']) && 
                    // count($_SESSION['register']['mobile']) > 0)
                    // {
                    //     echo "<div>";
                    //     foreach($_SESSION['register']['mobile'] as $error)
                    //     {
                    //         echo "<span class='red_font'>$error</span><br>";
                    //     }
                    //     echo "</div>";
                    //     unset($_SESSION['register']['mobile']);
                    // }

                    showValidationError('register', 'mobile');
                ?>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php requireFile('../app/Views/footer.php'); ?>
<?php unset($_SESSION['register']['formData']); ?>
