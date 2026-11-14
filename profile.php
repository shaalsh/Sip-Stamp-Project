<?php
// Check the login session and load this user from the users table
require_once "passport_bootstrap.php";

$message = "";
$name = $user["name"];

// Process the profile form only after a name has been submitted
if (isset($_POST["name"])) {
    $name = trim($_POST["name"]);

    // Check that the submitted name is not empty before updating users
    if ($name == "") {
        $message = "Please enter your name.";
    }

    if ($message == "") {
        try {
            // Prepare an update for only the name column in users where id matches the current account
            $statement = $memberConnection->prepare("UPDATE users SET name = ? WHERE id = ?");
            // Save the submitted name only for the account in this session
            $statement->execute(array($name, $userId));
        // Handle a MySQL error instead of leaving the request without a page message
        } catch (PDOException $exception) {
            $message = "Your changes could not be saved. Please try again.";
        }

        if ($message == "") {
            $_SESSION["profile_flash"] = "Your profile was updated.";
            // Open the profile again so refreshing will not submit the same name twice
            header("Location: profile.php");
            exit;
        }
    }
}

$pageTitle = "Profile";
$activePage = "profile";
include "header.php";
?>
<section class="panel member-panel">
    <h2>Profile</h2>
    <p class="hint">View your account details and update your name.</p>
    <?php if (isset($_SESSION["profile_flash"])) { ?>
        <p class="flash"><?php echo passportEscape($_SESSION["profile_flash"]); ?></p>
        <?php unset($_SESSION["profile_flash"]); ?>
    <?php } ?>
    <?php if ($message != "") { ?>
        <p class="error"><?php echo passportEscape($message); ?></p>
    <?php } ?>

    <form id="profileForm" class="card profile-form" action="profile.php" method="post">
        <div class="profile-avatar">
            <?php echo passportIcon("cup"); ?>
        </div>
        <p>
            <label for="name">Full name</label>
            <button type="button" id="editName" class="edit-name-btn"><?php echo passportIcon("pencil"); ?></button>
            <?php if ($message != "") { ?>
                <input type="text" id="name" name="name" maxlength="100" class="profile-field name-editing" value="<?php echo passportEscape($name); ?>">
            <?php } else { ?>
                <span id="nameDisplay" class="profile-field"><?php echo passportEscape($name); ?></span>
                <input type="text" id="name" name="name" maxlength="100" class="profile-field save-hidden" value="<?php echo passportEscape($name); ?>">
            <?php } ?>
            <span id="nameMsg" class="msg"></span>
        </p>
        <p>
            <label for="accountEmail">Email address</label>
            <!-- Show the email column from users as text inside its box -->
            <span id="accountEmail" class="profile-field fixed-email"><?php echo passportEscape($user["email"]); ?></span>
        </p>
        <?php if ($message != "") { ?>
            <button type="submit" class="btn" id="saveProfile">Save Changes</button>
        <?php } else { ?>
            <button type="submit" class="btn save-hidden" id="saveProfile">Save Changes</button>
        <?php } ?>
    </form>
</section>
<script src="passport.js"></script>
</main>
</body>
</html>
