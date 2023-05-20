-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Mar 2023 pada 07.39
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_olahraga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email`, `no_hp`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 84273821),
(2, 'admin2', '12345', 'admin2@gmail.com', 81921167),
(3, 'admin3', '54321', 'admin3@gmail.com', 123456);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(10) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `harga` int(100) NOT NULL,
  `jumlah_barang` int(100) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `kategori`, `harga`, `jumlah_barang`, `gambar`) VALUES
(1, 'Raket Yonex Gr 303', 'Badminton', 140000, 55, '84333995e96a0ec7d0a706489ff6c90e.jpg'),
(2, 'Raket Li-Ning XP 2020', 'Badminton', 110000, 50, '73b60b4c6f239260c400171538e53cd6.jpg'),
(5, 'TAS RAKET 2R VC THERMO D300', 'Badminton', 180000, 60, '1ecd4f1b2d160e8732544612a35816ec.jpg'),
(6, 'Bola Adidas AL RIHLA Qatar 2022', 'Sepak Bola', 100000, 49, 'd5bc88a007a712fda6e1f999905ff7c8.jpg'),
(7, 'Frasser Cones', 'Sepak Bola', 7000, 50, 'f97dfcd9d1a3ef4ff85faea73dd25538.jpg'),
(8, 'Stick Baseball ROX', 'Baseball', 115000, 50, '6b715dbe43534c082a03aa20592cb060.png'),
(9, 'Bola Basket Ballerbro MZ7', 'Basket', 300000, 50, '3637576ab61083acd550a9b7f5c26e3f.jpg'),
(10, 'Dumbell Plastik 5 kg', 'Angkat Beban', 38000, 50, '98fbc3128148c87b17bf28193897012e.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_barang`, `nama_barang`, `tanggal`, `jumlah_barang`) VALUES
(4, 2, 'Raket Li-Ning XP 2020', '2023-01-09', 10),
(5, 5, 'TAS RAKET 2R VC THERMO D300', '2023-01-11', 10),
(6, 1, 'Raket Yonex Gr 303', '2023-01-11', 10),
(7, 1, 'Raket Yonex Gr 303', '2023-01-11', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `jumlah_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_barang`, `nama_barang`, `tanggal`, `jumlah_barang`) VALUES
(3, 1, 'Raket Yonex Gr 303', '2023-01-09', 2),
(4, 1, 'Raket Yonex Gr 303', '2023-01-11', 1),
(5, 6, 'Bola Adidas AL RIHLA Qatar 2022', '2023-01-11', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
