<?php
// Check the login session and load this user from the users table
require_once "passport_bootstrap.php";
// Get this user's experience count different cafe count and stamp count
$stats = $passport->getStats();
// Get the latest three experiences saved by this user
$recentExperiences = $passport->getRecentExperiences();
// Set the browser tab title to Dashboard
$pageTitle = "Dashboard";
// Highlight Home in the shared menu
$activePage = "home";
// Show the shared page header and navigation menu
include "header.php";
// Continue with the HTML for this page
?>
<!-- Start the main content panel for this account page -->
<section class="panel member-panel">
    <!-- Display the Dashboard heading -->
    <h2>Dashboard</h2>
    <!-- Welcome the current user and display the name safely from the users table -->
    <p class="hint">Welcome back, <?php echo passportEscape($user["name"]); ?>.</p>

    <!-- Group the three dashboard statistic boxes in one row -->
    <div class="stats-row">
        <!-- Start one statistic box inside the dashboard row -->
        <div class="card stat-card">
            <!-- Show the coffee cup icon using the shared icon function -->
            <?php echo passportIcon("cup"); ?>
            <!-- Display the experience count and give AJAX an id to update it -->
            <strong id="experienceCount"><?php echo $stats["experiences"]; ?></strong>
            <!-- Display the Experiences text -->
            <span>Experiences</span>
        <!-- Close the div element -->
        </div>
        <!-- Start one statistic box inside the dashboard row -->
        <div class="card stat-card">
            <!-- Show the cafe icon using the shared icon function -->
            <?php echo passportIcon("cafe"); ?>
            <!-- Display the number of different cafes visited and give AJAX an id to update it -->
            <strong id="cafeCount"><?php echo $stats["cafes"]; ?></strong>
            <!-- Display the Cafe's visited text -->
            <span>Cafe's visited</span>
        <!-- Close the div element -->
        </div>
        <!-- Start one statistic box inside the dashboard row -->
        <div class="card stat-card">
            <!-- Show the stamp icon using the shared icon function -->
            <?php echo passportIcon("stamp"); ?>
            <!-- Display the collected stamp count and give AJAX an id to update it -->
            <strong id="stampCount"><?php echo $stats["stamps"]; ?></strong>
            <!-- Display the Stamps text -->
            <span>Stamps</span>
        <!-- Close the div element -->
        </div>
    <!-- Close the div element -->
    </div>

    <!-- Display the Passport Progress heading -->
    <h3>Passport Progress</h3>
    <!-- Create the section AJAX will refresh and identify it as the dashboard view -->
    <div id="passportContent" data-view="dashboard">
        <!-- Load the shared stamp totals for the dashboard view -->
        <?php $passportView = "dashboard"; include "passport_content.php"; ?>
    <!-- Close the div element -->
    </div>
    <!-- Group the page action buttons and apply their shared spacing -->
    <p class="progress-actions passport-actions">
        <!-- Open the full passport page -->
        <a href="passport.php" class="btn">View Passport</a>
    <!-- Close the p element -->
    </p>
    <!-- Reserve a message area for passport progress messages -->
    <p id="progressMessage" class="hint"></p>

    <!-- Display the Recent Experiences heading -->
    <h3>Recent Experiences</h3>
    <!-- Check whether this user has no saved experiences yet -->
    <?php if (count($recentExperiences) == 0) { ?>
        <!-- Show the empty state message inside a card -->
        <div class="card"><p class="hint">Your coffee journey starts here.</p>
            <!-- Open the experience form so the user can add a first experience -->
            <a href="add_experience.php" class="btn small">Add your first experience</a></div>
    <!-- Show the other section when the previous condition is not met -->
    <?php } else { ?>
        <!-- Group the recent experiences inside one card -->
        <div class="card recent-list">
            <!-- Repeat the following HTML for each of the latest three experiences -->
            <?php foreach ($recentExperiences as $experience) { ?>
                <!-- Start one row for a recent experience -->
                <article class="recent-row">
                    <!-- Show the coffee cup icon using the shared icon function -->
                    <?php echo passportIcon("cup"); ?>
                    <!-- Group the cafe drink date and rating for this experience -->
                    <div class="recent-details">
                        <!-- Display the cafe name safely from this experience row -->
                        <h3><?php echo passportEscape($experience["name"]); ?></h3>
                        <!-- Display the saved drink name safely -->
                        <p><?php echo passportEscape($experience["drink"]); ?></p>
                        <!-- Read the date column from experiences and display it as day month and year -->
                        <p class="experience-date"><?php echo passportEscape(date("d M Y", strtotime($experience["date"]))); ?></p>
                        <!-- Display the saved star rating as an integer out of five -->
                        <span class="hint"><?php echo (int) $experience["stars"]; ?> / 5 stars</span>
                    <!-- Close the div element -->
                    </div>
                <!-- Close the article element -->
                </article>
            <!-- End this PHP condition or loop before continuing the page -->
            <?php } ?>
        <!-- Close the div element -->
        </div>
        <!-- Group the page action buttons and apply their shared spacing -->
        <p class="progress-actions passport-actions">
            <!-- Open the page showing all saved experiences -->
            <a href="my_experiences.php" class="btn">View all experiences</a>
        <!-- Close the p element -->
        </p>
    <!-- End this PHP condition or loop before continuing the page -->
    <?php } ?>
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
