<?php
session_start();
// Check whether the login session is missing a user id
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "passport_connection.php";
require_once "CoffeePassport.php";
require_once "passport_helpers.php";
$userId = $_SESSION["user_id"];

// Prepare a query for id name and email in users where id matches the logged in user
$statement = $memberConnection->prepare("SELECT id, name, email FROM users WHERE id = ?");
$statement->execute(array($userId));
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Check whether the account has been removed from the users table
if (!$user) {
    unset($_SESSION["user_id"]);
    header("Location: login.php");
    exit;
}
// Create the passport object with the database connection and current user id
$passport = new CoffeePassport($memberConnection, $userId);
