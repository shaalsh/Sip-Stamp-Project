<?php
require_once "config.php";

// Open the project database using the connection settings for this computer
try {
    $memberConnection = new PDO("mysql:host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME . ";charset=utf8mb4", DBUSER, DBPASS);
    $memberConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    exit("The database could not be reached Please try again later");
}
