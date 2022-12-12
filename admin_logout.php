<?php
ob_start();
session_start();
if(isset($_SESSION['admin_id'])) {
    session_destroy();
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['admin_email']);
    header("Location: admin_login.php");
} else {
header("Location: admin_login.php");
}
?>  