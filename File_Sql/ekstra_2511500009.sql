-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 05 Bulan Mei 2026 pada 05.04
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwalguru`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekstra_2511500009`
--

CREATE TABLE `ekstra_2511500009` (
  `id_ekstra009` varchar(5) NOT NULL,
  `nama_ekstra009` varchar(50) NOT NULL,
  `ket009` varchar(20) NOT NULL,
  `semester009` int(5) NOT NULL,
  `thn_ajaran009` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ekstra_2511500009`
--

INSERT INTO `ekstra_2511500009` (`id_ekstra009`, `nama_ekstra009`, `ket009`, `semester009`, `thn_ajaran009`) VALUES
('001', 'futsal', 'futsal', 2, '2025/2026'),
('002', 'Esport', 'Gaming', 1, '2024/2025'),
('004', 'PMR', '', 3, '2025/2026');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ekstra_2511500009`
--
ALTER TABLE `ekstra_2511500009`
  ADD PRIMARY KEY (`id_ekstra009`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
