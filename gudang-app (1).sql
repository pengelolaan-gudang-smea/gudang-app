-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2024 at 02:10 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'Menambahkan anggaran', 'App\\Models\\Anggaran', 'created', 1, NULL, NULL, '[]', NULL, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(2, 'default', 'Menambahkan limit anggaran di Rekayasa Perangkat Lunak', 'App\\Models\\Limit', 'created', 1, NULL, NULL, '[]', NULL, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(3, 'default', 'Menambahkan anggaran', 'App\\Models\\Anggaran', 'created', NULL, 'App\\Models\\User', 4, '[]', NULL, '2024-09-12 03:58:26', '2024-09-12 03:58:26'),
(4, 'default', 'Menambahkan anggaran', 'App\\Models\\Anggaran', 'created', 2, 'App\\Models\\User', 4, '[]', NULL, '2024-09-12 03:58:26', '2024-09-12 03:58:26'),
(5, 'default', 'Menambahkan limit anggaran di Desain Komunikasi Visual', 'App\\Models\\Limit', 'created', 2, 'App\\Models\\User', 4, '[]', NULL, '2024-09-12 04:03:13', '2024-09-12 04:03:13'),
(6, 'default', 'Mengajukan barang', 'App\\Models\\Barang', 'created', NULL, 'App\\Models\\User', 3, '{\"attributes\": {\"name\": \"Mouse\", \"spek\": \"Lorem ipsum\", \"harga\": \"60000\", \"stock\": \"15\"}}', NULL, '2024-09-24 16:16:44', '2024-09-24 16:16:44'),
(7, 'default', 'Menghapus barang', 'App\\Models\\Barang', 'deleted', NULL, 'App\\Models\\User', 3, '{\"old\": {\"name\": \"Monitor\", \"spek\": \"Lorem ipsum dolor sit amet\", \"harga\": 1000000, \"stock\": 3, \"satuan\": \"Buah\"}}', NULL, '2024-09-28 11:16:19', '2024-09-28 11:16:19'),
(8, 'default', 'Menambahkan barang gudang', 'App\\Models\\BarangGudang', 'created', NULL, 'App\\Models\\User', 5, '{\"attributes\": {\"name\": \"Kabel\", \"spek\": \"Tes\", \"tahun\": \"2024\", \"satuan\": \"Meter\"}}', NULL, '2024-09-28 19:19:53', '2024-09-28 19:19:53'),
(9, 'default', 'Menambahkan user', 'App\\Models\\User', 'created', NULL, 'App\\Models\\User', 1, '{\"attributes\": {\"name\": \"Multimedia\", \"email\": \"dkv@skansaba.dev\", \"username\": \"dkv\"}}', NULL, '2024-10-08 13:35:18', '2024-10-08 13:35:18'),
(10, 'default', 'Menyetujui barang yang diajukan oleh rpl', 'App\\Models\\Barang', 'accepted', NULL, 'App\\Models\\User', 4, '{\"attributes\": {\"name\": \"Mouse\", \"spek\": \"Lorem ipsum\", \"harga\": 60000, \"satuan\": \"Pcs\"}}', NULL, '2024-10-08 13:39:24', '2024-10-08 13:39:24'),
(11, 'default', 'Menolak barang yang diajukan oleh admingudang', 'App\\Models\\Barang', 'rejected', NULL, 'App\\Models\\User', 4, '{\"attributes\": {\"name\": \"Headset\", \"spek\": \"Lorem ipsum dolor sit amet\", \"harga\": 80000, \"satuan\": \"Buah\"}}', NULL, '2024-10-08 13:41:12', '2024-10-08 13:41:12'),
(12, 'default', 'Mengajukan barang', 'App\\Models\\Barang', 'created', NULL, 'App\\Models\\User', 6, '{\"attributes\": {\"name\": \"Baterai Kamera Canon EOS\", \"spek\": \"Baterai Canon keren mantap\", \"harga\": \"150000\", \"stock\": \"5\"}}', NULL, '2024-10-08 13:45:03', '2024-10-08 13:45:03'),
(13, 'default', 'Menambahkan kode QR ', 'App\\Models\\BarangGudang', 'created', NULL, 'App\\Models\\User', 5, '[]', NULL, '2024-10-08 13:58:49', '2024-10-08 13:58:49'),
(14, 'default', 'Barang diterima oleh Bu Dinda', 'App\\Models\\BarangGudang', 'edited', NULL, 'App\\Models\\User', 5, '{\"attributes\": {\"penerima\": \"Bu Dinda\"}}', NULL, '2024-10-08 14:00:26', '2024-10-08 14:00:26'),
(15, 'default', 'Barang diambil oleh petugas lapangan  ', 'App\\Models\\BarangGudang', 'edited', NULL, 'App\\Models\\User', 5, '[]', NULL, '2024-10-08 14:01:29', '2024-10-08 14:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `anggaran` double NOT NULL,
  `jenis_anggaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id`, `anggaran`, `jenis_anggaran`, `tahun`, `created_at`, `updated_at`) VALUES
(1, 10000000, 'APBD', 2024, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(2, 15000000, 'APBN', 2024, '2024-09-12 03:58:26', '2024-09-12 03:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_inventaris` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_rekening` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spek` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `stock` int NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum disetujui',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_barang` enum('Aset','Persediaan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jurusan_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `name`, `slug`, `no_inventaris`, `kode_barang`, `kode_rekening`, `spek`, `harga`, `stock`, `satuan`, `sub_total`, `status`, `keterangan`, `expired`, `tujuan`, `jenis_barang`, `anggaran_id`, `user_id`, `jurusan_id`, `created_at`, `updated_at`) VALUES
(1, 'Mouse', 'mouse', 'BRG-202409-0001', 'BRG-RPL-01-2024', '0864214679', 'Lorem ipsum', 60000, 15, 'Pcs', '900000', 'Disetujui', '15', '2024-12-01', 'Lab RPL', 'Aset', 1, 3, 1, '2024-09-24 16:16:44', '2024-10-08 13:39:24'),
(3, 'Monitor', 'monitor', 'BRG-202409-0002', 'RPL-EXCEL-TES', '9872323', 'Lorem ipsum dolor sit amet', 1000000, 3, 'Buah', '3000000', 'Belum disetujui', NULL, '2024-12-31', 'Lab 10', 'Aset', NULL, 3, 1, '2024-09-28 11:23:44', '2024-09-28 11:23:44'),
(4, 'Kertas', 'kertas', 'BRG-202409-0003', 'RPL-EXCEL-TES-2', '2362372', 'Kertas HVS', 25000, 5, 'Lusin', '125000', 'Belum disetujui', NULL, '2025-02-28', NULL, 'Persediaan', NULL, 3, 1, '2024-09-28 11:23:44', '2024-09-28 11:23:44'),
(9, 'Headset', 'headset', 'BRG-202409-0004', 'RPL-IMPORT-GUDANG', '763743478', 'Lorem ipsum dolor sit amet', 80000, 5, 'Buah', '400000', 'Ditolak', 'Barang tidak memenuhi kriteria', NULL, 'Kantor RPL', 'Aset', 1, 5, 1, '2024-09-28 19:17:36', '2024-10-08 13:41:12'),
(10, 'Baterai Kamera Canon EOS', 'baterai-kamera-canon-eos', 'BRG-202410-0005', 'BRG-DKV-001-24', '3145367132', 'Baterai Canon keren mantap', 150000, 5, 'Buah', '750000', 'Belum disetujui', NULL, '2025-01-01', 'Lab PK', 'Aset', NULL, 6, 3, '2024-10-08 13:45:03', '2024-10-08 13:45:03'),
(11, 'Printer', 'printer', 'BRG-202410-0006', 'BRG-DKV-002-24', '2632873238', 'Lorem ipsum dolor sit amet', 2000000, 1, 'Buah', '2000000', 'Belum disetujui', NULL, '2024-11-30', 'Kantor Multimedia', 'Aset', NULL, 6, 3, '2024-10-08 13:54:18', '2024-10-08 13:54:18'),
(12, 'Kertas HVS', 'kertas-hvs', 'BRG-202410-0007', 'BRG-DKV-003-24', '2423874387', 'Lorem ipsum dolor sit amet', 120000, 1, 'Dus', '120000', 'Belum disetujui', NULL, '2024-12-31', 'Kantor Multimedia', 'Persediaan', NULL, 6, 3, '2024-10-08 13:54:19', '2024-10-08 13:54:19'),
(13, 'Flash', 'flash', 'BRG-202410-0008', 'BRG-DKV-004-24', '2387243272', 'Lorem ipsum dolor sit amet', 90000, 3, 'Pcs', '270000', 'Belum disetujui', NULL, '2025-02-28', 'Gudang Multimedia', 'Aset', NULL, 6, 3, '2024-10-08 13:54:19', '2024-10-08 13:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `barang_gudang`
--

CREATE TABLE `barang_gudang` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_inventaris` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spek` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_awal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_akhir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_diambil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_barang` enum('Aset','Persediaan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran_id` bigint UNSIGNED DEFAULT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_faktur` date DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penerima` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `saldo_keluar` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_rekening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_gudang`
--

INSERT INTO `barang_gudang` (`id`, `uuid`, `barang_id`, `name`, `no_inventaris`, `slug`, `spek`, `stock_awal`, `stock_akhir`, `satuan`, `barang_diambil`, `jurusan_id`, `tujuan`, `jenis_barang`, `anggaran_id`, `qr_code`, `tahun`, `tgl_faktur`, `lokasi`, `penerima`, `tgl_masuk`, `saldo_keluar`, `created_at`, `updated_at`, `kode_barang`, `kode_rekening`) VALUES
(2, 'c41d750c-7ac2-40b7-b28f-77441abd76c0', NULL, 'Kabel', 'BRG-202409-0002', 'kabel', 'Tes', '2', '2', 'Meter', NULL, NULL, NULL, 'Persediaan', 2, NULL, '2024', '2024-09-30', 'Kantor RPL', 'Roshit', '2024-09-27', 500000, '2024-09-28 19:19:53', '2024-10-08 14:03:16', 'BRG-RPL-02-2025', '2987322'),
(3, '743206eb-fe4c-40c1-9520-25d64bcbb8d6', 1, 'Mouse', 'BRG-202410-0003', 'mouse', 'Lorem ipsum', '15', '0', 'Pcs', 'Rosyid', 1, 'Lab 10, Lab 9', 'Aset', 1, 'qr_codes/1728395929_qr.png', '2024', '2024-10-08', 'Gudang RPL', 'Bu Dinda', NULL, NULL, '2024-10-08 13:39:24', '2024-10-08 14:01:29', 'BRG-RPL-01-2024', '0864214679');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pengambil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pengambilan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pengambilan` date NOT NULL,
  `qrCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `nama_barang`, `nama_pengambil`, `tujuan`, `jumlah_pengambilan`, `tgl_pengambilan`, `qrCode`, `created_at`, `updated_at`) VALUES
(1, 'Mouse', 'Rosyid', 'Lab 10, Lab 9', '15', '2024-10-08', 'qr_codes/1728395929_qr.png', '2024-10-08 14:01:29', '2024-10-08 14:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_anggaran`
--

CREATE TABLE `jenis_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_anggaran`
--

INSERT INTO `jenis_anggaran` (`id`, `name`, `tahun`, `created_at`, `updated_at`) VALUES
(1, 'APBD', '2024', '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(2, 'APBN', '2024', '2024-09-12 03:54:21', '2024-09-12 03:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Rekayasa Perangkat Lunak', 'rekayasa-perangkat-lunak', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(2, 'Teknik Komputer dan Jaringan', 'teknik-komputer-dan-jaringan', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(3, 'Desain Komunikasi Visual', 'desain-komunikasi-visual', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(4, 'Akuntansi Keuangan Lembaga', 'akuntansi-keuangan-lembaga', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(5, 'Layanan Perbankan Syariah', 'layanan-perbankan-syariah', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(6, 'Manajemen Perkantoran', 'manajemen-perkantoran', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(7, 'Bisnis Ritel', 'bisnis-ritel', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(8, 'Bisnis Daring', 'bisnis-daring', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(9, 'Normada', 'normada', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(11, 'Perpustakaan', 'perpustakaan', '2024-10-08 13:36:28', '2024-10-08 13:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `limit_anggaran`
--

CREATE TABLE `limit_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `limit` double NOT NULL,
  `jurusan_id` bigint UNSIGNED NOT NULL,
  `anggaran_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `limit_anggaran`
--

INSERT INTO `limit_anggaran` (`id`, `limit`, `jurusan_id`, `anggaran_id`, `created_at`, `updated_at`) VALUES
(1, 8000000, 1, 1, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(2, 10000000, 3, 2, '2024-09-12 04:03:13', '2024-09-12 04:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_07_29_123909_jurusan', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_01_26_191037_create_barang_keluar__table', 1),
(7, '2022_12_04_202949_create_jenis_anggarans_table', 1),
(8, '2023_09_29_124704_anggaran', 1),
(9, '2023_10_05_153833_create_permission_tables', 1),
(10, '2023_10_06_151724_barang', 1),
(11, '2023_11_04_042954_limit_anggaran', 1),
(12, '2023_11_20_125658_barang_gudang', 1),
(13, '2023_12_01_093732_create_activity_log_table', 1),
(14, '2023_12_01_093733_add_event_column_to_activity_log_table', 1),
(15, '2023_12_01_093734_add_batch_uuid_column_to_activity_log_table', 1),
(16, '2023_12_01_134935_rekap_login', 1),
(17, '2024_07_18_215438_create_saldos_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Edit akun', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(2, 'Mengajukan barang', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(3, 'Menyetujui barang', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(4, 'Barang gudang', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap_login`
--

CREATE TABLE `rekap_login` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `login` timestamp NOT NULL,
  `logout` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekap_login`
--

INSERT INTO `rekap_login` (`id`, `user_id`, `login`, `logout`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-09-12 04:33:47', '2024-09-12 04:34:10', '2024-09-12 04:33:47', '2024-09-12 04:34:10'),
(2, 3, '2024-09-12 04:34:20', NULL, '2024-09-12 04:34:20', '2024-09-12 04:34:20'),
(3, 1, '2024-09-23 16:12:19', NULL, '2024-09-23 16:12:19', '2024-09-23 16:12:19'),
(4, 3, '2024-09-24 16:09:31', NULL, '2024-09-24 16:09:32', '2024-09-24 16:09:32'),
(5, 5, '2024-09-27 18:16:49', '2024-09-27 18:18:21', '2024-09-27 18:16:49', '2024-09-27 18:18:21'),
(6, 3, '2024-09-27 18:18:28', NULL, '2024-09-27 18:18:28', '2024-09-27 18:18:28'),
(7, 3, '2024-09-28 10:06:51', '2024-09-28 11:42:32', '2024-09-28 10:06:51', '2024-09-28 11:42:32'),
(8, 5, '2024-09-28 11:42:40', NULL, '2024-09-28 11:42:40', '2024-09-28 11:42:40'),
(9, 5, '2024-09-28 16:53:02', '2024-09-28 19:20:53', '2024-09-28 16:53:02', '2024-09-28 19:20:53'),
(10, 3, '2024-09-28 19:21:04', NULL, '2024-09-28 19:21:04', '2024-09-28 19:21:04'),
(11, 3, '2024-09-29 06:58:48', '2024-09-29 06:59:02', '2024-09-29 06:58:48', '2024-09-29 06:59:02'),
(12, 4, '2024-09-29 06:59:14', '2024-09-29 07:02:23', '2024-09-29 06:59:14', '2024-09-29 07:02:23'),
(13, 1, '2024-10-08 13:33:06', '2024-10-08 13:35:32', '2024-10-08 13:33:06', '2024-10-08 13:35:32'),
(14, 4, '2024-10-08 13:35:42', '2024-10-08 13:41:36', '2024-10-08 13:35:42', '2024-10-08 13:41:36'),
(15, 6, '2024-10-08 13:41:46', '2024-10-08 13:56:27', '2024-10-08 13:41:46', '2024-10-08 13:56:27'),
(16, 3, '2024-10-08 13:56:33', '2024-10-08 13:57:22', '2024-10-08 13:56:33', '2024-10-08 13:57:22'),
(17, 5, '2024-10-08 13:57:34', NULL, '2024-10-08 13:57:34', '2024-10-08 13:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(2, 'WAKA', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(3, 'Pengajuan barang', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(4, 'Admin anggaran', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(5, 'Admin gudang', 'web', '2024-09-12 03:54:20', '2024-09-12 03:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saldos`
--

CREATE TABLE `saldos` (
  `id` bigint UNSIGNED NOT NULL,
  `saldo_masuk` int NOT NULL,
  `anggaran_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `jurusan_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Wakil Kepala Sekolah', 'waka', 'waka@gmail.com', '$2y$10$ipXVraQsHyN1EzpBMy6/DO.T6U.qXauFLlAYt0/ossrwWOCebbxU2', NULL, NULL, '2024-09-12 03:54:20', '2024-09-12 03:54:20'),
(2, 'Super Admin', 'root', 'root@gmail.com', '$2y$10$bLsNHKhYYCIJ0rcg0kNtue9HejLNk0aRnpeuIrflQtPYcIZeLwr2C', NULL, NULL, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(3, 'pak haris', 'rpl', 'rpl@gmail.com', '$2y$10$wI/JN.OEoxBGF5pKEamTd.0Jd1fC6UnBjSz.8z5dTEk5TyoM/cjqi', 1, NULL, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(4, 'Admin Anggaran 1', 'adminanggaran', 'adminanggaran@gmail.com', '$2y$10$pJ3OltpBUG6x.qNfdFqkHuJuVDYU/xWX8vA8eRjS/9GaR76/cgOYe', NULL, NULL, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(5, 'Admin Gudang', 'admingudang', 'admingudang@gmail.com', '$2y$10$QwNCw25MBdniDtKf/mIl4OEutSdAEVclhHoq90LqdkIot8hiXnPwC', NULL, NULL, '2024-09-12 03:54:21', '2024-09-12 03:54:21'),
(6, 'Multimedia', 'dkv', 'dkv@skansaba.dev', '$2y$10$mkx3vDHK0MsH/vtDfB9ddOLLcxvCv2i0njATCpBcIvXkNQfX4lRpS', 3, NULL, '2024-10-08 13:35:18', '2024-10-08 13:35:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_anggaran_id_foreign` (`anggaran_id`),
  ADD KEY `barang_user_id_foreign` (`user_id`),
  ADD KEY `barang_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `barang_gudang`
--
ALTER TABLE `barang_gudang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_gudang_barang_id_foreign` (`barang_id`),
  ADD KEY `barang_gudang_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `barang_gudang_anggaran_id_foreign` (`anggaran_id`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_anggaran`
--
ALTER TABLE `jenis_anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limit_anggaran`
--
ALTER TABLE `limit_anggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `limit_anggaran_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `limit_anggaran_anggaran_id_foreign` (`anggaran_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rekap_login`
--
ALTER TABLE `rekap_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekap_login_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `saldos`
--
ALTER TABLE `saldos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saldos_anggaran_id_foreign` (`anggaran_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_jurusan_id_foreign` (`jurusan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `barang_gudang`
--
ALTER TABLE `barang_gudang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_anggaran`
--
ALTER TABLE `jenis_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `limit_anggaran`
--
ALTER TABLE `limit_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap_login`
--
ALTER TABLE `rekap_login`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `saldos`
--
ALTER TABLE `saldos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_anggaran_id_foreign` FOREIGN KEY (`anggaran_id`) REFERENCES `anggaran` (`id`),
  ADD CONSTRAINT `barang_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`),
  ADD CONSTRAINT `barang_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_gudang`
--
ALTER TABLE `barang_gudang`
  ADD CONSTRAINT `barang_gudang_anggaran_id_foreign` FOREIGN KEY (`anggaran_id`) REFERENCES `anggaran` (`id`),
  ADD CONSTRAINT `barang_gudang_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_gudang_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `limit_anggaran`
--
ALTER TABLE `limit_anggaran`
  ADD CONSTRAINT `limit_anggaran_anggaran_id_foreign` FOREIGN KEY (`anggaran_id`) REFERENCES `anggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `limit_anggaran_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rekap_login`
--
ALTER TABLE `rekap_login`
  ADD CONSTRAINT `rekap_login_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saldos`
--
ALTER TABLE `saldos`
  ADD CONSTRAINT `saldos_anggaran_id_foreign` FOREIGN KEY (`anggaran_id`) REFERENCES `anggaran` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
