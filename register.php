
<?php
// Start the session
session_start();

// Process the registration form
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: signup.php");
    exit;
}

// Get the form values
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";

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
    $check = $connection->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $check->bind_param("s", $email);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $check->close();
        exit("This email is already registered.");
    }

    $check->close();

    // Hash the password before saving it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the users table
    $insert = $connection->prepare(
        "INSERT INTO users (name, email, password)
         VALUES (?, ?, ?)"
    );

    $insert->bind_param("sss", $name, $email, $hashedPassword);
    $insert->execute();
    $insert->close();

    // Redirect to the login page
    header("Location: login.php?registered=1");
    exit;

} catch (mysqli_sql_exception $e) {

    // Show a general message if registration fails
    error_log($e->getMessage());
    http_response_code(500);
    exit("Registration failed. Please try again later.");
}
?>
