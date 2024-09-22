-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 16 Sep 2024 pada 16.44
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_antrian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `gambar` varchar(255) NOT NULL DEFAULT 'default.png',
  `theme` varchar(20) NOT NULL DEFAULT 'sb_admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `nama`, `status`, `gambar`, `theme`) VALUES
(1, 'admin@admin.com', 'admin', 'admin', 1, 'default.png', 'sb_admin'),
(2, 'admingigi@admin.com', 'admingigi', 'admingigi', 1, 'default.png', 'sb_admin'),
(4, 'adminkia@admin.com', 'adminkia', 'adminkia', 1, 'default.png', 'sb_admin'),
(5, 'adminumum@admin.com', 'adminumum', 'adminumum', 1, 'default.png', 'sb_admin'),
(6, 'adminkajianawal@admin.com', 'adminkajianawal', 'adminkajianawal', 1, 'default.png', 'sb_admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id_antrian` int(4) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `tgl_antrian` date NOT NULL,
  `no_antrian` varchar(10) NOT NULL,
  `proses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `antrian`
--

INSERT INTO `antrian` (`id_antrian`, `id_pasien`, `tgl_antrian`, `no_antrian`, `proses`) VALUES
(48, 1, '2024-09-16', '1', 1),
(49, 2, '2024-09-16', '2', 1),
(50, 3, '2024-09-16', '3', 1),
(51, 4, '2024-09-16', '4', 1),
(52, 5, '2024-09-16', '5', 0),
(53, 24, '2024-09-16', '6', 0),
(54, 25, '2024-09-16', '7', 0),
(55, 25, '2024-09-16', '8', 0),
(56, 25, '2024-09-16', '9', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian_poli`
--

CREATE TABLE `antrian_poli` (
  `id_antrian_poli` int(4) NOT NULL,
  `id_antrian` int(4) NOT NULL,
  `id_pasien` int(4) NOT NULL,
  `id_poli` int(2) NOT NULL,
  `no_antrian_poli` varchar(10) NOT NULL,
  `tgl_antrian_poli` date NOT NULL,
  `proses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `antrian_poli`
--

INSERT INTO `antrian_poli` (`id_antrian_poli`, `id_antrian`, `id_pasien`, `id_poli`, `no_antrian_poli`, `tgl_antrian_poli`, `proses`) VALUES
(68, 48, 1, 1, '1', '2024-09-16', 1),
(69, 49, 2, 1, '2', '2024-09-16', 1),
(70, 50, 3, 2, '1', '2024-09-16', 1),
(71, 51, 4, 2, '2', '2024-09-16', 1),
(72, 52, 5, 3, '1', '2024-09-16', 1),
(73, 53, 24, 3, '2', '2024-09-16', 1),
(74, 54, 25, 1, '3', '2024-09-16', 0),
(75, 55, 25, 2, '3', '2024-09-16', 0),
(76, 56, 25, 3, '3', '2024-09-16', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_poli`
--

CREATE TABLE `kategori_poli` (
  `id_poli` int(2) NOT NULL,
  `kode_poli` varchar(5) NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `jumlah_maksimal` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori_poli`
--

INSERT INTO `kategori_poli` (`id_poli`, `kode_poli`, `nama_poli`, `jumlah_maksimal`) VALUES
(1, 'PLUM', 'Poli Umum', '30'),
(2, 'PLGG', 'Poli Gigi', '30'),
(3, 'PLKIA', 'Poli Kehatan Ibu & Anak', '30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(4) NOT NULL,
  `no_identitas` varchar(25) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` enum('Perempuan','Laki-Laki') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `no_identitas`, `nama`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `no_telp`, `username`, `password`) VALUES
(1, '111', 'ulla', 'Laki-Laki', '2024-07-16', 'BTN PEPABRI', '6285256953376', 'ulla', '4f9103524228b78d81c703cc9a886415'),
(2, '112', 'juna', 'Laki-Laki', '2024-07-16', 'SIDRAP', '6285256953376', 'juna', '09a4b07cc37f30fb0538a6057c2e51a3'),
(3, '113', 'icul', 'Laki-Laki', '2024-07-16', 'SIDRAP MAJU', '6285256953376', 'icul', '68327e88c55bf54341ca6ae7bebf6101'),
(4, '114', 'iqbal', 'Laki-Laki', '2024-07-16', 'KM 3', '6285256953376', 'iqbal', 'eedae20fc3c7a6e9c5b1102098771c70'),
(5, '115', 'adi', 'Laki-Laki', '2024-07-16', 'Lahalede', '6285256953376', 'adi', 'c46335eb267e2e1cde5b017acb4cd799'),
(24, '116', 'ian', 'Laki-Laki', '2024-07-18', 'PERUMNAS', '6285256953376', 'ian', 'a71a448d3d8474653e831749b8e71fcc'),
(25, '117', 'cum', 'Laki-Laki', '2024-07-18', 'BANK', '6285256953376', 'cum', 'efde81f569ccb7211e56a522b8b55e5b');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tjm_menu`
--

CREATE TABLE `tjm_menu` (
  `id` int(11) NOT NULL,
  `parent_menu` int(11) NOT NULL DEFAULT 1,
  `nama_menu` varchar(50) NOT NULL,
  `url_menu` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `urutan` tinyint(3) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` enum('Admin') NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tjm_menu`
--

INSERT INTO `tjm_menu` (`id`, `parent_menu`, `nama_menu`, `url_menu`, `icon`, `urutan`, `status`, `type`) VALUES
(1, 1, 'root', '/', '', 0, 0, 'Admin'),
(2, 1, 'dashboard', 'admin/dashboard', 'fa fa-fw fa-dashboard', 1, 1, 'Admin'),
(3, 1, 'User Admin', 'admin/useradmin', 'fa fa-users', 2, 1, 'Admin'),
(4, 1, 'Data Pasien', 'admin/pasien', 'glyphicon glyphicon-user', 3, 1, 'Admin'),
(5, 1, 'Poli', 'admin/poli', 'glyphicon glyphicon-list-alt', 4, 1, 'Admin'),
(6, 1, 'Antrian Kajian Awal', 'admin/antrian_kajian_awal', 'glyphicon glyphicon-list', 5, 1, 'Admin'),
(7, 1, 'Antrian Poli', 'admin/antrian_poli', 'glyphicon glyphicon-list', 6, 1, 'Admin'),
(8, 1, 'Antrian Poli Gigi', 'admin/antrian_poli_gigi', 'glyphicon glyphicon-list', 7, 1, 'Admin'),
(9, 1, 'Antrian Poli KIA', 'admin/antrian_poli_kia', 'glyphicon glyphicon-list', 8, 1, 'Admin'),
(10, 1, 'Menu', 'admin/menu', 'fa fa-gear', 100, 1, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id_antrian`);

--
-- Indeks untuk tabel `antrian_poli`
--
ALTER TABLE `antrian_poli`
  ADD PRIMARY KEY (`id_antrian_poli`);

--
-- Indeks untuk tabel `kategori_poli`
--
ALTER TABLE `kategori_poli`
  ADD PRIMARY KEY (`id_poli`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indeks untuk tabel `tjm_menu`
--
ALTER TABLE `tjm_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id_antrian` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `antrian_poli`
--
ALTER TABLE `antrian_poli`
  MODIFY `id_antrian_poli` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `kategori_poli`
--
ALTER TABLE `kategori_poli`
  MODIFY `id_poli` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tjm_menu`
--
ALTER TABLE `tjm_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
