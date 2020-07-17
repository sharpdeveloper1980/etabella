-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2019 at 08:15 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etabellaweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `userid`, `username`, `ip_address`, `type`, `action`, `description`, `created_at`, `user_type`) VALUES
(1, 5, 'superadmin', '::1', '1', 'Logged Out', 'ETabeall Super Admin', 1577277266, 'admin'),
(2, 5, 'superadmin', '::1', '1', 'Logged In', 'ETabeall Super Admin', 1577277286, 'admin'),
(3, 5, 'superadmin', '::1', '1', 'Create Client', 'ETabeall Super Admin', 1577278466, 'admin'),
(4, 5, 'superadmin', '::1', '1', 'Create Group', 'ETabeall Super Admin', 1577278525, 'admin'),
(5, 5, 'superadmin', '::1', '1', 'Create Client', 'ETabeall Super Admin', 1577278688, 'admin'),
(6, 5, 'superadmin', '::1', '1', 'Create Client', 'ETabeall Super Admin', 1577278716, 'admin'),
(7, 5, 'superadmin', '::1', '1', 'Create Client', 'ETabeall Super Admin', 1577278755, 'admin'),
(8, 5, 'superadmin', '::1', '1', 'Create Client', 'ETabeall Super Admin', 1577278791, 'admin'),
(9, 5, 'superadmin', '::1', '1', 'Update Job', 'ETabeall Super Admin', 1577278844, 'admin'),
(10, 5, 'superadmin', '::1', '1', 'Create Group', 'ETabeall Super Admin', 1577278884, 'admin'),
(11, 5, 'superadmin', '::1', '1', 'Update Group', 'ETabeall Super Admin', 1577278902, 'admin'),
(12, 5, 'superadmin', '::1', '1', 'Create Group', 'ETabeall Super Admin', 1577278963, 'admin'),
(13, 5, 'superadmin', '::1', '1', 'Create Job', 'ETabeall Super Admin', 1577279004, 'admin'),
(14, 5, 'superadmin', '::1', '1', 'Create Job', 'ETabeall Super Admin', 1577279023, 'admin'),
(15, 4, NULL, '::1', '4', 'Logged In', 'Alok', 1577280043, 'client'),
(16, 5, 'superadmin', '::1', '1', 'Update Group', 'ETabeall Super Admin', 1577280731, 'admin'),
(17, 5, 'superadmin', '::1', '1', 'Update Group', 'ETabeall Super Admin', 1577280750, 'admin'),
(18, 5, 'superadmin', '::1', '1', 'File Uploading', 'ETabeall Super Admin', 1577280939, 'admin'),
(19, 5, 'superadmin', '::1', '1', 'File Shared', 'ETabeall Super Admin', 1577281004, 'admin'),
(20, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281089, 'admin'),
(21, 5, 'superadmin', '::1', '1', 'File Uploading', 'ETabeall Super Admin', 1577281355, 'admin'),
(22, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(23, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(24, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(25, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(26, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(27, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(28, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(29, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(30, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(31, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281382, 'admin'),
(32, 5, 'superadmin', '::1', '1', 'File Uploading', 'ETabeall Super Admin', 1577281403, 'admin'),
(33, 5, 'superadmin', '::1', '1', 'File Shared', 'ETabeall Super Admin', 1577281424, 'admin'),
(34, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(35, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(36, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(37, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(38, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(39, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(40, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(41, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(42, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(43, 5, 'superadmin', '::1', '1', 'Delete Files', 'ETabeall Super Admin', 1577281465, 'admin'),
(44, 5, 'superadmin', '::1', '1', 'File Uploading', 'ETabeall Super Admin', 1577282323, 'admin'),
(45, 5, 'superadmin', '::1', '1', 'File Shared', 'ETabeall Super Admin', 1577282330, 'admin'),
(46, 4, NULL, '::1', '4', 'Logged Out', 'Alok', 1577282632, 'client'),
(47, 5, 'superadmin', '::1', '1', 'Logged Out', 'ETabeall Super Admin', 1577282635, 'admin'),
(48, 1, NULL, '::1', '4', 'Logged In', 'John', 1577337238, 'client'),
(49, 5, 'superadmin', '::1', '1', 'Logged In', 'ETabeall Super Admin', 1577339409, 'admin'),
(50, 5, 'superadmin', '::1', '1', 'Update Job', 'ETabeall Super Admin', 1577339490, 'admin'),
(51, 1, NULL, '::1', '4', 'File Uploading', 'John', 1577339756, 'client'),
(52, 5, 'superadmin', '::1', '1', 'Delete File', 'ETabeall Super Admin', 1577339786, 'admin'),
(53, 1, NULL, '::1', '4', 'File Uploading', 'John', 1577339987, 'client'),
(54, 1, NULL, '::1', '4', 'Download Files', 'John', 1577340162, 'client'),
(55, 1, NULL, '::1', '4', 'File Exported', 'John', 1577340334, 'client'),
(56, 1, NULL, '::1', '4', 'File Exported', 'John', 1577340409, 'client'),
(57, 1, NULL, '::1', '4', 'File Exported', 'John', 1577340480, 'client'),
(58, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577341645, 'client'),
(59, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577341885, 'client'),
(60, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577341958, 'client'),
(61, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577341994, 'client'),
(62, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577342550, 'client'),
(63, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577343276, 'client'),
(64, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577343336, 'client'),
(65, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577345907, 'client'),
(66, 1, NULL, '::1', '4', 'Logged In', 'John', 1577346120, 'client'),
(67, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577346548, 'client'),
(68, 1, NULL, '::1', '4', 'Logged In', 'John', 1577346551, 'client'),
(69, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577346615, 'client'),
(70, 1, NULL, '::1', '4', 'Logged In', 'John', 1577346617, 'client'),
(71, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577347093, 'client'),
(72, 5, 'superadmin', '::1', '1', 'Logged In', 'ETabeall Super Admin', 1577351878, 'admin'),
(73, 5, 'superadmin', '::1', '1', 'Rename File', 'ETabeall Super Admin', 1577352121, 'admin'),
(74, 5, 'superadmin', '::1', '1', 'Create Folder', 'ETabeall Super Admin', 1577352206, 'admin'),
(75, 5, 'superadmin', '::1', '1', 'File Uploading', 'ETabeall Super Admin', 1577352296, 'admin'),
(76, 5, 'superadmin', '::1', '1', 'File Shared', 'ETabeall Super Admin', 1577352340, 'admin'),
(77, 5, 'superadmin', '::1', '1', 'Update Folder', 'ETabeall Super Admin', 1577352419, 'admin'),
(78, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577352436, 'client'),
(79, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577352462, 'admin'),
(80, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577352508, 'admin'),
(81, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577352520, 'client'),
(82, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577352558, 'admin'),
(83, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577352590, 'client'),
(84, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577352637, 'admin'),
(85, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577352691, 'client'),
(86, 5, 'superadmin', '::1', '1', 'Update Folder', 'ETabeall Super Admin', 1577352723, 'admin'),
(87, 5, 'superadmin', '::1', '1', 'Update Folder', 'ETabeall Super Admin', 1577352778, 'admin'),
(88, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577352790, 'admin'),
(89, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577352798, 'client'),
(90, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577353458, 'admin'),
(91, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577353476, 'client'),
(92, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577353494, 'client'),
(93, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577353541, 'admin'),
(94, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577353549, 'admin'),
(95, 5, 'superadmin', '::1', '1', 'Update Client', 'ETabeall Super Admin', 1577353631, 'admin'),
(96, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577353678, 'client'),
(97, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577353694, 'client'),
(98, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577353711, 'client'),
(99, 5, 'superadmin', '::1', '1', 'File Uploading', 'ETabeall Super Admin', 1577353872, 'admin'),
(100, 5, 'superadmin', '::1', '1', 'File Shared', 'ETabeall Super Admin', 1577353889, 'admin'),
(101, 5, NULL, '::1', '4', 'Download Files', 'Abhishek Joshi', 1577353934, 'client'),
(102, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577353990, 'client'),
(103, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577354513, 'client'),
(104, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577354610, 'client'),
(105, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577354966, 'client'),
(106, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577355355, 'client'),
(107, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577355369, 'client'),
(108, 1, NULL, '::1', '4', 'Logged In', 'John', 1577355379, 'client'),
(109, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577355422, 'client'),
(110, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577355437, 'client'),
(111, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577355543, 'client'),
(112, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577355713, 'client'),
(113, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577355787, 'client'),
(114, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577355835, 'client'),
(115, 2, NULL, '::1', '4', 'Logged In', 'Darwin', 1577355853, 'client'),
(116, 2, NULL, '::1', '4', 'Logged Out', 'Darwin', 1577355945, 'client'),
(117, 1, NULL, '::1', '4', 'Logged In', 'John', 1577355962, 'client'),
(118, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577356457, 'client'),
(119, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577358715, 'client'),
(120, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577358875, 'client'),
(121, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577358928, 'client'),
(122, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577358950, 'client'),
(123, 5, NULL, '::1', '4', 'Logged Out', 'Abhishek Joshi', 1577360803, 'client'),
(124, 1, NULL, '::1', '4', 'Logged In', 'John', 1577360812, 'client'),
(125, 5, 'superadmin', '::1', '1', 'Logged Out', 'ETabeall Super Admin', 1577360859, 'admin'),
(126, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577360934, 'client'),
(127, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577361144, 'client'),
(128, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577361322, 'client'),
(129, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577361486, 'client'),
(130, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577361994, 'client'),
(131, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577362137, 'client'),
(132, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577363708, 'client'),
(133, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577363958, 'client'),
(134, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577364081, 'client'),
(135, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577364178, 'client'),
(136, 1, NULL, '::1', '4', 'Download Files', 'John', 1577364305, 'client'),
(137, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577364797, 'client'),
(138, 1, NULL, '::1', '4', 'Add Annotation', 'John', 1577367017, 'client'),
(139, 1, NULL, '::1', '4', 'Logged In', 'John', 1577423036, 'client'),
(140, 1, NULL, '::1', '4', 'Logged Out', 'John', 1577427394, 'client'),
(141, 1, NULL, '::1', '4', 'Logged In', 'John', 1577428010, 'client'),
(142, 5, NULL, '::1', '4', 'Logged In', 'Abhishek Joshi', 1577428032, 'client'),
(143, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577428251, 'client'),
(144, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577430050, 'client'),
(145, 5, NULL, '::1', '4', 'Add Annotation', 'Abhishek Joshi', 1577430303, 'client');

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `role`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 1569060007, 1569060007),
(2, 'Manager', 'manager', 1569060008, 1569060008),
(3, 'Developer', 'developer', 1569060009, 1569060009);

-- --------------------------------------------------------

--
-- Table structure for table `annotations`
--

CREATE TABLE `annotations` (
  `annotation_id` int(11) NOT NULL,
  `annotation_client_id` int(11) NOT NULL,
  `annotation_file_id` int(11) NOT NULL,
  `annotation_page` int(11) NOT NULL,
  `annotation_data` longtext DEFAULT NULL,
  `annotation_date` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `annotations`
--

INSERT INTO `annotations` (`annotation_id`, `annotation_client_id`, `annotation_file_id`, `annotation_page`, `annotation_data`, `annotation_date`) VALUES
(1, 5, 37, 1, '[{\"bbox\":[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:04:56Z\",\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-27T07:04:56Z\",\"v\":1}]', 1577430303);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarked`
--

CREATE TABLE `bookmarked` (
  `bookmarked_id` int(11) NOT NULL,
  `bookmarked_client_id` int(11) NOT NULL,
  `bookmarked_file_id` int(11) NOT NULL,
  `bookmarked_page` text NOT NULL,
  `bookmarked_data` longtext NOT NULL,
  `bookmarked_date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_unique_id` char(5) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `jobs` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `client_device_token` varchar(255) DEFAULT NULL,
  `quickblox_id` varchar(255) DEFAULT NULL,
  `client_display_name` varchar(100) DEFAULT NULL,
  `client_date_created` bigint(20) DEFAULT NULL,
  `client_date_last_update` bigint(20) DEFAULT NULL,
  `client_share_files_to_all` int(11) DEFAULT 0,
  `client_share_screen_to_all` int(11) DEFAULT 0,
  `client_last_screenshot` bigint(20) DEFAULT 0,
  `client_status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_unique_id`, `username`, `user_password`, `jobs`, `access_token`, `client_device_token`, `quickblox_id`, `client_display_name`, `client_date_created`, `client_date_last_update`, `client_share_files_to_all`, `client_share_screen_to_all`, `client_last_screenshot`, `client_status`) VALUES
(1, 'doDLS', 'john', '74a6ae97f18c9cd70120c46e4f956c55', '1', '8pBxPQ9gukSPAoh1Otly1vNZ49KBv3sWPvRHEtzG', NULL, NULL, 'John', 1577278466, 1577278466, 0, 0, 0, 1),
(2, 'cD0bG', 'darwin', '12f49b018434dc0067bb2b4f6a76c979', '1', '8pBxPQ9gukSPAoh1Otly1vNZ49KBv3sWPvRHEtzG', NULL, NULL, 'Darwin', 1577278688, 1577278688, 0, 0, 0, 1),
(3, '8vD5I', 'robert', '25878ecf106d91a808354016fe0722ef', '1', '8pBxPQ9gukSPAoh1Otly1vNZ49KBv3sWPvRHEtzG', NULL, NULL, 'Robert', 1577278716, 1577278716, 0, 0, 0, 1),
(4, 'iCLvm', 'alok', 'cf1e924918f05b53857dbcf98af4656e', '1', '8pBxPQ9gukSPAoh1Otly1vNZ49KBv3sWPvRHEtzG', NULL, NULL, 'Alok', 1577278755, 1577278755, 0, 0, 0, 1),
(5, 'BNxDA', 'abhishek', '2e880c43caf472a2f85a182bad0f85cf', '1,2,3', '8pBxPQ9gukSPAoh1Otly1vNZ49KBv3sWPvRHEtzG', NULL, NULL, 'Abhishek Joshi', 1577278791, 1577353631, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `device_token`
--

CREATE TABLE `device_token` (
  `device_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_token`
--

INSERT INTO `device_token` (`device_id`, `client_id`, `device_token`, `access_token`, `created_at`) VALUES
(1, 56, 'a488f63b958cf8bda0d944d4d3e1adc39faeefc2a7860c516a9806ff6a35b1a1', '99d18b37ef0964e13fcd00cdb08370f9', 20190614092252),
(2, 56, '760286e012bb3845c9a740fda5c3af4d2e6bccf4b522404db24bc92dde0f73e6', '99d18b37ef0964e13fcd00cdb08370f9', 20190614113153),
(3, 57, '055f8999fcb4438f766d5da50bd1409000ca43be67c701d4013340802666de2a', '1452d5450c725c7fa907c5ba4328a91f', 20190614113319),
(4, 58, '440e12bc6269a18781bf549dab2514b8a3995f54853292cea7ca2a003e566e87', 'c41883d3a7f8c1ac04f91ab7fb53eecc', 20190614113442),
(5, 59, 'a63f59802c0bbb71fce9fd4e6119ed0df3f4f65a2c1b7fd56f2a2fe3369972ba', '90f5dbedfcb8a452feb7949ee2ef9695', 20190614114443),
(9, 59, 'b310326b5dbc8b052d683e709a341a8c17edce7ce03d0893c6f9c79a58c499bd', '90f5dbedfcb8a452feb7949ee2ef9695', 20190620145054),
(11, 56, 'd43cada74edcefdeac5e09bb47f1316d81fb068fb44339940ff2e896bb201670', '976a5ab37b49911f1d7310bb3328ca5b', 20190711122801),
(12, 56, '3668c3bf6df478d2d700e83b900a6ef2e8c984179ab399c9f13c93436e18ed35', '976a5ab37b49911f1d7310bb3328ca5b', 20190715162747),
(13, 56, '8cf54104732c81bc5a31c35e7ae4a07dd8df5b741ed197eda6f1ac9421186be2', '976a5ab37b49911f1d7310bb3328ca5b', 20190723125812),
(14, 59, '8da8240f1b0250eeae2ac99d86d5ab0835e483776c07ea5c186ac99e60fde9b8', '8c4f6bbf9762b177c4c3b17ae3451493', 20190729142644);

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `download_id` int(11) NOT NULL,
  `download_client_id` int(11) NOT NULL,
  `download_file_id` int(11) NOT NULL,
  `download_date` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`download_id`, `download_client_id`, `download_file_id`, `download_date`) VALUES
(1, 1, 28, 1577340161),
(2, 1, 29, 1577340161),
(3, 1, 30, 1577340161),
(4, 1, 31, 1577340162),
(5, 1, 32, 1577340162),
(6, 1, 33, 1577340162),
(7, 1, 36, 1577340162),
(8, 1, 37, 1577340162),
(9, 1, 38, 1577340162),
(10, 5, 37, 1577353934),
(11, 5, 38, 1577353934),
(12, 5, 42, 1577353934),
(13, 5, 43, 1577353934),
(14, 5, 44, 1577353934),
(15, 5, 47, 1577353934),
(16, 5, 48, 1577353934),
(17, 1, 47, 1577364305),
(18, 1, 48, 1577364305),
(19, 1, 42, 1577364305),
(20, 1, 43, 1577364305),
(21, 1, 44, 1577364305);

-- --------------------------------------------------------

--
-- Table structure for table `edited_files`
--

CREATE TABLE `edited_files` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `date_uploaded` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `edited_files_new`
--

CREATE TABLE `edited_files_new` (
  `edited_file_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_upload_name` varchar(100) NOT NULL,
  `file_data` longtext DEFAULT NULL,
  `file_type` int(11) NOT NULL,
  `file_parent_id` int(11) NOT NULL,
  `file_date_modified` bigint(20) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `files_updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `job_id` varchar(255) NOT NULL,
  `file_name` longtext DEFAULT NULL,
  `file_upload_name` varchar(255) DEFAULT NULL,
  `file_type` int(11) NOT NULL,
  `file_parent_id` int(11) DEFAULT 0,
  `file_date_modified` bigint(20) DEFAULT 0,
  `file_size` bigint(20) DEFAULT 0,
  `file_shared` int(11) DEFAULT 0,
  `file_status` int(11) DEFAULT 1,
  `file_added` int(11) DEFAULT 0,
  `file_added_time` varchar(45) NOT NULL DEFAULT '0',
  `files_updated_at` varchar(45) NOT NULL DEFAULT '0' COMMENT 'when file status changed(E.g.active to inactive)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `job_id`, `file_name`, `file_upload_name`, `file_type`, `file_parent_id`, `file_date_modified`, `file_size`, `file_shared`, `file_status`, `file_added`, `file_added_time`, `files_updated_at`) VALUES
(28, '1,3', 'Pdf', NULL, 1, 0, 1577282323, 2712404, 1, 1, 0, '0', '0'),
(29, '1,3', 'all_docs', NULL, 1, 28, 1577282323, 2712404, 1, 1, 0, '0', '0'),
(30, '1,3', '31115.pdf', '392393067b4a84b3e59054dcb40c35d0.pdf', 2, 29, 1577282323, 662391, 1, 1, 0, '0', '0'),
(31, '1,3', '31117.pdf', '750dd5b61bb49c145f149c9da939043c.pdf', 2, 29, 1577282323, 706150, 1, 1, 0, '0', '0'),
(32, '1,3', '31118.pdf', 'bbed446f3b3dd5739ea2b4802891942b.pdf', 2, 29, 1577282323, 671365, 1, 1, 0, '0', '0'),
(33, '1,3', '3184.pdf', '47fbc034a5235eaa6ec27de17ab75b5c.pdf', 2, 29, 1577282323, 672498, 1, 1, 0, '0', '0'),
(36, '1', 'Directory', NULL, 1, 0, 1577339987, 2620379, 1, 1, 0, '0', '0'),
(37, '1', 'file-example_PDF_1MB.pdf', '9947bbca6a6828179ca9fcd0cc77bcfb.pdf', 2, 36, 1577339987, 1042157, 1, 1, 0, '0', '0'),
(38, '1', 'gre_research_validity_data.pdf', 'a044af0f88f1427f8d6d1852a940a189.pdf', 2, 36, 1577339987, 1578222, 1, 1, 0, '0', '0'),
(39, '1,2', 'IDDF', NULL, 1, 0, 1577352777, 498529, 1, 1, 0, '0', '0'),
(41, '1,2', 'Moderate', NULL, 1, 39, 1577352777, 530165, 1, 1, 0, '0', '0'),
(42, '1,2', 'adobefile.pdf', 'a0fe0ee41ec90fbeff992df8c2b275d7.pdf', 2, 41, 1577352777, 7945, 1, 1, 0, '0', '0'),
(43, '1,2', 'c4611_sample_explain.pdf', '23beeb336eb89d9de52b15f595de4b50.pdf', 2, 41, 1577352777, 88226, 1, 1, 0, '0', '0'),
(44, '1,2', 'file_995.pdf', '4dd55bf53cf3c307a6541710b9966297.pdf', 2, 41, 1577352777, 433994, 1, 1, 0, '0', '0'),
(46, '1', 'Samples', NULL, 1, 0, 1577353872, 12717, 1, 1, 0, '0', '0'),
(47, '1', 'B Sample PDF.pdf', '579e651d8068a18144f09e79be488dc5.pdf', 2, 46, 1577353872, 9689, 1, 1, 0, '0', '0'),
(48, '1', 'sample_A.pdf', 'db8bb74ebf564dea3d54a8adc8067b43.pdf', 2, 46, 1577353872, 3028, 1, 1, 0, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `files_index`
--

CREATE TABLE `files_index` (
  `file_id` int(11) NOT NULL,
  `job_id` varchar(255) NOT NULL,
  `file_name` varchar(1000) NOT NULL,
  `file_upload_name` varchar(40) DEFAULT NULL,
  `file_type` int(11) NOT NULL,
  `file_parent_id` int(11) DEFAULT 0,
  `file_date_modified` bigint(20) DEFAULT 0,
  `file_size` bigint(20) DEFAULT 0,
  `file_shared` int(11) DEFAULT 0,
  `file_status` int(11) DEFAULT 1,
  `file_added` int(11) NOT NULL DEFAULT 0,
  `file_added_time` varchar(45) NOT NULL DEFAULT '0',
  `files_updated_at` varchar(45) NOT NULL DEFAULT '0' COMMENT 'when file status changed(E.g.active to inactive)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ftp`
--

CREATE TABLE `ftp` (
  `ftp_id` int(11) NOT NULL,
  `ftp_host` varchar(200) DEFAULT NULL,
  `ftp_user` varchar(100) DEFAULT NULL,
  `ftp_pass` varchar(100) DEFAULT NULL,
  `ftp_download_user` varchar(100) DEFAULT NULL,
  `ftp_download_pass` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ftp`
--

INSERT INTO `ftp` (`ftp_id`, `ftp_host`, `ftp_user`, `ftp_pass`, `ftp_download_user`, `ftp_download_pass`) VALUES
(2, 'Demo Host', 'Demo Name', 'DEmo', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `client_id`, `group_name`, `created_at`, `updated_at`) VALUES
(1, '4,5', 'Group A', '2019-12-25 18:25:25', '2019-12-25 13:32:30'),
(2, '1,2,3', 'Group B', '2019-12-25 18:31:24', '2019-12-25 13:01:24'),
(3, '1,3', 'Group C', '2019-12-25 18:32:43', '2019-12-25 13:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `group_chat`
--

CREATE TABLE `group_chat` (
  `id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `group_id` int(11) NOT NULL,
  `msg_type` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `recipient_ids` varchar(255) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `reader_ids` varchar(255) DEFAULT NULL,
  `new_msg` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hyperlinks`
--

CREATE TABLE `hyperlinks` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `annotation_id` varchar(250) DEFAULT NULL,
  `page_no` int(11) DEFAULT NULL,
  `created_at` varchar(250) DEFAULT NULL,
  `updated_at` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hyperlinks`
--

INSERT INTO `hyperlinks` (`id`, `file_id`, `url`, `annotation_id`, `page_no`, `created_at`, `updated_at`) VALUES
(1, 37, '15', '01DX0E65MXDNDTGASMJJGM76MQ', NULL, '2019-12-26 11:57:23', '2019-12-26 11:57:23');

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `color` varchar(250) DEFAULT NULL,
  `client_id` varchar(250) DEFAULT NULL,
  `created_at` varchar(250) DEFAULT NULL,
  `updated_at` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`id`, `name`, `color`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 'Issue A', '#ff8080', '1', '2019-12-26 12:01:15', '2019-12-26 12:01:15'),
(2, 'Issue B', '#808080', '1', '2019-12-26 12:02:18', '2019-12-26 12:02:18');

-- --------------------------------------------------------

--
-- Table structure for table `jobfiles`
--

CREATE TABLE `jobfiles` (
  `file_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_upload_name` varchar(40) DEFAULT NULL,
  `file_type` int(11) NOT NULL,
  `file_parent_id` int(11) NOT NULL DEFAULT 0,
  `file_date_modified` bigint(20) NOT NULL DEFAULT 0,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `file_shared` int(11) NOT NULL DEFAULT 0,
  `file_status` int(11) NOT NULL DEFAULT 1,
  `parents_ids` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `group_id` text NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `group_id`, `job_name`, `created_at`, `updated_at`) VALUES
(1, '1,2', 'ICC', '2019-12-25 18:22:24', '2019-12-26 05:51:29'),
(2, '1,2', 'ISC', '2019-12-25 18:33:23', '2019-12-25 13:03:23'),
(3, '1,2', 'FGH', '2019-12-25 18:33:43', '2019-12-25 13:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `live_screens`
--

CREATE TABLE `live_screens` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `flag` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `note_client_id` int(11) NOT NULL,
  `note_file_id` int(11) NOT NULL,
  `note_page` text NOT NULL,
  `note_data` longtext DEFAULT NULL,
  `note_date` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `job_id` varchar(255) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `mark_read` int(11) NOT NULL DEFAULT 1 COMMENT '1 for unread, 2 for Read',
  `file_id` int(100) DEFAULT NULL,
  `annotation_data` longtext DEFAULT NULL,
  `is_annotation` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for other notificatons and 1 for share annotation',
  `page_no` int(11) DEFAULT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `job_id`, `sender`, `client_id`, `mark_read`, `file_id`, `annotation_data`, `is_annotation`, `page_no`, `created_at`, `updated_at`) VALUES
(1, 'Abhishek Joshi shared File Comment Link', 'celerisque sit amet ligula eu, con', NULL, 5, 1, 2, 37, '[{\"bbox\":[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:04:56Z\",\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375]],\"type\":\"pspdfkit/markup/highlight\",\"updatedAt\":\"2019-12-27T07:04:56Z\",\"v\":1}]', 1, 1, 1577430312, 1577430312),
(2, 'John shared File Comment Link', 'celerisque sit amet ligula eu, con', NULL, 1, 5, 2, 37, '[{\"bbox\":[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:04:56Z\",\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375]],\"type\":\"pspdfkit/markup/highlight\",\"updatedAt\":\"2019-12-27T07:04:56Z\",\"v\":1}]', 1, 1, 1577430353, 1577430353),
(3, 'Abhishek Joshi shared File Comment Link', 'celerisque sit amet ligula eu, con', NULL, 5, 1, 2, 37, '[{\"bbox\":[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:04:56Z\",\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375]],\"type\":\"pspdfkit/markup/highlight\",\"updatedAt\":\"2019-12-27T07:04:56Z\",\"v\":1}]', 1, 1, 1577430401, 1577430401),
(4, 'John shared File Comment Link', 'celerisque sit amet ligula eu, con', NULL, 1, 5, 2, 37, '[{\"bbox\":[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:04:56Z\",\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375]],\"type\":\"pspdfkit/markup/highlight\",\"updatedAt\":\"2019-12-27T07:04:56Z\",\"v\":1}]', 1, 1, 1577430463, 1577430463),
(5, 'Abhishek Joshi shared File Comment Link', 'celerisque sit amet ligula eu, con', NULL, 5, 1, 2, 37, '[{\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"v\":1,\"pageIndex\":0,\"bbox\":[205.9996238708496,217.5380126953125,176.89531250000002,12.2109375],\"opacity\":1,\"createdAt\":\"2019-12-27T07:04:56.783Z\",\"updatedAt\":\"2019-12-27T07:04:56.783Z\",\"type\":\"pspdfkit\\/markup\\/highlight\",\"rects\":[[205.9996238708496,217.5380126953125,176.89531250000002,12.2109375]],\"color\":\"#fcee7c\",\"blendMode\":\"multiply\"}]', 1, 1, 1577430568, 1577430568);

-- --------------------------------------------------------

--
-- Table structure for table `one_to_one`
--

CREATE TABLE `one_to_one` (
  `id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `msg_type` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `recipient_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `new_msg` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pdf_file_overlay`
--

CREATE TABLE `pdf_file_overlay` (
  `id` int(11) NOT NULL,
  `file_id` varchar(250) DEFAULT NULL,
  `file_name` varchar(250) DEFAULT NULL,
  `file_type` varchar(250) DEFAULT NULL,
  `page_no` varchar(250) DEFAULT NULL,
  `created_at` varchar(250) DEFAULT NULL,
  `updated_at` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `push_notification`
--

CREATE TABLE `push_notification` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `share_client_id` int(11) NOT NULL,
  `job_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `file_link` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quick_access`
--

CREATE TABLE `quick_access` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL COMMENT '1 = Open, 2 = Annoted, 3 = Commented, 4 = Shared',
  `reciepient_id` int(11) DEFAULT NULL COMMENT 'reciepient id is only useful for shared option ',
  `reciepient` varchar(255) DEFAULT NULL COMMENT 'reciepient is only useful for shared option ',
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quick_access`
--

INSERT INTO `quick_access` (`id`, `file_id`, `client_id`, `file_name`, `type`, `reciepient_id`, `reciepient`, `created_at`, `updated_at`) VALUES
(2, 30, 1, '31115.pdf', 1, NULL, NULL, 1577337309, 1577337309),
(3, 34, 1, 'SampleVideo_720x480_2mb.mp4', 1, NULL, NULL, 1577339767, 1577339767),
(4, 37, 1, 'file-example_PDF_1MB.pdf', 1, NULL, NULL, 1577428293, 1577428293),
(5, 38, 1, 'gre_research_validity_data.pdf', 1, NULL, NULL, 1577364256, 1577364256),
(6, 37, 1, 'file-example_PDF_1MB.pdf', 2, NULL, NULL, 1577367017, 1577367017),
(7, 32, 1, '31118.pdf', 1, NULL, NULL, 1577344265, 1577344265),
(8, 31, 1, '31117.pdf', 1, NULL, NULL, 1577347161, 1577347161),
(9, 37, 5, 'file-example_PDF_1MB.pdf', 1, NULL, NULL, 1577430364, 1577430364),
(10, 37, 5, 'file-example_PDF_1MB.pdf', 2, NULL, NULL, 1577430304, 1577430304),
(11, 48, 5, 'sample_A.pdf', 1, NULL, NULL, 1577367352, 1577367352),
(12, 47, 5, 'B Sample PDF.pdf', 1, NULL, NULL, 1577362098, 1577362098),
(13, 48, 5, 'sample_A.pdf', 2, NULL, NULL, 1577355788, 1577355788),
(14, 47, 1, 'B Sample PDF.pdf', 1, NULL, NULL, 1577358782, 1577358782),
(15, 47, 1, 'B Sample PDF.pdf', 2, NULL, NULL, 1577358875, 1577358875),
(16, 47, 5, 'B Sample PDF.pdf', 2, NULL, NULL, 1577361486, 1577361486),
(17, 43, 5, 'c4611_sample_explain.pdf', 1, NULL, NULL, 1577361291, 1577361291),
(18, 42, 1, 'adobefile.pdf', 1, NULL, NULL, 1577364811, 1577364811),
(19, 42, 1, 'adobefile.pdf', 2, NULL, NULL, 1577362137, 1577362137),
(20, 48, 1, 'sample_A.pdf', 1, NULL, NULL, 1577364637, 1577364637);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `page` text NOT NULL,
  `data` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `client_id`, `file_id`, `file_name`, `page`, `data`, `type`, `created_at`) VALUES
(1, 1, 37, 'file-example_PDF_1MB.pdf', '12', '[{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1}]', 'Annotation', 1577341645),
(2, 1, 37, 'file-example_PDF_1MB.pdf', '12', '[{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#ff8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1},{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1}]', 'Annotation', 1577341885),
(3, 1, 37, 'file-example_PDF_1MB.pdf', '12', '[{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1},{\"bbox\":[481.49169921875,155.43804931640625,32.86328125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#808080\",\"createdAt\":\"2019-12-26T06:31:52Z\",\"id\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"name\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[481.49169921875,155.43804931640625,32.86328125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:31:52Z\",\"v\":1},{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FF8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1}]', 'Annotation', 1577341958),
(4, 1, 37, 'file-example_PDF_1MB.pdf', '12', '[{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FF8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1},{\"bbox\":[481.49169921875,155.43804931640625,32.86328125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#808080\",\"createdAt\":\"2019-12-26T06:31:52Z\",\"id\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"name\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[481.49169921875,155.43804931640625,32.86328125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:31:52Z\",\"v\":1},{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1}]', 'Annotation', 1577341994),
(5, 1, 37, 'file-example_PDF_1MB.pdf', '12', '[{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1},{\"bbox\":[481.49169921875,155.43804931640625,32.86328125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#808080\",\"createdAt\":\"2019-12-26T06:31:52Z\",\"id\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"name\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[481.49169921875,155.43804931640625,32.86328125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:31:52Z\",\"v\":1},{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FF8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1},{\"bbox\":[70,300,460,33],\"blendMode\":\"multiply\",\"createdAt\":\"2019-12-26T06:41:59Z\",\"id\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"isDrawnNaturally\":false,\"lineWidth\":30,\"lines\":{\"intensities\":[[0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5]],\"points\":[[[85.5,315.5],[94.30000305175781,315.5],[103.0999984741211,315.5],[111.9000015258789,316.29998779296875],[119.9000015258789,317.9000244140625],[128.6999969482422,317.9000244140625],[137.5,317.9000244140625],[146.3000030517578,317.9000244140625],[155.10000610351562,317.9000244140625],[163.89999389648438,317.9000244140625],[172.6999969482422,317.9000244140625],[182.3000030517578,317.9000244140625],[191.10000610351562,317.9000244140625],[199.89999389648438,317.9000244140625],[209.5,317.9000244140625],[218.3000030517578,317.9000244140625],[226.3000030517578,317.0999755859375],[234.3000030517578,315.5],[243.10000610351562,315.5],[251.89999389648438,315.5],[260.70001220703125,315.5],[269.5,315.5],[279.1000061035156,315.5],[287.8999938964844,315.5],[296.70001220703125,315.5],[305.5,315.5],[314.29998779296875,315.5],[323.1000061035156,315.5],[332.70001220703125,315.5],[341.5,315.5],[351.1000061035156,315.5],[359.8999938964844,315.5],[370.29998779296875,315.5],[379.1000061035156,315.5],[388.70001220703125,315.5],[397.5,315.5],[407.1000061035156,315.5],[415.8999938964844,315.5],[424.70001220703125,315.5],[433.5,315.5],[443.1000061035156,315.5],[451.8999938964844,315.5],[461.5,315.5],[470.29998779296875,315.5],[479.1000061035156,315.5],[488.70001220703125,315.5],[498.29998779296875,315.5],[507.1000061035156,315.5],[514.2999877929688,315.5]]]},\"name\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"opacity\":1,\"pageIndex\":11,\"strokeColor\":\"#F587FF\",\"type\":\"pspdfkit\\/ink\",\"updatedAt\":\"2019-12-26T06:42:14Z\",\"v\":1}]', 'Annotation', 1577342550),
(6, 1, 37, 'file-example_PDF_1MB.pdf', '11', '[{\"bbox\":[481.49169921875,155.43804931640625,32.86328125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#808080\",\"createdAt\":\"2019-12-26T06:31:52Z\",\"id\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"name\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[481.49169921875,155.43804931640625,32.86328125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:31:52Z\",\"v\":1},{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1},{\"bbox\":[56.88399887084961,217.53802490234375,129.4562530517578,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T06:53:41Z\",\"id\":\"01DX0FPZSAWQ1NAZV6NHRMEE7A\",\"name\":\"01DX0FPZSAWQ1NAZV6NHRMEE7A\",\"opacity\":1,\"pageIndex\":10,\"rects\":[[56.88399887084961,217.53802490234375,129.4562530517578,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:53:47Z\",\"v\":1},{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FF8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1},{\"bbox\":[70,300,460,33],\"blendMode\":\"multiply\",\"createdAt\":\"2019-12-26T06:41:59Z\",\"id\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"isDrawnNaturally\":false,\"lineWidth\":30,\"lines\":{\"intensities\":[[0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5]],\"points\":[[[85.5,315.5],[94.30000305175781,315.5],[103.0999984741211,315.5],[111.9000015258789,316.29998779296875],[119.9000015258789,317.9000244140625],[128.6999969482422,317.9000244140625],[137.5,317.9000244140625],[146.3000030517578,317.9000244140625],[155.10000610351562,317.9000244140625],[163.89999389648438,317.9000244140625],[172.6999969482422,317.9000244140625],[182.3000030517578,317.9000244140625],[191.10000610351562,317.9000244140625],[199.89999389648438,317.9000244140625],[209.5,317.9000244140625],[218.3000030517578,317.9000244140625],[226.3000030517578,317.0999755859375],[234.3000030517578,315.5],[243.10000610351562,315.5],[251.89999389648438,315.5],[260.70001220703125,315.5],[269.5,315.5],[279.1000061035156,315.5],[287.8999938964844,315.5],[296.70001220703125,315.5],[305.5,315.5],[314.29998779296875,315.5],[323.1000061035156,315.5],[332.70001220703125,315.5],[341.5,315.5],[351.1000061035156,315.5],[359.8999938964844,315.5],[370.29998779296875,315.5],[379.1000061035156,315.5],[388.70001220703125,315.5],[397.5,315.5],[407.1000061035156,315.5],[415.8999938964844,315.5],[424.70001220703125,315.5],[433.5,315.5],[443.1000061035156,315.5],[451.8999938964844,315.5],[461.5,315.5],[470.29998779296875,315.5],[479.1000061035156,315.5],[488.70001220703125,315.5],[498.29998779296875,315.5],[507.1000061035156,315.5],[514.2999877929688,315.5]]]},\"name\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"opacity\":1,\"pageIndex\":11,\"strokeColor\":\"#F587FF\",\"type\":\"pspdfkit\\/ink\",\"updatedAt\":\"2019-12-26T06:42:14Z\",\"v\":1}]', 'Annotation', 1577343275),
(7, 1, 37, 'file-example_PDF_1MB.pdf', '11', '[{\"bbox\":[70,300,460,33],\"blendMode\":\"multiply\",\"createdAt\":\"2019-12-26T06:41:59Z\",\"id\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"isDrawnNaturally\":false,\"lineWidth\":30,\"lines\":{\"intensities\":[[0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5]],\"points\":[[[85.5,315.5],[94.30000305175781,315.5],[103.0999984741211,315.5],[111.9000015258789,316.29998779296875],[119.9000015258789,317.9000244140625],[128.6999969482422,317.9000244140625],[137.5,317.9000244140625],[146.3000030517578,317.9000244140625],[155.10000610351562,317.9000244140625],[163.89999389648438,317.9000244140625],[172.6999969482422,317.9000244140625],[182.3000030517578,317.9000244140625],[191.10000610351562,317.9000244140625],[199.89999389648438,317.9000244140625],[209.5,317.9000244140625],[218.3000030517578,317.9000244140625],[226.3000030517578,317.0999755859375],[234.3000030517578,315.5],[243.10000610351562,315.5],[251.89999389648438,315.5],[260.70001220703125,315.5],[269.5,315.5],[279.1000061035156,315.5],[287.8999938964844,315.5],[296.70001220703125,315.5],[305.5,315.5],[314.29998779296875,315.5],[323.1000061035156,315.5],[332.70001220703125,315.5],[341.5,315.5],[351.1000061035156,315.5],[359.8999938964844,315.5],[370.29998779296875,315.5],[379.1000061035156,315.5],[388.70001220703125,315.5],[397.5,315.5],[407.1000061035156,315.5],[415.8999938964844,315.5],[424.70001220703125,315.5],[433.5,315.5],[443.1000061035156,315.5],[451.8999938964844,315.5],[461.5,315.5],[470.29998779296875,315.5],[479.1000061035156,315.5],[488.70001220703125,315.5],[498.29998779296875,315.5],[507.1000061035156,315.5],[514.2999877929688,315.5]]]},\"name\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"opacity\":1,\"pageIndex\":11,\"strokeColor\":\"#F587FF\",\"type\":\"pspdfkit\\/ink\",\"updatedAt\":\"2019-12-26T06:42:14Z\",\"v\":1},{\"bbox\":[56.88399887084961,217.53802490234375,129.4562530517578,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T06:53:41Z\",\"id\":\"01DX0FPZSAWQ1NAZV6NHRMEE7A\",\"name\":\"01DX0FPZSAWQ1NAZV6NHRMEE7A\",\"opacity\":1,\"pageIndex\":10,\"rects\":[[56.88399887084961,217.53802490234375,129.4562530517578,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:53:47Z\",\"v\":1},{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1},{\"bbox\":[481.49169921875,155.43804931640625,32.86328125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#808080\",\"createdAt\":\"2019-12-26T06:31:52Z\",\"id\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"name\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[481.49169921875,155.43804931640625,32.86328125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:31:52Z\",\"v\":1},{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FF8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1}]', 'Annotation', 1577343336),
(8, 1, 37, 'file-example_PDF_1MB.pdf', '12', '[{\"bbox\":[481.49169921875,155.43804931640625,32.86328125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#808080\",\"createdAt\":\"2019-12-26T06:31:52Z\",\"id\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"name\":\"01DX0EF1MWCEGVV35SEDZFZ2G1\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[481.49169921875,155.43804931640625,32.86328125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:31:52Z\",\"v\":1},{\"bbox\":[70,300,460,33],\"blendMode\":\"multiply\",\"createdAt\":\"2019-12-26T06:41:59Z\",\"id\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"isDrawnNaturally\":false,\"lineWidth\":30,\"lines\":{\"intensities\":[[0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5]],\"points\":[[[85.5,315.5],[94.30000305175781,315.5],[103.0999984741211,315.5],[111.9000015258789,316.29998779296875],[119.9000015258789,317.9000244140625],[128.6999969482422,317.9000244140625],[137.5,317.9000244140625],[146.3000030517578,317.9000244140625],[155.10000610351562,317.9000244140625],[163.89999389648438,317.9000244140625],[172.6999969482422,317.9000244140625],[182.3000030517578,317.9000244140625],[191.10000610351562,317.9000244140625],[199.89999389648438,317.9000244140625],[209.5,317.9000244140625],[218.3000030517578,317.9000244140625],[226.3000030517578,317.0999755859375],[234.3000030517578,315.5],[243.10000610351562,315.5],[251.89999389648438,315.5],[260.70001220703125,315.5],[269.5,315.5],[279.1000061035156,315.5],[287.8999938964844,315.5],[296.70001220703125,315.5],[305.5,315.5],[314.29998779296875,315.5],[323.1000061035156,315.5],[332.70001220703125,315.5],[341.5,315.5],[351.1000061035156,315.5],[359.8999938964844,315.5],[370.29998779296875,315.5],[379.1000061035156,315.5],[388.70001220703125,315.5],[397.5,315.5],[407.1000061035156,315.5],[415.8999938964844,315.5],[424.70001220703125,315.5],[433.5,315.5],[443.1000061035156,315.5],[451.8999938964844,315.5],[461.5,315.5],[470.29998779296875,315.5],[479.1000061035156,315.5],[488.70001220703125,315.5],[498.29998779296875,315.5],[507.1000061035156,315.5],[514.2999877929688,315.5]]]},\"name\":\"01DX0F1JM74JN4AP0YRSATJ968\",\"opacity\":1,\"pageIndex\":11,\"strokeColor\":\"#F587FF\",\"type\":\"pspdfkit\\/ink\",\"updatedAt\":\"2019-12-26T06:42:14Z\",\"v\":1},{\"bbox\":[71.46493530273438,81.93804931640625,89.9453125,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T07:57:51Z\",\"id\":\"01DX0KCF3BVBWPR1KE7FNY2QPH\",\"name\":\"01DX0KCF3BVBWPR1KE7FNY2QPH\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[71.46493530273438,81.93804931640625,89.9453125,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T07:57:51Z\",\"v\":1},{\"bbox\":[150.74874877929688,170.13800048828125,152.4375,12.2109375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T06:27:01Z\",\"id\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"name\":\"01DX0E65MXDNDTGASMJJGM76MQ\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[150.74874877929688,170.13800048828125,152.4375,12.2109375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T06:27:01Z\",\"v\":1},{\"bbox\":[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FF8080\",\"createdAt\":\"2019-12-26T06:28:50Z\",\"id\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"name\":\"01DX0E9FJ177Q97TY004GPWSAP\",\"opacity\":1,\"pageIndex\":11,\"rects\":[[57.692501068115234,170.13800048828125,40.24921798706055,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:28:58Z\",\"v\":1},{\"bbox\":[56.88399887084961,217.53802490234375,129.4562530517578,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T06:53:41Z\",\"id\":\"01DX0FPZSAWQ1NAZV6NHRMEE7A\",\"name\":\"01DX0FPZSAWQ1NAZV6NHRMEE7A\",\"opacity\":1,\"pageIndex\":10,\"rects\":[[56.88399887084961,217.53802490234375,129.4562530517578,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T06:53:47Z\",\"v\":1}]', 'Annotation', 1577347093),
(9, 5, 37, 'file-example_PDF_1MB.pdf', '2', '[{\"bbox\":[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T09:52:49Z\",\"id\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"name\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"opacity\":1,\"pageIndex\":1,\"rects\":[[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T09:52:54Z\",\"v\":1}]', 'Annotation', 1577353990),
(10, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T09:52:49Z\",\"id\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"name\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"opacity\":1,\"pageIndex\":1,\"rects\":[[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T09:52:54Z\",\"v\":1},{\"bbox\":[242.20054626464844,305.738037109375,84.65937805175781,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:01:37Z\",\"id\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"name\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[242.20054626464844,305.738037109375,84.65937805175781,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:01:37Z\",\"v\":1}]', 'Annotation', 1577354513),
(11, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[242.20054626464844,305.738037109375,84.65937805175781,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:01:37Z\",\"id\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"name\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[242.20054626464844,305.738037109375,84.65937805175781,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:01:37Z\",\"v\":1},{\"bbox\":[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T09:52:49Z\",\"id\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"name\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"opacity\":1,\"pageIndex\":1,\"rects\":[[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T09:52:54Z\",\"v\":1}]', 'Annotation', 1577354610),
(12, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T09:52:49Z\",\"id\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"name\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"opacity\":1,\"pageIndex\":1,\"rects\":[[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T09:52:54Z\",\"v\":1},{\"bbox\":[242.20054626464844,305.738037109375,84.65937805175781,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:01:37Z\",\"id\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"name\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[242.20054626464844,305.738037109375,84.65937805175781,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:01:37Z\",\"v\":1}]', 'Annotation', 1577354965),
(13, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[242.20054626464844,305.738037109375,84.65937805175781,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:01:37Z\",\"id\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"name\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[242.20054626464844,305.738037109375,84.65937805175781,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:01:37Z\",\"v\":1},{\"bbox\":[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T09:52:49Z\",\"id\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"name\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"opacity\":1,\"pageIndex\":1,\"rects\":[[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T09:52:54Z\",\"v\":1}]', 'Annotation', 1577355355),
(14, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T09:52:49Z\",\"id\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"name\":\"01DX0SZ093W3BXFAYPYBSTXQS1\",\"opacity\":1,\"pageIndex\":1,\"rects\":[[170.16883850097656,196.13800048828125,137.0671844482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T09:52:54Z\",\"v\":1},{\"bbox\":[242.20054626464844,305.738037109375,84.65937805175781,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:01:37Z\",\"id\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"name\":\"01DX0TF35WEPWWRVFX7NAKNWDD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[242.20054626464844,305.738037109375,84.65937805175781,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:01:37Z\",\"v\":1}]', 'Annotation', 1577355543),
(15, 5, 48, 'sample_A.pdf', '1', '[{\"bbox\":[149.8874969482422,117.158447265625,119.04530334472656,11.6898193359375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:21:35Z\",\"id\":\"01DX0VKNBYAC8EGTX2NFJ85PA5\",\"name\":\"01DX0VKNBYAC8EGTX2NFJ85PA5\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[149.8874969482422,117.158447265625,119.04530334472656,11.6898193359375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:21:35Z\",\"v\":1}]', 'Annotation', 1577355713),
(16, 5, 48, 'sample_A.pdf', '1', '[{\"bbox\":[149.8874969482422,117.158447265625,119.04530334472656,11.6898193359375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T10:21:35Z\",\"id\":\"01DX0VKNBYAC8EGTX2NFJ85PA5\",\"name\":\"01DX0VKNBYAC8EGTX2NFJ85PA5\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[149.8874969482422,117.158447265625,119.04530334472656,11.6898193359375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T10:21:35Z\",\"v\":1}]', 'Annotation', 1577355787),
(17, 1, 47, 'B Sample PDF.pdf', '1', '[{\"bbox\":[215.28981018066406,203.138427734375,126.09373474121094,11.70782470703125],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T10:33:43Z\",\"id\":\"01DX0W9WKY2MEGFM5931ZC91PY\",\"name\":\"01DX0W9WKY2MEGFM5931ZC91PY\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[215.28981018066406,203.138427734375,126.09373474121094,11.70782470703125]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T10:33:43Z\",\"v\":1}]', 'Annotation', 1577356457),
(18, 1, 47, 'B Sample PDF.pdf', '1', '[{\"bbox\":[215.28981018066406,203.138427734375,105.39610290527344,11.70782470703125],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T11:11:37Z\",\"id\":\"01DX0YF9FBTZTP2XMMMVJ1RWDB\",\"name\":\"01DX0YF9FBTZTP2XMMMVJ1RWDB\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[215.28981018066406,203.138427734375,105.39610290527344,11.70782470703125]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T11:11:37Z\",\"v\":1}]', 'Annotation', 1577358715),
(19, 1, 47, 'B Sample PDF.pdf', '1', '[{\"bbox\":[215.28981018066406,203.138427734375,105.39610290527344,11.70782470703125],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T11:11:37Z\",\"id\":\"01DX0YF9FBTZTP2XMMMVJ1RWDB\",\"name\":\"01DX0YF9FBTZTP2XMMMVJ1RWDB\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[215.28981018066406,203.138427734375,105.39610290527344,11.70782470703125]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T11:11:37Z\",\"v\":1}]', 'Annotation', 1577358875),
(20, 5, 47, 'B Sample PDF.pdf', '1', '[{\"bbox\":[226.3267364501953,275.658447265625,97.76405334472656,11.707855224609375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T11:49:18Z\",\"id\":\"01DX10M9C7W0S0B6G532QPGA7D\",\"name\":\"01DX10M9C7W0S0B6G532QPGA7D\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[226.3267364501953,275.658447265625,97.76405334472656,11.707855224609375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T11:49:21Z\",\"v\":1}]', 'Annotation', 1577361143),
(21, 5, 47, 'B Sample PDF.pdf', '1', '[{\"bbox\":[226.3267364501953,275.658447265625,97.76405334472656,11.707855224609375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T11:49:18Z\",\"id\":\"01DX10M9C7W0S0B6G532QPGA7D\",\"name\":\"01DX10M9C7W0S0B6G532QPGA7D\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[226.3267364501953,275.658447265625,97.76405334472656,11.707855224609375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T11:49:21Z\",\"v\":1}]', 'Annotation', 1577361322),
(22, 5, 47, 'B Sample PDF.pdf', '1', '[{\"bbox\":[226.3267364501953,275.658447265625,97.76405334472656,11.707855224609375],\"blendMode\":\"multiply\",\"color\":\"#8DB8FF\",\"createdAt\":\"2019-12-26T11:49:18Z\",\"id\":\"01DX10M9C7W0S0B6G532QPGA7D\",\"name\":\"01DX10M9C7W0S0B6G532QPGA7D\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[226.3267364501953,275.658447265625,97.76405334472656,11.707855224609375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T11:49:21Z\",\"v\":1}]', 'Annotation', 1577361486),
(23, 1, 42, 'adobefile.pdf', '1', '[{\"bbox\":[177.62091064453125,101.2064208984375,50.43281555175781,13.2835693359375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T12:06:20Z\",\"id\":\"01DX11KERZYPY2PZCKPVGXNJ3X\",\"name\":\"01DX11KERZYPY2PZCKPVGXNJ3X\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[177.62091064453125,101.2064208984375,50.43281555175781,13.2835693359375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T12:06:20Z\",\"v\":1}]', 'Annotation', 1577361994),
(24, 1, 42, 'adobefile.pdf', '1', '[{\"bbox\":[177.62091064453125,101.2064208984375,50.43281555175781,13.2835693359375],\"blendMode\":\"normal\",\"color\":\"#000000\",\"createdAt\":\"2019-12-26T12:06:20Z\",\"id\":\"01DX11KERZYPY2PZCKPVGXNJ3X\",\"name\":\"01DX11KERZYPY2PZCKPVGXNJ3X\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[177.62091064453125,101.2064208984375,50.43281555175781,13.2835693359375]],\"type\":\"pspdfkit\\/markup\\/underline\",\"updatedAt\":\"2019-12-26T12:06:20Z\",\"v\":1},{\"bbox\":[157.18856811523438,253.2401123046875,102.62265014648438,15.635986328125],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:08:44Z\",\"id\":\"01DX11QVKBDB968TSCTCJ3P52E\",\"name\":\"01DX11QVKBDB968TSCTCJ3P52E\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[157.18856811523438,253.2401123046875,102.62265014648438,15.635986328125]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:08:44Z\",\"v\":1}]', 'Annotation', 1577362137),
(25, 1, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:34:53Z\",\"id\":\"01DX137QG4ZRYQV532XHKAEY39\",\"name\":\"01DX137QG4ZRYQV532XHKAEY39\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:34:53Z\",\"v\":1}]', 'Annotation', 1577363708),
(26, 1, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:34:53Z\",\"id\":\"01DX137QG4ZRYQV532XHKAEY39\",\"name\":\"01DX137QG4ZRYQV532XHKAEY39\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:34:53Z\",\"v\":1},{\"bbox\":[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:38:55Z\",\"id\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"name\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:38:55Z\",\"v\":1}]', 'Annotation', 1577363958),
(27, 1, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:34:53Z\",\"id\":\"01DX137QG4ZRYQV532XHKAEY39\",\"name\":\"01DX137QG4ZRYQV532XHKAEY39\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:34:53Z\",\"v\":1},{\"bbox\":[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:38:55Z\",\"id\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"name\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:38:55Z\",\"v\":1},{\"bbox\":[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:41:06Z\",\"id\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"name\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:41:06Z\",\"v\":1}]', 'Annotation', 1577364081),
(28, 1, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:34:53Z\",\"id\":\"01DX137QG4ZRYQV532XHKAEY39\",\"name\":\"01DX137QG4ZRYQV532XHKAEY39\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:34:53Z\",\"v\":1},{\"bbox\":[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:38:55Z\",\"id\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"name\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:38:55Z\",\"v\":1},{\"bbox\":[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:41:06Z\",\"id\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"name\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:41:06Z\",\"v\":1},{\"bbox\":[395.2780456542969,320.43804931640625,142.14920043945312,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:42:40Z\",\"id\":\"01DX13P01Y18QECRKVJQJJQBD7\",\"name\":\"01DX13P01Y18QECRKVJQJJQBD7\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[395.2780456542969,320.43804931640625,142.14920043945312,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:42:40Z\",\"v\":1}]', 'Annotation', 1577364178),
(29, 1, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:34:53Z\",\"id\":\"01DX137QG4ZRYQV532XHKAEY39\",\"name\":\"01DX137QG4ZRYQV532XHKAEY39\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:34:53Z\",\"v\":1},{\"bbox\":[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:38:55Z\",\"id\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"name\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:38:55Z\",\"v\":1},{\"bbox\":[395.2780456542969,320.43804931640625,142.14920043945312,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:42:40Z\",\"id\":\"01DX13P01Y18QECRKVJQJJQBD7\",\"name\":\"01DX13P01Y18QECRKVJQJJQBD7\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[395.2780456542969,320.43804931640625,142.14920043945312,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:42:40Z\",\"v\":1},{\"bbox\":[88.08438110351562,513.8902587890625,34.47265625,13.6812744140625],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:53:05Z\",\"id\":\"01DX14922MZ57900H03MEB9SNQ\",\"name\":\"01DX14922MZ57900H03MEB9SNQ\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[88.08438110351562,513.8902587890625,34.47265625,13.6812744140625]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:53:05Z\",\"v\":1},{\"bbox\":[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:41:06Z\",\"id\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"name\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:41:06Z\",\"v\":1}]', 'Annotation', 1577364797),
(30, 1, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:38:55Z\",\"id\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"name\":\"01DX13F3TGAWWSHC5FXDVNFHMG\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[406.6261901855469,217.53802490234375,113.84609985351562,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:38:55Z\",\"v\":1},{\"bbox\":[395.2780456542969,320.43804931640625,142.14920043945312,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:42:40Z\",\"id\":\"01DX13P01Y18QECRKVJQJJQBD7\",\"name\":\"01DX13P01Y18QECRKVJQJJQBD7\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[395.2780456542969,320.43804931640625,142.14920043945312,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:42:40Z\",\"v\":1},{\"bbox\":[88.08438110351562,513.8902587890625,34.47265625,13.6812744140625],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:53:05Z\",\"id\":\"01DX14922MZ57900H03MEB9SNQ\",\"name\":\"01DX14922MZ57900H03MEB9SNQ\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[88.08438110351562,513.8902587890625,34.47265625,13.6812744140625]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:53:05Z\",\"v\":1},{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:34:53Z\",\"id\":\"01DX137QG4ZRYQV532XHKAEY39\",\"name\":\"01DX137QG4ZRYQV532XHKAEY39\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:34:53Z\",\"v\":1},{\"bbox\":[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-26T12:41:06Z\",\"id\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"name\":\"01DX13K3WQ974GNMGAE4DMJ5WQ\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[144.1806182861328,246.93804931640625,156.47654724121094,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-26T12:41:06Z\",\"v\":1}]', 'Annotation', 1577367017),
(31, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T06:30:40Z\",\"id\":\"01DX30SHQVKA7WJ0F3593Y7CCN\",\"name\":\"01DX30SHQVKA7WJ0F3593Y7CCN\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[56.88399887084961,217.53802490234375,299.5765686035156,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-27T06:30:40Z\",\"v\":1}]', 'Annotation', 1577428251),
(32, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[157.2152557373047,217.53802490234375,97.58045959472656,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:00:43Z\",\"id\":\"01DX32GJG850GBHGBFGHB4E9FC\",\"name\":\"01DX32GJG850GBHGBFGHB4E9FC\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[157.2152557373047,217.53802490234375,97.58045959472656,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-27T07:00:43Z\",\"v\":1}]', 'Annotation', 1577430050),
(33, 5, 37, 'file-example_PDF_1MB.pdf', '1', '[{\"bbox\":[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375],\"blendMode\":\"multiply\",\"color\":\"#FCEE7C\",\"createdAt\":\"2019-12-27T07:04:56Z\",\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"opacity\":1,\"pageIndex\":0,\"rects\":[[205.99961853027344,217.53802490234375,176.8953094482422,12.2109375]],\"type\":\"pspdfkit\\/markup\\/highlight\",\"updatedAt\":\"2019-12-27T07:04:56Z\",\"v\":1}]', 'Annotation', 1577430303);

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `screen_id` int(11) NOT NULL,
  `screen_client_id` int(11) NOT NULL,
  `screen_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `screensharefile`
--

CREATE TABLE `screensharefile` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `selected_text_comment`
--

CREATE TABLE `selected_text_comment` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `comment` blob DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `page_no` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `selected_text_comment`
--

INSERT INTO `selected_text_comment` (`id`, `parent`, `comment`, `user_id`, `file_id`, `file_name`, `page_no`, `created_at`, `updated_at`) VALUES
(5, 1, 0x68696969, 5, 37, 'file-example_PDF_1MB.pdf', 1, '2019-12-27 07:05:06', '2019-12-27 12:35:06'),
(6, 1, 0x74657374, 1, 37, 'file-example_PDF_1MB.pdf', 1, '2019-12-27 07:05:53', '2019-12-27 12:35:53'),
(7, 1, 0x68656c6c6f, 5, 37, 'file-example_PDF_1MB.pdf', 1, '2019-12-27 07:06:41', '2019-12-27 12:36:41'),
(8, 1, 0x71, 1, 37, 'file-example_PDF_1MB.pdf', 1, '2019-12-27 07:07:43', '2019-12-27 12:37:43'),
(9, 1, 0x67626762, 5, 37, 'file-example_PDF_1MB.pdf', 1, '2019-12-27 07:09:28', '2019-12-27 12:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `selected_text_information`
--

CREATE TABLE `selected_text_information` (
  `id` int(11) NOT NULL,
  `text` blob DEFAULT NULL,
  `instance_json` text DEFAULT NULL,
  `main_instance_json_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `page_no` varchar(100) DEFAULT NULL,
  `file_id` int(100) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `selected_text_information`
--

INSERT INTO `selected_text_information` (`id`, `text`, `instance_json`, `main_instance_json_id`, `comment`, `page_no`, `file_id`, `file_name`, `created_at`, `updated_at`) VALUES
(1, 0x63656c657269737175652073697420616d6574206c6967756c612065752c20636f6e, '{\"id\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"name\":\"01DX32RA6EV2PWNS6ZPM1GT0RD\",\"v\":1,\"pageIndex\":0,\"bbox\":[205.9996238708496,217.5380126953125,176.89531250000002,12.2109375],\"opacity\":1,\"createdAt\":\"2019-12-27T07:04:56.783Z\",\"updatedAt\":\"2019-12-27T07:04:56.783Z\",\"type\":\"pspdfkit/markup/highlight\",\"rects\":[[205.9996238708496,217.5380126953125,176.89531250000002,12.2109375]],\"color\":\"#fcee7c\",\"blendMode\":\"multiply\"}', 1, NULL, '1', 37, 'file-example_PDF_1MB.pdf', '2019-12-27 07:05:06', '2019-12-27 12:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `sharing`
--

CREATE TABLE `sharing` (
  `sharing_id` int(11) NOT NULL,
  `sharing_client_id` int(11) NOT NULL,
  `sharing_to_client_id` int(11) NOT NULL,
  `sharing_files` int(11) DEFAULT -1,
  `sharing_screen` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `color_tag` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags_status`
--

CREATE TABLE `tags_status` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `task_description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `task_priority` int(10) NOT NULL COMMENT '0="high", 1="medium", 2="low"',
  `task_creation_date` bigint(20) DEFAULT NULL,
  `task_completion_date` bigint(20) DEFAULT NULL,
  `created_at` bigint(20) NOT NULL,
  `completed_date` bigint(20) NOT NULL DEFAULT 0,
  `updated_at` bigint(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `job_id` varchar(250) DEFAULT NULL,
  `client_id` varchar(255) NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topic_chat`
--

CREATE TABLE `topic_chat` (
  `id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `msg_type` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `recipient_ids` varchar(255) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `reader_ids` varchar(255) DEFAULT NULL,
  `new_msg` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_display_name` varchar(100) DEFAULT NULL,
  `user_last_login` bigint(20) DEFAULT NULL,
  `user_last_login_ip` varchar(255) DEFAULT NULL,
  `user_status` int(11) DEFAULT 1,
  `user_level` varchar(3) NOT NULL,
  `user_role` int(11) DEFAULT NULL,
  `user_date_created` bigint(20) NOT NULL,
  `user_date_last_update` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_display_name`, `user_last_login`, `user_last_login_ip`, `user_status`, `user_level`, `user_role`, `user_date_created`, `user_date_last_update`) VALUES
(5, 'superadmin', '375454b8a2903d8b1b3a8e404865f67b', 'eTabeall Super Admin', NULL, NULL, 1, '1', 111, 1555226012, 0);

-- --------------------------------------------------------

--
-- Table structure for table `witness`
--

CREATE TABLE `witness` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `witness_name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `witness_file`
--

CREATE TABLE `witness_file` (
  `id` int(11) NOT NULL,
  `witness_id` int(11) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `doc_issuename` varchar(100) DEFAULT NULL,
  `doc_color` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `annotations`
--
ALTER TABLE `annotations`
  ADD PRIMARY KEY (`annotation_id`);

--
-- Indexes for table `bookmarked`
--
ALTER TABLE `bookmarked`
  ADD PRIMARY KEY (`bookmarked_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `client_unique_id_idx` (`client_unique_id`);

--
-- Indexes for table `device_token`
--
ALTER TABLE `device_token`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`download_id`),
  ADD UNIQUE KEY `download_client_id` (`download_client_id`,`download_file_id`);

--
-- Indexes for table `edited_files`
--
ALTER TABLE `edited_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_id` (`file_id`,`client_id`);

--
-- Indexes for table `edited_files_new`
--
ALTER TABLE `edited_files_new`
  ADD PRIMARY KEY (`edited_file_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `files_index`
--
ALTER TABLE `files_index`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `file_name_idx` (`file_name`(767));

--
-- Indexes for table `ftp`
--
ALTER TABLE `ftp`
  ADD PRIMARY KEY (`ftp_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hyperlinks`
--
ALTER TABLE `hyperlinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobfiles`
--
ALTER TABLE `jobfiles`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `live_screens`
--
ALTER TABLE `live_screens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `one_to_one`
--
ALTER TABLE `one_to_one`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_file_overlay`
--
ALTER TABLE `pdf_file_overlay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `push_notification`
--
ALTER TABLE `push_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quick_access`
--
ALTER TABLE `quick_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`screen_id`);

--
-- Indexes for table `screensharefile`
--
ALTER TABLE `screensharefile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_text_comment`
--
ALTER TABLE `selected_text_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_text_information`
--
ALTER TABLE `selected_text_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sharing`
--
ALTER TABLE `sharing`
  ADD PRIMARY KEY (`sharing_id`),
  ADD UNIQUE KEY `sharing_client_id` (`sharing_client_id`,`sharing_to_client_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags_status`
--
ALTER TABLE `tags_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `topic_chat`
--
ALTER TABLE `topic_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD KEY `user_name_idx` (`user_name`);

--
-- Indexes for table `witness`
--
ALTER TABLE `witness`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `witness_file`
--
ALTER TABLE `witness_file`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `annotations`
--
ALTER TABLE `annotations`
  MODIFY `annotation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookmarked`
--
ALTER TABLE `bookmarked`
  MODIFY `bookmarked_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `device_token`
--
ALTER TABLE `device_token`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `download_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `edited_files`
--
ALTER TABLE `edited_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edited_files_new`
--
ALTER TABLE `edited_files_new`
  MODIFY `edited_file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `files_index`
--
ALTER TABLE `files_index`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ftp`
--
ALTER TABLE `ftp`
  MODIFY `ftp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_chat`
--
ALTER TABLE `group_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hyperlinks`
--
ALTER TABLE `hyperlinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobfiles`
--
ALTER TABLE `jobfiles`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `live_screens`
--
ALTER TABLE `live_screens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `one_to_one`
--
ALTER TABLE `one_to_one`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pdf_file_overlay`
--
ALTER TABLE `pdf_file_overlay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `push_notification`
--
ALTER TABLE `push_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quick_access`
--
ALTER TABLE `quick_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `screens`
--
ALTER TABLE `screens`
  MODIFY `screen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `screensharefile`
--
ALTER TABLE `screensharefile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `selected_text_comment`
--
ALTER TABLE `selected_text_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `selected_text_information`
--
ALTER TABLE `selected_text_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sharing`
--
ALTER TABLE `sharing`
  MODIFY `sharing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags_status`
--
ALTER TABLE `tags_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topic_chat`
--
ALTER TABLE `topic_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `witness`
--
ALTER TABLE `witness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `witness_file`
--
ALTER TABLE `witness_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
