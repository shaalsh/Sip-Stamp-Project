<?php
// db.php - connects to the database (every page includes this file)
// the login is in config.php, which stays on our laptops and is not uploaded to GitHub

require_once "config.php";

// Report query errors so a failed experience or stamp can be rolled back together.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if (mysqli_connect_errno()) {
    die("Unable to connect to database: " . mysqli_connect_error());
}
mysqli_set_charset($connection, "utf8mb4");

// TEMPORARY: until Student 1's login is ready, pretend user 1 is logged in
if (!isset($_SESSION["user_id"])) {
    $_SESSION["user_id"] = 1;
}
?>
