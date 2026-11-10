<?php
if (!isset($passport, $stats, $passportView)) {
    http_response_code(404);
    exit;
}
?>
<?php if ($passportView == "passport") { $stamps = $passport->getStamps(); ?>
    <div class="card">
        <p class="hint">Your latest 10 stamps</p>
        <div class="stamp-list">
            <?php foreach ($stamps as $stamp) { ?>
                <div class="stamp-slot earned-stamp">
                    <?php echo passportIcon("cup"); ?>
                    <strong><?php echo passportEscape($stamp["name"]); ?></strong>
                    <small><?php echo passportEscape(date("d M Y", strtotime($stamp["stamped_at"]))); ?></small>
                </div>
            <?php } ?>
            <?php for ($slot = count($stamps); $slot < 10; $slot++) { ?>
                <div class="stamp-slot empty-stamp">
                    <?php echo passportIcon("stamp"); ?><small>Not collected</small>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<div class="card passport-progress" data-experiences="<?php echo $stats["experiences"]; ?>" data-cafes="<?php echo $stats["cafes"]; ?>" data-stamps="<?php echo $stats["stamps"]; ?>">
    <div class="stamp-totals">
        <div class="stamp-total">
            <strong><?php echo $stats["stamps"]; ?></strong>
            <span>Stamps collected</span>
        </div>
        <div class="stamp-total">
            <strong><?php echo max(0, 10 - $stats["stamps"]); ?></strong>
            <span>Stamps remaining</span>
        </div>
    </div>
    <?php if ($stats["stamps"] >= 10) { ?>
        <p class="milestone"><?php echo passportIcon("stamp"); ?> Your first badge is earned — 10 stamps!</p>
    <?php } else { ?>
        <p class="hint">Your first badge is earned at 10 stamps.</p>
    <?php } ?>
</div>
