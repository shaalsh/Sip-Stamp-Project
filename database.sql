-- Sip Stamp local database
CREATE DATABASE IF NOT EXISTS sip_stamp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sip_stamp;

-- Sip Stamp saved database snapshot with stamps

-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql7.freesqldatabase.com
-- Generation Time: Nov 10, 2026 at 01:40 PM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql7839974`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE `cafes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`id`, `name`, `city`, `description`, `image`) VALUES
(1, 'Brew92', 'Riyadh', 'Olaya - famous for its Spanish Latte, industrial interiors, good for studying', NULL),
(2, 'Elixir Bunn', 'Riyadh', 'Al Olaya - specialty roastery known for V60 and cold brew', NULL),
(3, 'Camel Step', 'Riyadh', 'Hittin & Al Malqa - seasonal single-origin beans, flat white and pour-over', NULL),
(4, 'Overdose', 'Riyadh', 'Known for hot chocolate topped with a chocolate bar and whipped cream', NULL),
(5, 'Half Million', 'Riyadh', 'Specialty coffee chain - V60, cold brew and the Coffee Crunch dessert', NULL),
(6, 'Dose Cafe', 'Riyadh', 'Popular chain for Spanish Latte, good for working', NULL),
(7, 'Draft Cafe', 'Riyadh', 'Olaya - calm space, good for working', NULL),
(8, '% Arabica', 'Riyadh', 'White marble interior, known for the Kyoto Latte', NULL),
(9, 'Hustle n Flow', 'Riyadh', 'Al Malqa - warehouse style, charcoal and blue spirulina lattes', NULL),
(10, 'Namq', 'Riyadh', 'Al Malqa & Hittin - reflecting pool, modern Arabic design, brunch', NULL),
(11, 'Takya Cafe', 'Riyadh', 'Known for the Saffron Qahwa Latte', NULL),
(12, 'Fabrica de Cafe', 'Riyadh', 'Hittin & An Nakheel - matcha drinks, fudgy cookies and tiramisu', NULL),
(13, 'Kuro', 'Riyadh', 'Midtown Plaza - Japanese cafe, fluffy pancakes and matcha', NULL),
(14, 'Ralph\'s Coffee', 'Riyadh', 'KAFD - classic American cafe with a terrace', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `drink` varchar(50) NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `cafe_id`, `drink`, `stars`, `comment`, `date`) VALUES
(1, 1, 1, 'Spanish Latte', 5, 'Perfect sweetness and very smooth.', '2026-11-06 13:34:19'),
(2, 1, 2, 'V60', 4, 'Clean and fruity, very refreshing.', '2026-11-06 13:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_pic`) VALUES
(1, 'Test User', 'test@pnu.edu.sa', '1234', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cafes`
--
ALTER TABLE `cafes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `one_favorite` (`user_id`,`cafe_id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `experiences_ibfk_2` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
COMMIT;
