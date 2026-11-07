<?php
// add_experience.php - add a new coffee experience (CREATE)

session_start();
require_once "db.php";

$message = "";

// when the form is submitted
if (isset($_POST["cafe_id"])) {
    $cafeId  = (int) $_POST["cafe_id"];
    $drink   = trim($_POST["drink"]);
    $stars   = (int) $_POST["stars"];
    $comment = trim($_POST["comment"]);
    $userId  = $_SESSION["user_id"];

    if ($cafeId <= 0 || $drink == "" || $stars < 1 || $stars > 5 || $comment == "") {
        $message = "Please fill in all the fields.";
    } else {
        // INSERT with a prepared statement
        $statement = mysqli_prepare($connection,
            "INSERT INTO experiences (user_id, cafe_id, drink, stars, comment) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement, "iisis", $userId, $cafeId, $drink, $stars, $comment);
        mysqli_stmt_execute($statement);

        // STUDENT 4: add the stamp for this experience here

        $_SESSION["flash"] = "Your experience was added.";
        header("Location: my_experiences.php");
        exit;
    }
}

// data for the drop-down lists
$cafes  = mysqli_query($connection, "SELECT id, name FROM cafes ORDER BY name");
$drinks = array("Espresso", "Americano", "Cappuccino", "Spanish Latte", "Flat White", "V60", "Coffee of the Day", "Matcha");

$pageTitle  = "Add Experience";
$activePage = "add";
include "header.php";
?>

<section class="panel">
    <h2>Add Your Coffee Experience</h2>

    <?php if ($message != "") { ?>
        <p class="error"><?php echo $message; ?></p>
    <?php } ?>

    <form id="experienceForm" action="add_experience.php" method="post">

        <div class="photo-column">
            <figure class="photo-preview"><span class="big-cup">&#9749;</span></figure>
        </div>

        <div class="fields-column">
            <p>
                <label for="cafe_id">Café Name</label><br>
                <select id="cafe_id" name="cafe_id">
                    <option value="">-- Choose a café --</option>
                    <?php while ($cafe = mysqli_fetch_assoc($cafes)) { ?>
                        <option value="<?php echo $cafe["id"]; ?>"><?php echo htmlspecialchars($cafe["name"]); ?></option>
                    <?php } ?>
                </select>
                <span id="cafeMsg" class="msg"></span>
            </p>

            <p>
                <label for="drink">Drink</label><br>
                <select id="drink" name="drink">
                    <option value="">-- Choose a drink --</option>
                    <?php foreach ($drinks as $d) { ?>
                        <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
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
                <input type="hidden" id="stars" name="stars" value="0">
                <span id="starsMsg" class="msg"></span>
            </p>

            <p>
                <label for="comment">Your Review</label><br>
                <textarea id="comment" name="comment" rows="4" placeholder="Write your thoughts..."></textarea>
                <span id="commentMsg" class="msg"></span>
            </p>

            <input type="submit" value="Save Experience" class="btn">
        </div>
    </form>
</section>

    </main>
</body>
</html>
