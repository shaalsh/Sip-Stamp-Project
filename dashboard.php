<?php
require_once "passport_bootstrap.php";
$stats = $passport->getStats();
$recentExperiences = $passport->getRecentExperiences();
$pageTitle = "Dashboard";
$activePage = "home";
include "header.php";
?>
<section class="panel member-panel">
    <h2>Dashboard</h2>
    <p class="hint">Welcome back, <?php echo passportEscape($user["name"]); ?>.</p>

    <div class="stats-row">
        <div class="card stat-card">
            <?php echo passportIcon("cup"); ?>
            <strong id="experienceCount"><?php echo $stats["experiences"]; ?></strong>
            <span>Experiences</span>
        </div>
        <div class="card stat-card">
            <?php echo passportIcon("cafe"); ?>
            <strong id="cafeCount"><?php echo $stats["cafes"]; ?></strong>
            <span>Cafe's visited</span>
        </div>
        <div class="card stat-card">
            <?php echo passportIcon("stamp"); ?>
            <strong id="stampCount"><?php echo $stats["stamps"]; ?></strong>
            <span>Stamps</span>
        </div>
    </div>

    <h3>Passport Progress</h3>
    <div id="passportContent" data-view="dashboard">
        <?php $passportView = "dashboard"; include "passport_content.php"; ?>
    </div>
    <p class="progress-actions passport-actions">
        <a href="passport.php" class="btn">View Passport</a>
    </p>
    <p id="progressMessage" class="hint"></p>

    <h3>Recent Experiences</h3>
    <?php if (count($recentExperiences) == 0) { ?>
        <div class="card"><p class="hint">Your coffee journey starts here.</p>
            <a href="add_experience.php" class="btn small">Add your first experience</a></div>
    <?php } else { ?>
        <div class="card recent-list">
            <?php foreach ($recentExperiences as $experience) { ?>
                <article class="recent-row">
                    <?php echo passportIcon("cup"); ?>
                    <div class="recent-details">
                        <h3><?php echo passportEscape($experience["name"]); ?></h3>
                        <p><?php echo passportEscape($experience["drink"]); ?></p>
                        <p class="experience-date"><?php echo passportEscape(date("d M Y", strtotime($experience["date"]))); ?></p>
                        <span class="hint"><?php echo (int) $experience["stars"]; ?> / 5 stars</span>
                    </div>
                </article>
            <?php } ?>
        </div>
        <p class="progress-actions passport-actions">
            <a href="my_experiences.php" class="btn">View all experiences</a>
        </p>
    <?php } ?>
</section>
<script src="passport.js"></script>
</main>
</body>
</html>
