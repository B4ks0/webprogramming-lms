-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: db_webprogramming
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absensi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `jadwal_id` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','alpha') COLLATE utf8mb4_unicode_ci DEFAULT 'hadir',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  KEY `jadwal_id` (`jadwal_id`),
  CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_ibfk_3` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi`
--

LOCK TABLES `absensi` WRITE;
/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (1,4,1,1,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(2,4,1,2,'2026-05-07','hadir',NULL,'2026-05-30 06:18:28'),(3,4,1,1,'2026-05-12','hadir',NULL,'2026-05-30 06:18:28'),(4,4,1,2,'2026-05-14','izin','Keperluan keluarga','2026-05-30 06:18:28'),(5,4,1,1,'2026-05-19','hadir',NULL,'2026-05-30 06:18:28'),(6,4,1,2,'2026-05-21','hadir',NULL,'2026-05-30 06:18:28'),(7,4,1,1,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(8,4,1,2,'2026-05-28','sakit','Demam','2026-05-30 06:18:28'),(9,8,1,1,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(10,8,1,2,'2026-05-07','hadir',NULL,'2026-05-30 06:18:28'),(11,8,1,1,'2026-05-12','hadir',NULL,'2026-05-30 06:18:28'),(12,8,1,2,'2026-05-14','hadir',NULL,'2026-05-30 06:18:28'),(13,8,1,1,'2026-05-19','alpha',NULL,'2026-05-30 06:18:28'),(14,8,1,2,'2026-05-21','hadir',NULL,'2026-05-30 06:18:28'),(15,8,1,1,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(16,8,1,2,'2026-05-28','hadir',NULL,'2026-05-30 06:18:28'),(17,10,1,1,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(18,10,1,2,'2026-05-07','hadir',NULL,'2026-05-30 06:18:28'),(19,10,1,1,'2026-05-12','sakit','Surat dokter terlampir','2026-05-30 06:18:28'),(20,10,1,2,'2026-05-14','hadir',NULL,'2026-05-30 06:18:28'),(21,10,1,1,'2026-05-19','hadir',NULL,'2026-05-30 06:18:28'),(22,10,1,2,'2026-05-21','hadir',NULL,'2026-05-30 06:18:28'),(23,10,1,1,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(24,10,1,2,'2026-05-28','hadir',NULL,'2026-05-30 06:18:28'),(25,12,1,1,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(26,12,1,2,'2026-05-07','hadir',NULL,'2026-05-30 06:18:28'),(27,12,1,1,'2026-05-12','hadir',NULL,'2026-05-30 06:18:28'),(28,12,1,2,'2026-05-14','hadir',NULL,'2026-05-30 06:18:28'),(29,12,1,1,'2026-05-19','izin','Mengurus berkas akademik','2026-05-30 06:18:28'),(30,12,1,2,'2026-05-21','hadir',NULL,'2026-05-30 06:18:28'),(31,12,1,1,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(32,12,1,2,'2026-05-28','hadir',NULL,'2026-05-30 06:18:28'),(33,4,2,3,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(34,4,2,4,'2026-05-08','hadir',NULL,'2026-05-30 06:18:28'),(35,4,2,3,'2026-05-13','hadir',NULL,'2026-05-30 06:18:28'),(36,4,2,4,'2026-05-15','hadir',NULL,'2026-05-30 06:18:28'),(37,4,2,3,'2026-05-20','alpha',NULL,'2026-05-30 06:18:28'),(38,4,2,4,'2026-05-22','hadir',NULL,'2026-05-30 06:18:28'),(39,4,2,3,'2026-05-27','hadir',NULL,'2026-05-30 06:18:28'),(40,4,2,4,'2026-05-29','hadir',NULL,'2026-05-30 06:18:28'),(41,8,2,3,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(42,8,2,4,'2026-05-08','hadir',NULL,'2026-05-30 06:18:28'),(43,8,2,3,'2026-05-13','izin','Sakit ringan','2026-05-30 06:18:28'),(44,8,2,4,'2026-05-15','hadir',NULL,'2026-05-30 06:18:28'),(45,8,2,3,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(46,8,2,4,'2026-05-22','hadir',NULL,'2026-05-30 06:18:28'),(47,8,2,3,'2026-05-27','hadir',NULL,'2026-05-30 06:18:28'),(48,8,2,4,'2026-05-29','hadir',NULL,'2026-05-30 06:18:28'),(49,9,2,3,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(50,9,2,4,'2026-05-08','hadir',NULL,'2026-05-30 06:18:28'),(51,9,2,3,'2026-05-13','hadir',NULL,'2026-05-30 06:18:28'),(52,9,2,4,'2026-05-15','sakit','Flu','2026-05-30 06:18:28'),(53,9,2,3,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(54,9,2,4,'2026-05-22','hadir',NULL,'2026-05-30 06:18:28'),(55,9,2,3,'2026-05-27','hadir',NULL,'2026-05-30 06:18:28'),(56,9,2,4,'2026-05-29','hadir',NULL,'2026-05-30 06:18:28'),(57,11,2,3,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(58,11,2,4,'2026-05-08','hadir',NULL,'2026-05-30 06:18:28'),(59,11,2,3,'2026-05-13','hadir',NULL,'2026-05-30 06:18:28'),(60,11,2,4,'2026-05-15','hadir',NULL,'2026-05-30 06:18:28'),(61,11,2,3,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(62,11,2,4,'2026-05-22','izin','Urusan organisasi','2026-05-30 06:18:28'),(63,11,2,3,'2026-05-27','hadir',NULL,'2026-05-30 06:18:28'),(64,11,2,4,'2026-05-29','hadir',NULL,'2026-05-30 06:18:28'),(65,12,2,3,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(66,12,2,4,'2026-05-08','alpha',NULL,'2026-05-30 06:18:28'),(67,12,2,3,'2026-05-13','hadir',NULL,'2026-05-30 06:18:28'),(68,12,2,4,'2026-05-15','hadir',NULL,'2026-05-30 06:18:28'),(69,12,2,3,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(70,12,2,4,'2026-05-22','hadir',NULL,'2026-05-30 06:18:28'),(71,12,2,3,'2026-05-27','sakit','Migrain','2026-05-30 06:18:28'),(72,12,2,4,'2026-05-29','hadir',NULL,'2026-05-30 06:18:28'),(73,4,3,5,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(74,4,3,5,'2026-05-12','hadir',NULL,'2026-05-30 06:18:28'),(75,4,3,5,'2026-05-19','hadir',NULL,'2026-05-30 06:18:28'),(76,4,3,5,'2026-05-26','izin','Presentasi lomba','2026-05-30 06:18:28'),(77,8,3,5,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(78,8,3,5,'2026-05-12','hadir',NULL,'2026-05-30 06:18:28'),(79,8,3,5,'2026-05-19','hadir',NULL,'2026-05-30 06:18:28'),(80,8,3,5,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(81,10,3,5,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(82,10,3,5,'2026-05-12','sakit','Demam','2026-05-30 06:18:28'),(83,10,3,5,'2026-05-19','hadir',NULL,'2026-05-30 06:18:28'),(84,10,3,5,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(85,12,3,5,'2026-05-05','hadir',NULL,'2026-05-30 06:18:28'),(86,12,3,5,'2026-05-12','hadir',NULL,'2026-05-30 06:18:28'),(87,12,3,5,'2026-05-19','hadir',NULL,'2026-05-30 06:18:28'),(88,12,3,5,'2026-05-26','hadir',NULL,'2026-05-30 06:18:28'),(89,9,4,6,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(90,9,4,6,'2026-05-13','hadir',NULL,'2026-05-30 06:18:28'),(91,9,4,6,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(92,9,4,6,'2026-05-27','izin','Acara kampus','2026-05-30 06:18:28'),(93,11,4,6,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(94,11,4,6,'2026-05-13','alpha',NULL,'2026-05-30 06:18:28'),(95,11,4,6,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(96,11,4,6,'2026-05-27','hadir',NULL,'2026-05-30 06:18:28'),(97,12,4,6,'2026-05-06','hadir',NULL,'2026-05-30 06:18:28'),(98,12,4,6,'2026-05-13','hadir',NULL,'2026-05-30 06:18:28'),(99,12,4,6,'2026-05-20','hadir',NULL,'2026-05-30 06:18:28'),(100,12,4,6,'2026-05-27','hadir',NULL,'2026-05-30 06:18:28'),(101,8,5,7,'2026-05-07','hadir',NULL,'2026-05-30 06:18:28'),(102,8,5,7,'2026-05-14','hadir',NULL,'2026-05-30 06:18:28'),(103,8,5,7,'2026-05-21','hadir',NULL,'2026-05-30 06:18:28'),(104,8,5,7,'2026-05-28','hadir',NULL,'2026-05-30 06:18:28'),(105,11,5,7,'2026-05-07','hadir',NULL,'2026-05-30 06:18:28'),(106,11,5,7,'2026-05-14','izin','Seminar nasional','2026-05-30 06:18:28'),(107,11,5,7,'2026-05-21','hadir',NULL,'2026-05-30 06:18:28'),(108,11,5,7,'2026-05-28','hadir',NULL,'2026-05-30 06:18:28'),(109,9,6,8,'2026-05-08','hadir',NULL,'2026-05-30 06:18:28'),(110,9,6,8,'2026-05-15','hadir',NULL,'2026-05-30 06:18:28'),(111,9,6,8,'2026-05-22','hadir',NULL,'2026-05-30 06:18:28'),(112,9,6,8,'2026-05-29','sakit','Flu berat','2026-05-30 06:18:28'),(113,10,6,8,'2026-05-08','hadir',NULL,'2026-05-30 06:18:28'),(114,10,6,8,'2026-05-15','hadir',NULL,'2026-05-30 06:18:28'),(115,10,6,8,'2026-05-22','alpha',NULL,'2026-05-30 06:18:28'),(116,10,6,8,'2026-05-29','hadir',NULL,'2026-05-30 06:18:28'),(117,8,7,9,'2026-05-09','hadir',NULL,'2026-05-30 06:18:28'),(118,8,7,9,'2026-05-16','hadir',NULL,'2026-05-30 06:18:28'),(119,8,7,9,'2026-05-23','hadir',NULL,'2026-05-30 06:18:28'),(120,8,7,9,'2026-05-30','hadir',NULL,'2026-05-30 06:18:28'),(121,10,7,9,'2026-05-09','hadir',NULL,'2026-05-30 06:18:28'),(122,10,7,9,'2026-05-16','izin','Izin keluarga','2026-05-30 06:18:28'),(123,10,7,9,'2026-05-23','hadir',NULL,'2026-05-30 06:18:28'),(124,10,7,9,'2026-05-30','hadir',NULL,'2026-05-30 06:18:28'),(125,9,8,10,'2026-05-09','hadir',NULL,'2026-05-30 06:18:28'),(126,9,8,10,'2026-05-16','hadir',NULL,'2026-05-30 06:18:28'),(127,9,8,10,'2026-05-23','hadir',NULL,'2026-05-30 06:18:28'),(128,9,8,10,'2026-05-30','hadir',NULL,'2026-05-30 06:18:28'),(129,11,8,10,'2026-05-09','hadir',NULL,'2026-05-30 06:18:28'),(130,11,8,10,'2026-05-16','hadir',NULL,'2026-05-30 06:18:28'),(131,11,8,10,'2026-05-23','sakit','Surat sakit','2026-05-30 06:18:28'),(132,11,8,10,'2026-05-30','hadir',NULL,'2026-05-30 06:18:28');
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignment_submissions`
--

DROP TABLE IF EXISTS `assignment_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignment_submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assignment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nilai` decimal(5,2) DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `status` enum('submitted','reviewed') COLLATE utf8mb4_unicode_ci DEFAULT 'submitted',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_assignment_user` (`assignment_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `assignment_submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignment_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment_submissions`
--

LOCK TABLES `assignment_submissions` WRITE;
/*!40000 ALTER TABLE `assignment_submissions` DISABLE KEYS */;
INSERT INTO `assignment_submissions` VALUES (1,1,4,'submissions/andi_tugas1_login.php','Sudah saya kerjakan sesuai ketentuan.','2026-05-30 06:18:28',85.00,'Bagus, login berfungsi dengan baik.','reviewed'),(2,2,4,'submissions/andi_tugas2_crud.php','Menambahkan fitur search juga.','2026-05-30 06:18:28',88.00,'Excellent, bonus untuk fitur tambahan.','reviewed'),(3,1,8,'submissions/budi_tugas1_login.php','Login dengan hash password.','2026-05-30 06:18:28',90.00,'Implementasi keamanan sangat baik.','reviewed'),(4,2,8,'submissions/budi_tugas2_crud.php','CRUD lengkap dengan validasi.','2026-05-30 06:18:28',87.00,'Validasi sudah baik, perhatikan XSS.','reviewed'),(5,1,10,'submissions/dian_tugas1_login.php','Selesai sesuai spesifikasi.','2026-05-30 06:18:28',78.00,'Fungsionalitas OK, perbaiki tampilan.','reviewed'),(6,1,12,'submissions/fina_tugas1_login.php',NULL,'2026-05-30 06:18:28',NULL,NULL,'submitted'),(7,2,12,'submissions/fina_tugas2_crud.php','Masih ada bug pada delete.','2026-05-30 06:18:28',NULL,NULL,'submitted'),(8,4,8,'submissions/budi_tugas1_query.sql','5 query JOIN sudah lengkap.','2026-05-30 06:18:28',82.00,'Query sudah benar, optimalkan dengan index.','reviewed'),(9,4,9,'submissions/citra_tugas1_query.sql','Query dengan subquery juga.','2026-05-30 06:18:28',91.00,'Penggunaan subquery sangat kreatif.','reviewed'),(10,5,9,'submissions/citra_tugas2_normal.pdf','Normalisasi 3NF lengkap dengan penjelasan.','2026-05-30 06:18:28',76.00,'Penjelasan cukup, perlu diperdalam BCNF.','reviewed'),(11,4,11,'submissions/eko_tugas1_query.sql',NULL,'2026-05-30 06:18:28',NULL,NULL,'submitted'),(12,4,12,'submissions/fina_tugas1_query.sql','Query sederhana.','2026-05-30 06:18:28',70.00,'Perlu latihan lebih untuk query kompleks.','reviewed'),(13,6,4,'submissions/andi_tugas1_oop.php','OOP untuk perpustakaan.','2026-05-30 06:18:28',86.00,'Inheritance dan interface sudah baik.','reviewed'),(14,6,8,'submissions/budi_tugas1_oop.php','Lengkap dengan design pattern.','2026-05-30 06:18:28',93.00,'Implementasi pattern sangat baik!','reviewed'),(15,8,9,'submissions/citra_tugas1_erd.pdf','ERD sistem akademik 10 entitas.','2026-05-30 06:18:28',89.00,'ERD komprehensif dan relasi tepat.','reviewed'),(16,10,8,'submissions/budi_tugas1_wireshark.pdf','Capture 3 TCP handshake.','2026-05-30 06:18:28',84.00,'Analisis paket sudah benar.','reviewed'),(17,14,11,'submissions/eko_tugas1_ml.ipynb','Prediksi dengan LinearRegression.','2026-05-30 06:18:28',88.00,'Implementasi regresi baik, tambahkan visualisasi.','reviewed');
/*!40000 ALTER TABLE `assignment_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `judul_tugas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (1,1,'Tugas Login PHP','Buat halaman login sederhana menggunakan session dan role.',NULL,'2026-06-01 17:29:39','2026-05-25 09:29:39'),(2,1,'Tugas 2: Buat CRUD Sederhana','Implementasikan CRUD mahasiswa dengan PHP dan MySQL.',NULL,'2026-07-15 23:59:00','2026-05-30 06:18:28'),(3,1,'Tugas 3: Upload File & Validasi','Form upload foto dengan validasi tipe dan ukuran file.',NULL,'2026-07-29 23:59:00','2026-05-30 06:18:28'),(4,2,'Tugas 1: Query JOIN','Buat 5 query menggunakan INNER JOIN dan LEFT JOIN pada database LMS.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28'),(5,2,'Tugas 2: Normalisasi Tabel','Normalisasikan tabel yang diberikan hingga ke bentuk 3NF.',NULL,'2026-07-15 23:59:00','2026-05-30 06:18:28'),(6,3,'Tugas 1: Implementasi OOP','Buat class hierarchy untuk sistem perpustakaan dengan PHP OOP.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28'),(7,3,'Tugas 2: REST API CRUD','Buat REST API untuk manajemen produk dengan autentikasi token.',NULL,'2026-07-15 23:59:00','2026-05-30 06:18:28'),(8,4,'Tugas 1: ERD Sistem Akademik','Rancang ERD untuk sistem akademik lengkap dengan minimal 8 entitas.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28'),(9,4,'Tugas 2: Stored Procedure','Buat stored procedure untuk laporan nilai mahasiswa per semester.',NULL,'2026-07-15 23:59:00','2026-05-30 06:18:28'),(10,5,'Tugas 1: Analisis Paket Wireshark','Capture traffic jaringan dan analisis paket TCP handshake dengan Wireshark.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28'),(11,5,'Tugas 2: Konfigurasi VLAN','Konfigurasi VLAN dan inter-VLAN routing pada simulator Packet Tracer.',NULL,'2026-07-15 23:59:00','2026-05-30 06:18:28'),(12,6,'Tugas 1: Shell Script Monitoring','Buat script bash untuk monitoring disk usage dan email alert otomatis.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28'),(13,7,'Tugas 1: Aplikasi To-Do List Android','Buat aplikasi Android To-Do List dengan SQLite lokal.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28'),(14,8,'Tugas 1: Prediksi Harga Rumah','Implementasi regresi linear untuk prediksi harga rumah dengan dataset yang disediakan.',NULL,'2026-07-01 23:59:00','2026-05-30 06:18:28');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Pemrograman Web','pemrograman-web'),(2,'Basis Data','basis-data'),(3,'Jaringan Komputer','jaringan-komputer'),(4,'Sistem Operasi','sistem-operasi'),(5,'Pemrograman Mobile','pemrograman-mobile'),(6,'Kecerdasan Buatan','kecerdasan-buatan');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT '0.00',
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,3,1,'Web Programming Dasar','HTML, CSS, PHP, MySQL, dan dasar pembuatan LMS sederhana.',NULL,0.00,'published','2026-05-25 09:02:38'),(2,3,2,'Basis Data MySQL','Desain tabel, relasi, query SELECT, INSERT, UPDATE, DELETE, dan laporan sederhana.',NULL,0.00,'published','2026-05-25 09:10:32'),(3,3,1,'Pemrograman PHP Lanjut','OOP, Framework MVC, dan REST API menggunakan PHP modern.',NULL,0.00,'published','2026-05-30 06:18:28'),(4,3,2,'Desain Database','Perancangan ERD, normalisasi, stored procedure, dan optimasi query.',NULL,0.00,'published','2026-05-30 06:18:28'),(5,5,3,'Jaringan Komputer Dasar','Konsep jaringan, model OSI, TCP/IP, dan konfigurasi router dasar.',NULL,0.00,'published','2026-05-30 06:18:28'),(6,6,4,'Sistem Operasi Linux','Administrasi sistem Linux, manajemen proses, dan shell scripting.',NULL,0.00,'published','2026-05-30 06:18:28'),(7,7,5,'Android Development','Pengembangan aplikasi Android menggunakan Java dan Android Studio.',NULL,0.00,'published','2026-05-30 06:18:28'),(8,5,6,'Machine Learning Dasar','Pengenalan ML, regresi linear, klasifikasi, dan clustering dengan Python.',NULL,0.00,'published','2026-05-30 06:18:28');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrollments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `tgl_daftar` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_belajar` enum('aktif','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'aktif',
  `nilai_akhir` decimal(5,2) DEFAULT NULL,
  `catatan_dosen` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_enrollment` (`user_id`,`course_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

LOCK TABLES `enrollments` WRITE;
/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
INSERT INTO `enrollments` VALUES (1,4,2,'2026-05-25 17:11:57','aktif',NULL,NULL),(2,4,1,'2026-05-25 17:29:39','aktif',NULL,NULL),(3,4,3,'2026-05-30 14:18:28','aktif',NULL,NULL),(4,8,1,'2026-05-30 14:18:28','aktif',NULL,NULL),(5,8,2,'2026-05-30 14:18:28','aktif',NULL,NULL),(6,8,5,'2026-05-30 14:18:28','aktif',NULL,NULL),(7,8,7,'2026-05-30 14:18:28','aktif',NULL,NULL),(8,9,2,'2026-05-30 14:18:28','aktif',NULL,NULL),(9,9,4,'2026-05-30 14:18:28','aktif',NULL,NULL),(10,9,6,'2026-05-30 14:18:28','aktif',NULL,NULL),(11,9,8,'2026-05-30 14:18:28','aktif',NULL,NULL),(12,10,1,'2026-05-30 14:18:28','selesai',88.50,'Mahasiswa aktif dan berprestasi'),(13,10,3,'2026-05-30 14:18:28','aktif',NULL,NULL),(14,10,6,'2026-05-30 14:18:28','aktif',NULL,NULL),(15,10,7,'2026-05-30 14:18:28','aktif',NULL,NULL),(16,11,2,'2026-05-30 14:18:28','aktif',NULL,NULL),(17,11,4,'2026-05-30 14:18:28','aktif',NULL,NULL),(18,11,5,'2026-05-30 14:18:28','selesai',91.00,'Sangat baik, lulus dengan pujian'),(19,11,8,'2026-05-30 14:18:28','aktif',NULL,NULL),(20,12,1,'2026-05-30 14:18:28','aktif',NULL,NULL),(21,12,2,'2026-05-30 14:18:28','aktif',NULL,NULL),(22,12,3,'2026-05-30 14:18:28','aktif',NULL,NULL),(23,12,4,'2026-05-30 14:18:28','aktif',NULL,NULL);
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `kelas_id` (`kelas_id`),
  CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
INSERT INTO `jadwal` VALUES (1,1,1,'Senin','08:00:00','10:00:00','Gedung A-101','2026-05-30 06:18:28'),(2,1,2,'Rabu','13:00:00','15:00:00','Gedung A-102','2026-05-30 06:18:28'),(3,2,1,'Selasa','08:00:00','10:00:00','Lab Basis Data','2026-05-30 06:18:28'),(4,2,3,'Kamis','13:00:00','15:00:00','Lab Basis Data','2026-05-30 06:18:28'),(5,3,2,'Senin','10:00:00','12:00:00','Gedung B-201','2026-05-30 06:18:28'),(6,4,1,'Selasa','13:00:00','15:00:00','Gedung B-202','2026-05-30 06:18:28'),(7,5,4,'Rabu','08:00:00','10:00:00','Lab Jaringan','2026-05-30 06:18:28'),(8,6,2,'Kamis','08:00:00','10:00:00','Gedung C-301','2026-05-30 06:18:28'),(9,7,5,'Jumat','08:00:00','10:00:00','Lab Mobile','2026-05-30 06:18:28'),(10,8,3,'Jumat','13:00:00','15:00:00','Lab AI','2026-05-30 06:18:28');
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_kelas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int DEFAULT '30',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_kelas` (`kode_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'Kelas A','KLS-A',35,'2026-05-30 06:02:43'),(2,'Kelas B','KLS-B',35,'2026-05-30 06:02:43'),(3,'Kelas C','KLS-C',30,'2026-05-30 06:02:43'),(4,'Kelas D','KLS-D',35,'2026-05-30 06:18:28'),(5,'Kelas E','KLS-E',35,'2026-05-30 06:18:28');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `judul_materi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten_teks` longtext COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,1,'Pengenalan LMS','Materi pengantar tentang Learning Management System dan alur belajar online.',NULL,NULL,1,'2026-05-25 09:02:38'),(2,1,'HTML & CSS Fundamental','Struktur halaman HTML5, semantic elements, CSS box model, flexbox, dan grid layout.',NULL,NULL,2,'2026-05-30 06:18:28'),(3,1,'PHP Dasar & Form Handling','Sintaks PHP, variabel, array, kondisi, loop, dan menangani form POST/GET.',NULL,NULL,3,'2026-05-30 06:18:28'),(4,2,'Pengenalan Basis Data Relasional','Konsep RDBMS, tabel, baris, kolom, primary key dan foreign key.',NULL,NULL,1,'2026-05-30 06:18:28'),(5,2,'Query SELECT & JOIN','SELECT, WHERE, ORDER BY, GROUP BY, INNER JOIN, LEFT JOIN, dan subquery.',NULL,NULL,2,'2026-05-30 06:18:28'),(6,2,'Normalisasi & Optimasi','1NF, 2NF, 3NF, BCNF, indexing, dan explain query untuk optimasi.',NULL,NULL,3,'2026-05-30 06:18:28'),(7,3,'OOP PHP: Class & Object','Encapsulation, inheritance, polymorphism, dan abstract class di PHP.',NULL,NULL,1,'2026-05-30 06:18:28'),(8,3,'Framework MVC Laravel','Routing, controller, model, view, migration, dan eloquent ORM.',NULL,NULL,2,'2026-05-30 06:18:28'),(9,3,'REST API dengan PHP','Membuat RESTful API, format JSON, autentikasi token, dan dokumentasi API.',NULL,NULL,3,'2026-05-30 06:18:28'),(10,4,'Entity Relationship Diagram','Entitas, atribut, relasi, kardinalitas, dan konversi ERD ke tabel.',NULL,NULL,1,'2026-05-30 06:18:28'),(11,4,'Stored Procedure & Trigger','Membuat prosedur tersimpan, fungsi, dan trigger di MySQL.',NULL,NULL,2,'2026-05-30 06:18:28'),(12,4,'Backup & Recovery','mysqldump, restore database, dan strategi backup database produksi.',NULL,NULL,3,'2026-05-30 06:18:28'),(13,5,'Model OSI 7 Layer','Penjelasan tiap layer OSI: Physical, Data Link, Network, Transport, Session, Presentation, Application.',NULL,NULL,1,'2026-05-30 06:18:28'),(14,5,'TCP/IP & Subnetting','Protokol TCP/IP, pengalamatan IPv4, CIDR, dan perhitungan subnet.',NULL,NULL,2,'2026-05-30 06:18:28'),(15,5,'Konfigurasi Router & Switch','VLAN, routing statis, routing dinamis (OSPF, RIP), dan konfigurasi via CLI.',NULL,NULL,3,'2026-05-30 06:18:28'),(16,6,'Pengenalan Linux & CLI','Distribusi Linux, navigasi direktori, manajemen file, dan permission.',NULL,NULL,1,'2026-05-30 06:18:28'),(17,6,'Manajemen Proses & Servis','ps, kill, systemctl, crontab, dan monitoring sistem dengan top/htop.',NULL,NULL,2,'2026-05-30 06:18:28'),(18,6,'Shell Scripting Bash','Variabel, kondisi, loop, fungsi, dan skrip otomatisasi dengan bash.',NULL,NULL,3,'2026-05-30 06:18:28'),(19,7,'Android Studio & Struktur Proyek','Setup environment, struktur proyek Android, AndroidManifest, dan Gradle.',NULL,NULL,1,'2026-05-30 06:18:28'),(20,7,'Activity, Fragment & Intent','Siklus hidup Activity, Fragment, dan komunikasi antar komponen via Intent.',NULL,NULL,2,'2026-05-30 06:18:28'),(21,7,'RecyclerView & Retrofit','Menampilkan data list dengan RecyclerView dan konsumsi REST API dengan Retrofit.',NULL,NULL,3,'2026-05-30 06:18:28'),(22,8,'Pengenalan Machine Learning','Supervised vs unsupervised learning, dataset, fitur, dan label.',NULL,NULL,1,'2026-05-30 06:18:28'),(23,8,'Regresi Linear & Logistik','Implementasi regresi linear dan logistik menggunakan scikit-learn.',NULL,NULL,2,'2026-05-30 06:18:28'),(24,8,'Klasifikasi: KNN & Decision Tree','Algoritma KNN, pohon keputusan, dan evaluasi model dengan confusion matrix.',NULL,NULL,3,'2026-05-30 06:18:28');
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dosen','mahasiswa') COLLATE utf8mb4_unicode_ci DEFAULT 'mahasiswa',
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default.jpg',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@example.com','$2y$12$25sliOlSg/CfNi8LNHbFTOWoe4l.FWoE7ji3U519iDgPfJzrJEMkW','admin','default.jpg','2026-05-25 08:58:11'),(3,'Dr. Budi Santoso','dosen@example.com','$2y$12$3A5SEzDqc5I19KKXR9/KjOWDr/nEEJBxLBXCgg3aLAAl.NFRuVBve','dosen','default.jpg','2026-05-25 09:02:38'),(4,'Andi Mahasiswa','mahasiswa@example.com','$2y$12$OShvlrwiJWAB4W.RGEpJu.WEQ8JK547BenrYV9w.yxlb83OlEezGm','mahasiswa','default.jpg','2026-05-25 09:02:38'),(5,'Dr. Sari Dewi','sari@example.com','$2y$10$2L/CLX.mALC/RnG6x1tXn.zw4cpHxojdTSmzzWb9o93emSO32Fhh.','dosen','default.jpg','2026-05-30 06:18:28'),(6,'Dr. Hendra Gunawan','hendra@example.com','$2y$10$2L/CLX.mALC/RnG6x1tXn.zw4cpHxojdTSmzzWb9o93emSO32Fhh.','dosen','default.jpg','2026-05-30 06:18:28'),(7,'Dr. Maya Putri','maya@example.com','$2y$10$2L/CLX.mALC/RnG6x1tXn.zw4cpHxojdTSmzzWb9o93emSO32Fhh.','dosen','default.jpg','2026-05-30 06:18:28'),(8,'Budi Prasetyo','budi@example.com','$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW','mahasiswa','default.jpg','2026-05-30 06:18:28'),(9,'Citra Lestari','citra@example.com','$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW','mahasiswa','default.jpg','2026-05-30 06:18:28'),(10,'Dian Permata','dian@example.com','$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW','mahasiswa','default.jpg','2026-05-30 06:18:28'),(11,'Eko Santoso','eko@example.com','$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW','mahasiswa','default.jpg','2026-05-30 06:18:28'),(12,'Fina Rahmawati','fina@example.com','$2y$10$p0U5nfIDkyNuNho6pdDlsuzW1h2KziLYbB8kuQ8/vKRVn9r1TbSoW','mahasiswa','default.jpg','2026-05-30 06:18:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_webprogramming'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-30 15:08:10
