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
-- Table structure for table `COMMENT`
--

DROP TABLE IF EXISTS `COMMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COMMENT` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_announcement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `COMMENT_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id`),
  CONSTRAINT `COMMENT_ibfk_2` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMMENT`
--

LOCK TABLES `COMMENT` WRITE;
/*!40000 ALTER TABLE `COMMENT` DISABLE KEYS */;
INSERT INTO `COMMENT` VALUES (1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean rhoncus pulvinar odio, non ornare massa tincidunt ac. Pellentesque suscipit neque non leo sagittis sed ullamcorper ligula tristique. Sed a dolor sapien, nec fermentum velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer porta sollicitudin odio quis tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vitae mi vel risus dictum pulvinar at eget nunc.','2012-12-06 14:30:14',1,2),(2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean rhoncus pulvinar odio, non ornare massa tincidunt ac. Pellentesque suscipit neque non leo sagittis sed ullamcorper ligula tristique. Sed a dolor sapien, nec fermentum velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer porta sollicitudin odio quis tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vitae mi vel risus dictum pulvinar at eget nunc.','2012-12-08 12:16:10',3,2);
/*!40000 ALTER TABLE `COMMENT` ENABLE KEYS */;
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
-- Table structure for table `MESSAGE`
--

DROP TABLE IF EXISTS `MESSAGE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MESSAGE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date_post` datetime NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sender` (`id_sender`),
  KEY `id_receiver` (`id_receiver`),
  CONSTRAINT `MESSAGE_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `USER` (`id`),
  CONSTRAINT `MESSAGE_ibfk_2` FOREIGN KEY (`id_receiver`) REFERENCES `USER` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MESSAGE`
--

LOCK TABLES `MESSAGE` WRITE;
/*!40000 ALTER TABLE `MESSAGE` DISABLE KEYS */;
INSERT INTO `MESSAGE` VALUES (1,'Premier contact','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean rhoncus pulvinar odio, non ornare massa tincidunt ac. Pellentesque suscipit neque non leo sagittis sed ullamcorper ligula tristique. Sed a dolor sapien, nec fermentum velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer porta sollicitudin odio quis tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vitae mi vel risus dictum pulvinar at eget nunc.','2012-12-13 11:23:45',1,3),(2,'Deuxieme contact','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean rhoncus pulvinar odio, non ornare massa tincidunt ac. Pellentesque suscipit neque non leo sagittis sed ullamcorper ligula tristique. Sed a dolor sapien, nec fermentum velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer porta sollicitudin odio quis tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vitae mi vel risus dictum pulvinar at eget nunc.','2012-12-25 08:40:49',3,1);
/*!40000 ALTER TABLE `MESSAGE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PICTURE`
--

DROP TABLE IF EXISTS `PICTURE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PICTURE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternative` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `height` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PICTURE`
--

LOCK TABLES `PICTURE` WRITE;
/*!40000 ALTER TABLE `PICTURE` DISABLE KEYS */;
/*!40000 ALTER TABLE `PICTURE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TAG`
--

DROP TABLE IF EXISTS `TAG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TAG` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TAG`
--

LOCK TABLES `TAG` WRITE;
/*!40000 ALTER TABLE `TAG` DISABLE KEYS */;
/*!40000 ALTER TABLE `TAG` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TO_APPLY`
--

DROP TABLE IF EXISTS `TO_APPLY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TO_APPLY` (
  `id_user` int(11) NOT NULL,
  `id_announcement` int(11) NOT NULL,
  KEY `id_user` (`id_user`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `TO_APPLY_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id`),
  CONSTRAINT `TO_APPLY_ibfk_2` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TO_APPLY`
--

LOCK TABLES `TO_APPLY` WRITE;
/*!40000 ALTER TABLE `TO_APPLY` DISABLE KEYS */;
/*!40000 ALTER TABLE `TO_APPLY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TO_ASSOCIATE`
--

DROP TABLE IF EXISTS `TO_ASSOCIATE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TO_ASSOCIATE` (
  `id_announcement` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  KEY `id_announcement` (`id_announcement`),
  KEY `id_tag` (`id_tag`),
  CONSTRAINT `TO_ASSOCIATE_ibfk_1` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`),
  CONSTRAINT `TO_ASSOCIATE_ibfk_2` FOREIGN KEY (`id_tag`) REFERENCES `TAG` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TO_ASSOCIATE`
--

LOCK TABLES `TO_ASSOCIATE` WRITE;
/*!40000 ALTER TABLE `TO_ASSOCIATE` DISABLE KEYS */;
/*!40000 ALTER TABLE `TO_ASSOCIATE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TO_EVALUATE`
--

DROP TABLE IF EXISTS `TO_EVALUATE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TO_EVALUATE` (
  `id_user` int(11) NOT NULL,
  `id_announcement` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  KEY `id_user` (`id_user`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `TO_EVALUATE_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id`),
  CONSTRAINT `TO_EVALUATE_ibfk_2` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TO_EVALUATE`
--

LOCK TABLES `TO_EVALUATE` WRITE;
/*!40000 ALTER TABLE `TO_EVALUATE` DISABLE KEYS */;
/*!40000 ALTER TABLE `TO_EVALUATE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TO_FOLLOW`
--

DROP TABLE IF EXISTS `TO_FOLLOW`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TO_FOLLOW` (
  `id_user_followed` int(11) NOT NULL,
  `id_user_follower` int(11) NOT NULL,
  KEY `id_user_followed` (`id_user_followed`),
  KEY `id_user_follower` (`id_user_follower`),
  CONSTRAINT `TO_FOLLOW_ibfk_1` FOREIGN KEY (`id_user_followed`) REFERENCES `USER` (`id`),
  CONSTRAINT `TO_FOLLOW_ibfk_2` FOREIGN KEY (`id_user_follower`) REFERENCES `USER` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TO_FOLLOW`
--

LOCK TABLES `TO_FOLLOW` WRITE;
/*!40000 ALTER TABLE `TO_FOLLOW` DISABLE KEYS */;
/*!40000 ALTER TABLE `TO_FOLLOW` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER`
--

LOCK TABLES `USER` WRITE;
/*!40000 ALTER TABLE `USER` DISABLE KEYS */;
INSERT INTO `USER` VALUES (1,'Fred','Jimmy','noxa02','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-11-26 10:29:37','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(3,'Xavier','Masson','noxa03','efcdac01c2c702aa9f29e9b2f0d6fcf2faa82f8c','xavier.masson@fidesio.com','12 rue pommier','0134563864','0612325434','2012-11-27 08:39:00','79457832847b44a73ccfeef57c03033db88cad08',0,'administrator'),(4,'Chea','Caroline','kimitsu','79457832847b44a73ccfeef57c03033db88cad08','Caroline.Chea90@gmail.com','12 rue pommier','0134563864','0612325434','2012-11-27 08:39:00','79457832847b44a73ccfeef57c03033db88cad08',0,'user'),(5,'Vignaux','Henri','Ritooon','964f86117b9d94946b45710f0c40b10d44e7de85','Vignaux.Henri@gmail.com','14 rue pommier','0134563864','0612325434','2012-11-27 08:39:00','79457832847b44a73ccfeef57c03033db88cad08',1,'administrator');
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

-- Dump completed on 2012-12-02  0:36:26
