<?php
require '../app/Views/sessionstart.php';
$css = "css/login.css";
require '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Login</h1>

        <?php
            if(isset($_SESSION['login_error']))
            {
                echo "<div style='text-align:center;'><span style='color:red;text-align:center;'>" . $_SESSION['login_error'] . "</span></div>";
                $_SESSION['login_error'] = NULL;
            }
        ?>

        <form method="post" action="get_user_data">
            <div class="row">
                <div class="col25"><label for="email">Email</label></div>
                <div class="col75"><input type="email" id="email" name="email" required></div>
                <?php
                    if(isset($_SESSION['email_error']))
                    {
                        echo "<div style='text-align:center;'><span style='color:red;'>" . $_SESSION['email_error'] . "</span></div>";
                        $_SESSION['email_error'] = NULL;
                    }
                ?>
            </div>

            <div class="row">
                <div class="col25"><label for="pass">Password</label></div>
                <div class="col75"><input type="password" id="pass" name="pass" minlength="6" maxlength="12" required></div>
                <?php
                    if(isset($_SESSION['pass_error']))
                    {
                        echo "<div style='text-align:center;'><span style='color:red;'>" . $_SESSION['pass_error'] . "</span></div>";
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

<?php require '../app/Views/footer.php'; ?>
