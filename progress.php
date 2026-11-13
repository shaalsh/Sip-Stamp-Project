<?php
// Start or continue the session that stores the logged in user
session_start();
// Check whether the login session is missing a user id
if (!isset($_SESSION["user_id"])) {
    // Tell the AJAX script to open the login page instead of showing account data
    exit("login");
// End this condition loop function or class
}
// Open the shared MySQL connection using the local config settings
require_once "db.php";
// Load the class that reads experiences cafes and stamps
require_once "CoffeePassport.php";
// Load the functions for safe text and the page icons
require_once "passport_helpers.php";

// Create the passport object for the user in this login session
$passport = new CoffeePassport($connection, $_SESSION["user_id"]);
// Get this user's experience count different cafe count and stamp count
$stats = $passport->getStats();
// Check whether AJAX requested the full passport rather than the dashboard summary
if (isset($_GET["view"]) && $_GET["view"] == "passport") {
    // Choose the passport view including the stamp list
    $passportView = "passport";
// Use the other case when the previous condition is not met
} else {
    // Choose the dashboard view with the stamp totals only
    $passportView = "dashboard";
// End this condition loop function or class
}
// Build the stamp HTML that AJAX will place inside the current page
include "passport_content.php";
