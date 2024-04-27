-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 06:54 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabel_transaksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_reaksi`
--

CREATE TABLE `detail_reaksi` (
  `id_reaksi` varchar(11) NOT NULL,
  `id_akun` varchar(11) NOT NULL,
  `debet_kredit` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_reaksi`
--

INSERT INTO `detail_reaksi` (`id_reaksi`, `id_akun`, `debet_kredit`) VALUES
('R001', '101', 'D'),
('R001', '300', 'K'),
('R002', '101', 'K'),
('R002', '116', 'D'),
('R003', '101', 'K'),
('R003', '113', 'D'),
('R004', '101', 'D'),
('R004', '411', 'K'),
('R005', '112', 'D'),
('R005', '411', 'K'),
('R006', '101', 'K'),
('R006', '512', 'D'),
('R007', '101', 'K'),
('R007', '115', 'D'),
('R008', '101', 'K'),
('R008', '215', 'D'),
('R009', '101', 'K'),
('R009', '511', 'D'),
('R010', '101', 'D'),
('R010', '112', 'K');

-- --------------------------------------------------------

--
-- Table structure for table `reaksi`
--

CREATE TABLE `reaksi` (
  `id_reaksi` varchar(11) NOT NULL,
  `nama_reaksi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reaksi`
--

INSERT INTO `reaksi` (`id_reaksi`, `nama_reaksi`) VALUES
('R001', 'Penyetoran Modal'),
('R002', 'Menyewa Ruko'),
('R003', 'Membeli Barang Habis Pakai (tunai)'),
('R004', 'Menyelesaikan Pekerjaan & Menerima Pembayaran'),
('R005', 'Menyelesaikan Pekerjaan & Mengirimkan Tagihan'),
('R006', 'Membayar Biaya Listrik Air Telepon'),
('R007', 'Membayar Biaya Iklan untuk 5 Bulan Kedepan'),
('R008', 'Membayar Premi Asuransi untuk 12 Bulan Kedepan'),
('R009', 'Membayar Gaji Karyawan'),
('R010', 'Menerima Pembayaran Jasa Secara Kredit');

-- --------------------------------------------------------

--
-- Table structure for table `t_akun`
--

CREATE TABLE `t_akun` (
  `id_akun` varchar(100) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `aktiva_pasiva` enum('Aktiva','Pasiva') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_akun`
--

INSERT INTO `t_akun` (`id_akun`, `nama_akun`, `aktiva_pasiva`) VALUES
('110', 'Harta lancar', 'Aktiva'),
('101', 'Kas', 'Aktiva'),
('112', 'Piutang usaha', 'Aktiva'),
('113', 'Perlengkapan', 'Aktiva'),
('114', 'Surat-Surat berharga', 'Aktiva'),
('115', 'Iklan dibayar dimuka', 'Aktiva'),
('116', 'Sewa dibayar dimuka', 'Aktiva'),
('120', 'Harta tetap', 'Aktiva'),
('121', 'Tanah', 'Aktiva'),
('122', 'Peralatan', 'Aktiva'),
('123', 'Akumulasi penyusutan peralatan', 'Aktiva'),
('124', 'Gedung', 'Aktiva'),
('125', 'Akumulasi penyusutan gedung', 'Aktiva'),
('130', 'Investasi jangka panjang', 'Aktiva'),
('131', 'Investasi dalam saham', 'Aktiva'),
('132', 'Investasi dalam obligasi', 'Aktiva'),
('140', 'Harta tidak berwujud', 'Aktiva'),
('141', 'Goodwill', 'Aktiva'),
('142', 'Hak paten', 'Aktiva'),
('143', 'Hak cipta', 'Aktiva'),
('144', 'Hak merek', 'Aktiva'),
('200', 'Utang', 'Pasiva'),
('210', 'Utang jangka pendek/lancer', 'Pasiva'),
('211', 'Utang usaha', 'Pasiva'),
('212', 'Utang gaji', 'Pasiva'),
('213', 'Utang pajak', 'Pasiva'),
('214', 'Utang bunga', 'Pasiva'),
('215', 'Asuransi diterima dimuka', 'Pasiva'),
('216', 'Sewa diterima dimuka', 'Pasiva'),
('220', 'Utang jangka panjang', 'Pasiva'),
('221', 'Utang obligasi', 'Pasiva'),
('222', 'Utang hipotik', 'Pasiva'),
('300', 'Modal', 'Aktiva'),
('311', 'Modal pemilik', 'Pasiva'),
('312', 'Prive pemilik', 'Pasiva'),
('400', 'Pendapatan', 'Aktiva'),
('411', 'Pendapatan jasa/usaha', 'Pasiva'),
('412', 'Pendapatan lain-lain', 'Pasiva'),
('500', 'Beban-beban', 'Pasiva'),
('511', 'Beban gaji', 'Pasiva'),
('512', 'Beban perlengkapan', 'Pasiva');

-- --------------------------------------------------------

--
-- Table structure for table `t_trx`
--

CREATE TABLE `t_trx` (
  `id_trx` int(10) NOT NULL,
  `tgl` date NOT NULL,
  `transaksi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_trx`
--

INSERT INTO `t_trx` (`id_trx`, `tgl`, `transaksi`) VALUES
(30, '2024-04-26', 'modal awal'),
(31, '2024-04-18', 'uang sewa'),
(32, '2024-04-27', 'barang sudah pakai'),
(33, '2024-04-30', 'bayar karyawan'),
(34, '2024-04-19', 'modal 3'),
(35, '2024-04-23', 'data coba coba'),
(36, '2024-05-02', 'modal farrell'),
(37, '2024-05-11', 'coba1');

-- --------------------------------------------------------

--
-- Table structure for table `t_trx_detail`
--

CREATE TABLE `t_trx_detail` (
  `id_trx` int(10) NOT NULL,
  `id_akun` varchar(10) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `d_k` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_trx_detail`
--

INSERT INTO `t_trx_detail` (`id_trx`, `id_akun`, `nominal`, `d_k`) VALUES
(30, '101', 10000, 'D'),
(30, '300', 10000, 'K'),
(31, '101', 50000, 'K'),
(31, '116', 50000, 'D'),
(32, '101', 30000, 'K'),
(32, '113', 30000, 'D'),
(33, '101', 40000, 'D'),
(33, '411', 40000, 'K'),
(34, '101', 50000, 'D'),
(34, '112', 50000, 'K'),
(35, '101', 20000, 'K'),
(35, '512', 20000, 'D'),
(36, '101', 10000, 'K'),
(36, '115', 10000, 'D'),
(37, '101', 10000, 'K'),
(37, '215', 10000, 'D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_reaksi`
--
ALTER TABLE `detail_reaksi`
  ADD PRIMARY KEY (`id_reaksi`,`id_akun`);

--
-- Indexes for table `reaksi`
--
ALTER TABLE `reaksi`
  ADD PRIMARY KEY (`id_reaksi`);

--
-- Indexes for table `t_trx`
--
ALTER TABLE `t_trx`
  ADD PRIMARY KEY (`id_trx`);

--
-- Indexes for table `t_trx_detail`
--
ALTER TABLE `t_trx_detail`
  ADD KEY `fk_trx_detail_trx` (`id_trx`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_trx`
--
ALTER TABLE `t_trx`
  MODIFY `id_trx` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_reaksi`
--
ALTER TABLE `detail_reaksi`
  ADD CONSTRAINT `detail_reaksi_ibfk_1` FOREIGN KEY (`id_reaksi`) REFERENCES `reaksi` (`id_reaksi`);

--
-- Constraints for table `t_trx_detail`
--
ALTER TABLE `t_trx_detail`
  ADD CONSTRAINT `fk_trx_detail_trx` FOREIGN KEY (`id_trx`) REFERENCES `t_trx` (`id_trx`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
