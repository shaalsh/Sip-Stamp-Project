<?php
session_start();
// Check whether the login session is missing a user id
if (!isset($_SESSION["user_id"])) {
    // Tell the AJAX script to open the login page instead of showing account data
    exit("login");
}
require_once "db.php";
require_once "CoffeePassport.php";
require_once "passport_helpers.php";

$passport = new CoffeePassport($connection, $_SESSION["user_id"]);
// Get this user's experience count different cafe count and stamp count
$stats = $passport->getStats();
// Check whether AJAX requested the full passport rather than the dashboard summary
if (isset($_GET["view"]) && $_GET["view"] == "passport") {
    $passportView = "passport";
} else {
    $passportView = "dashboard";
}
// Build the stamp HTML that AJAX will place inside the current page
include "passport_content.php";
