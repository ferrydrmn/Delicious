-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2021 at 12:58 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delicious`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_order`
--

CREATE TABLE `daftar_order` (
  `id_order` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_order`
--

INSERT INTO `daftar_order` (`id_order`, `id_pembayaran`, `id_produk`, `harga`, `jumlah`) VALUES
(1, 1, 3, 13000, 5),
(2, 1, 2, 5000, 3),
(3, 1, 4, 7000, 8),
(4, 2, 3, 13000, 5),
(5, 2, 2, 7000, 3),
(6, 2, 4, 7000, 8),
(7, 4, 5, 125000, 5),
(8, 5, 3, 13000, 5),
(9, 6, 2, 7000, 5),
(10, 7, 2, 7000, 5),
(11, 8, 5, 125000, 3),
(12, 8, 2, 7000, 2),
(13, 9, 6, 10000, 5),
(14, 10, 4, 7000, 5),
(15, 11, 6, 10000, 5),
(16, 11, 5, 125000, 1),
(17, 11, 3, 13000, 2),
(18, 11, 2, 7000, 1),
(19, 11, 4, 7000, 7);

-- --------------------------------------------------------

--
-- Table structure for table `foto_produk`
--

CREATE TABLE `foto_produk` (
  `id_foto` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `path` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foto_produk`
--

INSERT INTO `foto_produk` (`id_foto`, `id_produk`, `path`) VALUES
(1, 2, 'food/P21.png'),
(2, 2, 'food/P22.png'),
(3, 2, 'food/P23.png'),
(4, 3, 'food/P31.png'),
(5, 3, 'food/P32.png'),
(6, 3, 'food/P33.png'),
(7, 4, 'food/P41.png'),
(8, 4, 'food/P42.png'),
(9, 4, 'food/P43.png'),
(10, 5, 'food/P51.png'),
(11, 5, 'food/P52.png'),
(12, 5, 'food/P53.png'),
(13, 6, 'food/P61.png'),
(14, 6, 'food/P62.png'),
(15, 6, 'food/P63.png');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` varchar(200) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `id_produk`, `id_pengguna`, `rating`, `komentar`, `tanggal`) VALUES
(1, 3, 5, 5, 'Ini adalah rendang yang sangat enak!\r\nSaya merekomendasikannya untuk kalian semua!', '2020-12-13'),
(2, 3, 6, 3, 'Rendang ini cukup enak, sayangnya kurang asin...', '2020-12-13'),
(3, 2, 5, 5, 'Ayam goreng dengan perpaduan bumbu yang pas...\r\nAsli, bikin nagih!', '2020-12-13'),
(4, 5, 6, 5, 'Pizza yang sangat enak!\r\nMembuatku ketagihan!\r\nKalian semua harus coba ini!', '2020-12-13'),
(5, 5, 6, 5, 'Sangat saya rekomendasikan untuk dicoba!', '2020-12-16'),
(6, 5, 5, 4, 'Recomended!', '2020-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `jenis_pembayaran` enum('offline','online') NOT NULL,
  `bayar` int(11) NOT NULL,
  `status` enum('terima','tolak','menunggu') NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pengguna`, `jenis_pembayaran`, `bayar`, `status`, `tanggal`) VALUES
(1, 5, 'offline', 136000, 'terima', '2020-12-09'),
(2, 5, 'offline', 142000, 'terima', '2020-12-09'),
(4, 6, 'offline', 625000, 'tolak', '2020-12-15'),
(5, 6, 'offline', 65000, 'terima', '2020-12-15'),
(6, 6, 'offline', 35000, 'menunggu', '2020-12-15'),
(7, 6, 'offline', 35000, 'menunggu', '2020-12-15'),
(8, 6, 'online', 389000, 'terima', '2020-12-15'),
(9, 0, 'offline', 50000, 'terima', '2020-12-18'),
(10, 13, 'offline', 35000, 'menunggu', '2020-12-18'),
(11, 0, 'offline', 257000, 'terima', '2020-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `password` varchar(32) NOT NULL,
  `level` enum('customer','admin','owner','guest','cashier') NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `foto_profil` varchar(40) NOT NULL,
  `status` enum('aktif','blokir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `email`, `nama`, `no_hp`, `password`, `level`, `alamat`, `foto_profil`, `status`) VALUES
(0, 'guest', '', '', '', 'guest', '', '', 'aktif'),
(1, 'admin@gmail.com', 'Admin', '812262970889', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'owner', 'Jalan raya', 'profile/1.png', 'aktif'),
(2, 'michael.joe@mhs.unsoed.ac.id', 'Michael Joe', '8123478982', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'admin', 'Tasikmalaya, Jawa Barat', 'profile/2.png', 'aktif'),
(4, 'sakuragi.hanamichi@mhs.unsoed.ac.id', 'Sakuragi Hanamichi', '81226297089', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'cashier', 'Jalan Raya Blater KM 5', 'profile/4.png', 'aktif'),
(5, 'faiz@yahoo.com', 'Faiz Aufa', '8122629', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'customer', 'Desa Blater RT 01 RW 01\r\nKecamatan Kalimanah Wetan\r\nKabupaten Purbalingga', 'profile/5.png', 'aktif'),
(6, 'astolfo@gmail.com', 'Aksara', '45678', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'customer', 'Blater\r\nPurbalingga', 'profile/6.png', 'aktif'),
(7, 'de.santa@mhs.unsoed.ac.id', 'Michael De Santa', '890098765', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'customer', 'Blater\r\nPurbalingga', 'pictures/man-account.png', 'aktif'),
(8, 'de.santa@gmail.com', 'Michael De Santa', '81678901234', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'customer', 'Desa Blater RT 01 RW 01\r\nKecamatan Kalimanah Wetan\r\nKabupaten Purbalingga', 'pictures/man-account.png', 'aktif'),
(9, '', 'Tony Stark', '08781256734', '', 'customer', 'Jakarta, Indonesia\r\nRT 01 RW 01', 'pictures/man-account.png', 'aktif'),
(11, 'tonystark@gmail.com', 'Tony Stark', '08781256734', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'customer', 'Jakarta, Indonesia\r\nRT 01 RW 01', 'pictures/man-account.png', 'aktif'),
(13, 'teset@gmail.com', 'Test', '89012367823', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'customer', 'Test', 'pictures/man-account.png', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(40) NOT NULL,
  `jenis_produk` enum('makanan','minuman') NOT NULL,
  `deskripsi` varchar(1000) NOT NULL,
  `harga` int(11) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jenis_produk`, `deskripsi`, `harga`, `status`) VALUES
(2, 'Ayam Goreng', 'makanan', 'Ayam goreng dengan perpaduan bumbu khas nusantara, ditambah dengan campuran rempah-rempah asal timur Indonesia, menambah cita rasa yang sangat berbeda dari ayam goreng kebanyakan!', 7000, 'aktif'),
(3, 'Rendang', 'makanan', 'Ini adalah rendang yang sangat enak!', 13000, 'aktif'),
(4, 'Es Jeruk', 'minuman', 'Ini adalah es jeruk yang terbuat dari jeruk Florida!', 7000, 'aktif'),
(5, 'Pizza Nusantara', 'makanan', 'Berbeda dengan pizza lainnya, pizza ini merupakan campuran khas antara rempah-rempah nusantara dengan berbagai bahan baku dari Italia!', 125000, 'aktif'),
(6, 'Ayam KFC Nusantara', 'makanan', 'Ayam KFC original dengan harga yang lebih murah, cita rasa nusantara!', 10000, 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_order`
--
ALTER TABLE `daftar_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `fk_pembayaran` (`id_pembayaran`);

--
-- Indexes for table `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `fk_fotoproduk` (`id_produk`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `fk_komentar_id_pengguna` (`id_pengguna`),
  ADD KEY `fk_komentar_produk` (`id_produk`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `fk_pengguna` (`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `uk_namaProduk` (`nama_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_order`
--
ALTER TABLE `daftar_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `foto_produk`
--
ALTER TABLE `foto_produk`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_order`
--
ALTER TABLE `daftar_order`
  ADD CONSTRAINT `fk_pembayaran` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`);

--
-- Constraints for table `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD CONSTRAINT `fk_fotoproduk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `fk_komentar_id_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `fk_komentar_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
