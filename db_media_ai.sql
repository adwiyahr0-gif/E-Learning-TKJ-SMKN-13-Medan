-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2026 at 04:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_media_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--
-- Error reading structure for table db_media_ai.cache: #1932 - Table &#039;db_media_ai.cache&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.cache: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`cache`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--
-- Error reading structure for table db_media_ai.cache_locks: #1932 - Table &#039;db_media_ai.cache_locks&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.cache_locks: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`cache_locks`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
-- Error reading structure for table db_media_ai.failed_jobs: #1932 - Table &#039;db_media_ai.failed_jobs&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.failed_jobs: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`failed_jobs`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--
-- Error reading structure for table db_media_ai.jobs: #1932 - Table &#039;db_media_ai.jobs&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.jobs: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`jobs`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--
-- Error reading structure for table db_media_ai.job_batches: #1932 - Table &#039;db_media_ai.job_batches&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.job_batches: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`job_batches`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `materis`
--

CREATE TABLE `materis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materis`
--

INSERT INTO `materis` (`id`, `judul`, `deskripsi`, `file_path`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'ngoding', 'buatkan lah satu program dan baca materi tersebut', 'materi/92MdaFlRaMHS9qcy12LBYUxPyjoxX0wzAxtQPOEo.pdf', 5, '2026-10-17 20:36:47', '2026-10-17 20:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--
-- Error reading structure for table db_media_ai.password_reset_tokens: #1932 - Table &#039;db_media_ai.password_reset_tokens&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.password_reset_tokens: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`password_reset_tokens`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--
-- Error reading structure for table db_media_ai.quiz_results: #1932 - Table &#039;db_media_ai.quiz_results&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.quiz_results: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`quiz_results`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--
-- Error reading structure for table db_media_ai.sessions: #1932 - Table &#039;db_media_ai.sessions&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.sessions: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`sessions`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `soals`
--

CREATE TABLE `soals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(20) NOT NULL DEFAULT 'pilihan_ganda',
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) DEFAULT NULL,
  `opsi_b` varchar(255) DEFAULT NULL,
  `opsi_c` varchar(255) DEFAULT NULL,
  `opsi_d` varchar(255) DEFAULT NULL,
  `jawaban_benar` char(1) DEFAULT NULL,
  `kunci_essay` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tanya_jawab_ais`
--
-- Error reading structure for table db_media_ai.tanya_jawab_ais: #1932 - Table &#039;db_media_ai.tanya_jawab_ais&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.tanya_jawab_ais: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`tanya_jawab_ais`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Error reading structure for table db_media_ai.users: #1932 - Table &#039;db_media_ai.users&#039; doesn&#039;t exist in engine
-- Error reading data for table db_media_ai.users: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_media_ai`.`users`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis` varchar(20) NOT NULL DEFAULT 'youtube',
  `url` varchar(500) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materis`
--
ALTER TABLE `materis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materis_user_id_foreign` (`user_id`);

--
-- Indexes for table `soals`
--
ALTER TABLE `soals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soals_tipe_index` (`tipe`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materis`
--
ALTER TABLE `materis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `soals`
--
ALTER TABLE `soals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
