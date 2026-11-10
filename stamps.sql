-- Create the stamps table without removing existing tables.
CREATE TABLE IF NOT EXISTS stamps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    experience_id INT NOT NULL UNIQUE,
    stamped_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (experience_id) REFERENCES experiences(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Give existing experiences their stamps too. Running this again does not repeat them.
INSERT INTO stamps (experience_id, stamped_at)
SELECT experiences.id, experiences.date
FROM experiences LEFT JOIN stamps ON stamps.experience_id = experiences.id
WHERE stamps.id IS NULL;
