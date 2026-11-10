<?php
require_once "passport_bootstrap.php";
$stats = $passport->getStats();
$pageTitle = "My Passport";
$activePage = "passport";
include "header.php";
?>
<section class="panel member-panel">
    <h2>My Passport</h2>
    <p class="hint">One experience, one stamp. Keep track of your coffee journey.</p>
    <div id="passportContent" data-view="passport">
        <?php $passportView = "passport"; include "passport_content.php"; ?>
    </div>
    <p class="progress-actions passport-actions">
        <a href="add_experience.php" class="btn">Add Experience</a>
    </p>
    <p id="progressMessage" class="hint" role="status"></p>
</section>
<script src="passport.js"></script>
</main>
</body>
</html>
