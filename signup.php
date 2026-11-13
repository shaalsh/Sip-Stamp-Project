<?php
// Start the session to check if the user is logged in
session_start();

// Redirect logged in users to the dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sign Up - SipStamp</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
</head>

<body>

    <!-- Sign up form -->
    <div class="auth-box">

        <h1>SipStamp</h1>
        <h2>Create Account</h2>

        <p class="hint">Start your coffee journey with us!</p>

        <form id="signupForm" action="register.php" method="post">

            <!-- Full name -->
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name"
                   maxlength="100" required>

            <!-- Email address -->
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" id="password"
                   name="password" minlength="8" required>

            <!-- Confirm password -->
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword"
                   name="confirmPassword" required>

            <!-- Validation message -->
            <p id="signupMsg" class="msg"></p>

            <button type="submit" class="auth-btn">
                Create Account
            </button>

        </form>

        <p class="auth-link">
            Already have an account?
            <a href="login.php">Log In</a>
        </p>

    </div>

    <!-- Lab 8: load the script before </body> so the form already exists -->
    <script src="auth.js"></script>
</body>
</html>
