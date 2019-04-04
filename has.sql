-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: has
-- ------------------------------------------------------
-- Server version	5.7.25

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
-- Table structure for table `hours_adjustments`
--

DROP TABLE IF EXISTS `hours_adjustments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hours_adjustments` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `date` varchar(10) NOT NULL,
  `entryHour` varchar(8) NOT NULL,
  `exitHour` varchar(8) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `id_justification` int(8) NOT NULL,
  `id_user` int(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_justification` (`id_justification`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `hours_adjustments_ibfk_1` FOREIGN KEY (`id_justification`) REFERENCES `justifications` (`id`),
  CONSTRAINT `hours_adjustments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hours_adjustments`
--

LOCK TABLES `hours_adjustments` WRITE;
/*!40000 ALTER TABLE `hours_adjustments` DISABLE KEYS */;
INSERT INTO `hours_adjustments` VALUES (1,'0032-02-11','12:03:00','14:05:00','2:02:00',3,1),(2,'0032-02-11','12:45:00','15:23:00','2:38:00',2,1);
/*!40000 ALTER TABLE `hours_adjustments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hours_adjustments_status`
--

DROP TABLE IF EXISTS `hours_adjustments_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hours_adjustments_status` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hours_adjustments_status`
--

LOCK TABLES `hours_adjustments_status` WRITE;
/*!40000 ALTER TABLE `hours_adjustments_status` DISABLE KEYS */;
INSERT INTO `hours_adjustments_status` VALUES (1,'waiting_coordinator_approval','Aguardando Aprovação do Coordenador de Curso.');
/*!40000 ALTER TABLE `hours_adjustments_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `justifications`
--

DROP TABLE IF EXISTS `justifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `justifications` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `justifications`
--

LOCK TABLES `justifications` WRITE;
/*!40000 ALTER TABLE `justifications` DISABLE KEYS */;
INSERT INTO `justifications` VALUES (3,'Capacitação'),(2,'Produção'),(1,'Versionamento');
/*!40000 ALTER TABLE `justifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profiles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,'Coordenador de Curso','course_coordinator'),(2,'Trabalhador','employee'),(3,'Coordenador de Núcleo Pedagógico','coordinator_of_pedagogical_core');
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'João Neto','joao@teste.com','password'),(2,'Kent Beck','kent@teste.com','password');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_hours_adjustments_status`
--

DROP TABLE IF EXISTS `users_hours_adjustments_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_hours_adjustments_status` (
  `id_status` int(4) NOT NULL,
  `id_user` int(12) NOT NULL,
  PRIMARY KEY (`id_status`,`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `users_hours_adjustments_status_ibfk_1` FOREIGN KEY (`id_status`) REFERENCES `hours_adjustments_status` (`id`),
  CONSTRAINT `users_hours_adjustments_status_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_hours_adjustments_status`
--

LOCK TABLES `users_hours_adjustments_status` WRITE;
/*!40000 ALTER TABLE `users_hours_adjustments_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_hours_adjustments_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_user_profiles`
--

DROP TABLE IF EXISTS `users_user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_user_profiles` (
  `id_user` int(11) NOT NULL,
  `id_user_profile` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_user_profile`),
  KEY `id_user_profile` (`id_user_profile`),
  CONSTRAINT `users_user_profiles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `users_user_profiles_ibfk_2` FOREIGN KEY (`id_user_profile`) REFERENCES `user_profiles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_user_profiles`
--

LOCK TABLES `users_user_profiles` WRITE;
/*!40000 ALTER TABLE `users_user_profiles` DISABLE KEYS */;
INSERT INTO `users_user_profiles` VALUES (2,1),(1,2),(2,2);
/*!40000 ALTER TABLE `users_user_profiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-04 11:28:25
