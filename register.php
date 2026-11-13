<?php
// Start the session
session_start();

// Only accept the sign up form
if (!isset($_POST["email"])) {
    header("Location: signup.php");
    exit;
}

// Get the form values
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

// Check if any field is empty
if ($name === "" || $email === "" || $password === "" || $confirmPassword === "") {
    exit("Please fill in all fields.");
}

// Check the name length
if (strlen($name) > 100) {
    exit("Name must not exceed 100 characters.");
}

// Validate the email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    exit("Please enter a valid email address.");
}

// Check the password length
if (strlen($password) < 8) {
    exit("Password must be at least 8 characters.");
}

// Check if the passwords match
if ($password !== $confirmPassword) {
    exit("Passwords do not match.");
}

// Connect to the database
require_once "db.php";

try {
    // Check if the email is already registered
    $check = mysqli_prepare($connection, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_bind_result($check, $existingId);
    $found = mysqli_stmt_fetch($check);
    mysqli_stmt_close($check);

    if ($found) {
        exit("This email is already registered.");
    }

    // Hash the password before saving it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the users table
    $insert = mysqli_prepare($connection, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert, "sss", $name, $email, $hashedPassword);
    mysqli_stmt_execute($insert);
    mysqli_stmt_close($insert);

    // Redirect to the login page
    header("Location: login.php?registered=1");
    exit;

} catch (mysqli_sql_exception $e) {

    // Show a general message if registration fails
    exit("Registration failed. Please try again later.");
}
?>
