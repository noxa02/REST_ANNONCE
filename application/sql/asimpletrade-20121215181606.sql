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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) DEFAULT NULL,
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `conclued` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('Service','Logement','Objet') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ANNOUNCEMENT`
--

LOCK TABLES `ANNOUNCEMENT` WRITE;
/*!40000 ALTER TABLE `ANNOUNCEMENT` DISABLE KEYS */;
INSERT INTO `ANNOUNCEMENT` VALUES (3,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:07:16',1,'Service'),(4,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:07:37',1,'Service'),(5,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:07:50',1,'Service'),(6,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:08:13',1,'Service'),(7,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:08:36',1,'Service'),(8,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:18:26',1,'Service'),(9,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:25:49',1,'Service'),(10,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:26:40',1,'Service'),(11,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:10:21',1,'Service'),(12,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:14:08',1,'Service'),(13,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:14:24',1,'Service'),(14,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:14:37',1,'Service'),(15,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:16:45',1,'Service'),(16,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:18:27',1,'Service'),(17,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:19:14',1,'Service'),(18,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:20:09',1,'Service'),(19,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:21:58',1,'Service'),(20,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:26:05',1,'Service'),(21,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:26:25',1,'Service'),(22,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:29:57',1,'Service'),(23,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:30:59',1,'Service'),(24,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:33:26',1,'Service'),(25,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:33:36',1,'Service'),(26,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:39:12',1,'Service'),(27,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:40:53',1,'Service'),(28,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:41:15',1,'Service'),(29,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:44:56',1,'Service'),(30,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:47:15',1,'Service'),(31,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:48:36',1,'Service'),(32,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:49:05',1,'Service'),(33,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:57:59',1,'Service'),(34,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:15:56',1,'Service'),(35,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:20:02',1,'Service'),(36,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:20:34',1,'Service'),(37,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:21:06',1,'Service'),(38,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:21:16',1,'Service'),(39,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:21:43',1,'Service'),(40,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:22:31',1,'Service'),(41,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 18:18:07',1,'Service'),(42,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 18:23:24',1,'Service'),(43,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-07 10:49:22',1,'Service'),(44,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-07 11:02:10',1,'Service'),(48,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-07 18:08:57',1,'Service'),(49,'Un Titre','Un sous titre','Un contenu','2012-12-15 15:30:41',1,'Service'),(50,'Un Titre','Un sous titre','Un contenu','2012-12-15 15:37:01',1,'Service'),(51,'Un Titre','Un sous titre','Un contenu','2012-12-15 15:40:23',1,'Service'),(52,'Un titre','Un sous titre','Un contenu','2012-12-15 15:44:35',1,'Service'),(53,'Un titre','Un sous titre','Un contenu','2012-12-15 15:45:12',1,'Service'),(54,'Un titre','Un sous titre','Un contenu','2012-12-15 15:46:56',1,'Service'),(55,'Un titre','Un sous titre','Un contenu','2012-12-15 15:48:21',1,'Service'),(56,'Un titre','Un sous titre','Un contenu','2012-12-15 15:48:57',1,'Service'),(57,'Un titre','Un sous titre','Un contenu','2012-12-15 15:50:56',1,'Service'),(58,'Un titre','Un sous titre','Un contenu','2012-12-15 15:51:08',1,'Service');
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
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_announcement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `COMMENT_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id`),
  CONSTRAINT `COMMENT_ibfk_2` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMMENT`
--

LOCK TABLES `COMMENT` WRITE;
/*!40000 ALTER TABLE `COMMENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `COMMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `INCOMING`
--

DROP TABLE IF EXISTS `INCOMING`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `INCOMING` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `subtitle` varchar(80) DEFAULT NULL,
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_announcement` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_announcement` (`id_announcement`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `INCOMING_ibfk_1` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`),
  CONSTRAINT `INCOMING_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `INCOMING`
--

LOCK TABLES `INCOMING` WRITE;
/*!40000 ALTER TABLE `INCOMING` DISABLE KEYS */;
INSERT INTO `INCOMING` VALUES (1,'Un Titre','Un sous titre','Un contenu','2012-12-10 11:23:59',3,4);
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
  `subject` varchar(80) NOT NULL,
  `content` text NOT NULL,
  `date_post` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sender` (`id_sender`),
  KEY `id_receiver` (`id_receiver`),
  CONSTRAINT `MESSAGE_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `USER` (`id`),
  CONSTRAINT `MESSAGE_ibfk_2` FOREIGN KEY (`id_receiver`) REFERENCES `USER` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MESSAGE`
--

LOCK TABLES `MESSAGE` WRITE;
/*!40000 ALTER TABLE `MESSAGE` DISABLE KEYS */;
INSERT INTO `MESSAGE` VALUES (3,'Un Sujet','Un contenue','2012-12-10 00:52:09',1,4),(4,'Un Sujet','Un contenu ','2012-12-10 01:00:24',1,4),(5,'','Le contenu','2012-12-15 15:58:25',1,6),(6,'Un sujet','Le contenu','2012-12-15 16:01:50',1,6),(7,'Un sujet','Le contenu','2012-12-15 16:06:03',1,6),(10,'Un sujet','Un contenu','2012-12-15 16:41:29',1,7);
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
  `title` varchar(80) DEFAULT NULL,
  `alternative` varchar(80) DEFAULT NULL,
  `path` varchar(180) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `id_announcement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `PICTURE_ibfk_1` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PICTURE`
--

LOCK TABLES `PICTURE` WRITE;
/*!40000 ALTER TABLE `PICTURE` DISABLE KEYS */;
INSERT INTO `PICTURE` VALUES (13,'announcement_48_2','Un texte alternatif','/announcement/original/','gif',48),(14,'announcement_48_3','Un texte alternatif','/announcement/original/','gif',48),(15,'announcement_48_4','Un texte alternatif','/announcement/original/','gif',48),(19,'announcement_55_0',NULL,'/announcement/original/','gif',55),(20,'announcement_55_1',NULL,'/announcement/original/','gif',55),(21,'announcement_55_2',NULL,'/announcement/original/','gif',55),(22,'announcement_55_3',NULL,'/announcement/original/','gif',55),(23,'announcement_55_4',NULL,'/announcement/original/','gif',55),(24,'announcement_56_0',NULL,'/announcement/original/','gif',56),(25,'announcement_56_1',NULL,'/announcement/original/','gif',56),(26,'announcement_56_2',NULL,'/announcement/original/','gif',56),(27,'announcement_56_3',NULL,'/announcement/original/','gif',56),(28,'announcement_56_4',NULL,'/announcement/original/','gif',56),(29,'announcement_57_0',NULL,'/announcement/original/','gif',57),(30,'announcement_57_1',NULL,'/announcement/original/','gif',57),(31,'announcement_57_2',NULL,'/announcement/original/','gif',57),(32,'announcement_57_3',NULL,'/announcement/original/','gif',57),(33,'announcement_57_4',NULL,'/announcement/original/','gif',57),(34,'announcement_58_0',NULL,'/announcement/original/','gif',58),(35,'announcement_58_1',NULL,'/announcement/original/','gif',58),(36,'announcement_58_2',NULL,'/announcement/original/','gif',58),(37,'announcement_58_3',NULL,'/announcement/original/','gif',58),(38,'announcement_58_4',NULL,'/announcement/original/','gif',58);
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
  `title` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TAG`
--

LOCK TABLES `TAG` WRITE;
/*!40000 ALTER TABLE `TAG` DISABLE KEYS */;
INSERT INTO `TAG` VALUES (1,'Vacances'),(2,'Jardinerie'),(3,'Social'),(4,'Bricolage');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TO_FOLLOW`
--

LOCK TABLES `TO_FOLLOW` WRITE;
/*!40000 ALTER TABLE `TO_FOLLOW` DISABLE KEYS */;
INSERT INTO `TO_FOLLOW` VALUES (1,3),(1,4),(1,5),(6,4),(1,6);
/*!40000 ALTER TABLE `TO_FOLLOW` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USER` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(180) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `address` varchar(120) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `portable` varchar(30) NOT NULL,
  `subscription_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hash` varchar(180) DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('administrator','user') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER`
--

LOCK TABLES `USER` WRITE;
/*!40000 ALTER TABLE `USER` DISABLE KEYS */;
INSERT INTO `USER` VALUES (1,'Fred','Jimmi','noxa02','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-11-26 09:29:37','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(3,'Xavier','Masson','noxa03','efcdac01c2c702aa9f29e9b2f0d6fcf2faa82f8c','xavier.masson@fidesio.com','12 rue pommier','0134563864','0612325434','2012-11-27 07:39:00','79457832847b44a73ccfeef57c03033db88cad08',0,'administrator'),(4,'Chea','Caroline','kimitsu','79457832847b44a73ccfeef57c03033db88cad08','Caroline.Chea90@gmail.com','12 rue pommier','0134563864','0612325434','2012-11-27 07:39:00','79457832847b44a73ccfeef57c03033db88cad08',0,'user'),(5,'Vignaux','Henri','Ritooon','964f86117b9d94946b45710f0c40b10d44e7de85','Vignaux.Henri@gmail.com','14 rue pommier','0134563864','0612325434','2012-11-27 07:39:00','79457832847b44a73ccfeef57c03033db88cad08',1,'administrator'),(6,'Fred','Jimmy','noxa07','ogame18','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','0000-00-00 00:00:00','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(7,'Fred','Jimmy','noxa08','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-12-02 16:22:16','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(8,'Fred','Jimmy','noxa09','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-12-02 19:23:14','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(15,'Tim','James','noxa10','efcdac01c2c702aa9f29e9b2f0d6fcf2faa82f8c','xavier.masson@fidesio.com','3 rue meissonnier','0187557986','0676534572','2012-12-12 21:06:45','79457832847b44a73ccfeef57c03033db88cad08',0,'user');
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

-- Dump completed on 2012-12-15 18:16:07
