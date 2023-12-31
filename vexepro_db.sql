-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: vexepro
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agencies`
--

DROP TABLE IF EXISTS `agencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agencies`
--

LOCK TABLES `agencies` WRITE;
/*!40000 ALTER TABLE `agencies` DISABLE KEYS */;
INSERT INTO `agencies` VALUES (1,'Nh├á xe H╞░ng Long'),(2,'T├ón Ho├áng Minh'),(3,'C├┤ng ty X');
/*!40000 ALTER TABLE `agencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stations`
--

DROP TABLE IF EXISTS `stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stations`
--

LOCK TABLES `stations` WRITE;
/*!40000 ALTER TABLE `stations` DISABLE KEYS */;
INSERT INTO `stations` VALUES (1,'Bß║┐n xe N╞░ß╗¢c Ngß║ºm','H├á Nß╗Öi'),(2,'Bß║┐n xe Gi├íp B├ít','H├á Nß╗Öi'),(3,'Bß║┐n xe trung t├óm ─É├á Nß║╡ng','─É├á Nß║╡ng'),(4,'Bß║┐n xe ─Éß╗⌐c Long','─É├á Nß║╡ng'),(5,'Bß║┐n xe Miß╗ün T├óy','TP. Hß╗ô Ch├¡ Minh'),(6,'Bß║┐n xe Miß╗ün ─É├┤ng','TP. Hß╗ô Ch├¡ Minh');
/*!40000 ALTER TABLE `stations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `trip_id` int NOT NULL,
  `status` enum('pending','active','canceled','used') COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`trip_id`,`seat`),
  KEY `vehicle_route_id_idx` (`trip_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `vehicle_route_id` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (101,8,100,'active','C34'),(102,7,100,'active','A11'),(103,6,100,'active','B21'),(104,2,100,'active','B21'),(105,8,96,'active','A12'),(106,9,96,'active','C31'),(107,9,96,'active','C32'),(108,8,96,'active','A14'),(109,10,96,'active','B21'),(110,10,120,'active','A11'),(111,10,120,'active','B22'),(112,7,120,'active','A14'),(113,7,120,'active','C32'),(114,3,120,'active','B21'),(115,6,98,'active','B25'),(116,3,98,'active','B22'),(117,5,98,'active','A12'),(118,7,98,'active','B22'),(119,5,98,'active','A13'),(120,6,112,'active','A11'),(121,6,112,'active','C31'),(122,1,112,'active','A14'),(123,6,112,'active','A12'),(124,3,112,'active','B22'),(125,7,95,'active','A11'),(126,9,95,'active','B21'),(127,9,95,'active','C35'),(128,1,97,'active','A11'),(129,3,97,'active','B22'),(130,2,97,'active','B21'),(131,9,108,'active','B21'),(132,4,108,'active','A13'),(133,3,108,'active','B22'),(134,9,108,'active','C32'),(135,8,103,'active','A14'),(136,6,103,'active','B21'),(137,7,103,'active','A13'),(138,3,103,'active','A11'),(139,9,103,'active','B23'),(140,2,110,'active','B22'),(141,2,110,'active','A14'),(142,4,110,'active','A13'),(143,9,110,'active','A12'),(144,5,110,'active','A11'),(145,4,93,'active','A14'),(146,5,93,'active','C31'),(147,3,93,'active','B21'),(148,8,113,'active','A13'),(149,5,113,'active','B22'),(150,4,113,'active','B24'),(151,4,121,'active','C34'),(152,6,121,'active','A13'),(153,1,121,'active','B23'),(154,10,121,'active','A14'),(155,7,121,'active','C33'),(156,3,105,'active','A11'),(157,9,105,'active','B23'),(158,5,105,'active','B24'),(159,10,105,'active','C33'),(160,3,105,'active','C31'),(161,9,92,'active','B22'),(162,3,92,'active','A15'),(163,4,92,'active','B25'),(164,5,114,'active','A15'),(165,6,114,'active','C35'),(166,1,114,'active','B24'),(167,10,101,'active','B24'),(168,10,101,'active','B23'),(169,9,101,'active','C33'),(170,2,101,'active','B25'),(171,6,101,'active','A12'),(172,7,118,'active','C32'),(173,8,118,'active','B23'),(174,2,118,'active','C32'),(175,6,118,'active','A12'),(176,4,118,'active','C31'),(177,2,111,'active','A12'),(178,8,111,'active','A11'),(179,1,111,'active','C35'),(180,3,111,'active','A13'),(181,2,111,'active','B24'),(182,7,106,'active','A15'),(183,5,106,'active','A15'),(184,5,106,'active','B25'),(189,1,117,'pending','A11'),(192,1,117,'pending','A21');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `station_id_start` int NOT NULL,
  `station_id_end` int NOT NULL,
  `start_time` datetime NOT NULL,
  `est_time` time NOT NULL,
  `remaining_slots` int NOT NULL,
  `price` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle_id` (`vehicle_id`,`station_id_start`,`station_id_end`,`start_time`),
  KEY `station_id_start_idx` (`station_id_start`),
  KEY `station_id_end_idx` (`station_id_end`),
  CONSTRAINT `station_id_end` FOREIGN KEY (`station_id_end`) REFERENCES `stations` (`id`),
  CONSTRAINT `station_id_start` FOREIGN KEY (`station_id_start`) REFERENCES `stations` (`id`),
  CONSTRAINT `vehicle_id` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
INSERT INTO `trips` VALUES (92,2,5,3,'2023-04-28 08:00:00','05:00:00',27,390000),(93,7,4,6,'2023-04-20 16:30:00','03:30:00',27,460000),(94,4,3,1,'2023-04-18 12:00:00','02:30:00',30,490000),(95,7,6,3,'2023-04-21 05:30:00','03:00:00',27,480000),(96,5,1,4,'2023-04-23 04:00:00','02:30:00',25,450000),(97,12,3,1,'2023-04-23 16:00:00','03:30:00',27,370000),(98,15,2,6,'2023-04-28 03:00:00','03:00:00',17,410000),(99,7,3,1,'2023-04-21 13:30:00','03:00:00',30,340000),(100,3,2,5,'2023-04-21 11:00:00','02:30:00',26,250000),(101,5,5,2,'2023-04-22 02:30:00','03:30:00',25,330000),(102,2,1,5,'2023-04-22 06:30:00','03:00:00',30,470000),(103,15,3,6,'2023-04-17 07:00:00','04:00:00',17,390000),(104,2,4,5,'2023-04-25 16:00:00','03:00:00',30,400000),(105,1,4,1,'2023-04-25 04:00:00','03:30:00',25,480000),(106,15,1,6,'2023-04-25 16:00:00','04:30:00',19,490000),(107,8,2,6,'2023-04-20 18:00:00','03:30:00',30,230000),(108,12,1,3,'2023-04-30 04:30:00','05:00:00',26,250000),(109,13,2,6,'2023-04-26 01:30:00','01:30:00',30,450000),(110,11,6,3,'2023-04-25 17:30:00','02:00:00',25,210000),(111,6,6,3,'2023-04-15 21:00:00','04:00:00',25,200000),(112,8,6,5,'2023-04-20 13:00:00','05:30:00',25,500000),(113,1,5,1,'2023-04-21 06:00:00','05:30:00',27,350000),(114,10,5,3,'2023-04-16 18:00:00','02:30:00',27,210000),(115,12,3,1,'2023-04-26 11:30:00','03:00:00',30,460000),(116,6,3,1,'2023-04-23 13:30:00','05:00:00',30,240000),(117,10,2,1,'2023-04-19 08:30:00','04:00:00',28,500000),(118,7,5,4,'2023-04-29 23:00:00','05:30:00',25,350000),(119,17,5,3,'2023-04-30 13:00:00','02:30:00',22,360000),(120,13,6,5,'2023-04-21 15:00:00','04:30:00',25,290000),(121,9,3,1,'2023-04-26 16:00:00','05:30:00',25,420000);
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int NOT NULL,
  `tel` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('customer','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'loc','$2y$10$KYfKcVte0BvBy2cbXh2vCOroLGrMkZw1MIUzB037q.5EKEQBvgP.u','Loc',34,'0946358730','loc@email.com','─É├á Nß║╡ng','customer'),(2,'duc','$2y$10$TcnzpEOUQqn1K2lGkg9rnO1kvkWeIItA.51rpLeiUAMhcVPUgwXbC','Duc',26,'0930187017','duc@email.com','H├á Nß╗Öi','customer'),(3,'anh','$2y$10$Cim.PnOmW9ISTQaDAR5nGukSCa4fTP9VlLI4iu4Zq3V1z8UzmaGQC','Anh',21,'0967911189','anh@email.com','Nam ─Éinh','customer'),(4,'an','$2y$10$OeF/A6i13LTmjWvoIWEbRup.kIdZUi3XAWT.njGWeD7uTjmUX3Qdi','An',27,'0948831179','an@email.com','Nam ─Éinh','customer'),(5,'long','$2y$10$vQbPGMgcevD1tZ/IY5Ere.LgfUzguzQF5lj7Nhj5ssOP1ip/xZjrG','Long',31,'0976336532','long@email.com','H├á Nß╗Öi','customer'),(6,'hung','$2y$10$304kYGmvC9cgUZYvyqfOSOc28bC3vGo1ju9se4FJSgrBwAuUV7l8.','Hung',21,'0982856035','hung@email.com','Thanh H├│a','customer'),(7,'phuong','$2y$10$Yijiwe.nUnzYjLxr.eJeEu9kvMJlWU9wjPVEU0PLtJOL.3/lxaVTa','Phuong',27,'0956081922','phuong@email.com','Huß║┐','customer'),(8,'nhi','$2y$10$z7jQHYrzvfhNWKSvStrusOVEpaSjNvn4EaLXjHV29c84hlOA/z1Gi','Nhi',20,'0961666816','nhi@email.com','Huß║┐','customer'),(9,'huyen','$2y$10$ffx23iBzrZiG5Zj6522NuOHRcKBfioWykGEi.CRUwiAU.9crJDajC','Huyen',24,'0956801881','huyen@email.com','H├á Nß╗Öi','customer'),(10,'trang','$2y$10$7K0ucRf.Ol14wks.SRT6wuessCHvAwlm1qdgNIv9It8Ra3RG7bFYe','Trang',22,'0992332312','trang@email.com','─É├á Nß║╡ng','customer'),(11,'minh','$2y$10$IlaT3Ay8MNxvrSPK131gGeuV68B1xzAxAKjQa/SsJ.OMJGcA1giWq','Minh',23,'0948432217','minh@gmail.com','H├á Nß╗Öi','admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_vouchers`
--

DROP TABLE IF EXISTS `users_vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_vouchers` (
  `user_id` int NOT NULL,
  `voucher_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`voucher_id`),
  KEY `voucher_id_idx` (`voucher_id`),
  CONSTRAINT `user_voucher_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `voucher_id` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_vouchers`
--

LOCK TABLES `users_vouchers` WRITE;
/*!40000 ALTER TABLE `users_vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_types`
--

DROP TABLE IF EXISTS `vehicle_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `row` int NOT NULL,
  `level` int NOT NULL,
  `line` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_types`
--

LOCK TABLES `vehicle_types` WRITE;
/*!40000 ALTER TABLE `vehicle_types` DISABLE KEYS */;
INSERT INTO `vehicle_types` VALUES (1,'Gi╞░ß╗¥ng nß║▒m 30 chß╗ù',3,2,5),(2,'Limousine gi╞░ß╗¥ng ph├▓ng 30 chß╗ù',3,2,5),(3,'Limousine 20 Gi╞░ß╗¥ng VIP (c├│ WC)',2,2,5);
/*!40000 ALTER TABLE `vehicle_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `agency_id` int NOT NULL,
  `type_id` int NOT NULL,
  `plate_num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `station_id_idx` (`agency_id`),
  KEY `type_id_idx` (`type_id`),
  CONSTRAINT `station_id` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`),
  CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `vehicle_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,1,1,'33C-366.55'),(2,1,1,'33A-855.87'),(3,1,2,'31C-890.43'),(4,1,2,'32B-391.72'),(5,2,1,'31F-311.92'),(6,2,1,'30A-608.23'),(7,2,1,'31B-340.24'),(8,2,2,'31E-748.65'),(9,2,2,'29E-158.46'),(10,2,2,'31E-891.31'),(11,3,2,'32C-132.93'),(12,3,2,'32F-751.32'),(13,3,2,'30E-969.20'),(14,3,3,'33A-675.17'),(15,3,3,'32B-795.36'),(16,3,3,'30C-953.42'),(17,3,3,'32F-353.86');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vouchers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `percentage` int NOT NULL,
  `valid_from` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_to` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vouchers`
--

LOCK TABLES `vouchers` WRITE;
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-13 22:03:20
