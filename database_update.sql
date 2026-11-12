-- Update the existing sip_stamp tables without replacing their rows
USE sip_stamp;

ALTER DATABASE sip_stamp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE cafes CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE experiences CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE favorites CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE stamps CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Link user_id in favorites to id in users
ALTER TABLE favorites
    ADD CONSTRAINT favorites_user_fk FOREIGN KEY (user_id)
    REFERENCES users (id) ON DELETE CASCADE;

-- Remove the unused profile image column from users
ALTER TABLE users DROP COLUMN profile_pic;
