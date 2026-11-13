<?php
// Connect to the database using the local connection settings

require_once "config.php";

// Report query errors so the experience and stamp can be rolled back together if saving fails
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if (mysqli_connect_errno()) {
    die("Unable to connect to database: " . mysqli_connect_error());
}
mysqli_set_charset($connection, "utf8mb4");
?>
