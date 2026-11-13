<?php
// Start the session
session_start();

// auth.js sends ajax=1. Without it, the form was sent the normal way (no JavaScript).
$ajax = isset($_POST["ajax"]);

// Show an error: AJAX gets "error|message", a normal form gets a popup and goes back to Log In
function loginError($message, $ajax) {
    if ($ajax) {
        exit("error|" . $message);
    }
    exit("<script>alert('" . $message . "'); window.location.href = 'login.php';</script>");
}

// Only accept the log in form (Lab 8: POST only)
if (!isset($_POST["email"])) {
    header("Location: login.php");
    exit;
}

// Get the form values
$email = trim($_POST["email"]);
$password = $_POST["password"];

// Check if the fields are empty
if ($email === "" || $password === "") {
    loginError("Please fill in all fields.", $ajax);
}

// Validate the email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    loginError("Please enter a valid email address.", $ajax);
}

try {
    // Connect to the database
    require_once "db.php";

    // Find the user by email
    $stmt = mysqli_prepare($connection, "SELECT id, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $userId, $hashedPassword);
    $found = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
} catch (mysqli_sql_exception $e) {
    // Show a general message if the database fails
    loginError("Unable to log in. Please try again later.", $ajax);
}

// Check the password
if (!$found || !password_verify($password, $hashedPassword)) {
    loginError("Invalid email or password.", $ajax);
}

// Save the user in the session
$_SESSION["user_id"] = $userId;

// AJAX: tell JavaScript to open the dashboard. Normal form: open it directly.
if ($ajax) {
    exit("success|Logged in successfully.");
}
header("Location: dashboard.php");
exit;
?>
