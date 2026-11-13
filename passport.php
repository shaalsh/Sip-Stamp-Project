<?php
// Check the login session and load this user from the users table
require_once "passport_bootstrap.php";
// Get this user's experience count different cafe count and stamp count
$stats = $passport->getStats();
// Set the browser tab title to My Passport
$pageTitle = "My Passport";
// Highlight My Passport in the shared menu
$activePage = "passport";
// Show the shared page header and navigation menu
include "header.php";
// Continue with the HTML for this page
?>
<!-- Start the main content panel for this account page -->
<section class="panel member-panel">
    <!-- Display the My Passport heading -->
    <h2>My Passport</h2>
    <!-- Display the One experience, one stamp Keep track of your coffee journey text -->
    <p class="hint">One experience, one stamp. Keep track of your coffee journey.</p>
    <!-- Create the section AJAX will refresh and identify it as the full passport view -->
    <div id="passportContent" data-view="passport">
        <!-- Load the shared stamp list and totals for the full passport view -->
        <?php $passportView = "passport"; include "passport_content.php"; ?>
    <!-- Close the div element -->
    </div>
    <!-- Group the page action buttons and apply their shared spacing -->
    <p class="progress-actions passport-actions">
        <!-- Open the form for adding a new experience -->
        <a href="add_experience.php" class="btn">Add Experience</a>
    <!-- Close the p element -->
    </p>
    <!-- Reserve a message area for passport progress messages -->
    <p id="progressMessage" class="hint"></p>
<!-- Close the section element -->
</section>
<!-- Load the JavaScript for AJAX passport updates and profile editing -->
<script src="passport.js"></script>
<!-- Close the main element -->
</main>
<!-- Close the body element -->
</body>
<!-- Close the html element -->
</html>
