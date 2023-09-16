-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Agu 2023 pada 07.25
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auto_responders`
--

CREATE TABLE `auto_responders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_id` char(36) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `type_keyword` enum('contains','equal') NOT NULL DEFAULT 'equal',
  `message_type` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `reply_when` enum('all','group','personal') NOT NULL DEFAULT 'all',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `auto_responders`
--

INSERT INTO `auto_responders` (`id`, `user_id`, `session_id`, `keyword`, `type_keyword`, `message_type`, `message`, `status`, `reply_when`, `created_at`, `updated_at`) VALUES
(4, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 'halo', 'contains', 'text', '{\"message\":\"Hai, dengan adit disini\",\"quoted\":\"yes\"}', 'active', 'all', '2023-07-08 05:53:41', '2023-07-08 05:53:41'),
(5, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 'Panduan', 'equal', 'media', '{\"url\":\"http:\\/\\/localhost\\/SIMP\\/app\\/storage?url=1\\/Cetak_Invoice_2023-07-06-1.xlsx\",\"media_type\":\"file\",\"caption\":\"Panduan sudah terlampir\"}', 'active', 'all', '2023-07-08 05:54:51', '2023-07-08 05:54:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulks`
--

CREATE TABLE `bulks` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_id` char(36) NOT NULL,
  `campaign_id` bigint(20) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message_type` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` enum('sent','invalid','failed','pending') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phonebook_id` bigint(20) NOT NULL,
  `message_type` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` enum('paused','completed','waiting','processing') NOT NULL,
  `delay` int(11) NOT NULL DEFAULT 0,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_id` char(36) NOT NULL,
  `label_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `session_id`, `label_id`, `name`, `number`, `created_at`, `updated_at`) VALUES
(89, 1, 'a02fa75a-cf3d-4804-837a-1e62345d697b', 2, 'Ratu', '6282310151507', '2023-06-30 12:07:42', '2023-06-30 12:07:42'),
(93, 1, 'a02fa75a-cf3d-4804-837a-1e62345d697b', 4, 'HADI', '082246925600', '2023-07-07 06:42:28', '2023-07-07 06:42:28'),
(101, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'BANK BJB', '6289654715638', '2023-07-08 05:34:12', '2023-07-08 05:34:12'),
(102, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'MPM FINANCE', '6285367214807', '2023-07-08 05:34:55', '2023-07-08 05:34:55'),
(103, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'Astra', '6285367215809', '2023-07-08 06:11:51', '2023-07-08 06:11:51'),
(104, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'PDAM', '6287354715645', '2023-07-08 19:17:51', '2023-07-08 19:17:51'),
(106, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'Freeport', '6287654332242', '2023-07-09 15:47:47', '2023-07-09 15:47:47'),
(107, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'Bank dki', '6288176713713', '2023-08-01 04:46:08', '2023-08-01 04:46:08'),
(108, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'BANK LAMPUNG', '6289654715639', '2023-08-01 13:26:43', '2023-08-01 13:26:43'),
(109, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 5, 'BANK ITU', '6285367214800', '2023-08-01 13:32:15', '2023-08-01 13:32:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact_labels`
--

CREATE TABLE `contact_labels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `session_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contact_labels`
--

INSERT INTO `contact_labels` (`id`, `user_id`, `session_id`, `title`, `created_at`, `updated_at`) VALUES
(5, 1, '3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 'Perusahaan', '2023-07-08 05:05:31', '2023-07-08 05:05:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_03_161743_create_sessions_table', 1),
(6, '2023_03_10_123538_create_auto_responders_table', 1),
(7, '2023_03_13_160432_create_contacts_table', 1),
(8, '2023_03_13_160438_create_contact_labels_table', 1),
(9, '2023_03_17_083540_create_campaigns_table', 1),
(10, '2023_03_17_163604_create_bulks_table', 1),
(11, '2023_06_30_220407_create_mitras_table', 2),
(12, '2023_07_01_195331_create_piutang_mitras_table', 3),
(13, '2023_07_02_140749_change_enum_columns_in_piutang_mitra_table', 4),
(14, '2023_07_03_160457_create_laporans_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mitra`
--

CREATE TABLE `mitra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `no_kontrak` varchar(255) NOT NULL,
  `masa_kontrak` varchar(200) NOT NULL,
  `nomor_hp` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mitra`
--

INSERT INTO `mitra` (`id`, `name`, `no_kontrak`, `masa_kontrak`, `nomor_hp`, `created_at`, `updated_at`) VALUES
(23, 'BANK BJB', 'PT0001', '2023-02-01 to 2025-02-01', 6289654715638, '2023-07-08 05:34:12', '2023-08-01 14:13:06'),
(24, 'MPM FINANCE', 'PT0002', '2023-09-01 to 2024-09-06', 6287643322552, '2023-07-08 05:34:55', '2023-08-01 14:13:50'),
(25, 'Astra', 'PT003', '2023-08-01 to 2025-08-01', 6285367215809, '2023-07-08 06:11:51', '2023-08-01 14:14:06'),
(33, 'BANK LAMPUNG', 'PT004', '2023-08-01 to 2025-08-01', 6289654715639, '2023-08-01 13:26:43', '2023-08-01 13:26:43'),
(35, 'BANK ITU', 'PT005', '2023-08-01 to 2025-08-01', 6285367214800, '2023-08-01 13:32:15', '2023-08-01 13:32:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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
-- Struktur dari tabel `piutang_mitra`
--

CREATE TABLE `piutang_mitra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mitra_id` int(10) UNSIGNED NOT NULL,
  `item` int(10) UNSIGNED NOT NULL,
  `besar_uang` int(10) UNSIGNED DEFAULT NULL,
  `jenis_layanan` enum('Express','SKH') NOT NULL,
  `status` enum('Belum Bayar','Sudah Bayar') NOT NULL,
  `status_validasi` enum('Belum Validasi','Tervalidasi','Tidak Valid') NOT NULL,
  `tgl_mulai_piutang` date DEFAULT NULL,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_temp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `piutang_mitra`
--

INSERT INTO `piutang_mitra` (`id`, `mitra_id`, `item`, `besar_uang`, `jenis_layanan`, `status`, `status_validasi`, `tgl_mulai_piutang`, `tgl_jatuh_tempo`, `created_at`, `updated_at`, `status_temp`) VALUES
(25, 23, 2, 48000, 'Express', 'Sudah Bayar', 'Tervalidasi', '2023-07-08', '2023-08-05', '2023-07-08 05:35:57', '2023-07-08 19:13:09', NULL),
(26, 24, 46, 542000, 'SKH', 'Sudah Bayar', 'Tervalidasi', '2023-07-09', '2023-08-05', '2023-07-08 05:36:29', '2023-07-08 19:13:20', NULL),
(27, 25, 23, 720000, 'Express', 'Belum Bayar', 'Tervalidasi', '2023-07-09', '2023-07-11', '2023-07-08 18:45:54', '2023-07-08 19:13:25', NULL),
(28, 23, 24, 1200000, 'Express', 'Belum Bayar', 'Belum Validasi', '2023-07-09', '2023-08-05', '2023-07-08 18:59:18', '2023-08-01 15:19:21', NULL),
(29, 23, 21, 3450000, 'Express', 'Belum Bayar', 'Belum Validasi', '2023-07-09', '2023-08-05', '2023-07-08 19:04:55', '2023-07-08 19:04:55', NULL),
(30, 25, 34, 560000, 'Express', 'Belum Bayar', 'Belum Validasi', '2023-07-10', '2023-08-05', '2023-07-09 01:33:11', '2023-08-01 14:15:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` char(36) NOT NULL,
  `session_name` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` enum('CONNECTED','STOPPED') NOT NULL DEFAULT 'STOPPED',
  `webhook` text DEFAULT NULL,
  `api_key` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `session_name`, `whatsapp_number`, `user_id`, `status`, `webhook`, `api_key`, `created_at`, `updated_at`) VALUES
('3285fa58-ffe0-4df7-ba9e-ba81300ec1f9', 'Adit', '6289654715638', 1, 'CONNECTED', NULL, '5d1c3e3e392c1fbe6af7c7183da0da55a31b6c37', '2023-07-08 05:02:53', '2023-07-12 01:28:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `password` varchar(255) NOT NULL,
  `limit_device` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `limit_device`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Piutang', 'admin', 'admin', '$2y$10$nUdFFxJq8WHUJ29Twk4ZGuQCIO3RpdG4sqVvoB2PWmR0xgXKeqO.a', NULL, 'xpwsSrVjTZYPNgU8g9XHv1sWTwziJy894opkgFxTG8DrR7wW50ZV3M3KnbQ2', '2023-06-30 09:15:10', '2023-07-09 01:58:57'),
(3, 'Manajer Korporat dan Penjualan', 'manajer', 'user', '$2y$10$6TT3eI1Opb/lnBciliDaGOlShq74BfqA4BEXmM5YJo20.dMozwU42', NULL, NULL, '2023-07-09 01:57:47', '2023-07-09 01:57:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auto_responders`
--
ALTER TABLE `auto_responders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bulks`
--
ALTER TABLE `bulks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `contact_labels`
--
ALTER TABLE `contact_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mitra_no_kontrak_unique` (`no_kontrak`),
  ADD UNIQUE KEY `mitra_nomor_hp_unique` (`nomor_hp`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `piutang_mitra`
--
ALTER TABLE `piutang_mitra`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sessions_api_key_unique` (`api_key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auto_responders`
--
ALTER TABLE `auto_responders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT untuk tabel `contact_labels`
--
ALTER TABLE `contact_labels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `piutang_mitra`
--
ALTER TABLE `piutang_mitra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
