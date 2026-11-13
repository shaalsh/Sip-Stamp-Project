<?php
// Start the session
session_start();

// Allow POST requests only
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

// Get the form values
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

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
    $stmt = $connection->prepare(
        "SELECT id, password FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();

    // Check the password
    if (!$user || !password_verify($password, $user["password"])) {
        exit("Invalid email or password.");
    }

    // Create a new session after successful login
    session_regenerate_id(true);
    $_SESSION["user_id"] = (int) $user["id"];

    // Redirect to the dashboard
    header("Location: dashboard.php");
    exit;

} catch (mysqli_sql_exception $e) {

    // Show a general message if the database fails
    error_log($e->getMessage());
    http_response_code(500);
    exit("Unable to log in. Please try again later.");
}
?>