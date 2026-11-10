<?php

class CoffeePassport {
    private $connection;
    private $userId;

    public function __construct($connection, $userId) {
        $this->connection = $connection;
        $this->userId = $userId;
    }

    public function getStats() {
        // Use user_id in experiences to count the experiences and different cafes for this user
        $statement = mysqli_prepare($this->connection,
            "SELECT COUNT(*) AS experiences, COUNT(DISTINCT cafe_id) AS cafes
             FROM experiences WHERE user_id = ?");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        $stats = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
        mysqli_stmt_close($statement);

        // Link experience_id in stamps to id in experiences to count stamps for this user
        $statement = mysqli_prepare($this->connection,
            "SELECT COUNT(*) AS total FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             WHERE experiences.user_id = ?");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
        mysqli_stmt_close($statement);
        $stats["stamps"] = (int) $row["total"];
        $stats["experiences"] = (int) $stats["experiences"];
        $stats["cafes"] = (int) $stats["cafes"];
        return $stats;
    }

    public function getRecentExperiences() {
        $statement = mysqli_prepare($this->connection,
            "SELECT cafes.name, experiences.drink, experiences.stars, experiences.date
             FROM experiences INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY experiences.date DESC, experiences.id DESC LIMIT 3");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        $rows = mysqli_fetch_all(mysqli_stmt_get_result($statement), MYSQLI_ASSOC);
        mysqli_stmt_close($statement);
        return $rows;
    }

    public function getStamps() {
        // Get the cafe name from the experience linked to each stamp
        $statement = mysqli_prepare($this->connection,
            "SELECT cafes.name, stamps.stamped_at FROM stamps
             INNER JOIN experiences ON stamps.experience_id = experiences.id
             INNER JOIN cafes ON experiences.cafe_id = cafes.id
             WHERE experiences.user_id = ? ORDER BY stamps.stamped_at DESC, stamps.id DESC LIMIT 10");
        mysqli_stmt_bind_param($statement, "i", $this->userId);
        mysqli_stmt_execute($statement);
        $rows = mysqli_fetch_all(mysqli_stmt_get_result($statement), MYSQLI_ASSOC);
        mysqli_stmt_close($statement);
        return $rows;
    }

}
