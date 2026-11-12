-- Sip Stamp local database
CREATE DATABASE IF NOT EXISTS sip_stamp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sip_stamp;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cafes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `cafes` DISABLE KEYS */;
INSERT INTO `cafes` VALUES (1,'Brew92','Riyadh','Olaya - famous for its Spanish Latte, industrial interiors, good for studying',NULL),(2,'Elixir Bunn','Riyadh','Al Olaya - specialty roastery known for V60 and cold brew',NULL),(3,'Camel Step','Riyadh','Hittin & Al Malqa - seasonal single-origin beans, flat white and pour-over',NULL),(4,'Overdose','Riyadh','Known for hot chocolate topped with a chocolate bar and whipped cream',NULL),(5,'Half Million','Riyadh','Specialty coffee chain - V60, cold brew and the Coffee Crunch dessert',NULL),(6,'Dose Cafe','Riyadh','Popular chain for Spanish Latte, good for working',NULL),(7,'Draft Cafe','Riyadh','Olaya - calm space, good for working',NULL),(8,'% Arabica','Riyadh','White marble interior, known for the Kyoto Latte',NULL),(9,'Hustle n Flow','Riyadh','Al Malqa - warehouse style, charcoal and blue spirulina lattes',NULL),(10,'Namq','Riyadh','Al Malqa & Hittin - reflecting pool, modern Arabic design, brunch',NULL),(11,'Takya Cafe','Riyadh','Known for the Saffron Qahwa Latte',NULL),(12,'Fabrica de Cafe','Riyadh','Hittin & An Nakheel - matcha drinks, fudgy cookies and tiramisu',NULL),(13,'Kuro','Riyadh','Midtown Plaza - Japanese cafe, fluffy pancakes and matcha',NULL),(14,'Ralph\'s Coffee','Riyadh','KAFD - classic American cafe with a terrace',NULL);
/*!40000 ALTER TABLE `cafes` ENABLE KEYS */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  `drink` varchar(50) NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `cafe_id` (`cafe_id`),
  CONSTRAINT `experiences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `experiences_ibfk_2` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (1,1,1,'Spanish Latte',5,'Perfect sweetness and very smooth.','2026-11-06 13:34:19'),(2,1,2,'V60',4,'Clean and fruity, very refreshing.','2026-11-06 13:34:19');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cafe_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `one_favorite` (`user_id`,`cafe_id`),
  KEY `cafe_id` (`cafe_id`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stamps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `experience_id` int(11) NOT NULL,
  `stamped_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `experience_id` (`experience_id`),
  CONSTRAINT `stamps_ibfk_1` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `stamps` DISABLE KEYS */;
INSERT INTO `stamps` VALUES (1,1,'2026-11-06 13:34:19'),(2,2,'2026-11-06 13:34:19');
/*!40000 ALTER TABLE `stamps` ENABLE KEYS */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@pnu.edu.sa','$2y$12$ar/cEh88vBlvuojzEwiYKu0/tLjvUHymgnxoWgdMDRsLgfVUnbBC2');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

COMMIT;
