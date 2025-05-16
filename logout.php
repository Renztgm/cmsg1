<?php
session_start();
session_unset();
session_destroy();

// Check HTTP_REFERER to determine previous page
$referer = $_SERVER['HTTP_REFERER'] ?? '';
if (strpos($referer, 'faculty') !== false) {
    header("Location: facultylogin.php");
} else {
    header("Location: login.php");
}
exit();
?>