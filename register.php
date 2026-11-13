<?php
// Start the session
session_start();

// Only accept the sign up form
if (!isset($_POST["email"])) {
    exit("error|POST only.");
}

// Get the form values
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

// Check if any field is empty
if ($name === "" || $email === "" || $password === "" || $confirmPassword === "") {
    exit("error|Please fill in all fields.");
}

// Check the name length
if (mb_strlen($name) > 100) {
    exit("error|Name must not exceed 100 characters.");
}

// Validate the email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    exit("error|Please enter a valid email address.");
}

// Check the password length
if (strlen($password) < 8) {
    exit("error|Password must be at least 8 characters.");
}

// Check if the passwords match
if ($password !== $confirmPassword) {
    exit("error|Passwords do not match.");
}

try {
    // Connect to the database
    require_once "db.php";

    // Check if the email is already registered
    $check = mysqli_prepare($connection, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_bind_result($check, $existingId);
    $found = mysqli_stmt_fetch($check);
    mysqli_stmt_close($check);

    if ($found) {
        exit("error|This email is already registered.");
    }

    // Hash the password before saving it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the users table
    $insert = mysqli_prepare($connection, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert, "sss", $name, $email, $hashedPassword);
    mysqli_stmt_execute($insert);
    mysqli_stmt_close($insert);

    // Return the result so it appears inside the sign up form
    echo "success|Account created successfully. Please use Log In below.";
    exit;

} catch (mysqli_sql_exception $e) {

    // Show a general message if registration fails
    exit("error|Registration failed. Please try again later.");
}
?>
