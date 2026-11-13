<?php
// explore.php - show cafes and search by name or city
require_once "require_login.php";
require_once "db.php";
$pageTitle = "Explore Cafés";
$activePage = "cafes";
$userId = $_SESSION["user_id"];

// Get the ids of the cafes this user already saved as favorites
$favorites = array();
$stmt = mysqli_prepare($connection, "SELECT cafe_id FROM favorites WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $favoriteCafeId);
while (mysqli_stmt_fetch($stmt)) {
    $favorites[] = $favoriteCafeId;
}
mysqli_stmt_close($stmt);

// Read all the cafes
$result = mysqli_query($connection, "SELECT id, name, city, description FROM cafes ORDER BY name");
include "header.php";
?>
<section class="panel">
    <h2>Explore Cafés ☕</h2>
    <p class="hint">Find your next coffee spot!</p>
    <input class="cafe-search" type="text" id="cafeSearch" placeholder="Search by café or city...">
    <p id="favoriteMessage" class="hint"></p>
    <div class="cafe-list">
    <?php while ($cafe = mysqli_fetch_assoc($result)) { ?>
        <article class="card cafe-item" data-search="<?php echo htmlspecialchars($cafe['name'] . ' ' . $cafe['city']); ?>">
            <div class="card-photo cafe-emoji">☕</div>
            <div class="card-text cafe-info">
                <h3><?php echo htmlspecialchars($cafe['name']); ?></h3>
                <p><?php echo htmlspecialchars($cafe['city']); ?></p>
                <p><?php echo htmlspecialchars($cafe['description']); ?></p>
                <button type="button" class="btn small favorite-btn" data-cafe="<?php echo $cafe['id']; ?>">
                    <?php if (in_array($cafe['id'], $favorites)) { echo '♥ Remove Favorite'; } else { echo '♡ Add Favorite'; } ?>
                </button>
            </div>
        </article>
    <?php } ?>
    </div>
    <p id="noCafes" class="hint no-cafes">No cafés found.</p>
</section>
<script src="cafes.js"></script>
</main></body></html>
