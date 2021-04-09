-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2021 at 01:24 AM
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
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` bigint(20) NOT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `slug_barang` text DEFAULT NULL,
  `status_barang` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `barang_deskripsi`
--

CREATE TABLE `barang_deskripsi` (
  `id_brg_desc` bigint(20) NOT NULL,
  `barang_brg_desc` bigint(20) NOT NULL,
  `judul_brg_desc` varchar(50) DEFAULT NULL,
  `desc_brg_desc` text DEFAULT NULL,
  `level_brg_desc` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `barang_kategori`
--

CREATE TABLE `barang_kategori` (
  `id_brg_kategori` bigint(20) NOT NULL,
  `barang_brg_kategori` bigint(20) DEFAULT NULL,
  `kategori_brg_kategori` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `barang_satuan`
--

CREATE TABLE `barang_satuan` (
  `id_brg_satuan` bigint(20) NOT NULL,
  `barang_brg_satuan` bigint(20) DEFAULT NULL,
  `satuan_brg_satuan` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `slug_kategori` text DEFAULT NULL,
  `icon_kategori` text DEFAULT NULL,
  `parent_kategori` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_path`
--

CREATE TABLE `kategori_path` (
  `kategori_path` bigint(20) NOT NULL,
  `parent_path` bigint(20) NOT NULL,
  `level_path` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan`
--

CREATE TABLE `penerimaan` (
  `id_terima` bigint(20) NOT NULL,
  `gudang_terima` bigint(20) NOT NULL,
  `tanggal_terima` date NOT NULL,
  `total_terima` int(11) NOT NULL,
  `status_terima` tinyint(1) NOT NULL,
  `user_terima` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_detail`
--

CREATE TABLE `penerimaan_detail` (
  `id_detail` bigint(20) NOT NULL,
  `terima_detail` bigint(20) NOT NULL,
  `minta_detail` bigint(20) NOT NULL,
  `harga_detail` int(11) NOT NULL,
  `jumlah_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_supplier`
--

CREATE TABLE `penerimaan_supplier` (
  `id_terima_supplier` bigint(20) NOT NULL,
  `id_minta_supplier` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` bigint(20) NOT NULL,
  `supplier_permintaan` bigint(20) DEFAULT NULL,
  `tanggal_permintaan` date DEFAULT NULL,
  `total_permintaan` int(11) DEFAULT NULL,
  `status_permintaan` int(1) DEFAULT NULL,
  `user_permintaan` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_detail`
--

CREATE TABLE `permintaan_detail` (
  `id_detail` bigint(20) NOT NULL,
  `permintaan_detail` bigint(20) DEFAULT NULL,
  `barang_detail` bigint(20) DEFAULT NULL,
  `harga_detail` int(20) DEFAULT NULL,
  `jumlah_detail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'Bagian Penjualan', '1'),
(3, 'Bagian Produk', '1'),
(4, 'Kepala Gudang', '2'),
(5, 'Pengelola Stok', '2'),
(6, 'Pengemasan', '2'),
(7, 'Pengiriman', '2');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` bigint(20) NOT NULL,
  `nama_satuan` varchar(50) DEFAULT NULL,
  `singkatan_satuan` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'nameapp', 'Name App'),
(2, 'pathassets', 'http://localhost/barang_mudo/assets/'),
(3, 'pathfavicon', 'http://localhost/barang_mudo/assets/logo/favicon.ico'),
(4, 'pathlogo', 'http://localhost/barang_mudo/assets/logo/logo.png'),
(5, 'pathlogohome', 'http://localhost/barang_mudo/assets/logo/logo-white.png'),
(6, 'pathnouser', 'http://localhost/barang_mudo/assets/logo/no_image.png'),
(7, 'pathimage', '../assets/'),
(8, 'nameappapi', 'API Barang Mudo'),
(9, 'pathlogoapi', 'http://localhost/barang_mudo/assets/logo/logo.png'),
(10, 'pathlogohomeapi', 'http://localhost/barang_mudo/assets/logo/logo-white.png'),
(11, 'pathfaviconapi', 'http://localhost/barang_mudo/assets/logo/favicon.ico');

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

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penerimaan`
--

CREATE TABLE `tmp_penerimaan` (
  `iddetail` bigint(20) DEFAULT NULL,
  `permintaan` bigint(20) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `user` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_permintaan`
--

CREATE TABLE `tmp_permintaan` (
  `satuan` bigint(20) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `user` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Admin', 'admin', '$2y$10$MRbVuprGDy9Jsrlm8LbyXOivU8H/3/t7toTOmQdIS5a5GCOEml6Hq', NULL, '1', 1, '2021-03-26 10:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_gudang`
--

CREATE TABLE `user_gudang` (
  `id_level` bigint(20) NOT NULL,
  `user_level` bigint(20) NOT NULL,
  `gudang_level` bigint(20) NOT NULL,
  `role_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_office`
--

CREATE TABLE `user_office` (
  `id_level` int(11) NOT NULL,
  `user_level` bigint(20) NOT NULL,
  `role_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_office`
--

INSERT INTO `user_office` (`id_level`, `user_level`, `role_level`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_deskripsi`
--
ALTER TABLE `barang_deskripsi`
  ADD PRIMARY KEY (`id_brg_desc`);

--
-- Indexes for table `barang_kategori`
--
ALTER TABLE `barang_kategori`
  ADD PRIMARY KEY (`id_brg_kategori`),
  ADD KEY `barang_brg_kategori` (`barang_brg_kategori`),
  ADD KEY `kategori_brg_kategori` (`kategori_brg_kategori`);

--
-- Indexes for table `barang_satuan`
--
ALTER TABLE `barang_satuan`
  ADD PRIMARY KEY (`id_brg_satuan`),
  ADD KEY `barang_brg_satuan` (`barang_brg_satuan`),
  ADD KEY `satuan_brg_satuan` (`satuan_brg_satuan`);

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
  ADD PRIMARY KEY (`kategori_path`,`parent_path`);

--
-- Indexes for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`id_terima`),
  ADD KEY `gudang_terima` (`gudang_terima`),
  ADD KEY `user_terima` (`user_terima`);

--
-- Indexes for table `penerimaan_detail`
--
ALTER TABLE `penerimaan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `terima_detail` (`terima_detail`),
  ADD KEY `minta_detail` (`minta_detail`);

--
-- Indexes for table `penerimaan_supplier`
--
ALTER TABLE `penerimaan_supplier`
  ADD KEY `id_terima_supplier` (`id_terima_supplier`),
  ADD KEY `id_minta_supplier` (`id_minta_supplier`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `supplier_permintaan` (`supplier_permintaan`),
  ADD KEY `user_permintaan` (`user_permintaan`);

--
-- Indexes for table `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `permintaan_detail` (`permintaan_detail`),
  ADD KEY `barang_detail` (`barang_detail`);

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
-- AUTO_INCREMENT for table `barang_deskripsi`
--
ALTER TABLE `barang_deskripsi`
  MODIFY `id_brg_desc` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_kategori`
--
ALTER TABLE `barang_kategori`
  MODIFY `id_brg_kategori` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_satuan`
--
ALTER TABLE `barang_satuan`
  MODIFY `id_brg_satuan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `penerimaan_detail`
--
ALTER TABLE `penerimaan_detail`
  MODIFY `id_detail` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  MODIFY `id_detail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_kategori`
--
ALTER TABLE `barang_kategori`
  ADD CONSTRAINT `barang_kategori_ibfk_1` FOREIGN KEY (`barang_brg_kategori`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_kategori_ibfk_2` FOREIGN KEY (`kategori_brg_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `barang_satuan`
--
ALTER TABLE `barang_satuan`
  ADD CONSTRAINT `barang_satuan_ibfk_1` FOREIGN KEY (`barang_brg_satuan`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_satuan_ibfk_2` FOREIGN KEY (`satuan_brg_satuan`) REFERENCES `satuan` (`id_satuan`);

--
-- Constraints for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD CONSTRAINT `penerimaan_ibfk_1` FOREIGN KEY (`gudang_terima`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `penerimaan_ibfk_2` FOREIGN KEY (`user_terima`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `penerimaan_detail`
--
ALTER TABLE `penerimaan_detail`
  ADD CONSTRAINT `penerimaan_detail_ibfk_1` FOREIGN KEY (`terima_detail`) REFERENCES `penerimaan` (`id_terima`),
  ADD CONSTRAINT `penerimaan_detail_ibfk_2` FOREIGN KEY (`minta_detail`) REFERENCES `permintaan_detail` (`id_detail`);

--
-- Constraints for table `penerimaan_supplier`
--
ALTER TABLE `penerimaan_supplier`
  ADD CONSTRAINT `penerimaan_supplier_ibfk_1` FOREIGN KEY (`id_terima_supplier`) REFERENCES `penerimaan` (`id_terima`),
  ADD CONSTRAINT `penerimaan_supplier_ibfk_2` FOREIGN KEY (`id_minta_supplier`) REFERENCES `permintaan` (`id_permintaan`);

--
-- Constraints for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `permintaan_ibfk_1` FOREIGN KEY (`supplier_permintaan`) REFERENCES `supplier` (`id_supplier`),
  ADD CONSTRAINT `permintaan_ibfk_2` FOREIGN KEY (`user_permintaan`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  ADD CONSTRAINT `permintaan_detail_ibfk_1` FOREIGN KEY (`permintaan_detail`) REFERENCES `permintaan` (`id_permintaan`),
  ADD CONSTRAINT `permintaan_detail_ibfk_2` FOREIGN KEY (`barang_detail`) REFERENCES `barang_satuan` (`id_brg_satuan`);

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
