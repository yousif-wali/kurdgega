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
  KEY `PostActivity_username_Shoppers_username` (`username`),
  CONSTRAINT `PostActivity_Product_ID_Products_Product_ID` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`),
  CONSTRAINT `PostActivity_username_Shoppers_username` FOREIGN KEY (`username`) REFERENCES `shoppers` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postactivity`
--

LOCK TABLES `postactivity` WRITE;
/*!40000 ALTER TABLE `postactivity` DISABLE KEYS */;
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
INSERT INTO `products` VALUES (0,0,'This is a title','this is a long description',299.99,'fuq0hfgjdjp7x29mr9nv.jpg,OIP (1).jpg,','2022-12-14 20:49:03','2022-12-28 20:49:03',0,'Home','90s',2019,'usednew'),(1,0,'This is a title','this is a long description',299.99,'fuq0hfgjdjp7x29mr9nv.jpg,OIP (1).jpg,','2022-12-14 20:50:45','2022-12-28 20:50:45',0,'Home','90s',2019,'usednew');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

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
  `email` text NOT NULL,
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
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppers`
--

LOCK TABLES `shoppers` WRITE;
/*!40000 ALTER TABLE `shoppers` DISABLE KEYS */;
INSERT INTO `shoppers` VALUES (0,'yousif','wali','bastory','yousifrwali@gmail.com','$2y$15$wW4LCbyLZBQYOBMRa9gHEuMvgb.0Vl5Yc45m56G8zfiryW7gkcSRm','2022-12-03',0,'','2183036006','male','1236','2022-12-14 17:53:23',0,0,'moorhead','mn','usa',0),(1,'buhar','wali','buhar04','buharwali@gmail.com','$2y$15$DlQ3tEKhOdMmZUtYAaGTD.fLYh1JiXz8MK4t53ZBG2pQg6M.6yK/O','2022-12-03',0,'::1','2183036001','male','1236 Belsly','2022-12-14 17:55:39',0,0,'Moorhead','MN','usa',0);
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

-- Dump completed on 2022-12-14 23:18:55
