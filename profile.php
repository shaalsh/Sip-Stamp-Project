<?php
require_once "passport_bootstrap.php";

$message = "";
$name = $user["name"];

// Security token: only this page, in this session, can change the name
if (!isset($_SESSION["profile_token"])) {
    $_SESSION["profile_token"] = bin2hex(random_bytes(32));
}

// When the form is submitted
if (isset($_POST["name"])) {
    $name = trim($_POST["name"]);

    // Check that the form belongs to the current session before saving the name
    if (!isset($_POST["profile_token"]) || !hash_equals($_SESSION["profile_token"], $_POST["profile_token"])) {
        $message = "Please reload the page and try again.";
    } else if ($name == "" || mb_strlen($name) > 100) {
        $message = "Please enter a name with 1 to 100 characters.";
    }

    if ($message == "") {
        try {
            // Update the name column in users using id to find the current account
            $statement = mysqli_prepare($connection, "UPDATE users SET name = ? WHERE id = ?");
            mysqli_stmt_bind_param($statement, "si", $name, $userId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
        } catch (mysqli_sql_exception $exception) {
            $message = "Your changes could not be saved. Please try again.";
        }

        if ($message == "") {
            $_SESSION["profile_flash"] = "Your profile was updated.";
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

    <form id="profileForm" class="card profile-form" action="profile.php" method="post" novalidate>
        <input type="hidden" name="profile_token" value="<?php echo passportEscape($_SESSION["profile_token"]); ?>">
        <div class="profile-avatar">
            <?php echo passportIcon("cup"); ?>
        </div>
        <p>
            <label for="name">Full name</label>
            <button type="button" id="editName" class="edit-name-btn"><?php echo passportIcon("pencil"); ?></button>
            <?php if ($message != "") { ?>
                <input type="text" id="name" name="name" maxlength="100" class="name-editing" value="<?php echo passportEscape($name); ?>">
            <?php } else { ?>
                <input type="text" id="name" name="name" maxlength="100" readonly value="<?php echo passportEscape($name); ?>">
            <?php } ?>
            <span id="nameMsg" class="msg"></span>
        </p>
        <p>
            <label for="accountEmail">Email address</label>
            <input type="email" id="accountEmail" class="fixed-email" value="<?php echo passportEscape($user["email"]); ?>" readonly>
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
