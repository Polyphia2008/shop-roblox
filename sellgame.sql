-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 02, 2025 at 05:02 PM
-- Server version: 10.6.20-MariaDB
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sellgame_ducapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountorder`
--

CREATE TABLE `accountorder` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `seller` text NOT NULL,
  `status` text NOT NULL,
  `rate` text NOT NULL,
  `robux` text NOT NULL,
  `price` text NOT NULL,
  `guarantee` text NOT NULL,
  `premium` text NOT NULL,
  `giaohang` text NOT NULL,
  `information` text NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `magd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `accountorder`
--

INSERT INTO `accountorder` (`id`, `username`, `seller`, `status`, `rate`, `robux`, `price`, `guarantee`, `premium`, `giaohang`, `information`, `time`, `magd`) VALUES
(174, 'vancongduc33@gmail.com', 'vanduc@gmail.com', '3', '100', '34', '3400', '4', '1', '2025/02/01 21:15:22', '', '', 'IQO5881739982'),
(175, '', 'vancongduc33@gmail.com', '1', '107', '23232', '2485824', '4', '0', '', '', '', ''),
(176, '', 'vancongduc33@gmail.com', '1', '99', '32', '3168', '4', '1', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `accountrb`
--

CREATE TABLE `accountrb` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `seller` text NOT NULL,
  `status` text NOT NULL,
  `rate` text NOT NULL,
  `robux` text NOT NULL,
  `price` text NOT NULL,
  `guarantee` text NOT NULL,
  `premium` text NOT NULL,
  `datejoin` text NOT NULL,
  `information` text NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `magd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `accountrb`
--

INSERT INTO `accountrb` (`id`, `username`, `seller`, `status`, `rate`, `robux`, `price`, `guarantee`, `premium`, `datejoin`, `information`, `time`, `magd`) VALUES
(169, 'vancongduc33@gmail.com', 'vanduc@gmail.com', '2', '102', '23', '2346', '5', '1', '43', '{\"tknick\":\"ewrs\",\"pass\":\"sde\",\"2fa\":\"\",\"dichvu\":\"nick\",\"timeup\":\"2025\\/01\\/30 11:58:09\"}', '2025/01/30 11:58:43', 'DBS3858516368'),
(170, 'vanduc@gmail.com', 'vanduc@gmail.com', '2', '104', '34', '3536', '4', '1', '34', '{\"tknick\":\"re\",\"pass\":\"re\",\"2fa\":\"\",\"dichvu\":\"nick\",\"timeup\":\"2025\\/01\\/30 12:01:03\"}', '2025/01/30 12:01:09', 'KGC8509940112'),
(171, '', 'vancongduc33@gmail.com', '1', '100', '3234', '323400', '4', '1', '212 ngày', '{\"tknick\":\"confds\",\"pass\":\"ss\",\"2fa\":\"67sdasacasFDSFD\",\"dichvu\":\"nick\",\"timeup\":\"2025\\/02\\/02 07:35:36\"}', '', ''),
(172, '', 'vancongduc33@gmail.com', '1', '104', '4332', '450528', '4', '0', '', '{\"tknick\":\"confds\",\"pass\":\"ss\",\"2fa\":\"\",\"dichvu\":\"nick\",\"timeup\":\"2025\\/02\\/02 07:35:54\"}', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `short_name` text NOT NULL,
  `accountNumber` text NOT NULL,
  `accountName` text NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `short_name`, `accountNumber`, `accountName`, `logo`, `token`) VALUES
(14, 'MBBANK', '20520827311', 'VAN THI NGUYEN HOA', '', 'ducapi');

-- --------------------------------------------------------

--
-- Table structure for table `bank_auto`
--

CREATE TABLE `bank_auto` (
  `id` int(11) NOT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `bank` varchar(255) CHARACTER SET cp1250 COLLATE cp1250_general_ci NOT NULL,
  `description` text DEFAULT NULL,
  `amount` int(11) DEFAULT 0,
  `received` varchar(255) DEFAULT NULL,
  `create_gettime` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `bank_auto`
--

INSERT INTO `bank_auto` (`id`, `tid`, `bank`, `description`, `amount`, `received`, `create_gettime`, `user_id`) VALUES
(87, 'FT25032710130574', 'MBBANK', 'NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897', 10000, '10000', '2025-02-01 20:20:06', 13);

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `code` varchar(32) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `loaithe` varchar(32) NOT NULL,
  `menhgia` text NOT NULL,
  `thucnhan` int(11) DEFAULT 0,
  `seri` text NOT NULL,
  `pin` text NOT NULL,
  `createdate` datetime NOT NULL,
  `status` varchar(32) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `chuyenmuc`
--

CREATE TABLE `chuyenmuc` (
  `id` int(11) NOT NULL,
  `code` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `title` text NOT NULL,
  `price` text NOT NULL,
  `buy` text NOT NULL,
  `note` text NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `chuyenmuc`
--

INSERT INTO `chuyenmuc` (`id`, `code`, `title`, `price`, `buy`, `note`, `logo`, `status`) VALUES
(12, '25RDFREEFIRE46', 'RD FREE FIRE', '10000', '0', '', 'https://i.imgur.com/Tb504Wu.jpge', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dongtien`
--

CREATE TABLE `dongtien` (
  `id` int(11) NOT NULL,
  `sotientruoc` int(11) DEFAULT NULL,
  `sotienthaydoi` int(11) DEFAULT NULL,
  `sotiensau` int(11) DEFAULT NULL,
  `thoigian` datetime DEFAULT NULL,
  `noidung` text DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_vietnamese_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `don_nap`
--

CREATE TABLE `don_nap` (
  `id` int(11) NOT NULL,
  `noidung` text NOT NULL,
  `userid` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `don_nap`
--

INSERT INTO `don_nap` (`id`, `noidung`, `userid`, `status`) VALUES
(82, '497242121', '14', 'xuly');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` text DEFAULT NULL,
  `device` text DEFAULT NULL,
  `create_date` text DEFAULT NULL,
  `action` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `ip`, `device`, `create_date`, `action`) VALUES
(1, 1, '2001:ee0:4276:66a0:452:f1cb:8fbc:e007', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/06/26 07:05:33', 'Đăng ký tài khoản thành công'),
(2, 1, '2001:ee0:4276:66a0:452:f1cb:8fbc:e007', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/06/26 07:05:38', 'Đăng nhập thành công vào hệ thống'),
(3, 2, '14.242.199.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 07:50:06', 'Đăng ký tài khoản thành công'),
(4, 2, '14.242.199.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 07:50:13', 'Đăng nhập thành công vào hệ thống'),
(5, 2, '14.242.199.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 07:54:16', 'Xóa bank khỏi hệ thống'),
(6, 2, '14.242.199.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 07:54:21', 'Xóa bank khỏi hệ thống'),
(7, 2, '2402:800:6345:bdff:c157:7bad:ae9e:13d6', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 10:44:44', 'Đăng nhập thành công vào hệ thống'),
(8, 3, '2001:ee0:4276:66a0:452:f1cb:8fbc:e007', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/06/26 15:41:27', 'Đăng ký tài khoản thành công'),
(9, 3, '2001:ee0:4276:66a0:452:f1cb:8fbc:e007', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/06/26 15:41:34', 'Đăng nhập thành công vào hệ thống'),
(10, 3, '2001:ee0:4276:66a0:452:f1cb:8fbc:e007', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/06/26 15:43:39', 'Thuê cron thành công (#5400)'),
(11, 2, '2402:800:6345:c288:940d:4476:e045:ae59', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 15:46:20', 'Đăng nhập thành công vào hệ thống'),
(12, 2, '2402:800:6345:c288:940d:4476:e045:ae59', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 15:47:38', 'Thuê cron thành công (#5400)'),
(13, 2, '2402:800:6345:c288:29af:4426:f02e:6991', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15', '2024/06/26 19:25:30', 'Đăng nhập thành công vào hệ thống'),
(14, 4, '171.251.235.214', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/02 22:39:14', 'Đăng ký tài khoản thành công'),
(15, 4, '171.251.235.214', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/02 22:39:24', 'Đăng nhập thành công vào hệ thống'),
(16, 4, '2402:800:63e0:29be:cd17:a6fd:e103:1f9a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/03 00:24:47', 'Đăng nhập thành công vào hệ thống'),
(17, 4, '2402:800:63e0:29be:cd17:a6fd:e103:1f9a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/03 01:12:53', 'Đăng nhập thành công vào hệ thống'),
(18, 4, '2402:800:63e0:29be:cd17:a6fd:e103:1f9a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/03 04:19:06', 'Đăng nhập thành công vào hệ thống'),
(19, 4, '2402:800:63e0:29be:cd17:a6fd:e103:1f9a', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/03 04:37:46', 'Đăng nhập thành công vào hệ thống'),
(20, 5, '2001:ee0:4e45:40f0:1030:ea5a:ba28:e1d3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/06 12:22:37', 'Đăng ký tài khoản thành công'),
(21, 5, '2001:ee0:4e45:40f0:1030:ea5a:ba28:e1d3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/06 12:23:02', 'Đăng nhập thành công vào hệ thống'),
(22, 6, '2402:800:63de:b651:c48f:cf0e:6e2f:2b7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/126.0.6478.153 Mobile/15E148 Safari/604.1', '2024/07/06 12:23:02', 'Đăng ký tài khoản thành công'),
(23, 6, '2402:800:63de:b651:c48f:cf0e:6e2f:2b7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/126.0.6478.153 Mobile/15E148 Safari/604.1', '2024/07/06 12:23:09', 'Đăng nhập thành công vào hệ thống'),
(24, 6, '2402:800:63de:b651:90d6:ab04:5bfe:a60c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/07/06 12:25:46', 'Đăng nhập thành công vào hệ thống'),
(25, 6, '2402:800:63de:b651:90d6:ab04:5bfe:a60c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/07/06 12:27:45', 'Đăng nhập thành công vào hệ thống'),
(26, 5, '2001:ee0:4e45:40f0:1030:ea5a:ba28:e1d3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/06 12:41:53', 'Thuê cron thành công (#4590)'),
(27, 6, '2402:800:6345:ffcc:f150:87ba:65cc:d2eb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/07/07 11:02:32', 'Đăng nhập thành công vào hệ thống'),
(28, 6, '2402:800:6345:a46a:f150:87ba:65cc:d2eb', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2024/07/07 11:52:12', 'Đăng nhập thành công vào hệ thống'),
(29, 4, '2402:800:6349:9c2f:cd65:7fe6:7f5f:cea1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2024/07/11 17:41:53', 'Đăng nhập thành công vào hệ thống'),
(30, 7, '171.250.166.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 20:41:46', 'Đăng ký tài khoản thành công'),
(31, 7, '171.250.166.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 20:42:05', 'Đăng nhập thành công vào hệ thống'),
(32, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:00:29', 'Xóa bank khỏi hệ thống'),
(33, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:15:46', 'Xóa thành viên (minhpin) Số dư còn: 0, Tổng nạp: 0'),
(34, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:15:50', 'Xóa thành viên (admin) Số dư còn: 100, Tổng nạp: 16.400'),
(35, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:15:52', 'Xóa thành viên (dichvuright) Số dư còn: 0, Tổng nạp: 0'),
(36, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:15:56', 'Xóa thành viên (khang1btre) Số dư còn: 0, Tổng nạp: 0'),
(37, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:16:04', 'Xóa thành viên (bientandatctv) Số dư còn: 15.410, Tổng nạp: 20.000'),
(38, 7, '104.28.237.72', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:17:54', 'Thuê cron thành công (#7020)'),
(39, 8, '171.251.235.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 21:37:10', 'Đăng ký tài khoản thành công'),
(40, 8, '2402:800:63e0:f284:dc15:66ce:496c:27dc, 172.71.124.111', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 22:05:22', 'Đăng nhập thành công vào hệ thống'),
(41, 8, '2402:800:63e0:f284:dc15:66ce:496c:27dc, 172.71.124.111', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 22:06:10', 'Thuê cron thành công (#6879.6)'),
(42, 7, '2402:800:634a:ab5f:5caf:7c9f:673e:3d8, 172.70.142.222', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 22:35:39', 'Đăng nhập thành công vào hệ thống'),
(43, 7, '2402:800:634a:ab5f:5caf:7c9f:673e:3d8, 172.71.82.97', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 22:48:13', 'Đăng nhập thành công vào hệ thống'),
(44, 7, '2402:800:634a:ab5f:5caf:7c9f:673e:3d8, 162.158.170.4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/14 23:20:59', 'Đăng nhập thành công vào hệ thống'),
(45, 7, '2402:800:63e1:efd:5caf:7c9f:673e:3d8, 172.69.166.28', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/15 07:13:23', 'Đăng nhập thành công vào hệ thống'),
(46, 7, '2402:800:63e1:efd:5caf:7c9f:673e:3d8, 172.68.242.98', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', '2024/09/15 07:46:52', 'Đăng nhập thành công vào hệ thống'),
(47, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 17:34:13', 'Đăng ký tài khoản thành công'),
(48, 0, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 17:44:14', 'Đăng nhập thành công vào hệ thống'),
(49, 0, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 18:40:00', 'Đăng nhập thành công vào hệ thống'),
(50, 0, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 18:42:02', 'Đăng nhập thành công vào hệ thống'),
(51, 0, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 18:43:13', 'Đăng nhập thành công vào hệ thống'),
(52, 0, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 18:45:25', 'Đăng nhập thành công vào hệ thống'),
(53, 10, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 18:45:48', 'Đăng ký tài khoản thành công'),
(54, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 18:50:33', 'Đăng nhập thành công vào hệ thống'),
(55, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 20:38:09', 'Đăng nhập thành công vào hệ thống'),
(56, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:04:11', 'thêm chuyên mục thành công (#2024)'),
(57, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:04:54', 'Xóa Mục Rate khỏi hệ thống'),
(58, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:05:01', 'thêm chuyên mục thành công (#100)'),
(59, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:05:10', 'thêm chuyên mục thành công (#102)'),
(60, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:05:28', 'thêm chuyên mục thành công (#104)'),
(61, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:05:39', 'thêm chuyên mục thành công (#105)'),
(62, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/14 22:06:00', 'thêm chuyên mục thành công (#107)'),
(63, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 07:28:15', 'Đăng nhập thành công vào hệ thống'),
(64, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 07:56:05', 'thêm chuyên mục thành công (#88)'),
(65, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 08:24:19', 'Đăng nhập thành công vào hệ thống'),
(66, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 10:50:12', 'Đăng nhập thành công vào hệ thống'),
(67, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 11:41:03', 'Đăng nhập thành công vào hệ thống'),
(68, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 15:23:47', 'Đăng nhập thành công vào hệ thống'),
(69, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 15:46:11', 'thêm chuyên mục thành công (#)'),
(70, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 16:35:35', 'Sửa Nick Có Robux thành công (#)'),
(71, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 16:36:48', 'Sửa Nick Có Robux thành công (#)'),
(72, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 16:36:53', 'Sửa Nick Có Robux thành công (#)'),
(73, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 21:30:47', 'Đăng nhập thành công vào hệ thống'),
(74, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 21:48:18', 'thêm Nick Có Robux thành công (#)'),
(75, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/15 21:48:42', 'thêm Nick Có Robux thành công (#)'),
(76, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/16 08:42:46', 'Đăng nhập thành công vào hệ thống'),
(77, 9, '14.191.247.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/16 20:28:07', 'thêm Nick Có Robux thành công (#)'),
(78, 9, '14.191.247.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/17 20:24:14', 'Hủy report thành công (#HGE9369685619)'),
(79, 9, '14.191.247.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/17 20:24:48', 'Hủy report thành công (#HGE9369685619)'),
(80, 9, '14.191.247.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/17 20:27:50', 'Hủy report thành công (#HGE9369685619)'),
(81, 9, '14.191.247.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/17 20:36:07', 'Hủy report thành công (#HGE9369685619)'),
(82, 9, '14.191.246.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/18 17:07:01', 'Đăng nhập thành công vào hệ thống'),
(83, 9, '14.191.246.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/18 19:24:32', 'Xóa bank khỏi hệ thống'),
(84, 9, '14.191.246.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/18 19:24:34', 'Xóa bank khỏi hệ thống'),
(85, 9, '14.191.246.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/18 19:28:49', 'Xóa bank khỏi hệ thống'),
(86, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/28 07:02:32', 'Đăng nhập thành công vào hệ thống'),
(87, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/28 18:29:23', 'thêm Nick Có Robux thành công (#)'),
(88, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/28 18:29:49', 'thêm Nick Có Robux thành công (#)'),
(89, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/28 18:29:59', 'thêm Nick Có Robux thành công (#)'),
(90, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/28 18:30:11', 'thêm Nick Có Robux thành công (#)'),
(91, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/28 19:34:14', 'thêm chuyên mục thành công (#RD FREE FIRE)'),
(92, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/28 20:38:33', 'thêm tài khoản thành công (#xcdsasfd|SDfsdsd)'),
(93, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/29 07:59:50', 'Thay đổi mật khẩu'),
(94, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/29 08:00:58', 'Đăng nhập thành công vào hệ thống'),
(95, 9, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/29 08:03:28', 'Đăng nhập thành công vào hệ thống'),
(96, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 21:58:37', 'Đăng ký tài khoản thành công'),
(97, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 22:12:21', 'thêm chuyên mục thành công (#232)'),
(98, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 22:16:46', 'Xóa Nick Chứa Robux khỏi hệ thống'),
(99, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:02:00', 'thêm Nick Có Robux thành công (#)'),
(100, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:02:01', 'thêm Nick Có Robux thành công (#)'),
(101, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:02:31', 'Xóa Nick Chứa Robux khỏi hệ thống'),
(102, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:02:40', 'Xóa Nick Chứa Robux khỏi hệ thống'),
(103, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:03:43', 'thêm Nick Có Robux thành công (#)'),
(104, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:07:10', 'Xóa Nick Chứa Robux khỏi hệ thống'),
(105, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:07:22', 'thêm Nick Order Robux thành công (#)'),
(106, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:09:55', 'thêm Nick Order Robux thành công (#)'),
(107, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:12:29', 'thêm Nick Order Robux thành công (#)'),
(108, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:15:07', 'thêm Nick Order Robux thành công'),
(109, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:18:38', 'thêm Nick Order Robux thành công'),
(110, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:18:50', 'thêm Nick Order Robux thành công'),
(111, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:19:12', 'thêm chuyên mục thành công (#100)'),
(112, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:20:59', 'thêm chuyên mục thành công (#99)'),
(113, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:21:25', 'thêm Nick Order Robux thành công'),
(114, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:21:37', 'thêm Nick Order Robux thành công'),
(115, 11, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '2025/01/29 23:36:40', 'Sửa Nick Có Robux thành công (#)'),
(116, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 09:38:16', 'Đăng ký tài khoản thành công'),
(117, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 11:09:23', 'Xóa Nick Order Robux khỏi hệ thống'),
(118, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 11:27:14', 'Add thông tin Nick thành công (#)'),
(119, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 11:58:09', 'thêm Nick Có Robux thành công (#)'),
(120, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 11:58:27', 'thêm Nick Order Robux thành công'),
(121, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 11:58:53', 'Gửi report thành công (#DBS3858516368)'),
(122, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 11:59:22', 'Hủy report thành công (#DBS3858516368)'),
(123, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 12:01:03', 'thêm Nick Có Robux thành công (#)'),
(124, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 12:03:23', 'Gửi report thành công (#DBS3858516368)'),
(125, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 12:03:35', 'Hủy report thành công (#DBS3858516368)'),
(126, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 12:03:50', 'Gửi report thành công (#DBS3858516368)'),
(127, 12, '115.76.54.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/01/30 12:04:03', 'Hủy report thành công (#DBS3858516368)'),
(128, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/01 15:33:38', 'Đăng ký tài khoản thành công'),
(129, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:35:36', 'thêm Nick Có Robux thành công (#)'),
(130, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:35:54', 'thêm Nick Có Robux thành công (#)'),
(131, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:36:15', 'thêm Nick Order Robux thành công'),
(132, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:36:25', 'thêm Nick Order Robux thành công'),
(133, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:37:08', 'thêm tài khoản thành công (#chuydd|kskskal)'),
(134, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:37:09', 'thêm tài khoản thành công (#lsdskd|sdjds)'),
(135, 13, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 07:37:10', 'thêm tài khoản thành công (#sdsdk|dsfds)'),
(136, 14, '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', '2025/02/02 16:25:44', 'Đăng ký tài khoản thành công');

-- --------------------------------------------------------

--
-- Table structure for table `log_balance`
--

CREATE TABLE `log_balance` (
  `id` int(11) NOT NULL,
  `money_before` text DEFAULT NULL,
  `money_change` text DEFAULT NULL,
  `money_after` text DEFAULT NULL,
  `time` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user_id` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `log_balance`
--

INSERT INTO `log_balance` (`id`, `money_before`, `money_change`, `money_after`, `time`, `content`, `user_id`) VALUES
(1, '0', '5500', '5500', '2024/06/26 07:59:38', '', '2'),
(2, '5500', '5500', '0', '2024/06/26 08:00:15', 'Thuê Cron #5500', '2'),
(3, '0', '5500', '5500', '2024/06/26 08:06:21', '', '2'),
(4, '5500', '5400', '100', '2024/06/26 10:48:12', 'Thuê Cron #5400', '2'),
(5, '10000', '5400', '4600', '2024/06/26 15:43:38', 'Thuê Cron #5400', '3'),
(6, '100', '5400', '5500', '2024/06/26 15:47:05', '', '2'),
(7, '5500', '5400', '100', '2024/06/26 15:47:38', 'Thuê Cron #5400', '2'),
(8, '0', '20000', '20000', '2024/07/06 12:38:53', 'Nạp tiền tự động qua ViettinBank (#504T24708LL8P2HF - CT DEN:504T24708LL8P2HF CRONSEVERCLOUD5 (0945543839) - 20000)', '5'),
(9, '20000', '4590', '15410', '2024/07/06 12:41:53', 'Thuê Cron #4590', '5'),
(10, '4600', '4600', '0', '2024/07/06 12:50:26', '', '3'),
(11, '0', '800', '800', '2024/09/14 21:16:38', 'Admin thay đổi số dư ', '7'),
(12, '800', '8000', '8800', '2024/09/14 21:16:53', '', '7'),
(13, '8800', '7020', '1780', '2024/09/14 21:17:53', 'Thuê Cron #7020', '7'),
(14, '0', '18000', '18000', '2024/09/14 21:51:46', 'Nạp tiền tự động qua Thesieure (#14092024214853 - lộc 8k - 18000)', '8'),
(15, '18000', '6879.6', '11120.4', '2024/09/14 22:06:09', 'Thuê Cron #6879.6', '8'),
(16, '11120', '10000', '21120', '2024/09/14 22:24:10', 'Nạp tiền tự động qua Thesieure (#14092024222029 - crondvd1s8 - 10000)', '8'),
(17, '21120', '-21120', '0', '2024/09/14 22:31:16', 'Admin thay đổi số dư ', '8'),
(18, '1780', '10000', '11780', '2024/09/14 22:31:29', 'Nạp tiền tự động qua Thesieure (#14092024223123 - crondvd1s7 - 10000)', '7'),
(19, '0', '160000', '160000', '2025/01/18 19:10:59', '', '10'),
(20, '160000', '16000', '176000', '2025/01/18 19:11:11', '', '10'),
(21, '176000', '1600000', '1776000', '2025/01/18 19:11:23', '', '10'),
(22, '1776000', '1776000', '3552000', '2025/01/18 19:11:32', '', '10'),
(23, '3552000', '1776000', '1776000', '2025/01/18 19:11:42', '', '10'),
(24, '0', '10000000', '10000000', '2025/01/30 09:39:33', '', '12'),
(25, '0', '10000', '10000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13'),
(26, '10000', '20000', '30000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032325855060 - CUSTOMER JYKE86. TU: LE NGUYEN PHUONG VY - 20000)', '13'),
(27, '30000', '2000000', '2030000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032557507006 - CUSTOMER H2XBQXAV - Ma giao dich/ Trace 9443 02 - 2000000)', '13'),
(28, '2030000', '1000000', '3030000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032152691815 - CUSTOMER N8XBQRQS - Ma giao dich/ Trace 2259 23 - 1000000)', '13'),
(29, '3030000', '1400000', '4430000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032101091898 - CUSTOMER H2XB2PZ7 - Ma giao dich/ Trace 9233 04 - 1400000)', '13'),
(30, '4430000', '100000', '4530000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032504309182 - CUSTOMER NGUYEN QUOC THAI chuyen tien. DEN: NGUYEN QUOC HUY - 100000)', '13'),
(31, '4530000', '200000', '4730000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032786025325 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 087275 - 200000)', '13'),
(32, '4730000', '316000', '5046000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032857360204 - NGUYEN QUOC THAI NGUYEN QUOC THAI chuyen tien- Ma GD  ACSP/ R2860471 - 316000)', '13'),
(33, '5046000', '4016000', '9062000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032801982094 - CUSTOMER 0972627695 921136   Ma giao dich  T race355072 Trace 355072 - 4016000)', '13'),
(34, '9062000', '1000000', '10062000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032783017400 - CUSTOMER G9XBWPA5 - Ma giao dich/ Trace 0568 33 - 1000000)', '13'),
(35, '10062000', '574000', '10636000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032460965875 - CUSTOMER G9XBWVPS - Ma giao dich/ Trace 0398 07 - 574000)', '13'),
(36, '10636000', '226000', '10862000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032907720033 - NGUYEN QUOC THAI NGUYEN QUOC THAI chuyen tien- Ma GD  ACSP/ 48247211 - 226000)', '13'),
(37, '10862000', '224000', '11086000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032176911690 - NGUYEN QUOC THAI NGUYEN QUOC THAI chuyen tien- Ma GD  ACSP/ F4264844 - 224000)', '13'),
(38, '11086000', '3024000', '14110000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032198692035 - NGUYEN HUU MINH TT CHIET KHAU P02011885560912598401 025- Ma GD ACSP/ xN963719 - 3024000)', '13'),
(39, '14110000', '300000', '14410000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032381818020 - CUSTOMER G9XB6KSW - Ma giao dich/ Trace 5345 03 - 300000)', '13'),
(40, '14410000', '220000', '14630000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032485741664 - CUSTOMER N8XB6N5Z - Ma giao dich/ Trace 8220 22 - 220000)', '13'),
(41, '14630000', '31000', '14661000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032951928970 - CTCP DICH VU DI DONG TRUC TUYEN 77992054740-QNOE85-CHUYEN TIEN-OQCH 54739813-MOMO77992054740MOMO. TU: M SERVICE JSC - 31000)', '13'),
(42, '14661000', '35000', '14696000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032094561770 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 302218 - 35000)', '13'),
(43, '14696000', '570000', '15266000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032503230760 - NGUYEN QUOC THAI NGUYEN QUOC THAI chuyen tien- Ma GD  ACSP/ FC150984 - 570000)', '13'),
(44, '15266000', '1000000', '16266000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032402595034 - CUSTOMER 0972627695 848934   Ma giao dich  T race910926 Trace 910926 - 1000000)', '13'),
(45, '16266000', '195000', '16461000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032166072354 - CUSTOMER G9XGYVVY - Ma giao dich/ Trace 2829 34 - 195000)', '13'),
(46, '16461000', '195000', '16656000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032285813550 - CUSTOMER VO HIEU THINH chuyen khoan 010225 0 2 12 48 657927   Ma giao dich  Trac e657927 Trace 657927 - 195000)', '13'),
(47, '16656000', '10000', '16666000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032346293047 - CTCP DICH VU DI DONG TRUC TUYEN 77989362252-XDBP27-CHUYEN TIEN-OQCH 54727045-MOMO77989362252MOMO. TU: M SERVICE JSC - 10000)', '13'),
(48, '16666000', '19000', '16685000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032286834742 - CUSTOMER MUKR41. TU: BUI TUAN DAT - 19000)', '13'),
(49, '16685000', '20000', '16705000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032202126274 - CUSTOMER CJRW81. TU: BUI TUAN DAT - 20000)', '13'),
(50, '16705000', '46000', '16751000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25032251187340 - NGUYEN HOAI KHIEM MB 0972627695 EBQY50- Ma GD ACSP/ L G095841 - 46000)', '13'),
(51, '16751000', '10000', '16761000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25031689001442 - CUSTOMER UZEA93. TU: LE NGUYEN PHUONG VY - 10000)', '13'),
(52, '16761000', '16000', '16777000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25031376144232 - CUSTOMER cskh0962311311 tsr 12229501 - Ma gi ao dich/ Trace 509529 - 16000)', '13'),
(53, '16777000', '10000', '16787000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030630979205 - CUSTOMER loc. TU: NGUYEN HOANG TIEN - 10000)', '13'),
(54, '16787000', '20000', '16807000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030448000616 - CUSTOMER TQRE06. TU: DUONG MINH LUAN - 20000)', '13'),
(55, '16807000', '200000', '17007000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030861089439 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 174433 - 200000)', '13'),
(56, '17007000', '200000', '17207000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030210920530 - LE QUOC HUY MBVCB.8410842961.335935.LE QUOC HUY  chuyen tien.CT tu 1051814873 LE QU OC HUY toi 0972627695 NGUYEN QUOC T HAI tai MB- Ma GD ACSP/ br335935 - 200000)', '13'),
(57, '17207000', '100000', '17307000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030940450839 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 569305 - 100000)', '13'),
(58, '17307000', '10000', '17317000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030285064832 - CUSTOMER SLRK54. TU: NGUYEN QUOC KHANH - 10000)', '13'),
(59, '17317000', '30000', '17347000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030174570476 - CUSTOMER TIUF31. TU: NGUYEN QUOC KHANH - 30000)', '13'),
(60, '17347000', '50000', '17397000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030676900055 - CUSTOMER NAP948077. DEN: NGUYEN HONG BAO THIEN - 50000)', '13'),
(61, '17397000', '50000', '17447000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030150779339 - CUSTOMER PHAM TRUNG DUNG chuyen tien. TU: PHAM TRUNG DUNG - 50000)', '13'),
(62, '17447000', '28000', '17475000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030260110045 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 909514 - 28000)', '13'),
(63, '17475000', '20000', '17495000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030346629110 - CUSTOMER PMQL26. TU: NGUYEN DUC MANH - 20000)', '13'),
(64, '17495000', '10000', '17505000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030507876610 - ZION ZALOPAY-CHUYENTIEN-O5CH792TU0F8-VYR C10. TU: ZION - 10000)', '13'),
(65, '17505000', '4000', '17509000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030387712503 - CUSTOMER NGUYEN QUOC THAI chuyen tien. DEN: NGUYEN QUOC HUY - 4000)', '13'),
(66, '17509000', '36000', '17545000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030234090330 - CUSTOMER PASK35. TU: DUONG NGHIA HUYNH - 36000)', '13'),
(67, '17545000', '506000', '18051000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030963002012 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 205024 - 506000)', '13'),
(68, '18051000', '520000', '18571000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030629844000 - LAM QUOC THAI CPAS15- Ma GD ACSP/ 1L940827 - 520000)', '13'),
(69, '18571000', '391000', '18962000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25030234837055 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 721885 - 391000)', '13'),
(70, '18962000', '200000', '19162000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027979349902 - CTCP DICH VU DI DONG TRUC TUYEN 77738340758-BREC03-CHUYEN TIEN-OQCH 53673709-MOMO77738340758MOMO. TU: M SERVICE JSC - 200000)', '13'),
(71, '19162000', '12000', '19174000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027276003461 - CUSTOMER GCXP39. TU: LE NGUYEN PHUONG VY - 12000)', '13'),
(72, '19174000', '50000', '19224000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027287812111 - CUSTOMER CBHN02. TU: BUI TUAN DAT - 50000)', '13'),
(73, '19224000', '10000', '19234000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027113748749 - CUSTOMER QWDA34. TU: LE NGUYEN PHUONG VY - 10000)', '13'),
(74, '19234000', '30000', '19264000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027062078421 - CUSTOMER BKMF09. TU: DUONG NGHIA HUYNH - 30000)', '13'),
(75, '19264000', '15000', '19279000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027177765368 - CUSTOMER XJHE54. TU: DUONG NGHIA HUYNH - 15000)', '13'),
(76, '19279000', '10000', '19289000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027928753051 - CTCP DICH VU DI DONG TRUC TUYEN 77710819300-ZULQ89-CHUYEN TIEN-OQCH 53530511-MOMO77710819300MOMO. TU: M SERVICE JSC - 10000)', '13'),
(77, '19289000', '10000', '19299000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027485181310 - CUSTOMER KHOT54. TU: DUONG MINH LUAN - 10000)', '13'),
(78, '19299000', '20000', '19319000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027060808102 - CTCP DICH VU DI DONG TRUC TUYEN 77702547577-PXOD86-CHUYEN TIEN-OQCH 53495770-MOMO77702547577MOMO. TU: M SERVICE JSC - 20000)', '13'),
(79, '19319000', '14000', '19333000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027997834069 - CUSTOMER DUIH83. TU: NGUYEN VAN DAT - 14000)', '13'),
(80, '19333000', '10000', '19343000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027995752585 - CUSTOMER LEPO38. TU: PHAM THI HANG - 10000)', '13'),
(81, '19343000', '10000', '19353000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027505866880 - CUSTOMER SKCB68. TU: PHAM THI HANG - 10000)', '13'),
(82, '19353000', '10000', '19363000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027416487882 - CUSTOMER RUXZ60. TU: DUONG NGHIA HUYNH - 10000)', '13'),
(83, '19363000', '320000', '19683000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027733112249 - CUSTOMER NGUYEN QUOC THAI chuyen tien - Ma g iao dich/ Trace 850795 - 320000)', '13'),
(84, '19683000', '10000', '19693000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027447739799 - CTCP DICH VU DI DONG TRUC TUYEN 77679837456-JMNQ20-CHUYEN TIEN-OQCH 53412639-MOMO77679837456MOMO. TU: M SERVICE JSC - 10000)', '13'),
(85, '19693000', '13000', '19706000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027703263044 - CUSTOMER UKXJ91. TU: DAO MINH HOANG - 13000)', '13'),
(86, '19706000', '10000', '19716000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027469506813 - CUSTOMER BRXF87. TU: DAO MINH HOANG - 10000)', '13'),
(87, '19716000', '10000', '19726000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027800028221 - CUSTOMER BLJH65. TU: DAO MINH HOANG - 10000)', '13'),
(88, '19726000', '140000', '19866000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027205099356 - NGUYEN THI TRANG QR   BXYO67- Ma GD ACSP/ 4f133094 - 140000)', '13'),
(89, '19866000', '10000', '19876000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027629757350 - CUSTOMER WERC42. TU: NGUYEN VIET ANH - 10000)', '13'),
(90, '19876000', '60000', '19936000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027363563882 - NGUYEN THI TRANG QR   CLZD28- Ma GD ACSP/ HJ908756 - 60000)', '13'),
(91, '19936000', '10000', '19946000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027712389504 - CUSTOMER CFRI62. TU: VU TRI HOANG LONG - 10000)', '13'),
(92, '19946000', '17000', '19963000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027287023187 - CUSTOMER WAUN05. TU: NGUYEN DUY HUNG - 17000)', '13'),
(93, '19963000', '13000', '19976000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027066977803 - CUSTOMER MUBT79. TU: NGUYEN DUY HUNG - 13000)', '13'),
(94, '19976000', '139000', '20115000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027202837960 - CUSTOMER SP250126602168 - Ma giao dich/ Trac e 683629 - 139000)', '13'),
(95, '20115000', '20000', '20135000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027864203938 - CUSTOMER HYZM18. TU: NGUYEN DUY HOANG BACH - 20000)', '13'),
(96, '20135000', '15000', '20150000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027908210984 - CUSTOMER OXIF20. TU: NGUYEN NGOC HUY - 15000)', '13'),
(97, '20150000', '220000', '20370000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027270227436 - NGUYEN QUOC THAI NGUYEN QUOC THAI chuyen tien- Ma GD  ACSP/ 9Z194271 - 220000)', '13'),
(98, '20370000', '130000', '20500000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027765106856 - CUSTOMER VO HIEU THINH chuyen khoan 260125 1 6 16 46 949132   Ma giao dich  Trac e949132 Trace 949132 - 130000)', '13'),
(99, '20500000', '44000', '20544000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027800640245 - CTCP DICH VU DI DONG TRUC TUYEN 77647779294-IWOT82-CHUYEN TIEN-OQCH 53234719-MOMO77647779294MOMO. TU: M SERVICE JSC - 44000)', '13'),
(100, '20544000', '20000', '20564000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027901853825 - CUSTOMER BTRN13. TU: TRAN VAN PHONG - 20000)', '13'),
(101, '20564000', '10000', '20574000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027020516691 - ZION ZALOPAY-CHUYENTIEN-O5CH792AOUN4-XFZ V21. TU: ZION - 10000)', '13'),
(102, '20574000', '15000', '20589000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027450490906 - CUSTOMER KVSJ75. TU: TRAN VAN PHONG - 15000)', '13'),
(103, '20589000', '12000', '20601000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027750088380 - CUSTOMER YLMX01. TU: VU NGUYEN THANH NHAN - 12000)', '13'),
(104, '20601000', '10000', '20611000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027179345005 - ZION ZALOPAY-CHUYENTIEN-O5CH792AMFLC-ZXL T97. TU: ZION - 10000)', '13'),
(105, '20611000', '10000', '20621000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027236570101 - CUSTOMER WVNJ31. TU: NGUYEN DUC HIEU - 10000)', '13'),
(106, '20621000', '10000', '20631000', '2025/02/01 19:17:25', 'Nạp tiền tự động qua MBBANK (#FT25027850631123 - CUSTOMER RWGC19. TU: NGUYEN HOANG TIEN - 10000)', '13'),
(107, '20631000', '10000', '20641000', '2025/02/01 20:20:06', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13'),
(108, '20641000', '10000', '20651000', '2025/02/01 20:35:35', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13'),
(109, '20651000', '10000', '20661000', '2025/02/01 20:37:34', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13'),
(110, '20661000', '10000', '20671000', '2025/02/01 20:38:39', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13'),
(111, '20671000', '10000', '20681000', '2025/02/01 20:39:10', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13'),
(112, '20681000', '10000', '20691000', '2025/02/01 20:40:06', 'Nạp tiền tự động qua MBBANK (#FT25032710130574 - NGUYEN THI HOANG YEN TGIOIDEV 634837339- Ma GD ACSP/ pY6 19897 - 10000)', '13');

-- --------------------------------------------------------

--
-- Table structure for table `mucrate`
--

CREATE TABLE `mucrate` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mucrate`
--

INSERT INTO `mucrate` (`id`, `code`, `status`) VALUES
(13, '100', '1'),
(14, '102', '1'),
(15, '104', '1'),
(16, '105', '1'),
(17, '107', '1'),
(18, '88', '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `magd` varchar(32) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `soluong` int(11) DEFAULT 0,
  `money` int(11) DEFAULT 0,
  `username` varchar(32) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `live` int(11) DEFAULT 0,
  `type` varchar(64) DEFAULT NULL,
  `display` varchar(32) DEFAULT 'show'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `magd`, `title`, `soluong`, `money`, `username`, `createdate`, `live`, `type`, `display`) VALUES
(19, 'WQK4389212180', 'RD FREE FIRE', 10000, 20000, 'vancongduc33@gmail.com', '2025-01-29 07:04:35', 0, '12', '1'),
(20, 'CWC6645241460', 'RD FREE FIRE', 10000, 20000, 'vancongduc33@gmail.com', '2025-01-29 07:04:50', 0, '12', '1'),
(21, 'PAO1588179481', 'RD FREE FIRE', 10000, 10000, 'vancongduc33@gmail.com', '2025-02-01 21:15:37', 0, '12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_nick`
--

CREATE TABLE `product_nick` (
  `id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `chuyenmuc` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `magd` varchar(32) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `note` text CHARACTER SET utf8mb3 COLLATE utf8mb3_vietnamese_ci NOT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'live',
  `seller` text CHARACTER SET utf32 COLLATE utf32_vietnamese_ci DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `product_nick`
--

INSERT INTO `product_nick` (`id`, `code`, `chuyenmuc`, `magd`, `username`, `note`, `createdate`, `status`, `seller`, `updated_time`) VALUES
(41, '25RDFREEFIRE46', '12', 'BXQ7765718457', 'vancongduc33@gmail.com', 'xcsfd|SDfsd\r', NULL, 'offline', NULL, '2025-01-29 07:01:44'),
(42, '25RDFREEFIRE46', '12', 'BXQ7765718457', 'vancongduc33@gmail.com', 'xcdsasfd|SDfsds', NULL, 'offline', NULL, '2025-01-29 07:01:44'),
(43, '25RDFREEFIRE46', '12', 'CTJ9978249824', 'vancongduc33@gmail.com', 'xcdsasfd|SDfsdsd', NULL, 'offline', NULL, '2025-01-29 06:58:55'),
(44, '25RDFREEFIRE46', '12', 'CTJ9978249824', 'vancongduc33@gmail.com', 'xcsewfd|SDfsd\r\n', NULL, 'offline', NULL, '2025-01-29 06:58:55'),
(45, '25RDFREEFIRE46', '12', 'CTJ9978249824', 'vancongduc33@gmail.com', 'xcdsasfd|SDfsdsaes', NULL, 'offline', NULL, '2025-01-29 06:58:55'),
(46, '25RDFREEFIRE46', '12', 'CTJ9978249824', 'vancongduc33@gmail.com', 'xcdsasếfd|SDfsdsd', NULL, 'offline', NULL, '2025-01-29 06:58:55'),
(47, '25RDFREEFIRE46', '12', 'YYR6565434702', 'vancongduc33@gmail.com', 'xcsdsfd|SDfsdd\r\n', NULL, 'offline', NULL, '2025-01-29 07:02:06'),
(48, '25RDFREEFIRE46', '12', 'GEJ5600993799', 'vancongduc33@gmail.com', 'sxcdsasfd|SDdfsds', NULL, 'offline', NULL, '2025-01-29 07:03:48'),
(49, '25RDFREEFIRE46', '12', 'WQK4389212180', 'vancongduc33@gmail.com', 'xcsdsafd|SDfsdd\r\n', NULL, 'offline', NULL, '2025-01-29 07:04:35'),
(50, '25RDFREEFIRE46', '12', 'PAO1588179481', 'vancongduc33@gmail.com', 'sxcdsassasd|SDdfsds', NULL, 'offline', NULL, '2025-02-01 21:15:37'),
(51, '25RDFREEFIRE46', '12', 'CWC6645241460', 'vancongduc33@gmail.com', 'sxcdsassfd|SDdfsdss', NULL, 'offline', NULL, '2025-01-29 07:04:50'),
(52, '25RDFREEFIRE46', '12', 'CWC6645241460', 'vancongduc33@gmail.com', 'xcsdefsafd|SDfsdd\r\n', NULL, 'offline', NULL, '2025-01-29 07:04:50'),
(53, '25RDFREEFIRE46', '12', 'WQK4389212180', 'vancongduc33@gmail.com', 'sxcdsassasd|SDdfsewds', NULL, 'offline', NULL, '2025-01-29 07:04:35'),
(54, '25RDFREEFIRE46', '12', NULL, NULL, 'chuydd|kskskal', NULL, 'live', 'văn đức', NULL),
(55, '25RDFREEFIRE46', '12', NULL, NULL, 'lsdskd|sdjds', NULL, 'live', 'văn đức', NULL),
(56, '25RDFREEFIRE46', '12', NULL, NULL, 'sdsdk|dsfds', NULL, 'live', 'văn đức', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rateorder`
--

CREATE TABLE `rateorder` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `rateorder`
--

INSERT INTO `rateorder` (`id`, `code`, `status`) VALUES
(17, '107', '1'),
(19, '232', '0'),
(20, '100', '1'),
(21, '99', '1');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'status_send_mail', '0'),
(2, 'title', 'thegioidev'),
(3, 'description', 'thegioidev'),
(4, 'keywords', 'thegioidev'),
(5, 'author', 'ducapi'),
(6, 'status_noti', '1'),
(7, 'status_update', '1'),
(8, 'hotline', '0123'),
(9, 'email', 'thegioidev@gmail.com'),
(10, 'email_smtp', 'tgdev@gmail.com'),
(11, 'pass_email_smtp', 'nvjbgzwelpwew'),
(12, 'session_login', '180000'),
(13, 'min_recharge', '1000'),
(14, 'time_delete_invoices', '2592000'),
(15, 'notification', 'PHA+Jm5ic3A7ICZuYnNwO1RoZWdpb2lkZXYgeGluIGfhu61pIMSR4bq/biBxdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBoJmFncmF2ZTtuZyBuaOG7r25nIGzhu51pIGNoJnVhY3V0ZTtjIHThu5F0IMSR4bq5cCBuaOG6pXQuIE1vbmcgcuG6sW5nIG7Eg20gbeG7m2kgc+G6vSBtYW5nIGzhuqFpIGNobyBxdSZ5YWN1dGU7IGtoJmFhY3V0ZTtjaCBuaGnhu4F1IG5p4buBbSB2dWksIHRoJmFncmF2ZTtuaCBjJm9jaXJjO25nIHYmYWdyYXZlOyBtYXkgbeG6r24uPC9wPg0K'),
(16, 'notications', ''),
(24, 'time_test_api', '86400'),
(25, 'noidungnap', 'tgioidev'),
(26, 'link_facebook', 'https://www.facebook.com/vanducdesignn'),
(27, 'link_zalo', 'https://zalo.me/0849270311'),
(28, 'logo', 'https://i.imgur.com/8EKwDve.png'),
(29, 'anhbia', 'https://i.imgur.com/8EKwDve.png'),
(30, 'favicon', 'https://i.imgur.com/1rbZ1Ic.png'),
(31, 'token_telegram', '7461772349:AAHuB-qiaAUX-iDpgjDYO0VfajsJYYoZvC8'),
(32, 'chat_id_telegram', ''),
(48, 'api_card', 'z3skgqfmt146iunhyc7ajw2lbodxre8v9p5'),
(49, 'ck_card', '20'),
(50, 'max_time_buy', '60'),
(57, 'baohanh', 'PHA+PHN0cm9uZz5DSOG6viDEkOG7mCBC4bqiTyBIJkFncmF2ZTtOSDwvc3Ryb25nPjxiciAvPg0KxJDhu4MgxJHhuqNtIGLhuqNvIHF1eeG7gW4gbOG7o2kgY2hvIMSRxqFuIHbhu4sgYiZhYWN1dGU7biBoJmFncmF2ZTtuZyB2JmFncmF2ZTsgbmfGsOG7nWkgdGkmZWNpcmM7dSBkJnVncmF2ZTtuZywgc2F1IGtoaSBtdWEgaCZhZ3JhdmU7bmcgaCZhdGlsZGU7eSBz4butIGThu6VuZyBuaGFuaCBuaOG6pXQgxJHhu4MgdHImYWFjdXRlO25oIGThu6dpIGRvIGLhu4sgYmFuZCBhY2M8YnIgLz4NCkNoJmlhY3V0ZTtuaCBzJmFhY3V0ZTtjaCBi4bqjbyBoJmFncmF2ZTtuaCBNaW4gJnF1b3Q7NCBQaCZ1YWN1dGU7dCZxdW90OyAoIGLhuqNvIGgmYWdyYXZlO25oIDEwMCUgZ2kmYWFjdXRlOyB0cuG7iyBhY2MgbuG6v3UgZGllIC0gVHJvbmcgdHLGsOG7nW5nIGjhu6NwIMSRJmF0aWxkZTsgeOG6oyDEkcaw4bujYyBiYW8gbmhpJmVjaXJjO3Ugcm9idXggdnVpIGwmb2dyYXZlO25nIGN1bmcgY+G6pXAgdGgmb2NpcmM7bmcgdGluIHThuqFpIG3hu6VjIGtoaeG6v3UgbuG6oWkgZGllPGJyIC8+DQo8YnIgLz4NCjxzdHJvbmc+VOG7qiBDSOG7kEkgQuG6ok8gSCZBZ3JhdmU7TkggVuG7mkkgVFLGr+G7nE5HIEjhu6JQIFNBVTwvc3Ryb25nPjxiciAvPg0KTXVhIGFjYyBraCZvY2lyYztuZyB04buxIMSR4buVaSBt4bqtdCBraOG6qXUsIGImYWFjdXRlO28gc2FpIHBhc3Mga2gmb2NpcmM7bmcgYuG6o28gaCZhZ3JhdmU7bmg8YnIgLz4NCktoaSBi4buLIGjhu6d5IGtoaeG6v3UgbuG6oWksIGhv4bq3YyBraGnhur91IG7huqFpIMSRJmF0aWxkZTsgxJHGsOG7o2Mgc+G7rSBsJnlhY3V0ZTsgbmjGsG5nIHbhuqtuIGfhurdwIGzhu5dpIHZ1aSBsJm9ncmF2ZTtuZyBiJmFhY3V0ZTtvIGzhuqFpIEFETUlOIMSR4buDIHPhu60gbCZ5YWN1dGU7LiZuYnNwOzxiciAvPg0KVOG7qyBjaOG7kWkgYuG6o28gaCZhZ3JhdmU7bmggduG7m2kgdOG6pXQgY+G6oyBjJmFhY3V0ZTtjIGwmeWFjdXRlOyBkbywgaG/hurdjIGtoJm9jaXJjO25nIHPhu60gZOG7pW5nIG4mdWFjdXRlO3Qga2hp4bq/dSBu4bqhaSDEkSZ1YWN1dGU7bmcgYyZhYWN1dGU7Y2g8YnIgLz4NCkPhu5EgdCZpZ3JhdmU7bmggxJHhu5VpIHBhc3MgYiZhYWN1dGU7byBs4buXaSwgY2gmdWFjdXRlO25nIHQmb2NpcmM7aSBraCZvYWN1dGU7YSB1c2VyIHYmYWdyYXZlOyBnaWFtIHRp4buBbiB0ciZlY2lyYztuIHNob3AgdsSpbmggdmnhu4VuLjwvcD4NCg=='),
(58, 'sudungbot', 'PHA+SMaw4bubbmcgZOG6q24gc+G7rSBk4bulbmcgYm90PGJyIC8+DQpDbGljayBraOG7n2kgxJEmb2NpcmM7bmcgYiZvYWN1dGU7dCBt4buXaSAxIGtoJmFhY3V0ZTtjaCBoJmFncmF2ZTtuZyDEkeG7gXUgYyZvYWN1dGU7IG0mYXRpbGRlOyBz4buRIHJpJmVjaXJjO25nPGJyIC8+DQpWJmlhY3V0ZTsgZOG7pSAvbWEgMzU3MjM8YnIgLz4NCkJvdCBjJm9hY3V0ZTsgY2jhu6ljIG7Eg25nJm5ic3A7PGJyIC8+DQpUaCZvY2lyYztuZyBiJmFhY3V0ZTtvIG11YSBoJmFncmF2ZTtuZyB0aCZhZ3JhdmU7bmggYyZvY2lyYztuZyZuYnNwOzxiciAvPg0KVGgmb2NpcmM7bmcgYiZhYWN1dGU7byBraGnhur91IHRy4bqhbmcgdGgmYWFjdXRlO2kga2hp4bq/dSBu4bqhaSBraGkgaG8mYWdyYXZlO24gdGgmYWdyYXZlO25oPC9wPg0KDQo8cD4mbmJzcDs8L3A+DQoNCjxwPjxhIGhyZWY9Imh0dHBzOi8vYXBwLnZuc2dzbS5jb20vc3RvcmFnZS9nNVhMT2JVTkpiRWU2OU8wNlcySTFCZkY1QVVLTWJnMEJudFhTZDNRLmpwZyI+PGltZyBzcmM9Imh0dHBzOi8vYXBwLnZuc2dzbS5jb20vc3RvcmFnZS9nNVhMT2JVTkpiRWU2OU8wNlcySTFCZkY1QVVLTWJnMEJudFhTZDNRLmpwZyIgc3R5bGU9ImhlaWdodDo0NzJweDsgd2lkdGg6MzUycHgiIC8+PC9hPjwvcD4NCg0KPHA+PGEgaHJlZj0iaHR0cHM6Ly9hcHAudm5zZ3NtLmNvbS9zdG9yYWdlL2c1WExPYlVOSmJFZTY5TzA2VzJJMUJmRjVBVUtNYmcwQm50WFNkM1EuanBnIj5ib3Nzcy5qcGcgMjUuODYgS0I8L2E+PC9wPg0KDQo8cD4mbmJzcDs8L3A+DQoNCjxwPiZsdDs8L3A+DQo='),
(59, 'report', 'PHA+PHN0cm9uZz5IxrDhu5tuZyBk4bqrbiBz4butIGThu6VuZyBuJnVhY3V0ZTt0IGtoaeG6v3UgbuG6oWk8L3N0cm9uZz48YnIgLz4NCk4mdWFjdXRlO3QgbiZhZ3JhdmU7eSBob+G6oXQgxJHhu5luZyB0cm9uZyAxMCBwaCZ1YWN1dGU7dCwgaOG6v3QgMTAgcGgmdWFjdXRlO3Qgc+G6vSBi4buLIG3huqV0PGJyIC8+DQpNdWEgaCZhZ3JhdmU7bmcgdnVpIGwmb2dyYXZlO25nIGtp4buDbSB0cmEsIGfhurdwIGzhu5dpIGgmYXRpbGRlO3kg4bqlbiBraGnhur91IG7huqFpIHYmYWdyYXZlOyBsJmFncmF2ZTttIHRoZW8gaMaw4bubbmcgZOG6q24gxJEmYXRpbGRlOyBnaGkgc+G6tW4sIHJlcG9zdCBzYWkgc+G6vSBraCZvY2lyYztuZyDEkcaw4bujYyBo4buXIHRy4bujPGJyIC8+DQpLaCZvY2lyYztuZyBz4butIGThu6VuZyBuJnVhY3V0ZTt0IG4mYWdyYXZlO3kgxJEmdWFjdXRlO25nIGMmYWFjdXRlO2NoIG3huqV0IHF1eeG7gW4ga2hp4bq/dSBu4bqhaSBz4bq9IGtoJm9jaXJjO25nIMSRxrDhu6NjIG5nxrDhu51pIGImYWFjdXRlO24gYuG6o28gaCZhZ3JhdmU7bmg8YnIgLz4NClThuqV0IGPhuqMga2gmYWFjdXRlO2NoIGgmYWdyYXZlO25nIG11YSBhY2MgdnVpIGwmb2dyYXZlO25nIGtp4buDbSB0cmEga+G7uSB0aCZvY2lyYztuZyB0aW4gdCZhZ3JhdmU7aSBraG/huqNuIG3huq10IGto4bqpdSB0cm9uZyB2Jm9ncmF2ZTtuZyA1IHBoJnVhY3V0ZTt0IGLhuqNvIGgmYWdyYXZlO25oPGJyIC8+DQpD4bqjbmggYiZhYWN1dGU7bzogTuG6v3UgdCZhZ3JhdmU7aSBraG/huqNuIHNhaSBraCZvY2lyYztuZyBz4butIGThu6VuZyBuJnVhY3V0ZTt0IGtoaeG6v3UgbuG6oWkgY2gmdWFjdXRlO25nIHQmb2NpcmM7aSB04burIGNo4buRaSBnaeG6o2kgcXV54bq/dCAoIG4mdWFjdXRlO3Qga2hp4bq/dSBu4bqhaSBt4bulYyDEkSZpYWN1dGU7Y2ggZ2lhbSB0aeG7gW4gbmfGsOG7nWkgYiZhYWN1dGU7biBoJmFncmF2ZTtuZywgdiZpZ3JhdmU7IHbhuq15IGtoJmFhY3V0ZTtjaCBoJmFncmF2ZTtuZyB2dWkgbCZvZ3JhdmU7bmcga2hp4bq/dSBu4bqhaSBraGkgZ+G6t3Agc+G7sSBj4buRICk8L3A+DQo='),
(60, '2falog', 'PHA+PHN0cm9uZz5IxrDhu5tuZyBk4bqrbiBz4butIGThu6VuZyAyZmEgYXV0aGU8L3N0cm9uZz48YnIgLz4NCuKAi1Ryb25nIHBo4bqnbiBs4buLY2ggc+G7rSBtdWEgaCZhZ3JhdmU7bmcsIGgmYXRpbGRlO3kgc2FvIGNoJmVhY3V0ZTtwIGNodeG7l2kgeCZhYWN1dGU7YyB0aOG7sWMgMmZhIHYmaWFjdXRlOyBk4bulIENEUlM3VVRGMkJOVVJGREFENEZJWlZQSkFFIG5oxrAgbSZvY2lyYzsgdOG6oyB0cm9uZyBoJmlncmF2ZTtuaCwgbuG6v3UgYuG6pXQga+G7syB0JmFncmF2ZTtpIGtob+G6o24gbiZhZ3JhdmU7byBjJm9hY3V0ZTsgY2h14buXaSBz4buRIG4mYWdyYXZlO3k8YnIgLz4NClNhdSDEkSZvYWN1dGU7LCBoJmF0aWxkZTt5IHRydXkgY+G6rXAgaHR0cHM6Ly8yZmEubGl2ZS88YnIgLz4NCm5o4bqlbiBuJnVhY3V0ZTt0IGfhu61pLCBzYW8gY2gmZWFjdXRlO3AgY2h14buXaSBtJmF0aWxkZTsgZ+G7k20gNiBjaOG7ryBz4buRIHYmYWdyYXZlOyBkJmFhY3V0ZTtuIHYmYWdyYXZlO28gcGjhuqduIMSRxINuZyBuaOG6rXAgY+G7p2EgdCZhZ3JhdmU7aSBraG/huqNuIHJvYmxveCDEkeG7gyDEkcSDbmcgbmjhuq1wPC9wPg0KDQo8cD4mbmJzcDs8L3A+DQoNCjxwPjxhIGhyZWY9Imh0dHBzOi8vYXBwLnZuc2dzbS5jb20vc3RvcmFnZS9vVFA4WnY2SUtCeTB1bDAxS25hQlNtVWpUdmp0MWl3aG0xYU5URlJzLmpwZyI+PGltZyBzcmM9Imh0dHBzOi8vYXBwLnZuc2dzbS5jb20vc3RvcmFnZS9vVFA4WnY2SUtCeTB1bDAxS25hQlNtVWpUdmp0MWl3aG0xYU5URlJzLmpwZyIgc3R5bGU9ImhlaWdodDo2NTZweDsgd2lkdGg6MTM1OHB4IiAvPjwvYT48L3A+DQoNCjxwPjxhIGhyZWY9Imh0dHBzOi8vYXBwLnZuc2dzbS5jb20vc3RvcmFnZS9vVFA4WnY2SUtCeTB1bDAxS25hQlNtVWpUdmp0MWl3aG0xYU5URlJzLmpwZyI+OTk5OS5qcGcgODIuOTIgS0I8L2E+PC9wPg0KDQo8cD4mbmJzcDs8L3A+DQo='),
(61, 'token_bot_tele', '7130251599:AAESiPSUP1f-yau7hdw4_I3L7GH5MKr2YZ8'),
(62, 'link_bot_tele', 'https://t.me/viptongadminBot'),
(63, 'noti_telegram', 'hot hot 50% sale'),
(64, 'key_ban_quyen', '4680696c0ae5f30626f925fe4394b28d');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `lydo` text NOT NULL,
  `nickrb` text NOT NULL,
  `dichvu` text NOT NULL,
  `time` text NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `type`, `lydo`, `nickrb`, `dichvu`, `time`, `status`) VALUES
(17, '12e9ed15-6b63-45ef-8723-4aed40e84723', '6t', '169', 'nick', '2025/01/30 12:03:50', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `level` int(11) NOT NULL,
  `token` text DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `device` text DEFAULT NULL,
  `otp` text DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT 0,
  `total_money` int(11) NOT NULL DEFAULT 0,
  `ck_user` int(11) NOT NULL DEFAULT 0,
  `banned` int(11) NOT NULL DEFAULT 0,
  `time_request` int(11) NOT NULL DEFAULT 0,
  `create_date` text DEFAULT NULL,
  `update_date` text DEFAULT NULL,
  `time_session` text DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `bank` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `level`, `token`, `ip`, `device`, `otp`, `money`, `total_money`, `ck_user`, `banned`, `time_request`, `create_date`, `update_date`, `time_session`, `telegram`, `bank`) VALUES
(13, 'văn đức', 'd91ea1cc869f9d1dd213150dc476c6bd0774ed20', 'vancongduc33@gmail.com', 1, '1ff69424727f4dc7c938413d3a192cae', '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, 20677600, 20691000, 0, 0, 0, '2025/02/01 15:33:38', '1738398818', '1738488014', '6970654797', ''),
(14, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'thegioidev@gmail.com', 1, '556bda0f31c778ea2bbc83e0c8ae9611', '14.191.246.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, 0, 0, 0, 0, 0, '2025/02/02 16:25:44', '1738488344', '1738489936', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountorder`
--
ALTER TABLE `accountorder`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `accountrb`
--
ALTER TABLE `accountrb`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `bank_auto`
--
ALTER TABLE `bank_auto`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `chuyenmuc`
--
ALTER TABLE `chuyenmuc`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `dongtien`
--
ALTER TABLE `dongtien`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `don_nap`
--
ALTER TABLE `don_nap`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_balance`
--
ALTER TABLE `log_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mucrate`
--
ALTER TABLE `mucrate`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `product_nick`
--
ALTER TABLE `product_nick`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rateorder`
--
ALTER TABLE `rateorder`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountorder`
--
ALTER TABLE `accountorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `accountrb`
--
ALTER TABLE `accountrb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bank_auto`
--
ALTER TABLE `bank_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chuyenmuc`
--
ALTER TABLE `chuyenmuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dongtien`
--
ALTER TABLE `dongtien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `don_nap`
--
ALTER TABLE `don_nap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `log_balance`
--
ALTER TABLE `log_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `mucrate`
--
ALTER TABLE `mucrate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_nick`
--
ALTER TABLE `product_nick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `rateorder`
--
ALTER TABLE `rateorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
