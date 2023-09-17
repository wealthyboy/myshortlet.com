-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: myshortlet
-- ------------------------------------------------------
-- Server version	8.0.22

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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (1,1,'Created a new attribute called 3 Bedrooms','Jacky','jacob.atam@gmail.com','2021-06-06 17:01:53','2021-06-06 17:01:53',NULL),(2,1,'Created a new attribute called 2 Bedrooms','Jacky','jacob.atam@gmail.com','2021-06-06 17:02:02','2021-06-06 17:02:02',NULL),(3,1,'Created a new attribute called 1 bedroom','Jacky','jacob.atam@gmail.com','2021-06-06 17:02:11','2021-06-06 17:02:11',NULL),(4,1,'Created a new attribute called Bedroom 1','Jacky','jacob.atam@gmail.com','2021-06-06 17:02:28','2021-06-06 17:02:28',NULL),(5,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-06-06 17:13:08','2021-06-06 17:13:08',NULL),(6,1,'Created a new attribute called Bedroom 1','Jacky','jacob.atam@gmail.com','2021-06-06 17:13:49','2021-06-06 17:13:49',NULL),(7,1,'Created a new attribute called Bedroom 2','Jacky','jacob.atam@gmail.com','2021-06-06 17:14:12','2021-06-06 17:14:12',NULL),(8,1,'Created a new attribute called Bedroom 3','Jacky','jacob.atam@gmail.com','2021-06-06 17:14:37','2021-06-06 17:14:37',NULL),(9,1,'Created a new attribute called 1 queen bed','Jacky','jacob.atam@gmail.com','2021-06-06 17:14:50','2021-06-06 17:14:50',NULL),(10,1,'Created a new attribute called 1 queen bed','Jacky','jacob.atam@gmail.com','2021-06-06 17:15:28','2021-06-06 17:15:28',NULL),(11,1,'Created a new attribute called Internet','Jacky','jacob.atam@gmail.com','2021-06-06 18:57:51','2021-06-06 18:57:51',NULL),(12,1,'Created a new attribute called Bathroom','Jacky','jacob.atam@gmail.com','2021-06-06 19:24:54','2021-06-06 19:24:54',NULL),(13,1,'Created a new attribute called Toilet paper','Jacky','jacob.atam@gmail.com','2021-06-06 19:25:09','2021-06-06 19:25:09',NULL),(14,1,'Created a new attribute called Towels','Jacky','jacob.atam@gmail.com','2021-06-06 19:25:27','2021-06-06 19:25:27',NULL),(15,1,'Created a new attribute called Towels/Sheets','Jacky','jacob.atam@gmail.com','2021-06-06 19:26:54','2021-06-06 19:26:54',NULL),(16,1,'Created a new attribute called Bathtub or shower','Jacky','jacob.atam@gmail.com','2021-06-06 19:31:31','2021-06-06 19:31:31',NULL),(17,1,'Created a new attribute called Room Amenities','Jacky','jacob.atam@gmail.com','2021-06-06 19:36:47','2021-06-06 19:36:47',NULL),(18,1,'Created a new attribute called Socket near the bed','Jacky','jacob.atam@gmail.com','2021-06-06 19:37:28','2021-06-06 19:37:28',NULL),(19,1,'Created a new attribute called Hardwood or parquet floors','Jacky','jacob.atam@gmail.com','2021-06-06 19:40:22','2021-06-06 19:40:22',NULL),(20,1,'Created a new attribute called Heating','Jacky','jacob.atam@gmail.com','2021-06-06 19:44:51','2021-06-06 19:44:51',NULL),(21,1,'Created a new attribute called Check in','Jacky','jacob.atam@gmail.com','2021-06-06 19:47:38','2021-06-06 19:47:38',NULL),(22,1,'Created a new attribute called 12AM noon','Jacky','jacob.atam@gmail.com','2021-06-06 19:48:10','2021-06-06 19:48:10',NULL),(23,1,'Created a new attribute called Check out','Jacky','jacob.atam@gmail.com','2021-06-06 19:49:45','2021-06-06 19:49:45',NULL),(24,1,'Created a new attribute called 12 mid night','Jacky','jacob.atam@gmail.com','2021-06-06 19:52:46','2021-06-06 19:52:46',NULL),(25,1,'Created a new attribute called Pets','Jacky','jacob.atam@gmail.com','2021-06-06 20:01:13','2021-06-06 20:01:13',NULL),(26,1,'Created a new attribute called No pets allowed','Jacky','jacob.atam@gmail.com','2021-06-06 20:02:23','2021-06-06 20:02:23',NULL),(27,1,'Created a new attribute called Pets allowed','Jacky','jacob.atam@gmail.com','2021-06-06 20:02:41','2021-06-06 20:02:41',NULL),(28,1,'Created a new attribute called Children & Beds','Jacky','jacob.atam@gmail.com','2021-06-06 20:11:38','2021-06-06 20:11:38',NULL),(29,1,'Created a new attribute called Children of all ages are welcome.','Jacky','jacob.atam@gmail.com','2021-06-06 20:13:34','2021-06-06 20:13:34',NULL),(30,1,'Created a new attribute called Children 18 and above are considered adults at this property.','Jacky','jacob.atam@gmail.com','2021-06-06 20:13:51','2021-06-06 20:13:51',NULL),(31,1,'Created a new attribute called This property doesn\'t offer extra beds.','Jacky','jacob.atam@gmail.com','2021-06-06 20:14:11','2021-06-06 20:14:11',NULL),(32,1,'Created a new attribute called Age restriction','Jacky','jacob.atam@gmail.com','2021-06-06 20:14:38','2021-06-06 20:14:38',NULL),(33,1,'Created a new attribute called The minimum age for check-in is 18','Jacky','jacob.atam@gmail.com','2021-06-06 20:16:26','2021-06-06 20:16:26',NULL),(34,1,'Created a new attribute called Cards accepted at this property','Jacky','jacob.atam@gmail.com','2021-06-06 20:25:40','2021-06-06 20:25:40',NULL),(35,1,'Created a new attribute called Smoking','Jacky','jacob.atam@gmail.com','2021-06-06 20:25:52','2021-06-06 20:25:52',NULL),(36,1,'Created a new attribute called No smoking','Jacky','jacob.atam@gmail.com','2021-06-06 20:26:05','2021-06-06 20:26:05',NULL),(37,1,'Created a new attribute called Staycity Aparthotels Greenwich High Road accepts these cards and reserves the right to temporarily hold an amount prior to arrival.','Jacky','jacob.atam@gmail.com','2021-06-06 20:27:18','2021-06-06 20:27:18',NULL),(38,1,'Created a new attribute called Breakfast','Jacky','jacob.atam@gmail.com','2021-06-06 20:28:13','2021-06-06 20:28:13',NULL),(39,1,'Created a new attribute called Pick Up','Jacky','jacob.atam@gmail.com','2021-06-06 20:31:43','2021-06-06 20:31:43',NULL),(40,1,'Created a new Location called Nigeria','Jacky','jacob.atam@gmail.com','2021-06-06 21:14:38','2021-06-06 21:14:38',NULL),(41,1,'Created a new Location called Lagos','Jacky','jacob.atam@gmail.com','2021-06-06 21:20:26','2021-06-06 21:20:26',NULL),(42,1,'Created a new Location called Ikeja','Jacky','jacob.atam@gmail.com','2021-06-06 21:24:59','2021-06-06 21:24:59',NULL),(43,1,'Created a new Location called Opebi','Jacky','jacob.atam@gmail.com','2021-06-06 21:25:43','2021-06-06 21:25:43',NULL),(44,1,'Created a new attribute called Kitchen','Jacky','jacob.atam@gmail.com','2021-06-06 21:31:12','2021-06-06 21:31:12',NULL),(45,1,'Created a new attribute called Shared kitchen','Jacky','jacob.atam@gmail.com','2021-06-06 21:31:52','2021-06-06 21:31:52',NULL),(46,1,'Created a new attribute called High chair','Jacky','jacob.atam@gmail.com','2021-06-06 21:32:12','2021-06-06 21:32:12',NULL),(47,1,'Created a new attribute called Dining table','Jacky','jacob.atam@gmail.com','2021-06-06 21:32:28','2021-06-06 21:32:28',NULL),(48,1,'Created a new attribute called Cleaning products','Jacky','jacob.atam@gmail.com','2021-06-06 21:32:51','2021-06-06 21:32:51',NULL),(49,1,'Created a new attribute called Toaster','Jacky','jacob.atam@gmail.com','2021-06-06 21:33:24','2021-06-06 21:33:24',NULL),(50,1,'Created a new attribute called Stovetop','Jacky','jacob.atam@gmail.com','2021-06-06 21:33:40','2021-06-06 21:33:40',NULL),(51,1,'Created a new attribute called Oven','Jacky','jacob.atam@gmail.com','2021-06-06 21:34:07','2021-06-06 21:34:07',NULL),(52,1,'Created a new attribute called Dryer','Jacky','jacob.atam@gmail.com','2021-06-06 21:34:26','2021-06-06 21:34:26',NULL),(53,1,'Created a new attribute called Electric kettle','Jacky','jacob.atam@gmail.com','2021-06-06 21:34:40','2021-06-06 21:34:40',NULL),(54,1,'Created a new attribute called Kitchen','Jacky','jacob.atam@gmail.com','2021-06-06 21:34:54','2021-06-06 21:34:54',NULL),(55,1,'Created a new attribute called Washing machine','Jacky','jacob.atam@gmail.com','2021-06-06 21:35:26','2021-06-06 21:35:26',NULL),(56,1,'Created a new attribute called Dishwasher','Jacky','jacob.atam@gmail.com','2021-06-06 21:36:04','2021-06-06 21:36:04',NULL),(57,1,'Created a new attribute called Microwave','Jacky','jacob.atam@gmail.com','2021-06-06 21:36:21','2021-06-06 21:36:21',NULL),(58,1,'Created a new attribute called Refrigerator','Jacky','jacob.atam@gmail.com','2021-06-06 21:36:41','2021-06-06 21:36:41',NULL),(59,1,'Created a new attribute called Drying rack for clothing','Jacky','jacob.atam@gmail.com','2021-06-06 21:37:39','2021-06-06 21:37:39',NULL),(60,1,'Created a new attribute called Clothes rack','Jacky','jacob.atam@gmail.com','2021-06-06 21:37:57','2021-06-06 21:37:57',NULL),(61,1,'Created a new attribute called Hypoallergenic','Jacky','jacob.atam@gmail.com','2021-06-06 21:38:25','2021-06-06 21:38:25',NULL),(62,1,'Created a new attribute called Soundproof','Jacky','jacob.atam@gmail.com','2021-06-06 21:38:41','2021-06-06 21:38:41',NULL),(63,1,'Created a new attribute called Private entrance','Jacky','jacob.atam@gmail.com','2021-06-06 21:38:55','2021-06-06 21:38:55',NULL),(64,1,'Created a new attribute called Carpeted','Jacky','jacob.atam@gmail.com','2021-06-06 21:39:11','2021-06-06 21:39:11',NULL),(65,1,'Created a new attribute called Ironing facilities','Jacky','jacob.atam@gmail.com','2021-06-06 21:39:25','2021-06-06 21:39:25',NULL),(66,1,'Created a new attribute called Iron','Jacky','jacob.atam@gmail.com','2021-06-06 21:39:44','2021-06-06 21:39:44',NULL),(67,1,'Created a new attribute called Air conditioning','Jacky','jacob.atam@gmail.com','2021-06-06 21:40:00','2021-06-06 21:40:00',NULL),(68,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-06-06 22:09:17','2021-06-06 22:09:17',NULL),(69,1,'Created a new attribute called Health & Wellness Facilities','Jacky','jacob.atam@gmail.com','2021-06-06 22:14:28','2021-06-06 22:14:28',NULL),(70,1,'Created a new reservation Fraser Place Canary Wharf Opens in new window','Jacky','jacob.atam@gmail.com','2021-06-06 22:14:35','2021-06-06 22:14:35',NULL),(71,1,'Created a new attribute called Full-body massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:15:15','2021-06-06 22:15:15',NULL),(72,1,'Created a new attribute called Hand massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:38:51','2021-06-06 22:38:51',NULL),(73,1,'Created a new attribute called Head massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:39:54','2021-06-06 22:39:54',NULL),(74,1,'Created a new attribute called Couples\' massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:40:12','2021-06-06 22:40:12',NULL),(75,1,'Created a new attribute called Foot massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:40:31','2021-06-06 22:40:31',NULL),(76,1,'Created a new attribute called Neck massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:40:51','2021-06-06 22:40:51',NULL),(77,1,'Created a new attribute called Massage','Jacky','jacob.atam@gmail.com','2021-06-06 22:41:55','2021-06-06 22:41:55',NULL),(78,1,'Created a new attribute called Accessibility','Jacky','jacob.atam@gmail.com','2021-06-07 07:16:22','2021-06-07 07:16:22',NULL),(79,1,'Created a new attribute called Upper floors accessible by elevator','Jacky','jacob.atam@gmail.com','2021-06-07 07:16:55','2021-06-07 07:16:55',NULL),(80,1,'Created a new attribute called Cleaning Services','Jacky','jacob.atam@gmail.com','2021-06-07 07:17:10','2021-06-07 07:17:10',NULL),(81,1,'Created a new attribute called Daily housekeeping','Jacky','jacob.atam@gmail.com','2021-06-07 07:17:27','2021-06-07 07:17:27',NULL),(82,1,'Created a new attribute called Ironing service (Additional charge )','Jacky','jacob.atam@gmail.com','2021-06-07 07:18:00','2021-06-07 07:18:00',NULL),(83,1,'Created a new attribute called Dry cleaning (Additional charge )','Jacky','jacob.atam@gmail.com','2021-06-07 07:18:22','2021-06-07 07:18:22',NULL),(84,1,'Created a new attribute called Laundry Additional charge','Jacky','jacob.atam@gmail.com','2021-06-07 07:18:38','2021-06-07 07:18:38',NULL),(85,1,'Created a new attribute called Miscellaneous','Jacky','jacob.atam@gmail.com','2021-06-07 07:19:26','2021-06-07 07:19:26',NULL),(86,1,'Created a new attribute called Air conditioning','Jacky','jacob.atam@gmail.com','2021-06-07 07:19:38','2021-06-07 07:19:38',NULL),(87,1,'Created a new attribute called Smoke-free property','Jacky','jacob.atam@gmail.com','2021-06-07 07:19:51','2021-06-07 07:19:51',NULL),(88,1,'Created a new attribute called Heating','Jacky','jacob.atam@gmail.com','2021-06-07 07:20:02','2021-06-07 07:20:02',NULL),(89,1,'Created a new attribute called Soundproof rooms','Jacky','jacob.atam@gmail.com','2021-06-07 07:20:15','2021-06-07 07:20:15',NULL),(90,1,'Created a new attribute called Family rooms','Jacky','jacob.atam@gmail.com','2021-06-07 07:20:37','2021-06-07 07:20:37',NULL),(91,1,'Created a new attribute called Non-smoking rooms','Jacky','jacob.atam@gmail.com','2021-06-07 07:20:50','2021-06-07 07:20:50',NULL),(92,1,'Created a new attribute called Building Characteristics','Jacky','jacob.atam@gmail.com','2021-06-07 07:22:00','2021-06-07 07:22:00',NULL),(93,1,'Created a new attribute called Private apartment in building','Jacky','jacob.atam@gmail.com','2021-06-07 07:22:21','2021-06-07 07:22:21',NULL),(94,1,'Created a new attribute called Detached','Jacky','jacob.atam@gmail.com','2021-06-07 07:24:01','2021-06-07 07:24:01',NULL),(95,1,'Created a new attribute called Transportation','Jacky','jacob.atam@gmail.com','2021-06-07 07:24:14','2021-06-07 07:24:14',NULL),(96,1,'Created a new attribute called Airport drop-off (Additional charge )','Jacky','jacob.atam@gmail.com','2021-06-07 07:24:36','2021-06-07 07:24:36',NULL),(97,1,'Created a new attribute called Airport pickup (Additional charge)','Jacky','jacob.atam@gmail.com','2021-06-07 07:25:02','2021-06-07 07:25:02',NULL),(98,1,'Created a new attribute called Airport shuttle (additional charge)','Jacky','jacob.atam@gmail.com','2021-06-07 07:25:20','2021-06-07 07:25:20',NULL),(99,1,'Created a new attribute called Car rental','Jacky','jacob.atam@gmail.com','2021-06-07 07:25:34','2021-06-07 07:25:34',NULL),(100,1,'Created a new attribute called Front Desk Services','Jacky','jacob.atam@gmail.com','2021-06-07 07:25:49','2021-06-07 07:25:49',NULL),(101,1,'Created a new attribute called Tour desk','Jacky','jacob.atam@gmail.com','2021-06-07 07:26:01','2021-06-07 07:26:01',NULL),(102,1,'Created a new attribute called Entertainment & Family Services','Jacky','jacob.atam@gmail.com','2021-06-07 07:26:12','2021-06-07 07:26:12',NULL),(103,1,'Created a new attribute called Babysitting/Child services (Additional charge)','Jacky','jacob.atam@gmail.com','2021-06-07 07:26:32','2021-06-07 07:26:32',NULL),(104,1,'Created a new attribute called Food & Drink','Jacky','jacob.atam@gmail.com','2021-06-07 07:26:52','2021-06-07 07:26:52',NULL),(105,1,'Created a new attribute called Grocery deliveries','Jacky','jacob.atam@gmail.com','2021-06-07 07:27:06','2021-06-07 07:27:06',NULL),(106,1,'Created a new attribute called Special diet meals (on request)','Jacky','jacob.atam@gmail.com','2021-06-07 07:27:16','2021-06-07 07:27:16',NULL),(107,1,'Created a new attribute called Breakfast in the room','Jacky','jacob.atam@gmail.com','2021-06-07 07:27:29','2021-06-07 07:27:29',NULL),(108,1,'Created a new attribute called Minibar','Jacky','jacob.atam@gmail.com','2021-06-07 07:27:39','2021-06-07 07:27:39',NULL),(109,1,'Created a new attribute called Tea/Coffee maker','Jacky','jacob.atam@gmail.com','2021-06-07 07:27:53','2021-06-07 07:27:53',NULL),(110,1,'Created a new attribute called Outdoor & View','Jacky','jacob.atam@gmail.com','2021-06-07 07:28:13','2021-06-07 07:28:13',NULL),(111,1,'Created a new attribute called Enjoy the view','Jacky','jacob.atam@gmail.com','2021-06-07 07:28:23','2021-06-07 07:28:23',NULL),(112,1,'Created a new attribute called Languages Spoken','Jacky','jacob.atam@gmail.com','2021-06-07 07:28:35','2021-06-07 07:28:35',NULL),(113,1,'Created a new attribute called English','Jacky','jacob.atam@gmail.com','2021-06-07 07:28:46','2021-06-07 07:28:46',NULL),(114,1,'Created a new attribute called Safety & security','Jacky','jacob.atam@gmail.com','2021-06-07 07:29:21','2021-06-07 07:29:21',NULL),(115,1,'Created a new attribute called Fire extinguishers','Jacky','jacob.atam@gmail.com','2021-06-07 07:29:36','2021-06-07 07:29:36',NULL),(116,1,'Created a new attribute called Smoke alarms','Jacky','jacob.atam@gmail.com','2021-06-07 07:29:49','2021-06-07 07:29:49',NULL),(117,1,'Created a new attribute called Security alarm','Jacky','jacob.atam@gmail.com','2021-06-07 07:30:06','2021-06-07 07:30:06',NULL),(118,1,'Created a new attribute called Carbon monoxide detector','Jacky','jacob.atam@gmail.com','2021-06-07 07:30:16','2021-06-07 07:30:16',NULL),(119,1,'Created a new attribute called Safe','Jacky','jacob.atam@gmail.com','2021-06-07 07:30:29','2021-06-07 07:30:29',NULL),(120,1,'Created a new attribute called Living Area','Jacky','jacob.atam@gmail.com','2021-06-07 07:37:14','2021-06-07 07:37:14',NULL),(121,1,'Created a new attribute called Space for everyone to be together','Jacky','jacob.atam@gmail.com','2021-06-07 07:37:29','2021-06-07 07:37:29',NULL),(122,1,'Created a new attribute called Dining area','Jacky','jacob.atam@gmail.com','2021-06-07 07:37:42','2021-06-07 07:37:42',NULL),(123,1,'Created a new attribute called Sitting area','Jacky','jacob.atam@gmail.com','2021-06-07 07:37:55','2021-06-07 07:37:55',NULL),(124,1,'Created a new attribute called Desk','Jacky','jacob.atam@gmail.com','2021-06-07 07:38:07','2021-06-07 07:38:07',NULL),(125,1,'Deleted  2 Products','Jacky','jacob.atam@gmail.com','2021-06-07 13:15:46','2021-06-07 13:15:46',NULL),(126,1,'Created a new attribute called Exra Services','Jacky','jacob.atam@gmail.com','2021-06-07 13:15:54','2021-06-07 13:15:54',NULL),(127,1,'Created a new attribute called Breakfast','Jacky','jacob.atam@gmail.com','2021-06-07 13:16:08','2021-06-07 13:16:08',NULL),(128,1,'Created a new attribute called Car pick up','Jacky','jacob.atam@gmail.com','2021-06-07 13:16:28','2021-06-07 13:16:28',NULL),(129,1,'Created a new attribute called Bedrooms','Jacky','jacob.atam@gmail.com','2021-06-07 13:19:42','2021-06-07 13:19:42',NULL),(130,1,'Updated  Attribute 3 Bedrooms ','Jacky','jacob.atam@gmail.com','2021-06-07 13:22:29','2021-06-07 13:22:29',NULL),(131,1,'Updated  Attribute 2 Bedrooms ','Jacky','jacob.atam@gmail.com','2021-06-07 13:22:59','2021-06-07 13:22:59',NULL),(132,1,'Updated  Attribute 1 bedroom ','Jacky','jacob.atam@gmail.com','2021-06-07 13:26:30','2021-06-07 13:26:30',NULL),(133,1,'Updated  Attribute 1 bedroom ','Jacky','jacob.atam@gmail.com','2021-06-07 13:28:37','2021-06-07 13:28:37',NULL),(134,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-06-07 15:40:49','2021-06-07 15:40:49',NULL),(135,1,'Created a new reservation Fraser Place Canary Wharf Opens in new window','Jacky','jacob.atam@gmail.com','2021-06-07 20:36:35','2021-06-07 20:36:35',NULL),(136,1,'Edit a  reservation ','Jacky','jacob.atam@gmail.com','2021-06-07 21:06:50','2021-06-07 21:06:50',NULL),(137,1,'Edit a  reservation ','Jacky','jacob.atam@gmail.com','2021-06-07 21:07:14','2021-06-07 21:07:14',NULL),(138,1,'Created a new reservation Hotel Holiday Inn Express Manchester City Centre, an IHG Hotel','Jacky','jacob.atam@gmail.com','2021-06-16 03:56:25','2021-06-16 03:56:25',NULL),(139,1,'Edit a  reservation ','Jacky','jacob.atam@gmail.com','2021-06-16 04:45:37','2021-06-16 04:45:37',NULL),(140,1,'Deleted  2 Products','Jacky','jacob.atam@gmail.com','2021-09-08 13:54:26','2021-09-08 13:54:26',NULL),(141,1,'Deleted  118 Products','Jacky','jacob.atam@gmail.com','2021-09-19 10:45:51','2021-09-19 10:45:51',NULL),(142,1,'Created a new attribute called Rules','Jacky','jacob.atam@gmail.com','2021-09-19 10:51:21','2021-09-19 10:51:21',NULL),(143,1,'Created a new attribute called Pets','Jacky','jacob.atam@gmail.com','2021-09-19 10:51:34','2021-09-19 10:51:34',NULL),(144,1,'Created a new attribute called No Pets','Jacky','jacob.atam@gmail.com','2021-09-19 10:52:15','2021-09-19 10:52:15',NULL),(145,1,'Created a new attribute called No Smoking','Jacky','jacob.atam@gmail.com','2021-09-19 10:52:32','2021-09-19 10:52:32',NULL),(146,1,'Created a new attribute called Smoking allowed','Jacky','jacob.atam@gmail.com','2021-09-19 10:53:09','2021-09-19 10:53:09',NULL),(147,1,'Created a new attribute called Extra Services','Jacky','jacob.atam@gmail.com','2021-09-19 10:54:10','2021-09-19 10:54:10',NULL),(148,1,'Created a new attribute called Bedroom 1','Jacky','jacob.atam@gmail.com','2021-09-19 11:24:28','2021-09-19 11:24:28',NULL),(149,1,'Created a new attribute called Extra-large double bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:06:15','2021-09-19 12:06:15',NULL),(150,1,'Created a new attribute called Single bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:06:33','2021-09-19 12:06:33',NULL),(151,1,'Created a new attribute called Large bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:06:58','2021-09-19 12:06:58',NULL),(152,1,'Created a new attribute called Bedroom 2','Jacky','jacob.atam@gmail.com','2021-09-19 12:07:53','2021-09-19 12:07:53',NULL),(153,1,'Created a new attribute called Bedroom 3','Jacky','jacob.atam@gmail.com','2021-09-19 12:08:13','2021-09-19 12:08:13',NULL),(154,1,'Created a new attribute called Bedroom 4','Jacky','jacob.atam@gmail.com','2021-09-19 12:09:26','2021-09-19 12:09:26',NULL),(155,1,'Created a new attribute called Bedroom 4','Jacky','jacob.atam@gmail.com','2021-09-19 12:10:02','2021-09-19 12:10:02',NULL),(156,1,'Created a new attribute called Extra-large double bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:10:45','2021-09-19 12:10:45',NULL),(157,1,'Created a new attribute called Single bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:11:00','2021-09-19 12:11:00',NULL),(158,1,'Created a new attribute called Large bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:13:21','2021-09-19 12:13:21',NULL),(159,1,'Created a new attribute called Single bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:16:23','2021-09-19 12:16:23',NULL),(160,1,'Created a new attribute called Extra-large double bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:16:55','2021-09-19 12:16:55',NULL),(161,1,'Created a new attribute called Large bed','Jacky','jacob.atam@gmail.com','2021-09-19 12:21:01','2021-09-19 12:21:01',NULL),(162,1,'Created a new attribute called Room Amenities','Jacky','jacob.atam@gmail.com','2021-09-19 12:28:04','2021-09-19 12:28:04',NULL),(163,1,'Created a new attribute called Facilities','Jacky','jacob.atam@gmail.com','2021-09-19 12:28:18','2021-09-19 12:28:18',NULL),(164,1,'Created a new attribute called Air conditioning','Jacky','jacob.atam@gmail.com','2021-09-19 12:29:13','2021-09-19 12:29:13',NULL),(165,1,'Created a new attribute called Kitchen','Jacky','jacob.atam@gmail.com','2021-09-19 12:29:29','2021-09-19 12:29:29',NULL),(166,1,'Created a new attribute called Free parking','Jacky','jacob.atam@gmail.com','2021-09-19 12:31:37','2021-09-19 12:31:37',NULL),(167,1,'Created a new attribute called Swimming Pool','Jacky','jacob.atam@gmail.com','2021-09-19 12:32:56','2021-09-19 12:32:56',NULL),(168,1,'Created a new attribute called Pets allowed','Jacky','jacob.atam@gmail.com','2021-09-19 12:33:16','2021-09-19 12:33:16',NULL),(169,1,'Created a new attribute called TV','Jacky','jacob.atam@gmail.com','2021-09-19 12:35:33','2021-09-19 12:35:33',NULL),(170,1,'Created a new attribute called Fitness Center','Jacky','jacob.atam@gmail.com','2021-09-19 12:36:00','2021-09-19 12:36:00',NULL),(171,1,'Created a new attribute called Bathroom','Jacky','jacob.atam@gmail.com','2021-09-19 12:37:12','2021-09-19 12:37:12',NULL),(172,1,'Created a new attribute called Bedroom','Jacky','jacob.atam@gmail.com','2021-09-19 12:39:55','2021-09-19 12:39:55',NULL),(173,1,'Created a new attribute called Outdoors','Jacky','jacob.atam@gmail.com','2021-09-19 12:40:54','2021-09-19 12:40:54',NULL),(174,1,'Created a new attribute called Kitchen','Jacky','jacob.atam@gmail.com','2021-09-19 12:41:14','2021-09-19 12:41:14',NULL),(175,1,'Created a new attribute called Room Facilities','Jacky','jacob.atam@gmail.com','2021-09-19 12:41:42','2021-09-19 12:41:42',NULL),(176,1,'Created a new attribute called Living Area','Jacky','jacob.atam@gmail.com','2021-09-19 12:42:09','2021-09-19 12:42:09',NULL),(177,1,'Created a new attribute called Languages spoken','Jacky','jacob.atam@gmail.com','2021-09-19 12:44:53','2021-09-19 12:44:53',NULL),(178,1,'Created a new attribute called English','Jacky','jacob.atam@gmail.com','2021-09-19 12:45:28','2021-09-19 12:45:28',NULL),(179,1,'Created a new attribute called French','Jacky','jacob.atam@gmail.com','2021-09-19 12:45:44','2021-09-19 12:45:44',NULL),(180,1,'Created a new attribute called Media & Technology','Jacky','jacob.atam@gmail.com','2021-09-19 14:56:21','2021-09-19 14:56:21',NULL),(181,1,'Created a new attribute called Internet','Jacky','jacob.atam@gmail.com','2021-09-19 14:58:53','2021-09-19 14:58:53',NULL),(182,1,'Created a new attribute called Wellness','Jacky','jacob.atam@gmail.com','2021-09-19 15:00:09','2021-09-19 15:00:09',NULL),(183,1,'Created a new attribute called What\'s nearby','Jacky','jacob.atam@gmail.com','2021-09-19 15:33:30','2021-09-19 15:33:30',NULL),(184,1,'Created a new property Lovely Studio Apartment at Lekki, Agungi','Jacky','jacob.atam@gmail.com','2021-09-19 17:11:12','2021-09-19 17:11:12',NULL),(185,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2021-09-19 17:11:55','2021-09-19 17:11:55',NULL),(186,1,'Created a new attribute called Toilet paper','Jacky','jacob.atam@gmail.com','2021-09-19 19:07:53','2021-09-19 19:07:53',NULL),(187,1,'Created a new attribute called Towels','Jacky','jacob.atam@gmail.com','2021-09-19 19:08:11','2021-09-19 19:08:11',NULL),(188,1,'Created a new attribute called Bidet','Jacky','jacob.atam@gmail.com','2021-09-19 19:10:15','2021-09-19 19:10:15',NULL),(189,1,'Created a new attribute called Towels/sheets (extra fee)','Jacky','jacob.atam@gmail.com','2021-09-19 19:10:42','2021-09-19 19:10:42',NULL),(190,1,'Created a new attribute called Additional toilet','Jacky','jacob.atam@gmail.com','2021-09-19 19:11:13','2021-09-19 19:11:13',NULL),(191,1,'Created a new attribute called Hairdryer','Jacky','jacob.atam@gmail.com','2021-09-19 19:11:38','2021-09-19 19:11:38',NULL),(192,1,'Created a new attribute called Linen','Jacky','jacob.atam@gmail.com','2021-09-19 19:12:05','2021-09-19 19:12:05',NULL),(193,1,'Created a new attribute called Wardrobe or closet','Jacky','jacob.atam@gmail.com','2021-09-19 19:12:54','2021-09-19 19:12:54',NULL),(194,1,'Created a new attribute called Dining table','Jacky','jacob.atam@gmail.com','2021-09-19 19:13:55','2021-09-19 19:13:55',NULL),(195,1,'Created a new attribute called Cleaning products','Jacky','jacob.atam@gmail.com','2021-09-19 19:14:28','2021-09-19 19:14:28',NULL),(196,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-09-19 19:20:02','2021-09-19 19:20:02',NULL),(197,1,'Updated  Attribute Media & Technology ','Jacky','jacob.atam@gmail.com','2021-09-19 19:22:11','2021-09-19 19:22:11',NULL),(198,1,'Deleted  3 Products','Jacky','jacob.atam@gmail.com','2021-09-19 19:22:33','2021-09-19 19:22:33',NULL),(199,1,'Created a new attribute called Flat-screen TV','Jacky','jacob.atam@gmail.com','2021-09-19 19:22:51','2021-09-19 19:22:51',NULL),(200,1,'Created a new attribute called Kitchen','Jacky','jacob.atam@gmail.com','2021-09-19 19:24:29','2021-09-19 19:24:29',NULL),(201,1,'Created a new attribute called Popular amenities','Jacky','jacob.atam@gmail.com','2021-09-19 19:29:48','2021-09-19 19:29:48',NULL),(202,1,'Updated  Attribute Amenities ','Jacky','jacob.atam@gmail.com','2021-09-19 23:12:10','2021-09-19 23:12:10',NULL),(203,1,'Updated  Attribute Facilities ','Jacky','jacob.atam@gmail.com','2021-09-19 23:12:31','2021-09-19 23:12:31',NULL),(204,1,'Updated  Attribute TVe ','Jacky','jacob.atam@gmail.com','2021-09-19 23:13:04','2021-09-19 23:13:04',NULL),(205,1,'Updated  Attribute Air conditioning ','Jacky','jacob.atam@gmail.com','2021-09-19 23:13:24','2021-09-19 23:13:24',NULL),(206,1,'Updated  Attribute Fitness Center ','Jacky','jacob.atam@gmail.com','2021-09-19 23:13:36','2021-09-19 23:13:36',NULL),(207,1,'Updated  Attribute Air conditioning ','Jacky','jacob.atam@gmail.com','2021-09-19 23:57:37','2021-09-19 23:57:37',NULL),(208,1,'Updated  Attribute Fitness Center ','Jacky','jacob.atam@gmail.com','2021-09-19 23:57:45','2021-09-19 23:57:45',NULL),(209,1,'Updated  Attribute Fitness Center ','Jacky','jacob.atam@gmail.com','2021-09-19 23:58:03','2021-09-19 23:58:03',NULL),(210,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-09-19 23:58:35','2021-09-19 23:58:35',NULL),(211,1,'Updated  Attribute Facilities ','Jacky','jacob.atam@gmail.com','2021-09-19 23:58:48','2021-09-19 23:58:48',NULL),(212,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-09-19 23:59:15','2021-09-19 23:59:15',NULL),(213,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-09-19 23:59:55','2021-09-19 23:59:55',NULL),(214,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-09-20 00:07:34','2021-09-20 00:07:34',NULL),(215,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-09-20 00:08:02','2021-09-20 00:08:02',NULL),(216,1,'Updated  Attribute No Pets ','Jacky','jacob.atam@gmail.com','2021-09-20 00:08:11','2021-09-20 00:08:11',NULL),(217,1,'Updated  Attribute No Smoking ','Jacky','jacob.atam@gmail.com','2021-09-20 00:08:19','2021-09-20 00:08:19',NULL),(218,1,'Updated  Attribute Pets ','Jacky','jacob.atam@gmail.com','2021-09-20 00:08:27','2021-09-20 00:08:27',NULL),(219,1,'Updated  Attribute Smoking allowed ','Jacky','jacob.atam@gmail.com','2021-09-20 00:08:37','2021-09-20 00:08:37',NULL),(220,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-09-20 00:08:42','2021-09-20 00:08:42',NULL),(221,1,'Updated  Attribute Bedroom ','Jacky','jacob.atam@gmail.com','2021-09-20 00:20:36','2021-09-20 00:20:36',NULL),(222,1,'Updated  Attribute Outdoors ','Jacky','jacob.atam@gmail.com','2021-09-20 00:20:54','2021-09-20 00:20:54',NULL),(223,1,'Updated  Attribute Room Facilities ','Jacky','jacob.atam@gmail.com','2021-09-20 00:21:09','2021-09-20 00:21:09',NULL),(224,1,'Updated  Attribute Living Area ','Jacky','jacob.atam@gmail.com','2021-09-20 00:34:13','2021-09-20 00:34:13',NULL),(225,1,'Updated  Attribute Media & Technology ','Jacky','jacob.atam@gmail.com','2021-09-20 00:34:26','2021-09-20 00:34:26',NULL),(226,1,'Updated  Attribute Internet ','Jacky','jacob.atam@gmail.com','2021-09-20 00:34:40','2021-09-20 00:34:40',NULL),(227,1,'Updated  Attribute Wellness ','Jacky','jacob.atam@gmail.com','2021-09-20 00:34:55','2021-09-20 00:34:55',NULL),(228,1,'Created a new attribute called All pools are free of charge','Jacky','jacob.atam@gmail.com','2021-09-20 00:36:20','2021-09-20 00:36:20',NULL),(229,1,'Created a new attribute called Sun loungers or beach chairs','Jacky','jacob.atam@gmail.com','2021-09-20 00:36:47','2021-09-20 00:36:47',NULL),(230,1,'Created a new attribute called Pool/beach towels','Jacky','jacob.atam@gmail.com','2021-09-20 00:37:06','2021-09-20 00:37:06',NULL),(231,1,'Created a new attribute called Hot tub/Jacuzzi','Jacky','jacob.atam@gmail.com','2021-09-20 00:37:24','2021-09-20 00:37:24',NULL),(232,1,'Created a new attribute called WiFi','Jacky','jacob.atam@gmail.com','2021-09-20 00:37:53','2021-09-20 00:37:53',NULL),(233,1,'Created a new attribute called Dining table','Jacky','jacob.atam@gmail.com','2021-09-20 00:38:24','2021-09-20 00:38:24',NULL),(234,1,'Deleted  3 Products','Jacky','jacob.atam@gmail.com','2021-09-20 00:40:05','2021-09-20 00:40:05',NULL),(235,1,'Created a new attribute called Kitchen','Jacky','jacob.atam@gmail.com','2021-09-20 00:40:15','2021-09-20 00:40:15',NULL),(236,1,'Created a new attribute called Dining table','Jacky','jacob.atam@gmail.com','2021-09-20 00:40:30','2021-09-20 00:40:30',NULL),(237,1,'Created a new attribute called Cleaning products','Jacky','jacob.atam@gmail.com','2021-09-20 00:41:25','2021-09-20 00:41:25',NULL),(238,1,'Created a new attribute called Toaster','Jacky','jacob.atam@gmail.com','2021-09-20 00:42:09','2021-09-20 00:42:09',NULL),(239,1,'Created a new attribute called Oven','Jacky','jacob.atam@gmail.com','2021-09-20 00:42:23','2021-09-20 00:42:23',NULL),(240,1,'Created a new attribute called Tumble dryer','Jacky','jacob.atam@gmail.com','2021-09-20 00:42:41','2021-09-20 00:42:41',NULL),(241,1,'Created a new attribute called Kitchenware','Jacky','jacob.atam@gmail.com','2021-09-20 00:43:03','2021-09-20 00:43:03',NULL),(242,1,'Created a new attribute called Electric kettle','Jacky','jacob.atam@gmail.com','2021-09-20 00:43:21','2021-09-20 00:43:21',NULL),(243,1,'Created a new attribute called Sofa','Jacky','jacob.atam@gmail.com','2021-09-20 00:43:54','2021-09-20 00:43:54',NULL),(244,1,'Created a new attribute called Dining area','Jacky','jacob.atam@gmail.com','2021-09-20 00:44:13','2021-09-20 00:44:13',NULL),(245,1,'Created a new attribute called Body Masage (Additinal Charge)','Jacky','jacob.atam@gmail.com','2021-09-20 00:46:25','2021-09-20 00:46:25',NULL),(246,1,'Updated  Attribute TVe ','Jacky','jacob.atam@gmail.com','2021-09-20 12:52:18','2021-09-20 12:52:18',NULL),(247,1,'Updated  Attribute Air conditioning ','Jacky','jacob.atam@gmail.com','2021-09-20 12:52:32','2021-09-20 12:52:32',NULL),(248,1,'Updated  Attribute Fitness Center ','Jacky','jacob.atam@gmail.com','2021-09-20 12:52:47','2021-09-20 12:52:47',NULL),(249,1,'Updated  Attribute Swimming Pool ','Jacky','jacob.atam@gmail.com','2021-09-20 12:52:59','2021-09-20 12:52:59',NULL),(250,1,'Updated  Attribute Pets allowed ','Jacky','jacob.atam@gmail.com','2021-09-20 12:53:11','2021-09-20 12:53:11',NULL),(251,1,'Updated  Attribute Kitchen & Dining ','Jacky','jacob.atam@gmail.com','2021-09-20 13:04:44','2021-09-20 13:04:44',NULL),(252,1,'Updated  Attribute Free parking ','Jacky','jacob.atam@gmail.com','2021-09-20 13:05:00','2021-09-20 13:05:00',NULL),(253,1,'Updated  Attribute Kitchen & Dinin ','Jacky','jacob.atam@gmail.com','2021-09-20 13:07:21','2021-09-20 13:07:21',NULL),(254,1,'Updated  Attribute Kitchen ','Jacky','jacob.atam@gmail.com','2021-09-20 13:07:38','2021-09-20 13:07:38',NULL),(255,1,'Updated  Attribute Kitchen & Dining ','Jacky','jacob.atam@gmail.com','2021-09-20 13:07:52','2021-09-20 13:07:52',NULL),(256,1,'Updated  Attribute Body Masage (Additinal Charge) ','Jacky','jacob.atam@gmail.com','2021-09-20 13:08:03','2021-09-20 13:08:03',NULL),(257,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-09-20 13:08:11','2021-09-20 13:08:11',NULL),(258,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-09-22 16:55:11','2021-09-22 16:55:11',NULL),(259,1,'Updated  Attribute Air conditioning ','Jacky','jacob.atam@gmail.com','2021-09-22 17:01:23','2021-09-22 17:01:23',NULL),(260,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-09-22 17:07:49','2021-09-22 17:07:49',NULL),(261,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-09-22 17:08:06','2021-09-22 17:08:06',NULL),(262,1,'Updated  Attribute Kitchen ','Jacky','jacob.atam@gmail.com','2021-09-22 17:08:55','2021-09-22 17:08:55',NULL),(263,1,'Updated  Attribute Outdoors ','Jacky','jacob.atam@gmail.com','2021-09-22 17:09:50','2021-09-22 17:09:50',NULL),(264,1,'Created a new attribute called Wifi','Jacky','jacob.atam@gmail.com','2021-09-22 17:11:56','2021-09-22 17:11:56',NULL),(265,1,'Updated  Attribute TV ','Jacky','jacob.atam@gmail.com','2021-09-22 17:12:10','2021-09-22 17:12:10',NULL),(266,1,'Updated  Attribute Parking ','Jacky','jacob.atam@gmail.com','2021-09-22 17:12:26','2021-09-22 17:12:26',NULL),(267,1,'Updated  Attribute Parking ','Jacky','jacob.atam@gmail.com','2021-09-22 17:13:51','2021-09-22 17:13:51',NULL),(268,1,'Updated  Attribute Swimming Pool ','Jacky','jacob.atam@gmail.com','2021-09-22 17:16:18','2021-09-22 17:16:18',NULL),(269,1,'Created a new Location called Abuja','Jacky','jacob.atam@gmail.com','2021-09-23 08:31:06','2021-09-23 08:31:06',NULL),(270,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2021-09-23 08:50:56','2021-09-23 08:50:56',NULL),(271,1,'Updated  Location Lagos ','Jacky','jacob.atam@gmail.com','2021-09-24 10:02:49','2021-09-24 10:02:49',NULL),(272,1,'Updated  Location Abuja ','Jacky','jacob.atam@gmail.com','2021-09-24 10:03:50','2021-09-24 10:03:50',NULL),(273,1,'Created a new Location called Port Harcourt','Jacky','jacob.atam@gmail.com','2021-09-24 10:08:22','2021-09-24 10:08:22',NULL),(274,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2021-09-24 10:09:10','2021-09-24 10:09:10',NULL),(275,1,'Updated  Attribute Body Masage ','Jacky','jacob.atam@gmail.com','2021-09-29 18:43:18','2021-09-29 18:43:18',NULL),(276,1,'Created a new attribute called Car Hire','Jacky','jacob.atam@gmail.com','2021-09-29 18:43:45','2021-09-29 18:43:45',NULL),(277,1,'Created a new attribute called BreakFast','Jacky','jacob.atam@gmail.com','2021-09-29 18:44:29','2021-09-29 18:44:29',NULL),(278,1,'Updated  Attribute Kitchen ','Jacky','jacob.atam@gmail.com','2021-09-29 18:52:08','2021-09-29 18:52:08',NULL),(279,1,'Updated  Attribute Swimming Pool ','Jacky','jacob.atam@gmail.com','2021-09-29 18:52:35','2021-09-29 18:52:35',NULL),(280,1,'Updated  Attribute Pets allowed ','Jacky','jacob.atam@gmail.com','2021-09-29 18:53:30','2021-09-29 18:53:30',NULL),(281,1,'Created a new attribute called Serviced Apartment','Jacky','jacob.atam@gmail.com','2021-09-29 19:12:28','2021-09-29 19:12:28',NULL),(282,1,'Created a new property Single room apartment in Ikeja GRA','Jacky','jacob.atam@gmail.com','2021-09-29 19:20:25','2021-09-29 19:20:25',NULL),(283,1,'Created a new property Avenu montaigne','Jacky','jacob.atam@gmail.com','2021-09-29 19:33:29','2021-09-29 19:33:29',NULL),(284,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2021-09-29 19:36:05','2021-09-29 19:36:05',NULL),(285,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2021-09-29 19:36:58','2021-09-29 19:36:58',NULL),(286,1,'Created a new attribute called Boat Cruise','Jacky','jacob.atam@gmail.com','2021-09-30 17:23:01','2021-09-30 17:23:01',NULL),(287,1,'Created a new attribute called Lunch','Jacky','jacob.atam@gmail.com','2021-09-30 17:23:32','2021-09-30 17:23:32',NULL),(288,1,'Created a new attribute called Dinner','Jacky','jacob.atam@gmail.com','2021-09-30 17:23:43','2021-09-30 17:23:43',NULL),(289,1,'Created a new attribute called area','Jacky','jacob.atam@gmail.com','2021-09-30 17:36:04','2021-09-30 17:36:04',NULL),(290,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2021-09-30 17:36:27','2021-09-30 17:36:27',NULL),(291,1,'Created a new attribute called Chocolat Royal','Jacky','jacob.atam@gmail.com','2021-09-30 17:37:00','2021-09-30 17:37:00',NULL),(292,1,'Created a new attribute called Safety','Jacky','jacob.atam@gmail.com','2021-09-30 17:38:06','2021-09-30 17:38:06',NULL),(293,1,'Deleted  3 Products','Jacky','jacob.atam@gmail.com','2021-10-07 17:44:28','2021-10-07 17:44:28',NULL),(294,1,'Updated  Attribute Tumble dryer ','Jacky','jacob.atam@gmail.com','2021-10-07 17:45:06','2021-10-07 17:45:06',NULL),(295,1,'Updated  Attribute Bathroom ','Jacky','jacob.atam@gmail.com','2021-10-07 17:45:26','2021-10-07 17:45:26',NULL),(296,1,'Updated  Attribute Body Masage ','Jacky','jacob.atam@gmail.com','2021-10-07 17:59:19','2021-10-07 17:59:19',NULL),(297,1,'Updated  Attribute Car Hire ','Jacky','jacob.atam@gmail.com','2021-10-07 17:59:51','2021-10-07 17:59:51',NULL),(298,1,'Updated  Attribute BreakFast ','Jacky','jacob.atam@gmail.com','2021-10-07 18:00:02','2021-10-07 18:00:02',NULL),(299,1,'Updated  Attribute Boat Cruise ','Jacky','jacob.atam@gmail.com','2021-10-07 18:01:35','2021-10-07 18:01:35',NULL),(300,1,'Updated  Attribute Dinner ','Jacky','jacob.atam@gmail.com','2021-10-07 18:01:57','2021-10-07 18:01:57',NULL),(301,1,'Updated  Attribute Lunch ','Jacky','jacob.atam@gmail.com','2021-10-07 18:02:38','2021-10-07 18:02:38',NULL),(302,1,'Updated  Attribute Serviced Apartment ','Jacky','jacob.atam@gmail.com','2021-10-07 18:02:55','2021-10-07 18:02:55',NULL),(303,1,'Updated  Attribute Bedroom ','Jacky','jacob.atam@gmail.com','2021-10-07 18:03:40','2021-10-07 18:03:40',NULL),(304,1,'Updated  Attribute Outdoors ','Jacky','jacob.atam@gmail.com','2021-10-07 18:03:57','2021-10-07 18:03:57',NULL),(305,1,'Updated  Attribute Room Facilities ','Jacky','jacob.atam@gmail.com','2021-10-07 18:04:14','2021-10-07 18:04:14',NULL),(306,1,'Updated  Attribute Living Area ','Jacky','jacob.atam@gmail.com','2021-10-07 18:04:37','2021-10-07 18:04:37',NULL),(307,1,'Updated  Attribute Media & Technology ','Jacky','jacob.atam@gmail.com','2021-10-07 18:04:58','2021-10-07 18:04:58',NULL),(308,1,'Updated  Attribute Internet ','Jacky','jacob.atam@gmail.com','2021-10-07 18:05:13','2021-10-07 18:05:13',NULL),(309,1,'Updated  Attribute Wellness ','Jacky','jacob.atam@gmail.com','2021-10-07 18:06:27','2021-10-07 18:06:27',NULL),(310,1,'Updated  Attribute Additional toilet ','Jacky','jacob.atam@gmail.com','2021-10-07 18:07:14','2021-10-07 18:07:14',NULL),(311,1,'Updated  Attribute Additional toilet ','Jacky','jacob.atam@gmail.com','2021-10-07 18:07:14','2021-10-07 18:07:14',NULL),(312,1,'Updated  Attribute Bidet ','Jacky','jacob.atam@gmail.com','2021-10-07 18:07:23','2021-10-07 18:07:23',NULL),(313,1,'Updated  Attribute Hairdryer ','Jacky','jacob.atam@gmail.com','2021-10-07 18:07:42','2021-10-07 18:07:42',NULL),(314,1,'Updated  Attribute Toilet paper ','Jacky','jacob.atam@gmail.com','2021-10-07 18:09:00','2021-10-07 18:09:00',NULL),(315,1,'Updated  Attribute Towels ','Jacky','jacob.atam@gmail.com','2021-10-07 18:09:15','2021-10-07 18:09:15',NULL),(316,1,'Updated  Attribute Towels/sheets (extra fee) ','Jacky','jacob.atam@gmail.com','2021-10-07 18:09:27','2021-10-07 18:09:27',NULL),(317,1,'Updated  Attribute Linen ','Jacky','jacob.atam@gmail.com','2021-10-07 18:10:05','2021-10-07 18:10:05',NULL),(318,1,'Updated  Attribute Wardrobe or closet ','Jacky','jacob.atam@gmail.com','2021-10-07 18:10:18','2021-10-07 18:10:18',NULL),(319,1,'Updated  Attribute Dining area ','Jacky','jacob.atam@gmail.com','2021-10-07 18:10:59','2021-10-07 18:10:59',NULL),(320,1,'Updated  Attribute Sofa ','Jacky','jacob.atam@gmail.com','2021-10-07 18:11:13','2021-10-07 18:11:13',NULL),(321,1,'Updated  Attribute Flat-screen TV ','Jacky','jacob.atam@gmail.com','2021-10-07 18:11:47','2021-10-07 18:11:47',NULL),(322,1,'Updated  Attribute Hot tub/Jacuzzi ','Jacky','jacob.atam@gmail.com','2021-10-07 18:12:14','2021-10-07 18:12:14',NULL),(323,1,'Updated  Attribute Pool/beach towels ','Jacky','jacob.atam@gmail.com','2021-10-07 18:12:37','2021-10-07 18:12:37',NULL),(324,1,'Updated  Attribute Sun loungers or beach chairs ','Jacky','jacob.atam@gmail.com','2021-10-07 18:12:48','2021-10-07 18:12:48',NULL),(325,1,'Created a new property Single room apartment in Ikeja GRA','Jacky','jacob.atam@gmail.com','2021-10-07 18:17:47','2021-10-07 18:17:47',NULL),(326,1,'Created a new property Avenu montaigne','Jacky','jacob.atam@gmail.com','2021-10-07 18:24:02','2021-10-07 18:24:02',NULL),(327,1,'Deleted  2 Products','Jacky','jacob.atam@gmail.com','2021-10-14 20:22:53','2021-10-14 20:22:53',NULL),(328,1,'Created a new property Lisbon Serviced Apartments','Jacky','jacob.atam@gmail.com','2021-10-14 20:26:38','2021-10-14 20:26:38',NULL),(329,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2022-03-05 13:18:00','2022-03-05 13:18:00',NULL),(330,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2022-03-05 20:07:45','2022-03-05 20:07:45',NULL),(331,1,'Created a new property Avenu montaigne','Jacky','jacob.atam@gmail.com','2022-03-05 20:11:58','2022-03-05 20:11:58',NULL),(332,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2022-03-05 20:39:51','2022-03-05 20:39:51',NULL),(333,1,'Updated  Attribute Bedroom 1 ','Jacky','jacob.atam@gmail.com','2022-03-06 08:51:47','2022-03-06 08:51:47',NULL),(334,1,'Updated  Attribute Bedroom 1 ','Jacky','jacob.atam@gmail.com','2022-03-06 14:02:39','2022-03-06 14:02:39',NULL),(335,1,'Created a new property Blue Waters','Jacky','jacob.atam@gmail.com','2023-01-11 15:22:06','2023-01-11 15:22:06',NULL),(336,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 15:22:48','2023-01-11 15:22:48',NULL),(337,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 16:35:20','2023-01-11 16:35:20',NULL),(338,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 16:36:05','2023-01-11 16:36:05',NULL),(339,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 16:36:16','2023-01-11 16:36:16',NULL),(340,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 16:48:16','2023-01-11 16:48:16',NULL),(341,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 16:50:02','2023-01-11 16:50:02',NULL),(342,1,'Deleted  1 Products','Jacky','jacob.atam@gmail.com','2023-01-11 16:56:11','2023-01-11 16:56:11',NULL),(343,1,'Created a new property Avenu montaigne','Jacky','jacob.atam@gmail.com','2023-01-11 17:01:37','2023-01-11 17:01:37',NULL),(344,1,'Created a new Location called Ikoyi','Jacky','jacob.atam@gmail.com','2023-01-11 19:49:13','2023-01-11 19:49:13',NULL),(345,1,'Created a new Location called Victoria Island','Jacky','jacob.atam@gmail.com','2023-01-11 19:49:36','2023-01-11 19:49:36',NULL),(346,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 19:50:03','2023-01-11 19:50:03',NULL),(347,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 19:50:18','2023-01-11 19:50:18',NULL),(348,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 20:21:39','2023-01-11 20:21:39',NULL),(349,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 20:25:27','2023-01-11 20:25:27',NULL),(350,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-01-11 20:25:45','2023-01-11 20:25:45',NULL),(351,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-06-16 04:51:13','2023-06-16 04:51:13',NULL),(352,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-06-19 04:41:32','2023-06-19 04:41:32',NULL),(353,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-06-25 01:28:59','2023-06-25 01:28:59',NULL),(354,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-06-25 01:32:48','2023-06-25 01:32:48',NULL),(355,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-06-25 01:57:52','2023-06-25 01:57:52',NULL),(356,1,' Created new permission called agents','Jacky','jacob.atam@gmail.com','2023-07-04 19:33:40','2023-07-04 19:33:40',NULL),(357,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 10:35:38','2023-07-14 10:35:38',NULL),(358,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 10:42:06','2023-07-14 10:42:06',NULL),(359,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 10:42:32','2023-07-14 10:42:32',NULL),(360,1,'Deleted  2 Products','Jacky','jacob.atam@gmail.com','2023-07-14 11:19:59','2023-07-14 11:19:59',NULL),(361,1,'Deleted  2 Products','Jacky','jacob.atam@gmail.com','2023-07-14 13:20:44','2023-07-14 13:20:44',NULL),(362,1,'Deleted  2 Products','Jacky','jacob.atam@gmail.com','2023-07-14 17:08:59','2023-07-14 17:08:59',NULL),(363,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 17:43:13','2023-07-14 17:43:13',NULL),(364,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 17:43:33','2023-07-14 17:43:33',NULL),(365,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 17:43:50','2023-07-14 17:43:50',NULL),(366,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 17:46:24','2023-07-14 17:46:24',NULL),(367,1,'Edited a  property ','Jacky','jacob.atam@gmail.com','2023-07-14 17:49:28','2023-07-14 17:49:28',NULL),(368,1,'Updated  Attribute Air conditioning ','Jacky','jacob.atam@gmail.com','2023-07-14 17:51:39','2023-07-14 17:51:39',NULL);
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_attribute`
--

DROP TABLE IF EXISTS `apartment_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_attribute` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint unsigned NOT NULL,
  `attribute_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `bed_count` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_attribute_apartment_id_foreign` (`apartment_id`),
  CONSTRAINT `apartment_attribute_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_attribute`
--

LOCK TABLES `apartment_attribute` WRITE;
/*!40000 ALTER TABLE `apartment_attribute` DISABLE KEYS */;
INSERT INTO `apartment_attribute` VALUES (5,19,168,NULL,NULL,NULL,NULL,NULL),(6,19,166,NULL,NULL,NULL,NULL,NULL),(7,19,169,NULL,NULL,NULL,NULL,NULL),(8,19,164,NULL,NULL,NULL,NULL,NULL),(9,19,165,NULL,NULL,NULL,NULL,NULL),(10,19,167,NULL,NULL,NULL,NULL,NULL),(11,19,170,NULL,NULL,NULL,NULL,NULL),(12,19,171,NULL,NULL,NULL,NULL,NULL),(13,19,177,NULL,NULL,NULL,NULL,NULL),(14,19,192,NULL,NULL,NULL,NULL,NULL),(15,19,191,NULL,NULL,NULL,NULL,NULL),(16,19,174,NULL,NULL,NULL,NULL,NULL),(17,19,180,NULL,NULL,NULL,NULL,NULL),(18,19,179,NULL,NULL,NULL,NULL,NULL),(19,19,178,NULL,NULL,NULL,NULL,NULL),(28,19,130,NULL,NULL,NULL,NULL,1),(29,19,136,NULL,NULL,NULL,NULL,3),(30,19,139,NULL,NULL,NULL,NULL,3),(31,20,168,NULL,NULL,NULL,NULL,NULL),(32,20,166,NULL,NULL,NULL,NULL,NULL),(33,20,169,NULL,NULL,NULL,NULL,NULL),(34,20,164,NULL,NULL,NULL,NULL,NULL),(35,20,165,NULL,NULL,NULL,NULL,NULL),(36,20,167,NULL,NULL,NULL,NULL,NULL),(37,20,170,NULL,NULL,NULL,NULL,NULL),(38,20,171,NULL,NULL,NULL,NULL,NULL),(39,20,177,NULL,NULL,NULL,NULL,NULL),(40,20,192,NULL,NULL,NULL,NULL,NULL),(41,20,191,NULL,NULL,NULL,NULL,NULL),(42,20,174,NULL,NULL,NULL,NULL,NULL),(43,20,180,NULL,NULL,NULL,NULL,NULL),(44,20,179,NULL,NULL,NULL,NULL,NULL),(45,20,178,NULL,NULL,NULL,NULL,NULL),(46,20,129,NULL,NULL,NULL,NULL,6),(47,20,136,NULL,NULL,NULL,NULL,7);
/*!40000 ALTER TABLE `apartment_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_facility`
--

DROP TABLE IF EXISTS `apartment_facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_facility` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `facility_id` bigint unsigned NOT NULL,
  `apartment_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_facility_facility_id_foreign` (`facility_id`),
  KEY `apartment_facility_apartment_id_foreign` (`apartment_id`),
  CONSTRAINT `apartment_facility_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `apartment_facility_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_facility`
--

LOCK TABLES `apartment_facility` WRITE;
/*!40000 ALTER TABLE `apartment_facility` DISABLE KEYS */;
/*!40000 ALTER TABLE `apartment_facility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_location`
--

DROP TABLE IF EXISTS `apartment_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_location` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint unsigned NOT NULL,
  `apartment_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_location_location_id_foreign` (`location_id`),
  KEY `apartment_location_apartment_id_foreign` (`apartment_id`),
  CONSTRAINT `apartment_location_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  CONSTRAINT `apartment_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_location`
--

LOCK TABLES `apartment_location` WRITE;
/*!40000 ALTER TABLE `apartment_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `apartment_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_stocks`
--

DROP TABLE IF EXISTS `apartment_stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `apartment_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_stocks_apartment_id_foreign` (`apartment_id`),
  CONSTRAINT `apartment_stocks_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_stocks`
--

LOCK TABLES `apartment_stocks` WRITE;
/*!40000 ALTER TABLE `apartment_stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `apartment_stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_user`
--

DROP TABLE IF EXISTS `apartment_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `apartment_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_user`
--

LOCK TABLES `apartment_user` WRITE;
/*!40000 ALTER TABLE `apartment_user` DISABLE KEYS */;
INSERT INTO `apartment_user` VALUES (1,14,11,NULL,NULL);
/*!40000 ALTER TABLE `apartment_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartments`
--

DROP TABLE IF EXISTS `apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_id` bigint unsigned NOT NULL,
  `price` bigint unsigned DEFAULT NULL,
  `sale_price` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_from` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_sale_price_expires` timestamp NULL DEFAULT NULL,
  `sale_price_expires` timestamp NULL DEFAULT NULL,
  `quantity` int unsigned DEFAULT NULL,
  `max_adults` int DEFAULT NULL,
  `max_children` int DEFAULT NULL,
  `no_of_rooms` int DEFAULT '1',
  `available` tinyint(1) DEFAULT '1',
  `to_available` timestamp NULL DEFAULT NULL,
  `apartment_available` int DEFAULT '1',
  `toilets` int NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attrs` text COLLATE utf8mb4_unicode_ci,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_price_negotiable` tinyint(1) DEFAULT NULL,
  `price_mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartments`
--

LOCK TABLES `apartments` WRITE;
/*!40000 ALTER TABLE `apartments` DISABLE KEYS */;
INSERT INTO `apartments` VALUES (19,'Apartment',18,4000000,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','apartment',NULL,NULL,NULL,NULL,1,4,4,3,1,NULL,1,3,'multiple','1689355076',NULL,NULL,NULL,'per night'),(20,'apart4',18,80000,NULL,'2023-07-14 17:49:28','2023-07-14 17:49:28','apart4',NULL,NULL,NULL,NULL,1,5,7,2,1,NULL,1,3,'multiple','1689356968',NULL,NULL,NULL,'per night');
/*!40000 ALTER TABLE `apartments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_cart`
--

DROP TABLE IF EXISTS `attribute_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_cart` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `attribute_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_cart`
--

LOCK TABLES `attribute_cart` WRITE;
/*!40000 ALTER TABLE `attribute_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `attribute_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_category`
--

DROP TABLE IF EXISTS `attribute_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_category`
--

LOCK TABLES `attribute_category` WRITE;
/*!40000 ALTER TABLE `attribute_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `attribute_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_information`
--

DROP TABLE IF EXISTS `attribute_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_information` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `information_id` int unsigned NOT NULL,
  `attribute_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_information_information_id_foreign` (`information_id`),
  KEY `attribute_information_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `attribute_information_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attribute_information_information_id_foreign` FOREIGN KEY (`information_id`) REFERENCES `information` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_information`
--

LOCK TABLES `attribute_information` WRITE;
/*!40000 ALTER TABLE `attribute_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `attribute_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_location`
--

DROP TABLE IF EXISTS `attribute_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_location` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=440 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_location`
--

LOCK TABLES `attribute_location` WRITE;
/*!40000 ALTER TABLE `attribute_location` DISABLE KEYS */;
INSERT INTO `attribute_location` VALUES (21,144,3,NULL,NULL,NULL),(30,144,4,NULL,NULL,NULL),(46,123,6,NULL,NULL,NULL),(48,144,6,NULL,NULL,NULL),(49,145,6,NULL,NULL,NULL),(51,147,6,NULL,NULL,NULL),(52,148,6,NULL,NULL,NULL),(53,149,6,NULL,NULL,NULL),(54,150,6,NULL,NULL,NULL),(133,197,4,NULL,NULL,NULL),(137,168,4,NULL,NULL,NULL),(138,166,4,NULL,NULL,NULL),(139,169,4,NULL,NULL,NULL),(140,164,4,NULL,NULL,NULL),(141,165,4,NULL,NULL,NULL),(142,167,4,NULL,NULL,NULL),(143,170,4,NULL,NULL,NULL),(144,171,4,NULL,NULL,NULL),(145,177,4,NULL,NULL,NULL),(146,192,4,NULL,NULL,NULL),(147,174,4,NULL,NULL,NULL),(149,180,4,NULL,NULL,NULL),(150,179,4,NULL,NULL,NULL),(151,178,4,NULL,NULL,NULL),(205,123,5,NULL,NULL,NULL),(210,197,6,NULL,NULL,NULL),(211,126,6,NULL,NULL,NULL),(212,194,6,NULL,NULL,NULL),(213,168,6,NULL,NULL,NULL),(214,166,6,NULL,NULL,NULL),(215,169,6,NULL,NULL,NULL),(216,164,6,NULL,NULL,NULL),(217,165,6,NULL,NULL,NULL),(218,167,6,NULL,NULL,NULL),(219,170,6,NULL,NULL,NULL),(220,171,6,NULL,NULL,NULL),(221,177,6,NULL,NULL,NULL),(222,192,6,NULL,NULL,NULL),(223,174,6,NULL,NULL,NULL),(224,181,6,NULL,NULL,NULL),(225,180,6,NULL,NULL,NULL),(226,179,6,NULL,NULL,NULL),(227,178,6,NULL,NULL,NULL),(228,185,6,NULL,NULL,NULL),(229,184,6,NULL,NULL,NULL),(230,190,6,NULL,NULL,NULL),(231,187,6,NULL,NULL,NULL),(232,186,6,NULL,NULL,NULL),(233,188,6,NULL,NULL,NULL),(256,148,4,NULL,NULL,NULL),(257,191,4,NULL,NULL,NULL),(258,123,1,NULL,NULL,NULL),(262,123,2,NULL,NULL,NULL),(266,123,3,NULL,NULL,NULL),(268,147,3,NULL,NULL,NULL),(270,123,4,NULL,NULL,NULL),(271,126,4,NULL,NULL,NULL),(272,147,4,NULL,NULL,NULL),(273,149,4,NULL,NULL,NULL),(278,145,3,NULL,NULL,NULL),(279,146,3,NULL,NULL,NULL),(301,124,3,NULL,NULL,NULL),(302,148,3,NULL,NULL,NULL),(314,125,5,NULL,NULL,NULL),(328,125,3,NULL,NULL,NULL),(329,149,3,NULL,NULL,NULL),(330,158,3,NULL,NULL,NULL),(331,123,7,NULL,NULL,NULL),(406,124,5,NULL,NULL,NULL),(407,126,5,NULL,NULL,NULL),(409,124,1,NULL,NULL,NULL),(410,125,1,NULL,NULL,NULL),(411,144,1,NULL,NULL,NULL),(412,145,1,NULL,NULL,NULL),(413,146,1,NULL,NULL,NULL),(414,147,1,NULL,NULL,NULL),(415,148,1,NULL,NULL,NULL),(416,149,1,NULL,NULL,NULL),(417,150,1,NULL,NULL,NULL),(418,158,1,NULL,NULL,NULL),(419,124,2,NULL,NULL,NULL),(420,125,2,NULL,NULL,NULL),(421,144,2,NULL,NULL,NULL),(422,145,2,NULL,NULL,NULL),(423,146,2,NULL,NULL,NULL),(424,147,2,NULL,NULL,NULL),(425,148,2,NULL,NULL,NULL),(426,149,2,NULL,NULL,NULL),(427,150,2,NULL,NULL,NULL),(428,158,2,NULL,NULL,NULL),(429,150,3,NULL,NULL,NULL),(430,124,7,NULL,NULL,NULL),(431,125,7,NULL,NULL,NULL),(432,144,7,NULL,NULL,NULL),(433,145,7,NULL,NULL,NULL),(434,146,7,NULL,NULL,NULL),(435,147,7,NULL,NULL,NULL),(436,148,7,NULL,NULL,NULL),(437,149,7,NULL,NULL,NULL),(438,150,7,NULL,NULL,NULL),(439,158,7,NULL,NULL,NULL);
/*!40000 ALTER TABLE `attribute_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_prices`
--

DROP TABLE IF EXISTS `attribute_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `price` bigint DEFAULT NULL,
  `attribute_id` int unsigned NOT NULL,
  `room_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_prices_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `attribute_prices_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_prices`
--

LOCK TABLES `attribute_prices` WRITE;
/*!40000 ALTER TABLE `attribute_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `attribute_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_property`
--

DROP TABLE IF EXISTS `attribute_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_property` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `property_id` bigint unsigned NOT NULL,
  `attribute_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_property_property_id_foreign` (`property_id`),
  CONSTRAINT `attribute_property_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=900 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_property`
--

LOCK TABLES `attribute_property` WRITE;
/*!40000 ALTER TABLE `attribute_property` DISABLE KEYS */;
INSERT INTO `attribute_property` VALUES (799,18,123,NULL,NULL,NULL,NULL,NULL),(800,18,124,NULL,NULL,NULL,NULL,NULL),(801,18,125,NULL,NULL,NULL,NULL,NULL),(802,18,144,NULL,NULL,NULL,NULL,NULL),(803,18,145,NULL,NULL,NULL,NULL,NULL),(804,18,146,NULL,NULL,NULL,NULL,NULL),(805,18,147,NULL,NULL,NULL,NULL,NULL),(806,18,148,NULL,NULL,NULL,NULL,NULL),(807,18,149,NULL,NULL,NULL,NULL,NULL),(808,18,150,NULL,NULL,NULL,NULL,NULL),(809,18,158,NULL,NULL,NULL,NULL,'Languages spoken'),(885,18,168,NULL,NULL,NULL,NULL,NULL),(886,18,166,NULL,NULL,NULL,NULL,NULL),(887,18,169,NULL,NULL,NULL,NULL,NULL),(888,18,164,NULL,NULL,NULL,NULL,NULL),(889,18,165,NULL,NULL,NULL,NULL,NULL),(890,18,167,NULL,NULL,NULL,NULL,NULL),(891,18,170,NULL,NULL,NULL,NULL,NULL),(892,18,171,NULL,NULL,NULL,NULL,NULL),(893,18,177,NULL,NULL,NULL,NULL,NULL),(894,18,192,NULL,NULL,NULL,NULL,NULL),(895,18,191,NULL,NULL,NULL,NULL,NULL),(896,18,174,NULL,NULL,NULL,NULL,NULL),(897,18,180,NULL,NULL,NULL,NULL,NULL),(898,18,179,NULL,NULL,NULL,NULL,NULL),(899,18,178,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `attribute_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attribute_room`
--

DROP TABLE IF EXISTS `attribute_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attribute_room` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint unsigned NOT NULL,
  `attribute_id` bigint unsigned DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `reservation_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attribute_room`
--

LOCK TABLES `attribute_room` WRITE;
/*!40000 ALTER TABLE `attribute_room` DISABLE KEYS */;
INSERT INTO `attribute_room` VALUES (1,1,1,NULL,NULL,NULL,NULL,NULL),(2,1,5,1,NULL,NULL,NULL,NULL),(3,1,6,1,NULL,NULL,NULL,NULL),(4,1,7,1,NULL,NULL,NULL,NULL),(5,1,29,1,NULL,NULL,NULL,NULL),(6,1,28,1,NULL,NULL,NULL,NULL),(7,1,30,1,NULL,NULL,NULL,NULL),(8,2,1,NULL,NULL,NULL,NULL,NULL),(9,2,12,1,NULL,NULL,NULL,NULL),(10,2,12,1,NULL,NULL,NULL,NULL),(16,2,87,1,NULL,NULL,NULL,NULL),(17,2,86,1,NULL,NULL,NULL,NULL),(18,2,117,1,NULL,NULL,NULL,NULL),(19,2,115,1,NULL,NULL,NULL,NULL),(20,2,116,1,NULL,NULL,NULL,NULL),(21,2,114,1,NULL,NULL,NULL,NULL),(22,2,111,1,NULL,NULL,NULL,NULL),(23,2,108,1,NULL,NULL,NULL,NULL),(24,2,79,1,NULL,NULL,NULL,NULL),(25,2,83,1,NULL,NULL,NULL,NULL),(26,2,81,1,NULL,NULL,NULL,NULL),(27,2,84,1,NULL,NULL,NULL,NULL),(28,2,80,1,NULL,NULL,NULL,NULL),(29,2,82,1,NULL,NULL,NULL,NULL),(30,2,74,1,NULL,NULL,NULL,NULL),(31,2,76,1,NULL,NULL,NULL,NULL),(32,2,75,1,NULL,NULL,NULL,NULL),(33,2,77,1,NULL,NULL,NULL,NULL),(34,2,67,1,NULL,NULL,NULL,NULL),(35,2,68,1,NULL,NULL,NULL,NULL),(36,2,43,1,NULL,NULL,NULL,NULL),(37,2,42,1,NULL,NULL,NULL,NULL),(38,2,51,1,NULL,NULL,NULL,NULL),(39,2,47,1,NULL,NULL,NULL,NULL),(40,2,49,1,NULL,NULL,NULL,NULL),(41,2,62,1,NULL,NULL,NULL,NULL),(42,2,59,1,NULL,NULL,NULL,NULL),(43,2,55,1,NULL,NULL,NULL,NULL),(44,2,54,1,NULL,NULL,NULL,NULL),(45,2,18,1,NULL,NULL,NULL,NULL),(46,2,19,1,NULL,NULL,NULL,NULL),(47,2,56,1,NULL,NULL,NULL,NULL),(48,2,61,1,NULL,NULL,NULL,NULL),(49,2,60,1,NULL,NULL,NULL,NULL),(50,2,58,1,NULL,NULL,NULL,NULL),(51,2,1,NULL,NULL,NULL,NULL,NULL),(52,2,119,1,NULL,NULL,NULL,NULL),(53,2,120,1,NULL,NULL,NULL,NULL),(54,2,100,1,NULL,NULL,NULL,NULL),(55,2,98,1,NULL,NULL,NULL,NULL),(56,2,101,1,NULL,NULL,NULL,NULL),(57,2,99,1,NULL,NULL,NULL,NULL),(58,2,102,1,NULL,NULL,NULL,NULL),(60,2,0,1,NULL,NULL,NULL,NULL),(61,2,50,1,NULL,NULL,NULL,NULL),(62,3,1,NULL,NULL,NULL,NULL,NULL),(63,3,12,1,NULL,NULL,NULL,NULL),(64,3,12,1,NULL,NULL,NULL,NULL),(70,3,87,1,NULL,NULL,NULL,NULL),(71,3,86,1,NULL,NULL,NULL,NULL),(72,3,117,1,NULL,NULL,NULL,NULL),(73,3,115,1,NULL,NULL,NULL,NULL),(74,3,114,1,NULL,NULL,NULL,NULL),(75,3,111,1,NULL,NULL,NULL,NULL),(76,3,108,1,NULL,NULL,NULL,NULL),(77,3,112,1,NULL,NULL,NULL,NULL),(78,3,110,1,NULL,NULL,NULL,NULL),(79,3,109,1,NULL,NULL,NULL,NULL),(80,3,101,1,NULL,NULL,NULL,NULL),(81,3,99,1,NULL,NULL,NULL,NULL),(82,3,102,1,NULL,NULL,NULL,NULL),(83,3,96,1,NULL,NULL,NULL,NULL),(84,3,94,1,NULL,NULL,NULL,NULL),(85,3,89,1,NULL,NULL,NULL,NULL),(86,3,90,1,NULL,NULL,NULL,NULL),(87,3,79,1,NULL,NULL,NULL,NULL),(88,3,83,1,NULL,NULL,NULL,NULL),(89,3,81,1,NULL,NULL,NULL,NULL),(90,3,84,1,NULL,NULL,NULL,NULL),(91,3,67,1,NULL,NULL,NULL,NULL),(92,3,70,1,NULL,NULL,NULL,NULL),(93,3,49,1,NULL,NULL,NULL,NULL),(94,3,46,1,NULL,NULL,NULL,NULL),(95,3,53,1,NULL,NULL,NULL,NULL),(96,3,45,1,NULL,NULL,NULL,NULL),(97,3,62,1,NULL,NULL,NULL,NULL),(98,3,59,1,NULL,NULL,NULL,NULL),(99,3,55,1,NULL,NULL,NULL,NULL),(100,3,54,1,NULL,NULL,NULL,NULL),(101,3,18,1,NULL,NULL,NULL,NULL),(102,3,15,1,NULL,NULL,NULL,NULL),(103,3,14,1,NULL,NULL,NULL,NULL),(104,3,1,NULL,NULL,NULL,NULL,NULL),(105,3,119,1,NULL,NULL,NULL,NULL),(106,3,120,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `attribute_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attributes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hex_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `svg` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attributes`
--

LOCK TABLES `attributes` WRITE;
/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
INSERT INTO `attributes` VALUES (123,'Pets',NULL,'2021-09-19 10:51:34','2021-09-20 00:08:27',NULL,'rules',NULL,NULL,NULL,'pets',0.00,NULL,NULL,NULL),(124,'No Pets',NULL,'2021-09-19 10:52:15','2021-09-20 00:08:11',NULL,'rules',NULL,NULL,NULL,'no_pets',0.00,NULL,NULL,NULL),(125,'No Smoking',NULL,'2021-09-19 10:52:32','2021-09-20 00:08:19',NULL,'rules',NULL,NULL,NULL,'no_smoking',0.00,NULL,NULL,NULL),(126,'Smoking allowed',NULL,'2021-09-19 10:53:09','2021-09-20 00:08:37',NULL,'rules',NULL,NULL,NULL,'smoking_allowed',0.00,NULL,NULL,NULL),(128,'Bedroom 1',NULL,'2021-09-19 11:24:28','2022-03-06 14:02:39',NULL,'bedrooms',NULL,NULL,NULL,'bedroom_1',0.00,NULL,NULL,'<svg class=\"\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><path fill-rule=\"evenodd\" d=\"M11 7h8a4 4 0 014 4v9h-2v-3H3v3H1V5h2v9h8V7zm-1 3a3 3 0 11-6 0 3 3 0 016 0z\" clip-rule=\"evenodd\"></path></svg>'),(129,'Extra-large double bed',128,'2021-09-19 12:06:15','2021-09-19 12:06:15',NULL,'bedrooms',NULL,NULL,NULL,'extra_large_double_bed',0.00,NULL,NULL,NULL),(130,'Single bed',128,'2021-09-19 12:06:33','2021-09-19 12:06:33',NULL,'bedrooms',NULL,NULL,NULL,'single_bed',0.00,NULL,NULL,NULL),(131,'Large bed',128,'2021-09-19 12:06:57','2021-09-19 12:06:57',NULL,'bedrooms',NULL,NULL,NULL,'large_bed',0.00,NULL,NULL,NULL),(132,'Bedroom 2',NULL,'2021-09-19 12:07:53','2021-09-19 12:07:53',NULL,'bedrooms',NULL,NULL,NULL,'bedroom_2',0.00,NULL,NULL,NULL),(133,'Bedroom 3',NULL,'2021-09-19 12:08:13','2021-09-19 12:08:13',NULL,'bedrooms',NULL,NULL,NULL,'bedroom_3',0.00,NULL,NULL,NULL),(135,'Bedroom 4',NULL,'2021-09-19 12:10:02','2021-09-19 12:10:02',NULL,'bedrooms',NULL,NULL,NULL,'bedroom_4',0.00,NULL,NULL,NULL),(136,'Extra-large double bed',132,'2021-09-19 12:10:45','2021-09-19 12:10:45',NULL,'bedrooms',NULL,NULL,NULL,'extra_large_double_bed',0.00,NULL,NULL,NULL),(137,'Single bed',132,'2021-09-19 12:11:00','2021-09-19 12:11:00',NULL,'bedrooms',NULL,NULL,NULL,'single_bed',0.00,NULL,NULL,NULL),(138,'Large bed',132,'2021-09-19 12:13:21','2021-09-19 12:13:21',NULL,'bedrooms',NULL,NULL,NULL,'large_bed',0.00,NULL,NULL,NULL),(139,'Single bed',133,'2021-09-19 12:16:23','2021-09-19 12:16:23',NULL,'bedrooms',NULL,NULL,NULL,'single_bed',0.00,NULL,NULL,NULL),(140,'Extra-large double bed',133,'2021-09-19 12:16:54','2021-09-19 12:16:54',NULL,'bedrooms',NULL,NULL,NULL,'extra_large_double_bed',0.00,NULL,NULL,NULL),(141,'Large bed',133,'2021-09-19 12:21:01','2021-09-19 12:21:01',NULL,'bedrooms',NULL,NULL,NULL,'large_bed',0.00,NULL,NULL,NULL),(144,'Air conditioning',NULL,'2021-09-19 12:29:13','2023-07-14 17:51:39',NULL,'facilities',NULL,NULL,NULL,'air_conditioning',0.00,NULL,NULL,'<svg class=\"uitk-icon uitk-spacing uitk-spacing-padding-inlineend-two uitk-icon-medium uitk-icon-default-theme\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><path d=\"M22 11h-4.17l3.24-3.24-1.41-1.42L15 11h-2V9l4.66-4.66-1.42-1.41L13 6.17V2h-2v4.17L7.76 2.93 6.34 4.34 11 9v2H9L4.34 6.34 2.93 7.76 6.17 11H2v2h4.17l-3.24 3.24 1.41 1.42L9 13h2v2l-4.66 4.66 1.42 1.41L11 17.83V22h2v-4.17l3.24 3.24 1.42-1.41L13 15v-2h2l4.66 4.66 1.41-1.42L17.83 13H22v-2z\"></path></svg>'),(145,'Kitchen',NULL,'2021-09-19 12:29:28','2021-09-29 18:52:08',NULL,'facilities',NULL,NULL,NULL,'kitchen',0.00,NULL,NULL,'<svg class=\"\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><svg><path d=\"M6 9h8v2H6V9z\"></path><path d=\"M21 5c.6 0 1 .4 1 1v12c0 .6-.4 1-1 1H3c-.6 0-1-.4-1-1V6c0-.6.4-1 1-1h18zm-5 11V8c0-.54-.46-1-1-1H5c-.6 0-1 .4-1 1v8c0 .5.4 1 1 1h10c.5 0 1-.5 1-1zm3 0c.6 0 1-.4 1-1s-.4-1-1-1-1 .4-1 1 .4 1 1 1zm0-4c.6 0 1-.4 1-1s-.4-1-1-1-1 .4-1 1 .4 1 1 1z\"></path></svg></svg>'),(146,'Parking',NULL,'2021-09-19 12:31:37','2021-09-22 17:13:51',NULL,'facilities',NULL,NULL,NULL,'parking',0.00,NULL,NULL,'<svg class=\"uitk-icon uitk-icon-medium\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><path fill-rule=\"evenodd\" d=\"M6 3h7a6 6 0 010 12h-3v6H6V3zm4 8h3.2a2 2 0 002-2 2 2 0 00-2-2H10v4z\" clip-rule=\"evenodd\"></path></svg>'),(147,'Swimming Pool',NULL,'2021-09-19 12:32:56','2021-09-29 18:52:35',NULL,'facilities',NULL,NULL,NULL,'swimming_pool',0.00,NULL,NULL,'<svg class=\"\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><path d=\"M9.82 11.64h.01a4.15 4.15 0 014.36 0h.01c.76.46 1.54.47 2.29 0l.41-.23L10.48 5C8.93 3.45 7.5 2.99 5 3v2.5c1.82-.01 2.89.39 4 1.5l1 1-3.25 3.25c.27.1.52.25.77.39.75.47 1.55.47 2.3 0z\"></path><path fill-rule=\"evenodd\" d=\"M21.98 16.5c-1.1 0-1.71-.37-2.16-.64h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0 4.13 4.13 0 01-4.36 0h-.01a2.08 2.08 0 00-2.29 0l-.03.02c-.47.27-1.08.62-2.17.62v-2c.56 0 .78-.13 1.15-.36a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.76.46 1.54.47 2.29 0a4.13 4.13 0 014.36 0h.01c.36.22.6.36 1.14.36v2z\" clip-rule=\"evenodd\"></path><path d=\"M19.82 20.36c.45.27 1.07.64 2.18.64v-2a1.8 1.8 0 01-1.15-.36 4.13 4.13 0 00-4.36 0c-.75.47-1.53.46-2.29 0h-.01a4.15 4.15 0 00-4.36 0h-.01c-.75.47-1.55.47-2.3 0a4.15 4.15 0 00-4.36 0h-.01A1.8 1.8 0 012 19v2c1.1 0 1.72-.36 2.18-.63l.01-.01a2.07 2.07 0 012.3 0c1.39.83 2.97.82 4.36 0h.01a2.08 2.08 0 012.29 0h.01c1.38.83 2.95.83 4.34.01l.02-.01a2.08 2.08 0 012.29 0h.01zM19 5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z\"></path></svg>'),(148,'Pets allowed',NULL,'2021-09-19 12:33:16','2021-09-29 18:53:30',NULL,'facilities',NULL,NULL,NULL,'pets_allowed',0.00,NULL,NULL,'<svg class=\"uitk-icon uitk-flex-item all-r-margin-zero all-r-padding-three uitk-icon-medium\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><svg><path d=\"M9 8a2.5 2.5 0 100-5 2.5 2.5 0 000 5zm-4.5 4a2.5 2.5 0 100-5 2.5 2.5 0 000 5zm13-6.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm2 6.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5zm-9.7-.61l-5.15 5.58A3 3 0 006.85 22h.65l1.19-.13a30 30 0 016.62 0l1.19.13h.65a3 3 0 002.2-5.03l-5.15-5.58a3 3 0 00-4.4 0z\"></path></svg></svg>'),(149,'TV',NULL,'2021-09-19 12:35:33','2021-09-22 17:12:10',NULL,'facilities',NULL,NULL,NULL,'tv',0.00,NULL,NULL,NULL),(150,'Fitness Center',NULL,'2021-09-19 12:36:00','2021-09-20 12:52:47',NULL,'facilities',NULL,NULL,NULL,'fitness_center',0.00,NULL,NULL,NULL),(151,'Bathroom',NULL,'2021-09-19 12:37:12','2021-10-07 17:45:26',NULL,'apartment facilities',NULL,NULL,NULL,'bathroom',0.00,NULL,NULL,'<svg class=\"\" height=\"16\" width=\"16\" viewBox=\"0 0 24 24\" role=\"presentation\" aria-hidden=\"true\" focusable=\"false\"><path d=\"M12.75 15h10.5l-.74-.873-.664 3.986a5.25 5.25 0 0 1-5.179 4.387H7.333a5.25 5.25 0 0 1-5.18-4.387l-.663-3.986L.75 15h4.5a.75.75 0 0 0 0-1.5H.75a.75.75 0 0 0-.74.873l.664 3.986A6.75 6.75 0 0 0 7.334 24h9.333a6.75 6.75 0 0 0 6.659-5.64l.664-3.987a.75.75 0 0 0-.74-.873h-10.5a.75.75 0 0 0 0 1.5zM12 19.5H6v-5.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v5.25zm0 1.5a1.5 1.5 0 0 0 1.5-1.5v-5.25A2.25 2.25 0 0 0 11.25 12h-4.5a2.25 2.25 0 0 0-2.25 2.25v5.25A1.5 1.5 0 0 0 6 21h6zm4.5-17.25a2.25 2.25 0 0 1 4.5 0v10.5a.75.75 0 0 0 1.5 0V3.75a3.75 3.75 0 1 0-7.5 0 .75.75 0 0 0 1.5 0zm-3 3a2.25 2.25 0 0 1 4.5 0l.75-.75h-6l.75.75zm-1.5 0c0 .414.336.75.75.75h6a.75.75 0 0 0 .75-.75 3.75 3.75 0 1 0-7.5 0z\"></path></svg>'),(152,'Bedroom',NULL,'2021-09-19 12:39:55','2021-10-07 18:03:40',NULL,'apartment facilities',NULL,NULL,NULL,'bedroom',0.00,NULL,NULL,NULL),(153,'Outdoors',NULL,'2021-09-19 12:40:54','2021-10-07 18:03:57',NULL,'apartment facilities',NULL,NULL,NULL,'outdoors',0.00,NULL,NULL,'<svg class=\"bk-icon -streamline-garden\" height=\"16\" width=\"16\" viewBox=\"0 0 24 24\" role=\"presentation\" aria-hidden=\"true\" focusable=\"false\"><path d=\"M5.361 6.625a6.75 6.75 0 0 0 7.413 6.721 6.93 6.93 0 0 0 6.087-6.988V2.125a1.5 1.5 0 0 0-2.4-1.2l-1.8 1.35h.9L13.461.7c-.8-.6-1.9-.6-2.7 0l-2.1 1.575h.9l-1.8-1.35a1.5 1.5 0 0 0-2.4 1.2v4.5zm1.5 0v-4.5l1.8 1.35c.267.2.633.2.9 0l2.1-1.575a.75.75 0 0 1 .9 0l2.1 1.575c.267.2.633.2.9 0l1.8-1.35V6.37a5.428 5.428 0 0 1-4.754 5.486 5.25 5.25 0 0 1-5.746-5.23zm4.5 6v10.5a.75.75 0 0 0 1.5 0v-10.5a.75.75 0 0 0-1.5 0zm-5.359 3.811c1.473.285 2.458 1.077 2.374 1.51-.084.432-1.292.801-2.765.516-1.473-.284-2.458-1.076-2.374-1.51.084-.432 1.292-.8 2.765-.516zm.285-1.473c-2.179-.42-4.233.206-4.523 1.705-.29 1.5 1.383 2.846 3.562 3.267 2.179.421 4.233-.205 4.523-1.705.29-1.5-1.383-2.846-3.562-3.267zm14.699 2.09c.084.434-.9 1.226-2.374 1.51-1.473.285-2.681-.084-2.765-.516-.084-.433.9-1.226 2.374-1.51 1.473-.285 2.681.084 2.765.517zm1.473-.284c-.29-1.5-2.344-2.126-4.523-1.705-2.178.421-3.851 1.767-3.562 3.267.29 1.5 2.344 2.126 4.523 1.705 2.179-.42 3.852-1.767 3.562-3.267z\"></path></svg>'),(155,'Room Facilities',NULL,'2021-09-19 12:41:42','2021-10-07 18:04:14',NULL,'apartment facilities',NULL,NULL,NULL,'room_facilities',0.00,NULL,NULL,NULL),(156,'Living Area',NULL,'2021-09-19 12:42:09','2021-10-07 18:04:37',NULL,'apartment facilities',NULL,NULL,NULL,'living_area',0.00,NULL,NULL,NULL),(157,'Languages spoken',NULL,'2021-09-19 12:44:53','2021-09-19 12:44:53',NULL,'other',NULL,NULL,NULL,'languages_spoken',0.00,NULL,NULL,NULL),(158,'English',157,'2021-09-19 12:45:28','2021-09-19 12:45:28',NULL,'other',NULL,NULL,NULL,'english',0.00,NULL,NULL,NULL),(159,'French',157,'2021-09-19 12:45:44','2021-09-19 12:45:44',NULL,'other',NULL,NULL,NULL,'french',0.00,NULL,NULL,NULL),(160,'Media & Technology',NULL,'2021-09-19 14:56:21','2021-10-07 18:04:58',NULL,'apartment facilities',NULL,NULL,NULL,'media_technology',0.00,NULL,NULL,NULL),(161,'Internet',NULL,'2021-09-19 14:58:53','2021-10-07 18:05:13',NULL,'extra services',NULL,NULL,NULL,'internet',0.00,NULL,NULL,NULL),(162,'Wellness',NULL,'2021-09-19 15:00:09','2021-10-07 18:06:27',NULL,'apartment facilities',NULL,NULL,NULL,'wellness',0.00,NULL,NULL,NULL),(164,'Toilet paper',151,'2021-09-19 19:07:53','2021-10-07 18:09:00',NULL,'apartment facilities',NULL,NULL,NULL,'toilet_paper',0.00,NULL,NULL,NULL),(165,'Towels',151,'2021-09-19 19:08:11','2021-10-07 18:09:15',NULL,'apartment facilities',NULL,NULL,NULL,'towels',0.00,NULL,NULL,NULL),(166,'Bidet',151,'2021-09-19 19:10:15','2021-10-07 18:07:23',NULL,'apartment facilities',NULL,NULL,NULL,'bidet',0.00,NULL,NULL,NULL),(167,'Towels/sheets (extra fee)',151,'2021-09-19 19:10:42','2021-10-07 18:09:27',NULL,'apartment facilities',NULL,NULL,NULL,'towelssheets_extra_fee',0.00,NULL,NULL,NULL),(168,'Additional toilet',151,'2021-09-19 19:11:13','2021-10-07 18:07:14',NULL,'apartment facilities',NULL,NULL,NULL,'additional_toilet',0.00,NULL,NULL,NULL),(169,'Hairdryer',151,'2021-09-19 19:11:38','2021-10-07 18:07:42',NULL,'apartment facilities',NULL,NULL,NULL,'hairdryer',0.00,NULL,NULL,NULL),(170,'Linen',152,'2021-09-19 19:12:05','2021-10-07 18:10:05',NULL,'apartment facilities',NULL,NULL,NULL,'linen',0.00,NULL,NULL,NULL),(171,'Wardrobe or closet',152,'2021-09-19 19:12:54','2021-10-07 18:10:18',NULL,'apartment facilities',NULL,NULL,NULL,'wardrobe_or_closet',0.00,NULL,NULL,NULL),(174,'Flat-screen TV',160,'2021-09-19 19:22:51','2021-10-07 18:11:47',NULL,'apartment facilities',NULL,NULL,NULL,'flat_screen_tv',0.00,NULL,NULL,NULL),(177,'All pools are free of charge',153,'2021-09-20 00:36:20','2021-09-20 00:36:20',NULL,'apartment_facilities',NULL,NULL,NULL,'all_pools_are_free_of_charge',0.00,NULL,NULL,NULL),(178,'Sun loungers or beach chairs',162,'2021-09-20 00:36:47','2021-10-07 18:12:48',NULL,'apartment facilities',NULL,NULL,NULL,'sun_loungers_or_beach_chairs',0.00,NULL,NULL,NULL),(179,'Pool/beach towels',162,'2021-09-20 00:37:06','2021-10-07 18:12:37',NULL,'apartment facilities',NULL,NULL,NULL,'poolbeach_towels',0.00,NULL,NULL,NULL),(180,'Hot tub/Jacuzzi',162,'2021-09-20 00:37:24','2021-10-07 18:12:14',NULL,'apartment facilities',NULL,NULL,NULL,'hot_tubjacuzzi',0.00,NULL,NULL,NULL),(181,'WiFi',161,'2021-09-20 00:37:53','2021-09-20 00:37:53',NULL,'apartment_facilities',NULL,NULL,NULL,'wifi',0.00,NULL,NULL,NULL),(183,'Kitchen & Dining',NULL,'2021-09-20 00:40:15','2021-09-20 13:07:52',NULL,'apartment_facilities',NULL,NULL,NULL,'kitchen_dining',0.00,NULL,NULL,NULL),(184,'Dining table',183,'2021-09-20 00:40:30','2021-09-20 00:40:30',NULL,'apartment_facilities',NULL,NULL,NULL,'dining_table',0.00,NULL,NULL,NULL),(185,'Cleaning products',183,'2021-09-20 00:41:25','2021-09-20 00:41:25',NULL,'apartment_facilities',NULL,NULL,NULL,'cleaning_products',0.00,NULL,NULL,NULL),(186,'Toaster',183,'2021-09-20 00:42:09','2021-09-20 00:42:09',NULL,'apartment_facilities',NULL,NULL,NULL,'toaster',0.00,NULL,NULL,NULL),(187,'Oven',183,'2021-09-20 00:42:23','2021-09-20 00:42:23',NULL,'apartment_facilities',NULL,NULL,NULL,'oven',0.00,NULL,NULL,NULL),(188,'Tumble dryer',183,'2021-09-20 00:42:41','2021-10-07 17:45:06',NULL,'apartment facilities',NULL,NULL,NULL,'tumble_dryer',0.00,NULL,NULL,NULL),(189,'Kitchenware',183,'2021-09-20 00:43:03','2021-09-20 00:43:03',NULL,'apartment_facilities',NULL,NULL,NULL,'kitchenware',0.00,NULL,NULL,NULL),(190,'Electric kettle',183,'2021-09-20 00:43:21','2021-09-20 00:43:21',NULL,'apartment_facilities',NULL,NULL,NULL,'electric_kettle',0.00,NULL,NULL,NULL),(191,'Sofa',156,'2021-09-20 00:43:54','2021-10-07 18:11:13',NULL,'apartment facilities',NULL,NULL,NULL,'sofa',0.00,NULL,NULL,NULL),(192,'Dining area',156,'2021-09-20 00:44:13','2021-10-07 18:10:59',NULL,'apartment facilities',NULL,NULL,NULL,'dining_area',0.00,NULL,NULL,NULL),(193,'Body Masage',NULL,'2021-09-20 00:46:25','2021-10-07 17:59:19',NULL,'extra services',NULL,NULL,NULL,'body_masage',0.00,NULL,NULL,NULL),(194,'Wifi',NULL,'2021-09-22 17:11:56','2021-09-22 17:11:56',NULL,'facilities',NULL,NULL,NULL,'wifi',0.00,NULL,NULL,'<svg class=\"uitk-icon uitk-icon-medium\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><path fill-rule=\"evenodd\" d=\"M1 9l2 2a12.73 12.73 0 0118 0l2-2A15.57 15.57 0 001 9zm8 8l3 3 3-3a4.24 4.24 0 00-6 0zm-2-2l-2-2a9.91 9.91 0 0114 0l-2 2a7.07 7.07 0 00-10 0z\" clip-rule=\"evenodd\"></path></svg>'),(195,'Car Hire',NULL,'2021-09-29 18:43:45','2021-10-07 17:59:51',NULL,'extra services',NULL,NULL,NULL,'car_hire',0.00,NULL,NULL,NULL),(196,'BreakFast',NULL,'2021-09-29 18:44:29','2021-10-07 18:00:02',NULL,'extra services',NULL,NULL,NULL,'breakfast',0.00,NULL,NULL,NULL),(197,'Serviced Apartment',NULL,'2021-09-29 19:12:28','2021-10-07 18:02:55',NULL,'property type',NULL,NULL,NULL,'serviced_apartment',0.00,NULL,NULL,NULL),(198,'Boat Cruise',NULL,'2021-09-30 17:23:01','2021-10-07 18:01:35',NULL,'extra services',NULL,NULL,NULL,'boat_cruise',0.00,NULL,NULL,NULL),(199,'Lunch',NULL,'2021-09-30 17:23:32','2021-10-07 18:02:38',NULL,'extra services',NULL,NULL,NULL,'lunch',0.00,NULL,NULL,NULL),(200,'Dinner',NULL,'2021-09-30 17:23:43','2021-10-07 18:01:57',NULL,'extra services',NULL,NULL,NULL,'dinner',0.00,NULL,NULL,NULL),(201,'area',NULL,'2021-09-30 17:36:04','2021-09-30 17:36:04',NULL,'other',NULL,NULL,NULL,'area',0.00,NULL,NULL,NULL),(202,'Chocolat Royal',NULL,'2021-09-30 17:37:00','2021-09-30 17:37:00',NULL,'other',NULL,NULL,NULL,'chocolat_royal',0.00,NULL,NULL,NULL),(203,'Safety',NULL,'2021-09-30 17:38:06','2021-09-30 17:38:06',NULL,'other',NULL,NULL,NULL,'safety',0.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `col` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sm_col_width` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `md_col_width` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (2,'Test','#',1,'https://myshortlet.xyz/images/banners/ZfiEXk63NcIYmoqMXdV32b3OtIAjPmEbO9oETebP.jpg',NULL,'2023-01-17 20:55:25','2023-01-17 20:55:25','col-lg-12','slider','col-12',NULL,NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_details`
--

DROP TABLE IF EXISTS `booking_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  `total` bigint DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin` timestamp NULL DEFAULT NULL,
  `checkout` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sale_price` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_details`
--

LOCK TABLES `booking_details` WRITE;
/*!40000 ALTER TABLE `booking_details` DISABLE KEYS */;
INSERT INTO `booking_details` VALUES (1,6,7,1,1,5000,5000,'$2y$10$pReP51VCgvg/m20h06OqwO35FMinHW3mxRJS9GC5nt2v/jbVVz/JG','2021-10-16 00:00:00','2021-11-16 00:00:00','2021-10-07 14:26:57','2021-10-07 14:31:34',NULL),(2,5,6,1,1,50000,50000,'$2y$10$pReP51VCgvg/m20h06OqwO35FMinHW3mxRJS9GC5nt2v/jbVVz/JG','2021-11-15 00:00:00','2021-11-17 00:00:00','2021-10-07 14:32:10','2021-10-07 14:34:07',NULL),(3,5,6,1,1,50000,50000,'$2y$10$ETl/XMlcQpB.I.cz1ubZ6epE1kyYGt.F441C4GBaS0slAMmWkF8TW','2021-11-14 00:00:00','2021-11-16 00:00:00','2021-10-07 15:23:45','2021-10-07 15:32:05',NULL),(4,8,9,1,1,5000,5000,'$2y$10$ETl/XMlcQpB.I.cz1ubZ6epE1kyYGt.F441C4GBaS0slAMmWkF8TW','2021-11-14 00:00:00','2021-11-16 00:00:00','2021-10-07 18:24:39','2021-10-07 18:41:10',NULL),(5,9,10,1,1,5000,5000,'$2y$10$ETl/XMlcQpB.I.cz1ubZ6epE1kyYGt.F441C4GBaS0slAMmWkF8TW','2021-10-15 00:00:00','2021-10-16 00:00:00','2021-10-14 20:27:13','2021-10-14 20:27:13',NULL),(6,9,10,1,NULL,5000,5000,'$2y$10$dqxA9w0k9Jw6tSPAMlomEeoNSDoEtcwUj79MXb7McZ3fvK4O6Jk0u','2022-03-06 00:00:00','2022-03-07 00:00:00','2022-02-28 00:08:35','2022-02-28 08:29:22',NULL),(7,10,11,1,NULL,600000,600000,'$2y$10$dqxA9w0k9Jw6tSPAMlomEeoNSDoEtcwUj79MXb7McZ3fvK4O6Jk0u','2022-03-11 00:00:00','2022-03-12 00:00:00','2022-03-05 20:13:24','2022-03-07 11:43:23',NULL),(8,10,11,1,NULL,600000,600000,'$2y$10$ghTclmuyxbpMqLdT/RLYWegzmcFm32AgIc3uXdqauJJydtqIdeUQ.','2022-03-08 00:00:00','2022-03-12 00:00:00','2022-03-07 19:45:20','2022-03-07 19:45:20',NULL),(9,10,11,1,NULL,600000,600000,'$2y$10$bITQXRGeFkbzlbaednj5A.tLI8nOl8fJGZ0tuKKFqn8DkvQld46nS','2022-03-16 00:00:00','2022-03-18 00:00:00','2022-03-07 19:45:28','2022-03-13 15:16:35',NULL),(10,10,11,2,NULL,600000,1200000,'$2y$10$KEElxFmeLS/d.IHMQ6Hayu7JSJwA2P4e9akvagurwEbkx01Pj49v2','2023-01-14 00:00:00','2023-02-06 00:00:00','2022-08-03 20:08:02','2023-01-10 17:12:27',NULL),(11,12,13,1,NULL,1000000,1000000,'$2y$10$KEElxFmeLS/d.IHMQ6Hayu7JSJwA2P4e9akvagurwEbkx01Pj49v2','2023-02-15 00:00:00','2023-02-18 00:00:00','2023-01-11 19:51:31','2023-01-17 14:51:17',NULL),(12,12,13,2,NULL,1000000,2000000,'$2y$10$K8ukP8kb5v8LDa79LpTiCe1qKSuo39QT0PW.udl/2hINkYfOFUINW','2023-06-28 00:00:00','2023-06-30 00:00:00','2023-06-16 03:41:23','2023-06-20 19:14:18',NULL),(13,11,12,1,NULL,40000,40000,'$2y$10$OcXub96chu.Ud.Ql8jBB7OiKNvL/2Nkmfs4z/Pq3WYlfDfwvthWL2','2023-07-18 00:00:00','2023-07-20 00:00:00','2023-06-21 14:46:08','2023-06-21 14:46:08',NULL),(14,12,13,1,NULL,1000000,1000000,'$2y$10$/pB4v2.k8uwLi.H8C5EehOpaLYoXNKfxQI7ODUwZ8C8/bo2z8udhC','2023-07-12 00:00:00','2023-07-14 00:00:00','2023-06-25 01:35:04','2023-06-28 22:40:44',NULL),(15,11,12,1,NULL,40000,40000,'$2y$10$/pB4v2.k8uwLi.H8C5EehOpaLYoXNKfxQI7ODUwZ8C8/bo2z8udhC','2023-07-18 00:00:00','2023-07-21 00:00:00','2023-06-25 02:08:48','2023-06-28 23:02:44',NULL);
/*!40000 ALTER TABLE `booking_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `room_id` int DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in` timestamp NULL DEFAULT NULL,
  `check_out` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  `image_custom_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_index` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_location`
--

DROP TABLE IF EXISTS `category_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_location` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_location_location_id_foreign` (`location_id`),
  CONSTRAINT `category_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_location`
--

LOCK TABLES `category_location` WRITE;
/*!40000 ALTER TABLE `category_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_property`
--

DROP TABLE IF EXISTS `category_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_property` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `property_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_property_property_id_foreign` (`property_id`),
  CONSTRAINT `category_property_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_property`
--

LOCK TABLES `category_property` WRITE;
/*!40000 ALTER TABLE `category_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` int unsigned NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_code2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_code3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (8,'2021-06-16 03:32:08','2021-06-16 03:32:08','Australian','$',NULL,'AUD'),(9,'2021-06-16 03:32:08','2021-06-16 03:32:08','Nigeria','₦',NULL,'NGR'),(10,'2021-06-16 03:32:08','2021-06-16 03:32:08','United States','$',NULL,'USD'),(11,'2021-06-16 03:32:08','2021-06-16 03:32:08','Europe','€',NULL,'EUR'),(12,'2021-06-16 03:32:08','2021-06-16 03:32:08','United Kingdom','£',NULL,'GBP');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_rate_countries`
--

DROP TABLE IF EXISTS `currency_rate_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currency_rate_countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `currency_rate_id` int DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_rate_countries`
--

LOCK TABLES `currency_rate_countries` WRITE;
/*!40000 ALTER TABLE `currency_rate_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency_rate_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_rates`
--

DROP TABLE IF EXISTS `currency_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currency_rates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `currency1_id` int DEFAULT NULL,
  `currency2_id` int DEFAULT NULL,
  `rate` decimal(6,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_rates`
--

LOCK TABLES `currency_rates` WRITE;
/*!40000 ALTER TABLE `currency_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extras`
--

DROP TABLE IF EXISTS `extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `guest_user_id` int DEFAULT NULL,
  `attribute_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  `reservation_id` int DEFAULT NULL,
  `user_reservation_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extras`
--

LOCK TABLES `extras` WRITE;
/*!40000 ALTER TABLE `extras` DISABLE KEYS */;
INSERT INTO `extras` VALUES (1,9,NULL,1,1,1,198,'2021-10-14 20:28:14','2021-10-14 20:28:14',NULL,NULL,NULL),(2,NULL,NULL,NULL,1,1,193,'2021-10-14 20:28:14','2021-10-14 20:28:14',NULL,NULL,NULL),(3,NULL,NULL,NULL,1,1,196,'2021-10-14 20:28:14','2021-10-14 20:28:14',NULL,NULL,NULL),(4,10,NULL,1,NULL,2,193,'2022-03-07 11:43:34','2022-03-07 11:43:34',5000,3,NULL),(5,10,NULL,1,NULL,2,195,'2022-03-07 11:43:34','2022-03-07 11:43:34',5000,3,NULL),(6,10,NULL,1,NULL,3,193,'2022-08-03 20:09:10','2022-08-03 20:09:10',5000,4,NULL),(7,10,NULL,1,NULL,4,195,'2023-01-09 13:26:42','2023-01-09 13:26:42',5000,5,NULL),(8,10,NULL,1,NULL,4,198,'2023-01-09 13:26:42','2023-01-09 13:26:42',5000,5,NULL),(9,NULL,NULL,NULL,NULL,4,193,'2023-01-09 13:26:42','2023-01-09 13:26:42',5000,NULL,5),(10,NULL,NULL,NULL,NULL,4,198,'2023-01-09 13:26:42','2023-01-09 13:26:42',5000,NULL,5),(11,NULL,NULL,NULL,1,8,193,'2023-01-11 20:50:07','2023-01-11 20:50:07',NULL,NULL,9),(12,NULL,NULL,NULL,1,8,196,'2023-01-11 20:50:07','2023-01-11 20:50:07',NULL,NULL,9),(13,NULL,NULL,NULL,1,8,198,'2023-01-11 20:50:07','2023-01-11 20:50:07',NULL,NULL,9),(14,NULL,NULL,NULL,NULL,9,196,'2023-06-16 03:41:59','2023-06-16 03:41:59',NULL,NULL,10),(15,NULL,NULL,NULL,NULL,9,198,'2023-06-16 03:41:59','2023-06-16 03:41:59',NULL,NULL,10),(16,NULL,NULL,NULL,NULL,10,198,'2023-06-19 04:39:27','2023-06-19 04:39:27',NULL,NULL,11),(17,NULL,NULL,NULL,NULL,17,193,'2023-06-25 11:49:52','2023-06-25 11:49:52',NULL,NULL,18),(18,NULL,NULL,NULL,NULL,17,195,'2023-06-25 11:49:52','2023-06-25 11:49:52',NULL,NULL,18),(19,NULL,NULL,NULL,NULL,22,193,'2023-06-28 23:05:10','2023-06-28 23:05:10',NULL,NULL,3);
/*!40000 ALTER TABLE `extras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `property_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorites_user_id_foreign` (`user_id`),
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (1,1,5,'2021-09-22 16:29:05','2021-09-22 16:29:05'),(2,1,6,'2021-09-29 19:21:26','2021-09-29 19:21:26'),(4,1,10,'2022-03-05 14:20:10','2022-03-05 14:20:10'),(6,1,11,'2023-01-11 15:50:19','2023-01-11 15:50:19'),(9,1,12,'2023-06-25 16:40:58','2023-06-25 16:40:58'),(10,1,13,'2023-06-25 16:41:01','2023-06-25 16:41:01'),(13,1,18,'2023-07-14 18:13:09','2023-07-14 18:13:09');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guest_users`
--

DROP TABLE IF EXISTS `guest_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guest_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mailing_list` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guest_users`
--

LOCK TABLES `guest_users` WRITE;
/*!40000 ALTER TABLE `guest_users` DISABLE KEYS */;
INSERT INTO `guest_users` VALUES (1,'Jacob','atam','jacob.atam@gmail.com','08023456789',1,1,NULL,'2021-10-14 20:28:14','2021-10-14 20:28:14'),(2,'Jacob','atam','jacob.atam@gmail.com','08023456789',1,1,NULL,'2022-03-07 11:43:34','2022-03-07 11:43:34'),(3,'jacob','atam','jacob.atam@gmail.com','3',1,1,NULL,'2022-08-03 20:09:10','2022-08-03 20:09:10'),(4,'jacob','atam','jacob.atam@gmail.com','08062284410',1,1,NULL,'2023-01-09 13:26:42','2023-01-09 13:26:42'),(5,'jacob','atam','jacob.atam@gmail.com','08062284410',1,1,NULL,'2023-01-11 19:51:47','2023-01-11 19:51:47'),(6,'jacob','atam','jacob.atam@gmail.com','08062284410',1,1,NULL,'2023-01-11 20:47:55','2023-01-11 20:47:55'),(7,'jacob','atam','jacob.atam@gmail.com','08062284410',1,1,NULL,'2023-01-11 20:48:10','2023-01-11 20:48:10'),(8,'jacob','atam','jacob.atam@gmail.com','08062284410',1,1,NULL,'2023-01-11 20:50:07','2023-01-11 20:50:07'),(9,'ewe','wewe','23@dsd.com','2323',1,1,NULL,'2023-06-16 03:41:59','2023-06-16 03:41:59'),(10,'ewe','wewe','jacob.atam@gmail.com','2323',1,1,NULL,'2023-06-19 04:39:27','2023-06-19 04:39:27'),(11,'df','df','info@enkoded.com','433343',1,1,NULL,'2023-06-25 01:59:29','2023-06-25 01:59:29'),(12,'df','df','info@enkoded.com','433343',1,1,NULL,'2023-06-25 02:13:38','2023-06-25 02:13:38'),(13,'df','ew','info@enkoded.com','433343',1,1,NULL,'2023-06-25 02:17:00','2023-06-25 02:17:00'),(14,'we','we','jacob.atam@gmail.com','433343',1,1,NULL,'2023-06-25 02:23:15','2023-06-25 02:23:15'),(15,'df','ew','jacob.atam@gmail.com','232332',1,1,NULL,'2023-06-25 02:32:04','2023-06-25 02:32:04'),(16,'df','ew','seth.atam@gmail.com','433343',1,1,NULL,'2023-06-25 02:43:20','2023-06-25 02:43:20'),(17,'df','ew','jacob.atam@gmail.com','433343',1,1,NULL,'2023-06-25 11:49:52','2023-06-25 11:49:52'),(18,'we','ew','jacob.atam@gmail.com','433343',1,1,NULL,'2023-06-25 12:11:09','2023-06-25 12:11:09'),(19,'df','ew','jacob.atam@gmail.com','433343',1,1,NULL,'2023-06-26 10:59:51','2023-06-26 10:59:51'),(20,'df','ew','jacob.atam@gmail.com','433343',1,1,NULL,'2023-06-26 11:29:59','2023-06-26 11:29:59'),(21,'df','ew','jacob.atam@gmail.com','433343',1,1,NULL,'2023-06-28 22:39:16','2023-06-28 22:39:16'),(22,'Tosin','Oluwa','oluwatosin.ayodele@globatos.ng','9042382206',1,1,NULL,'2023-06-28 23:05:10','2023-06-28 23:05:10');
/*!40000 ALTER TABLE `guest_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_id` bigint unsigned NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_id` int NOT NULL,
  `x_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `y_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_image_type_image_id_index` (`image_type`,`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'',0,NULL,'2021-06-06 22:14:34','2021-06-06 22:14:34','https://myshortlet.com/images/apartments/5kbEVLKkFwgqDrwWag8plx9WaKycIEfTlIXXhNuJ.jpg','App\\Models\\Room',1,NULL,NULL,NULL),(2,'',0,NULL,'2021-06-06 22:14:34','2021-06-06 22:14:34','https://myshortlet.com/images/apartments/QH3ms4bLtBdq2O305A3HQqRsmY5tnHTSnC4T8huz.jpg','App\\Models\\Room',1,NULL,NULL,NULL),(3,'',0,NULL,'2021-06-06 22:14:34','2021-06-06 22:14:34','https://myshortlet.com/images/apartments/ufVHxYKIIJiD1BomFyvDlX5pdLG18gM7wfHMRBNr.jpg','App\\Models\\Room',1,NULL,NULL,NULL),(4,'',0,NULL,'2021-06-07 20:36:34','2021-06-07 20:36:34','https://myshortlet.com/images/apartments/UImLJWUkjxVo6ZL55iuxHv9GjfiMzgqxoLdEYrOy.jpg','App\\Models\\Room',2,NULL,NULL,NULL),(5,'',0,NULL,'2021-06-07 20:36:34','2021-06-07 20:36:34','https://myshortlet.com/images/apartments/gWWdHDfALvh594oVQOFH9EB34tyErwTwUJCXTYHu.jpg','App\\Models\\Room',2,NULL,NULL,NULL),(6,'',0,NULL,'2021-06-07 20:36:34','2021-06-07 20:36:34','https://myshortlet.com/images/apartments/24zdxxDuIZhuRVpHjJiloH2HE978utnlzZJsSW8d.jpg','App\\Models\\Room',2,NULL,NULL,NULL),(7,'',0,NULL,'2021-06-07 20:36:34','2021-06-07 20:36:34','https://myshortlet.com/images/apartments/RhJnal1MNJzhRtP7PPTbfqwpGDn5whvvNc1DmRfs.jpg','App\\Models\\Room',2,NULL,NULL,NULL),(8,'',0,NULL,'2021-06-07 20:36:35','2021-06-07 20:36:35','https://myshortlet.com/images/apartments/zdsO52PQL8lRoNrg0fXD8e9Yk0Mwr529DkJb8oVL.jpg','App\\Models\\Room',2,NULL,NULL,NULL),(9,'',0,NULL,'2021-06-16 03:56:25','2021-06-16 03:56:25','https://myshortlet.com/images/apartments/Ndpf5uFdLkKmFN1cchw6EzD9sQnhmFmRoDV4FR57.jpg','App\\Models\\Room',3,NULL,NULL,NULL),(10,'',0,NULL,'2021-06-16 03:56:25','2021-06-16 03:56:25','https://myshortlet.com/images/apartments/xlajmbZ1cdqB5kDgkvCD5JkJk6v6hSGDTubcH9Km.jpg','App\\Models\\Room',3,NULL,NULL,NULL),(11,'',0,NULL,'2021-06-16 03:56:25','2021-06-16 03:56:25','https://myshortlet.com/images/apartments/pCnqRnplGmI5hHQqQFXstukayocoSHfyKtMDMKO4.jpg','App\\Models\\Room',3,NULL,NULL,NULL),(12,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/sl9Vx8wcLbpYC3nUjiO4KowCiQRjtA15LkNaW4oq.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(13,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/YNse9VlKOowxPeN6yTtN0E99Cljq8uvVi7wCYEE3.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(14,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/8G3secNr3SyTUbiPlk6TMnFEiWDyKEfZbBabuVp2.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(15,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/PvaX9g5FJC1e5W5vs1rKwD0KZPn4RPGPXDNudmGz.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(16,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/0uIuds2hvRQWDhsaqMAWh3SJu1qIQoluljU3XsXY.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(17,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/dxgUvSe4dPaTAGdcJC73zr8kqkUZIQxwPm3ktIgp.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(18,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/GiafX6wSxPUCNZYY1Gn244inCEodyWcGmmIZO6w3.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(19,'',0,NULL,'2021-09-19 17:11:12','2021-09-19 17:11:12','https://myshortlet.com/images/apartments/WE9j3mUYFwn23L5uJoqX2Q3EQzklnls90ygU5aIF.jpg','App\\Models\\Apartment',4,NULL,NULL,NULL),(20,'',0,NULL,'2021-09-29 19:20:25','2021-09-29 19:20:25','https://myshortlet.com/images/apartments/tT7RC9llMTdTulIJ9gFhpdxpWJ7J7pKSGQYTPpmc.jpg','App\\Models\\Apartment',5,NULL,NULL,NULL),(21,'',0,NULL,'2021-09-29 19:20:25','2021-09-29 19:20:25','https://myshortlet.com/images/apartments/lNtXCAErEv5loxk1Tv0OqjdqOri0rIHG3SkrLELS.jpg','App\\Models\\Apartment',5,NULL,NULL,NULL),(22,'',0,NULL,'2021-09-29 19:20:25','2021-09-29 19:20:25','https://myshortlet.com/images/apartments/RKN3oZhsxEv9aseCkoNjg8ohYws98WrXnQ8B102K.jpg','App\\Models\\Apartment',5,NULL,NULL,NULL),(23,'',0,NULL,'2021-09-29 19:20:25','2021-09-29 19:20:25','https://myshortlet.com/images/apartments/8oPWsX6AwGGGpVXxMEICDCq5pXJDaLl1iw2eaf3c.jpg','App\\Models\\Apartment',5,NULL,NULL,NULL),(24,'',0,NULL,'2021-09-29 19:20:25','2021-09-29 19:20:25','https://myshortlet.com/images/apartments/M2NVPPaGNQcRs6aqd9SRfZHu4PlGAgKlHBpYt0uQ.jpg','App\\Models\\Apartment',5,NULL,NULL,NULL),(25,'',0,NULL,'2021-09-29 19:20:25','2021-09-29 19:20:25','https://myshortlet.com/images/apartments/0YHkTBVzykPwTp49pXJjyXZJMqGDIcEaujvO85vj.jpg','App\\Models\\Apartment',5,NULL,NULL,NULL),(26,'',0,NULL,'2021-09-29 19:33:29','2021-09-29 19:33:29','https://myshortlet.com/images/apartments/R0aW9BoHH4JiSIOQIv8w7cN8lkTA9uEfO3Xjt7Dw.jpg','App\\Models\\Apartment',6,NULL,NULL,NULL),(27,'',0,NULL,'2021-09-29 19:33:29','2021-09-29 19:33:29','https://myshortlet.com/images/apartments/0kG7ui9t15w0YowCTgFCkVX3M6lKTN8OmxUvd4mS.jpg','App\\Models\\Apartment',6,NULL,NULL,NULL),(28,'',0,NULL,'2021-09-29 19:33:29','2021-09-29 19:33:29','https://myshortlet.com/images/apartments/bxzrzM3jjyVhavQ6JO008jyvb4voCvqsj62qRsSa.jpg','App\\Models\\Apartment',6,NULL,NULL,NULL),(29,'',0,NULL,'2021-09-29 19:33:29','2021-09-29 19:33:29','https://myshortlet.com/images/apartments/LIOgtCyPjG4s3B3abX0DajEfmRvjcvzmVOUIsc3k.jpg','App\\Models\\Apartment',6,NULL,NULL,NULL),(30,'',0,NULL,'2021-09-29 19:33:29','2021-09-29 19:33:29','https://myshortlet.com/images/apartments/62Os81TpOxLTzRiGoBo9z08j842zR4KjYecQ1GCp.jpg','App\\Models\\Apartment',6,NULL,NULL,NULL),(31,'',0,NULL,'2021-10-07 18:17:47','2021-10-07 18:17:47','https://myshortlet.com/images/apartments/0Zpbw1AkLo6yAGpEEsvcETEJlofosL9xg5TiupTO.jpg','App\\Models\\Apartment',7,NULL,NULL,8),(32,'',0,NULL,'2021-10-07 18:17:47','2021-10-07 18:17:47','https://myshortlet.com/images/apartments/jUuJK51C1AjUZaKl7xW8oWMqoERzVcrP43kLRTUj.jpg','App\\Models\\Apartment',7,NULL,NULL,8),(33,'',0,NULL,'2021-10-07 18:17:47','2021-10-07 18:17:47','https://myshortlet.com/images/apartments/cdFlILmxWHPD9Fv0xhlllFPuVWGF8rLrb0ujBRAN.jpg','App\\Models\\Apartment',7,NULL,NULL,8),(34,'',0,NULL,'2021-10-07 18:17:47','2021-10-07 18:17:47','https://myshortlet.com/images/apartments/nc0ljq1PmWnt7xKth95D5LtEtWJLkAcjuQEQGN3g.jpg','App\\Models\\Apartment',7,NULL,NULL,8),(35,'',0,NULL,'2021-10-07 18:17:47','2021-10-07 18:17:47','https://myshortlet.com/images/apartments/p87BAHzjX2C7OGxUp4gXV1VTJMZ89asbriD9rte3.jpg','App\\Models\\Apartment',7,NULL,NULL,8),(36,'',0,NULL,'2021-10-07 18:24:02','2021-10-07 18:24:02','https://myshortlet.com/images/apartments/M2AHEGqJLKDdVvmgvomu1IMtb54kVJ2Vaei2W1JI.jpg','App\\Models\\Apartment',8,NULL,NULL,9),(37,'',0,NULL,'2021-10-07 18:24:02','2021-10-07 18:24:02','https://myshortlet.com/images/apartments/M9Jfqkjnebt8taLjrgGXnOwVYbeX2lWrH8NhTNwE.jpg','App\\Models\\Apartment',8,NULL,NULL,9),(38,'',0,NULL,'2021-10-07 18:24:02','2021-10-07 18:24:02','https://myshortlet.com/images/apartments/cv0N2DUPUg1WWTcrvd7ZlpOVGZv8nIVC5X4yfMqb.jpg','App\\Models\\Apartment',8,NULL,NULL,9),(39,'',0,NULL,'2021-10-07 18:24:02','2021-10-07 18:24:02','https://myshortlet.com/images/apartments/w1WkoxBkkXIkr3OhBRZQQQz66fEeGchZfs88PZQO.jpg','App\\Models\\Apartment',8,NULL,NULL,9),(40,'',0,NULL,'2021-10-07 18:24:02','2021-10-07 18:24:02','https://myshortlet.com/images/apartments/r4B3FOvEyjbRe1BRhclikWzxanZBg200bmIbahJU.jpg','App\\Models\\Apartment',8,NULL,NULL,9),(41,'',0,NULL,'2021-10-14 20:26:38','2021-10-14 20:26:38','https://myshortlet.com/images/apartments/lDSNRU1L6CmHLE0VxiukyxAzp3LEwQDcrEWU7ABS.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(42,'',0,NULL,'2021-10-14 20:26:38','2021-10-14 20:26:38','https://myshortlet.com/images/apartments/0iNAelDmLB01R0KYDjin8ZzvGPlLODS4ob3TRqV5.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(43,'',0,NULL,'2021-10-14 20:26:38','2021-10-14 20:26:38','https://myshortlet.com/images/apartments/YBQVoRC2QyX3bli8jOSu41NnACKIekFLjvrg6MN3.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(44,'',0,NULL,'2021-10-14 20:26:38','2021-10-14 20:26:38','https://myshortlet.com/images/apartments/zzp0WfvMFXUZTq9NKxiYsq0Rx4piuSPWlBKOklZT.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(45,'',0,NULL,'2021-10-14 20:26:38','2021-10-14 20:26:38','https://myshortlet.com/images/apartments/DhQ3NHepZbNC33Vn39DZ7ftXCXRwprCZFpTi3nPy.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(46,'',0,NULL,'2022-03-05 13:18:00','2022-03-05 13:18:00','https://myshortlet.com/images/apartments/njGiyV67fd2UVeowvZ3ApJzLRSDgvfk1pwdy20cs.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(47,'',0,NULL,'2022-03-05 13:18:00','2022-03-05 13:18:00','https://myshortlet.com/images/apartments/Bpylio6aroHfd1sjmZZg2YHTjwtjDNxn18ATNOIx.jpg','App\\Models\\Apartment',9,NULL,NULL,10),(48,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/JwdHkNxEGBlA4N7ofQYmwBpY1uAETtK48kOqhReR.jpg','App\\Models\\Apartment',10,NULL,NULL,NULL),(49,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/ftO7pKpIsGW8Cb1uhjS4uaUfTwFpYtHvY1Hho9n8.jpg','App\\Models\\Apartment',10,NULL,NULL,NULL),(50,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/d955FuwWEvMd1kkQzzR5k4tzJ0eVShVQSRRb4cR1.jpg','App\\Models\\Apartment',10,NULL,NULL,NULL),(51,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/zbakxQ5RCgGZh37jGx3y37SuTycvHebYRX4NuopZ.jpg','App\\Models\\Apartment',10,NULL,NULL,NULL),(52,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/7UF0ZireRkthVgQ1nPXZTtztrH47wLqa3NTrWRWc.jpg','App\\Models\\Apartment',10,NULL,NULL,NULL),(53,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/jnIiUGnlwZhGzGJ1HAgbIqxQUQL781TCDgdVjLaX.jpg','App\\Models\\Apartment',10,NULL,NULL,NULL),(54,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/JwdHkNxEGBlA4N7ofQYmwBpY1uAETtK48kOqhReR.jpg','App\\Models\\Property',11,NULL,NULL,NULL),(55,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/ftO7pKpIsGW8Cb1uhjS4uaUfTwFpYtHvY1Hho9n8.jpg','App\\Models\\Property',11,NULL,NULL,NULL),(56,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/d955FuwWEvMd1kkQzzR5k4tzJ0eVShVQSRRb4cR1.jpg','App\\Models\\Property',11,NULL,NULL,NULL),(57,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/zbakxQ5RCgGZh37jGx3y37SuTycvHebYRX4NuopZ.jpg','App\\Models\\Property',11,NULL,NULL,NULL),(58,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/7UF0ZireRkthVgQ1nPXZTtztrH47wLqa3NTrWRWc.jpg','App\\Models\\Property',11,NULL,NULL,NULL),(59,'',0,NULL,'2022-03-05 20:11:58','2022-03-05 20:11:58','https://myshortlet.com/images/apartments/jnIiUGnlwZhGzGJ1HAgbIqxQUQL781TCDgdVjLaX.jpg','App\\Models\\Property',11,NULL,NULL,NULL),(60,'',0,NULL,'2023-01-11 15:22:06','2023-01-11 15:22:06','https://myshortlet.xyz/images/apartments/JXqTggyz41nHbBuWycGLF0JuDSsQr8iAdiIBLsFP.jpg','App\\Models\\Apartment',11,NULL,NULL,NULL),(61,'',0,NULL,'2023-01-11 15:22:06','2023-01-11 15:22:06','https://myshortlet.xyz/images/apartments/hOw6X4sEbicplggcWe2B7QtQ9wSuH2BinqCm9CCi.jpg','App\\Models\\Apartment',11,NULL,NULL,NULL),(62,'',0,NULL,'2023-01-11 15:22:06','2023-01-11 15:22:06','https://myshortlet.xyz/images/apartments/pTGfnwPGFikWglk0Xuz4KL5lspcub83tyeBK0SRZ.jpg','App\\Models\\Apartment',11,NULL,NULL,NULL),(63,'',0,NULL,'2023-01-11 15:22:06','2023-01-11 15:22:06','https://myshortlet.xyz/images/apartments/JXqTggyz41nHbBuWycGLF0JuDSsQr8iAdiIBLsFP.jpg','App\\Models\\Property',12,NULL,NULL,NULL),(64,'',0,NULL,'2023-01-11 15:22:06','2023-01-11 15:22:06','https://myshortlet.xyz/images/apartments/hOw6X4sEbicplggcWe2B7QtQ9wSuH2BinqCm9CCi.jpg','App\\Models\\Property',12,NULL,NULL,NULL),(65,'',0,NULL,'2023-01-11 15:22:06','2023-01-11 15:22:06','https://myshortlet.xyz/images/apartments/pTGfnwPGFikWglk0Xuz4KL5lspcub83tyeBK0SRZ.jpg','App\\Models\\Property',12,NULL,NULL,NULL),(67,'',0,NULL,'2023-01-11 16:35:20','2023-01-11 16:35:20','https://myshortlet.xyz/images/apartments/cPYrZsEenTszJSNcSrLgwEFkmBWs9sznylwBKImJ.png','App\\Models\\Apartment',10,NULL,NULL,11),(73,'',0,NULL,'2023-01-11 16:48:16','2023-01-11 16:48:16','https://myshortlet.xyz/images/apartments/j16B1a5h6M5rrVoo0XKajHLQx34RqTjrQRARhu0p.png','App\\Models\\Apartment',11,NULL,NULL,12),(74,'',0,NULL,'2023-01-11 16:48:16','2023-01-11 16:48:16','https://myshortlet.xyz/images/apartments/aOjQ0lN9Uz5rdE9L78P3RKa6kvEtM0RJXePgAUkZ.jpg','App\\Models\\Apartment',11,NULL,NULL,12),(75,'',0,NULL,'2023-01-11 16:48:16','2023-01-11 16:48:16','https://myshortlet.xyz/images/apartments/WYPlCDzX5s5hmfaml4WcpXnW9yAIaBSkaLpywG3c.png','App\\Models\\Apartment',11,NULL,NULL,12),(76,'',0,NULL,'2023-01-11 16:48:16','2023-01-11 16:48:16','https://myshortlet.xyz/images/apartments/kFYTMFMPOSKmZGLnsMZ9vOCFxgUTL4PbF2erQtxQ.png','App\\Models\\Apartment',11,NULL,NULL,12),(77,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/YEOiXET6u1SJg0QimCDQz4WOw5SD2TW7QoGYMTOo.png','App\\Models\\Apartment',10,NULL,NULL,11),(78,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/HY0HmMA5TmJfcBalLB4wbXAIjFLVtFWRSeDM2v7x.png','App\\Models\\Apartment',10,NULL,NULL,11),(79,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/AxQ69VuVuFg6v42PO2pCRoDRnBtQdan8OSkcAQOH.jpg','App\\Models\\Apartment',10,NULL,NULL,11),(80,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/f9EoQEuqrTZVd9iQnhsEcNATMNgowOGmZ9wte572.png','App\\Models\\Apartment',10,NULL,NULL,11),(81,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/G9zNJlrha11sRQLpPj4gjo8Vd3txGya1nvYeZUaW.png','App\\Models\\Apartment',10,NULL,NULL,11),(82,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/j8FQlmxubGs7ulpLucrecHGj8O0OdibTSvEewOqU.png','App\\Models\\Apartment',10,NULL,NULL,11),(83,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/XEewQ5Ppxx3zQopxrFdErwEfZqnCV8voQsjKnhWm.png','App\\Models\\Apartment',10,NULL,NULL,11),(84,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/Cnd7biLiNVT3ECWPEteCSECBnGcdNkzZtS7EOoxG.png','App\\Models\\Apartment',10,NULL,NULL,11),(85,'',0,NULL,'2023-01-11 16:50:02','2023-01-11 16:50:02','https://myshortlet.xyz/images/apartments/YIYjaqQLX6aOkCOnOvpQbQRoiuUcTFi5oyKADwEZ.png','App\\Models\\Apartment',10,NULL,NULL,11),(86,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/DcdzDEW5GsCheaUnFa4nGuJXSqAmZM9jwSB3rvRz.jpg','App\\Models\\Apartment',12,NULL,NULL,NULL),(94,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/DcdzDEW5GsCheaUnFa4nGuJXSqAmZM9jwSB3rvRz.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(95,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/UM1UFOF8xqCsYKfH2QkcgtWArjL8toM2QQF9XmzT.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(96,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/8RKHfUlqEhRrouZn8yDLUac1N4LiUV6JekCbePNc.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(97,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/XZOrYPcAGFM0VNB4DX6qDcjOTJIqwu245ulEQNsj.png','App\\Models\\Property',13,NULL,NULL,NULL),(98,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/NgZZp0zkiGE1kptK3FvYPMFhnHoQfcemnEJrFZW6.png','App\\Models\\Property',13,NULL,NULL,NULL),(99,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/AWgjsxnEdpuuhXShoFmY4gmRitOlwVga6Bw1vqdh.png','App\\Models\\Property',13,NULL,NULL,NULL),(100,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/Pwn7qhHRY9zplxUfxjOCJ4QZr1rc2Fsw3aQRQb52.png','App\\Models\\Property',13,NULL,NULL,NULL),(101,'',0,NULL,'2023-01-11 17:01:37','2023-01-11 17:01:37','https://myshortlet.xyz/images/apartments/MO967dNvGMaCzay40CYUatMKc4jKjVLqtX05fGTw.png','App\\Models\\Property',13,NULL,NULL,NULL),(102,'',0,NULL,'2023-06-25 01:28:59','2023-06-25 01:28:59','https://avenuemontaigne.ng/images/apartments/xqsYjuTvPZTxdYANEZ1CXGXf6acK6dABldlSqTU8.jpg','App\\Models\\Apartment',12,NULL,NULL,13),(103,'',0,NULL,'2023-06-25 01:28:59','2023-06-25 01:28:59','https://avenuemontaigne.ng/images/apartments/yR0iG55f7csIXoBiPWRxzZZsYXZPubWBwkWXzqL4.jpg','App\\Models\\Apartment',12,NULL,NULL,13),(104,'',0,NULL,'2023-06-25 01:28:59','2023-06-25 01:28:59','https://avenuemontaigne.ng/images/apartments/UEx6h2ViDUu3WMALwNDl4lWZHEYrmVfPXcBF73yb.jpg','App\\Models\\Apartment',12,NULL,NULL,13),(105,'',0,NULL,'2023-06-25 01:28:59','2023-06-25 01:28:59','https://avenuemontaigne.ng/images/apartments/tsHKaL449pdrncouxK0LruY7vtxmDk2rfvshpReM.jpg','App\\Models\\Apartment',12,NULL,NULL,13),(106,'',0,NULL,'2023-06-25 01:28:59','2023-06-25 01:28:59','https://avenuemontaigne.ng/images/apartments/UxZooskD8dsFTE0Y5WElzeR56P5C1LZWMumeHTNf.jpg','App\\Models\\Apartment',12,NULL,NULL,13),(107,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/DWgoAH3SL5vs0kexpseH79wDSsEhJjvJuLyQ01U4.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(108,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/rrBKQAozsnVJHMeFLf451ihrBmEcL9lQX79r9eDG.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(109,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/GOOO0IhwaLBApbGQ9JMcdXl5BQy394DhtjYoCDx1.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(110,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/vSKQnlcqx5KU6EsGVHuoNYUr0dTDY4X6boo1ZzLw.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(111,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/vOtDCiYY4ayMkDhuQ7Vx0ACFDUu2ytdeKzqmoChK.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(112,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/DkKlv59ifC53LqP04B3K9AkRL0gYJZtsF3Li0Qxp.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(113,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/ja2NrixCH4th2MbFFY3pBKCCAMuBrLQq3EIKeifl.jpg','App\\Models\\Apartment',13,NULL,NULL,NULL),(114,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/DWgoAH3SL5vs0kexpseH79wDSsEhJjvJuLyQ01U4.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(115,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/rrBKQAozsnVJHMeFLf451ihrBmEcL9lQX79r9eDG.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(116,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/GOOO0IhwaLBApbGQ9JMcdXl5BQy394DhtjYoCDx1.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(117,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/vSKQnlcqx5KU6EsGVHuoNYUr0dTDY4X6boo1ZzLw.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(118,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/vOtDCiYY4ayMkDhuQ7Vx0ACFDUu2ytdeKzqmoChK.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(119,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/DkKlv59ifC53LqP04B3K9AkRL0gYJZtsF3Li0Qxp.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(120,'',0,NULL,'2023-07-14 10:32:32','2023-07-14 10:32:32','https://avenuemontaigne.ng/images/apartments/ja2NrixCH4th2MbFFY3pBKCCAMuBrLQq3EIKeifl.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(121,'',0,NULL,'2023-07-14 10:35:38','2023-07-14 10:35:38','https://avenuemontaigne.ng/images/apartments/RwPetMT2JMVvZ304dCRjuAsZqrAn9MMTQIsytKlT.jpg','App\\Models\\Apartment',14,NULL,NULL,NULL),(122,'',0,NULL,'2023-07-14 10:35:38','2023-07-14 10:35:38','https://avenuemontaigne.ng/images/apartments/RwPetMT2JMVvZ304dCRjuAsZqrAn9MMTQIsytKlT.jpg','App\\Models\\Property',13,NULL,NULL,NULL),(123,'',0,NULL,'2023-07-14 11:22:17','2023-07-14 11:22:17','https://avenuemontaigne.ng/images/apartments/YLS7xQsIrL1UJGz1kuGk3K7nuhV9Rm6NeevVzcNA.jpg','App\\Models\\Apartment',15,NULL,NULL,NULL),(124,'',0,NULL,'2023-07-14 11:22:17','2023-07-14 11:22:17','https://avenuemontaigne.ng/images/apartments/YLS7xQsIrL1UJGz1kuGk3K7nuhV9Rm6NeevVzcNA.jpg','App\\Models\\Property',14,NULL,NULL,NULL),(125,'',0,NULL,'2023-07-14 11:27:04','2023-07-14 11:27:04','https://avenuemontaigne.ng/images/apartments/YLS7xQsIrL1UJGz1kuGk3K7nuhV9Rm6NeevVzcNA.jpg','App\\Models\\Apartment',16,NULL,NULL,NULL),(126,'',0,NULL,'2023-07-14 11:27:04','2023-07-14 11:27:04','https://avenuemontaigne.ng/images/apartments/YLS7xQsIrL1UJGz1kuGk3K7nuhV9Rm6NeevVzcNA.jpg','App\\Models\\Property',15,NULL,NULL,NULL),(127,'',0,NULL,'2023-07-14 13:23:40','2023-07-14 13:23:40','https://avenuemontaigne.ng/images/apartments/ZjKW5AivxMkAetvmMwJtF56Yr1Obv4g7Kwyg1w78.jpg','App\\Models\\Apartment',17,NULL,NULL,NULL),(128,'',0,NULL,'2023-07-14 13:23:40','2023-07-14 13:23:40','https://avenuemontaigne.ng/images/apartments/ZjKW5AivxMkAetvmMwJtF56Yr1Obv4g7Kwyg1w78.jpg','App\\Models\\Property',16,NULL,NULL,NULL),(129,'',0,NULL,'2023-07-14 13:29:41','2023-07-14 13:29:41','https://avenuemontaigne.ng/images/apartments/ZjKW5AivxMkAetvmMwJtF56Yr1Obv4g7Kwyg1w78.jpg','App\\Models\\Apartment',18,NULL,NULL,NULL),(130,'',0,NULL,'2023-07-14 13:29:41','2023-07-14 13:29:41','https://avenuemontaigne.ng/images/apartments/ZjKW5AivxMkAetvmMwJtF56Yr1Obv4g7Kwyg1w78.jpg','App\\Models\\Property',17,NULL,NULL,NULL),(131,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/rowxrRolpBuWQbRx78RMjvRQsVgy5KHPAgXCLUtQ.jpg','App\\Models\\Apartment',19,NULL,NULL,NULL),(132,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/zpusvKEteoq6bcD8d83WqAIZj5FXwH4lIon3NGDD.jpg','App\\Models\\Apartment',19,NULL,NULL,NULL),(133,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/8GZWajlamjHNwMGd1DwCODMkQiOJfPno4R6xyNLM.jpg','App\\Models\\Apartment',19,NULL,NULL,NULL),(134,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/NWmctZnlZmMSlH5z0uv8Z2H3QW6CPJ8ogRpzU2nB.jpg','App\\Models\\Apartment',19,NULL,NULL,NULL),(135,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/1Lyt6IbWyMygzynXmbpmtuQD739hh6GpSDDRKOxf.jpg','App\\Models\\Apartment',19,NULL,NULL,NULL),(136,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/rowxrRolpBuWQbRx78RMjvRQsVgy5KHPAgXCLUtQ.jpg','App\\Models\\Property',18,NULL,NULL,NULL),(137,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/zpusvKEteoq6bcD8d83WqAIZj5FXwH4lIon3NGDD.jpg','App\\Models\\Property',18,NULL,NULL,NULL),(138,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/8GZWajlamjHNwMGd1DwCODMkQiOJfPno4R6xyNLM.jpg','App\\Models\\Property',18,NULL,NULL,NULL),(139,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/NWmctZnlZmMSlH5z0uv8Z2H3QW6CPJ8ogRpzU2nB.jpg','App\\Models\\Property',18,NULL,NULL,NULL),(140,'',0,NULL,'2023-07-14 17:17:56','2023-07-14 17:17:56','https://avenuemontaigne.ng/images/apartments/1Lyt6IbWyMygzynXmbpmtuQD739hh6GpSDDRKOxf.jpg','App\\Models\\Property',18,NULL,NULL,NULL),(141,'',0,NULL,'2023-07-14 17:49:28','2023-07-14 17:49:28','https://avenuemontaigne.ng/images/apartments/1xnT4j3BBGXsPSpf8ccnrab9arb2azHrJZkXHc5s.jpg','App\\Models\\Apartment',20,NULL,NULL,NULL),(142,'',0,NULL,'2023-07-14 17:49:28','2023-07-14 17:49:28','https://avenuemontaigne.ng/images/apartments/1xnT4j3BBGXsPSpf8ccnrab9arb2azHrJZkXHc5s.jpg','App\\Models\\Property',18,NULL,NULL,NULL);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `information` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  `custom_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `same_page` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `y_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teaser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `information_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `information`
--

LOCK TABLES `information` WRITE;
/*!40000 ALTER TABLE `information` DISABLE KEYS */;
INSERT INTO `information` VALUES (1,'Company','company',NULL,'2021-10-07 15:15:20','2021-10-07 15:15:20',NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL),(2,'Explore','explore',NULL,'2021-10-07 15:15:38','2021-10-07 15:15:38',NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL),(3,'Terms and Policies','terms-and-policies',NULL,'2021-10-07 15:15:59','2021-10-07 15:15:59',NULL,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL),(4,'About','about',NULL,'2021-10-07 15:17:49','2021-10-07 15:17:49',1,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lives`
--

DROP TABLE IF EXISTS `lives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lives` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `make_live` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lives`
--

LOCK TABLES `lives` WRITE;
/*!40000 ALTER TABLE `lives` DISABLE KEYS */;
INSERT INTO `lives` VALUES (1,0);
/*!40000 ALTER TABLE `lives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location_property`
--

DROP TABLE IF EXISTS `location_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location_property` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `property_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `location_property_property_id_foreign` (`property_id`),
  CONSTRAINT `location_property_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location_property`
--

LOCK TABLES `location_property` WRITE;
/*!40000 ALTER TABLE `location_property` DISABLE KEYS */;
INSERT INTO `location_property` VALUES (55,18,1,NULL,NULL,NULL),(56,18,2,NULL,NULL,NULL),(57,18,3,NULL,NULL,NULL),(58,18,7,NULL,NULL,NULL);
/*!40000 ALTER TABLE `location_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locations_parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Nigeria',NULL,'2021-06-06 21:14:38','2021-06-06 21:14:38','Located just 5 minutes’ walk from Greenwich Train Station, Staycity Aparthotels Greenwich High Road offer modern apartments with onsite parking and free Wi-Fi. London Bridge can be reached via train in just 8 minutes’ from Greenwich Station.\r\n\r\nEach Stayc','nigeria','https://myshortlet.com/images/locations/Gbmnuq2JsfH1Sks01qShy9WjgyKxqKv4pFRcn457.jpg','country',NULL),(2,'Lagos',1,'2021-06-06 21:20:26','2021-09-24 10:02:49','Located just 5 minutes’ walk from Greenwich Train Station, Staycity Aparthotels Greenwich High Road offer modern apartments with onsite parking and free Wi-Fi. London Bridge can be reached via train in just 8 minutes’ from Greenwich Station.\r\n\r\nEach Stayc','nigeria-lagos','https://myshortlet.com/images/locations/VjZ0qeMFmuxDwyDazIakkSaGFW2EJqiIuvQLMpDi.jpg','state',NULL),(3,'Ikeja',2,'2021-06-06 21:24:59','2021-06-06 21:24:59',NULL,'nigeria-lagos-ikeja','https://myshortlet.com/images/locations/ZMT2wnUmjCJttNji8ahY8q8pXJvI95nzPsiqD2CM.jpg','city',NULL),(4,'Opebi',3,'2021-06-06 21:25:43','2021-06-06 21:25:43',NULL,'nigeria-ikeja-opebi','https://myshortlet.com/images/locations/nfWTS53DliHPrw2lDTGC7nFqZ5u6T0yZn5iIdtWR.jpg','street',NULL),(5,'Abuja',1,'2021-09-23 08:31:06','2021-09-24 10:03:50',NULL,'nigeria-abuja','https://myshortlet.com/images/locations/v1A47ALi5eP98ZqFSiKHFweqwIp5Dsx6c6cIV8zo.jpg','state',NULL),(6,'Port Harcourt',1,'2021-09-24 10:08:22','2021-09-24 10:08:22',NULL,'nigeria-port-harcourt','https://myshortlet.com/images/locations/dX2mJqMLKnssxujuqXSriNurG2EfFQrmbjrRSno9.jpg','state',NULL),(7,'Ikoyi',2,'2023-01-11 19:49:13','2023-01-11 19:49:13','Filled with opulent homes and luxury hotels, Ikoyi is centered on Awolowo Road, with its upscale boutiques and artisan bakeries. High-end Nigerian eateries serve dishes such as pepper soup, while resident celebrities frequent chic cocktail bars and clubs.','ikoyi-lagos-nigeria',NULL,'city','ikoyi, lagos, nigeria'),(8,'Victoria Island',2,'2023-01-11 19:49:36','2023-01-11 19:49:36','Filled with opulent homes and luxury hotels, Ikoyi is centered on Awolowo Road, with its upscale boutiques and artisan bakeries. High-end Nigerian eateries serve dishes such as pepper soup, while resident celebrities frequent chic cocktail bars and clubs.','victoria-island-lagos-nigeria',NULL,'city','victoria, island, lagos, nigeria');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_07_25_092156_create_permissions_table',1),(4,'2018_07_25_092427_create_user_permissions_table',1),(5,'2018_09_11_133801_create_categories_table',1),(6,'2018_09_11_225547_create_activities_table',1),(7,'2018_09_12_192027_create_system_settings_table',1),(8,'2018_09_12_193056_create_vouchers_table',1),(9,'2018_09_12_193846_create_user_socials_table',1),(10,'2018_09_12_205354_create_information_table',1),(11,'2018_09_12_205754_create_banners_table',1),(12,'2018_09_12_210052_create_lives_table',1),(13,'2018_09_12_210249_create_favorites_table',1),(14,'2018_09_13_124741_create_roles_table',1),(15,'2018_09_13_124801_create_user_roles_table',1),(16,'2018_10_05_134952_create_table_reviews',1),(17,'2018_10_31_092721_create_products_attributes_table',1),(18,'2019_02_07_180818_create_promo_texts_table',1),(19,'2019_02_07_182530_create_promos_table',1),(20,'2019_02_07_223815_alter_table_promos',1),(21,'2020_01_02_131345_create_images_table',1),(22,'2020_01_02_154657_aler_images_table__add_image',1),(23,'2020_01_02_160439_aler_images_table__imagable',1),(24,'2020_01_09_151348_alter_information_table__add_parent_id',1),(25,'2020_01_10_010527_alter_table_attributes_table_add_sort_order',1),(26,'2020_01_10_013106_alter_table_information_table_add_sort_order',1),(27,'2020_01_10_182507_create_locations_table',1),(28,'2020_01_12_042741_alter_table_banner__add_col_width',1),(29,'2020_01_13_105133_create_currencies_table',1),(30,'2020_02_02_200911_alter_users_table_add_type',1),(31,'2020_02_08_172230_alter_attributes_table_change_type',1),(32,'2020_02_15_093112_alter_settings_table__add_default_payment',1),(33,'2020_02_15_112041_create_currency_rates_table',1),(34,'2020_02_15_112957_alter_curencies_table',1),(35,'2020_02_16_032220_create_currency_rate_countries_table',1),(36,'2020_04_27_125847_alter_table_reviews__add_user_id',1),(37,'2020_04_30_160426_alter_information_table_add_custom_link',1),(38,'2020_05_03_145942_alter_information_table__add_image',1),(39,'2020_05_03_164453_alter_information_table__image',1),(40,'2020_05_04_200543_create_comments_table',1),(41,'2020_05_16_131622_alter_images_add_xypos',1),(42,'2020_05_16_183525_alter_information_table_add_images',1),(43,'2020_05_19_181232_alter_information_table_add_teaser',1),(44,'2020_05_19_182030_create_table_attribute_information',1),(45,'2020_05_19_192143_alter_attributes_table_add_hex_code_and_image',1),(46,'2020_05_20_150809_alter_reviews_table_add_image',1),(47,'2020_05_31_222621_alter_users_table_drop_unquie',1),(48,'2020_06_01_083316_alter_attributes_table_add_hexcode',1),(49,'2020_06_08_080406_alter_banners_table_make_tile_mull',1),(50,'2020_09_08_101830_alter_categories_table_add_banner_image',1),(51,'2020_10_07_164133_alter_settings_table_add_make_shipping_free',1),(52,'2020_10_21_100446_alter_system_settings_table_add_key',1),(53,'2020_12_13_093351_alter_attributes_table_add_slug',1),(54,'2021_01_16_215845_alter_banners_table_add_type',1),(55,'2021_01_17_002223_alter_banners_table_add_sm_col_width',1),(56,'2021_02_18_113220_create_apartments_table',2),(57,'2021_02_18_113855_create_requirements_table',3),(58,'2021_02_18_115738_create_facilities_table',3),(59,'2021_02_18_120108_create_rooms_table',3),(60,'2021_02_18_144458_create_services_table',3),(61,'2021_02_19_030127_alter_services_table_add_price_nullable',3),(62,'2021_02_20_225446_alter_apartments_table_add_slug',3),(63,'2021_02_20_225520_alter_rooms_table_add_slug',3),(64,'2021_02_21_120639_alter_rooms_table_change_price_to_bigint',3),(65,'2021_02_21_120827_alter_rooms_table_change_sale_price_to_bigint',3),(66,'2021_02_21_145812_alter_rooms_table_add_sale_price_expires',3),(67,'2021_02_26_111436_create_table_apartment_attribute',3),(68,'2021_02_26_115125_create_table_apartment_facility',3),(69,'2021_02_26_134839_create_table_attribute_room',3),(70,'2021_03_03_045828_alter_systen_settings_table_add_type',3),(71,'2021_03_03_112427_alter_table_rooms_add_sale_price_expires',3),(72,'2021_03_03_201425_alter_apartments_table_add_allow',3),(73,'2021_05_26_121743_create_table_location_reservation',3),(74,'2021_05_26_121833_alter_table_locations_add_image',3),(75,'2021_05_28_115512_alter_location_table_add_location_type',3),(76,'2021_05_28_152405_alter_table_apartments_add_featured',3),(77,'2021_05_31_163401_alter_apartments_table_add_user_id',3),(78,'2021_06_02_125800_alter_settings_table_add_allow_multi_currency',3),(79,'2021_06_02_181458_alter_rooms_table_change_reservation_id_to_apartment_id',4),(80,'2021_06_03_172426_alter_rooms_table_add_quantity',4),(81,'2021_06_03_172714_alter_system_settings_table_rename_system_settings',4),(82,'2021_06_03_174554_create_related_apartments_table',4),(83,'2021_06_07_155638_alter_table_rooms_add_max_adults',5),(84,'2021_06_11_231142_alter_attributes_table_add_description',6),(85,'2021_06_15_175252_alter_rooms_table_add_no_of_rooms',6),(86,'2021_06_16_045222_alter_rooms_table_add_to_available',7),(87,'2021_06_18_113414_alter_rooms_table_add_apartment_left',8),(88,'2021_06_18_114705_create_carts_table',8),(89,'2021_06_18_114758_create_orders_table',8),(90,'2021_06_18_122124_create_table_attribute_cart',8),(91,'2021_07_05_144627_alter_rooms_add_toilets',9),(92,'2021_07_09_142255_alter_table_apartments_add_status',9),(93,'2021_07_10_184828_create_room_children_attribtes_table',10),(94,'2021_07_10_211944_create_attribute_prices_table',10),(95,'2021_07_11_035542_alter_attribute_room_table_add_price',10),(96,'2021_07_12_163120_alter_rooms_table_make_name_null',10),(97,'2021_07_13_102658_alter_apartments_table_add_allow_cancellation',10),(98,'2021_07_14_114114_alter_apartments_table_add_is_not_admin',10),(99,'2021_07_14_194226_alter_apartments_table_add_unique_id',10),(100,'2021_07_15_043248_alter_orders_table_rename_to_reservations',10),(101,'2021_07_15_175441_alter_table_users_add_image',10),(102,'2021_08_26_185840_alter_rooms_table_add_type',10),(103,'2021_08_27_162454_alter_apartments_table_add_cancellation_fee',10),(104,'2021_09_04_115107_create_guest_users_table',10),(105,'2021_09_04_121104_alter_reservations_table_add_room_id',10),(106,'2021_09_05_005450_rename_table_apartments_to_properties',10),(107,'2021_09_05_011754_create_table_location_property',10),(108,'2021_09_05_012024_create_table_attribute_property',10),(109,'2021_09_05_013430_alter_table_reversations_add_property_id',10),(110,'2021_09_05_074448_reanme_colunm_apartment_id_to_property_id',10),(111,'2021_09_05_081230_drop_table_apartment_attribute',10),(112,'2021_09_05_081619_create_apartment_attribute_table',10),(113,'2021_09_05_163041_alter_apartments_table_add_is_available',10),(114,'2021_09_08_174622_later_reservations_table_add_apartment_id',11),(115,'2021_09_08_190302_create_user_reservations_table',11),(116,'2021_09_08_192019_alter_table_reservations_add_user_reservation_id',11),(117,'2021_09_10_020919_create_table_attribute_location',11),(118,'2021_09_12_111706_alter_properties_table_add_check_in_check_ot_time',11),(119,'2021_09_13_035409_alter_users_table_add_code',11),(120,'2021_09_18_043049_alter_attributes_table_add_user_id',11),(121,'2021_09_18_043321_create_table_attribute_category',11),(122,'2021_09_21_231422_alter_favorites_table_rename_column_product_id_to_property_id',12),(123,'2021_09_22_061042_alter_table_attributes_add_svg',12),(124,'2021_09_24_113649_alter_properties_table_add_location_full_name',13),(125,'2021_09_24_113716_alter_locations_table_add_location_full_name',13),(126,'2021_09_25_125414_alter_apartment_attribute_add_price',14),(127,'2021_09_27_164147_alter_attribute_property_table_add_price',15),(128,'2021_09_28_141210_alter_categories_table_rename_column_from_category_name',15),(129,'2021_09_28_141419_alter_categories_table_rename_column_add_sort_order',15),(130,'2021_09_29_113145_alter_apartment_attribute_add_bed_count',15),(131,'2021_09_29_222432_alter_properties_table_rename_allow_cancellation',16),(132,'2021_09_30_092615_alter_table_attribute_property_add_name',16),(133,'2021_09_30_145753_alter_images_table_add_property_id',16),(134,'2021_10_02_012749_create_apartment_stocks_table',17),(135,'2021_10_04_134149_alter_properties_table_add_price',17),(136,'2021_10_07_031907_create_booking_details_table',18),(137,'2021_10_10_195650_alter_booking_table_add_sale_price',19),(138,'2021_10_12_054233_create_extras_table',19),(139,'2021_10_13_155954_alter_reservation_table_add_price',19),(140,'2021_10_16_103808_alter_extras_table__add_reservation_id',20),(141,'2021_10_19_121014_alter_table_apartments_add_attributes',20),(142,'2021_10_22_160959_alter_apartments_table_add_size',20),(143,'2021_10_22_235838_alter_properties_table_add_is_shortle',20),(144,'2021_10_24_030347_create_table_category_property',20),(145,'2021_10_24_030413_create_table_category_location',20),(146,'2021_10_24_113815_alter_table_properties_add_size',20),(147,'2021_10_26_170903_alter_properties_table__add_mode',20),(148,'2021_10_27_142720_alter_properties_table__add_price_mode',20),(149,'2021_10_30_152044_alter_properties_table_make_price_nullable',20),(150,'2021_11_07_001154_alter_banners_table_add_description',20),(151,'2021_11_17_154557_alter_table_apartments_add_price_mode',20),(152,'2023_07_12_145507_create_table_property_user',21),(153,'2023_07_12_153659_create_sub_lets_table',21),(154,'2023_07_12_154948_create_table_apartment_user',21);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Admin','12345','2021-06-02 15:16:14','2021-06-02 15:16:14',NULL),(2,'Agent','234','2023-07-04 19:33:40','2023-07-10 21:16:58',NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_texts`
--

DROP TABLE IF EXISTS `promo_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promo_texts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `promo` text COLLATE utf8mb4_unicode_ci,
  `promo_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_texts`
--

LOCK TABLES `promo_texts` WRITE;
/*!40000 ALTER TABLE `promo_texts` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo_texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promos`
--

DROP TABLE IF EXISTS `promos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `background_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `make_live` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promos`
--

LOCK TABLES `promos` WRITE;
/*!40000 ALTER TABLE `promos` DISABLE KEYS */;
/*!40000 ALTER TABLE `promos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `properties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  `is_refundable` tinyint(1) NOT NULL DEFAULT '0',
  `cancellation_message` text COLLATE utf8mb4_unicode_ci,
  `is_not_admin` tinyint(1) NOT NULL DEFAULT '0',
  `token` bigint DEFAULT NULL,
  `virtual_tour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_fee` int DEFAULT NULL,
  `check_in_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  `is_shortlet` tinyint(1) NOT NULL DEFAULT '0',
  `is_price_negotiable` tinyint(1) NOT NULL DEFAULT '0',
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `bedrooms` int DEFAULT NULL,
  `toilets` int DEFAULT NULL,
  `is_land` tinyint(1) NOT NULL DEFAULT '0',
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

LOCK TABLES `properties` WRITE;
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
INSERT INTO `properties` VALUES (18,'Avenu montaigne','multiple','cooper road ikoyi','<p>dairodamilola@yahoo.com</p>',NULL,'2023-07-14 17:17:56','2023-07-14 17:49:28','avenu-montaigne-42210936','https://avenuemontaigne.ng/images/apartments/zjtFBlO7F940al3AeLMIRgE0zNGbgecUIDjRHSAn.jpg',1,1,NULL,NULL,NULL,0,0,NULL,0,42210936,NULL,NULL,'2:00 PM','2:00 PM','Ikoyi, Ikeja, Lagos, Nigeria',NULL,1,0,NULL,NULL,NULL,NULL,0,'shortlet',NULL);
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_user`
--

DROP TABLE IF EXISTS `property_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `apartment_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_user`
--

LOCK TABLES `property_user` WRITE;
/*!40000 ALTER TABLE `property_user` DISABLE KEYS */;
INSERT INTO `property_user` VALUES (1,14,12,NULL,NULL,NULL);
/*!40000 ALTER TABLE `property_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `related_apartments`
--

DROP TABLE IF EXISTS `related_apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `related_apartments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` int DEFAULT NULL,
  `related_id` int DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `related_apartments`
--

LOCK TABLES `related_apartments` WRITE;
/*!40000 ALTER TABLE `related_apartments` DISABLE KEYS */;
/*!40000 ALTER TABLE `related_apartments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requirements`
--

DROP TABLE IF EXISTS `requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requirements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requirements`
--

LOCK TABLES `requirements` WRITE;
/*!40000 ALTER TABLE `requirements` DISABLE KEYS */;
/*!40000 ALTER TABLE `requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `booker_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booker_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booker_phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booker_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booker_is_main_guest` tinyint(1) DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_requests` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `coupon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `apartment_id` int DEFAULT NULL,
  `guest_user_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `checkin` timestamp NULL DEFAULT NULL,
  `checkout` timestamp NULL DEFAULT NULL,
  `number_of_guest` int DEFAULT NULL,
  `children` int DEFAULT NULL,
  `adults` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `property_id` int DEFAULT NULL,
  `user_reservation_id` int DEFAULT NULL,
  `sale_price` bigint DEFAULT NULL,
  `price` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-09-25 08:34:38','2021-09-25 08:34:38',4,NULL,1,'2021-09-30 00:00:00','2021-10-02 00:00:00',NULL,NULL,NULL,0,5,1,NULL,NULL),(2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-10-14 20:28:14','2021-10-14 20:28:14',9,NULL,1,'2021-10-15 00:00:00','2021-10-16 00:00:00',NULL,NULL,NULL,0,10,2,NULL,5000),(3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-03-07 11:43:34','2022-03-07 11:43:34',10,NULL,1,'2022-03-11 00:00:00','2022-03-12 00:00:00',NULL,NULL,NULL,0,11,3,NULL,600000),(4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-08-03 20:09:10','2022-08-03 20:09:10',10,NULL,2,'2022-08-10 00:00:00','2022-08-12 00:00:00',NULL,NULL,NULL,0,11,4,NULL,600000),(5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-09 13:26:42','2023-01-09 13:26:42',10,NULL,2,'2023-01-12 00:00:00','2023-01-13 00:00:00',NULL,NULL,NULL,0,11,5,NULL,600000),(6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-11 19:51:47','2023-01-11 19:51:47',12,NULL,1,'2023-01-13 00:00:00','2023-01-14 00:00:00',NULL,NULL,NULL,0,13,6,NULL,5000),(7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-11 20:47:55','2023-01-11 20:47:55',12,NULL,1,'2023-01-19 00:00:00','2023-01-20 00:00:00',NULL,NULL,NULL,0,13,7,NULL,1000000),(8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-11 20:48:10','2023-01-11 20:48:10',12,NULL,1,'2023-01-19 00:00:00','2023-01-20 00:00:00',NULL,NULL,NULL,0,13,8,NULL,1000000),(9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-01-11 20:50:07','2023-01-11 20:50:07',12,NULL,1,'2023-01-19 00:00:00','2023-01-20 00:00:00',NULL,NULL,NULL,0,13,9,NULL,1000000),(10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-16 03:41:59','2023-06-16 03:41:59',12,NULL,1,'2023-06-17 00:00:00','2023-06-21 00:00:00',NULL,NULL,NULL,0,13,10,NULL,1000000),(11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-19 04:39:27','2023-06-19 04:39:27',12,NULL,2,'2023-06-23 00:00:00','2023-06-24 00:00:00',NULL,NULL,NULL,0,13,11,NULL,1000000),(12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 01:59:29','2023-06-25 01:59:29',12,NULL,1,'2023-07-10 00:00:00','2023-07-14 00:00:00',NULL,NULL,NULL,0,13,12,NULL,1000000),(13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 02:13:38','2023-06-25 02:13:38',12,NULL,1,'2023-06-29 00:00:00','2023-06-30 00:00:00',NULL,NULL,NULL,0,13,13,NULL,1000000),(14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 02:17:00','2023-06-25 02:17:00',12,NULL,1,'2023-06-29 00:00:00','2023-06-30 00:00:00',NULL,NULL,NULL,0,13,14,NULL,1000000),(15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 02:23:15','2023-06-25 02:23:15',12,NULL,1,'2023-06-29 00:00:00','2023-06-30 00:00:00',NULL,NULL,NULL,0,13,15,NULL,1000000),(16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 02:32:04','2023-06-25 02:32:04',12,NULL,1,'2023-07-16 00:00:00','2023-07-19 00:00:00',NULL,NULL,NULL,0,13,16,NULL,1000000),(17,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 02:43:20','2023-06-25 02:43:20',12,NULL,2,'2023-07-09 00:00:00','2023-07-11 00:00:00',NULL,NULL,NULL,0,13,17,NULL,1000000),(18,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 11:49:52','2023-06-25 11:49:52',11,NULL,1,'2023-06-29 00:00:00','2023-06-30 00:00:00',NULL,NULL,NULL,0,12,18,NULL,40000),(19,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-25 12:11:09','2023-06-25 12:11:09',12,NULL,1,'2023-09-13 00:00:00','2023-09-15 00:00:00',NULL,NULL,NULL,0,13,19,NULL,1000000),(20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-26 10:59:51','2023-06-26 10:59:51',12,NULL,1,'2023-07-30 00:00:00','2023-07-31 00:00:00',NULL,NULL,NULL,0,13,20,NULL,1000000),(21,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-26 11:29:59','2023-06-26 11:29:59',12,NULL,1,'2023-07-30 00:00:00','2023-07-31 00:00:00',NULL,NULL,NULL,0,13,1,NULL,1000000),(22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-28 22:39:16','2023-06-28 22:39:16',11,NULL,1,'2023-07-12 00:00:00','2023-07-14 00:00:00',NULL,NULL,NULL,0,12,2,NULL,40000),(23,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-28 23:05:10','2023-06-28 23:05:10',11,NULL,1,'2023-07-18 00:00:00','2023-07-21 00:00:00',NULL,NULL,NULL,0,12,3,NULL,40000);
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_children_attribtes`
--

DROP TABLE IF EXISTS `room_children_attribtes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_children_attribtes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_parent_attribte_id` int DEFAULT NULL,
  `attribute_id` int unsigned NOT NULL,
  `room_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_children_attribtes_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `room_children_attribtes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_children_attribtes`
--

LOCK TABLES `room_children_attribtes` WRITE;
/*!40000 ALTER TABLE `room_children_attribtes` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_children_attribtes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_parent_attribtes`
--

DROP TABLE IF EXISTS `room_parent_attribtes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_parent_attribtes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` int unsigned NOT NULL,
  `room_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_parent_attribtes_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `room_parent_attribtes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_parent_attribtes`
--

LOCK TABLES `room_parent_attribtes` WRITE;
/*!40000 ALTER TABLE `room_parent_attribtes` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_parent_attribtes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `sale_price` decimal(8,6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_lets`
--

DROP TABLE IF EXISTS `sub_lets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_lets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_lets`
--

LOCK TABLES `sub_lets` WRITE;
/*!40000 ALTER TABLE `sub_lets` DISABLE KEYS */;
INSERT INTO `sub_lets` VALUES (4,14,'2023-07-12 20:23:59','2023-07-12 20:23:59');
/*!40000 ALTER TABLE `sub_lets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_times` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_tag_keywords` text COLLATE utf8mb4_unicode_ci,
  `products_items_per_page` int NOT NULL,
  `alert_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_h_o_l` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_h_w_l` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_logo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `products_items_size_h` int DEFAULT NULL,
  `products_items_size_w` int DEFAULT NULL,
  `payment_id` int DEFAULT NULL,
  `customer_currency_id` int DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `location_aware` tinyint(1) NOT NULL DEFAULT '1',
  `shipping_is_free` tinyint(1) NOT NULL DEFAULT '0',
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_multi_currency` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'AvenueMontaigne','Lekki','info@myshorlet.com','08169389886',NULL,NULL,'REal Estate','Rent luxury apartments','Real Estate',35,'jacob.atam@gmail.com','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1687696643avm residences-24.png','1687696643avm residences-24.png',32,23,NULL,NULL,9,1,0,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `permission_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_permissions_user_id_foreign` (`user_id`),
  KEY `user_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `user_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (1,1,1,'2021-06-02 15:16:14','2021-06-02 15:16:14');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_reservations`
--

DROP TABLE IF EXISTS `user_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_reservations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `guest_user_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `checkin` timestamp NULL DEFAULT NULL,
  `checkout` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_reservations`
--

LOCK TABLES `user_reservations` WRITE;
/*!40000 ALTER TABLE `user_reservations` DISABLE KEYS */;
INSERT INTO `user_reservations` VALUES (1,1,20,13,'2023-07-30 00:00:00','2023-07-31 00:00:00','₦',NULL,NULL,'INV-2023-576375984','1000000',NULL,'online','102.88.63.121',NULL,'2023-06-26 11:29:59','2023-06-26 11:29:59'),(2,NULL,21,12,'2023-07-12 00:00:00','2023-07-14 00:00:00','₦',NULL,NULL,'INV-2023-23248571','80000',NULL,'online','102.88.35.180',NULL,'2023-06-28 22:39:16','2023-06-28 22:39:16'),(3,NULL,22,12,'2023-07-18 00:00:00','2023-07-21 00:00:00','₦',NULL,NULL,'INV-2023-1163873449','150000',NULL,'online','102.88.63.146',NULL,'2023-06-28 23:05:10','2023-06-28 23:05:10');
/*!40000 ALTER TABLE `user_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `role_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_roles_user_id_foreign` (`user_id`),
  KEY `user_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_socials`
--

DROP TABLE IF EXISTS `user_socials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_socials` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `social_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_socials_user_id_foreign` (`user_id`),
  CONSTRAINT `user_socials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_socials`
--

LOCK TABLES `user_socials` WRITE;
/*!40000 ALTER TABLE `user_socials` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_socials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mailing_list` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `company_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jacky',NULL,'jacob.atam@gmail.com',NULL,'2021-06-02 15:16:14',1,1,NULL,'$2y$10$NooCgVaS8ajJfo9VdBOu5ewhZtlP0P9QLtE5bQal9gJwNHx7tuzBm','lubYFHGAtZQehG12HxTaWIohf80ErU8DL1luhyteZv5NRZRjJm4KxTBQZA1F','2021-06-02 15:16:14','2023-06-17 12:03:24','admin',NULL,NULL,NULL,''),(2,'','onsylxBp','peterchase997@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$9uoxsPva4NQMmTIuUYSM4edJ9DwJHOKgzfmsGXZraw8F.Na7Z6Ti2',NULL,'2021-06-08 01:47:24','2021-06-08 01:47:24','subscriber',NULL,NULL,NULL,''),(3,'','odCMDIUPGrfNx','pb5499805@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$zS07Nvm80vHALkKL22Rjgeded3fZhDZAgx5DNVaZMe1Z28hdgHC5i',NULL,'2021-06-14 02:53:52','2021-06-14 02:53:52','subscriber',NULL,NULL,NULL,''),(4,'','fNogybksnEu','nganschmaltz306@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$Qyap/VlFSVwSXcSW7SPYd.QgECY8Aw6ozv3rfvBLDFCl99U21vski',NULL,'2021-06-30 11:55:38','2021-06-30 11:55:38','subscriber',NULL,NULL,NULL,''),(5,'','rWZERVhyKmLAGxu','marina.skuratova90@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$hB4nSwvoWyqkbbmY5QwtReMBt/iLVLoX1lGQ0.l131ai7SMfMlYWW',NULL,'2021-07-09 03:56:18','2021-07-09 03:56:18','subscriber',NULL,NULL,NULL,''),(6,'','IxTUopPJX','frenchgraiden844@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$nxNtamuusFu.w1QPq4.lL.j8nHlqQFYuQpOHLL6jd3FezI4npQkfW',NULL,'2021-07-17 18:23:35','2021-07-17 18:23:35','subscriber',NULL,NULL,NULL,''),(7,'','MartinbicRN','noelsclav@mail.com',NULL,NULL,1,1,NULL,'$2y$10$mDhL0/.rfRKdKNigpxPLBOm2.tVXrj7MTdhjOHhczu/QoUFgatJce',NULL,'2021-07-24 07:38:28','2021-07-24 07:38:28','subscriber',NULL,NULL,NULL,''),(8,'','iDrdcCtBKQmpaWA','jusimporkaw@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$mq90aG9q52.59CCiedAlm.xBBmYquu6yGK7D74Z8eL1CivBn/AdkW',NULL,'2021-07-25 10:17:44','2021-07-25 10:17:44','subscriber',NULL,NULL,NULL,''),(9,'','StevesatVN','freesunsidistben@mail.com',NULL,NULL,1,1,NULL,'$2y$10$dwp50xVIT6TaRGNsdRFPm.kciK8Eq11W8GSoagmv6u1IbkzOt9c56',NULL,'2021-07-29 17:04:13','2021-07-29 17:04:13','subscriber',NULL,NULL,NULL,''),(10,'','RobertclidaSS','myringpecabvi@mail.com',NULL,NULL,1,1,NULL,'$2y$10$4ruInhcYJ1Wpxc2dxrNDVuzEMx/tPTE5jrh0IwsSfg6FKlHA79WEy',NULL,'2021-07-30 10:54:40','2021-07-30 10:54:40','subscriber',NULL,NULL,NULL,''),(11,'','ShaneTitDH','inamhypcanar@mail.com',NULL,NULL,1,1,NULL,'$2y$10$kuOpDCtazVea//RoysBeaun8xvF4gLjW7.sPEyk96LaTdvcB3aG0a',NULL,'2021-08-03 09:07:12','2021-08-03 09:07:12','subscriber',NULL,NULL,NULL,''),(12,'','yCjkFxZY','muscpersdifflil71@gmail.com',NULL,NULL,1,1,NULL,'$2y$10$WTOSGEzDOPUpQ1aU4wbMN.WbKGh9bVRiAgB.9aFuyRKMrsbF9ckyu',NULL,'2021-08-07 13:50:27','2021-08-07 13:50:27','subscriber',NULL,NULL,NULL,''),(13,'we','df','info@enkoded.com','6266286780',NULL,1,1,NULL,'$2y$10$kg9N26fsIMP0mrUGkqM8QOtc4OHxymYFrO5L8lpIXQi3nmdH/r2mS',NULL,'2023-07-10 20:40:45','2023-07-10 20:40:45',NULL,NULL,NULL,NULL,''),(14,'Tosin','ewe','abiola@autofactorng.com','08169339886',NULL,1,1,NULL,'$2y$10$S/0.6iM5nrWQK0aa.k1eHuBKh1uZc0NQ1tkRjX6o7PRDZi9LWG06.',NULL,'2023-07-10 21:42:36','2023-07-10 21:42:36','agent',NULL,NULL,NULL,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vouchers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_value` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` int unsigned DEFAULT NULL,
  `apartment_id` int unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vouchers_code_unique` (`code`),
  KEY `vouchers_category_id_foreign` (`category_id`),
  CONSTRAINT `vouchers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
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

-- Dump completed on 2023-08-13  0:04:41
