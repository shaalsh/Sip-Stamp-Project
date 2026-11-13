<?php
// Check that the passport object totals and selected view were loaded by the parent page
if (!isset($passport, $stats, $passportView)) {
    // Stop this request so the following code does not run
    exit;
// End this condition loop function or class
}
// Continue with the HTML for this page
?>
<?php
// Subtract the collected stamp count from the ten stamp goal
$remaining = 10 - $stats["stamps"];
// Check whether the user has collected more than ten stamps
if ($remaining < 0) {
    // Keep the remaining count at zero instead of showing a negative number
    $remaining = 0;
// End this condition loop function or class
}
// Continue with the HTML for this page
?>
<!-- Read the latest ten stamps only when the full passport view is requested -->
<?php if ($passportView == "passport") { $stamps = $passport->getStamps(); ?>
    <!-- Start a white card for this section -->
    <div class="card">
        <!-- Display the Your latest 10 stamps text -->
        <p class="hint">Your latest 10 stamps</p>
        <!-- Group the collected and empty stamp slots -->
        <div class="stamp-list">
            <!-- Repeat one earned stamp slot for each saved stamp -->
            <?php foreach ($stamps as $stamp) { ?>
                <!-- Start a coloured slot for a collected stamp -->
                <div class="stamp-slot earned-stamp">
                    <!-- Show the coffee cup icon using the shared icon function -->
                    <?php echo passportIcon("cup"); ?>
                    <!-- Display the cafe name linked to this stamp safely -->
                    <strong><?php echo passportEscape($stamp["name"]); ?></strong>
                    <!-- Display the stamped_at date from stamps as day month and year -->
                    <small><?php echo passportEscape(date("d M Y", strtotime($stamp["stamped_at"]))); ?></small>
                <!-- Close the div element -->
                </div>
            <!-- End this PHP condition or loop before continuing the page -->
            <?php } ?>
            <!-- Add empty slots until the passport contains ten visible slots -->
            <?php for ($slot = count($stamps); $slot < 10; $slot++) { ?>
                <!-- Start a pale slot for a stamp that has not been collected -->
                <div class="stamp-slot empty-stamp">
                    <!-- Display the empty stamp icon with the Not collected label -->
                    <?php echo passportIcon("stamp"); ?><small>Not collected</small>
                <!-- Close the div element -->
                </div>
            <!-- End this PHP condition or loop before continuing the page -->
            <?php } ?>
        <!-- Close the div element -->
        </div>
    <!-- Close the div element -->
    </div>
<!-- End this PHP condition or loop before continuing the page -->
<?php } ?>
<!-- Store this user's totals in HTML attributes so AJAX can update the dashboard numbers -->
<div class="card passport-progress" data-experiences="<?php echo $stats["experiences"]; ?>" data-cafes="<?php echo $stats["cafes"]; ?>" data-stamps="<?php echo $stats["stamps"]; ?>">
    <!-- Place the collected and remaining totals next to each other -->
    <div class="stamp-totals">
        <!-- Start one box for a stamp total -->
        <div class="stamp-total">
            <!-- Display the total number of stamps collected by this user -->
            <strong><?php echo $stats["stamps"]; ?></strong>
            <!-- Display the Stamps collected text -->
            <span>Stamps collected</span>
        <!-- Close the div element -->
        </div>
        <!-- Start one box for a stamp total -->
        <div class="stamp-total">
            <!-- Display how many stamps remain before the ten stamp goal -->
            <strong><?php echo $remaining; ?></strong>
            <!-- Display the Stamps remaining text -->
            <span>Stamps remaining</span>
        <!-- Close the div element -->
        </div>
    <!-- Close the div element -->
    </div>
    <!-- Check whether the user has reached the first badge at ten stamps -->
    <?php if ($stats["stamps"] >= 10) { ?>
        <!-- Display the earned badge message and stamp icon after the goal is reached -->
        <p class="milestone"><?php echo passportIcon("stamp"); ?> Your first badge is earned — 10 stamps!</p>
    <!-- Show the other section when the previous condition is not met -->
    <?php } else { ?>
        <!-- Display the Your first badge is earned at 10 stamps text -->
        <p class="hint">Your first badge is earned at 10 stamps.</p>
    <!-- End this PHP condition or loop before continuing the page -->
    <?php } ?>
<!-- Close the div element -->
</div>
