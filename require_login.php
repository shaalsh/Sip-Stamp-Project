<?php
session_start();
header("Cache-Control: no-store");

// Use the user id saved by the login page before reading account data
if (!isset($_SESSION["user_id"]) || !is_scalar($_SESSION["user_id"]) || (int) $_SESSION["user_id"] <= 0) {
    unset($_SESSION["user_id"]);
    if (basename($_SERVER["SCRIPT_NAME"]) === "toggle_favorite.php") {
        http_response_code(401);
        exit("Please log in to save favorites.");
    }
    header("Location: login.php");
    exit;
}
