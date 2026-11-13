<?php
// toggle_favorite.php - AJAX adds or removes one favorite
session_start();
// Demo user for testing Student 2 without the login module.
if (!isset($_SESSION["user_id"])) { $_SESSION["user_id"] = 1; }
require_once "db.php";
header("Content-Type: text/plain; charset=utf-8");
$userId = (int) $_SESSION["user_id"];
$cafeId = isset($_POST["cafe_id"]) ? (int) $_POST["cafe_id"] : 0;
if ($cafeId <= 0) { http_response_code(400); exit("Invalid café"); }

// Check if the cafe is already saved
$stmt = mysqli_prepare($connection, "SELECT id FROM favorites WHERE user_id = ? AND cafe_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $userId, $cafeId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$exists = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if ($exists) {
    $stmt = mysqli_prepare($connection, "DELETE FROM favorites WHERE user_id = ? AND cafe_id = ?");
    $answer = "removed";
} else {
    $stmt = mysqli_prepare($connection, "INSERT INTO favorites (user_id, cafe_id) VALUES (?, ?)");
    $answer = "added";
}
mysqli_stmt_bind_param($stmt, "ii", $userId, $cafeId);
if (mysqli_stmt_execute($stmt)) { echo $answer; }
else { http_response_code(500); echo "Error saving favorite"; }
