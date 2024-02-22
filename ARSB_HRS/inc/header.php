<?php
require __DIR__ . '/../config/app.php';
$style = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$style .= $_SERVER['SERVER_NAME'];
$style .="/ARSB_HRS/styles/styles.css";
include __DIR__ . '/../controller/databaseController.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta lang="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo $style ?>" />
        <?php session_start(); ?>
        <title><?php echo APP_NAME; ?></title>
        <style>
            .error {
                color:red;
            }
        </style>
    </head>
    <body>
        <h1><?php echo APP_NAME; ?></h1>