<?php
// my_experiences.php - show my experiences (READ) and delete one (DELETE)

session_start();
header("Cache-Control: no-store");

// Check the login session before opening this page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";
require_once "Experience.php";

$userId = $_SESSION["user_id"];

// DELETE: when a Delete button is clicked
if (isset($_POST["delete_id"])) {
    $id = (int) $_POST["delete_id"];

    $statement = mysqli_prepare($connection, "DELETE FROM experiences WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($statement, "ii", $id, $userId);
    mysqli_stmt_execute($statement);

    $_SESSION["flash"] = "Experience deleted.";
    header("Location: my_experiences.php");
    exit;
}

// READ: get my experiences with the café name (INNER JOIN)
$statement = mysqli_prepare($connection,
    "SELECT experiences.id, cafes.name, experiences.drink, experiences.stars, experiences.comment
     FROM experiences INNER JOIN cafes ON experiences.cafe_id = cafes.id
     WHERE experiences.user_id = ?
     ORDER BY experiences.id DESC");
mysqli_stmt_bind_param($statement, "i", $userId);
mysqli_stmt_execute($statement);
mysqli_stmt_bind_result($statement, $id, $cafeName, $drink, $stars, $comment);

$experiences = array();
while (mysqli_stmt_fetch($statement)) {
    $experiences[] = new Experience($id, $cafeName, $drink, $stars, $comment);   // one object per row
}

$pageTitle  = "My Experiences";
$activePage = "mine";
include "header.php";
?>

<section class="panel">
    <h2>My Coffee Experiences</h2>

    <?php if (isset($_SESSION["flash"])) { ?>
        <p class="flash"><?php echo htmlspecialchars($_SESSION["flash"]); ?></p>
        <?php unset($_SESSION["flash"]); ?>
    <?php } ?>

    <p class="hint">Use Edit to update an experience or its rating. <a href="add_experience.php" class="btn small">&#10010; Add Experience</a></p>

    <?php foreach ($experiences as $exp) { ?>
        <article class="card">

            <figure class="card-photo"><span class="big-cup">&#9749;</span></figure>

            <div class="card-text">
                <h3><?php echo htmlspecialchars($exp->getDrink() . " at " . $exp->getCafeName()); ?></h3>
                <p><?php echo $exp->getStars(); ?></p>
                <p><?php echo htmlspecialchars($exp->getComment()); ?></p>

                <div class="actions">
                    <a href="edit_experience.php?id=<?php echo $exp->getId(); ?>" class="btn-light">Edit</a>
                    <form action="my_experiences.php" method="post" class="delete-form"
                          onsubmit="return confirm('Delete this experience?');">
                        <input type="hidden" name="delete_id" value="<?php echo $exp->getId(); ?>">
                        <input type="submit" value="Delete" class="btn-delete">
                    </form>
                </div>
            </div>
        </article>
    <?php } ?>
</section>

    </main>
</body>
</html>
