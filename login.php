
<?php
// Start the session
session_start();

// Redirect logged in users to the dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

// Check if the user registered successfully
$registered = isset($_GET["registered"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Log In - SipStamp</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="auth.js" defer></script>
</head>

<body>

    <!-- Log in form -->
    <div class="auth-box">

        <h1>SipStamp</h1>
        <h2>Welcome Back!</h2>

        <p class="hint">Log in to continue your coffee journey.</p>

        <?php if ($registered) { ?>
            <p class="success-msg">
                Account created successfully. Please log in.
            </p>
        <?php } ?>

        <form id="loginForm" action="authenticate.php" method="post">

            <!-- Email address -->
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" id="password"
                   name="password" required>

            <div id="loginResult" class="msg" role="alert"></div>

            <button type="submit" class="auth-btn">
                Log In
            </button>

        </form>

        <p class="auth-link">
            Don't have an account?
            <a href="signup.php">Sign Up</a>
        </p>

    </div>

</body>
</html>
