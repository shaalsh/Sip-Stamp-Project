<?php
// Check the login session before opening this page
session_start();
header("Cache-Control: no-store");
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
