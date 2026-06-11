<?php
require '../app/Views/sessionstart.php';
session_unset();
session_destroy();
header("Location: index");
?>
