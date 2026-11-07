<?php
// edit_experience.php - edit one experience (UPDATE)
// opened like this: edit_experience.php?id=5

session_start();
require_once "db.php";

$userId  = $_SESSION["user_id"];
$message = "";

// the id comes from the URL the first time, and from the hidden field after saving
if (isset($_POST["id"])) {
    $id = (int) $_POST["id"];
} else {
    $id = (int) $_GET["id"];
}

// UPDATE: when the form is submitted
if (isset($_POST["cafe_id"])) {
    $cafeId  = (int) $_POST["cafe_id"];
    $drink   = trim($_POST["drink"]);
    $stars   = (int) $_POST["stars"];
    $comment = trim($_POST["comment"]);

    if ($cafeId <= 0 || $drink == "" || $stars < 1 || $stars > 5 || $comment == "") {
        $message = "Please fill in all the fields.";
    } else {
        $statement = mysqli_prepare($connection,
            "UPDATE experiences SET cafe_id = ?, drink = ?, stars = ?, comment = ? WHERE id = ? AND user_id = ?");
        mysqli_stmt_bind_param($statement, "isisii", $cafeId, $drink, $stars, $comment, $id, $userId);
        mysqli_stmt_execute($statement);

        $_SESSION["flash"] = "Experience updated.";
        header("Location: my_experiences.php");
        exit;
    }
}

// data for the drop-down lists
$cafes  = mysqli_query($connection, "SELECT id, name FROM cafes ORDER BY name");
$drinks = array("Espresso", "Americano", "Cappuccino", "Spanish Latte", "Flat White", "V60", "Coffee of the Day", "Matcha");

// read the saved experience to fill the form
$statement = mysqli_prepare($connection,
    "SELECT cafe_id, drink, stars, comment FROM experiences WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($statement, "ii", $id, $userId);
mysqli_stmt_execute($statement);
mysqli_stmt_bind_result($statement, $curCafe, $curDrink, $curStars, $curComment);

if (!mysqli_stmt_fetch($statement)) {
    $_SESSION["flash"] = "Experience not found.";
    header("Location: my_experiences.php");
    exit;
}

$pageTitle  = "Edit Experience";
$activePage = "mine";
include "header.php";
?>

<section class="panel">
    <h2>Edit Your Coffee Experience</h2>

    <?php if ($message != "") { ?>
        <p class="error"><?php echo $message; ?></p>
    <?php } ?>

    <form id="experienceForm" action="edit_experience.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="photo-column">
            <figure class="photo-preview"><span class="big-cup">&#9749;</span></figure>
        </div>

        <div class="fields-column">
            <p>
                <label for="cafe_id">Café Name</label><br>
                <select id="cafe_id" name="cafe_id">
                    <?php while ($cafe = mysqli_fetch_assoc($cafes)) { ?>
                        <option value="<?php echo $cafe["id"]; ?>" <?php if ($cafe["id"] == $curCafe) { echo "selected"; } ?>><?php echo htmlspecialchars($cafe["name"]); ?></option>
                    <?php } ?>
                </select>
                <span id="cafeMsg" class="msg"></span>
            </p>

            <p>
                <label for="drink">Drink</label><br>
                <select id="drink" name="drink">
                    <?php foreach ($drinks as $d) { ?>
                        <option value="<?php echo $d; ?>" <?php if ($d == $curDrink) { echo "selected"; } ?>><?php echo $d; ?></option>
                    <?php } ?>
                </select>
                <span id="drinkMsg" class="msg"></span>
            </p>

            <p>
                <span class="field-title">Rating</span><br>
                <span class="star" id="star1" onclick="chooseStar(1)">&#9733;</span>
                <span class="star" id="star2" onclick="chooseStar(2)">&#9733;</span>
                <span class="star" id="star3" onclick="chooseStar(3)">&#9733;</span>
                <span class="star" id="star4" onclick="chooseStar(4)">&#9733;</span>
                <span class="star" id="star5" onclick="chooseStar(5)">&#9733;</span>
                <input type="hidden" id="stars" name="stars" value="<?php echo $curStars; ?>">
                <span id="starsMsg" class="msg"></span>
            </p>

            <p>
                <label for="comment">Your Review</label><br>
                <textarea id="comment" name="comment" rows="4"><?php echo htmlspecialchars($curComment); ?></textarea>
                <span id="commentMsg" class="msg"></span>
            </p>

            <input type="submit" value="Save Changes" class="btn">
            <p class="cancel"><a href="my_experiences.php" class="btn-light">Cancel</a></p>
        </div>
    </form>
</section>

    </main>
</body>
</html>
