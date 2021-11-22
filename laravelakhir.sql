-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2021 at 11:07 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelakhir`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_transaksis`
--

CREATE TABLE `item_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_lokasi` bigint(20) UNSIGNED NOT NULL,
  `id_kodebarang` bigint(20) UNSIGNED NOT NULL,
  `namaBarang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `um` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_transaksis`
--

INSERT INTO `item_transaksis` (`id`, `bukti`, `id_lokasi`, `id_kodebarang`, `namaBarang`, `um`, `qty`, `tgl_masuk`, `created_at`, `updated_at`) VALUES
(1, 'TAMBAH01', 1, 1, 'TRANSISTOR 54 OHM', 'EA', 20, '2021-11-22 09:51:54', '2021-11-22 02:51:54', '2021-11-22 02:51:54'),
(2, 'TAMBAH02', 1, 1, 'TRANSISTOR 54 OHM', 'EA', 100, '2021-11-23 09:52:02', '2021-11-22 02:52:02', '2021-11-22 02:52:02'),
(3, 'TAMBAH03', 1, 1, 'TRANSISTOR 54 OHM', 'EA', 20, '2021-11-23 09:52:21', '2021-11-22 02:52:21', '2021-11-22 02:52:21'),
(4, 'KURANG01', 1, 1, 'TRANSISTOR 54 OHM', 'EA', 115, '2021-11-24 09:52:35', '2021-11-22 02:52:35', '2021-11-22 02:52:35'),
(5, 'TAMBAH04', 2, 1, 'TRANSISTOR 54 OHM', 'EA', 100, '2021-11-22 09:53:14', '2021-11-22 02:53:14', '2021-11-22 02:53:14'),
(6, 'TAMBAH05', 2, 1, 'TRANSISTOR 54 OHM', 'EA', 20, '2021-11-23 09:53:24', '2021-11-22 02:53:24', '2021-11-22 02:53:24'),
(7, 'KURANG02', 2, 1, 'TRANSISTOR 54 OHM', 'EA', 90, '2021-11-24 09:53:46', '2021-11-22 02:53:46', '2021-11-22 02:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `masterhistories`
--

CREATE TABLE `masterhistories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_trans` date NOT NULL,
  `jam` time NOT NULL,
  `id_lokasi` bigint(20) UNSIGNED NOT NULL,
  `id_kodebarang` bigint(20) UNSIGNED NOT NULL,
  `qty` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `masterhistories`
--

INSERT INTO `masterhistories` (`id`, `bukti`, `tgl_trans`, `jam`, `id_lokasi`, `id_kodebarang`, `qty`, `tgl_masuk`, `program`, `userid`, `created_at`, `updated_at`) VALUES
(1, 'TAMBAH01', '2021-11-22', '09:51:00', 1, 1, '20', '2021-11-22 09:51:54', 'RECEIPT', 'samuelindraw', '2021-11-22 02:51:54', '2021-11-22 02:51:54'),
(2, 'TAMBAH02', '2021-11-22', '09:52:00', 1, 1, '100', '2021-11-23 09:52:02', 'RECEIPT', 'samuelindraw', '2021-11-22 02:52:02', '2021-11-22 02:52:02'),
(3, 'TAMBAH03', '2021-11-22', '09:52:00', 1, 1, '20', '2021-11-23 09:52:21', 'RECEIPT', 'samuelindraw', '2021-11-22 02:52:21', '2021-11-22 02:52:21'),
(4, 'KURANG01', '2021-11-24', '09:52:00', 1, 1, '-20', '2021-11-22 09:51:54', 'ISSUE', 'samuelindraw', '2021-11-22 02:52:35', '2021-11-22 02:52:35'),
(5, 'KURANG01', '2021-11-24', '09:52:00', 1, 1, '-95', '2021-11-23 09:52:02', 'ISSUE', 'samuelindraw', '2021-11-22 02:52:35', '2021-11-22 02:52:35'),
(6, 'TAMBAH04', '2021-11-22', '09:53:00', 2, 1, '100', '2021-11-22 09:53:14', 'RECEIPT', 'samuelindraw', '2021-11-22 02:53:14', '2021-11-22 02:53:14'),
(7, 'TAMBAH05', '2021-11-22', '09:53:00', 2, 1, '20', '2021-11-23 09:53:24', 'RECEIPT', 'samuelindraw', '2021-11-22 02:53:24', '2021-11-22 02:53:24'),
(8, 'KURANG02', '2021-11-24', '09:53:00', 2, 1, '-0', '2021-11-22 09:51:54', 'ISSUE', 'samuelindraw', '2021-11-22 02:53:46', '2021-11-22 02:53:46'),
(9, 'KURANG02', '2021-11-24', '09:53:00', 2, 1, '-90', '2021-11-22 09:53:14', 'ISSUE', 'samuelindraw', '2021-11-22 02:53:46', '2021-11-22 02:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `master_barangs`
--

CREATE TABLE `master_barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kodeBarang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaBarang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `um` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_barangs`
--

INSERT INTO `master_barangs` (`id`, `kodeBarang`, `namaBarang`, `um`, `created_at`, `updated_at`) VALUES
(1, 'AA-000001-00A', 'TRANSISTOR 54 OHM', 'EA', '2021-11-22 02:51:29', '2021-11-22 02:51:29'),
(2, 'AA-000002-00A', 'TRANSISTOR 52 OHM', 'EA', '2021-11-22 02:51:35', '2021-11-22 02:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `master_lokasis`
--

CREATE TABLE `master_lokasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kodeLokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namaLokasi` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_lokasis`
--

INSERT INTO `master_lokasis` (`id`, `kodeLokasi`, `namaLokasi`, `created_at`, `updated_at`) VALUES
(1, 'HIT', 'polytron', '2021-11-22 02:51:39', '2021-11-22 02:51:39'),
(2, 'SYG', 'sayung', '2021-11-22 02:51:43', '2021-11-22 02:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `master_stocks`
--

CREATE TABLE `master_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_lokasi` bigint(20) UNSIGNED NOT NULL,
  `id_kodebarang` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_stocks`
--

INSERT INTO `master_stocks` (`id`, `id_lokasi`, `id_kodebarang`, `qty`, `tgl_masuk`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '2021-11-22 09:51:54', '2021-11-22 02:51:54', '2021-11-22 02:52:35'),
(2, 1, 1, 5, '2021-11-23 09:52:02', '2021-11-22 02:52:02', '2021-11-22 02:52:35'),
(3, 1, 1, 20, '2021-11-23 09:52:21', '2021-11-22 02:52:21', '2021-11-22 02:52:21'),
(4, 2, 1, 10, '2021-11-22 09:53:14', '2021-11-22 02:53:14', '2021-11-22 02:53:46'),
(5, 2, 1, 20, '2021-11-23 09:53:24', '2021-11-22 02:53:24', '2021-11-22 02:53:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2021_11_18_150824_create_master_barangs_table', 1),
(4, '2021_11_18_150902_create_master_lokasis_table', 1),
(5, '2021_11_19_023659_create_item_transaksis_table', 1),
(6, '2021_11_19_090731_create_masterstoks_table', 1),
(7, '2021_11_21_072738_create_masterhistories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'samuelwijaya', 'samuelindraw', 'samuelindraw75@gmail.com', NULL, '$2y$10$DZQTlVPgEDxQpHdmQ45HMO2n3JRNywA2KPbCNqXJv7yjwQ03cbiBe', NULL, '2021-11-22 02:51:18', '2021-11-22 02:51:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_transaksis`
--
ALTER TABLE `item_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_transaksi_unique` (`bukti`);

--
-- Indexes for table `masterhistories`
--
ALTER TABLE `masterhistories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_barangs`
--
ALTER TABLE `master_barangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_barang_unique` (`kodeBarang`);

--
-- Indexes for table `master_lokasis`
--
ALTER TABLE `master_lokasis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_barang_unique` (`kodeLokasi`);

--
-- Indexes for table `master_stocks`
--
ALTER TABLE `master_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `master_stok_unique` (`id_kodebarang`,`tgl_masuk`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_transaksis`
--
ALTER TABLE `item_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `masterhistories`
--
ALTER TABLE `masterhistories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_barangs`
--
ALTER TABLE `master_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_lokasis`
--
ALTER TABLE `master_lokasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_stocks`
--
ALTER TABLE `master_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
