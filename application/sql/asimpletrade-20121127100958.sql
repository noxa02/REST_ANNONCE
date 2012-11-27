-- MySQL dump 10.13  Distrib 5.5.25, for osx10.6 (i386)
--
-- Host: localhost    Database: asimpletrade
-- ------------------------------------------------------
-- Server version	5.5.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ANNOUNCEMENT`
--

DROP TABLE IF EXISTS `ANNOUNCEMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ANNOUNCEMENT` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) DEFAULT NULL,
  `content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `conclued` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ANNOUNCEMENT`
--

LOCK TABLES `ANNOUNCEMENT` WRITE;
/*!40000 ALTER TABLE `ANNOUNCEMENT` DISABLE KEYS */;
INSERT INTO `ANNOUNCEMENT` VALUES (2,'Première annonce','Description annonce','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam orci eros, interdum a imperdiet et, convallis vitae urna. Nullam gravida justo et neque tempor bibendum. Maecenas arcu mauris, tristique quis elementum nec, hendrerit scelerisque est. Duis pulvinar elit nec leo viverra vestibulum. ','2012-11-26 11:39:15',0);
/*!40000 ALTER TABLE `ANNOUNCEMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `INCOMING`
--

DROP TABLE IF EXISTS `INCOMING`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `INCOMING` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) DEFAULT NULL,
  `content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `id_administrator` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_administrator` (`id_administrator`),
  CONSTRAINT `INCOMING_ibfk_1` FOREIGN KEY (`id_administrator`) REFERENCES `USER` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `INCOMING`
--

LOCK TABLES `INCOMING` WRITE;
/*!40000 ALTER TABLE `INCOMING` DISABLE KEYS */;
INSERT INTO `INCOMING` VALUES (1,'First Incoming','Description of Incoming','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in metus elit, nec blandit ipsum. Cras euismod bibendum sem, et egestas quam egestas vitae. Sed euismod, lorem ut scelerisque viverra, lorem metus varius dui, ac dignissim enim nisl vel diam. ','2012-11-26 19:21:51',1);
/*!40000 ALTER TABLE `INCOMING` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(180) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `address` varchar(120) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `portable` varchar(30) NOT NULL,
  `subscription_date` datetime NOT NULL,
  `hash` varchar(180) DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('administrator','user') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER`
--

LOCK TABLES `USER` WRITE;
/*!40000 ALTER TABLE `USER` DISABLE KEYS */;
INSERT INTO `USER` VALUES (1,'Fred','Jimmy','noxa02','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-11-26 10:29:37','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator');
/*!40000 ALTER TABLE `USER` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-27 10:10:01
