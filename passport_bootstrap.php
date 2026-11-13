<?php
// Start or continue the session that stores the logged in user
session_start();
// Keep this private account page out of the browser cache
header("Cache-Control: no-store");
// Check whether the login session is missing a user id
if (!isset($_SESSION["user_id"])) {
    // Send the user to the login page
    header("Location: login.php");
    // Stop this request so the following code does not run
    exit;
// End this condition loop function or class
}

// Open the shared MySQL connection using the local config settings
require_once "db.php";
// Load the class that reads experiences cafes and stamps
require_once "CoffeePassport.php";
// Load the functions for safe text and the page icons
require_once "passport_helpers.php";
// Use the id from the login session to read only this user's data
$userId = $_SESSION["user_id"];

// Prepare a query for id name and email in users where id matches the logged in user
$statement = mysqli_prepare($connection, "SELECT id, name, email FROM users WHERE id = ?");
// Put the current user id into the query as an integer
mysqli_stmt_bind_param($statement, "i", $userId);
// Run the prepared query on the database
mysqli_stmt_execute($statement);
// Store the selected users columns in the account variables
mysqli_stmt_bind_result($statement, $accountId, $accountName, $accountEmail);
// Read the matching user row and remember whether it exists
$found = mysqli_stmt_fetch($statement);
// Close this statement after finishing its query
mysqli_stmt_close($statement);

// Check whether the account has been removed from the users table
if (!$found) {
    // Remove the user id when the account no longer exists
    unset($_SESSION["user_id"]);
    // Send the user to the login page
    header("Location: login.php");
    // Stop this request so the following code does not run
    exit;
// End this condition loop function or class
}
// Keep the account id name and email together for the page to display
$user = array("id" => $accountId, "name" => $accountName, "email" => $accountEmail);
// Create the passport object with the database connection and current user id
$passport = new CoffeePassport($connection, $userId);
