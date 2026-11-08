<?php
// A simple header for Student 2 testing only.
if (!isset($_SESSION["user_id"])) { $_SESSION["user_id"] = 1; } // Demo user, replace when login is ready.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($pageTitle); ?> | SipStamp</title>
<link rel="stylesheet" href="cafes_style.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<header class="site-header">
  <div class="brand">☕ SipStamp <small>coffee passport</small></div>
  <nav><a href="explore.php" <?php if ($activePage === 'cafes') echo 'class="current"'; ?>>Explore Cafés</a>
  <a href="favorites.php" <?php if ($activePage === 'favorites') echo 'class="current"'; ?>>My Favorites ♥</a></nav>
</header>
<main class="container">
