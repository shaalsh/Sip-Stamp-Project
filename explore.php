<?php
// explore.php - show cafes and search by name or city
require_once "require_login.php";
require_once "db.php";
$pageTitle = "Explore Cafés";
$activePage = "cafes";
$userId = (int) $_SESSION["user_id"];

// Read cafes and check which ones are already favorites
$sql = "SELECT cafes.*, favorites.id AS favorite_id FROM cafes
        LEFT JOIN favorites ON cafes.id = favorites.cafe_id AND favorites.user_id = ?
        ORDER BY cafes.name";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
include "header.php";
?>
<section class="panel">
    <h2>Explore Cafés ☕</h2>
    <p class="hint">Find your next coffee spot!</p>
    <input class="cafe-search" type="text" id="cafeSearch" placeholder="Search by café or city...">
    <p id="favoriteMessage" class="hint"></p>
    <div class="cafe-list">
    <?php while ($cafe = mysqli_fetch_assoc($result)) { ?>
        <article class="card cafe-item" data-search="<?php echo htmlspecialchars(strtolower($cafe['name'].' '.$cafe['city']), ENT_QUOTES); ?>">
            <div class="card-photo cafe-emoji">☕</div>
            <div class="card-text cafe-info">
                <h3><?php echo htmlspecialchars($cafe['name']); ?></h3>
                <p><?php echo htmlspecialchars($cafe['city']); ?></p>
                <p><?php echo htmlspecialchars($cafe['description'] ?? ''); ?></p>
                <button type="button" class="btn small favorite-btn" data-cafe="<?php echo (int)$cafe['id']; ?>">
                    <?php echo $cafe['favorite_id'] ? '♥ Remove Favorite' : '♡ Add Favorite'; ?>
                </button>
            </div>
        </article>
    <?php } ?>
    </div>
    <p id="noCafes" class="hint" style="display:none">No cafés found.</p>
</section>
<script src="cafes.js"></script>
</main></body></html>
