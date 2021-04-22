-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2021 at 05:04 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barang_mudo`
--

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` bigint(20) NOT NULL,
  `nama_gudang` varchar(50) DEFAULT NULL,
  `alamat_gudang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `nama_gudang`, `alamat_gudang`) VALUES
(1, 'Gudang A', 'Padang');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `icon_kategori` text DEFAULT NULL,
  `parent_kategori` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `icon_kategori`, `parent_kategori`) VALUES
(1, 'Hobi & Koleksi', NULL, 0),
(2, 'Mainan', NULL, 1),
(3, 'Action Figure', NULL, 2),
(4, 'Musik', NULL, 1),
(5, 'Aksesoris Gitar', NULL, 4),
(6, 'Biola', NULL, 4),
(7, 'Kartu', NULL, 2),
(8, 'Perawatan & Kecantikan', NULL, 0),
(9, 'Perawatan Wajah', NULL, 8),
(10, 'Masker Wajah Wanita', NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_path`
--

CREATE TABLE `kategori_path` (
  `id_path` bigint(20) NOT NULL,
  `kategori_path` bigint(20) DEFAULT NULL,
  `parent_path` bigint(20) DEFAULT NULL,
  `level_path` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_path`
--

INSERT INTO `kategori_path` (`id_path`, `kategori_path`, `parent_path`, `level_path`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 2, 2, 1),
(4, 3, 1, 0),
(5, 3, 2, 1),
(6, 3, 3, 2),
(7, 4, 1, 0),
(8, 4, 4, 1),
(9, 5, 1, 0),
(10, 5, 4, 1),
(11, 5, 5, 2),
(12, 6, 1, 0),
(13, 6, 4, 1),
(14, 6, 6, 2),
(15, 7, 1, 0),
(16, 7, 2, 1),
(17, 7, 7, 2),
(18, 8, 8, 0),
(19, 9, 8, 0),
(20, 9, 9, 1),
(21, 10, 8, 0),
(22, 10, 9, 1),
(23, 10, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` char(50) DEFAULT NULL,
  `jenis_role` enum('1','2') DEFAULT NULL COMMENT '1=back_office 2=gudang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`, `jenis_role`) VALUES
(1, 'Administrator', '1'),
(2, 'Penjualan', '1'),
(3, 'Kepala Gudang', '2'),
(4, 'Staf Gudang', '2');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` bigint(20) NOT NULL,
  `nama_satuan` varchar(50) DEFAULT NULL,
  `singkatan_satuan` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `singkatan_satuan`) VALUES
(3, 'zxc_', 'zxc_');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id_seting` bigint(20) NOT NULL,
  `nama_seting` varchar(50) DEFAULT NULL,
  `value_seting` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id_seting`, `nama_seting`, `value_seting`) VALUES
(1, 'nameapp', 'Barang Mudo'),
(2, 'pathassets', 'http://localhost/barang_mudo/assets/'),
(3, 'pathfavicon', 'http://localhost/barang_mudo/assets/logo/favicon.ico'),
(4, 'pathlogo', 'http://localhost/barang_mudo/assets/logo/logo.png'),
(5, 'pathlogohome', 'http://localhost/barang_mudo/assets/logo/logo-white.png'),
(6, 'pathnouser', 'http://localhost/barang_mudo/assets/logo/no_image.png');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` bigint(20) NOT NULL,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `alamat_supplier` text DEFAULT NULL,
  `telp_supplier` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `telp_supplier`) VALUES
(3, 'Abdi dharma', 'p', '082388356944');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) NOT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `avatar_user` text DEFAULT NULL,
  `jenis_user` enum('1','2') DEFAULT NULL,
  `status_user` int(1) DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `avatar_user`, `jenis_user`, `status_user`, `last_login`) VALUES
(1, 'Admin', 'admin', '$2y$10$MRbVuprGDy9Jsrlm8LbyXOivU8H/3/t7toTOmQdIS5a5GCOEml6Hq', NULL, '1', 1, '2021-03-03 10:35:20'),
(2, 'penjualan', 'penjualan', '$2y$10$aL7/pY25H0veQkYoqRIhx.Z0nOj6gtr4epZbyTlDDfHhKYa5Sf5gW', NULL, '1', 1, '2021-02-28 08:34:30'),
(3, 'Kepala Gudang', 'kepala_gudang', '$2y$10$RXFCehVSYLRLiISbsDgfP.esqt04LWzhjkPwFVhHpcBA1gFN2f9KS', NULL, '2', 1, '2021-03-04 06:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_gudang`
--

CREATE TABLE `user_gudang` (
  `id_level` bigint(20) NOT NULL,
  `user_level` bigint(20) DEFAULT NULL,
  `gudang_level` bigint(20) DEFAULT NULL,
  `role_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_gudang`
--

INSERT INTO `user_gudang` (`id_level`, `user_level`, `gudang_level`, `role_level`) VALUES
(1, 3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_office`
--

CREATE TABLE `user_office` (
  `id_level` int(11) NOT NULL,
  `user_level` bigint(20) DEFAULT NULL,
  `role_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_office`
--

INSERT INTO `user_office` (`id_level`, `user_level`, `role_level`) VALUES
(1, 1, 1),
(2, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kategori_path`
--
ALTER TABLE `kategori_path`
  ADD PRIMARY KEY (`id_path`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id_seting`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_gudang`
--
ALTER TABLE `user_gudang`
  ADD PRIMARY KEY (`id_level`),
  ADD KEY `gudang_level` (`gudang_level`),
  ADD KEY `user_level` (`user_level`),
  ADD KEY `role_level` (`role_level`);

--
-- Indexes for table `user_office`
--
ALTER TABLE `user_office`
  ADD PRIMARY KEY (`id_level`),
  ADD KEY `user_level` (`user_level`),
  ADD KEY `role_level` (`role_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori_path`
--
ALTER TABLE `kategori_path`
  MODIFY `id_path` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_gudang`
--
ALTER TABLE `user_gudang`
  ADD CONSTRAINT `user_gudang_ibfk_2` FOREIGN KEY (`gudang_level`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `user_gudang_ibfk_3` FOREIGN KEY (`user_level`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `user_gudang_ibfk_4` FOREIGN KEY (`role_level`) REFERENCES `role` (`id_role`);

--
-- Constraints for table `user_office`
--
ALTER TABLE `user_office`
  ADD CONSTRAINT `user_office_ibfk_1` FOREIGN KEY (`user_level`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `user_office_ibfk_2` FOREIGN KEY (`role_level`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
