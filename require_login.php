<?php
// Check the login session before opening this page
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
