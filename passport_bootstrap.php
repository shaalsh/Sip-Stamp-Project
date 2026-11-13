<?php
session_start();
// Keep this private account page out of the browser cache
header("Cache-Control: no-store");
// Check whether the login session is missing a user id
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";
require_once "CoffeePassport.php";
require_once "passport_helpers.php";
$userId = $_SESSION["user_id"];

// Prepare a query for id name and email in users where id matches the logged in user
$statement = mysqli_prepare($connection, "SELECT id, name, email FROM users WHERE id = ?");
// Put the current user id into the query as an integer
mysqli_stmt_bind_param($statement, "i", $userId);
mysqli_stmt_execute($statement);
mysqli_stmt_bind_result($statement, $accountId, $accountName, $accountEmail);
$found = mysqli_stmt_fetch($statement);
mysqli_stmt_close($statement);

// Check whether the account has been removed from the users table
if (!$found) {
    unset($_SESSION["user_id"]);
    header("Location: login.php");
    exit;
}
$user = array("id" => $accountId, "name" => $accountName, "email" => $accountEmail);
// Create the passport object with the database connection and current user id
$passport = new CoffeePassport($connection, $userId);
