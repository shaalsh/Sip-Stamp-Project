<?php
// Save a new coffee experience

session_start();

// Lab 8: only a logged-in user can open this page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "db.php";

$message = "";

// Read the experience details when the form is submitted
if (isset($_POST["cafe_id"])) {
    $cafeId  = (int) $_POST["cafe_id"];
    $drink   = trim($_POST["drink"]);
    $stars   = (int) $_POST["stars"];
    $comment = trim($_POST["comment"]);
    $userId  = $_SESSION["user_id"];

    if ($cafeId <= 0 || $drink == "" || $stars < 1 || $stars > 5 || $comment == "") {
        $message = "Please fill in all the fields.";
    } else {
        // Save the experience and its stamp together so both are added successfully
        mysqli_begin_transaction($connection);
        try {
            $statement = mysqli_prepare($connection,
                "INSERT INTO experiences (user_id, cafe_id, drink, stars, comment) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($statement, "iisis", $userId, $cafeId, $drink, $stars, $comment);
            mysqli_stmt_execute($statement);
            $experienceId = mysqli_insert_id($connection);
            mysqli_stmt_close($statement);

            // Save the new id from experiences in experience_id in the stamps table
            $statement = mysqli_prepare($connection, "INSERT INTO stamps (experience_id) VALUES (?)");
            mysqli_stmt_bind_param($statement, "i", $experienceId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_commit($connection);

            $_SESSION["flash"] = "Your experience was added and you earned a stamp.";
            header("Location: my_experiences.php");
            exit;
        } catch (mysqli_sql_exception $exception) {
            mysqli_rollback($connection);
            $message = "Your experience could not be saved. Please try again.";
        }
    }
}

// Get the cafes and drinks shown in the dropdown lists
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
