<?php

class CoffeePassport {
    private $connection;
    private $userId;

    // Receive the database connection and user id when the object is created
    public function __construct($connection, $userId) {
        $this->connection = $connection;
        $this->userId = $userId;
    }

    // Define the method that returns this user's experience cafe and stamp totals
    public function getStats() {
        // Prepare a query for cafe_id in experiences belonging to this user
        $statement = $this->connection->prepare("SELECT cafe_id FROM experiences WHERE user_id = ?");
        $statement->execute(array($this->userId));
        $experiences = 0;
        $cafes = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $cafeId = $row["cafe_id"];
            $experiences++;
            // Check that this cafe id has not already been counted
            if (!in_array($cafeId, $cafes)) {
                $cafes[] = $cafeId;
            }
        }

        // Prepare the following query using the database connection stored in this object
        $statement = $this->connection->prepare(
            // Count stamps after joining stamps experience_id to experiences id and filtering by user_id
            "SELECT COUNT(*) AS total FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             WHERE experiences.user_id = ?");
        $statement->execute(array($this->userId));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $stampCount = $row["total"];

        // Return the experience total different cafe total and stamp total together
        return array("experiences" => $experiences, "cafes" => count($cafes), "stamps" => $stampCount);
    }

    // Define the method that reads the latest three experiences for this user
    public function getRecentExperiences() {
        // Prepare the following query using the database connection stored in this object
        $statement = $this->connection->prepare(
            // Read cafes name and experiences drink stars and date by cafe_id and user_id with the newest experience id first
            "SELECT cafes.name, experiences.drink, experiences.stars, experiences.date
             FROM experiences INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY experiences.id DESC");
        $statement->execute(array($this->userId));
        $rows = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
            // Check whether the latest three experiences have been collected
            if (count($rows) == 3) {
                break;
            }
        }
        return $rows;
    }

    // Define the method that reads the latest ten stamps for this user
    public function getStamps() {
        // Prepare the following query using the database connection stored in this object
        $statement = $this->connection->prepare(
            // Read cafes name and stamps stamped_at by joining experience_id to experiences id and cafe_id to cafes id with the newest stamp id first
            "SELECT cafes.name, stamps.stamped_at FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY stamps.id DESC");
        $statement->execute(array($this->userId));
        $rows = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
            // Check whether the latest ten stamps have been collected
            if (count($rows) == 10) {
                break;
            }
        }
        return $rows;
    }

}
