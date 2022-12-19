-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: kurdgega
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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

--
-- Table structure for table `blacklist`
--

DROP TABLE IF EXISTS `blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blacklist` (
  `list_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `User_ID_Blocked` int(11) NOT NULL,
  PRIMARY KEY (`list_ID`),
  KEY `blacklist_User_ID_Shoppers_User_ID` (`User_ID`),
  KEY `blacklist_User_ID_Blocked_Shoppers_User_ID` (`User_ID_Blocked`),
  CONSTRAINT `blacklist_User_ID_Blocked_Shoppers_User_ID` FOREIGN KEY (`User_ID_Blocked`) REFERENCES `shoppers` (`User_ID`),
  CONSTRAINT `blacklist_User_ID_Shoppers_User_ID` FOREIGN KEY (`User_ID`) REFERENCES `shoppers` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklist`
--

LOCK TABLES `blacklist` WRITE;
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chatFrom` varchar(20) NOT NULL,
  `chatTo` varchar(20) NOT NULL,
  `chatSent` timestamp NOT NULL DEFAULT current_timestamp(),
  `chatStatus` enum('read','sent','not sent') DEFAULT NULL,
  `messages` longtext DEFAULT NULL,
  `images` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chats`
--

LOCK TABLES `chats` WRITE;
/*!40000 ALTER TABLE `chats` DISABLE KEYS */;
INSERT INTO `chats` VALUES (1,'bastory','buhar04','2022-12-18 21:36:49',NULL,'Hello there',NULL),(2,'buhar04','bastory','2022-12-18 22:14:44',NULL,'Hello there',NULL),(3,'bastory','buhar04','2022-12-18 22:14:45',NULL,'Hello there',NULL),(5,'bastory','buhar04','2022-12-18 23:04:20',NULL,'another message',NULL),(14,'bastory','bastory01','2022-12-19 01:14:24',NULL,'Testing',NULL);
/*!40000 ALTER TABLE `chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `postactivity`
--

DROP TABLE IF EXISTS `postactivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `postactivity` (
  `PostID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `likes` tinyint(1) NOT NULL DEFAULT 0,
  `comment` longtext NOT NULL,
  `commentDate` datetime NOT NULL DEFAULT current_timestamp(),
  `share` int(11) NOT NULL,
  PRIMARY KEY (`PostID`),
  KEY `PostActivity_Product_ID_Products_Product_ID` (`Product_ID`),
  KEY `postactivity_username_shoppers_username` (`username`),
  CONSTRAINT `postactivity_username_shoppers_username` FOREIGN KEY (`username`) REFERENCES `shoppers` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postactivity`
--

LOCK TABLES `postactivity` WRITE;
/*!40000 ALTER TABLE `postactivity` DISABLE KEYS */;
INSERT INTO `postactivity` VALUES (1,0,'buhar04',0,'','2022-12-17 22:06:18',0),(2,0,'bastory',1,'','2022-12-18 12:18:54',0),(3,1,'bastory',1,'','2022-12-18 12:34:42',0);
/*!40000 ALTER TABLE `postactivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `Product_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `price` double NOT NULL,
  `images` longtext NOT NULL,
  `publishedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `countdown` datetime NOT NULL DEFAULT (current_timestamp() + interval 14 day),
  `views` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) NOT NULL,
  `model` varchar(200) NOT NULL,
  `year` int(4) NOT NULL,
  `conditions` varchar(200) NOT NULL,
  PRIMARY KEY (`Product_ID`),
  KEY `Products_User_ID_Shoppers_User_ID` (`User_ID`),
  CONSTRAINT `Products_User_ID_Shoppers_User_ID` FOREIGN KEY (`User_ID`) REFERENCES `shoppers` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (0,1,'This is a title','this is a long description',299.99,'5c46899429255fde092c1f26fefbb891.jpg,OIP (2).jpg,','2022-12-17 21:26:37','2022-12-31 21:26:37',0,'Home','90s',1950,'new'),(1,2,'This is a title','',0,'data-databases.png,','2022-12-17 22:01:48','2022-12-31 22:01:48',0,'','',0,'new');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER DeletePostActivity
AFTER DELETE ON products FOR EACH ROW
BEGIN
DELETE FROM postactivity WHERE postactivity.Product_ID = OLD.Product_ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `shoppers`
--

DROP TABLE IF EXISTS `shoppers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoppers` (
  `User_ID` int(11) NOT NULL,
  `fName` varchar(100) NOT NULL,
  `lName` varchar(100) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pwd` longtext NOT NULL,
  `dob` date NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `ip` text NOT NULL,
  `phone` tinytext NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `address` longtext NOT NULL,
  `lastLogin` datetime NOT NULL DEFAULT current_timestamp(),
  `factor_auth` int(7) unsigned NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `city` varchar(100) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `vip` tinyint(1) DEFAULT 0,
  `profile` varchar(200) NOT NULL,
  `signedup` date DEFAULT current_timestamp(),
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppers`
--

LOCK TABLES `shoppers` WRITE;
/*!40000 ALTER TABLE `shoppers` DISABLE KEYS */;
INSERT INTO `shoppers` VALUES (1,'yousif','wali','bastory','yousifrwali@gmail.com','$2y$15$SG3v.k3Z8ArNZoTlWZjUteX/S0FoorIc4meZP00pfMWrqlpIpNL4y','2022-12-02',0,'::1','218-303-6006','male','123 11th st s','2022-12-18 18:29:02',0,0,'moorhead','mn','usa',0,'profile.png','2022-12-17'),(2,'buhar','wali','buhar04','buharwali@gmail.com','$2y$15$Jj4JONmbFqExXkSNySQmh.FW.l6yrkFbnVH1ZDG16Jg4dYjJ3Fefy','2022-12-02',0,'::1','2183036001','female','1236 Belsly','2022-12-17 21:57:39',0,0,'Moorhead','MN','United States',0,'profile.png','2022-12-17'),(3,'yousif','wali','bastory01','yousifrwali2@gmail.com','$2y$15$9xUdGlfGVIxmVzsEG27nveTjsr1O.QW9q5LOgjoIiQPDqn5Jmre1m','2022-12-03',0,'::1','218-303-6007','male','123 11th st s','2022-12-18 19:17:30',0,0,'moorhead','mn','usa',0,'profile.png','2022-12-18');
/*!40000 ALTER TABLE `shoppers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-18 19:19:48
