<?php
// Start the session
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

    <title>Home - SipStamp</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
</head>

<body>

    <!-- Home page -->
    <div class="home-box">

        <h1>SipStamp</h1>

        <h2>Your Coffee Journey Starts Here</h2>

        <p class="hint">
            Discover new cafes, share your coffee experiences,
            and collect stamps along the way.
        </p>

        <!-- Navigation buttons -->
        <div class="home-buttons">

            <a href="signup.php" class="home-btn">
                Get Started
            </a>

            <a href="login.php" class="home-btn secondary-btn">
                Log In
            </a>

        </div>

    </div>

</body>
</html>