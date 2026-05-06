<?php
// File: admin/logout.php - Proses Logout
session_start();
session_destroy();
header("Location: login.php");
exit;
?>