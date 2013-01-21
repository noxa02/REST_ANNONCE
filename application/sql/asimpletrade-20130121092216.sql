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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ANNOUNCEMENT`
--

LOCK TABLES `ANNOUNCEMENT` WRITE;
/*!40000 ALTER TABLE `ANNOUNCEMENT` DISABLE KEYS */;
INSERT INTO `ANNOUNCEMENT` VALUES (3,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:07:16',1,'Service'),(4,'Un titre','Un sous titre','Un contenuz','2012-12-06 09:07:37',1,'Service'),(5,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:07:50',1,'Service'),(6,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:08:13',1,'Service'),(7,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:08:36',1,'Service'),(8,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:18:26',1,'Service'),(9,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:25:49',1,'Service'),(10,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 09:26:40',1,'Service'),(11,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:10:21',1,'Service'),(12,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:14:08',1,'Service'),(13,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:14:24',1,'Service'),(14,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:14:37',1,'Service'),(15,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:16:45',1,'Service'),(16,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:18:27',1,'Service'),(17,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:19:14',1,'Service'),(18,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:20:09',1,'Service'),(19,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:21:58',1,'Service'),(20,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:26:05',1,'Service'),(21,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:26:25',1,'Service'),(22,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:29:57',1,'Service'),(23,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:30:59',1,'Service'),(24,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:33:26',1,'Service'),(25,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:33:36',1,'Service'),(26,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:39:12',1,'Service'),(27,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:40:53',1,'Service'),(28,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:41:15',1,'Service'),(29,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:44:56',1,'Service'),(30,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:47:15',1,'Service'),(31,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:48:36',1,'Service'),(32,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:49:05',1,'Service'),(33,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 10:57:59',1,'Service'),(34,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:15:56',1,'Service'),(35,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:20:02',1,'Service'),(36,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:20:34',1,'Service'),(37,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:21:06',1,'Service'),(38,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:21:16',1,'Service'),(39,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:21:43',1,'Service'),(40,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 11:22:31',1,'Service'),(41,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 18:18:07',1,'Service'),(42,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-06 18:23:24',1,'Service'),(43,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-07 10:49:22',1,'Service'),(44,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-07 11:02:10',1,'Service'),(48,'Deuxieme Annonce','Un deuxieme sous titre','Un deuxieme contenu','2012-12-07 18:08:57',1,'Service'),(49,'Un Titre','Un sous titre','Un contenu','2012-12-15 15:30:41',1,'Service'),(50,'Un Titre','Un sous titre','Un contenu','2012-12-15 15:37:01',1,'Service'),(51,'Un Titre','Un sous titre','Un contenu','2012-12-15 15:40:23',1,'Service'),(52,'Un titre','Un sous titre','Un contenu','2012-12-15 15:44:35',1,'Service'),(53,'Un titre','Un sous titre','Un contenu','2012-12-15 15:45:12',1,'Service'),(54,'Un titre','Un sous titre','Un contenu','2012-12-15 15:46:56',1,'Service'),(55,'Un titre','Un sous titre','Un contenu','2012-12-15 15:48:21',1,'Service'),(56,'Un titre','Un sous titre','Un contenu','2012-12-15 15:48:57',1,'Service'),(57,'Un titre','Un sous titre','Un contenu','2012-12-15 15:50:56',1,'Service'),(58,'Un titre','Un sous titre','Un contenu','2012-12-15 15:51:08',1,'Service'),(59,'Un titre ','Un sous titre','Un contenu','2012-12-17 08:30:01',0,'Service'),(61,'Un titre','Un sous titre','Un contenu d\'annonce','2012-12-17 10:59:58',0,'Service'),(63,'Un titre','Un sous titre','Un contenu d\'annonce','2012-12-17 19:57:49',0,'Service'),(65,'Un titre','Un sous titre','Un contenu d\'annonce','2012-12-18 09:05:13',0,'Service'),(66,'Un titre','Un sous titre','Un contenu d\'annonce','2012-12-18 09:12:16',0,'Service'),(67,'Un titre','Un sous titre','Un contenu d\'annonce','2012-12-18 09:15:05',0,'Service'),(68,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:29:38',0,'Service'),(69,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:29:53',0,'Service'),(70,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:30:35',0,'Service'),(71,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:31:18',0,'Service'),(72,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:31:48',0,'Service'),(73,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:32:05',0,'Service'),(74,'Une Annonce','Un sous titre d\'Annonce','Un contenu d\'Annonce','2013-01-15 23:33:02',0,'Service'),(75,'Azerty','Qsdfg','Wxcvb','2013-01-17 10:22:00',1,'Service'),(76,'Azerty','Qsdfg','Wxcvb','2013-01-17 10:22:29',1,'Service');
/*!40000 ALTER TABLE `ANNOUNCEMENT` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER DELETE_ON_ANNOUNCEMENT
  BEFORE DELETE ON ANNOUNCEMENT
    FOR EACH ROW 
      BEGIN

      SELECT COUNT(id_announcement) INTO @countAnnouncementTA FROM TO_ASSOCIATE
      WHERE id_announcement  = old.id;

      SELECT COUNT(id) INTO @countComment FROM COMMENT
      WHERE id_announcement  = old.id;

      SELECT COUNT(id_announcement) INTO @countAnnouncementTAP FROM TO_APPLY
      WHERE id_announcement  = old.id;

      SELECT COUNT(id_announcement) INTO @countAnnouncementTE FROM TO_EVALUATE
      WHERE id_announcement  = old.id;

      IF @countAnnouncementTA > 0
        THEN 
          DELETE FROM TO_ASSOCIATE WHERE id_announcement = old.id;
      END IF;   

      IF @countComment > 0
        THEN 
          DELETE FROM COMMENT WHERE id_announcement = old.id;
      END IF;  

      IF @countAnnouncementTAP > 0
        THEN 
          DELETE FROM TO_APPLY WHERE id_announcement = old.id;
      END IF; 

      IF @countAnnouncementTE > 0
        THEN 
          DELETE FROM TO_EVALUATE WHERE id_announcement = old.id;
      END IF; 
      END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COMMENT`
--

LOCK TABLES `COMMENT` WRITE;
/*!40000 ALTER TABLE `COMMENT` DISABLE KEYS */;
INSERT INTO `COMMENT` VALUES (1,'Un contenu de commentaire','2012-12-16 14:24:04',1,48),(2,'Un contenu de commentaire','2012-12-16 14:26:01',1,48),(3,'Un contenu de commentaire','2012-12-16 14:28:19',1,48);
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
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `INCOMING_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `USER` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `INCOMING`
--

LOCK TABLES `INCOMING` WRITE;
/*!40000 ALTER TABLE `INCOMING` DISABLE KEYS */;
INSERT INTO `INCOMING` VALUES (2,'Une news','Un sous titre de news','Un contenu de news','2012-12-17 10:19:30',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MESSAGE`
--

LOCK TABLES `MESSAGE` WRITE;
/*!40000 ALTER TABLE `MESSAGE` DISABLE KEYS */;
INSERT INTO `MESSAGE` VALUES (4,'Un Sujet','Un contenu ','2012-12-10 01:00:24',1,4),(5,'','Le contenu','2012-12-15 15:58:25',1,6),(6,'Un sujet','Le contenu','2012-12-15 16:01:50',1,6),(7,'Un sujet','Le contenu','2012-12-15 16:06:03',1,6),(10,'Un sujet','Un contenu','2012-12-15 16:41:29',1,7),(11,'Un sujetz','Le contenu','2012-12-16 12:13:10',1,7),(13,'Un sujet','Un contenu de message','2012-12-18 10:04:09',1,5),(14,'Un sujet','Un contenu de message','2012-12-18 10:04:24',1,5),(15,'Un sujet','Un contenu','2013-01-12 14:42:54',1,6),(16,'Un sujet','Un contenu','2013-01-12 14:43:09',1,6),(17,'Un sujet','Un contenu','2013-01-12 14:51:21',1,6),(18,'Un sujet','Un contenu','2013-01-12 14:51:30',1,6);
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
  `id_announcement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_announcement` (`id_announcement`),
  CONSTRAINT `PICTURE_ibfk_1` FOREIGN KEY (`id_announcement`) REFERENCES `ANNOUNCEMENT` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PICTURE`
--

LOCK TABLES `PICTURE` WRITE;
/*!40000 ALTER TABLE `PICTURE` DISABLE KEYS */;
INSERT INTO `PICTURE` VALUES (13,'announcement_48_2','Un texte alternatif','/announcement/original/','gif',48),(14,'announcement_48_3','Un texte alternatif','/announcement/original/','gif',48),(15,'announcement_48_4','Un texte alternatif','/announcement/original/','gif',48),(19,'announcement_55_0',NULL,'/announcement/original/','gif',55),(20,'announcement_55_1',NULL,'/announcement/original/','gif',55),(21,'announcement_55_2',NULL,'/announcement/original/','gif',55),(22,'announcement_55_3',NULL,'/announcement/original/','gif',55),(23,'announcement_55_4',NULL,'/announcement/original/','gif',55),(24,'announcement_56_0',NULL,'/announcement/original/','gif',56),(25,'announcement_56_1',NULL,'/announcement/original/','gif',56),(26,'announcement_56_2',NULL,'/announcement/original/','gif',56),(27,'announcement_56_3',NULL,'/announcement/original/','gif',56),(28,'announcement_56_4',NULL,'/announcement/original/','gif',56),(29,'announcement_57_0',NULL,'/announcement/original/','gif',57),(30,'announcement_57_1',NULL,'/announcement/original/','gif',57),(31,'announcement_57_2',NULL,'/announcement/original/','gif',57),(32,'announcement_57_3',NULL,'/announcement/original/','gif',57),(33,'announcement_57_4',NULL,'/announcement/original/','gif',57),(34,'announcement_58_0',NULL,'/announcement/original/','gif',58),(35,'announcement_58_1',NULL,'/announcement/original/','gif',58),(36,'announcement_58_2',NULL,'/announcement/original/','gif',58),(37,'announcement_58_3',NULL,'/announcement/original/','gif',58),(38,'announcement_58_4',NULL,'/announcement/original/','gif',58),(45,'Mon image','Un texte alternatif','','',53),(46,'Mon image','Un texte alternatif','','',53),(60,'Mon image','Un texte alternatif','','',61),(61,'Mon image','Un texte alternatif','','',61),(75,'50cf7a291927e','Un texte alternatif','/announcement/original/','gif',63),(76,'50d01f47e05b4','Un texte alternatif','/announcement/original/','gif',63),(78,'50d02092911af','Un texte alternatif','/announcement/original/','gif',63),(79,'50d031c93c90c',NULL,'/announcement/original/','gif',65),(80,'50d031c93e506',NULL,'/announcement/original/','gif',65),(81,'50d031c947fbf',NULL,'/announcement/original/','gif',65),(82,'50d031c94f87a',NULL,'/announcement/original/','gif',65),(83,'50d031c951229',NULL,'/announcement/original/','gif',65),(84,'50d031c9516fe',NULL,'/announcement/original/','gif',65),(85,'50d03419f1df0',NULL,'/announcement/original/','gif',67),(86,'50d0341a0013d',NULL,'/announcement/original/','gif',67),(87,'50d0341a03cab',NULL,'/announcement/original/','gif',67),(88,'50d0341a04211',NULL,'/announcement/original/','gif',67),(89,'50d0341a0ce4e',NULL,'/announcement/original/','gif',67),(90,'Mon images',NULL,'/announcement/original/','gif',67),(91,'50f5e72e54386',NULL,'/announcement/original/','gif',74),(92,'50f5e72e5d187',NULL,'/announcement/original/','gif',74),(93,'50f5e72e5d568',NULL,'/announcement/original/','gif',74),(94,'50f5e72e5d92b',NULL,'/announcement/original/','gif',74),(95,'50f5e72e5dd99',NULL,'/announcement/original/','gif',74),(96,'50f5e72e5e245',NULL,'/announcement/original/','gif',74),(97,'50f7c710034ed',NULL,'/announcement/original/','gif',NULL),(98,'50f7d0b4bebb8',NULL,'/announcement/original/','gif',NULL),(99,'50f7d0e5ac92f',NULL,'/announcement/original/','gif',76),(100,'50f7d0e5ad7f0',NULL,'/announcement/original/','gif',76),(101,'50f7d0e5add9f',NULL,'/announcement/original/','gif',76),(102,'50f7d0e5ae22a',NULL,'/announcement/original/','gif',76),(103,'50f7d0e5aec50',NULL,'/announcement/original/','gif',76);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TAG`
--

LOCK TABLES `TAG` WRITE;
/*!40000 ALTER TABLE `TAG` DISABLE KEYS */;
INSERT INTO `TAG` VALUES (1,'Voyage'),(2,'Jardinerie'),(3,'Social'),(4,'Bricolage'),(7,'ededez');
/*!40000 ALTER TABLE `TAG` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TO_APPLY`
--

DROP TABLE IF EXISTS `TO_APPLY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TO_APPLY` (
  `status` tinyint(1) NOT NULL DEFAULT '0',
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
INSERT INTO `TO_APPLY` VALUES (0,1,63),(0,4,55),(0,4,55),(0,4,55);
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
INSERT INTO `TO_FOLLOW` VALUES (1,5),(6,4),(1,7),(1,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER`
--

LOCK TABLES `USER` WRITE;
/*!40000 ALTER TABLE `USER` DISABLE KEYS */;
INSERT INTO `USER` VALUES (1,'Time','Jimmi','noxa02','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-11-26 09:29:37','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(3,'Time','Masson','noxa03','efcdac01c2c702aa9f29e9b2f0d6fcf2faa82f8c','xavier.masson@fidesio.com','12 rue pommier','0134563864','0612325434','2012-11-27 07:39:00','79457832847b44a73ccfeef57c03033db88cad08',1,'administrator'),(4,'Time','Caroline','kimitsu','79457832847b44a73ccfeef57c03033db88cad08','Caroline.Chea90@gmail.com','12 rue pommier','0134563864','0612325434','2012-11-27 07:39:00','79457832847b44a73ccfeef57c03033db88cad08',1,'user'),(5,'Time','Henri','Ritooon','964f86117b9d94946b45710f0c40b10d44e7de85','Vignaux.Henri@gmail.com','14 rue pommier','0134563864','0612325434','2012-11-27 07:39:00','79457832847b44a73ccfeef57c03033db88cad08',1,'administrator'),(6,'Time','Jimmy','noxa07','ogame18','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','0000-00-00 00:00:00','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(7,'Time','Jimmy','noxa08','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-12-02 16:22:16','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(8,'Time','Jimmy','noxa09','7d422c853c3e460cbf6df57ac6209e60ac5bea93','Masson.Xavier.91@gmail.com','3 rue meissonnier','0169486412','0676564534','2012-12-02 19:23:14','ec457d0a974c48d5685a7efa03d137dc8bbde7e3',1,'administrator'),(16,'Tim','James','noxa093','ogame17','xavier.masson@fidesio.com','3 rue meissonnier','0187557986','0676534572','2012-12-17 08:24:52','79457832847b44a73ccfeef57c03033db88cad08',1,'user'),(17,'Tim','James','noxa0989','ogame17','xavier.masson@fidesio.com','3 rue meissonnier','0187557986','0676534572','2012-12-22 17:39:48','79457832847b44a73ccfeef57c03033db88cad08',0,'user'),(18,'jimmy','','','','','','','','2012-12-24 18:23:09',NULL,0,'administrator'),(19,'Paolo','Paul','Paolo123','paulpaolo','paolo@gmail.com','23 square des braises','0113434523','0613543643','2013-01-14 10:48:53','5hdziz678hdef567nfeife23',0,'user'),(21,'Masson','Bertrand','BertrandMasson','a1728282718a7105f813fb35d4fa99351beafb59','MassonBerty@aol.com','3 rue meissonnier','0145356412','0624564321','2013-01-15 11:48:34','sqfgq678dzfz54ghjd89',0,'user');
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

-- Dump completed on 2013-01-21  9:22:17
