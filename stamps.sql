-- Create the stamps table without changing the existing tables
CREATE TABLE IF NOT EXISTS stamps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    experience_id INT NOT NULL UNIQUE,
    stamped_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (experience_id) REFERENCES experiences(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Add a stamp for each existing experience that does not already have one
INSERT INTO stamps (experience_id, stamped_at)
SELECT experiences.id, experiences.date
FROM experiences LEFT JOIN stamps ON stamps.experience_id = experiences.id
WHERE stamps.id IS NULL;
