<?php
// Check the login session before opening the account pages
session_start();
header("Cache-Control: no-store");
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";
require_once "CoffeePassport.php";
require_once "passport_helpers.php";
$userId = $_SESSION["user_id"];

// Match user_id from the session with id in users to get the account details
$statement = mysqli_prepare($connection, "SELECT id, name, email FROM users WHERE id = ?");
mysqli_stmt_bind_param($statement, "i", $userId);
mysqli_stmt_execute($statement);
mysqli_stmt_bind_result($statement, $accountId, $accountName, $accountEmail);
$found = mysqli_stmt_fetch($statement);
mysqli_stmt_close($statement);

// The account was not found: log in again
if (!$found) {
    unset($_SESSION["user_id"]);
    header("Location: login.php");
    exit;
}
$user = array("id" => $accountId, "name" => $accountName, "email" => $accountEmail);
$passport = new CoffeePassport($connection, $userId);
