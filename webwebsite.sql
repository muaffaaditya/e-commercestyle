-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 03:04 AM
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
-- Database: `webwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_milestones`
--

CREATE TABLE `about_milestones` (
  `id` int(11) NOT NULL,
  `year_range` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `order_num` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_settings`
--

CREATE TABLE `about_settings` (
  `id` int(11) NOT NULL,
  `hero_title_white` text DEFAULT NULL,
  `hero_title_gradient` text DEFAULT NULL,
  `hero_description` text DEFAULT NULL,
  `spotlight_title` varchar(255) DEFAULT NULL,
  `spotlight_description` text DEFAULT NULL,
  `chairman_image` varchar(255) DEFAULT NULL,
  `chairman_experience` varchar(50) DEFAULT NULL,
  `cta_banner_title` varchar(255) DEFAULT NULL,
  `cta_banner_desc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_settings`
--

INSERT INTO `about_settings` (`id`, `hero_title_white`, `hero_title_gradient`, `hero_description`, `spotlight_title`, `spotlight_description`, `chairman_image`, `chairman_experience`, `cta_banner_title`, `cta_banner_desc`, `created_at`, `updated_at`) VALUES
(1, 'Membangun Eksperiens Digital Melalui', 'Kepemimpinan Mahasiswa & Inovasi', 'Menjembatani kesenjangan antara keunggulan akademis di Sistem Informasi dan solusi web dunia nyata. Kami memberdayakan generasi spesialis berikutnya untuk membangun produk digital yang skalabel dan berdampak tinggi.', NULL, NULL, '1771946230_images (1).png', '1 tahun', NULL, NULL, NULL, '2026-02-24 08:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `about_stacks`
--

CREATE TABLE `about_stacks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT NULL,
  `order_num` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'muaffa aditya', '$2y$10$K5QH9rfBrKkMPOC0KeS9EONISpDTQiuK6SPOa5mDrNwjDRj6G/x7W', '2026-02-21 19:56:20', '2026-02-21 19:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `blog_hero_settings`
--

CREATE TABLE `blog_hero_settings` (
  `id` int(11) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `title_white` varchar(255) DEFAULT NULL,
  `title_gradient` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `placeholder_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_hero_settings`
--

INSERT INTO `blog_hero_settings` (`id`, `tagline`, `title_white`, `title_gradient`, `description`, `placeholder_text`, `created_at`, `updated_at`) VALUES
(1, 'WAWASAN TEKNOLOGI TERBARU', NULL, NULL, NULL, NULL, NULL, '2026-02-24 00:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT 'Admin',
  `reading_time` int(11) DEFAULT 5,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `project_details` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_settings`
--

CREATE TABLE `contact_settings` (
  `id` int(11) NOT NULL,
  `hero_title_white` varchar(255) DEFAULT NULL,
  `hero_title_gradient` varchar(255) DEFAULT NULL,
  `hero_description` text DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `instagram_username` varchar(100) DEFAULT NULL,
  `location_text` text DEFAULT NULL,
  `is_accepting_projects` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_settings`
--

INSERT INTO `contact_settings` (`id`, `hero_title_white`, `hero_title_gradient`, `hero_description`, `whatsapp_number`, `email_address`, `instagram_username`, `location_text`, `is_accepting_projects`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, '6281249771960', 'muaffaaditya88@gmail.com', '@m.aadiitya', 'Jl. Rajawali No.10, Pandewatan, Punggul, Kec. Gedangan, Kabupaten Sidoarjo, Jawa Timur 61254', 1, NULL, '2026-02-24 02:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `dev_process_headers`
--

CREATE TABLE `dev_process_headers` (
  `id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT 'Proses Pengembangan Kami',
  `subtitle` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dev_process_headers`
--

INSERT INTO `dev_process_headers` (`id`, `title`, `subtitle`, `created_at`, `updated_at`) VALUES
(1, 'Proses Pengembangan Kami', 'Bagaimana kami mewujudkan visi Anda.', '2026-02-21 15:01:31', '2026-02-21 15:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `dev_process_steps`
--

CREATE TABLE `dev_process_steps` (
  `id` int(11) NOT NULL,
  `step_no` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `order_num` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) DEFAULT 'fas fa-bolt',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feature_headers`
--

CREATE TABLE `feature_headers` (
  `id` int(11) NOT NULL DEFAULT 1,
  `tagline` varchar(255) DEFAULT 'Fitur Utama',
  `title` text DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feature_headers`
--

INSERT INTO `feature_headers` (`id`, `tagline`, `title`, `subtitle`, `created_at`, `updated_at`) VALUES
(1, 'Fitur Utama', 'Kami fokus pada ROI, kecepatan pasar, dan kode yang bersih.', 'Pendekatan prioritas teknik kami memastikan bahwa setiap piksel mendukung bisnis Anda.', '2026-02-21 13:25:05', '2026-02-22 13:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `category` enum('expertise','company') NOT NULL,
  `order_num` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id`, `title`, `url`, `category`, `order_num`, `created_at`, `updated_at`) VALUES
(1, 'wqd', 'edew', 'company', 0, '2026-02-24 07:25:26', '2026-02-24 07:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

CREATE TABLE `footer_settings` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `newsletter_text` varchar(255) DEFAULT NULL,
  `copyright_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `description`, `instagram_url`, `github_url`, `linkedin_url`, `newsletter_text`, `copyright_text`, `created_at`, `updated_at`) VALUES
(1, 'Meningkatkan citra merek melalui keahlian digital tingkat tinggi. Berfokus pada penyediaan solusi yang skalabel dengan Laravel dan tumpukan frontend modern.', 'https://instagram.com/m.aadiitya', 'https://github.com/muaffaaditya', 'https://www.linkedin.com/in/muaffa-aditya-43388b2b4/', NULL, 'ADT.DEVELOPER', NULL, '2026-02-24 07:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `hero_settings`
--

CREATE TABLE `hero_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `status_tag` varchar(255) DEFAULT 'Menerima proyek Q1 2026',
  `title_white` varchar(255) DEFAULT 'Membangun Masa Depan',
  `title_gradient` varchar(255) DEFAULT 'Pengalaman Digital',
  `description` text DEFAULT NULL,
  `button_primary_text` varchar(100) DEFAULT 'Mulai Proyek',
  `button_secondary_text` varchar(100) DEFAULT 'Portofolio',
  `client_count` varchar(50) DEFAULT '500+',
  `hero_image` varchar(255) DEFAULT 'hero-code.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_settings`
--

INSERT INTO `hero_settings` (`id`, `status_tag`, `title_white`, `title_gradient`, `description`, `button_primary_text`, `button_secondary_text`, `client_count`, `hero_image`, `updated_at`) VALUES
(1, 'Menerima proyek Q1 2026', 'Membangun Masa Depan', 'Pengalaman Digital', 'Solusi web kustom berperforma tinggi untuk brand ambisius.', 'Mulai Proyek', 'Portofolio', '500+', 'hero_1771928628.jpg', '2026-02-24 03:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_hero_settings`
--

CREATE TABLE `portfolio_hero_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `tagline` varchar(255) DEFAULT 'SHOWCASE PROYEK UNGGULAN',
  `title_white_1` varchar(255) DEFAULT 'Kami merancang',
  `title_gradient` varchar(255) DEFAULT 'solusi digital',
  `title_white_2` varchar(255) DEFAULT 'berperforma tinggi.',
  `description` text DEFAULT NULL,
  `button_primary_text` varchar(100) DEFAULT 'Lihat Proyek',
  `button_secondary_text` varchar(100) DEFAULT 'Alur Kerja Kami',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio_hero_settings`
--

INSERT INTO `portfolio_hero_settings` (`id`, `tagline`, `title_white_1`, `title_gradient`, `title_white_2`, `description`, `button_primary_text`, `button_secondary_text`, `created_at`, `updated_at`) VALUES
(1, 'SHOWCASE PROYEK UNGGULAN', 'Kami merancang', 'solusi digital', 'berperforma tinggi.', 'Pengembangan web kelas atas untuk brand modern. Dari platform SaaS yang skalabel hingga pengalaman e-commerce yang imersif.', 'Lihat Proyek', 'Alur Kerja Kami', '2026-02-22 12:25:07', '2026-02-22 12:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_hero_settings`
--

CREATE TABLE `pricing_hero_settings` (
  `id` int(11) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `title_white` varchar(255) DEFAULT NULL,
  `title_gradient` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricing_hero_settings`
--

INSERT INTO `pricing_hero_settings` (`id`, `tagline`, `title_white`, `title_gradient`, `description`, `created_at`, `updated_at`) VALUES
(1, 'PAKET HARGA TERBAIK', NULL, NULL, NULL, NULL, '2026-02-24 01:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_plans`
--

CREATE TABLE `pricing_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price_monthly` varchar(50) DEFAULT NULL,
  `price_yearly` varchar(50) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `live_url` varchar(255) DEFAULT '#',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) DEFAULT 'fas fa-laptop-code',
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_details`
--

CREATE TABLE `service_details` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `technologies` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_bg_color` varchar(50) DEFAULT 'bg-primary/10',
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_headers`
--

CREATE TABLE `service_headers` (
  `id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT 'Keahlian Inti Kami',
  `subtitle` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_headers`
--

INSERT INTO `service_headers` (`id`, `title`, `subtitle`, `created_at`, `updated_at`) VALUES
(1, 'Keahlian Inti Kami', 'Solusi komprehensif untuk web modern.', '2026-02-21 14:20:12', '2026-02-21 14:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `service_hero_settings`
--

CREATE TABLE `service_hero_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `tagline` varchar(255) DEFAULT 'SOLUSI DIGITAL AHLI',
  `title_white` varchar(255) DEFAULT 'Tingkatkan Kehadiran',
  `title_primary` varchar(255) DEFAULT 'Digital Anda.',
  `description` text DEFAULT NULL,
  `button_primary_text` varchar(100) DEFAULT 'Mulai Proyek',
  `button_secondary_text` varchar(100) DEFAULT 'Lihat Portofolio',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_hero_settings`
--

INSERT INTO `service_hero_settings` (`id`, `tagline`, `title_white`, `title_primary`, `description`, `button_primary_text`, `button_secondary_text`, `created_at`, `updated_at`) VALUES
(1, 'SOLUSI DIGITAL AHLI', 'Tingkatkan Kehadiran', 'Digital Anda.', 'Kami berspesialisasi dalam aplikasi web dan seluler berperforma tinggi menggunakan kerangka kerja modern seperti Laravel, Tailwind CSS, dan Flutter.', 'Mulai Proyek', 'Lihat Portofolio', '2026-02-21 14:43:29', '2026-02-22 13:24:03');

-- --------------------------------------------------------

--
-- Table structure for table `service_pages`
--

CREATE TABLE `service_pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `main_description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `technologies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`technologies`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_pages`
--

INSERT INTO `service_pages` (`id`, `slug`, `title`, `subtitle`, `icon`, `main_description`, `features`, `technologies`, `created_at`, `updated_at`) VALUES
(1, 'web-application', 'Web Application', 'Membangun ekosistem digital yang skalabel dan performa tinggi.', 'fa-laptop-code', 'Kami menghadirkan aplikasi web modern yang tidak hanya cantik tetapi juga cepat dan aman. Menggunakan arsitektur terkini untuk memastikan bisnis Anda siap menghadapi trafik besar.', '[\"Dashboard Admin Kustom\", \"Integrasi Pembayaran\", \"PWA (Progressive Web App)\", \"Optimasi SEO On-Page\"]', '[\"Laravel\", \"Vue.js\", \"Tailwind CSS\", \"MySQL\"]', NULL, NULL),
(2, 'ui-ux-solutions', 'UI/UX Solutions', 'Desain berpusat pada pengguna untuk pengalaman yang tak terlupakan.', 'fa-bezier-curve', 'Kami percaya bahwa desain yang baik adalah desain yang menyelesaikan masalah. Kami menggabungkan estetika visual dengan riset pengalaman pengguna yang mendalam.', '[\"Riset Pengguna & Persona\", \"Wireframing & Prototyping\", \"Desain Antarmuka Modern\", \"Usability Testing\"]', '[\"Figma\", \"Adobe XD\", \"Framer\", \"Lottie Animations\"]', NULL, NULL),
(3, 'backend-api', 'Backend API', 'Infrastruktur data yang kokoh untuk mobilitas aplikasi Anda.', 'fa-server', 'Menyediakan tulang punggung digital yang aman untuk menghubungkan berbagai platform. Kami membangun API yang efisien, terdokumentasi dengan baik, dan mudah diintegrasikan.', '[\"Restful API Development\", \"Sistem Otentikasi JWT\", \"Arsitektur Microservices\", \"Dokumentasi Swagger/Postman\"]', '[\"Node.js\", \"Laravel Sanctum\", \"Redis\", \"Docker\"]', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_headers`
--

CREATE TABLE `testimonial_headers` (
  `id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) DEFAULT 'Siapa yang mempercayai keahlian kami.',
  `subtitle` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonial_headers`
--

INSERT INTO `testimonial_headers` (`id`, `title`, `subtitle`, `created_at`, `updated_at`) VALUES
(1, 'Siapa yang mempercayai kami.', 'Bergabunglah dengan 500+ tim yang telah meningkatkan kehadiran digital mereka bersama kami.', '2026-02-21 14:28:23', '2026-02-21 14:31:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_milestones`
--
ALTER TABLE `about_milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_settings`
--
ALTER TABLE `about_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_stacks`
--
ALTER TABLE `about_stacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `blog_hero_settings`
--
ALTER TABLE `blog_hero_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_settings`
--
ALTER TABLE `contact_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dev_process_headers`
--
ALTER TABLE `dev_process_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dev_process_steps`
--
ALTER TABLE `dev_process_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_headers`
--
ALTER TABLE `feature_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_settings`
--
ALTER TABLE `hero_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio_hero_settings`
--
ALTER TABLE `portfolio_hero_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing_hero_settings`
--
ALTER TABLE `pricing_hero_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_details`
--
ALTER TABLE `service_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_headers`
--
ALTER TABLE `service_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_hero_settings`
--
ALTER TABLE `service_hero_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_pages`
--
ALTER TABLE `service_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial_headers`
--
ALTER TABLE `testimonial_headers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_milestones`
--
ALTER TABLE `about_milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `about_settings`
--
ALTER TABLE `about_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `about_stacks`
--
ALTER TABLE `about_stacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_hero_settings`
--
ALTER TABLE `blog_hero_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_settings`
--
ALTER TABLE `contact_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dev_process_steps`
--
ALTER TABLE `dev_process_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `footer_settings`
--
ALTER TABLE `footer_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pricing_hero_settings`
--
ALTER TABLE `pricing_hero_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pricing_plans`
--
ALTER TABLE `pricing_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_details`
--
ALTER TABLE `service_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_pages`
--
ALTER TABLE `service_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
