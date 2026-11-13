<?php
// Check the login session and load this user from the users table
require_once "passport_bootstrap.php";

// Start with no validation or database error message
$message = "";
// Read the saved name from the current user account
$name = $user["name"];

// Check whether this session already has a profile form token
if (!isset($_SESSION["profile_token"])) {
    // Create a random token and keep it in the session for checking profile submissions
    $_SESSION["profile_token"] = bin2hex(random_bytes(32));
// End this condition loop function or class
}

// Process the profile form only after a name has been submitted
if (isset($_POST["name"])) {
    // Remove spaces from the start and end of the submitted name
    $name = trim($_POST["name"]);

    // Check that the submitted form token matches the one in this login session
    if (!isset($_POST["profile_token"]) || !hash_equals($_SESSION["profile_token"], $_POST["profile_token"])) {
        // Set an error message when the form token is missing or incorrect
        $message = "Please reload the page and try again.";
    // Reject an empty name or a name longer than one hundred characters including Arabic
    } else if ($name == "" || mb_strlen($name) > 100) {
        // Set the message explaining the allowed name length
        $message = "Please enter a name with 1 to 100 characters.";
    // End this condition loop function or class
    }

    // Continue only when there is no error message
    if ($message == "") {
        // Try the database operation so a database error can be handled
        try {
            // Prepare an update for only the name column in users where id matches the current account
            $statement = mysqli_prepare($connection, "UPDATE users SET name = ? WHERE id = ?");
            // Bind the new name as text and the current account id as an integer
            mysqli_stmt_bind_param($statement, "si", $name, $userId);
            // Run the prepared query on the database
            mysqli_stmt_execute($statement);
            // Close this statement after finishing its query
            mysqli_stmt_close($statement);
        // Handle a MySQL error instead of leaving the request without a page message
        } catch (mysqli_sql_exception $exception) {
            // Show a simple message if the name could not be saved
            $message = "Your changes could not be saved. Please try again.";
        // End this condition loop function or class
        }

        // Continue only when there is no error message
        if ($message == "") {
            // Keep a success message in the session for the next page load
            $_SESSION["profile_flash"] = "Your profile was updated.";
            // Open the profile again so refreshing will not submit the same name twice
            header("Location: profile.php");
            // Stop this request so the following code does not run
            exit;
        // End this condition loop function or class
        }
    // End this condition loop function or class
    }
// End this condition loop function or class
}

// Set the browser tab title to Profile
$pageTitle = "Profile";
// Highlight Profile in the shared menu
$activePage = "profile";
// Show the shared page header and navigation menu
include "header.php";
// Continue with the HTML for this page
?>
<!-- Start the main content panel for this account page -->
<section class="panel member-panel">
    <!-- Display the Profile heading -->
    <h2>Profile</h2>
    <!-- Display the View your account details and update your name text -->
    <p class="hint">View your account details and update your name.</p>
    <!-- Check whether a successful name update left a message in the session -->
    <?php if (isset($_SESSION["profile_flash"])) { ?>
        <!-- Display the saved success message safely -->
        <p class="flash"><?php echo passportEscape($_SESSION["profile_flash"]); ?></p>
        <!-- Remove the success message so it is shown only once -->
        <?php unset($_SESSION["profile_flash"]); ?>
    <!-- End this PHP condition or loop before continuing the page -->
    <?php } ?>
    <!-- Show this part only when there is a validation or save error -->
    <?php if ($message != "") { ?>
        <!-- Display the current form error safely -->
        <p class="error"><?php echo passportEscape($message); ?></p>
    <!-- End this PHP condition or loop before continuing the page -->
    <?php } ?>

    <!-- Submit the profile form to this PHP page using POST and use the page validation messages -->
    <form id="profileForm" class="card profile-form" action="profile.php" method="post" novalidate>
        <!-- Send the session token with the form so PHP can check that it belongs to this session -->
        <input type="hidden" name="profile_token" value="<?php echo passportEscape($_SESSION["profile_token"]); ?>">
        <!-- Start the profile icon area -->
        <div class="profile-avatar">
            <!-- Show the coffee cup icon using the shared icon function -->
            <?php echo passportIcon("cup"); ?>
        <!-- Close the div element -->
        </div>
        <!-- Start a paragraph that groups this label and field -->
        <p>
            <!-- Display the Full name label for its input field -->
            <label for="name">Full name</label>
            <!-- Show a pencil button that enables name editing without submitting the form -->
            <button type="button" id="editName" class="edit-name-btn"><?php echo passportIcon("pencil"); ?></button>
            <!-- Show this part only when there is a validation or save error -->
            <?php if ($message != "") { ?>
                <!-- Keep the submitted name editable after an error and limit typing to one hundred characters -->
                <input type="text" id="name" name="name" maxlength="100" class="name-editing" value="<?php echo passportEscape($name); ?>">
            <!-- Show the other section when the previous condition is not met -->
            <?php } else { ?>
                <!-- Show the saved name as read only until the pencil is clicked -->
                <input type="text" id="name" name="name" maxlength="100" readonly value="<?php echo passportEscape($name); ?>">
            <!-- End this PHP condition or loop before continuing the page -->
            <?php } ?>
            <!-- Provide a place for JavaScript to display a name validation message -->
            <span id="nameMsg" class="msg"></span>
        <!-- Close the p element -->
        </p>
        <!-- Start a paragraph that groups this label and field -->
        <p>
            <!-- Display the Email address label for its input field -->
            <label for="accountEmail">Email address</label>
            <!-- Display the email column from users as read only and omit a field name so it is not submitted -->
            <input type="email" id="accountEmail" class="fixed-email" value="<?php echo passportEscape($user["email"]); ?>" readonly>
        <!-- Close the p element -->
        </p>
        <!-- Show this part only when there is a validation or save error -->
        <?php if ($message != "") { ?>
            <!-- Show the save button so the user can correct and submit the name again -->
            <button type="submit" class="btn" id="saveProfile">Save Changes</button>
        <!-- Show the other section when the previous condition is not met -->
        <?php } else { ?>
            <!-- Keep the save button hidden until the pencil is clicked -->
            <button type="submit" class="btn save-hidden" id="saveProfile">Save Changes</button>
        <!-- End this PHP condition or loop before continuing the page -->
        <?php } ?>
    <!-- Close the form element -->
    </form>
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
