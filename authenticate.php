<?php
// Start the session
session_start();

// Only accept the log in form
if (!isset($_POST["email"])) {
    header("Location: login.php");
    exit;
}

// Get the form values
$email = trim($_POST["email"]);
$password = $_POST["password"];

// Check if the fields are empty
if ($email === "" || $password === "") {
    exit("Please fill in all fields.");
}

// Validate the email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email address.");
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

    // Check the password
    if (!$found || !password_verify($password, $hashedPassword)) {
        exit("Invalid email or password.");
    }

    // Save the user in the session
    $_SESSION["user_id"] = $userId;

    // Redirect to the dashboard
    header("Location: dashboard.php");
    exit;

} catch (mysqli_sql_exception $e) {

    // Show a general message if the database fails
    exit("Unable to log in. Please try again later.");
}
?>
