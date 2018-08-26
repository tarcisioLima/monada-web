-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: monadaweb
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actived` tinyint(1) NOT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `author_username_unique` (`username`),
  KEY `author_userid_foreign` (`userId`),
  CONSTRAINT `author_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'olavodecarvalho','B. 1947, philosopher, author of 18 books, and journalist, I am also a lecturer with a wide audience in Brazil and a growing one in the USA, where I live.',1,'https://www.facebook.com/olavo.decarvalho','https://twitter.com/OdeCarvalho','https://www.youtube.com/user/olavodeca','https://www.instagram.com/olavodecarvalho1','http://www.seminariodefilosofia.org','https://pbs.twimg.com/profile_images/626195152898424832/6wFj8Ksr_400x400.jpg',24),(2,'socr4tes','',1,'','','','','','http://img3.wikia.nocookie.net/__cb20120206064856/epicrapbattlesofhistory/images/e/ea/Socrates_Portr',11),(3,'plata0','',1,'','','','','','http://www.imagick.com.br/wp-content/uploads/2014/01/Platao-1.jpg',12),(4,'lavelle','',1,'','','','','','https://upload.wikimedia.org/wikipedia/commons/thumb/0/00/Louislavelle.jpg/200px-Louislavelle.jpg',13),(5,'leibnez','',1,'','','','','','http://www.joseferreira.com.br/blogs/filosofia/e-books/e-book-discurso-de-metafisica-gottfried-leibn',14),(6,'mario_concreto','',1,'','','','','','http://www.erealizacoes.com.br/upload/colaborador/74/mario-ferreira-dos-santos1.jpg',15),(7,'vivaldi','',1,'','','','','','http://images.tiketa.lt/Files/2016.12/id_39570.jpg',16),(8,'wolfgangsmith','',1,'','','','','','https://images.gr-assets.com/authors/1517998098p5/254790.jpg',17),(9,'saotomas','',1,'','','','','','https://resenhasdefilosofia.files.wordpress.com/2012/11/sao-tomas-de-aquino-34984.jpg',18);
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (31,'Tecnologia'),(32,'Filosofia da Ciência'),(33,'Ciência'),(34,'Religião'),(35,'Economia'),(36,'Política'),(37,'Filosofia'),(38,'Globalismo'),(39,'Exatas'),(40,'Humanas');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compositions`
--

DROP TABLE IF EXISTS `compositions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compositions` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compositions`
--

LOCK TABLES `compositions` WRITE;
/*!40000 ALTER TABLE `compositions` DISABLE KEYS */;
INSERT INTO `compositions` VALUES (2,'2018-08-14 19:47:21','testezera braba','lembrar de alterar front dps lembrarei','2018-08-14 20:38:30'),(3,'2018-08-14 19:48:47','teste','teste','2018-08-14 19:48:47');
/*!40000 ALTER TABLE `compositions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_userid_foreign` (`userId`),
  CONSTRAINT `device_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device`
--

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` VALUES (34,'10.240.0.231','dha66ZcFWeg:APA91bGyy6fm1RnwgYcVgtzOZxOpAMpMl8HDU4sFpZMB2X0qm7vFUgKIp4ASdbS9b4_6qqNq9sd4e9SvOfH1O3sSmf84wefWrtfYqe-zDW5QJT1dqzewBTWTXL4gFUQe6i4lIpG6c42Cc7GW8kf6Y0uMqHyZokP7iw','cUFoVTF6Q2Jvb0p2d1pKWWxTQkQxWmFLVWpRT0lpbmtoeUhNdEhaZnllNDhuczF6WjlrY3d3VzdTWUVG5b6e0303bed21','Mozilla/5.0 (Linux; Android 7.0; SM-J730G Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/68.0.3440.91 Mobile Safari/537.36','2018-08-10 21:26:27',23),(35,'10.240.0.116',NULL,'dUlKdHRjcEVROXYydnlscUxtQzVpWTg5TXVsSDlkWXI1MDBrNHF0NHJFQkdsQnUzRWNjOExhSVNUeG165b74246f44174','PostmanRuntime/6.4.1','2018-08-15 13:02:39',23),(36,'10.240.0.233','fLPCHc1-1lQ:APA91bGqpWnZ4lZwimEuM9LGls0NSaF-PM-NJ366dvEOCWZVAAU5kJyJq45meQoJLECbPe09HMy3U3qiedcdxAl83P3WssDwlyYzlQyk54IyywuD6bSgw07O-ReB_ufA24uk1C64YdBDiGwnDzj2QLiJqIVfrQ7yZw','T29DZU5tZEU3TzRqTFVhRldUNENwNzNTaXlyMEc2RENqMmM5dUJwcmJMcEUycHZGV1pGaTV0MDZGZGJt5b718b970d6bf','Mozilla/5.0 (Linux; Android 7.0; SM-J730G Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/68.0.3440.91 Mobile Safari/537.36','2018-08-13 13:45:59',23),(37,'10.240.1.60',NULL,'NDlHYklqNFNIb0tGc3BHbFcxejNJeWxkV2tNUlJHUDFoUWJxWlM1YUw0aHA1aGExYlJBQkY1cG5LYmIz5b71a2b8d8c3c','PostmanRuntime/6.4.1','2018-08-13 15:24:40',24),(38,'10.240.1.60','dkqoPGC1djQ:APA91bGDalCW8HaO8IRVo-ndoTq7zpAuwLtCU1unC2AcczJBIEQ8VuMy1Hj_Nl4K7Q4pITk3RD4qwQdJ_eR2TaG6oRTtlIMdmWXOuKlteL-MBNfYjZVAK2L1YNkCgXlD5_tcAI4PXlwhCpTwyLgLHbDMmdCW_JLGVg','YkxGczZHT3RXdHRnbXdaUklRNnp5YmwyaWc3SHFNTWRVNFJ0c3NVNWhhTjFCWmlJQ1lCeXBacldYWk035b719d41a0580','Mozilla/5.0 (Linux; Android 7.0; SM-J730G Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/68.0.3440.91 Mobile Safari/537.36','2018-08-13 15:01:21',23),(39,'10.240.0.207','eu6LYV8tmZE:APA91bEADnOy7Cqd6dDq8wdCT9Gx_lxHwnV_9tP6QKiU-W8yRwB3ORssn_Nvr9uD41sPH8NCKlDTRTn-XAF1n8TECIV4crLMXtDOUNxHxyWQmLN3twFo_2yUUQzXvQlTUu2Abc5R1Z1otg8RxnIh39_g_UP-QeyzTQ','TjRmazRtWmdhV0YxZEtmdXpqOWFUeU1HUGNzemp6M2hxNzJKSFZvWkN5S3AxV1NYNFdBVEVRNmlRakZU5b71804055b7c','Mozilla/5.0 (Linux; Android 7.0; SM-J730G Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/68.0.3440.91 Mobile Safari/537.36','2018-08-13 12:57:36',23),(40,'10.240.0.118','e0yonhjOgdA:APA91bHsZoMC0uiko_u1PVyRH1OjZCbWVYLHDnCDLLXwyK1mPjL4Vk17dzArWyPTaFEnDBgia7DvVd8_rCdDFY9lattiDTo6MCyIAnovsiEEodn-QOH8qmQ_Cd1Mx2WfD9EYdQlL1l8Q2Lmj0hnWRN42BCiHIXRJFw','RzNXc0ZBQzlWeFhYV214dDRCZDlOWkhHTEhuaHJWSm5QV2p2OFpHQ1FreGpNbVpZeWNUd3hKcTFIbDNW5b719bea7b880','Mozilla/5.0 (Linux; Android 7.0; SM-J730G Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/68.0.3440.91 Mobile Safari/537.36','2018-08-13 14:55:38',23),(41,'10.240.0.233',NULL,'b3lia21Va0tGRVI2N0F3UnBrdWFjRXN2cXVwazVmRG5aakMwMTUwaHcySDRycDVtZVF0d240WXZNOW5W5b71a2c6e3864','PostmanRuntime/6.4.1','2018-08-13 15:24:55',24),(42,'10.240.1.21',NULL,'SFc4aXlCZUROUnhMR3hUcGZsOUI5VVE4OGtRRjdGaGFqVlI5UmVSeUdJcnZrMWRyYVlwY1BqbnBtSDI45b71a3676b852','PostmanRuntime/6.4.1','2018-08-13 15:27:35',18),(43,'10.240.1.21',NULL,'d1dXTEUwQ3JMVTZ5YXJveFRGa1NCTDhGNW5zTno3N2xIeWJSR29WYk1TSjF3VHc3M1dUSzRPN3I5S3Fn5b7424a535f76','PostmanRuntime/6.4.1','2018-08-15 13:03:33',23),(44,'10.240.0.68',NULL,'ZGFYbzRXNU8xVVg2dWY5WEw3R1BTRXE0OFMwQzQ2RkZYem5meTVKdGcwVml6MVFBNVR4S2xpc2FLSmxr5b7468fd8f000','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36','2018-08-15 17:55:09',9),(45,'10.240.0.231',NULL,'NGpqWTgwUndMakZha24yUmprV2lYcjI5eVRqTWt4TzFuZHcyeGV1bmdHNTBEMnlBREY5QmU2STZjV0hZ5b75d763','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36','2018-08-16 19:58:27',23),(46,'10.240.0.118',NULL,'VmppVFpJbWJtUmp6V1d2bzhGQ2xpV3BZQ0xDeHN4RGtxdURUNm9LdzNzbXprQnRoOVFlVGxnakJzQzA05b75c46063034','PostmanRuntime/6.4.1','2018-08-16 18:37:20',23),(47,'10.240.0.233',NULL,'WlJ1OWVhUXBZVjB1MUZReXpZa2F3RnFtWWVpdEdpMHg2cVZVM2xzNFBMZElRcmZxSklJc1N0Vm1Jd1Bo5b75d69713f69','PostmanRuntime/6.4.1','2018-08-16 19:55:03',9),(48,'10.240.1.78',NULL,'Q1BFZEJEamhrd2ZpelJ6ZnVZNHQwaWtyaHJmOUs3MnVXVmxTT1Q3a1dZRWJ0SGV5NTJFVFlRaGFOQ1Vy5b75d8cb5c886','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36','2018-08-16 20:04:27',23),(49,'10.240.0.68',NULL,'RmxvWFJnbFFXUElRdmsyME5lYXNlMTg3OVhvUGdmSHBpaGZ5cVFLM1FKb29KbTJuVGR1bUZwYUlYY2ZN5b75efae27f47','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36','2018-08-16 21:42:06',23),(50,'10.240.0.116',NULL,'NTRnVUo0NnhEcE9YY0tiOEQyYmlBYW1lejFwdER2REFKWFpZdmdWUkJTd0oyNk5VeG02NmVnU3BMTGtT5b76ce93d199c','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36','2018-08-17 13:33:07',23);
/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `folder_authorid_foreign` (`authorId`),
  CONSTRAINT `folder_authorid_foreign` FOREIGN KEY (`authorId`) REFERENCES `author` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder`
--

LOCK TABLES `folder` WRITE;
/*!40000 ALTER TABLE `folder` DISABLE KEYS */;
INSERT INTO `folder` VALUES (9,'Politica Nacional','',1),(10,'Politica Internacional','',1),(11,'Metafísica','',1);
/*!40000 ALTER TABLE `folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicationId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `image_publicationid_foreign` (`publicationId`),
  CONSTRAINT `image_publicationid_foreign` FOREIGN KEY (`publicationId`) REFERENCES `publication` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `like`
--

DROP TABLE IF EXISTS `like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like` (
  `userId` int(10) unsigned NOT NULL,
  `publicationId` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `like_userid_foreign` (`userId`),
  KEY `like_publicationid_foreign` (`publicationId`),
  CONSTRAINT `like_publicationid_foreign` FOREIGN KEY (`publicationId`) REFERENCES `publication` (`id`),
  CONSTRAINT `like_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like`
--

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
INSERT INTO `like` VALUES (23,387,'2018-08-16 02:03:40'),(22,387,'2018-08-16 02:04:13'),(23,410,'2018-08-17 21:02:34'),(23,411,'2018-08-17 22:25:09'),(23,408,'2018-08-18 01:14:07'),(23,405,'2018-08-18 01:14:16'),(23,392,'2018-08-18 01:32:39'),(23,412,'2018-08-19 17:44:11');
/*!40000 ALTER TABLE `like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (4,'2018_07_30_180115_create_user_table',1),(5,'2018_07_30_180216_create_device_table',2),(6,'2018_07_30_181203_create_author_table',3),(7,'2018_07_30_182108_create_unread_notification_table',4),(8,'2018_07_30_182537_create_relation_table',5),(9,'2018_07_30_182940_create_folder_table',6),(10,'2018_07_30_183658_create_publication_table',7),(11,'2018_07_30_183958_create_category_table',8),(12,'2018_07_30_184311_create_publication_category_table',9),(13,'2018_07_30_184428_create_image_table',10),(14,'2018_07_30_184614_create_like_table',11),(15,'2018_07_30_184939_create_saved_table',12),(16,'2018_07_30_185133_create_reset_password_table',13),(17,'2018_07_31_184650_update_token_in_device_table',14),(18,'2018_07_31_185745_update_token_in_device_table',15),(19,'2016_06_01_000001_create_oauth_auth_codes_table',16),(20,'2016_06_01_000002_create_oauth_access_tokens_table',16),(21,'2016_06_01_000003_create_oauth_refresh_tokens_table',16),(22,'2016_06_01_000004_create_oauth_clients_table',16),(23,'2016_06_01_000005_create_oauth_personal_access_clients_table',16),(24,'2018_08_01_014722_update_ip_in_device_table',17),(25,'2018_08_01_142528_update_token_in_device_table',18),(26,'2018_08_08_205156_update_publication_table',19),(27,'2018_08_17_221158_update_tablename_saved',20);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Monada Web Personal Access Client','3B0w5w5R9j15YpHCKzOySmqOEE7dTltQKZ5lEkAN','http://localhost',1,0,0,'2018-07-31 19:53:52','2018-07-31 19:53:52'),(2,NULL,'Monada Web Password Grant Client','CykIC3L9MuHhAvJxDWenfcZk2DYIawFOetGDlxAE','http://localhost',0,1,0,'2018-07-31 19:53:52','2018-07-31 19:53:52');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2018-07-31 19:53:52','2018-07-31 19:53:52');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publication`
--

DROP TABLE IF EXISTS `publication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publication` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `draft` tinyint(1) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `authorId` int(10) unsigned NOT NULL,
  `folderId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_authorid_foreign` (`authorId`),
  KEY `publication_folderid_foreign` (`folderId`),
  CONSTRAINT `publication_authorid_foreign` FOREIGN KEY (`authorId`) REFERENCES `author` (`id`),
  CONSTRAINT `publication_folderid_foreign` FOREIGN KEY (`folderId`) REFERENCES `folder` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=413 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publication`
--

LOCK TABLES `publication` WRITE;
/*!40000 ALTER TABLE `publication` DISABLE KEYS */;
INSERT INTO `publication` VALUES (7,NULL,'eae',NULL,NULL,'2018-08-08 21:13:12',9,NULL),(9,NULL,'Teste!!!',NULL,NULL,'2018-08-08 21:19:20',1,NULL),(10,NULL,'Teste!!!',NULL,NULL,'2018-08-08 21:27:49',1,NULL),(11,NULL,'Teste!!!',NULL,NULL,'2018-08-08 21:28:36',1,NULL),(12,NULL,'Teste!!!',NULL,NULL,'2018-08-08 21:29:54',1,NULL),(13,NULL,'Teste!!!',NULL,NULL,'2018-08-08 21:31:12',1,NULL),(14,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:08:31',1,NULL),(15,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:11:12',1,NULL),(16,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:16:05',1,NULL),(17,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:33:25',1,NULL),(18,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:35:47',1,NULL),(19,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:36:48',1,NULL),(20,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:37:35',1,NULL),(21,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:37:56',1,NULL),(22,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:38:51',1,NULL),(23,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:39:49',1,NULL),(24,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:40:37',1,NULL),(25,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:43:01',1,NULL),(26,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:43:37',1,NULL),(27,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:45:20',1,NULL),(28,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:46:05',1,NULL),(29,NULL,'Teste!!!',NULL,NULL,'2018-08-08 22:46:46',1,NULL),(30,NULL,'Teste!!!',NULL,NULL,'2018-08-08 23:35:17',1,NULL),(31,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:34:40',1,NULL),(32,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:36:03',1,NULL),(33,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:37:47',1,NULL),(34,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:38:09',1,NULL),(35,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:38:21',1,NULL),(36,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:38:55',1,NULL),(37,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:39:47',1,NULL),(38,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:41:50',1,NULL),(39,NULL,'Teste!!!',NULL,NULL,'2018-08-10 21:42:01',1,NULL),(40,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:45:07',1,NULL),(41,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:45:16',1,NULL),(42,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:45:47',1,NULL),(43,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:46:09',1,NULL),(44,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:47:00',1,NULL),(45,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:48:49',1,NULL),(46,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:49:27',1,NULL),(47,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:54:43',1,NULL),(48,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:55:01',1,NULL),(49,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:55:20',1,NULL),(50,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:55:43',1,NULL),(51,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:56:06',1,NULL),(52,NULL,'Teste!!!',NULL,NULL,'2018-08-10 23:58:55',1,NULL),(53,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:03:12',1,NULL),(54,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:03:44',1,NULL),(55,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:07:25',1,NULL),(56,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:07:36',1,NULL),(57,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:08:21',1,NULL),(58,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:08:34',1,NULL),(59,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:10:05',1,NULL),(60,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:10:44',1,NULL),(61,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:12:16',1,NULL),(62,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:46:25',1,NULL),(63,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:53:45',1,NULL),(64,NULL,'Teste!!!',NULL,NULL,'2018-08-11 00:54:33',1,NULL),(65,NULL,'Teste!!!',NULL,NULL,'2018-08-11 01:50:38',1,NULL),(66,NULL,'Teste!!!',NULL,NULL,'2018-08-11 01:50:48',1,NULL),(67,NULL,'Teste!!!',NULL,NULL,'2018-08-11 01:56:43',1,NULL),(68,NULL,'Teste!!!',NULL,NULL,'2018-08-11 01:59:41',1,NULL),(69,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:00:15',1,NULL),(70,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:00:28',1,NULL),(71,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:00:39',1,NULL),(72,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:01:17',1,NULL),(73,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:05:18',1,NULL),(74,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:08:30',1,NULL),(75,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:12:17',1,NULL),(76,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:12:37',1,NULL),(77,NULL,'Teste!!!',NULL,NULL,'2018-08-11 02:12:58',1,NULL),(78,NULL,'Teste!!!',NULL,NULL,'2018-08-11 03:15:45',1,NULL),(79,NULL,'Teste!!!',NULL,NULL,'2018-08-11 03:16:13',1,NULL),(80,NULL,'Teste!!!',NULL,NULL,'2018-08-11 13:52:36',1,NULL),(81,NULL,'Teste!!!',NULL,NULL,'2018-08-11 13:54:09',1,NULL),(82,NULL,'Teste!!!',NULL,NULL,'2018-08-11 13:56:06',1,NULL),(83,NULL,'Teste!!!',NULL,NULL,'2018-08-11 13:56:27',1,NULL),(84,NULL,'Teste!!!',NULL,NULL,'2018-08-13 10:55:37',1,NULL),(85,NULL,'Teste!!!',NULL,NULL,'2018-08-13 10:56:32',1,NULL),(86,NULL,'Teste!!!',NULL,NULL,'2018-08-13 10:56:51',1,NULL),(87,NULL,'Teste!!!',NULL,NULL,'2018-08-13 10:57:14',1,NULL),(88,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:02:18',1,NULL),(89,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:02:36',1,NULL),(90,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:02:43',1,NULL),(91,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:02:54',1,NULL),(92,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:09:22',1,NULL),(93,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:11:48',1,NULL),(94,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:14:18',1,NULL),(95,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:18:42',1,NULL),(96,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:20:50',1,NULL),(97,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:23:49',1,NULL),(98,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:26:22',1,NULL),(99,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:26:30',1,NULL),(100,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:26:37',1,NULL),(101,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:26:41',1,NULL),(102,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:26:46',1,NULL),(103,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:28:26',1,NULL),(104,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:31:53',1,NULL),(105,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:32:13',1,NULL),(106,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:36:00',1,NULL),(107,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:36:50',1,NULL),(108,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:38:31',1,NULL),(109,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:41:34',1,NULL),(110,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:41:51',1,NULL),(111,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:46:29',1,NULL),(112,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:48:45',1,NULL),(113,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:52:06',1,NULL),(114,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:53:46',1,NULL),(115,NULL,'Teste!!!',NULL,NULL,'2018-08-13 11:57:36',1,NULL),(116,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:12:48',1,NULL),(117,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:16:00',1,NULL),(118,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:19:01',1,NULL),(119,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:29:13',1,NULL),(120,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:31:43',1,NULL),(121,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:32:06',1,NULL),(122,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:34:03',1,NULL),(123,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:36:21',1,NULL),(124,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:40:47',1,NULL),(125,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:43:22',1,NULL),(126,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:49:17',1,NULL),(127,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:52:25',1,NULL),(128,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:52:39',1,NULL),(129,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:53:44',1,NULL),(130,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:55:21',1,NULL),(131,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:55:52',1,NULL),(132,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:56:17',1,NULL),(133,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:57:52',1,NULL),(134,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:58:05',1,NULL),(135,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:58:07',1,NULL),(136,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:59:37',1,NULL),(137,NULL,'Teste!!!',NULL,NULL,'2018-08-13 12:59:55',1,NULL),(138,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:24:18',1,NULL),(139,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:24:28',1,NULL),(140,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:31:10',1,NULL),(141,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:46:09',1,NULL),(142,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:48:18',1,NULL),(143,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:48:31',1,NULL),(144,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:52:34',1,NULL),(145,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:52:45',1,NULL),(146,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:53:53',1,NULL),(147,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:56:46',1,NULL),(148,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:56:54',1,NULL),(149,NULL,'Teste!!!',NULL,NULL,'2018-08-13 13:57:52',1,NULL),(150,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:00:31',1,NULL),(151,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:02:00',1,NULL),(152,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:14:58',1,NULL),(153,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:17:54',1,NULL),(154,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:18:00',1,NULL),(155,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:18:03',1,NULL),(156,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:18:06',1,NULL),(157,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:18:09',1,NULL),(158,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:18:12',1,NULL),(159,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:18:23',1,NULL),(160,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:25:41',1,NULL),(161,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:25:50',1,NULL),(162,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:29:01',1,NULL),(163,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:31:57',1,NULL),(164,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:35:31',1,NULL),(165,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:35:58',1,NULL),(166,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:36:03',1,NULL),(167,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:36:14',1,NULL),(168,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:36:28',1,NULL),(169,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:36:41',1,NULL),(170,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:36:58',1,NULL),(171,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:37:13',1,NULL),(172,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:37:26',1,NULL),(173,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:42:39',1,NULL),(174,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:42:58',1,NULL),(175,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:43:13',1,NULL),(176,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:45:40',1,NULL),(177,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:45:57',1,NULL),(178,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:46:06',1,NULL),(179,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:46:51',1,NULL),(180,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:46:58',1,NULL),(181,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:47:09',1,NULL),(182,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:47:13',1,NULL),(183,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:52:06',1,NULL),(184,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:52:15',1,NULL),(185,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:52:21',1,NULL),(186,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:52:27',1,NULL),(187,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:53:00',1,NULL),(188,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:54:20',1,NULL),(189,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:54:28',1,NULL),(190,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:56:10',1,NULL),(191,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:56:51',1,NULL),(192,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:57:01',1,NULL),(193,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:57:19',1,NULL),(194,NULL,'Teste!!!',NULL,NULL,'2018-08-13 14:57:41',1,NULL),(195,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:01:46',1,NULL),(196,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:02:41',1,NULL),(197,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:03:25',1,NULL),(198,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:03:39',1,NULL),(199,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:04:04',1,NULL),(200,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:04:15',1,NULL),(201,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:06:31',1,NULL),(202,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:12:34',1,NULL),(203,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:13:14',1,NULL),(204,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:15:24',1,NULL),(205,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:15:41',1,NULL),(206,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:15:53',1,NULL),(207,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:16:23',1,NULL),(208,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:25:24',1,NULL),(209,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:28:45',9,NULL),(210,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:28:59',9,NULL),(211,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:29:04',1,NULL),(212,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:29:17',1,NULL),(213,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:29:58',1,NULL),(214,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:30:09',9,NULL),(215,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:31:16',9,NULL),(216,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:31:21',1,NULL),(217,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:32:36',1,NULL),(218,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:33:35',1,NULL),(219,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:33:47',9,NULL),(220,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:34:27',9,NULL),(221,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:34:47',9,NULL),(222,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:35:38',1,NULL),(223,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:36:55',1,NULL),(224,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:37:16',9,NULL),(225,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:38:32',1,NULL),(226,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:42:35',1,NULL),(227,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:42:47',9,NULL),(228,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:42:56',9,NULL),(229,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:43:09',1,NULL),(230,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:51:57',1,NULL),(231,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:59:09',1,NULL),(232,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:59:19',1,NULL),(233,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:59:27',9,NULL),(234,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 15:59:41',9,NULL),(235,NULL,'Teste!!!',NULL,NULL,'2018-08-13 15:59:42',1,NULL),(236,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:00:07',1,NULL),(237,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 16:00:19',9,NULL),(238,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 16:01:13',9,NULL),(239,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:01:27',1,NULL),(240,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:01:45',1,NULL),(241,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:01:58',1,NULL),(242,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:02:42',1,NULL),(243,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:13:27',1,NULL),(244,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:13:48',1,NULL),(245,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 16:13:58',9,NULL),(246,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 16:14:21',9,NULL),(247,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:14:28',1,NULL),(248,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:15:19',1,NULL),(249,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:15:27',1,NULL),(250,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:15:34',1,NULL),(251,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:16:00',1,NULL),(252,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:16:10',1,NULL),(253,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:16:25',1,NULL),(254,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:16:42',1,NULL),(255,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 16:16:49',9,NULL),(256,NULL,'Teste!!!',NULL,NULL,'2018-08-13 16:16:54',1,NULL),(257,NULL,'Teste!!!',NULL,NULL,'2018-08-13 18:30:46',1,NULL),(258,NULL,'Teste!!!',NULL,NULL,'2018-08-13 18:31:04',1,NULL),(259,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 18:31:14',9,NULL),(260,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 18:32:24',9,NULL),(261,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 18:32:44',9,NULL),(262,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:00:25',9,NULL),(263,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:00:52',9,NULL),(264,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:01:26',9,NULL),(265,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:01:41',9,NULL),(266,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:07:09',9,NULL),(267,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:07:15',9,NULL),(268,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:07:27',1,NULL),(269,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:07:31',1,NULL),(270,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:08:16',1,NULL),(271,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:08:31',9,NULL),(272,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:08:37',9,NULL),(273,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:10:30',9,NULL),(274,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:11:41',9,NULL),(275,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:11:49',9,NULL),(276,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:14:07',9,NULL),(277,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:14:14',1,NULL),(278,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:14:21',1,NULL),(279,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:14:26',9,NULL),(280,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:16:39',9,NULL),(281,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:16:48',9,NULL),(282,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:21:53',9,NULL),(283,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:22:19',9,NULL),(284,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:22:35',9,NULL),(285,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:22:46',9,NULL),(286,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:22:55',1,NULL),(287,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:22:59',1,NULL),(288,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:23:19',1,NULL),(289,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:23:24',1,NULL),(290,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:23:27',1,NULL),(291,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:23:37',1,NULL),(292,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:23:47',9,NULL),(293,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:23:53',9,NULL),(294,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:23:56',1,NULL),(295,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:24:17',1,NULL),(296,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:24:26',9,NULL),(297,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:24:46',9,NULL),(298,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:24:55',1,NULL),(299,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:25:31',1,NULL),(300,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:25:36',9,NULL),(301,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:31:59',9,NULL),(302,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:32:04',9,NULL),(303,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:32:08',1,NULL),(304,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:32:18',1,NULL),(305,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:32:31',1,NULL),(306,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:32:34',1,NULL),(307,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:32:37',1,NULL),(308,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:32:41',9,NULL),(309,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:33:44',9,NULL),(310,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:33:50',9,NULL),(311,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:33:55',1,NULL),(312,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:33:59',1,NULL),(313,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:34:18',1,NULL),(314,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:34:20',9,NULL),(315,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:36:26',9,NULL),(316,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:36:28',1,NULL),(317,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:36:40',1,NULL),(318,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:36:41',9,NULL),(319,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:46:56',9,NULL),(320,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:47:02',9,NULL),(321,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:47:18',9,NULL),(322,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:47:35',1,NULL),(323,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:47:38',1,NULL),(324,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:51:39',1,NULL),(325,NULL,'Teste!!!',NULL,NULL,'2018-08-13 19:51:43',1,NULL),(326,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:51:49',9,NULL),(327,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:52:00',9,NULL),(328,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 19:58:13',9,NULL),(329,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:05:48',9,NULL),(330,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:05:58',9,NULL),(331,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:06:41',9,NULL),(332,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:07:18',9,NULL),(333,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:07:26',9,NULL),(334,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:07:32',9,NULL),(335,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:07:42',1,NULL),(336,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:07:48',9,NULL),(337,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:08:10',9,NULL),(338,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:08:50',9,NULL),(339,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:09:00',9,NULL),(340,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:09:05',1,NULL),(341,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:09:13',1,NULL),(342,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:09:36',1,NULL),(343,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:09:42',1,NULL),(344,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:09:47',9,NULL),(345,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:09:50',9,NULL),(346,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:13:29',9,NULL),(347,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:15:55',9,NULL),(348,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:16:12',9,NULL),(349,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:16:23',9,NULL),(350,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:16:25',1,NULL),(351,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:16:29',9,NULL),(352,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:19:37',9,NULL),(353,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:19:40',1,NULL),(354,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:19:46',1,NULL),(355,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:20:00',1,NULL),(356,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:20:04',9,NULL),(357,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:20:09',9,NULL),(358,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:20:27',9,NULL),(359,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:20:29',1,NULL),(360,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:20:44',1,NULL),(361,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:20:49',9,NULL),(362,NULL,'Teste2!!!',NULL,NULL,'2018-08-13 20:20:53',9,NULL),(363,NULL,'Teste!!!',NULL,NULL,'2018-08-13 20:20:56',1,NULL),(364,NULL,'Teste!!!',NULL,NULL,'2018-08-13 22:06:25',1,NULL),(365,NULL,'Teste!!!',NULL,NULL,'2018-08-13 22:07:06',1,NULL),(366,NULL,'Teste!!!',NULL,NULL,'2018-08-13 22:07:25',1,NULL),(367,NULL,'Teste!!!',NULL,NULL,'2018-08-13 22:07:42',1,NULL),(368,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 22:08:17',1,NULL),(369,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 22:10:02',1,NULL),(370,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 22:11:48',1,NULL),(371,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 22:12:19',1,NULL),(372,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 22:12:27',1,NULL),(373,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 22:52:16',1,NULL),(374,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 23:00:34',1,NULL),(375,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-13 23:00:50',1,NULL),(376,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-15 12:17:40',1,NULL),(377,NULL,'Teste2!!!',NULL,NULL,'2018-08-15 12:19:03',9,NULL),(378,NULL,'Teste2!!!',NULL,NULL,'2018-08-15 12:19:09',9,NULL),(379,NULL,'Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!! Tenho que fazer uma postagem gigantesca!!!',NULL,NULL,'2018-08-15 12:19:10',1,NULL),(380,'Postagem com video vimeo','Essa é uma postagem de teste com o link de um vídeo by video','https://vimeo.com/76979871',NULL,'2018-08-15 16:44:56',1,NULL),(381,'Postagem com video youtube','Essa é uma postagem de teste com o link de um vídeo by youtube','https://www.youtube.com/watch?v=6d69NL9KLLk',NULL,'2018-08-15 16:47:52',1,NULL),(382,'Postagem com link','Essa é uma postagem de teste com um link','https://laravel.com/docs/5.6/routing',NULL,'2018-08-15 16:48:34',1,NULL),(383,'Postagem com link sem metatags','Essa é uma postagem de teste com um link sem metagas','https://monada-web-tarcisiolima.c9users.io/',NULL,'2018-08-15 16:49:03',1,NULL),(384,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-15 16:50:51',1,NULL),(385,NULL,'Uma postagem posterior!!!',NULL,NULL,'2018-08-15 22:18:48',9,NULL),(386,NULL,'Opa!!!',NULL,NULL,'2018-08-15 22:20:43',9,NULL),(387,NULL,'Opa!!!',NULL,NULL,'2018-08-15 22:28:44',9,NULL),(388,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-16 18:51:26',1,NULL),(389,NULL,'Opa!!!',NULL,NULL,'2018-08-16 21:18:32',9,NULL),(390,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 11:46:54',1,NULL),(391,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 11:51:03',1,NULL),(392,NULL,'Opa!!!',NULL,NULL,'2018-08-17 11:58:56',9,NULL),(393,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 11:58:57',1,NULL),(394,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 11:59:41',1,NULL),(395,NULL,'Opa!!!',NULL,NULL,'2018-08-17 11:59:49',9,NULL),(396,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:16:16',1,NULL),(397,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:21:41',1,NULL),(398,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:36:51',1,NULL),(399,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:37:25',1,NULL),(400,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:38:26',1,NULL),(401,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:39:59',1,NULL),(402,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:48:39',1,NULL),(403,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 13:53:23',1,NULL),(404,NULL,'Opa!!!',NULL,NULL,'2018-08-17 13:54:04',9,NULL),(405,NULL,'Opa!!!',NULL,NULL,'2018-08-17 14:03:16',9,NULL),(406,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 14:13:01',1,NULL),(407,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-06-17 14:13:17',1,NULL),(408,NULL,'Opa!!!',NULL,NULL,'2018-07-17 14:13:21',9,NULL),(409,'Postagem com link com metatagsss','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2017-08-17 14:13:33',1,NULL),(410,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 14:14:10',1,NULL),(411,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 20:20:19',1,NULL),(412,'Postagem com link com metatags','Essa é uma postagem de teste com um link sem metagas','https://medium.com/red-academy-journal/como-internacionalizar-seu-app-em-ionic-2-bd452efb0b8c',NULL,'2018-08-17 20:27:41',1,NULL);
/*!40000 ALTER TABLE `publication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publication_category`
--

DROP TABLE IF EXISTS `publication_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publication_category` (
  `publicationId` int(10) unsigned NOT NULL,
  `categoryId` int(10) unsigned NOT NULL,
  KEY `publication_category_publicationid_foreign` (`publicationId`),
  KEY `publication_category_categoryid_foreign` (`categoryId`),
  CONSTRAINT `publication_category_categoryid_foreign` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  CONSTRAINT `publication_category_publicationid_foreign` FOREIGN KEY (`publicationId`) REFERENCES `publication` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publication_category`
--

LOCK TABLES `publication_category` WRITE;
/*!40000 ALTER TABLE `publication_category` DISABLE KEYS */;
INSERT INTO `publication_category` VALUES (7,36),(7,35),(7,34),(9,37),(9,36),(412,32),(412,34),(412,35);
/*!40000 ALTER TABLE `publication_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relation`
--

DROP TABLE IF EXISTS `relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relation` (
  `followerId` int(10) unsigned NOT NULL,
  `followingId` int(10) unsigned NOT NULL,
  `muted` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `relation_followerid_foreign` (`followerId`),
  KEY `relation_followingid_foreign` (`followingId`),
  CONSTRAINT `relation_followerid_foreign` FOREIGN KEY (`followerId`) REFERENCES `user` (`id`),
  CONSTRAINT `relation_followingid_foreign` FOREIGN KEY (`followingId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relation`
--

LOCK TABLES `relation` WRITE;
/*!40000 ALTER TABLE `relation` DISABLE KEYS */;
INSERT INTO `relation` VALUES (9,15,0,'2018-08-04 19:52:23'),(9,13,0,'2018-08-04 19:52:23'),(9,17,0,'2018-08-04 19:52:23'),(9,18,0,'2018-08-04 19:52:23'),(22,13,0,'2018-08-04 21:31:33'),(22,17,0,'2018-08-04 21:31:33'),(22,14,0,'2018-08-04 21:31:33'),(22,16,0,'2018-08-04 21:31:33'),(23,13,0,'2018-08-04 21:56:17'),(23,17,0,'2018-08-04 21:56:17'),(23,18,0,'2018-08-04 21:56:17'),(23,15,0,'2018-08-04 21:56:17'),(23,16,0,'2018-08-04 21:56:17'),(9,24,0,'2018-08-08 22:08:26'),(23,24,0,'2018-08-10 21:37:40');
/*!40000 ALTER TABLE `relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reset_password` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password`
--

LOCK TABLES `reset_password` WRITE;
/*!40000 ALTER TABLE `reset_password` DISABLE KEYS */;
INSERT INTO `reset_password` VALUES ('gabriel11@gmail.com','WUxEc09ZekVwbFRabUsyMUZWblQzbG9xdGRtN2RDSlFTQzR5blFBVmVtdTNGa0I2NnNwdWhva1FtNG5T5b61d8df33170','2018-08-01 15:59:27'),('gmoraizsilva@gmail.com','cUc1WXNWRXRPUTE4MU9zdkNXcWtrd0hNdlpwVDJJUWtMb0t5MzQyRFlRNjlOUkRpNGUwWm02d0ViMHp55b661f630480d','2018-08-04 21:49:23');
/*!40000 ALTER TABLE `reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `save`
--

DROP TABLE IF EXISTS `save`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `save` (
  `userId` int(10) unsigned NOT NULL,
  `publicationId` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `saved_userid_foreign` (`userId`),
  KEY `saved_publicationid_foreign` (`publicationId`),
  CONSTRAINT `saved_publicationid_foreign` FOREIGN KEY (`publicationId`) REFERENCES `publication` (`id`),
  CONSTRAINT `saved_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `save`
--

LOCK TABLES `save` WRITE;
/*!40000 ALTER TABLE `save` DISABLE KEYS */;
INSERT INTO `save` VALUES (23,410,'2018-08-17 22:25:03'),(23,411,'2018-08-17 22:29:43'),(23,405,'2018-08-18 01:14:18'),(23,395,'2018-08-18 01:42:41');
/*!40000 ALTER TABLE `save` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unread_notification`
--

DROP TABLE IF EXISTS `unread_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unread_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` enum('LIKE','RELATION','PUBLICATION','SYSTEM') COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unread_notification_userid_foreign` (`userId`),
  CONSTRAINT `unread_notification_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unread_notification`
--

LOCK TABLES `unread_notification` WRITE;
/*!40000 ALTER TABLE `unread_notification` DISABLE KEYS */;
INSERT INTO `unread_notification` VALUES (40,'PUBLICATION',26,9),(41,'PUBLICATION',27,9),(42,'PUBLICATION',28,9),(43,'PUBLICATION',29,9),(44,'PUBLICATION',30,9),(396,'PUBLICATION',385,9),(398,'PUBLICATION',386,9),(400,'PUBLICATION',387,9),(402,'PUBLICATION',388,9),(404,'PUBLICATION',389,9),(406,'PUBLICATION',390,9),(408,'PUBLICATION',391,9),(410,'PUBLICATION',9,9),(412,'PUBLICATION',1,9),(414,'PUBLICATION',1,9),(416,'PUBLICATION',9,9),(418,'PUBLICATION',1,9),(420,'PUBLICATION',1,9),(422,'PUBLICATION',1,9),(424,'PUBLICATION',1,9),(426,'PUBLICATION',1,9),(428,'PUBLICATION',1,9),(430,'PUBLICATION',1,9),(432,'PUBLICATION',1,9),(434,'PUBLICATION',9,9),(436,'PUBLICATION',9,9),(438,'PUBLICATION',1,9),(440,'PUBLICATION',1,9),(442,'PUBLICATION',9,9),(444,'PUBLICATION',1,9),(446,'PUBLICATION',1,9),(447,'PUBLICATION',1,9),(449,'PUBLICATION',1,9);
/*!40000 ALTER TABLE `unread_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Gabriel Morais','gabriel@gmail.com','123456'),(2,'Gabriel Morais','gabriel5@gmail.com','123456'),(3,'Gabriel Morais','gabriel6@gmail.com','123456'),(4,'Gabriel Morais','gabriel7@gmail.com','123456'),(5,'Gabriel Morais','gabriel8@gmail.com','123456'),(6,'Gabriel Morais','gabriel9@gmail.com','123456'),(7,'Gabriel Morais','gabriel10@gmail.com','123456'),(8,'Gabriel Morais','gabriel11@gmail.com','$2y$10$iz52ERSfuwl80vsPU1nvHOnVE7P6XjRPHgN3qkdxGzcbvRtJCNjbi'),(9,'Gabriel Morais Silva','gmoraizsilva@gmail.com','$2y$10$gPPCuyE6OpRGaDaHoya7Y.0k3mhS3cSNvNKlSQF0Y0PFlQX/Nycjq'),(10,'Olavo de Carvalho','olavodecarvalho@presencatotal.com',''),(11,'Socrates Ateniense','socr4tes@presencatotal.com',''),(12,'Platao Causal','plata0@presencatotal.com',''),(13,'Louis Lavelle','lavelle@presencatotal.com',''),(14,'Gottfried Wilhelm Leibniz','leibnez@presencatotal.com',''),(15,'Mário Ferreira dos Santos','mario_concreto@presencatotal.com',''),(16,'Antonio Vivaldi','vivaldi@presencatotal.com',''),(17,'Wolfgang Smith','wolfgangsmith@presencatotal.com',''),(18,'Tomás de Aquino','saotomas@presencatotal.com','$2y$10$iz52ERSfuwl80vsPU1nvHOnVE7P6XjRPHgN3qkdxGzcbvRtJCNjbi'),(19,'Gabriel Morais Silva','teste@gmail.com','$2y$10$5iZsPjSMhqNHd7C56dBqkO2c8kcO1ku.qKYgSp/MR6nt6TtRHiMKm'),(20,'Gabriel Morais Silva','teste2@gmail.com','$2y$10$UPmcTFf2EYkjfBhBUVs/k.WaeS3sJ1edpuS.Yqc/u4FlCu18Cy26q'),(21,'Gabriel Morais Silva','teste3@gmail.com','$2y$10$GXH0qjt6B72TDfvq.C5P.uRVHRj.gPDX2W7VoNIIONaCeVenomHvm'),(22,'Gabriel Morais Silva','teste4@gmail.com','$2y$10$bufDAWBfMboDhLt8l4a.jO8TQiSJ3R/wvvxD2B9CSOyJVGOr.Gg/u'),(23,'Gabriel Morais','gmoraizteste@gmail.com','$2y$10$PANKEchTQPGxjqDKy9fT9OroHp80PsSr3jqIR214yPa5Fp35mTfU.'),(24,'Olavo de carvalho','olavo@monada.com','$2y$10$iz52ERSfuwl80vsPU1nvHOnVE7P6XjRPHgN3qkdxGzcbvRtJCNjbi');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-20 22:09:16
