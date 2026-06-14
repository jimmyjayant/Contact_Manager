<?php
require '../app/Views/sessionstart.php';
$css = "css/changepassword.css";
require '../app/Views/headerandnavbar.php';

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

    </div>
</div>
</div>

<?php require '../app/Views/footer.php'; ?>