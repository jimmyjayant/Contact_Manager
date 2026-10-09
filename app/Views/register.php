<?php
requireFile('../app/Views/sessionstart.php');

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
                    <label for="fname">First Name*</label>
                </div>
                <div class="col75">
                    <input type="text" id="fname" name="fname" maxlength="100" 
                    placeholder="Enter your First Name" required>
                    <br>
                    <span>Required|Max 100 characters|Alphabets only</span>
                </div>
            </div>

            <div class="row">
                <?php
                    if(!empty($_SESSION['register']['firstname']) && 
                    count($_SESSION['register']['firstname']) > 0)
                    {
                        echo "<div>";
                        foreach($_SESSION['register']['firstname'] as $error)
                        {
                            echo "<span class='red_font'>$error</span><br>";
                        }
                        echo "</div>";
                        unset($_SESSION['register']['firstname']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="lname">Last Name*</label>
                </div>
                <div class="col75">
                    <input type="text" id="lname" name="lname" maxlength="100" 
                    placeholder="Enter your Last Name" required>
                    <br>
                    <span>Required|Max 100 characters|Alphabets only</span>
                </div>
            </div>

            <div class="row">
                <?php
                    if(!empty($_SESSION['register']['lastname']) && 
                    count($_SESSION['register']['lastname']) > 0)
                    {
                        echo "<div>";
                        foreach($_SESSION['register']['lastname'] as $error)
                        {
                            echo "<span class='red_font'>$error</span><br>";
                        }
                        echo "</div>";
                        unset($_SESSION['register']['lastname']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="email">Email Address*</label>
                </div>
                <div class="col75">
                    <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(!empty($_SESSION['register']['email']) && 
                    count($_SESSION['register']['email']) > 0)
                    {
                        echo "<div>";
                        foreach($_SESSION['register']['email'] as $error)
                        {
                            echo "<span class='red_font'>$error</span><br>";
                        }
                        echo "</div>";
                        unset($_SESSION['register']['email']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="pass">Password*</label>
                </div>
                <div class="col75">
                    <input type="password" id="pass" name="pass" minlength="6" maxlength="12" 
                    placeholder="Enter your password" required>
                </div>
            </div>

            <div class="row">
                <?php
                    if(!empty($_SESSION['register']['password']) && 
                    count($_SESSION['register']['password']) > 0)
                    {
                        echo "<div>";
                        foreach($_SESSION['register']['password'] as $error)
                        {
                            echo "<span class='red_font'>$error</span><br>";
                        }
                        echo "</div>";
                        unset($_SESSION['register']['password']);
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25">
                    <label for="contact">Contact</label>
                </div>
                <div class="col75">
                    <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" 
                    placeholder="Enter Your contact number" required>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?php
                    if(!empty($_SESSION['register']['mobile']) && 
                    count($_SESSION['register']['mobile']) > 0)
                    {
                        echo "<div>";
                        foreach($_SESSION['register']['mobile'] as $error)
                        {
                            echo "<span class='red_font'>$error</span><br>";
                        }
                        echo "</div>";
                        unset($_SESSION['register']['mobile']);
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
