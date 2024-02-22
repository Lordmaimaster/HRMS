<?php
$index = isset($_SERVER['HTTPS']) ? 'https:..' : 'http://';
$index .= $_SERVER['SERVER_NAME'];
$index .= "/ARSB_HRS/";
if ($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) {
    echo "<script>alert('Session Expired')</script>";
    session_unset();
    session_destroy();
    header("Refresh:0 url=" . $index);
    exit();
} else
    $_SESSION['last_activity'] = time();
?>