<?php
require_once '../app/Views/sessionstart.php';

session_unset();
session_destroy();

// Delete the cookie
setcookie("PHPSESSID", "", time() - 3600, "/");

header("Location: index");
exit();
?>
