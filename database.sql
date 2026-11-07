-- =============================================================
-- SipStamp - database (ONLINE: import it in freesqldatabase phpMyAdmin)
-- -------------------------------------------------------------
-- The "users" and "cafes" tables here are TEMPORARY copies so I can
-- test my pages now. When Student 1 and Student 2 finish, we import
-- the group's final database.sql instead (same table names/columns).
-- Chapter 6: tables, primary keys, foreign keys, data types, INSERT
-- =============================================================


USE sql7839974;                  -- our online database (from the FreeSQLDatabase email)

-- delete the old tables first, so importing again does not repeat rows
DROP TABLE IF EXISTS experiences;
DROP TABLE IF EXISTS cafes;
DROP TABLE IF EXISTS users;

-- -------------------------------------------------------------
-- TEMPORARY: users table (owner: Student 1)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,  -- primary key: unique number for each user
    name        VARCHAR(100) NOT NULL,           -- user's name
    email       VARCHAR(100) NOT NULL,           -- user's email
    password    VARCHAR(255) NOT NULL,           -- password
    profile_pic VARCHAR(255)                     -- path of the profile picture (can be empty)
);

-- -------------------------------------------------------------
-- TEMPORARY: cafes table (owner: Student 2)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cafes (
    id          INT AUTO_INCREMENT PRIMARY KEY,  -- primary key
    name        VARCHAR(100) NOT NULL,           -- café name
    city        VARCHAR(50)  NOT NULL,           -- city
    description VARCHAR(255),                    -- short description
    image       VARCHAR(255)                     -- path of the café picture
);

-- -------------------------------------------------------------
-- MY TABLE: experiences (owner: Student 3)
-- One user  -> many experiences   (one-to-many)
-- One café  -> many experiences   (one-to-many)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS experiences (
    id       INT AUTO_INCREMENT PRIMARY KEY,         -- primary key
    user_id  INT NOT NULL,                           -- foreign key -> users.id (who wrote it)
    cafe_id  INT NOT NULL,                           -- foreign key -> cafes.id (which café)
    drink    VARCHAR(50)  NOT NULL,                  -- the drink, e.g. "Spanish Latte"
    stars    INT NOT NULL,                           -- rating from 1 to 5
    comment  VARCHAR(500) NOT NULL,                  -- the review text
    date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    -- when it was added (filled automatically)
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,  -- delete user -> delete her experiences
    FOREIGN KEY (cafe_id) REFERENCES cafes(id) ON DELETE CASCADE   -- delete café -> delete its experiences
);

-- -------------------------------------------------------------
-- Test data (Chapter 6: INSERT)
-- -------------------------------------------------------------
INSERT INTO users (name, email, password) VALUES
('Test User', 'test@pnu.edu.sa', '1234');        -- user id 1 (the one we pretend is logged in)

INSERT INTO cafes (name, city, description) VALUES
('Brew92',              'Riyadh', 'Olaya - famous for its Spanish Latte, industrial interiors, good for studying'),
('Elixir Bunn',         'Riyadh', 'Al Olaya - specialty roastery known for V60 and cold brew'),
('Camel Step',          'Riyadh', 'Hittin & Al Malqa - seasonal single-origin beans, flat white and pour-over'),
('Overdose',            'Riyadh', 'Known for hot chocolate topped with a chocolate bar and whipped cream'),
('Half Million',        'Riyadh', 'Specialty coffee chain - V60, cold brew and the Coffee Crunch dessert'),
('Dose Cafe',           'Riyadh', 'Popular chain for Spanish Latte, good for working'),
('Draft Cafe',          'Riyadh', 'Olaya - calm space, good for working'),
('% Arabica',           'Riyadh', 'White marble interior, known for the Kyoto Latte'),
('Hustle n Flow',       'Riyadh', 'Al Malqa - warehouse style, charcoal and blue spirulina lattes'),
('Namq',                'Riyadh', 'Al Malqa & Hittin - reflecting pool, modern Arabic design, brunch'),
('Takya Cafe',          'Riyadh', 'Known for the Saffron Qahwa Latte'),
('Fabrica de Cafe',     'Riyadh', 'Hittin & An Nakheel - matcha drinks, fudgy cookies and tiramisu'),
('Kuro',                'Riyadh', 'Midtown Plaza - Japanese cafe, fluffy pancakes and matcha'),
('Ralph''s Coffee',     'Riyadh', 'KAFD - classic American cafe with a terrace');

INSERT INTO experiences (user_id, cafe_id, drink, stars, comment) VALUES
(1, 1, 'Spanish Latte', 5, 'Perfect sweetness and very smooth.'),
(1, 2, 'V60',           4, 'Clean and fruity, very refreshing.');
