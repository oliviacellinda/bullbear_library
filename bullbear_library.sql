-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2019 at 10:35 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bullbear_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username_admin` varchar(100) NOT NULL,
  `password_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username_admin`, `password_admin`) VALUES
('admin', '$2y$12$AJcthx8dH6LRe4unul.l2eKC0E9VTvexss5lgTZhoCXC9V3/xZ./a');

-- --------------------------------------------------------

--
-- Table structure for table `ebook_isi`
--

CREATE TABLE `ebook_isi` (
  `id_ebook` int(11) UNSIGNED NOT NULL,
  `id_ebook_paket` int(11) UNSIGNED NOT NULL,
  `nama_ebook` varchar(255) NOT NULL,
  `file_ebook` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ebook_isi`
--

INSERT INTO `ebook_isi` (`id_ebook`, `id_ebook_paket`, `nama_ebook`, `file_ebook`) VALUES
(1, 1, 'Mengenal peralatan crochet', 'Prototype.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `ebook_paket`
--

CREATE TABLE `ebook_paket` (
  `id_ebook_paket` int(11) UNSIGNED NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `deskripsi_paket` text NOT NULL,
  `harga_paket` int(11) NOT NULL,
  `thumbnail_paket` varchar(255) NOT NULL,
  `tanggal_dibuat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ebook_paket`
--

INSERT INTO `ebook_paket` (`id_ebook_paket`, `nama_paket`, `deskripsi_paket`, `harga_paket`, `thumbnail_paket`, `tanggal_dibuat`) VALUES
(1, 'Crochet untuk Pemula', 'Ebook yang berisi cara membuat kerajinan tangan crochet untuk pemula. Anda akan dikenalkan pada berbagai macam peralatan yang digunakan, ukuran jarum dan benang, membaca pola gambar, dan teknik rajutan dasar.', 200000, 'magnolia-2218788_1920.jpg', '2019-12-08 00:05:41');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `username_member` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `password_member` varchar(255) NOT NULL,
  `nama_member` varchar(255) NOT NULL,
  `email_member` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`username_member`, `password_member`, `nama_member`, `email_member`) VALUES
('userdummy', '$2y$12$AJcthx8dH6LRe4unul.l2eKC0E9VTvexss5lgTZhoCXC9V3/xZ./a', 'User Dummy', 'dummy@asd.com');

-- --------------------------------------------------------

--
-- Table structure for table `member_library`
--

CREATE TABLE `member_library` (
  `username_member` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `jenis_library` varchar(5) NOT NULL,
  `id_paket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `invoice` varchar(255) NOT NULL,
  `username_anggota` varchar(100) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `jenis_paket` varchar(5) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `tanggal_verifikasi` datetime NOT NULL,
  `status_verifikasi` tinyint(1) NOT NULL,
  `total_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `video_isi`
--

CREATE TABLE `video_isi` (
  `id_video` int(11) UNSIGNED NOT NULL,
  `id_video_paket` int(11) UNSIGNED NOT NULL,
  `nama_video` varchar(255) NOT NULL,
  `file_video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_isi`
--

INSERT INTO `video_isi` (`id_video`, `id_video_paket`, `nama_video`, `file_video`) VALUES
(2, 1, 'video 2', 'animegrimoire_Karakai_Jouzu_no_Takagi-san_-_02_720p1C16FDD0.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `video_paket`
--

CREATE TABLE `video_paket` (
  `id_video_paket` int(11) UNSIGNED NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `deskripsi_paket` text NOT NULL,
  `harga_paket` int(11) NOT NULL,
  `thumbnail_paket` varchar(255) NOT NULL,
  `tanggal_dibuat` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_paket`
--

INSERT INTO `video_paket` (`id_video_paket`, `nama_paket`, `deskripsi_paket`, `harga_paket`, `thumbnail_paket`, `tanggal_dibuat`) VALUES
(1, 'HTML dan CSS (Elementary)', 'Pelajaran HTML dan CSS untuk pemula.', 100000, 'sunset-174276_1920.jpg', '2019-12-05 02:14:39'),
(2, 'Paket Video 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 50000, 'Bekko_Logo.png', '2019-12-16 00:17:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username_admin`);

--
-- Indexes for table `ebook_isi`
--
ALTER TABLE `ebook_isi`
  ADD PRIMARY KEY (`id_ebook`,`id_ebook_paket`),
  ADD KEY `fk_ebook` (`id_ebook_paket`);

--
-- Indexes for table `ebook_paket`
--
ALTER TABLE `ebook_paket`
  ADD PRIMARY KEY (`id_ebook_paket`);
ALTER TABLE `ebook_paket` ADD FULLTEXT KEY `nama_paket` (`nama_paket`,`deskripsi_paket`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`username_member`);

--
-- Indexes for table `member_library`
--
ALTER TABLE `member_library`
  ADD PRIMARY KEY (`username_member`,`jenis_library`,`id_paket`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`invoice`);

--
-- Indexes for table `video_isi`
--
ALTER TABLE `video_isi`
  ADD PRIMARY KEY (`id_video`,`id_video_paket`),
  ADD KEY `fk_video` (`id_video_paket`);

--
-- Indexes for table `video_paket`
--
ALTER TABLE `video_paket`
  ADD PRIMARY KEY (`id_video_paket`);
ALTER TABLE `video_paket` ADD FULLTEXT KEY `nama_paket` (`nama_paket`,`deskripsi_paket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ebook_isi`
--
ALTER TABLE `ebook_isi`
  MODIFY `id_ebook` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ebook_paket`
--
ALTER TABLE `ebook_paket`
  MODIFY `id_ebook_paket` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `video_isi`
--
ALTER TABLE `video_isi`
  MODIFY `id_video` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `video_paket`
--
ALTER TABLE `video_paket`
  MODIFY `id_video_paket` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ebook_isi`
--
ALTER TABLE `ebook_isi`
  ADD CONSTRAINT `fk_ebook` FOREIGN KEY (`id_ebook_paket`) REFERENCES `ebook_paket` (`id_ebook_paket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_library`
--
ALTER TABLE `member_library`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`username_member`) REFERENCES `member` (`username_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_isi`
--
ALTER TABLE `video_isi`
  ADD CONSTRAINT `fk_video` FOREIGN KEY (`id_video_paket`) REFERENCES `video_paket` (`id_video_paket`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
