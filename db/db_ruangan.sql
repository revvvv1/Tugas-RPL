-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2020 at 08:43 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ruangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `email`, `password`) VALUES
(10, 'desi@hh.com', '069e2dd171f61ecffb845190a7adf425'),
(15, 'tuti@gmail.com', '7da0da6bf56eb7dc3f1b10684b7c806e'),
(20, 'surip@gmail.com', '202cb962ac59075b964b07152d234b70'),
(22, 'putriayu@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int(30) NOT NULL,
  `fakultas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `fakultas`) VALUES
(1, 'Fakultas Hukum'),
(2, 'Fakultas Ekonomi'),
(3, 'Fakultas Keguruan dan Ilmu Pendidikan'),
(4, 'Fakultas Pertanian'),
(5, 'Fakultas Kebidanan'),
(6, 'Fakultas Agama Islam'),
(7, 'Fakultas Teknik'),
(8, 'Fakultas Ilmu Komputer'),
(9, 'Fakultas Ilmu Sosial dan Ilmu Politik');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(10) NOT NULL,
  `id_koordinator` varchar(10) NOT NULL,
  `id_ruangan` varchar(10) NOT NULL,
  `komentar` varchar(500) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `id_koordinator`, `id_ruangan`, `komentar`, `tanggal`) VALUES
(7, '32', '1', 'Ruangannya nyaman, adem', '2020-04-13'),
(8, '32', '1', 'Ruangannya dingin sejuk ac nya', '2020-04-13'),
(11, '34', '1', 'Ruangannya Nyaman.', '2020-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `koordinator`
--

CREATE TABLE `koordinator` (
  `id_koordinator` int(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `npm` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `kelas` varchar(3) NOT NULL,
  `id_prodi` varchar(100) NOT NULL,
  `id_fakultas` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `koordinator`
--

INSERT INTO `koordinator` (`id_koordinator`, `email`, `password`, `npm`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kelas`, `id_prodi`, `id_fakultas`, `foto`, `status`) VALUES
(22, 'desi@hh.com', '069e2dd171f61ecffb845190a7adf425', '112333331112', 'Desi', 'Jakarta', '1990-12-01', 'perempuan', '4E', '1', '1', 'hard-working.png', 'aktif'),
(27, 'tuti@gmail.com', '7da0da6bf56eb7dc3f1b10684b7c806e', '12345', 'Tuti Dwijayanti', 'Brebes', '2019-04-22', 'perempuan', '4A', '18', '8', 'hard-working.png', 'aktif'),
(32, 'surip@gmail.com', '202cb962ac59075b964b07152d234b70', '123456789', 'Surip', 'Brebes', '2020-04-13', 'laki-laki', '4A', '18', '8', 'Capture2.JPG', 'aktif'),
(34, 'putriayu@gmail.com', '202cb962ac59075b964b07152d234b70', '12345678910', 'Putri Ayu Ningsih', 'Brebes', '1997-11-30', 'perempuan', '4D', '7', '3', 'foto-3x4-anggit-5c279cd543322f790b682d42.jpg', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(5) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `id_fakultas` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `prodi`, `id_fakultas`) VALUES
(1, 'Ilmu Hukum - S1', '1'),
(2, 'Manajemen - S1', '2'),
(3, 'Akuntansi - S1', '2'),
(4, 'Akuntansi - D3', '2'),
(5, 'Pendidikan Luar Sekolah - S1', '3'),
(6, 'Pendidikan Matematika - S1', '3'),
(7, 'Pendidikan Bahasa Inggris - S1', '3'),
(8, 'Pendidikan Jasmani, Kesehatan dan Rekreasi - S1', '3'),
(9, 'Pendidikan Bahasa dan Sastra Indonesia - S1', '3'),
(10, 'Agroteknologi - S1', '4'),
(11, 'Kebidanan - D3', '5'),
(12, 'Pendidikan Agama Islam - S1', '6'),
(13, 'Manajemen Pendidikan Islam - S1', '6'),
(14, 'Pendidikan Guru Raudhatul Athfal - S1', '6'),
(15, 'Teknik Industri - S1', '7'),
(16, 'Teknik Mesin - S1', '7'),
(17, 'Teknik Mesin - D3', '7'),
(18, 'Teknik Informatika - S1', '8'),
(19, 'Ilmu Komunikasi - S1', '9');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(10) NOT NULL,
  `kode_ruangan` varchar(30) NOT NULL,
  `lantai` varchar(5) NOT NULL,
  `gedung` varchar(50) NOT NULL,
  `fasilitas` text NOT NULL,
  `kondisi` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `kode_ruangan`, `lantai`, `gedung`, `fasilitas`, `kondisi`, `email`) VALUES
(1, 'R.A-2-12', '2', 'H.OPPON', 'Meja, Proyektor, Kursi, AC', 'KOSONG', ''),
(4, 'R.A-3-11', '3', 'H.OPPON', 'Meja, Kursi, AC, Proyektor', 'KOSONG', ''),
(8, 'R.A-4-24', '4', 'H.OPPON', 'Kursi, AC, Papan Tulis, Proyektor', 'KOSONG', ''),
(9, 'R.A-4-25', '4', 'H.OPPON', 'Kursi, Meja, AC, Proyektor', 'KOSONG', ''),
(11, 'R.A-4-20', '4', 'H.OPPON', 'Kursi, Meja, AC, Proyektor, Papan Tulis', 'KOSONG', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `foto`) VALUES
(1, 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'laki-laki', 'Brebes', '2018-04-16', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indexes for table `koordinator`
--
ALTER TABLE `koordinator`
  ADD PRIMARY KEY (`id_koordinator`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `koordinator`
--
ALTER TABLE `koordinator`
  MODIFY `id_koordinator` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
