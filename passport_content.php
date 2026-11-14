<?php
// Check that the passport object totals and selected view were loaded by the parent page
if (!isset($passport, $stats, $passportView)) {
    exit;
}
?>
<?php
// Subtract the collected stamp count from the ten stamp goal
$remaining = 10 - $stats["stamps"];
// Check whether the user has collected more than ten stamps
if ($remaining < 0) {
    $remaining = 0;
}
?>
<!-- Read the latest ten stamps only when the full passport view is requested -->
<?php if ($passportView == "passport") { $stamps = $passport->getStamps(); ?>
    <div class="card">
        <p class="hint">Your latest 10 stamps</p>
        <div class="stamp-list">
            <!-- Repeat one earned stamp slot for each saved stamp -->
            <?php foreach ($stamps as $stamp) { ?>
                <div class="stamp-slot earned-stamp">
                    <?php echo passportIcon("cup"); ?>
                    <strong><?php echo passportEscape($stamp["name"]); ?></strong>
                    <small><?php echo passportEscape($stamp["stamped_at"]); ?></small>
                </div>
            <?php } ?>
            <!-- Add empty slots until the passport contains ten visible slots -->
            <?php for ($slot = count($stamps); $slot < 10; $slot++) { ?>
                <div class="stamp-slot empty-stamp">
                    <?php echo passportIcon("stamp"); ?><small>Not collected</small>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<!-- Keep the totals in hidden inputs for the AJAX dashboard update -->
<input type="hidden" id="totalExperiences" value="<?php echo $stats["experiences"]; ?>">
<input type="hidden" id="totalCafes" value="<?php echo $stats["cafes"]; ?>">
<input type="hidden" id="totalStamps" value="<?php echo $stats["stamps"]; ?>">
<div class="card passport-progress">
    <div class="stamp-totals">
        <div class="stamp-total">
            <strong><?php echo $stats["stamps"]; ?></strong>
            <span>Stamps collected</span>
        </div>
        <div class="stamp-total">
            <strong><?php echo $remaining; ?></strong>
            <span>Stamps remaining</span>
        </div>
    </div>
    <!-- Check whether the user has reached the first badge at ten stamps -->
    <?php if ($stats["stamps"] >= 10) { ?>
        <p class="milestone"><?php echo passportIcon("stamp"); ?> Your first badge is earned — 10 stamps!</p>
    <?php } else { ?>
        <p class="hint">Your first badge is earned at 10 stamps.</p>
    <?php } ?>
</div>
