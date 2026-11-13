<?php
// favorites.php - show the cafes saved by this user
require_once "require_login.php";
require_once "db.php";
$pageTitle = "Favorites";
$activePage = "favorites";
$userId = $_SESSION["user_id"];

// Get this user's favorite cafes (INNER JOIN)
$stmt = mysqli_prepare($connection,
    "SELECT cafes.id, cafes.name, cafes.city, cafes.description
     FROM cafes INNER JOIN favorites ON cafes.id = favorites.cafe_id
     WHERE favorites.user_id = ? ORDER BY cafes.name");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $name, $city, $description);

$cafes = array();
while (mysqli_stmt_fetch($stmt)) {
    $cafes[] = array("id" => $id, "name" => $name, "city" => $city, "description" => $description);
}
mysqli_stmt_close($stmt);
include "header.php";
?>
<section class="panel">
    <h2>My Favorites ♥</h2>
    <p class="hint">Your favorite coffee places in one spot.</p>
    <p id="favoriteMessage" class="hint"></p>
    <div class="cafe-list">
    <?php foreach ($cafes as $cafe) { ?>
        <article class="card cafe-item" id="cafe<?php echo $cafe['id']; ?>">
            <div class="card-photo cafe-emoji">♥</div>
            <div class="card-text cafe-info">
                <h3><?php echo htmlspecialchars($cafe['name']); ?></h3>
                <p><?php echo htmlspecialchars($cafe['city']); ?></p>
                <p><?php echo htmlspecialchars($cafe['description']); ?></p>
                <button type="button" class="btn small favorite-btn" data-cafe="<?php echo $cafe['id']; ?>" data-page="favorites">♥ Remove Favorite</button>
            </div>
        </article>
    <?php } ?>
    </div>
    <p class="hint"><a href="explore.php">Explore more cafés</a></p>
</section>
<script src="cafes.js"></script>
</main></body></html>
