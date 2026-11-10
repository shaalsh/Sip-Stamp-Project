<?php
require_once "passport_bootstrap.php";

$message = "";
$name = $user["name"];
if (!isset($_SESSION["profile_token"])) {
    $_SESSION["profile_token"] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = isset($_POST["name"]) && is_string($_POST["name"]) ? trim($_POST["name"]) : "";
    $token = isset($_POST["profile_token"]) && is_string($_POST["profile_token"]) ? $_POST["profile_token"] : "";

    // Check that this form came from the user's session before changing their account.
    if (!hash_equals($_SESSION["profile_token"], $token)) {
        http_response_code(403);
        $message = "Please reload the page and try again.";
    } elseif ($name === "" || mb_strlen($name) > 100) {
        $message = "Please enter a name with 1 to 100 characters.";
    }

    if ($message === "") {
        try {
            // Update only name in users, using id to find this user's account.
            $statement = mysqli_prepare($connection,
                "UPDATE users SET name = ? WHERE id = ?");
            mysqli_stmt_bind_param($statement, "si", $name, $userId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
        } catch (mysqli_sql_exception $exception) {
            $message = "Your changes could not be saved. Please try again.";
        }

        if ($message === "") {
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
        <p class="flash" role="status"><?php echo passportEscape($_SESSION["profile_flash"]); ?></p>
        <?php unset($_SESSION["profile_flash"]); ?>
    <?php } ?>
    <?php if ($message !== "") { ?>
        <p class="error" role="alert"><?php echo passportEscape($message); ?></p>
    <?php } ?>

    <form id="profileForm" class="card profile-form" action="profile.php" method="post" data-editing="<?php echo $message !== "" ? "true" : "false"; ?>" novalidate>
        <input type="hidden" name="profile_token" value="<?php echo passportEscape($_SESSION["profile_token"]); ?>">
        <div class="profile-avatar">
            <span><?php echo passportEscape(mb_strtoupper(mb_substr($user["name"], 0, 1))); ?></span>
        </div>
        <p>
            <label for="name">Full name</label>
            <button type="button" id="editName" class="edit-name-btn" aria-label="Edit name" aria-controls="name" hidden><?php echo passportIcon("pencil"); ?></button>
            <input type="text" id="name" name="name" maxlength="100" autocomplete="name" required value="<?php echo passportEscape($name); ?>" aria-describedby="nameMsg">
            <span id="nameMsg" class="msg"></span>
        </p>
        <p>
            <label for="accountEmail">Email address</label>
            <input type="email" id="accountEmail" class="fixed-email" value="<?php echo passportEscape($user["email"]); ?>" readonly>
        </p>
        <button type="submit" class="btn" id="saveProfile">Save Changes</button>
    </form>
</section>
<script src="passport.js"></script>
</main>
</body>
</html>
