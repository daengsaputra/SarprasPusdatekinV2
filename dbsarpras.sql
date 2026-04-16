-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260218.e704c8118e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 12, 2026 at 03:51 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsarpras`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `kind` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'loanable',
  `quantity_total` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity_available` int UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bast_document_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bast_photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `code`, `name`, `category`, `description`, `kind`, `quantity_total`, `quantity_available`, `status`, `photo`, `bast_document_path`, `bast_photo_path`, `created_at`, `updated_at`) VALUES
(237, 'AV-01', 'AVER PTZ + AUDIO', 'PTZ Camera', 'Rusak', 'loanable', 1, 0, 'active', 'assets/PmfqSIczx7iDBWl0R14W1ibxiPLvyIBTKBElEic0.png', 'assets/bast/WJwatdO2xV3tywTR65srSwwgmrf7rLW4cd17mbxz.pdf', NULL, '2026-03-04 15:28:34', '2026-03-07 15:12:24'),
(238, 'AV-02', 'AVER PTZ + AUDIO', 'PTZ Camera', '-', 'loanable', 1, 0, 'active', 'AV-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 17:04:32'),
(239, 'AV-03', 'AVER PTZ + AUDIO', 'PTZ Camera', 'Rusak', 'loanable', 1, 0, 'active', 'AV-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-11 02:36:16'),
(240, 'AV-04', 'AVER PTZ + AUDIO', 'PTZ Camera', '-', 'loanable', 1, 0, 'active', 'AV-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 17:10:27'),
(241, 'BAT-01', 'Baterai Kamera A', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BAT-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 17:51:05'),
(242, 'BAT-02', 'Baterai Kamera B', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BAT-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 20:45:30'),
(243, 'BAT-03', 'Baterai Kamera C', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BAT-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 20:45:30'),
(244, 'BAT-04', 'Baterai Kamera R', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BAT-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 20:45:30'),
(245, 'BCS-00', 'Batterai Camcorder Sony', 'Baterai', '-', 'loanable', 1, 1, 'active', 'BCS-00.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(246, 'BCS-01', 'Batterai Camcorder Sony', 'Baterai', '-', 'loanable', 1, 1, 'active', 'BCS-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(247, 'BCS-02', 'Batterai Camcorder Sony', 'Baterai', '-', 'loanable', 1, 1, 'active', 'BCS-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(248, 'BCS-03', 'Batterai Camcorder Sony', 'Baterai', '-', 'loanable', 1, 1, 'active', 'BCS-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(249, 'BCS-04', 'Batterai Camcorder Sony', 'Baterai', '-', 'loanable', 1, 1, 'active', 'BCS-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(250, 'BCS-05', 'Batterai Camcorder Sony', 'Baterai', '-', 'loanable', 1, 1, 'active', 'BCS-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(251, 'BM-01', 'Blackmagic HyperDeck Studio HD', NULL, '-', 'loanable', 1, 1, 'active', 'BM-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(252, 'BM-02', 'Blackmagic Video Assist 5\" 12G', NULL, '-', 'loanable', 1, 1, 'active', 'BM-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(253, 'BP-01', 'Batterai Camcorder Panasonic', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BP-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 22:08:45'),
(254, 'BP-02', 'Batterai Camcorder Panasonic', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BP-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 22:08:45'),
(255, 'BP-03', 'Batterai Camcorder Panasonic', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BP-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-07 17:58:14'),
(256, 'BP-04', 'Batterai Camcorder Panasonic', 'Baterai', '-', 'loanable', 1, 0, 'active', 'BP-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-11 02:36:16'),
(257, 'C-01', 'Sony NX5R', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'C-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(258, 'C-02', 'Sony NX5R', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'C-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(259, 'C-03', 'Sony NX5R', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'C-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(260, 'CL-01', 'CLIP ON SENNHEISER G4', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'CL-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(261, 'CL-02', 'CLIP ON SENNHEISER G4', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'CL-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(262, 'CL-03', 'CLIP-ON - SENNHEISER EW 112-P', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'CL-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(263, 'CL-04', 'CLIP-ON - SENNHEISER EW 112-P', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'CL-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(264, 'DJ-01', 'DJI Stabilizer', 'Stabilizer Video', '-', 'loanable', 1, 1, 'active', 'DJ-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(265, 'E-01', 'Elgato Hd 60 S + Video Capture', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'E-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(266, 'GS-01', 'Green Screen', 'Green Screen', '-', 'loanable', 1, 1, 'active', 'GS-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(267, 'GS-02', 'Green Screen', 'Green Screen', '-', 'loanable', 1, 1, 'active', 'GS-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(268, 'HC-01', 'Hdmi Video Capture (silver)', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'HC-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(269, 'HC-02', 'Hdmi Video Capture (silver)', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'HC-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(270, 'HC-03', 'Hdmi Video Capture (silver)', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'HC-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(271, 'HC-04', 'Hdmi Video Capture (hitam)', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'HC-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(272, 'HD-01', 'Kabel HDMI Pendek', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(273, 'HD-02', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(274, 'HD-03', 'Kabel HDMI Pendek', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(275, 'HD-04', 'Kabel HDMI Pendek', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(276, 'HD-05', 'Kabel HDMI Pendek', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(277, 'HD-06', 'Kabel HDMI', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(278, 'HD-07', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(279, 'HD-08', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-08.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(280, 'HD-09', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-09.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(281, 'HD-10', 'Kabel HDMI Panjang (20 M)', 'Kabel', 'Ukuran 20 Meter', 'loanable', 1, 1, 'active', 'HD-10.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(282, 'HD-11', 'Kabel HDMI (10 M)', 'Kabel', 'Ukuran 10 Meter', 'loanable', 1, 1, 'active', 'HD-11.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(283, 'HD-12', 'Kabel HDMI (10 M)', 'Kabel', 'Ukuran 10 Meter', 'loanable', 1, 1, 'active', 'HD-12.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(284, 'HD-13', 'Kabel HDMI (10 M)', 'Kabel', 'Ukuran 10 Meter', 'loanable', 1, 1, 'active', 'HD-13.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(285, 'HD-14', 'Kabel HDMI (2 M)', 'Kabel', 'Ukuran 2 Meter', 'loanable', 1, 1, 'active', 'HD-14.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(286, 'HD-15', 'Kabel HDMI (2 M)', 'Kabel', 'Ukuran 2 Meter', 'loanable', 1, 1, 'active', 'HD-15.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(287, 'HD-16', 'Kabel HDMI Pendek', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-16.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(288, 'HD-17', 'Kabel HDMI Pendek', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-17.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(289, 'HD-18', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-18.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(290, 'HD-19', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-19.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(291, 'HD-20', 'Kabel HDMI Panjang', 'Kabel', '-', 'loanable', 1, 1, 'active', 'HD-20.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(292, 'HDD B1', 'Hardisk Berkas', 'HDD / SSD', 'New', 'loanable', 1, 1, 'active', 'HDD B1.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(293, 'HDD F1', 'Hardisk Foto 1', 'HDD / SSD', 'New', 'loanable', 1, 1, 'active', 'HDD F1.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(294, 'HDD V1', 'Hardisk Video 1', 'HDD / SSD', 'New', 'loanable', 1, 1, 'active', 'HDD V1.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(295, 'HDD V2', 'Hardisk Video 2', 'HDD / SSD', 'New', 'loanable', 1, 1, 'active', 'HDD V2.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(296, 'HE-01', 'HEADPHONE AUDIO TECHNICA', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'HE-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(297, 'HE-02', 'HEADPHONE AUDIO TECHNICA', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'HE-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(298, 'HE-03', 'HEADPHONE AUDIO TECHNICA', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'HE-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(299, 'HE-04', 'HEADPHONE AUDIO TECHNICA', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'HE-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(300, 'HL-01', 'Hollyland Wireless Video', 'Video Wireless', '-', 'loanable', 1, 1, 'active', 'HL-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(301, 'HL-02', 'Hollyland Wireless Video', 'Video Wireless', '-', 'loanable', 1, 1, 'active', 'HL-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(302, 'IC-01', 'Hollyland Solidcom C1-8S Full-', 'Intercom', '-', 'loanable', 1, 1, 'active', 'IC-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(303, 'J5-01', 'J5 Video Card', 'Video Capture ', 'sudah BAP Umum', 'loanable', 1, 1, 'active', 'J5-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(304, 'J5-02', 'J5 Video Card', 'Video Capture ', 'sudah BAP Umum', 'loanable', 1, 1, 'active', 'J5-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(305, 'K-01', 'Mirrorless - CanonEOS R Body O', 'Kamera', '-', 'loanable', 1, 1, 'active', 'K-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(306, 'K-02', 'Mirrorless - CanonEOS R Body O', 'Kamera', '-', 'loanable', 1, 1, 'active', 'K-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(307, 'K-03', 'DSLR - Canon 80D', 'Kamera', 'sudah BAP Umum', 'loanable', 1, 1, 'active', 'K-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(308, 'K-04', 'DSLR - Canon 6D', 'Kamera', 'sudah BAP Umum', 'loanable', 1, 1, 'active', 'K-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(309, 'K-05', 'Mirrorless - Sony A7', 'Kamera', 'sudah BAP Umum', 'loanable', 1, 1, 'active', 'K-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(310, 'K-06', 'Mirrorless - Sony RX10', 'Kamera', '-', 'loanable', 1, 1, 'active', 'K-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(311, 'KSDI-01', 'Kabel SDI', 'Kabel', '-', 'loanable', 1, 1, 'active', 'KSDI-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(312, 'KSDI-02', 'Kabel SDI', 'Kabel', '-', 'loanable', 1, 1, 'active', 'KSDI-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(313, 'KSDI-03', 'Kabel SDI', 'Kabel', '-', 'loanable', 1, 1, 'active', 'KSDI-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(314, 'KSDI-04', 'Kabel SDI', 'Kabel', '-', 'loanable', 1, 1, 'active', 'KSDI-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(315, 'LAN-01', 'Converter USB to LAN', 'Converter', '-', 'loanable', 1, 1, 'active', 'LAN-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(316, 'LD-01', 'Speaker LD', 'Speaker', '-', 'loanable', 1, 1, 'active', 'LD-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(317, 'LD-02', 'Speaker LD', 'Speaker', '-', 'loanable', 1, 1, 'active', 'LD-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(318, 'LENS-01', 'Lensa EF 16-35mm f2.8 L III US', 'Lensa', '-', 'loanable', 1, 1, 'active', 'LENS-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(319, 'LENS-02', 'Lensa EF 70-200mm f/2.8 L IS I', 'Lensa', '-', 'loanable', 1, 1, 'active', 'LENS-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(320, 'LENS-03', 'Lensa EF 70-200mm f/2.8 L IS I', 'Lensa', '-', 'loanable', 1, 1, 'active', 'LENS-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(321, 'LENS-04', 'Lensa EF 70-200mm f2.8 LU (Can', 'Lensa', '-', 'loanable', 1, 1, 'active', 'LENS-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(322, 'LENS-05', 'Lensa 70 – 200 (Sony)', 'Lensa', '-', 'loanable', 1, 1, 'active', 'LENS-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(323, 'LENS-06', 'Lensa 20MM (Sony)', 'Lensa', '-', 'loanable', 1, 1, 'active', 'LENS-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(324, 'LEX-01', 'SD Card Lexar', 'SD Card', '-', 'loanable', 1, 1, 'active', 'LEX-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(325, 'LEX-02', 'SD Card Lexar', 'SD Card', '-', 'loanable', 1, 1, 'active', 'LEX-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(326, 'LG-01', 'Lighting VILTROX', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(327, 'LG-02', 'Lighting VILTROX', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(328, 'LG-03', 'Lighting VILTROX', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(329, 'LG-04', 'Lighting VILTROX', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(330, 'LG-05', 'Lighting GODOX SK400II', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(331, 'LG-06', 'Lighting GODOX SK400II', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(332, 'LG-07', 'LED Portable', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(333, 'LG-08', 'LED Portable', 'Lighting', '-', 'loanable', 1, 1, 'active', 'LG-08.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(334, 'MA-01', 'Kabel Mic/Audio (DSL)', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MA-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(335, 'MA-02', 'Kabel Mic/Audio (DSL)', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MA-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(336, 'MA-03', 'Kabel Mic/Audio (DSL)', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MA-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(337, 'MA-04', 'Kabel Mic/Audio (DSL)', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MA-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(338, 'MA-05', 'Kabel Mic/Audio (DSL)', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MA-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(339, 'MC-01', 'MIC SENNHEISER E845 S', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MC-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(340, 'MC-02', 'MIC SENNHEISER E845 S', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MC-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(341, 'ME-01', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(342, 'ME-02', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(343, 'ME-03', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(344, 'ME-04', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(345, 'ME-05', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(346, 'ME-06', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(347, 'ME-07', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(348, 'ME-08', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-08.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(349, 'ME-09', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-09.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(350, 'ME-10', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-10.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(351, 'ME-11', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-11.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(352, 'ME-12', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-12.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(353, 'ME-13', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-13.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(354, 'ME-14', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-14.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(355, 'ME-15', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-15.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(356, 'ME-16', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-16.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(357, 'ME-17', 'Memori Kamera', 'Memory', '-', 'loanable', 1, 1, 'active', 'ME-17.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(358, 'MIC-01', 'MIC SHURE SM7B', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MIC-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(359, 'MIC-02', 'MIC SHURE SM7B', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MIC-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(360, 'MIC-03', 'MIC SHURE SM7B', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MIC-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(361, 'MIC-04', 'MIC SHURE SM7B', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MIC-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(362, 'MTP-01', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(363, 'MTP-02', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(364, 'MTP-03', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(365, 'MTP-04', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(366, 'MTP-05', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(367, 'MTP-06', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(368, 'MTP-07', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(369, 'MTP-08', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-08.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(370, 'MTP-09', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-09.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(371, 'MTP-10', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-10.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(372, 'MTP-11', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-11.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(373, 'MTP-12', 'Mounting Tripod Libec', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-12.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(374, 'MTP-13', 'Mounting Tripod Excel', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-13.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(375, 'MTP-14', 'Mounting Tripod Excel', 'Mounting Tripod', '-', 'loanable', 1, 1, 'active', 'MTP-14.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(376, 'Mux- 01', 'Muxlab PTZ Camera SKU: 500790-', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'Mux- 01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(377, 'Mux- 02', 'Muxlab PTZ Camera SKU: 500790-', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'Mux- 02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(378, 'Mux- 03', 'Muxlab PTZ Camera SKU: 500790-', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'Mux- 03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(379, 'Mux- 04', 'Muxlab PTZ Camera SKU: 500790-', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'Mux- 04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(380, 'MX-01', 'MIXER AUDIO 6 CHANNEL \"ASHLEY', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MX-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(381, 'MX-02', 'MIXER AUDIO 6 CHANNEL \"ASHLEY', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MX-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(382, 'MX-03', 'MIXER AUDIO 8 CHANNEL \"ZOOM\"', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'MX-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(383, 'N-01', 'NetGear', 'Switch', '-', 'loanable', 1, 1, 'active', 'N-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(384, 'N-02', 'NetGear', 'Switch', '-', 'loanable', 1, 1, 'active', 'N-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(385, 'N-03', 'NetGear', 'Switch', '-', 'loanable', 1, 1, 'active', 'N-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(386, 'OR-01', 'ORBIT MODEM INTERNET', 'Modem', '-', 'loanable', 1, 1, 'active', 'OR-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(387, 'P-01', 'Panasonic HC-X2000', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'P-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(388, 'P-02', 'Panasonic HC-X2001', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'P-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(389, 'P-03', 'Panasonic HC-X2002', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'P-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(390, 'P-04', 'Panasonic HC-X2003', 'Camcorder', '-', 'loanable', 1, 1, 'active', 'P-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(391, 'PRO-01', 'Proyektor', 'Proyektor', '-', 'loanable', 1, 1, 'active', 'PRO-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(392, 'PRO-02', 'Proyektor', 'Proyektor', '-', 'loanable', 1, 1, 'active', 'PRO-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(393, 'PRO-03', 'Proyektor', 'Proyektor', '-', 'loanable', 1, 1, 'active', 'PRO-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(394, 'S-01', 'SONY VOICE RECORDER', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'S-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(395, 'S-02', 'SONY VOICE RECORDER', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'S-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(396, 'S-03', 'SONY VOICE RECORDER', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'S-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(397, 'SC-01', 'Focusrite Scarlet 2i2 3rd Gen', 'Sound Card', '-', 'loanable', 1, 1, 'active', 'SC-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(398, 'SC-02', 'Focusrite Scarlet 2i2 3rd Gen', 'Sound Card', '-', 'loanable', 1, 1, 'active', 'SC-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(399, 'SC-03', 'Vention Audio Sound Card', 'Sound Card', 'Rusak', 'loanable', 1, 1, 'active', 'SC-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(400, 'SC-04', 'Vention Audio Sound Card', 'Sound Card', '-', 'loanable', 1, 1, 'active', 'SC-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(401, 'SC-05', 'U GREEN Sound Card', 'Sound Card', '-', 'loanable', 1, 1, 'active', 'SC-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(402, 'SC-06', 'U GREEN Sound Card', 'Sound Card', '-', 'loanable', 1, 1, 'active', 'SC-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(403, 'SC-07', 'U GREEN Sound Card', 'Sound Card', '-', 'loanable', 1, 1, 'active', 'SC-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(404, 'SDI-01', 'Magewell USB Capture SDI Gen 2', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'SDI-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(405, 'SDI-02', 'Ezcap262 - USB 3.0 SDI Capture', 'Video Capture ', '-', 'loanable', 1, 1, 'active', 'SDI-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(406, 'SHDD-01', 'Seagate Harddisk 2 TB', 'HDD / SSD', '-', 'loanable', 1, 1, 'active', 'SHDD-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(407, 'SHDD-02', 'Seagate Harddisk 2 TB', 'HDD / SSD', '-', 'loanable', 1, 1, 'active', 'SHDD-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(408, 'SHDD-03', 'Seagate Harddisk 2 TB', 'HDD / SSD', '-', 'loanable', 1, 1, 'active', 'SHDD-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(409, 'SHDD-04', 'Seagate Harddisk 2 TB', 'HDD / SSD', '-', 'loanable', 1, 1, 'active', 'SHDD-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(410, 'SHDD-05', 'Seagate Harddisk 1 TB', 'HDD / SSD', '-', 'loanable', 1, 1, 'active', 'SHDD-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(411, 'SMC-01', 'Tripod ( Stand Arm Mic Shure)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'SMC-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(412, 'SMC-02', 'Tripod ( Stand Arm Mic Shure)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'SMC-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(413, 'SMC-03', 'Tripod ( Stand Arm Mic Shure)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'SMC-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(414, 'SMC-04', 'Tripod ( Stand Arm Mic Shure)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'SMC-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(415, 'SP-01', 'Spliter HDMI 4k', 'Splitter HDMI', '-', 'loanable', 1, 1, 'active', 'SP-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(416, 'SP-02', 'Spliter HDMI 1080', 'Splitter HDMI', '-', 'loanable', 1, 1, 'active', 'SP-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(417, 'SPE-01', 'Speaker JBL', 'Speaker', '-', 'loanable', 1, 1, 'active', 'SPE-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(418, 'SW-01', 'Switcher DATA VIDEO', 'Video Switcher', '-', 'loanable', 1, 1, 'active', 'SW-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(419, 'SW-02', 'Swithcer FEEL WORLD', 'Video Switcher', '-', 'loanable', 1, 1, 'active', 'SW-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(420, 'SW-03', 'VMOX LYRA Ultymate', 'Video Switcher', '-', 'loanable', 1, 1, 'active', 'SW-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(421, 'TG-01', 'Tripod Green Screen', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TG-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(422, 'TG-02', 'Tripod Green Screen', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TG-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(423, 'TJBL-01', 'Tripod JBL', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TJBL-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(424, 'TJBL-02', 'Tripod JBL', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TJBL-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(425, 'TL-01', 'Tripod Lighting Viltrox', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TL-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(426, 'TL-02', 'Tripod Lighting Viltrox', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TL-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(427, 'TL-03', 'Tripod Lighting Viltrox', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TL-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(428, 'TL-04', 'Tripod Lighting Viltrox', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TL-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(429, 'TL-05', 'Tripod Lighting Godox', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TL-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(430, 'TL-06', 'Tripod Lighting Godox', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TL-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(431, 'TMM-01', 'Tripod (Stand Mic Meja)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TMM-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(432, 'TMM-02', 'Tripod (Stand Mic Meja)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TMM-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(433, 'TMM-03', 'Tripod (Stand Mic Meja)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TMM-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(434, 'TMM-04', 'Tripod (Stand Mic Meja)', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TMM-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(435, 'TP-01', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(436, 'TP-02', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(437, 'TP-03', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(438, 'TP-04', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(439, 'TP-05', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(440, 'TP-06', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(441, 'TP-07', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(442, 'TP-08', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-08.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(443, 'TP-09', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-09.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(444, 'TP-10', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-10.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(445, 'TP-11', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-11.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(446, 'TP-12', 'Tripod Libec type 650EX', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-12.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(447, 'TP-13', 'Tripod Excel', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-13.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(448, 'TP-14', 'Tripod Excel', 'Tripod ', '-', 'loanable', 1, 1, 'active', 'TP-14.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(449, 'TPR-01', 'Teleprompter dan Tripod', 'Teleprompter', '-', 'loanable', 1, 1, 'active', 'TPR-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(450, 'TS-01', 'Tas Kamera (LowePro)', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(451, 'TS-02', 'Tas Camcorder Besar Backpack', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(452, 'TS-03', 'Tas Camcorder Sedang', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(453, 'TS-04', 'TAS TROLLEY “GODOX”', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-04.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(454, 'TS-05', 'TAS TROLLEY “GODOX”', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-05.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(455, 'TS-06', 'TAS BACKPACK “QUARZELL”', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-06.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(456, 'TS-07', 'TAS CAMCORDER “MAXX”', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-07.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(457, 'TS-08', 'TAS CAMCORDER “MAXX”', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-08.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(458, 'TS-09', 'TAS CAMCORDER “MAXX”', 'Tas Kamera', '-', 'loanable', 1, 1, 'active', 'TS-09.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(459, 'VA-01', 'VANNOE', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'VA-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(460, 'VA-02', 'VANNOE', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'VA-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(461, 'VA-03', 'VANNOE', 'PTZ Camera', '-', 'loanable', 1, 1, 'active', 'VA-03.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(462, 'Z-01', 'ZOOM AUDIO RECORDER', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'Z-01.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34'),
(463, 'Z-02', 'ZOOM AUDIO RECORDER', 'AUDIO', '-', 'loanable', 1, 1, 'active', 'Z-02.jpg', NULL, NULL, '2026-03-04 15:28:34', '2026-03-04 15:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint UNSIGNED NOT NULL,
  `batch_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_id` bigint UNSIGNED NOT NULL,
  `borrower_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `borrower_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `quantity_returned` int UNSIGNED NOT NULL DEFAULT '0',
  `loan_date` date NOT NULL,
  `return_date_planned` date DEFAULT NULL,
  `return_date_actual` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'borrowed',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `request_photo_path` text COLLATE utf8mb4_unicode_ci,
  `loan_photo_path` text COLLATE utf8mb4_unicode_ci,
  `loan_photo_paths` json DEFAULT NULL,
  `return_photo_path` text COLLATE utf8mb4_unicode_ci,
  `return_photo_paths` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `batch_code`, `asset_id`, `borrower_name`, `borrower_contact`, `unit`, `activity_name`, `quantity`, `quantity_returned`, `loan_date`, `return_date_planned`, `return_date_actual`, `status`, `notes`, `request_photo_path`, `loan_photo_path`, `loan_photo_paths`, `return_photo_path`, `return_photo_paths`, `created_at`, `updated_at`) VALUES
(4, 'PJ20260305000432', 237, 'Daeng Saputra', '08121212', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 0, '2026-03-05', '2026-03-05', NULL, 'borrowed', NULL, '[\"loan-requests\\/y0buDDY7OPHw8wlWUa5WQEaVgjw7Qswv3rVG2EuX.png\",\"loan-requests\\/pzCsRpQkL2uhxsMQrg11aporr5ICfjPESOwrXf86.png\"]', '[\"loan-proofs\\/uSThDO0lTJfIdxrqH04PU4X0beqh0PHxLMKKvf69.png\",\"loan-proofs\\/t3LS7mWrHEqO8AJFteFDANbBPL77j9G8GbYfKdLn.png\"]', NULL, NULL, NULL, '2026-03-04 17:04:32', '2026-03-04 17:04:32'),
(5, 'PJ20260305000432', 238, 'Daeng Saputra', '08121212', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 0, '2026-03-05', '2026-03-05', NULL, 'borrowed', NULL, '[\"loan-requests\\/y0buDDY7OPHw8wlWUa5WQEaVgjw7Qswv3rVG2EuX.png\",\"loan-requests\\/pzCsRpQkL2uhxsMQrg11aporr5ICfjPESOwrXf86.png\"]', '[\"loan-proofs\\/uSThDO0lTJfIdxrqH04PU4X0beqh0PHxLMKKvf69.png\",\"loan-proofs\\/t3LS7mWrHEqO8AJFteFDANbBPL77j9G8GbYfKdLn.png\"]', NULL, NULL, NULL, '2026-03-04 17:04:32', '2026-03-04 17:04:32'),
(6, 'PJ20260305001027', 239, 'Daeng Saputra', '08121212', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 1, '2026-03-05', '2026-03-05', '2026-03-05', 'returned', NULL, '[\"loan-requests\\/l0sVmBFeJwiTN4gyIjXDeJOm6J52UKUshIY6i3IG.png\",\"loan-requests\\/Lq76aeNmBrPLEGar7OpyOOuXAZD9PeSj2OgO14OW.png\"]', '[\"loan-proofs\\/4Z1S5HjJMxfWpqdXdCYdTKQtIOKgFBEt7MNMpmE5.png\",\"loan-proofs\\/A4xVAX7MmTEE5M0BiXkNZ8dHyPZYEI9A2EJWoZ9T.png\"]', NULL, '[\"loan-returns\\/0eIYfJNBIWhUVJUnb7OCfsywsSJ3ERcgOinJKqOy.png\"]', NULL, '2026-03-04 17:10:27', '2026-03-11 02:23:19'),
(7, 'PJ20260305001027', 240, 'Daeng Saputra', '08121212', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 0, '2026-03-05', '2026-03-05', NULL, 'borrowed', NULL, '[\"loan-requests\\/l0sVmBFeJwiTN4gyIjXDeJOm6J52UKUshIY6i3IG.png\",\"loan-requests\\/Lq76aeNmBrPLEGar7OpyOOuXAZD9PeSj2OgO14OW.png\"]', '[\"loan-proofs\\/4Z1S5HjJMxfWpqdXdCYdTKQtIOKgFBEt7MNMpmE5.png\",\"loan-proofs\\/A4xVAX7MmTEE5M0BiXkNZ8dHyPZYEI9A2EJWoZ9T.png\"]', NULL, NULL, NULL, '2026-03-04 17:10:27', '2026-03-04 17:10:27'),
(8, 'PJ20260305005105', 241, 'cv', 'mas daeng', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'Kegiatan Bali 1', 1, 0, '2026-03-05', '2026-03-25', NULL, 'borrowed', NULL, '[\"loan-requests\\/3aJuNhpyxPyaEaWVpcne4Sd9zVznzmcK1uL7HqWW.png\"]', '[\"loan-proofs\\/uzKbkhafkinPXfxooV69mH7NYDHgl5g8HkU3oPFu.png\"]', NULL, NULL, NULL, '2026-03-04 17:51:05', '2026-03-04 17:51:05'),
(9, 'PJ20260305034530', 242, 'inyut', 'mas daeng', 'Sekretariat Utama', 'Kegiatan Bali 1', 1, 0, '2026-03-05', '2026-03-09', NULL, 'borrowed', NULL, '[\"loan-requests\\/d0vrxxpm9O13xAIWIQmsAnitSSQCt2trvuRtioID.png\"]', '[\"loan-proofs\\/Mg49cBDVVVyr7XTNlmBJpeAvyZkivRaEtPnvA9TG.png\"]', NULL, NULL, NULL, '2026-03-04 20:45:30', '2026-03-04 20:45:30'),
(10, 'PJ20260305034530', 243, 'inyut', 'mas daeng', 'Sekretariat Utama', 'Kegiatan Bali 1', 1, 0, '2026-03-05', '2026-03-09', NULL, 'borrowed', NULL, '[\"loan-requests\\/d0vrxxpm9O13xAIWIQmsAnitSSQCt2trvuRtioID.png\"]', '[\"loan-proofs\\/Mg49cBDVVVyr7XTNlmBJpeAvyZkivRaEtPnvA9TG.png\"]', NULL, NULL, NULL, '2026-03-04 20:45:30', '2026-03-04 20:45:30'),
(11, 'PJ20260305034530', 244, 'inyut', 'mas daeng', 'Sekretariat Utama', 'Kegiatan Bali 1', 1, 0, '2026-03-05', '2026-03-09', NULL, 'borrowed', NULL, '[\"loan-requests\\/d0vrxxpm9O13xAIWIQmsAnitSSQCt2trvuRtioID.png\"]', '[\"loan-proofs\\/Mg49cBDVVVyr7XTNlmBJpeAvyZkivRaEtPnvA9TG.png\"]', NULL, NULL, NULL, '2026-03-04 20:45:30', '2026-03-04 20:45:30'),
(12, 'PJ20260305050845', 253, 'bree', '08121212', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'kegiatan bandung PIP', 1, 0, '2026-03-05', '2026-03-06', NULL, 'borrowed', NULL, '[\"loan-requests\\/5qb4RAxDe4U3Xb6wr7ORYX16tSj0KaeUlnDfpHPB.png\"]', '[\"loan-proofs\\/W03rHxas8YSOemcShnEa8HHn7N7ZvUFmKQvERauP.png\"]', NULL, NULL, NULL, '2026-03-04 22:08:45', '2026-03-04 22:08:45'),
(13, 'PJ20260305050845', 254, 'bree', '08121212', 'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan', 'kegiatan bandung PIP', 1, 0, '2026-03-05', '2026-03-06', NULL, 'borrowed', NULL, '[\"loan-requests\\/5qb4RAxDe4U3Xb6wr7ORYX16tSj0KaeUlnDfpHPB.png\"]', '[\"loan-proofs\\/W03rHxas8YSOemcShnEa8HHn7N7ZvUFmKQvERauP.png\"]', NULL, NULL, NULL, '2026-03-04 22:08:45', '2026-03-04 22:08:45'),
(14, 'PJ20260308005814', 255, 'inyut', '08121212', 'Sekretariat Utama', 'Kegiatan Bali 1', 1, 0, '2026-03-08', '2026-03-19', NULL, 'borrowed', NULL, '[\"loan-requests\\/nwMmAUfWmUyZvQzm7rXAVKGdJL4qMDVFTl45VWo2.png\"]', '[\"loan-proofs\\/ZPrJ5pRou7fFb6B0K8oXDxOlcgauHndNewA41C2u.png\"]', NULL, NULL, NULL, '2026-03-07 17:58:14', '2026-03-07 17:58:14'),
(15, 'PJ20260308012958', 256, 'Daeng Saputra', 'vc', 'Sekretariat Utama', 'kegiatan bandung PIP', 1, 1, '2026-03-08', '2026-03-09', '2026-03-09', 'returned', NULL, '[\"loan-requests\\/BBmYrxLLv3VF7e4ZJRsgm7FYN3yJE8zP4URcY11W.png\"]', '[\"loan-proofs\\/TksNWnqsctZZdqhyE2Glt8kTDYl98j3MgHnXn2FT.png\"]', NULL, '[\"loan-returns\\/C8YV6lzRGmcsmRR1BNscBlMdgkdvwiUzVPTknSHU.png\"]', NULL, '2026-03-07 18:29:58', '2026-03-11 02:18:44'),
(16, 'PJ20260311092024', 256, 'cv', 'vc', 'Sekretariat Utama', 'amanaaab', 1, 1, '2026-03-11', '2026-03-18', '2026-03-18', 'returned', NULL, '[\"loan-requests\\/sUWV6TRrM6YyxbDWQEUWI3WgjjgpQNTDgaisQWIg.png\"]', '[\"loan-proofs\\/jYKH6DcULjwdN7t5UYa70vj6Zi9KOeAIvSCLaROE.png\"]', NULL, '[\"loan-returns\\/vdfHaukASPe0CxM70UJxohvuHbJB9dhJzQZZuEgU.png\"]', NULL, '2026-03-11 02:20:24', '2026-03-11 02:22:59'),
(17, 'PJ20260311093616', 239, 'bree2', '22', 'Deputi Bidang Pengendalian dan Evaluasi', 'Kegiatan Bali 12', 1, 0, '2026-03-11', '2026-03-12', NULL, 'borrowed', NULL, '[\"loan-requests\\/o1ZP8EZvoUshixs6yiJNZU2o5SjOI5JedmgddK7Y.png\",\"loan-requests\\/ah9Iexcioq7aF2Y0639j5bjE4hilu35dXmgxPNMr.png\",\"loan-requests\\/8WdRirAO97zM7F8mVuBXMXPOej1akJ18nRpGBJyr.png\",\"loan-requests\\/HiXZaIAegbja54LsL6kaKFMBmWvvsIZfQC3wakUP.png\",\"loan-requests\\/bXQzFC2ZoCVQLzMP2L7SBgvIC38bHItfsOTrlG2W.png\"]', '[\"loan-proofs\\/1fiLoctlYkPwU4WQRLyKs72bQx3Y2v98UO7l0Exz.png\",\"loan-proofs\\/lLrb7ihuZSC8IW2onU9PukzNl1SbzJq9R7dBYaP7.png\",\"loan-proofs\\/pSWMS7qjEqftLFrrjzKtfdK2rRtLewSp0qfctGWc.png\",\"loan-proofs\\/pqdQHQJ8mm7yBNxYh5I9HI1zCADQRccw1Gz9TUNd.png\",\"loan-proofs\\/OWJk285I3VOGAAOfEzG1DSszhqKlEhqeYowN2UsJ.png\"]', NULL, NULL, NULL, '2026-03-11 02:36:16', '2026-03-11 02:36:16'),
(18, 'PJ20260311093616', 256, 'bree2', '22', 'Deputi Bidang Pengendalian dan Evaluasi', 'Kegiatan Bali 12', 1, 0, '2026-03-11', '2026-03-12', NULL, 'borrowed', NULL, '[\"loan-requests\\/o1ZP8EZvoUshixs6yiJNZU2o5SjOI5JedmgddK7Y.png\",\"loan-requests\\/ah9Iexcioq7aF2Y0639j5bjE4hilu35dXmgxPNMr.png\",\"loan-requests\\/8WdRirAO97zM7F8mVuBXMXPOej1akJ18nRpGBJyr.png\",\"loan-requests\\/HiXZaIAegbja54LsL6kaKFMBmWvvsIZfQC3wakUP.png\",\"loan-requests\\/bXQzFC2ZoCVQLzMP2L7SBgvIC38bHItfsOTrlG2W.png\"]', '[\"loan-proofs\\/1fiLoctlYkPwU4WQRLyKs72bQx3Y2v98UO7l0Exz.png\",\"loan-proofs\\/lLrb7ihuZSC8IW2onU9PukzNl1SbzJq9R7dBYaP7.png\",\"loan-proofs\\/pSWMS7qjEqftLFrrjzKtfdK2rRtLewSp0qfctGWc.png\",\"loan-proofs\\/pqdQHQJ8mm7yBNxYh5I9HI1zCADQRccw1Gz9TUNd.png\",\"loan-proofs\\/OWJk285I3VOGAAOfEzG1DSszhqKlEhqeYowN2UsJ.png\"]', NULL, NULL, NULL, '2026-03-11 02:36:16', '2026-03-11 02:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_12_152557_create_assets_table', 1),
(5, '2025_09_12_152558_create_loans_table', 1),
(6, '2025_09_13_075637_add_unit_to_loans_table', 1),
(7, '2025_09_13_165622_add_batch_code_to_loans_table', 1),
(8, '2025_09_13_201130_add_role_to_users_table', 1),
(9, '2025_09_13_230000_add_photo_to_users_table', 1),
(10, '2025_09_22_000001_add_photo_to_assets_table', 1),
(11, '2025_10_08_000002_add_kind_to_assets_table', 1),
(12, '2025_11_05_011021_add_quantity_returned_to_loans_table', 1),
(13, '2025_11_07_000100_add_activity_name_to_loans_table', 1),
(14, '2025_11_11_110000_add_bast_fields_to_assets_table', 1),
(15, '2025_11_12_000000_create_site_settings_table', 1),
(16, '2025_11_13_000500_add_attachment_columns_to_loans_table', 1),
(17, '2026_02_24_000001_add_loan_photo_paths_to_loans_table', 2),
(18, '2026_02_24_000002_add_return_photo_paths_to_loans_table', 2),
(19, '2026_03_05_000001_normalize_user_roles_to_three_levels', 3),
(20, '2026_03_11_092700_change_attachment_columns_to_text_on_loans_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('daengsaputra41@gmail.com', '$2y$12$0D3HTzXbeqnBaiMEX8QAGux9OjGmYCsFLATalantOdWuCbEdSPDR.', '2026-02-27 08:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(3, 'landing_theme', 'forest', '2026-03-03 03:13:56', '2026-03-07 15:54:59'),
(4, 'landing_video_path', NULL, '2026-03-03 03:13:56', '2026-03-07 18:33:03'),
(5, 'landing_theme_surfaces', '{\"surface1\":\"linear-gradient(140deg, #0b1220 0%, #05060a 55%, #020205 100%)\",\"surface2\":\"rgba(12,19,33,0.92)\",\"surface3\":\"rgba(18,35,64,0.65)\",\"accent\":\"#38bdf8\",\"accentSoft\":\"#dbeafe\",\"text_primary\":\"#e2e8f0\",\"text_secondary\":\"rgba(226, 232, 240, 0.75)\"}', '2026-03-03 03:13:56', '2026-03-03 03:13:56'),
(6, 'dashboard_hero_variant', 'slate', '2026-03-07 14:28:55', '2026-03-07 17:59:30'),
(7, 'admin_page_toggles', '{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true}', '2026-03-07 19:00:16', '2026-03-07 19:17:42'),
(8, 'admin_broadcast_message', NULL, '2026-03-07 19:00:16', '2026-03-07 19:00:16'),
(9, 'admin_menu_audit_log', '[{\"at\":\"2026-03-08 02:17:42\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"normal\",\"changed_keys\":[\"assets_loanable\",\"assets_inventory\",\"loans\",\"reports\",\"users\"],\"role_access_changed\":[],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false},\"toggles_after\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true},\"role_access_before\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true}},\"role_access_after\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true}},\"broadcast_before\":null,\"broadcast_after\":null,\"landing_video_before\":null,\"landing_video_after\":null,\"hero_variant_before\":\"slate\",\"hero_variant_after\":\"slate\"},{\"at\":\"2026-03-08 02:13:43\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"landing_settings\"],\"role_access_changed\":[],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"role_access_before\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"role_access_after\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:13:31\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"maintenance\",\"changed_keys\":[\"assets_loanable\",\"assets_inventory\",\"loans\",\"reports\",\"users\"],\"role_access_changed\":[],\"toggles_before\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"role_access_before\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"role_access_after\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:13:22\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"normal\",\"changed_keys\":[\"assets_loanable\",\"assets_inventory\",\"loans\",\"reports\",\"users\",\"landing_settings\"],\"role_access_changed\":[],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"toggles_after\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"role_access_before\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"role_access_after\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:05:50\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"role_access_before\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"role_access_after\":{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"landing_settings\":{\"peminjam\":false,\"petugas\":false,\"super_admin\":true}},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:03:00\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"landing_settings\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:02:53\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"maintenance\",\"changed_keys\":[\"assets_inventory\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":true,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:01:53\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"assets_inventory\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":true,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:01:12\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"maintenance\",\"changed_keys\":[\"assets_loanable\",\"assets_inventory\",\"loans\",\"reports\",\"users\"],\"toggles_before\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:01:07\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"normal\",\"changed_keys\":[\"reports\",\"users\"],\"toggles_before\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:01:02\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"operasional\",\"changed_keys\":[\"assets_loanable\",\"assets_inventory\",\"loans\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":false,\"users\":false,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:55\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":\"maintenance\",\"changed_keys\":[\"landing_settings\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:46\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"landing_settings\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":false},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:40\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"users\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":false,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:35\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"reports\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":true,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":false,\"users\":true,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:31\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"loans\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":false,\"reports\":true,\"users\":true,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:26\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"assets_inventory\"],\"toggles_before\":{\"assets_loanable\":false,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":false,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null},{\"at\":\"2026-03-08 02:00:16\",\"actor\":\"daeng\",\"actor_email\":\"daengsaputra41@gmail.com\",\"preset\":null,\"changed_keys\":[\"assets_loanable\"],\"toggles_before\":{\"assets_loanable\":true,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"toggles_after\":{\"assets_loanable\":false,\"assets_inventory\":true,\"loans\":true,\"reports\":true,\"users\":true,\"landing_settings\":true},\"broadcast_before\":null,\"broadcast_after\":null}]', '2026-03-07 19:00:16', '2026-03-07 19:17:42'),
(10, 'admin_role_page_access', '{\"assets_loanable\":{\"peminjam\":true,\"petugas\":true,\"super_admin\":true},\"assets_inventory\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"loans\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"reports\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true},\"users\":{\"peminjam\":false,\"petugas\":true,\"super_admin\":true}}', '2026-03-07 19:05:50', '2026-03-07 19:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'daeng', 'daengsaputra41@gmail.com', NULL, '$2y$12$8WhfGzm0vdOnaq8RAEXJRejGQU5fvBKihX24cm6OBmDXVZ3FH.e7i', 'super_admin', NULL, '6VIUzt3sDGuuFi1qjPVOSdrswSdhEFexXlMVKBnvpD9Smj0KjUsolGKFmNFj', '2026-02-19 07:10:19', '2026-03-03 03:13:54'),
(3, 'DaengSaputra', 'bandeg18@gmail.com', NULL, '$2y$12$SNtN/yuaPLIcEa03mJmAIux4cfVTgeBeQhheNy3oIxlWN75AaTn/e', 'petugas', 'avatars/YH7ghGokKWHTyvGWtJc3jxR18BXuSmLJPKqjcd02.jpg', NULL, '2026-02-26 02:07:05', '2026-03-04 22:39:55'),
(4, 'wahyu', 'wahyu@gmail.com', NULL, '$2y$12$YYQKcrbO8QUHyUSyI285wuOrYxLNnAAiC3LyXy3syaoEOuVajhLJG', 'petugas', NULL, NULL, '2026-03-03 02:54:54', '2026-03-03 03:13:55'),
(5, 'naufal', 'naufal@example.com', NULL, '$2y$12$M9LIpP7KFN3yi17HoJqGRuu2sdmwzyj/HQmHsm82R71P5HgXz0Sba', 'petugas', NULL, NULL, '2026-03-03 03:13:54', '2026-03-03 03:13:54'),
(6, 'Pegawai', 'pegawai@example.com', NULL, '$2y$12$MQF3mS4TJaHAKhHqBmVADuRdDbNgDQYvtDuHN5xWqWxaWo176QW72', 'peminjam', NULL, NULL, '2026-03-04 22:29:20', '2026-03-04 22:29:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_code_unique` (`code`),
  ADD KEY `assets_kind_index` (`kind`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_asset_id_foreign` (`asset_id`),
  ADD KEY `loans_batch_code_index` (`batch_code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
