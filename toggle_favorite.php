<?php
// toggle_favorite.php - AJAX adds or removes one favorite
require_once "require_login.php";
require_once "db.php";

// Only accept a request that sends a café id
if (!isset($_POST["cafe_id"])) {
    exit("error");
}
$userId = $_SESSION["user_id"];
$cafeId = (int) $_POST["cafe_id"];
if ($cafeId <= 0) {
    exit("error");
}

// Check if the cafe is already saved
$stmt = mysqli_prepare($connection, "SELECT id FROM favorites WHERE user_id = ? AND cafe_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $userId, $cafeId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $favoriteId);
$exists = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($exists) {
    $stmt = mysqli_prepare($connection, "DELETE FROM favorites WHERE user_id = ? AND cafe_id = ?");
    $answer = "removed";
} else {
    $stmt = mysqli_prepare($connection, "INSERT INTO favorites (user_id, cafe_id) VALUES (?, ?)");
    $answer = "added";
}
mysqli_stmt_bind_param($stmt, "ii", $userId, $cafeId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
echo $answer;
