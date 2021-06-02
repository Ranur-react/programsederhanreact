-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2021 at 12:54 PM
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
  `status_barang` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `barang_deskripsi`
--

CREATE TABLE `barang_deskripsi` (
  `id_brg_desc` bigint(20) NOT NULL,
  `barang_brg_desc` bigint(20) NOT NULL,
  `judul_brg_desc` varchar(50) DEFAULT NULL,
  `desc_brg_desc` text DEFAULT NULL,
  `level_brg_desc` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `barang_kategori`
--

CREATE TABLE `barang_kategori` (
  `id_brg_kategori` bigint(20) NOT NULL,
  `barang_brg_kategori` bigint(20) NOT NULL,
  `kategori_brg_kategori` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `barang_satuan`
--

CREATE TABLE `barang_satuan` (
  `id_brg_satuan` bigint(20) NOT NULL,
  `barang_brg_satuan` bigint(20) NOT NULL,
  `satuan_brg_satuan` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` bigint(20) NOT NULL,
  `nama_gudang` varchar(50) DEFAULT NULL,
  `alamat_gudang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `harga_barang`
--

CREATE TABLE `harga_barang` (
  `id_hrg_barang` bigint(20) NOT NULL,
  `terima_hrg_barang` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `slug_kategori` text DEFAULT NULL,
  `icon_kategori` text DEFAULT NULL,
  `parent_kategori` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_path`
--

CREATE TABLE `kategori_path` (
  `kategori_path` bigint(20) NOT NULL,
  `parent_path` bigint(20) NOT NULL,
  `level_path` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(23, '2021-03-24-092217', 'App\\Database\\Migrations\\CreateTabelUser', 'default', 'App', 1619678872, 1),
(24, '2021-03-24-103035', 'App\\Database\\Migrations\\CreateTabelRole', 'default', 'App', 1619678872, 1),
(25, '2021-03-25-114954', 'App\\Database\\Migrations\\CreateTabelGudang', 'default', 'App', 1619678873, 1),
(26, '2021-03-25-120018', 'App\\Database\\Migrations\\CreateTabelUserOffice', 'default', 'App', 1619678873, 1),
(27, '2021-03-25-132256', 'App\\Database\\Migrations\\CreateTabelUserGudang', 'default', 'App', 1619678873, 1),
(28, '2021-04-04-031035', 'App\\Database\\Migrations\\CreateTabelSatuan', 'default', 'App', 1619678873, 1),
(29, '2021-04-10-043405', 'App\\Database\\Migrations\\CreateTabelSupplier', 'default', 'App', 1619678873, 1),
(30, '2021-04-10-064513', 'App\\Database\\Migrations\\CreateTableKategori', 'default', 'App', 1619678873, 1),
(31, '2021-04-10-064942', 'App\\Database\\Migrations\\CreateTabelKategoriPath', 'default', 'App', 1619678873, 1),
(32, '2021-04-10-083640', 'App\\Database\\Migrations\\CreateTabelBarang', 'default', 'App', 1619678873, 1),
(33, '2021-04-10-090143', 'App\\Database\\Migrations\\CreateTabelBarangDeskripsi', 'default', 'App', 1619678873, 1),
(34, '2021-04-10-090840', 'App\\Database\\Migrations\\CreateTabelBarangDeskripsiKategori', 'default', 'App', 1619678873, 1),
(35, '2021-04-10-092542', 'App\\Database\\Migrations\\CreateTabelBarangDeskripsiSatuan', 'default', 'App', 1619678873, 1),
(36, '2021-04-12-110619', 'App\\Database\\Migrations\\CreateTabelTmpPermintaan', 'default', 'App', 1619678873, 1),
(37, '2021-04-12-113827', 'App\\Database\\Migrations\\CreateTabelPermintaan', 'default', 'App', 1619678873, 1),
(38, '2021-04-12-123137', 'App\\Database\\Migrations\\CreateTablePermintaanDetail', 'default', 'App', 1619678873, 1),
(39, '2021-04-12-141559', 'App\\Database\\Migrations\\CreateTabelTmpPenerimaan', 'default', 'App', 1619678873, 1),
(40, '2021-04-12-141935', 'App\\Database\\Migrations\\CreateTabelPenerimaan', 'default', 'App', 1619678873, 1),
(41, '2021-04-12-142453', 'App\\Database\\Migrations\\CreateTabelPenerimaanDetail', 'default', 'App', 1619678873, 1),
(42, '2021-04-12-143746', 'App\\Database\\Migrations\\CreateTabelPenerimaanSupplier', 'default', 'App', 1619678874, 1),
(43, '2021-04-23-070259', 'App\\Database\\Migrations\\CreateTabelSettings', 'default', 'App', 1619678874, 1),
(44, '2021-04-29-025126', 'App\\Database\\Migrations\\CreateTabelHargaBarang', 'default', 'App', 1619678874, 1);

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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_supplier`
--

CREATE TABLE `penerimaan_supplier` (
  `id_terima_supplier` bigint(20) NOT NULL,
  `id_minta_supplier` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` bigint(20) NOT NULL,
  `supplier_permintaan` bigint(20) NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `total_permintaan` int(11) NOT NULL,
  `status_permintaan` tinyint(1) NOT NULL,
  `user_permintaan` bigint(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_detail`
--

CREATE TABLE `permintaan_detail` (
  `id_detail` bigint(20) NOT NULL,
  `permintaan_detail` bigint(20) NOT NULL,
  `barang_detail` bigint(20) NOT NULL,
  `harga_detail` int(11) NOT NULL,
  `jumlah_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` char(50) DEFAULT NULL,
  `jenis_role` enum('1','2') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id_seting` bigint(20) NOT NULL,
  `nama_seting` varchar(50) DEFAULT NULL,
  `value_seting` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id_seting`, `nama_seting`, `value_seting`) VALUES
(1, 'nameapp', 'Barang Mudo'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penerimaan`
--

CREATE TABLE `tmp_penerimaan` (
  `iddetail` bigint(20) NOT NULL,
  `permintaan` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_permintaan`
--

CREATE TABLE `tmp_permintaan` (
  `satuan` bigint(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `avatar_user`, `jenis_user`, `status_user`, `last_login`) VALUES
(1, 'Administrator', 'admin', '$2y$10$V.kguzFiZyHL7GcVShficeGKeLvRl.3vshsM.J966/RYompscyFTy', 'images/users/1619679303.png', '1', 1, '2021-04-29 06:55:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_gudang`
--

CREATE TABLE `user_gudang` (
  `id_level` bigint(20) NOT NULL,
  `user_level` bigint(20) NOT NULL,
  `gudang_level` bigint(20) NOT NULL,
  `role_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_office`
--

CREATE TABLE `user_office` (
  `id_level` int(11) NOT NULL,
  `user_level` bigint(20) NOT NULL,
  `role_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD PRIMARY KEY (`id_brg_desc`),
  ADD KEY `barang_deskripsi_barang_brg_desc_foreign` (`barang_brg_desc`);

--
-- Indexes for table `barang_kategori`
--
ALTER TABLE `barang_kategori`
  ADD PRIMARY KEY (`id_brg_kategori`),
  ADD KEY `barang_kategori_barang_brg_kategori_foreign` (`barang_brg_kategori`),
  ADD KEY `barang_kategori_kategori_brg_kategori_foreign` (`kategori_brg_kategori`);

--
-- Indexes for table `barang_satuan`
--
ALTER TABLE `barang_satuan`
  ADD PRIMARY KEY (`id_brg_satuan`),
  ADD KEY `barang_satuan_barang_brg_satuan_foreign` (`barang_brg_satuan`),
  ADD KEY `barang_satuan_satuan_brg_satuan_foreign` (`satuan_brg_satuan`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `harga_barang`
--
ALTER TABLE `harga_barang`
  ADD PRIMARY KEY (`id_hrg_barang`),
  ADD KEY `harga_barang_terima_hrg_barang_foreign` (`terima_hrg_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kategori_path`
--
ALTER TABLE `kategori_path`
  ADD PRIMARY KEY (`kategori_path`,`parent_path`),
  ADD KEY `kategori_path_parent_path_foreign` (`parent_path`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`id_terima`),
  ADD KEY `penerimaan_gudang_terima_foreign` (`gudang_terima`),
  ADD KEY `penerimaan_user_terima_foreign` (`user_terima`);

--
-- Indexes for table `penerimaan_detail`
--
ALTER TABLE `penerimaan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `penerimaan_detail_terima_detail_foreign` (`terima_detail`),
  ADD KEY `penerimaan_detail_minta_detail_foreign` (`minta_detail`);

--
-- Indexes for table `penerimaan_supplier`
--
ALTER TABLE `penerimaan_supplier`
  ADD KEY `penerimaan_supplier_id_terima_supplier_foreign` (`id_terima_supplier`),
  ADD KEY `penerimaan_supplier_id_minta_supplier_foreign` (`id_minta_supplier`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `permintaan_supplier_permintaan_foreign` (`supplier_permintaan`),
  ADD KEY `permintaan_user_permintaan_foreign` (`user_permintaan`);

--
-- Indexes for table `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `permintaan_detail_permintaan_detail_foreign` (`permintaan_detail`),
  ADD KEY `permintaan_detail_barang_detail_foreign` (`barang_detail`);

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
  ADD KEY `user_gudang_user_level_foreign` (`user_level`),
  ADD KEY `user_gudang_gudang_level_foreign` (`gudang_level`),
  ADD KEY `user_gudang_role_level_foreign` (`role_level`);

--
-- Indexes for table `user_office`
--
ALTER TABLE `user_office`
  ADD PRIMARY KEY (`id_level`),
  ADD KEY `user_office_user_level_foreign` (`user_level`),
  ADD KEY `user_office_role_level_foreign` (`role_level`);

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
  MODIFY `id_brg_satuan` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harga_barang`
--
ALTER TABLE `harga_barang`
  MODIFY `id_hrg_barang` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `penerimaan_detail`
--
ALTER TABLE `penerimaan_detail`
  MODIFY `id_detail` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  MODIFY `id_detail` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_deskripsi`
--
ALTER TABLE `barang_deskripsi`
  ADD CONSTRAINT `barang_deskripsi_barang_brg_desc_foreign` FOREIGN KEY (`barang_brg_desc`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `barang_kategori`
--
ALTER TABLE `barang_kategori`
  ADD CONSTRAINT `barang_kategori_barang_brg_kategori_foreign` FOREIGN KEY (`barang_brg_kategori`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_kategori_kategori_brg_kategori_foreign` FOREIGN KEY (`kategori_brg_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `barang_satuan`
--
ALTER TABLE `barang_satuan`
  ADD CONSTRAINT `barang_satuan_barang_brg_satuan_foreign` FOREIGN KEY (`barang_brg_satuan`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_satuan_satuan_brg_satuan_foreign` FOREIGN KEY (`satuan_brg_satuan`) REFERENCES `satuan` (`id_satuan`);

--
-- Constraints for table `harga_barang`
--
ALTER TABLE `harga_barang`
  ADD CONSTRAINT `harga_barang_terima_hrg_barang_foreign` FOREIGN KEY (`terima_hrg_barang`) REFERENCES `penerimaan_detail` (`id_detail`);

--
-- Constraints for table `kategori_path`
--
ALTER TABLE `kategori_path`
  ADD CONSTRAINT `kategori_path_kategori_path_foreign` FOREIGN KEY (`kategori_path`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `kategori_path_parent_path_foreign` FOREIGN KEY (`parent_path`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD CONSTRAINT `penerimaan_gudang_terima_foreign` FOREIGN KEY (`gudang_terima`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `penerimaan_user_terima_foreign` FOREIGN KEY (`user_terima`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `penerimaan_detail`
--
ALTER TABLE `penerimaan_detail`
  ADD CONSTRAINT `penerimaan_detail_minta_detail_foreign` FOREIGN KEY (`minta_detail`) REFERENCES `permintaan_detail` (`id_detail`),
  ADD CONSTRAINT `penerimaan_detail_terima_detail_foreign` FOREIGN KEY (`terima_detail`) REFERENCES `penerimaan` (`id_terima`);

--
-- Constraints for table `penerimaan_supplier`
--
ALTER TABLE `penerimaan_supplier`
  ADD CONSTRAINT `penerimaan_supplier_id_minta_supplier_foreign` FOREIGN KEY (`id_minta_supplier`) REFERENCES `permintaan` (`id_permintaan`),
  ADD CONSTRAINT `penerimaan_supplier_id_terima_supplier_foreign` FOREIGN KEY (`id_terima_supplier`) REFERENCES `penerimaan` (`id_terima`);

--
-- Constraints for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `permintaan_supplier_permintaan_foreign` FOREIGN KEY (`supplier_permintaan`) REFERENCES `supplier` (`id_supplier`),
  ADD CONSTRAINT `permintaan_user_permintaan_foreign` FOREIGN KEY (`user_permintaan`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `permintaan_detail`
--
ALTER TABLE `permintaan_detail`
  ADD CONSTRAINT `permintaan_detail_barang_detail_foreign` FOREIGN KEY (`barang_detail`) REFERENCES `barang_satuan` (`id_brg_satuan`),
  ADD CONSTRAINT `permintaan_detail_permintaan_detail_foreign` FOREIGN KEY (`permintaan_detail`) REFERENCES `permintaan` (`id_permintaan`);

--
-- Constraints for table `user_gudang`
--
ALTER TABLE `user_gudang`
  ADD CONSTRAINT `user_gudang_gudang_level_foreign` FOREIGN KEY (`gudang_level`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `user_gudang_role_level_foreign` FOREIGN KEY (`role_level`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `user_gudang_user_level_foreign` FOREIGN KEY (`user_level`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `user_office`
--
ALTER TABLE `user_office`
  ADD CONSTRAINT `user_office_role_level_foreign` FOREIGN KEY (`role_level`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `user_office_user_level_foreign` FOREIGN KEY (`user_level`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
