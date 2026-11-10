<?php
require_once "passport_bootstrap.php";
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-store");
$passportView = isset($_GET["view"]) && $_GET["view"] === "passport" ? "passport" : "dashboard";
$stats = $passport->getStats();
include "passport_content.php";
