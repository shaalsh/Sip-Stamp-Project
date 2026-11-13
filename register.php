
<?php
// Start the session
session_start();

// Process the registration form
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("error|POST only.");
}

// Get the form values
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";

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

// Connect to the database
try {
    require_once "db.php";
    // Check if the email is already registered
    $check = $connection->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $check->bind_param("s", $email);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $check->close();
        exit("error|This email is already registered.");
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

    // Return the result so it appears inside the sign up form
    echo "success|Account created successfully. Please use Log In below.";
    exit;

} catch (mysqli_sql_exception $e) {

    // Show a general message if registration fails
    error_log($e->getMessage());
    exit("error|Registration failed. Please try again later.");
}
?>
