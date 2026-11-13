<?php

// Define the class used to read the coffee passport data
class CoffeePassport {
    // Keep the MySQL connection inside this class
    private $connection;
    // Keep the current user id inside this class
    private $userId;

    // Receive the database connection and user id when the object is created
    public function __construct($connection, $userId) {
        // Save the supplied MySQL connection in the object
        $this->connection = $connection;
        // Save the supplied user id in the object
        $this->userId = $userId;
    // End this condition loop function or class
    }

    // Define the method that returns this user's experience cafe and stamp totals
    public function getStats() {
        // Prepare a query for cafe_id in experiences belonging to this user
        $statement = mysqli_prepare($this->connection, "SELECT cafe_id FROM experiences WHERE user_id = ?");
        // Bind the user id stored in this object as an integer
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        // Run the prepared query on the database
        mysqli_stmt_execute($statement);
        // Read the selected cafe_id column into the cafe id variable
        mysqli_stmt_bind_result($statement, $cafeId);
        // Start the experience count at zero
        $experiences = 0;
        // Start an empty list for the different cafes visited
        $cafes = array();
        // Read each row returned by this prepared query
        while (mysqli_stmt_fetch($statement)) {
            // Add one for the experience in the current row
            $experiences++;
            // Check that this cafe id has not already been counted
            if (!in_array($cafeId, $cafes)) {
                // Add this cafe id once to the list of different cafes visited
                $cafes[] = $cafeId;
            // End this condition loop function or class
            }
        // End this condition loop function or class
        }
        // Close this statement after finishing its query
        mysqli_stmt_close($statement);

        // Prepare the following query using the database connection stored in this object
        $statement = mysqli_prepare($this->connection,
            // Count stamps after joining stamps experience_id to experiences id and filtering by user_id
            "SELECT COUNT(*) FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             WHERE experiences.user_id = ?");
        // Bind the user id stored in this object as an integer
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        // Run the prepared query on the database
        mysqli_stmt_execute($statement);
        // Read the stamp total from the query into the stamp count variable
        mysqli_stmt_bind_result($statement, $stampCount);
        // Fetch the single row containing the total stamp count
        mysqli_stmt_fetch($statement);
        // Close this statement after finishing its query
        mysqli_stmt_close($statement);

        // Return the experience total different cafe total and stamp total together
        return array("experiences" => $experiences, "cafes" => count($cafes), "stamps" => $stampCount);
    // End this condition loop function or class
    }

    // Define the method that reads the latest three experiences for this user
    public function getRecentExperiences() {
        // Prepare the following query using the database connection stored in this object
        $statement = mysqli_prepare($this->connection,
            // Read cafes name and experiences drink stars and date by cafe_id and user_id with the newest experience id first
            "SELECT cafes.name, experiences.drink, experiences.stars, experiences.date
             FROM experiences INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY experiences.id DESC");
        // Bind the user id stored in this object as an integer
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        // Run the prepared query on the database
        mysqli_stmt_execute($statement);
        // Read the cafe name drink stars and experience date into separate variables
        mysqli_stmt_bind_result($statement, $name, $drink, $stars, $date);
        // Start an empty array for the rows that will be shown on the page
        $rows = array();
        // Read each row returned by this prepared query
        while (mysqli_stmt_fetch($statement)) {
            // Add the cafe name drink rating and date as one experience in the result array
            $rows[] = array("name" => $name, "drink" => $drink, "stars" => $stars, "date" => $date);
            // Check whether the latest three experiences have been collected
            if (count($rows) == 3) {
                // Stop the loop after reaching the required number of rows
                break;
            // End this condition loop function or class
            }
        // End this condition loop function or class
        }
        // Close this statement after finishing its query
        mysqli_stmt_close($statement);
        // Return the collected rows to the page that called this method
        return $rows;
    // End this condition loop function or class
    }

    // Define the method that reads the latest ten stamps for this user
    public function getStamps() {
        // Prepare the following query using the database connection stored in this object
        $statement = mysqli_prepare($this->connection,
            // Read cafes name and stamps stamped_at by joining experience_id to experiences id and cafe_id to cafes id with the newest stamp id first
            "SELECT cafes.name, stamps.stamped_at FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY stamps.id DESC");
        // Bind the user id stored in this object as an integer
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        // Run the prepared query on the database
        mysqli_stmt_execute($statement);
        // Read the cafe name and stamped_at date into separate variables
        mysqli_stmt_bind_result($statement, $name, $stampedAt);
        // Start an empty array for the rows that will be shown on the page
        $rows = array();
        // Read each row returned by this prepared query
        while (mysqli_stmt_fetch($statement)) {
            // Add this cafe name and stamp date to the stamp list
            $rows[] = array("name" => $name, "stamped_at" => $stampedAt);
            // Check whether the latest ten stamps have been collected
            if (count($rows) == 10) {
                // Stop the loop after reaching the required number of rows
                break;
            // End this condition loop function or class
            }
        // End this condition loop function or class
        }
        // Close this statement after finishing its query
        mysqli_stmt_close($statement);
        // Return the collected rows to the page that called this method
        return $rows;
    // End this condition loop function or class
    }

// End this condition loop function or class
}
