<?php
// Lab 8: only a logged-in user can open this page
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
