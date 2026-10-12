<?php
session_start();
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_username']);
session_destroy();
header("Location: admin_login.php");
exit();
?>