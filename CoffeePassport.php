<?php

class CoffeePassport {
    private $connection;
    private $userId;

    public function __construct($connection, $userId) {
        $this->connection = $connection;
        $this->userId = $userId;
    }

    public function getStats() {
        // Count this user's experiences and the different cafes they visited
        $statement = mysqli_prepare($this->connection, "SELECT cafe_id FROM experiences WHERE user_id = ?");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $cafeId);
        $experiences = 0;
        $cafes = array();
        while (mysqli_stmt_fetch($statement)) {
            $experiences++;
            if (!in_array($cafeId, $cafes)) {
                $cafes[] = $cafeId;
            }
        }
        mysqli_stmt_close($statement);

        // Link experience_id in stamps to id in experiences to count stamps for this user
        $statement = mysqli_prepare($this->connection,
            "SELECT COUNT(*) FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             WHERE experiences.user_id = ?");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $stampCount);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);

        return array("experiences" => $experiences, "cafes" => count($cafes), "stamps" => $stampCount);
    }

    public function getRecentExperiences() {
        // The 3 newest experiences with the cafe name
        $statement = mysqli_prepare($this->connection,
            "SELECT cafes.name, experiences.drink, experiences.stars, experiences.date
             FROM experiences INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY experiences.id DESC");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $name, $drink, $stars, $date);
        $rows = array();
        while (mysqli_stmt_fetch($statement)) {
            $rows[] = array("name" => $name, "drink" => $drink, "stars" => $stars, "date" => $date);
            if (count($rows) == 3) {
                break;
            }
        }
        mysqli_stmt_close($statement);
        return $rows;
    }

    public function getStamps() {
        // The 10 newest stamps with the cafe name from the linked experience
        $statement = mysqli_prepare($this->connection,
            "SELECT cafes.name, stamps.stamped_at FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY stamps.id DESC");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $name, $stampedAt);
        $rows = array();
        while (mysqli_stmt_fetch($statement)) {
            $rows[] = array("name" => $name, "stamped_at" => $stampedAt);
            if (count($rows) == 10) {
                break;
            }
        }
        mysqli_stmt_close($statement);
        return $rows;
    }

}
