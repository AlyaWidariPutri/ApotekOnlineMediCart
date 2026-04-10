-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 08:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uapotek_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_obat` bigint(20) UNSIGNED NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga_beli` double NOT NULL,
  `subtotal` double NOT NULL,
  `id_pembelian` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id`, `id_obat`, `jumlah_beli`, `harga_beli`, `subtotal`, `id_pembelian`, `created_at`, `updated_at`) VALUES
(1, 4, 23434, 5543454, 129905301036, 1, '2026-04-07 22:38:24', '2026-04-07 22:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_penjualan` bigint(20) UNSIGNED NOT NULL,
  `id_obat` bigint(20) UNSIGNED NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga_beli` double NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id`, `id_penjualan`, `id_obat`, `jumlah_beli`, `harga_beli`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 2, 43200, 86400, '2026-04-06 22:18:08', '2026-04-06 22:18:08'),
(2, 1, 1, 2, 440, 880, '2026-04-06 22:18:08', '2026-04-06 22:18:08'),
(3, 2, 2, 1, 335, 335, '2026-04-07 00:20:00', '2026-04-07 00:20:00'),
(4, 3, 1, 1, 440, 440, '2026-04-07 00:59:50', '2026-04-07 00:59:50'),
(5, 4, 2, 16, 335, 5360, '2026-04-07 03:01:32', '2026-04-07 03:01:32'),
(6, 5, 6, 1, 43200, 43200, '2026-04-07 03:19:32', '2026-04-07 03:19:32'),
(7, 6, 4, 1, 14967, 14967, '2026-04-07 06:40:21', '2026-04-07 06:40:21'),
(8, 7, 8, 1, 188553, 188553, '2026-04-07 07:07:32', '2026-04-07 07:07:32'),
(9, 8, 6, 1, 43200, 43200, '2026-04-07 07:09:23', '2026-04-07 07:09:23'),
(10, 9, 6, 1, 43200, 43200, '2026-04-07 21:19:47', '2026-04-07 21:19:47'),
(11, 10, 4, 1, 14967, 14967, '2026-04-08 01:17:25', '2026-04-08 01:17:25'),
(12, 11, 2, 1, 335, 335, '2026-04-08 02:37:51', '2026-04-08 02:37:51'),
(13, 12, 2, 2, 335, 670, '2026-04-08 03:10:32', '2026-04-08 03:10:32'),
(14, 12, 1, 4, 440, 1760, '2026-04-08 03:10:33', '2026-04-08 03:10:33'),
(15, 13, 4, 1, 14967, 14967, '2026-04-09 03:46:00', '2026-04-09 03:46:00'),
(16, 13, 5, 1, 10702, 10702, '2026-04-09 03:46:00', '2026-04-09 03:46:00'),
(17, 13, 1, 1, 440, 440, '2026-04-09 03:46:00', '2026-04-09 03:46:00'),
(18, 14, 5, 1, 10702, 10702, '2026-04-09 04:09:32', '2026-04-09 04:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_distributor` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`id`, `nama_distributor`, `telepon`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'PT Sehat Sejahtera', '087654345678', 'Jl. Pegangsaan Timur, DKI Jakarta', '2026-04-07 07:31:14', '2026-04-07 07:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_obat`
--

CREATE TABLE `jenis_obat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `deskripsi_jenis` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_obat`
--

INSERT INTO `jenis_obat` (`id`, `jenis`, `deskripsi_jenis`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Obat Bebas', 'Logo warna hijau yang dilingkari garis hitam ini merupakan tanda obat bebas, yaitu obat yang dapat dijual bebas di apotek atau toko tanpa memerlukan resep dokter. Obat ini umumnya digunakan untuk mengatasi masalah kesehatan ringan pada masyarakat.', 'jenis_obat_images/roX7K9R8yYmEZrnueNsfPePsTro3hPjngDRssuwp.png', '2026-04-04 05:09:41', '2026-04-08 06:56:39'),
(2, 'Obat Bebas Terbatas', 'Logo warna biru yang dilingkari garis hitam ini merupakan obat bebas terbatas, yaitu kategori obat yang dapat dijual bebas, tetapi penggunaannya harus lebih hati-hati. Obat ini biasanya memiliki potensi efek samping yang lebih tinggi atau risiko ketergant', 'jenis_obat_images/2DdpT2RhX7XMQyTVlikJJGVBdr678tquXspq1ydj.jpg', '2026-04-04 07:32:36', '2026-04-04 07:32:36'),
(3, 'Obat Keras', 'Logo berwarna merah dengan huruf K merupakan obat keras yaitu obat yang berpotensi menimbulkan efek samping serius atau harus digunakan dengan pengawasan ketat. Ini termasuk obat-obatan yang memerlukan resep dokter untuk pengadaannya.', 'jenis_obat_images/JWdx6opUeM14trydprY1qysAEUPeb1TVLWVNN2pT.png', '2026-04-04 07:33:27', '2026-04-04 07:33:27'),
(4, 'Narkotika', 'Logo Plus Merah merupakan logo Narkotika yaitu obat yang memiliki potensi besar untuk menimbulkan ketergantungan fisik dan psikologis. Penggunaannya sangat dibatasi dan hanya dapat diperoleh dengan resep dokter yang khusus.', 'jenis_obat_images/8d8u6KbJSM9dPtkBsoX4OLEcbzPskbRhD9YAzLq1.jpg', '2026-04-04 07:34:00', '2026-04-04 07:34:00'),
(5, 'Obat Jamu', 'Logo bergambar daun berwarna hijau merupakan tanda obat jamu, yaitu produk yang terbuat dari bahan alami dan telah digunakan dalam tradisi pengobatan Indonesia. Obat ini tidak selalu memiliki klaim terapeutik yang terukur secara ilmiah.', 'jenis_obat_images/9dgJJb3TigW1LyD6ab3kgdsp8CRgg7ZNqOKDSbiU.jpg', '2026-04-04 07:34:35', '2026-04-04 07:37:41'),
(6, 'Obat Herbal Terstandar', 'Logo 3 bintang merupakan tanda obat herbal dihasilkan dari ekstrak tumbuhan atau senyawa alami yang digunakan untuk mengatasi berbagai penyakit atau meningkatkan kesehatan. Produk ini sering kali memiliki pengawasan yang lebih longgar dibandingkan obat me', 'jenis_obat_images/A3VWLThwvDOQrueO9wSHW5BObvEyDPldpkRY1NDw.jpg', '2026-04-04 07:36:00', '2026-04-04 07:38:03'),
(7, 'Obat Fitofarmaka', 'Logo salju berwarna hijau-kuning merupakan Fitofarmaka adalah obat yang terbuat dari bahan dasar tumbuhan yang telah dibuktikan dan teruji secara ilmiah untuk keamanan dan efektivitasnya. Kategori ini berada di antara obat herbal dan obat paten.', 'jenis_obat_images/bzkfC5PNS7JdVgQH1x1GqyUvmBDc3gRl0QQG7zeV.jpg', '2026-04-04 07:36:33', '2026-04-04 07:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengiriman`
--

CREATE TABLE `jenis_pengiriman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_kirim` enum('ekonomi','kargo','regular','same day','standar') NOT NULL,
  `nama_ekspedisi` varchar(255) NOT NULL,
  `kode_kurir` varchar(255) DEFAULT NULL,
  `layanan` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `logo_ekspedisi` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pengiriman`
--

INSERT INTO `jenis_pengiriman` (`id`, `jenis_kirim`, `nama_ekspedisi`, `kode_kurir`, `layanan`, `is_active`, `logo_ekspedisi`, `harga`, `created_at`, `updated_at`) VALUES
(12, 'regular', 'JNE', 'jne', 'REG', 1, '/images/logo/jne.png', 10000, '2026-04-06 21:25:08', '2026-04-06 21:25:08'),
(13, 'regular', 'JNE', 'jne', 'OKE', 1, '/images/logo/jne.png', 12000, '2026-04-06 21:25:08', '2026-04-06 21:25:08'),
(14, 'regular', 'JNE', 'jne', 'YES', 1, '/images/logo/jne.png', 15000, '2026-04-06 21:25:08', '2026-04-06 21:25:08'),
(15, 'regular', 'J&T', 'jnt', 'REG', 1, '/images/logo/jnt.png', 11000, '2026-04-06 21:25:08', '2026-04-06 21:25:08'),
(16, 'regular', 'SiCepat', 'sicepat', 'REG', 1, '/images/logo/sicepat.png', 9000, '2026-04-06 21:25:08', '2026-04-06 21:25:08'),
(17, 'regular', 'TIKI', 'tiki', 'REG', 1, '/images/logo/tiki.png', 13000, '2026-04-06 21:25:08', '2026-04-06 21:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` bigint(20) UNSIGNED NOT NULL,
  `id_obat` bigint(20) UNSIGNED NOT NULL,
  `jumlah_order` double NOT NULL,
  `harga` double NOT NULL,
  `subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `id_pelanggan`, `id_obat`, `jumlah_order`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
(21, 4, 4, 1, 14967, 14967, '2026-04-08 03:23:54', '2026-04-08 03:23:54'),
(23, 1, 8, 1, 188553, 188553, '2026-04-09 04:11:13', '2026-04-09 04:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `metode_bayar`
--

CREATE TABLE `metode_bayar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `metode_pembayaran` varchar(30) NOT NULL,
  `tempat_bayar` varchar(50) NOT NULL,
  `no_rekening` varchar(25) DEFAULT NULL,
  `url_logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metode_bayar`
--

INSERT INTO `metode_bayar` (`id`, `metode_pembayaran`, `tempat_bayar`, `no_rekening`, `url_logo`, `created_at`, `updated_at`) VALUES
(1, 'Bayar ditempat', 'COD', NULL, 'https://music.youtube.com/watch?v=MBbqqWqLPlI&list=RDAMVMHMQlkbXjSTM', '2026-04-05 19:35:37', '2026-04-05 19:35:37'),
(2, 'E-Wallet', 'GoPay', '08765434567', '/image/gopay', '2026-04-05 19:38:35', '2026-04-05 19:40:59'),
(3, 'E-Wallet', 'OVO', '08765434577', '/image/ovo', '2026-04-05 19:39:01', '2026-04-05 19:39:01'),
(4, 'E-Wallet', 'DANA', '08876543457', '/image/dana', '2026-04-05 19:40:46', '2026-04-05 19:40:46'),
(5, 'Virtual Account', 'BCA Virtual Account', '08765434567', '/image/va/bca', '2026-04-05 19:42:24', '2026-04-05 19:42:24'),
(6, 'Virtual Account', 'Mandiri Virtual Account', '08765434567', '/image/va/mandiri', '2026-04-05 19:42:47', '2026-04-05 19:42:47'),
(7, 'Virtual Account', 'Bri Virtual Account', '08765434567', '/image/va/BRI', '2026-04-05 19:43:09', '2026-04-05 19:43:09'),
(8, 'Pembayaran Instant', 'LinkAja', NULL, '/image/pi/linkaja', '2026-04-05 19:44:17', '2026-04-05 19:44:17'),
(9, 'Pembayaran Instant', 'QRIS', '08876543457', '/image/pi/qris', '2026-04-05 19:44:49', '2026-04-05 19:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_03_20_133732_create_metode_bayar_table', 1),
(6, '2025_03_20_133840_create_jenis_pengiriman_table', 1),
(7, '2025_03_20_140023_create_distributor_table', 1),
(8, '2025_03_20_140117_create_jenis_obat_table', 1),
(9, '2025_03_20_140254_create_obat_table', 1),
(10, '2025_03_20_140346_create_pelanggan_table', 1),
(11, '2025_03_20_140458_create_pembelian_table', 1),
(12, '2025_03_20_140551_create_keranjang_table', 1),
(13, '2025_03_20_140645_create_detail_pembelian_table', 1),
(14, '2025_03_20_141041_create_penjualan_table', 1),
(15, '2025_03_20_142820_create_pengiriman_table', 1),
(16, '2025_03_20_142856_create_detail_penjualan_table', 1),
(17, '2025_05_22_052730_add_harga_to_jenis_pengiriman_table', 1),
(18, '2026_04_03_234854_add_berat_to_obat_table', 1),
(19, '2026_04_04_090240_add_city_id_to_pelanggan_table', 1),
(20, '2026_04_04_201611_add_api_fields_to_jenis_pengiriman_table', 2),
(21, '2026_04_05_123631_add_kurir_fields_to_jenis_pengiriman', 3),
(22, '2026_04_06_091803_add_alamat2_and_alamat3_to_pelanggan_table', 4),
(23, '2026_04_07_022600_add_weight_to_obat_table', 5),
(24, '2026_04_08_151236_update_status_order_enum_in_penjualan_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `idjenis` bigint(20) UNSIGNED NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `deskripsi_obat` text NOT NULL,
  `foto1` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `berat` int(11) NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `idjenis`, `harga_jual`, `deskripsi_obat`, `foto1`, `foto2`, `foto3`, `stok`, `berat`, `created_at`, `updated_at`) VALUES
(1, 'Ibuprofen Novapharin', 3, 440, 'PENGGUNAAN OBAT INI HARUS SESUAI PETUNJUK DOKTER. Digunakan untuk mengurangi demam dan mengobati nyeri atau inflamasi yang disebabkan oleh berbagai kondisi seperti sakit kepala, sakit gigi, sakit punggung, arthritis (peradangan pada sendi), keram saat haid, atau luka minor.', 'obat_images/8WouniQRlAgJOb8o6FhPH30mdD9NXQGQsy1MjjDA.jpg', 'obat_images/8h0gnT8ptsVPcE6UCqm63gnl3PSobYlFDqupcGsa.png', NULL, 634, 4, '2026-04-04 07:40:53', '2026-04-09 03:46:00'),
(2, 'Antasida Doen Tablet', 1, 335, 'Efektif meredakan gejala asam lambung berlebih, seperti maag, nyeri ulu hati, mual, dan kembung. Mengandung kombinasi Aluminium Hydroxide dan Magnesium Hydroxide yang bekerja menetralkan asam lambung. Tersedia dalam bentuk tablet kunyah dan suspensi (cair).', 'obat_images/te5B684JyPXMCBItcYAE4tQVYhltgM9TFWWEVlHC.jpg', 'obat_images/SrOZ8au9cJsWk1tKP57CUiHFbE2Iydw2mjFb9ZUB.png', NULL, 56, 10, '2026-04-04 07:44:04', '2026-04-08 03:10:32'),
(4, 'Wybert Herbal Batuk Plus Sirup 60ml (per Botol)', 6, 14967, 'per 15 ml mengandung ekstrak setara: akar kayu manis 200mg, thymi herba 500mg, kencur 150mg, daun sirih 150mg, daun sembung 100mg, jeruk nipis 150mg, jahe 450mg, pala 150mg, minyak biji bunga matahari 400mg, cabejawa 200mg, menthol 15mg', 'obat_images/ZSd2pthHTdTk8O175embe3goKSKeMH8GTirACW07.jpg', 'obat_images/aCGSu6NrgPXdDYNKpY7014QJP0C9nJUoTKwkYsN1.jpg', 'obat_images/mQlk6UmFCfX8GKgVV8G6k5UtQM6W8Ng8Yc1fLtDN.jpg', 27196, 200, '2026-04-04 07:49:40', '2026-04-09 03:46:00'),
(5, 'Flutrop Kaplet (per Strip)', 2, 10702, 'Flutrop diproduksi oleh PT. Tropica Mas dan telah terdaftar pada BPOM. Pada setiap tablet Flutrop mengandung 30mg pseudoefedrin HCl dan 2,5mg triprolidin. Kombinasi antar kedua kandungan pada Flutrop dapat membantu meringankan gejala yang berhubungan dengan flu, sinusitis dan kondisi alergi. Flutrop juga berkhasiat untuk mengurangi pembengkakan pada mukosa rongga hidung dan membantu menghentikan gejala hidung berair (pilek)', 'obat_images/2sSt2uKTCpiL1F4kEYRpIda5VPPHBzFj8bOEQARS.jpg', 'obat_images/Eu9pVw6QAhMZBAFdPItwARzKroYAwd1Q7azNzvaZ.jpg', NULL, 8763, 10, '2026-04-04 07:56:42', '2026-04-09 04:09:32'),
(6, 'Stimuno Forte Kapsul Isi 10 Kapsul (per Strip)', 7, 43200, 'Stimuno Forte 10 Kapsul bermanfaat untuk meningkatkan kerja sistem imun atau sistem kekebalan tubuh.\r\n\r\nStimuno Forte 10 Kapsul mengandung ekstrak tanaman meniran hijau (Phyllanthus niruri), yang diyakini mampu mencegah dan mempercepat penyembuhan penyakit infeksi.', 'obat_images/t6z8yBJsh9oABuJz1aSRfQMQOmlysydKrpaZ3PYG.jpg', 'obat_images/4gllSiM9tmUJ8GrPFwwLlGlQSRgo6e4zujTgVJr0.jpg', NULL, 4, 10, '2026-04-04 08:02:11', '2026-04-07 21:19:47'),
(8, 'Ardium 500mg Tablet 1 Dos Isi 4 Strip 15 Tablet (per Strip)', 5, 188553, 'Ardium merupakan obat yang digunakan untuk mengatasi wasir agar tidak terjadi pembengkakan (hemorrhoid) di sekitar anus dan mengurangi varises atau peleberan pembuluh darah di kaki. Ardium mengandung kombinasi flavonoid murni yang telah di mikronisasi yaitu Diosmin dan Hesperidin yang didapat dari isolat buah citrus seperti jeruk atau lemon. Hesperidin diekstrasi dari buah citrus di mana Diosmin merupakan turunan amina biogenik dari Hesperidin yang berguna untuk pengobatan wasir. Diosmin bekerja dengan cara memperbaiki tegangan pembuluh darah vena, menghambat reaksi peradangan dan mengurangi permeabilitas kapiler. Selain itu, Diosmin juga berpotensi menghambat prostaglandin yang dapat mengurangi rasa nyeri pada wasir.', 'obat_images/7i5JMKUevzZ7tcTV9bG3mhoJJLjgCzRoqGNs19xV.jpg', 'obat_images/Derr1PPxVRY0jR6nZk4MEzo3grXbX2Q4i3MguO2a.jpg', NULL, 82, 10, '2026-04-04 08:43:06', '2026-04-07 21:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `katakunci` varchar(15) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat1` varchar(255) NOT NULL,
  `kota1` varchar(255) NOT NULL,
  `city_id` varchar(255) DEFAULT NULL,
  `propinsi1` varchar(255) NOT NULL,
  `kodepos1` varchar(255) NOT NULL,
  `kota2` varchar(255) DEFAULT NULL,
  `propinsi2` varchar(255) DEFAULT NULL,
  `kodepos2` varchar(255) DEFAULT NULL,
  `alamat2` text DEFAULT NULL,
  `kota3` varchar(255) DEFAULT NULL,
  `propinsi3` varchar(255) DEFAULT NULL,
  `kodepos3` varchar(255) DEFAULT NULL,
  `alamat3` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `url_ktp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama_pelanggan`, `email`, `katakunci`, `no_telp`, `alamat1`, `kota1`, `city_id`, `propinsi1`, `kodepos1`, `kota2`, `propinsi2`, `kodepos2`, `alamat2`, `kota3`, `propinsi3`, `kodepos3`, `alamat3`, `foto`, `url_ktp`, `created_at`, `updated_at`) VALUES
(1, 'four', 'four@gmail.com', 'd855e4324cf5bef', '94663720203', 'Jl. Masjid Irsyadul Ummah Rt. 05, Rw. 07, No. 75', 'KOTA DEPOK', NULL, 'JAWA BARAT', '16413', 'KAB. KEPAHIANG', 'BENGKULU', '777333', 'jalan jalan', 'KAB. KARO', 'SUMATERA UTARA', '5432', 'padang', 'uploads/profiles/1775509007.jpg', 'ktp-documents/hqSXHjhrXlRpfb4KTpslXwc0ldtvPzoYZ0yVMvvp.png', '2026-04-04 05:03:29', '2026-04-08 07:34:44'),
(3, 'alexa', 'alexa@gmail.com', '5e8667a439c68f5', '088765434567', 'nhhewjdw', 'KOTA CILEGON', NULL, 'BANTEN', '8764456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/profiles/1775594007.png', 'ktp-documents/qgFitjY7zU3Qj1hJGVHMluLi7pk2dQ0ELeGBfDpJ.png', '2026-04-07 20:32:59', '2026-04-07 20:36:46'),
(4, 'Donianto BN', 'doni@gmail.com', '25d55ad283aa400', '', '', '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-08 03:06:34', '2026-04-08 03:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nonota` varchar(100) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `total_bayar` double(15,2) NOT NULL,
  `id_distributor` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `nonota`, `tgl_pembelian`, `total_bayar`, `id_distributor`, `created_at`, `updated_at`) VALUES
(1, 'PB-20260408053824', '2026-04-08', 129905301036.00, 1, '2026-04-07 22:38:24', '2026-04-07 22:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_penjualan` bigint(20) UNSIGNED NOT NULL,
  `no_invoice` varchar(255) NOT NULL,
  `tgl_kirim` datetime DEFAULT NULL,
  `tgl_tiba` datetime DEFAULT NULL,
  `status_kirim` enum('Sedang Dikirim','Tiba di Tujuan') NOT NULL,
  `nama_kurir` varchar(30) NOT NULL,
  `telpon_kurir` varchar(15) NOT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id`, `id_penjualan`, `no_invoice`, `tgl_kirim`, `tgl_tiba`, `status_kirim`, `nama_kurir`, `telpon_kurir`, `bukti_foto`, `keterangan`, `created_at`, `updated_at`) VALUES
(7, 2, 'INV098574389', '2026-04-11 15:14:00', '2026-04-20 15:14:00', 'Sedang Dikirim', 'ubi', '087654567876', NULL, 'dd', '2026-04-08 08:15:00', '2026-04-08 08:15:00'),
(8, 9, 'INV5674832', '2026-04-29 15:16:00', '2026-04-08 15:16:53', 'Tiba di Tujuan', 'dodo', '087654567', 'bukti_pengiriman/qvww1RevBzHdJckrlzIXj42cM1KTLexYh0GSTHWQ.jpg', NULL, '2026-04-08 08:16:34', '2026-04-08 08:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_metode_bayar` bigint(20) UNSIGNED NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `url_resep` varchar(255) DEFAULT NULL,
  `ongkos_kirim` double NOT NULL,
  `biaya_app` double NOT NULL,
  `total_bayar` double NOT NULL,
  `status_order` enum('Menunggu Konfirmasi','Diproses','Menunggu Kurir','Sedang Dikirim','Selesai','Dibatalkan Pembeli','Dibatalkan Penjual','Bermasalah') DEFAULT 'Menunggu Konfirmasi',
  `keterangan_status` varchar(255) DEFAULT NULL,
  `id_jenis_kirim` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `id_metode_bayar`, `tgl_penjualan`, `url_resep`, `ongkos_kirim`, `biaya_app`, `total_bayar`, `status_order`, `keterangan_status`, `id_jenis_kirim`, `id_pelanggan`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-07', '/storage/resep/Ye57si6aTACshrYbsC5R6sXMblAz0litiLYV6IEZ.png', 0, 2429, 89709, 'Menunggu Kurir', 'Pesanan siap, menunggu kurir mengambil', 13, 1, '2026-04-06 22:18:08', '2026-04-08 02:47:52'),
(2, 2, '2026-04-07', NULL, 0, 2429, 2764, 'Diproses', 'Pesanan sedang dikirim oleh ubi', 14, 1, '2026-04-07 00:20:00', '2026-04-08 08:15:00'),
(3, 1, '2026-04-07', '/storage/resep/8HcJoAv3g4pE5voTyG4x9nzMmp4vr15ByjGLQMxD.png', 0, 2429, 2869, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 14, 1, '2026-04-07 00:59:50', '2026-04-07 00:59:50'),
(4, 4, '2026-04-07', NULL, 0, 2429, 7789, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 16, 1, '2026-04-07 03:01:32', '2026-04-07 03:01:32'),
(5, 8, '2026-04-07', NULL, 0, 2429, 45629, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 14, 1, '2026-04-07 03:19:32', '2026-04-07 03:19:32'),
(6, 1, '2026-04-07', NULL, 0, 1496.7, 16463.7, 'Menunggu Kurir', 'Pesanan siap, menunggu kurir mengambil', 12, 1, '2026-04-07 06:40:21', '2026-04-08 00:47:39'),
(7, 3, '2026-04-07', NULL, 0, 18855.3, 207408.3, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 13, 1, '2026-04-07 07:07:32', '2026-04-07 07:07:32'),
(8, 8, '2026-04-07', NULL, 0, 864, 44064, 'Diproses', 'Pesanan disetujui kasir, sedang diproses', 17, 1, '2026-04-07 07:09:23', '2026-04-08 03:24:10'),
(9, 1, '2026-04-08', NULL, 0, 864, 44064, 'Selesai', 'Pesanan telah sampai di tujuan', 13, 3, '2026-04-07 21:19:47', '2026-04-08 08:16:53'),
(10, 5, '2026-04-08', NULL, 0, 299.34, 15266.34, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 13, 3, '2026-04-08 01:17:25', '2026-04-08 01:17:25'),
(11, 3, '2026-04-08', NULL, 0, 6.7, 341.7, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 14, 3, '2026-04-08 02:37:51', '2026-04-08 02:37:51'),
(12, 5, '2026-04-08', '/storage/resep/TROMlF6FzqHz5hAKAOO9bF4aFWkcJOPgSVMn02mk.jpg', 0, 48.6, 2478.6, 'Menunggu Kurir', 'Pesanan siap, menunggu kurir mengambil', 14, 4, '2026-04-08 03:10:32', '2026-04-08 03:23:21'),
(13, 4, '2026-04-09', '/storage/resep/kYYoAw0kQg2L9NKF8O2ATiRUpjOLLwADBgGgpIXQ.jpg', 0, 522.18, 26631.18, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 13, 1, '2026-04-09 03:46:00', '2026-04-09 03:46:00'),
(14, 6, '2026-04-09', NULL, 0, 214.04, 10916.04, 'Menunggu Konfirmasi', 'Pesanan baru dibuat', 12, 1, '2026-04-09 04:09:32', '2026-04-09 04:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `jabatan` enum('admin','apoteker','karyawan','kasir','pemilik') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@yahoo.com', NULL, '$2y$12$vpK4x1OXYWA5R/hMvIYJ3uepVcmejDNrj1.8p.g/0.zi5OaN1OImm', NULL, 'admin', NULL, NULL),
(2, 'Apoteker', 'apoteker@yahoo.com', NULL, '$2y$12$ugkVia34kQFurBmpVRPHau/Y/6ZCn95EY0uVZehiaePfbFyM3d/DK', NULL, 'apoteker', NULL, NULL),
(3, 'Karyawan', 'karyawan@yahoo.com', NULL, '$2y$12$iVBBXYbUUI66c/ZFkiRIcOSHTK/Htqbw/jBkp/tIW8zbvJU7IcGuS', NULL, 'karyawan', NULL, NULL),
(4, 'Kasir', 'kasir@yahoo.com', NULL, '$2y$12$y6KxGX..TdI9DYMHeyfGMO7GBQUhNQ2MPIWE84Gz4y6YVfxVxFVN.', NULL, 'kasir', NULL, NULL),
(5, 'Pemilik', 'pemilik@yahoo.com', NULL, '$2y$12$zZuggKwgLMLvWavfZEOCvO2oJ0XPyEPRkmh7gZErvQEasOFoniuIu', NULL, 'pemilik', NULL, NULL),
(7, 'user1', 'user1@gmail.com', NULL, '$2y$12$94AVLfR7FtizO1RKsNGLSuiwqvhAOpZ3i7UJNgf2qRIK0JjDdNZda', NULL, 'kasir', '2026-04-07 19:59:20', '2026-04-07 19:59:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pembelian_id_obat_foreign` (`id_obat`),
  ADD KEY `detail_pembelian_id_pembelian_foreign` (`id_pembelian`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_penjualan_id_penjualan_foreign` (`id_penjualan`),
  ADD KEY `detail_penjualan_id_obat_foreign` (`id_obat`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_obat`
--
ALTER TABLE `jenis_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_pengiriman`
--
ALTER TABLE `jenis_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_id_pelanggan_foreign` (`id_pelanggan`),
  ADD KEY `keranjang_id_obat_foreign` (`id_obat`);

--
-- Indexes for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obat_idjenis_foreign` (`idjenis`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelanggan_email_unique` (`email`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelian_id_distributor_foreign` (`id_distributor`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengiriman_id_penjualan_foreign` (`id_penjualan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualan_id_metode_bayar_foreign` (`id_metode_bayar`),
  ADD KEY `penjualan_id_jenis_kirim_foreign` (`id_jenis_kirim`),
  ADD KEY `penjualan_id_pelanggan_foreign` (`id_pelanggan`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_obat`
--
ALTER TABLE `jenis_obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jenis_pengiriman`
--
ALTER TABLE `jenis_pengiriman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `metode_bayar`
--
ALTER TABLE `metode_bayar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_id_obat_foreign` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pembelian_id_pembelian_foreign` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_id_obat_foreign` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penjualan_id_penjualan_foreign` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_id_obat_foreign` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keranjang_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_idjenis_foreign` FOREIGN KEY (`idjenis`) REFERENCES `jenis_obat` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_id_distributor_foreign` FOREIGN KEY (`id_distributor`) REFERENCES `distributor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_id_penjualan_foreign` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_id_jenis_kirim_foreign` FOREIGN KEY (`id_jenis_kirim`) REFERENCES `jenis_pengiriman` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penjualan_id_metode_bayar_foreign` FOREIGN KEY (`id_metode_bayar`) REFERENCES `metode_bayar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penjualan_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
