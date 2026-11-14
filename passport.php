<?php
// Check the login session and load this user from the users table
require_once "passport_bootstrap.php";
// Get this user's experience count different cafe count and stamp count
$stats = $passport->getStats();
$pageTitle = "My Passport";
$activePage = "passport";
include "header.php";
?>
<section class="panel member-panel">
    <h2>My Passport</h2>
    <p class="hint">One experience, one stamp. Keep track of your coffee journey.</p>
    <!-- Create the section AJAX will refresh and identify it as the full passport view -->
    <input type="hidden" id="passportView" value="passport">
    <div id="passportContent">
        <?php $passportView = "passport"; include "passport_content.php"; ?>
    </div>
    <p class="progress-actions passport-actions">
        <a href="add_experience.php" class="btn">Add Experience</a>
    </p>
    <p id="progressMessage" class="hint"></p>
</section>
<!-- Load the JavaScript for AJAX passport updates and profile editing -->
<script src="passport.js"></script>
</main>
</body>
</html>
