-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Feb 2026 pada 13.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_karyawan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('hadir','terlambat','izin','cuti','alfa') DEFAULT 'hadir',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `tanggal`, `check_in`, `check_out`, `status`, `created_at`) VALUES
(1, 5, '2026-02-02', '09:51:31', '09:51:34', 'terlambat', '2026-02-02 08:51:31'),
(2, 2, '2026-02-02', '13:23:00', '13:23:07', 'terlambat', '2026-02-02 12:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') DEFAULT 'karyawan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@company.com', '$2y$10$FOKnp337eAZzbHtpgziud.KsOvGN.zaF6syybMjheR2eakyQqr63e', 'admin', '2026-02-01 07:27:07'),
(2, 'Budi Santoso', 'budi@company.com', '$2y$10$Z4jCEGhZYlJiPoO5lQ1aAeFLiOhTX/pxQ2otPZvNPI5KO4OV0V6TS', 'karyawan', '2026-02-01 07:27:09'),
(3, 'Siti Nurhaliza', 'siti@company.com', '$2y$10$Z4jCEGhZYlJiPoO5lQ1aAeFLiOhTX/pxQ2otPZvNPI5KO4OV0V6TS', 'karyawan', '2026-02-01 07:27:09'),
(4, 'Ahmad Wijaya', 'ahmad@company.com', '$2y$10$Z4jCEGhZYlJiPoO5lQ1aAeFLiOhTX/pxQ2otPZvNPI5KO4OV0V6TS', 'karyawan', '2026-02-01 07:27:09'),
(5, 'apalah', 'apalah@gmail.com', '$2y$10$1HunaYgyxPtnLChyAaB4cO5.vrsl5WPs.gVSg59klbudlMqDzMcF.', 'admin', '2026-02-02 08:50:57'),
(6, 'cecep', 'cecep@gmail.com', '$2y$10$NEoa.7v0ovu8pLYGrzqF..5y.BL3IGd2DMnIbweUfa.uV1mfnLe1e', 'karyawan', '2026-02-02 09:13:51'),
(11, 'becak', 'becak@gmail.com', '$2y$10$97TORAuqDm542dMDqbctCukQziJGKbfftmtWdh2FKbmj1yq/vkV2e', 'karyawan', '2026-02-02 12:19:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`user_id`,`tanggal`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
