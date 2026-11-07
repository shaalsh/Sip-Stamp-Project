<?php
// rate.php - called by jQuery AJAX when a star is clicked (UPDATE the rating)
// example: rate.php?id=5&stars=4   -> answers "ok"

session_start();
require_once "db.php";

$id     = (int) $_GET["id"];
$stars  = (int) $_GET["stars"];
$userId = $_SESSION["user_id"];

$statement = mysqli_prepare($connection, "UPDATE experiences SET stars = ? WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($statement, "iii", $stars, $id, $userId);

if ($stars >= 1 && $stars <= 5 && mysqli_stmt_execute($statement)) {
    echo "ok";
} else {
    echo "error";
}
?>
