-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: s_marlin
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `permissions` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Standart user',NULL),(2,'Administrator','{\"admin\":1}');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_cookie`
--

DROP TABLE IF EXISTS `user_cookie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_cookie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(225) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_cookie_idx` (`user_id`),
  CONSTRAINT `fk_user_cookie` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_cookie`
--

LOCK TABLES `user_cookie` WRITE;
/*!40000 ALTER TABLE `user_cookie` DISABLE KEYS */;
INSERT INTO `user_cookie` VALUES (10,6,'af6db7c9024b1db9882b831d49b0cd9b41077e1a46baa080eca1d168e660a663');
/*!40000 ALTER TABLE `user_cookie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `status` varchar(255) DEFAULT NULL,
  `date_reg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_groups_idx` (`group_id`),
  KEY `fk_groups_id_idx` (`group_id`),
  KEY `fk_group_idx` (`group_id`),
  CONSTRAINT `fk_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'asd@asd.com','$2y$10$9dUc/venFzYIdaM1v/XjbOJrLO2X9NVlCTeMOA78oK5M7j10zl.Qm','Оля',1,'Статус : королевский',NULL),(5,'zxc@zxc.o','$2y$10$Q7gbUnrkDCC.BkwBSubJEeRiOobhPlo30QVcGjX8gqdpTpEa4iB42','Настя',2,'Красиво жить не запретишь',NULL),(6,'nnn@mm.com','$2y$10$uboEqZrI7csUHYJfzTHUUOwTGNKpF67zVbx66zAUD85QzW7zerJri','Марина',2,'Учиться, учиться и еще раз учиться!!!',NULL),(7,'n1nn@mm.com','$2y$10$hfHqIACOIq8qdHQAmFmSo.zywVXnLdKhtHaGyRNPrdSvkJ21AsCUW','Саша',1,'всегда готов!!!',NULL),(8,'lol@l.c','$2y$10$yEnMtx.Z.wo/VUaDPvahkuqgcz1/u7cRd7CnzAKlpEcFtY23SQ2oC','Любовь',1,'Улыбка - это лучший макияж.',NULL),(9,'go@go.go','$2y$10$Dg./V7muEJD.uDgLTJWji.bHN4arrGL0IOElblHp38F/L3XYuwbgq','Гоша',1,'Книжки читай, а не чужие статусы',NULL),(10,'vvv@v.v','$2y$10$REFVpuQmQhpMy.B7/9lYW.WXNha5bF2j6gm0Wk3EreeT0/W6xEpmy','Виктория',1,'Победа',NULL),(11,'ss@s.s','$2y$10$58nw57Po79WEpApdZ5k/7ub1GSg.od5NIKR0uuXCVC8GPHMeT5TZy','света',1,'Страдаю из-за мелочей...',NULL),(13,'1ooo@o.o','$2y$10$h9V5cu5qVogo/WhMNxZRdOtvvTGIOD85056Upi91Gvn3uh4m/6ExO','Олег',1,'Занят, идите спать!',NULL),(15,'fff@f.f','$2y$10$x4aGpxntO3FtFPfL47f8x.4dkKGCCRPJB5AMeH1aEk5hPlxX1/xAK','Федор',1,'Легко',NULL),(16,'ddd@d.d','$2y$10$W5U8mYicryVwa1LxR47Dde1Pvc12nd.nAPneMv5/Sd97fPsLi.l8a','Дмитрий',1,'Жизнь-......',NULL),(17,'yyy@y.y','$2y$10$gl4kz/Q2f4uzTXI1M4A10Oa9sCWbgU3qgYCnjHl5w0X4pKNV4uuDW','Юлия',1,'Загрузка статуса ...',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-28 11:18:00
