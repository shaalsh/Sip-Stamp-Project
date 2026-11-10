<?php

session_start();
if (!is_file(__DIR__ . "/config.php")) {
    http_response_code(503);
    exit("Copy config.example.php to config.php and add your database settings first.");
}
require_once __DIR__ . "/config.php";

// Demo mode is only used locally until the group's login pages are ready.
if (!isset($_SESSION["user_id"]) && defined("DEMO_USER_ID") && DEMO_USER_ID > 0) {
    $_SESSION["user_id"] = (int) DEMO_USER_ID;
}
if (!isset($_SESSION["user_id"]) || !is_scalar($_SESSION["user_id"]) || (int) $_SESSION["user_id"] <= 0) {
    http_response_code(401);
    exit("Please log in to view your account.");
}

require_once __DIR__ . "/db.php";
require_once __DIR__ . "/CoffeePassport.php";
require_once __DIR__ . "/passport_helpers.php";
$userId = (int) $_SESSION["user_id"];

// Match the session's user_id with id in users before showing any account details.
$statement = mysqli_prepare($connection,
    "SELECT id, name, email FROM users WHERE id = ?");
mysqli_stmt_bind_param($statement, "i", $userId);
mysqli_stmt_execute($statement);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
mysqli_stmt_close($statement);
if (!$user) {
    http_response_code(401);
    exit("This account was not found. Please log in again.");
}
$passport = new CoffeePassport($connection, $userId);
