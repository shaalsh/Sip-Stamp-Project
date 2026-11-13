<?php
// favorites.php - show the cafes saved by this user
session_start();
// Demo user for testing Student 2 without the login module.
if (!isset($_SESSION["user_id"])) { $_SESSION["user_id"] = 1; }
require_once "db.php";
$pageTitle = "Favorites";
$activePage = "favorites";
$userId = (int) $_SESSION["user_id"];

$sql = "SELECT cafes.* FROM cafes INNER JOIN favorites ON cafes.id = favorites.cafe_id
        WHERE favorites.user_id = ? ORDER BY cafes.name";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
include "header.php";
?>
<section class="panel">
    <h2>My Favorites ♥</h2>
    <p class="hint">Your favorite coffee places in one spot.</p>
    <p id="favoriteMessage" class="hint"></p>
    <div class="cafe-list">
    <?php while ($cafe = mysqli_fetch_assoc($result)) { ?>
        <article class="card cafe-item">
            <div class="card-photo cafe-emoji">♥</div>
            <div class="card-text cafe-info">
                <h3><?php echo htmlspecialchars($cafe['name']); ?></h3>
                <p><?php echo htmlspecialchars($cafe['city']); ?></p>
                <p><?php echo htmlspecialchars($cafe['description'] ?? ''); ?></p>
                <button type="button" class="btn small favorite-btn" data-cafe="<?php echo (int)$cafe['id']; ?>">♥ Remove Favorite</button>
            </div>
        </article>
    <?php } ?>
    </div>
    <p class="hint"><a href="explore.php">Explore more cafés</a></p>
</section>
<script src="cafes.js"></script>
</main></body></html>
