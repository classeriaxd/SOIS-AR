-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2021 at 10:21 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sois-accomplishmentreport`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_acronym` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `organization_id`, `course_name`, `course_acronym`) VALUES
(1, 4, 'Bachelor of Science in Accountancy', 'BSA'),
(2, 1, 'Bachelor of Science in Electronics and Communication Engineering', 'BSECE'),
(3, 6, 'Bachelor of Science Mechanical Engineering', 'BSME'),
(4, 5, 'Bachelor of Science in Business Administration Major in Human Resource Development Management', 'BSBA-HRDM'),
(5, 3, 'Bachelor of Science in Business Administration Major in Marketing Management', 'BSBA-MM'),
(6, 8, 'Bachelor of Science in Office Administration Major in Legal Transcription', 'BSOA-LT'),
(7, 7, 'Bachelor of Secondary Education Major in English', 'BSED-English'),
(8, 7, 'Bachelor of Secondary Education Major in Mathematics', 'BSED-Mathematics'),
(9, 2, 'Bachelor of Science in Information Technology', 'BSIT'),
(10, 8, 'Diploma in Office Management Technology with Specialization in Legal Office Management', 'DOMT-LOM'),
(11, 2, 'Diploma in Information Communication Technology', 'DICT');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `objective` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beneficiaries` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sponsors` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `event_image_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `image_type` tinyint(3) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2021_08_12_000001_create_roles_table', 1),
(4, '2021_08_12_000002_create_organizations_table', 1),
(5, '2021_08_12_000003_create_courses_table', 1),
(6, '2021_08_12_000004_create_position_titles_table', 1),
(7, '2021_08_12_000005_create_users_table', 1),
(8, '2021_08_12_000007_create_users_position_titles_table', 1),
(9, '2021_08_12_000008_create_events_table', 1),
(10, '2021_08_12_000009_create_event_images_table', 1),
(11, '2021_08_12_091126_create_organization_assets_table', 1),
(12, '2021_08_19_042442_create_student_accomplishments_table', 1),
(13, '2021_08_19_042511_create_student_accomplishment_files_table', 1),
(14, '2021_08_19_070523_create_organization_document_types_table', 1),
(15, '2021_08_19_070534_create_organization_documents_table', 1),
(16, '2021_08_19_123850_create_temporary_files_table', 1),
(17, '2021_08_21_070655_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `organization_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_acronym` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`organization_id`, `organization_name`, `organization_acronym`) VALUES
(1, 'Association of Electronics Engineering Students', 'AECES'),
(2, 'Computer Society', 'CS'),
(3, 'Junior Marketing Association', 'JMA'),
(4, 'Junior Philippine Institutes of Accountants', 'JPIA'),
(5, 'Junior People Management Association of the Philippines', 'JPMAP'),
(6, 'Junior Philippine Society of Mechanical Engineering', 'JPSME'),
(7, 'Mentor\'s Society', 'MS'),
(8, 'Philippine Association of Students in Office Administration', 'PASOA');

-- --------------------------------------------------------

--
-- Table structure for table `organization_assets`
--

CREATE TABLE `organization_assets` (
  `organization_asset_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_assets`
--

INSERT INTO `organization_assets` (`organization_asset_id`, `organization_id`, `image`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 'organization_assets/original/aeces.jpg', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(2, 2, 'organization_assets/original/cs.png', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(3, 3, 'organization_assets/original/jma.png', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(4, 4, 'organization_assets/original/jpia.jpg', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(5, 5, 'organization_assets/original/jpmap.png', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(6, 6, 'organization_assets/original/jpsme.jpg', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(7, 7, 'organization_assets/original/mentors.jpg', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18'),
(8, 8, 'organization_assets/original/pasoa.png', 1, '2021-08-20 23:36:18', '2021-08-20 23:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `organization_documents`
--

CREATE TABLE `organization_documents` (
  `orgdoc_id` bigint(20) UNSIGNED NOT NULL,
  `org_id` bigint(20) UNSIGNED NOT NULL,
  `orgdoc_type_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_document_types`
--

CREATE TABLE `organization_document_types` (
  `orgdoctype_id` bigint(20) UNSIGNED NOT NULL,
  `org_id` bigint(20) UNSIGNED NOT NULL,
  `doctype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_document_types`
--

INSERT INTO `organization_document_types` (`orgdoctype_id`, `org_id`, `doctype`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Minutes of the Meeting', NULL, NULL, NULL),
(2, 1, 'Constitution', NULL, NULL, NULL),
(3, 1, 'Resolution', NULL, NULL, NULL),
(4, 1, 'Memorandum Order', NULL, NULL, NULL),
(5, 2, 'Minutes of the Meeting', NULL, NULL, NULL),
(6, 2, 'Constitution', NULL, NULL, NULL),
(7, 2, 'Resolution', NULL, NULL, NULL),
(8, 2, 'Memorandum Order', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position_titles`
--

CREATE TABLE `position_titles` (
  `position_title_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `position_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position_titles`
--

INSERT INTO `position_titles` (`position_title_id`, `organization_id`, `position_title`) VALUES
(1, 1, 'President'),
(2, 1, 'Vice President for Internal Affairs'),
(3, 1, 'Vice President for External Affairs'),
(4, 1, 'Vice President for Records'),
(5, 1, 'Assistant Vice President for Records'),
(6, 1, 'Vice President for Research and Documentation'),
(7, 1, 'Assistant Vice President for Research and Documentation '),
(8, 1, 'Vice President for Communications'),
(9, 1, 'Assistant Vice President for Communications'),
(10, 1, 'Vice President for Finance'),
(11, 1, 'Assitant Vice President for Finance'),
(12, 1, 'Vice President for Audit'),
(13, 1, 'Vice President for Arts'),
(14, 1, 'Vice Presient for Sport'),
(15, 1, 'Vice President for Academics'),
(16, 1, 'Member'),
(17, 2, 'President'),
(18, 2, 'Vice President for Internal Affairs'),
(19, 2, 'Vice President for External Affairs'),
(20, 2, 'Vice President for Records'),
(21, 2, 'Assistant Vice President for Records'),
(22, 2, 'Vice President for Research and Documentation'),
(23, 2, 'Assistant Vice President for Research and Documentation '),
(24, 2, 'Vice President for Communications'),
(25, 2, 'Assistant Vice President for Communications'),
(26, 2, 'Vice President for Finance'),
(27, 2, 'Assitant Vice President for Finance'),
(28, 2, 'Vice President for Audit'),
(29, 2, 'Vice President for Arts'),
(30, 2, 'Vice Presient for Sport'),
(31, 2, 'Vice President for Academics'),
(32, 2, 'Member'),
(33, 3, 'President'),
(34, 3, 'Vice President for Internal Affairs'),
(35, 3, 'Vice President for External Affairs'),
(36, 3, 'Vice President for Records'),
(37, 3, 'Assistant Vice President for Records'),
(38, 3, 'Vice President for Research and Documentation'),
(39, 3, 'Assistant Vice President for Research and Documentation '),
(40, 3, 'Vice President for Communications'),
(41, 3, 'Assistant Vice President for Communications'),
(42, 3, 'Vice President for Finance'),
(43, 3, 'Assitant Vice President for Finance'),
(44, 3, 'Vice President for Audit'),
(45, 3, 'Vice President for Arts'),
(46, 3, 'Vice Presient for Sport'),
(47, 3, 'Vice President for Academics'),
(48, 3, 'Member'),
(49, 4, 'President'),
(50, 4, 'Vice President for Internal Affairs'),
(51, 4, 'Vice President for External Affairs'),
(52, 4, 'Vice President for Records'),
(53, 4, 'Assistant Vice President for Records'),
(54, 4, 'Vice President for Research and Documentation'),
(55, 4, 'Assistant Vice President for Research and Documentation '),
(56, 4, 'Vice President for Communications'),
(57, 4, 'Assistant Vice President for Communications'),
(58, 4, 'Vice President for Finance'),
(59, 4, 'Assitant Vice President for Finance'),
(60, 4, 'Vice President for Audit'),
(61, 4, 'Vice President for Arts'),
(62, 4, 'Vice Presient for Sport'),
(63, 4, 'Vice President for Academics'),
(64, 4, 'Member'),
(65, 5, 'President'),
(66, 5, 'Vice President for Internal Affairs'),
(67, 5, 'Vice President for External Affairs'),
(68, 5, 'Vice President for Records'),
(69, 5, 'Assistant Vice President for Records'),
(70, 5, 'Vice President for Research and Documentation'),
(71, 5, 'Assistant Vice President for Research and Documentation '),
(72, 5, 'Vice President for Communications'),
(73, 5, 'Assistant Vice President for Communications'),
(74, 5, 'Vice President for Finance'),
(75, 5, 'Assitant Vice President for Finance'),
(76, 5, 'Vice President for Audit'),
(77, 5, 'Vice President for Arts'),
(78, 5, 'Vice Presient for Sport'),
(79, 5, 'Vice President for Academics'),
(80, 5, 'Member'),
(81, 6, 'President'),
(82, 6, 'Vice President for Internal Affairs'),
(83, 6, 'Vice President for External Affairs'),
(84, 6, 'Vice President for Records'),
(85, 6, 'Assistant Vice President for Records'),
(86, 6, 'Vice President for Research and Documentation'),
(87, 6, 'Assistant Vice President for Research and Documentation '),
(88, 6, 'Vice President for Communications'),
(89, 6, 'Assistant Vice President for Communications'),
(90, 6, 'Vice President for Finance'),
(91, 6, 'Assitant Vice President for Finance'),
(92, 6, 'Vice President for Audit'),
(93, 6, 'Vice President for Arts'),
(94, 6, 'Vice Presient for Sport'),
(95, 6, 'Vice President for Academics'),
(96, 6, 'Member'),
(97, 7, 'President'),
(98, 7, 'Vice President for Internal Affairs'),
(99, 7, 'Vice President for External Affairs'),
(100, 7, 'Vice President for Records'),
(101, 7, 'Assistant Vice President for Records'),
(102, 7, 'Vice President for Research and Documentation'),
(103, 7, 'Assistant Vice President for Research and Documentation '),
(104, 7, 'Vice President for Communications'),
(105, 7, 'Assistant Vice President for Communications'),
(106, 7, 'Vice President for Finance'),
(107, 7, 'Assitant Vice President for Finance'),
(108, 7, 'Vice President for Audit'),
(109, 7, 'Vice President for Arts'),
(110, 7, 'Vice Presient for Sport'),
(111, 7, 'Vice President for Academics'),
(112, 7, 'Member'),
(113, 8, 'President'),
(114, 8, 'Vice President for Internal Affairs'),
(115, 8, 'Vice President for External Affairs'),
(116, 8, 'Vice President for Records'),
(117, 8, 'Assistant Vice President for Records'),
(118, 8, 'Vice President for Research and Documentation'),
(119, 8, 'Assistant Vice President for Research and Documentation '),
(120, 8, 'Vice President for Communications'),
(121, 8, 'Assistant Vice President for Communications'),
(122, 8, 'Vice President for Finance'),
(123, 8, 'Assitant Vice President for Finance'),
(124, 8, 'Vice President for Audit'),
(125, 8, 'Vice President for Arts'),
(126, 8, 'Vice Presient for Sport'),
(127, 8, 'Vice President for Academics'),
(128, 8, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`, `description`) VALUES
(1, 'Admin', 'Admin'),
(2, 'User', 'Users/Students/Officers/Professors');

-- --------------------------------------------------------

--
-- Table structure for table `student_accomplishments`
--

CREATE TABLE `student_accomplishments` (
  `student_accomplishment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `accomplishment_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_accomplishments`
--

INSERT INTO `student_accomplishments` (`student_accomplishment_id`, `user_id`, `organization_id`, `accomplishment_uuid`, `title`, `description`, `status`, `remarks`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 12, 4, '001ad1ef-4c74-4073-b5b7-99b6f5ec9a2e', 'Nemo id et duis', 'Do nobis suscipi', 1, '*clap* *clap*', NULL, '2021-08-20 23:38:34', '2021-08-20 23:38:34'),
(2, 12, 4, '2a49a530-c38b-4ef2-99c7-d486b7801171', 'Quas doloribus n', 'Quisquam ut cupi', 2, 'bakit ganto??????????', NULL, '2021-08-20 23:43:16', '2021-08-20 23:43:16'),
(3, 12, 4, '2f599d2b-fbd8-4416-bd50-f07604adc5a3', 'Aperiam odit ess', 'Quae autem minim', 0, 'PENDING', NULL, '2021-08-20 23:43:30', '2021-08-20 23:43:30'),
(4, 12, 4, '826a6f2a-6259-4cce-9836-db1dffbe2822', 'Excepturi est e', 'Libero adipisci', 0, 'PENDING', NULL, '2021-08-20 23:43:41', '2021-08-20 23:43:41'),
(5, 12, 4, 'b8b33f70-ba82-4fb3-a8e2-1d8501cb77dc', 'Beatae pariatur', 'Labore rerum sin', 0, 'PENDING', NULL, '2021-08-20 23:43:57', '2021-08-20 23:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `student_accomplishment_files`
--

CREATE TABLE `student_accomplishment_files` (
  `student_accomplishment_file_id` bigint(20) UNSIGNED NOT NULL,
  `student_accomplishment_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_accomplishment_files`
--

INSERT INTO `student_accomplishment_files` (`student_accomplishment_file_id`, `student_accomplishment_id`, `file`, `caption`, `created_at`, `updated_at`) VALUES
(1, 1, '/uploads/student_accomplishments/6120ad69a2673-1629531497.jpg', 'Nostrud in ullam', '2021-08-20 23:38:34', '2021-08-20 23:38:34'),
(2, 1, '/uploads/student_accomplishments/6120ad6b76f8b-1629531499.jpg', 'Nostrud in ullam', '2021-08-20 23:38:34', '2021-08-20 23:38:34'),
(3, 1, '/uploads/student_accomplishments/6120ad6f7ed72-1629531503.jpg', 'Nostrud in ullam', '2021-08-20 23:38:34', '2021-08-20 23:38:34'),
(4, 2, '/uploads/student_accomplishments/6120ae92ac691-1629531794.jpg', 'Officia laborum', '2021-08-20 23:43:16', '2021-08-20 23:43:16'),
(5, 3, '/uploads/student_accomplishments/6120aea04803a-1629531808.jpg', 'Numquam voluptas', '2021-08-20 23:43:30', '2021-08-20 23:43:30'),
(6, 4, '/uploads/student_accomplishments/6120aeabb29e8-1629531819.jpg', 'Laboriosam veli', '2021-08-20 23:43:41', '2021-08-20 23:43:41'),
(7, 5, '/uploads/student_accomplishments/6120aebaea7ef-1629531834.jpg', 'Dolore autem exp', '2021-08-20 23:43:57', '2021-08-20 23:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_files`
--

CREATE TABLE `temporary_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temporary_files`
--

INSERT INTO `temporary_files` (`id`, `folder`, `filename`, `created_at`, `updated_at`) VALUES
(1, '6120ad69c030a-1629531497', '6120ad69a2673-1629531497.jpg', '2021-08-20 23:38:18', '2021-08-20 23:38:18'),
(2, '6120ad6b792b4-1629531499', '6120ad6b76f8b-1629531499.jpg', '2021-08-20 23:38:19', '2021-08-20 23:38:19'),
(3, '6120ad6f8109b-1629531503', '6120ad6f7ed72-1629531503.jpg', '2021-08-20 23:38:23', '2021-08-20 23:38:23'),
(4, '6120ae92ae5d1-1629531794', '6120ae92ac691-1629531794.jpg', '2021-08-20 23:43:14', '2021-08-20 23:43:14'),
(5, '6120aea04a74b-1629531808', '6120aea04803a-1629531808.jpg', '2021-08-20 23:43:28', '2021-08-20 23:43:28'),
(6, '6120aeabb54e1-1629531819', '6120aeabb29e8-1629531819.jpg', '2021-08-20 23:43:39', '2021-08-20 23:43:39'),
(7, '6120aebaecf00-1629531834', '6120aebaea7ef-1629531834.jpg', '2021-08-20 23:43:54', '2021-08-20 23:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(3) UNSIGNED NOT NULL,
  `date_of_birth` date NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `course_id`, `role_id`, `email`, `password`, `student_number`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `mobile_number`, `address`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 2, 'bsa@email.com', '$2y$10$fSta4FJ39JtuGUJcrwr2E.S7tmA6lsIkosrUvXHUmXsXVGpeAGeou', '2018-00001-TG-O', 'Jon Jeremiah', 'Malakas', 'Bartolome', 1, '2000-01-01', '+639123456700', 'Bulacan, Malolos', '2021-08-20 23:36:17', '2021-08-20 23:36:17', 0),
(2, 2, 2, 'ece@email.com', '$2y$10$8kUDLrMbJBYcayL3AXSq0.v8jK0X7bZFTN7hnrnJ3Ie6TN7BfFP3q', '2018-00002-TG-O', 'Bryan', 'Santiago', 'Laserna', 1, '2000-01-01', '+639123456701', 'Purok 13 South Daang Hari, Taguig City', '2021-08-20 23:36:17', '2021-08-20 23:36:17', 0),
(3, 3, 2, 'bsme@email.com', '$2y$10$oFRSxRXdUC.jW9CxGzF.FOEOndz77ieCgLNk9z2lWSopaqY/eccme', '2018-00003-TG-O', 'Earl', 'Vincent', 'Caroliner', 1, '2000-01-01', '+639123456702', 'Lower Bicutan, Taguig City', '2021-08-20 23:36:17', '2021-08-20 23:36:17', 0),
(4, 4, 2, 'bshr@email.com', '$2y$10$8i5AQZWpNeiJX8AaZCGOpOJrnlXNysodH4XS7pqW1w894v1VsPqj2', '2018-00004-TG-O', 'Hajji', 'Janloui', 'Luciano', 1, '2000-01-01', '+639123456703', 'Bambang, Sta Ana Signal, Taguig City', '2021-08-20 23:36:17', '2021-08-20 23:36:17', 0),
(5, 5, 2, 'bsmm@email.com', '$2y$10$tYXZXLoEYrr5EuUCjp6bKOUMEpSBTFhSrb1PpaE1cKSRnIXJ1Q3sS', '2018-00005-TG-O', 'Jojemar', 'Mar', 'Exala', 1, '2000-01-01', '+639123456704', 'Makati City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(6, 6, 2, 'bsoa@email.com', '$2y$10$J3Wvcf7VBLuz4NQ6nqrWwegkAxqBDgopHpjHjSZtx2y2PmXVN8Gc2', '2018-00006-TG-O', 'Russel', 'Apurada', 'Claveria', 1, '2000-01-01', '+639123456705', 'Western, Bicutan, Taguig City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(7, 7, 2, 'bsede@email.com', '$2y$10$QoExVRBraXJDTv2YtlT4yuXou/meLZklI9omiXm/N9oxZPU9T2xQ2', '2018-00007-TG-O', 'Roe Bien', 'Astra', 'Arnaiz', 1, '2000-01-01', '+639123456706', 'Lower Bicutan, Taguig City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(8, 8, 2, 'bsedm@email.com', '$2y$10$yY/979DsTmguXzdNBo1Gdu9sPWN5NmFcJbMWm0iaYxP.UzhhAfb5y', '2018-00008-TG-O', 'Juan', 'Carlos', 'Amaguin', 1, '2000-01-01', '+639123456707', 'Paranaque City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(9, 9, 2, 'bsit@email.com', '$2y$10$UrZh10hiok7DOXWny00tZupr9YfqdoRR.HCLqH1MTWAKPYtTTjL3y', '2018-00009-TG-O', 'Sebastian', 'Carlo', 'Cabiades', 1, '2000-01-01', '+639123456708', 'Alabang, Muntinlupa City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(10, 10, 2, 'domt@email.com', '$2y$10$qXqF/g9gW0cNQpOmoQs94u1dMEMlJv0PpdWydAqZzzKQMQ1pIPtyC', '2018-00010-TG-O', 'Timothy', 'Swift', 'Beldeniza', 1, '2000-01-01', '+639123456709', 'Lower Bicutan, Taguig City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(11, 11, 2, 'dict@email.com', '$2y$10$7mJJl6GraAAxt4EXVABLKumqfi/lz/2gN8OF.SZF1W3Zvgy0dvWby', '2018-00011-TG-O', 'John Andrew', 'P', 'Mahipos', 1, '2000-01-01', '+639123456710', 'Lower Bicutan, Taguig City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0),
(12, 1, 2, 'bsa-member@email.com', '$2y$10$anqD2UXaVhNy/ZNq/ua6FuBFIdgM9jpBS/zgnIfk4k.T0TXsy5mqW', '2018-00012-TG-O', 'BSA John', 'Fitzgerald', 'Kennedy', 1, '2000-01-01', '+639123456710', 'Lower Bicutan, Taguig City', '2021-08-20 23:36:18', '2021-08-20 23:36:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_position_titles`
--

CREATE TABLE `users_position_titles` (
  `position_title_position_title_id` bigint(20) UNSIGNED NOT NULL,
  `user_user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_position_titles`
--

INSERT INTO `users_position_titles` (`position_title_position_title_id`, `user_user_id`) VALUES
(54, 1),
(6, 2),
(86, 3),
(70, 4),
(38, 5),
(118, 6),
(102, 7),
(103, 8),
(22, 9),
(119, 10),
(23, 11),
(64, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `courses_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`event_image_id`),
  ADD UNIQUE KEY `event_images_slug_unique` (`slug`),
  ADD KEY `event_images_event_id_foreign` (`event_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `organization_assets`
--
ALTER TABLE `organization_assets`
  ADD PRIMARY KEY (`organization_asset_id`),
  ADD KEY `organization_assets_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `organization_documents`
--
ALTER TABLE `organization_documents`
  ADD PRIMARY KEY (`orgdoc_id`),
  ADD UNIQUE KEY `organization_documents_org_id_unique` (`org_id`),
  ADD KEY `organization_documents_orgdoc_type_id_foreign` (`orgdoc_type_id`);

--
-- Indexes for table `organization_document_types`
--
ALTER TABLE `organization_document_types`
  ADD PRIMARY KEY (`orgdoctype_id`),
  ADD KEY `organization_document_types_org_id_foreign` (`org_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `position_titles`
--
ALTER TABLE `position_titles`
  ADD PRIMARY KEY (`position_title_id`),
  ADD KEY `position_titles_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `student_accomplishments`
--
ALTER TABLE `student_accomplishments`
  ADD PRIMARY KEY (`student_accomplishment_id`),
  ADD UNIQUE KEY `student_accomplishments_accomplishment_uuid_unique` (`accomplishment_uuid`),
  ADD KEY `student_accomplishments_user_id_foreign` (`user_id`),
  ADD KEY `student_accomplishments_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `student_accomplishment_files`
--
ALTER TABLE `student_accomplishment_files`
  ADD PRIMARY KEY (`student_accomplishment_file_id`),
  ADD KEY `student_accomplishment_files_student_accomplishment_id_foreign` (`student_accomplishment_id`);

--
-- Indexes for table `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_student_number_unique` (`student_number`),
  ADD KEY `users_course_id_foreign` (`course_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `users_position_titles`
--
ALTER TABLE `users_position_titles`
  ADD KEY `users_position_titles_position_title_position_title_id_foreign` (`position_title_position_title_id`),
  ADD KEY `users_position_titles_user_user_id_foreign` (`user_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `event_image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `organization_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `organization_assets`
--
ALTER TABLE `organization_assets`
  MODIFY `organization_asset_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `organization_documents`
--
ALTER TABLE `organization_documents`
  MODIFY `orgdoc_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_document_types`
--
ALTER TABLE `organization_document_types`
  MODIFY `orgdoctype_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `position_titles`
--
ALTER TABLE `position_titles`
  MODIFY `position_title_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_accomplishments`
--
ALTER TABLE `student_accomplishments`
  MODIFY `student_accomplishment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_accomplishment_files`
--
ALTER TABLE `student_accomplishment_files`
  MODIFY `student_accomplishment_file_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`);

--
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `organization_assets`
--
ALTER TABLE `organization_assets`
  ADD CONSTRAINT `organization_assets_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`);

--
-- Constraints for table `organization_documents`
--
ALTER TABLE `organization_documents`
  ADD CONSTRAINT `organization_documents_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`organization_id`),
  ADD CONSTRAINT `organization_documents_orgdoc_type_id_foreign` FOREIGN KEY (`orgdoc_type_id`) REFERENCES `organization_document_types` (`orgdoctype_id`);

--
-- Constraints for table `organization_document_types`
--
ALTER TABLE `organization_document_types`
  ADD CONSTRAINT `organization_document_types_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`organization_id`);

--
-- Constraints for table `position_titles`
--
ALTER TABLE `position_titles`
  ADD CONSTRAINT `position_titles_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`);

--
-- Constraints for table `student_accomplishments`
--
ALTER TABLE `student_accomplishments`
  ADD CONSTRAINT `student_accomplishments_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`organization_id`),
  ADD CONSTRAINT `student_accomplishments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `student_accomplishment_files`
--
ALTER TABLE `student_accomplishment_files`
  ADD CONSTRAINT `student_accomplishment_files_student_accomplishment_id_foreign` FOREIGN KEY (`student_accomplishment_id`) REFERENCES `student_accomplishments` (`student_accomplishment_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `users_position_titles`
--
ALTER TABLE `users_position_titles`
  ADD CONSTRAINT `users_position_titles_position_title_position_title_id_foreign` FOREIGN KEY (`position_title_position_title_id`) REFERENCES `position_titles` (`position_title_id`),
  ADD CONSTRAINT `users_position_titles_user_user_id_foreign` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
