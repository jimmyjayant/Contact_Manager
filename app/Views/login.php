<?php
require_once '../app/Views/sessionstart.php';

$css = ["css/login.css"];

require_once '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Login</h1>

        <?php
            if(isset($_SESSION['login_error']))
            {
                echo "<div class='center'><span class='red_font'>" . $_SESSION['login_error'] . "</span></div>";
                $_SESSION['login_error'] = NULL;
            }
        ?>

        <form method="post" action="get_user_data">
            <div class="row">
                <div class="col25"><label for="email">Email</label></div>
                <div class="col75"><input type="email" id="email" name="email" required></div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['email_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['email_error'] . "</span></div>";
                        $_SESSION['email_error'] = NULL;
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25"><label for="pass">Password</label></div>
                <div class="col75">
                    <input type="password" id="pass" name="pass" minlength="6" maxlength="12" required>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                </div>
            </div>

            <div class="row">
                <?php
                    if(isset($_SESSION['pass_error']))
                    {
                        echo "<div><span class='red_font'>" . $_SESSION['pass_error'] . "</span></div>";
                        $_SESSION['pass_error'] = NULL;
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
