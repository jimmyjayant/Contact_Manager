<?php
require '../app/Views/sessionstart.php';
$css = "css/login.css";
require '../app/Views/headerandnavbar.php';
?>

<div class="content">
    <div class="intro">
        <h1>Login</h1>

        <form method="post" action="get_user_data">
            <div class="row">
                <div class="col25"><label for="email">Email</label></div>
                <div class="col75"><input type="email" id="email" required></div>
            </div>

            <div class="row">
                <div class="col25"><label for="pass">Password</label></div>
                <div class="col75"><input type="password" id="pass" min="6" maxlength="12" required></div>
            </div>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>
