<?php
session_start();
if (!isset($_SESSION["admin_uuid"])) {
    header("Location: ../login/login.php");
    exit();
}
?>
