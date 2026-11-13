<?php
// progress.php - sends the latest stamp count to passport.js (AJAX)
session_start();
if (!isset($_SESSION["user_id"])) {
    exit("login");
}
require_once "db.php";
require_once "CoffeePassport.php";
require_once "passport_helpers.php";

$passport = new CoffeePassport($connection, $_SESSION["user_id"]);
$stats = $passport->getStats();
if (isset($_GET["view"]) && $_GET["view"] == "passport") {
    $passportView = "passport";
} else {
    $passportView = "dashboard";
}
include "passport_content.php";
