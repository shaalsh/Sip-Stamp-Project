<?php
// header.php - the top of every page (sidebar). Each page sets $pageTitle and $activePage first.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $pageTitle; ?> - SipStamp</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>

    <aside id="sidebar">
        <h1 class="logo">SipStamp</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php"      <?php if ($activePage == "home")      { echo 'class="active"'; } ?>>Home</a></li>
                <li><a href="passport.php"       <?php if ($activePage == "passport")  { echo 'class="active"'; } ?>>My Passport</a></li>
                <li><a href="add_experience.php" <?php if ($activePage == "add")       { echo 'class="active"'; } ?>>Add Experience</a></li>
                <li><a href="my_experiences.php" <?php if ($activePage == "mine")      { echo 'class="active"'; } ?>>My Experiences</a></li>
                <li><a href="explore.php"        <?php if ($activePage == "cafes")     { echo 'class="active"'; } ?>>Cafés</a></li>
                <li><a href="favorites.php"      <?php if ($activePage == "favorites") { echo 'class="active"'; } ?>>Favorites</a></li>
                <li><a href="profile.php"        <?php if ($activePage == "profile")   { echo 'class="active"'; } ?>>Profile</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </aside>

    <main>
