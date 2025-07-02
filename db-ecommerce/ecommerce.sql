-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 11:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `building` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `floor` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `flat` varchar(1000) NOT NULL,
  `notes` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `regions_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `address`, `street`, `building`, `floor`, `flat`, `notes`, `user_id`, `regions_id`, `created_at`, `updated_at`) VALUES
(4, '', '0', 'alex hello', '122', '5', '', 8, 2, '2023-01-06 19:47:15', '2023-05-20 17:22:59'),
(5, 'fefeff', '3', '34', '2', '3', 'eeeee', 14, 5, '2023-01-06 19:47:15', '2023-05-29 21:59:26'),
(6, '', '1', 'giza hello world', '578', '88', 'sfdgsg', 55, 7, '2023-01-06 19:47:15', '2023-01-06 19:47:15'),
(7, '', '1', 'hello world', '44', '3', 'dfdf', 4, 1, '2023-01-06 20:05:41', '2023-01-06 20:05:41'),
(49, '61 youssef ghaly street 3rd floor flat no.5', '61 youssef ghaly street 3rd floor flat no.5', '61', '33', '444', 'NULL', 56, 1, '2023-06-21 23:04:09', '2023-06-21 23:04:09'),
(50, '61 youssef ghaly street 3rd floor flat no.5', '61 youssef ghaly street 3rd floor flat no.5', '61', '3rd', '5ith', 'kosom masr', 61, 1, '2023-12-16 21:57:52', '2023-12-16 21:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 => active , 0 => not active ',
  `image` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name_en`, `name_ar`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'samsung', 'samsung', 1, 'dufalt.jpg', '2022-11-21 22:20:38', '2022-12-23 12:20:15'),
(2, 'bmw', 'bmw', 1, 'dufalt.jpg', '2022-11-22 18:03:15', '2022-12-23 12:20:23'),
(3, 'mercedes', 'mercedes', 1, 'dufalt.jpg', '2022-11-22 18:03:15', '2022-12-23 12:20:24'),
(4, 'apple', 'apple', 1, 'dufalt.jpg', '2022-12-22 00:18:36', '2022-12-23 12:20:25'),
(5, 'lenovo', 'lenovo', 1, '', '2022-12-23 12:30:37', '2022-12-23 12:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` mediumint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `user_id`, `quantity`) VALUES
(1, 29, 1, 2),
(2, 30, 1, 10),
(3, 30, 6, 4),
(4, 31, 1, 3),
(5, 31, 6, 2),
(7, 32, 7, 1),
(8, 40, 14, 1),
(9, 41, 14, 1),
(11, 41, 14, 1),
(19, 34, 55, 2),
(20, 31, 55, 3),
(120, 43, 56, 2),
(121, 34, 56, 1),
(122, 34, 56, 1),
(123, 43, 56, 1),
(124, 43, 56, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(25) NOT NULL,
  `name_ar` varchar(25) NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 => active , 0 => not active  ',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_en`, `name_ar`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'electronics', 'electronics', 'default.jpg', 1, '2022-11-12 18:32:35', '2022-12-21 21:47:41'),
(2, 'car', 'car', 'default.jpg', 1, '2022-11-12 18:32:35', '2022-11-12 18:32:35'),
(4, 'clothes', 'clothes', 'default.jpg', 1, '2022-11-21 19:25:27', '2022-11-21 19:25:27'),
(5, 'office', 'office', 'default.jpg', 1, '2022-11-21 21:48:24', '2022-11-21 21:48:24'),
(6, 'supermarket', 'supermarket', 'default.jpg', 1, '2022-12-20 21:53:43', '2022-12-20 21:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name_ar` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `shipping_fees` mediumint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active , 0 not active',
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name_en`, `name_ar`, `shipping_fees`, `status`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Cairo', 'القاهرة', 50, 1, 1, '2023-05-17 11:33:41', '2023-05-21 16:49:09'),
(2, 'Alexandria', 'الاسكندرية', 80, 1, 1, '2023-05-17 11:33:41', '2023-05-21 16:49:32'),
(3, 'Giza', 'الجيز', 50, 1, 1, '2023-05-17 11:33:41', '2023-05-21 16:49:46'),
(4, 'other', 'اخره', 100, 1, 1, '2023-05-21 16:50:17', '2023-05-21 16:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(5) NOT NULL,
  `name_ar` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active , 0 not active',
  `created-at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated-at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name_en`, `name_ar`, `status`, `created-at`, `updated-at`) VALUES
(1, 'EGYPT', 'مصر', 1, '2023-05-17 11:30:47', '2023-05-17 11:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` mediumint(4) NOT NULL,
  `discount` mediumint(5) NOT NULL,
  `discount_type` mediumint(5) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `max_discount_value` mediumint(5) NOT NULL,
  `mini_order_value` mediumint(5) NOT NULL,
  `max_user_value` mediumint(5) NOT NULL,
  `max_usage_number_per_user` mediumint(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `most_order`
-- (See below for the actual view)
--
CREATE TABLE `most_order` (
`pro_name_en` varchar(50)
,`pro_desc_en` varchar(1000)
,`pro_image` varchar(50)
,`pro_price` decimal(7,0)
,`count_product` bigint(21)
,`product_id` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titel_en` varchar(100) NOT NULL,
  `titel_ar` varchar(100) NOT NULL,
  `discount` mediumint(5) DEFAULT NULL,
  `image` varchar(50) DEFAULT 'default.jpg',
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 => active , 0 => not active',
  `price` mediumint(5) NOT NULL,
  `total_price` mediumint(5) NOT NULL,
  `delivre_date` longtext NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `coupons_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `order_number`, `status`, `price`, `total_price`, `delivre_date`, `address_id`, `coupons_id`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 10000, 10000, '20230526000000', 4, NULL, 18, '2023-01-06 19:55:51', '2023-06-21 21:10:36'),
(6, 2, 1, 12000, 12000, '20230526000000', 5, NULL, 14, '2023-01-06 19:55:51', '2023-06-21 21:10:33'),
(7, 3, 1, 5555, 5555, '20230526000000', 6, NULL, 8, '2023-01-06 19:55:51', '2023-06-21 21:10:20'),
(8, 4, 1, 7777, 7777, '20230526000000', 5, NULL, 9, '2023-01-06 19:55:51', '2023-06-21 21:10:16'),
(9, 5, 1, 33333, 33333, '20230526000000', 7, NULL, 55, '2023-01-06 20:06:53', '2023-06-21 21:10:08'),
(10, 6, 1, 2424, 2424, '20230526000000', 4, NULL, 1, '2023-01-06 20:06:53', '2023-06-21 21:09:55'),
(11, 7, 1, 10000, 12000, '20230526000000', 6, NULL, 7, '2023-05-21 16:56:14', '2023-06-21 21:09:52'),
(14, 8, 1, 333, 2333, '20230526000000', 4, NULL, 5, '2023-05-24 22:30:09', '2023-06-21 21:09:48'),
(157, 2, 1, 14168, 14248, '2023-12-17', 49, NULL, 56, '2023-12-13 21:57:44', '2023-12-13 21:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name_ar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(7,0) NOT NULL,
  `quantity` smallint(3) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL COMMENT '1=>active , 0 => not active',
  `desc_en` varchar(1000) NOT NULL,
  `decs_ar` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(50) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name_en`, `name_ar`, `price`, `quantity`, `status`, `desc_en`, `decs_ar`, `image`, `brand_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(29, 'lab tops HP', 'لاب توب', 50001, 1, 1, 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'hp.jpg', 1, 14, '2022-11-21 22:22:55', '2023-10-11 08:34:22'),
(30, 'hardDsk', 'hardDsk', 250, 3, 1, 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'Request for an indictment from the labor responsible for saving molesteas temperature sex with difference in terms of jurisdiction', 'hard-drive.jpg', 1, 14, '2022-11-22 17:25:12', '2023-12-16 21:56:36'),
(31, 'bmwX7', 'bmwX7', 10000, 4, 1, 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'BMW-X7.jpg', 2, 9, '2022-11-22 18:07:58', '2023-03-20 21:08:04'),
(32, 'mercedes panz', 'mercedespanz', 12000, 0, 1, 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'Deserunt eum recusandae accusantium accusamus laborum officiis provident dolores, molestias sed tempore dolorum praesentium cum et ratione iusto odit inventore ', 'mercedes.jpg', 3, 13, '2022-11-22 18:07:58', '2022-12-22 20:04:37'),
(34, 'lab tops lenovo', 'lab top lenovo', 7000, 8, 1, 'Request for an indictment from the labor responsible for saving molesteas temperature sex with difference in terms of jurisdiction', '??? ?????? ??? ????? ?? ????? ??????? ?? ??????? ???????????? ???????  ?????? ????? ?? ???????? ?? ??? ????????', 'lenovo-pcs-tablets-hover.jpg', 5, 14, '2022-12-21 22:11:18', '2023-12-13 19:55:07'),
(35, 'lab top lenovo', 'lab top lenovo', 7500, 5, 1, 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'lenovo-laptop-.jpg', 5, 14, '2022-12-21 22:19:44', '2023-10-22 20:25:47'),
(38, 'dell', 'ديل', 8000, 2, 1, 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'Dell.jpg', 5, 14, '2022-12-21 22:47:58', '2023-12-16 21:57:06'),
(40, 'teshert', 'تيشرت', 200, 50, 1, 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'طلب الحصول على اتهام من العمل المسؤول عن الإدخار ، مولستياس ، درجة الحرارة ، ممارسة الجنس مع الاختلاف من حيث الاختصاص', 't-shirt.png', 5, 11, '2022-12-22 00:12:41', '2023-12-16 22:12:57'),
(41, 'samsung A52', 'سمسونج A52', 5000, 12, 1, 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'طلب الحصول على اتهام من العمل المسؤول عن الإدخار ، مولستياس ، درجة الحرارة ، ممارسة الجنس مع الاختلاف من حيث الاختصاص', 'samsung.jpg', 1, 8, '2022-12-22 00:17:48', '2022-12-22 00:30:37'),
(42, 'iphone pro max 14', 'ايفون برو مكس 14', 40000, 15, 1, 'Request to obtain a charge from the work responsible for savings, molestias, temperature, sex with difference in terms of jurisdiction', 'طلب الحصول على اتهام من العمل المسؤول عن الإدخار ، مولستياس ، درجة الحرارة ، ممارسة الجنس مع الاختلاف من حيث الاختصاص', 'Apple-iPhone-14-Pro-Max.jpg', 4, 8, '2022-12-22 00:19:40', '2023-12-16 22:13:08'),
(43, 'shepse', 'شبسى', 56, 120, 1, 'mkarm4 weta3mo halwo', 'مقرمش وطعو حلو', 'shapse.png', NULL, 18, '2022-12-22 00:32:14', '2023-12-16 22:13:48'),
(45, 'macBook', 'macBook', 10000, 14, 1, 'apple', 'apple', 'macBook.png', 4, 14, '2023-01-03 22:29:36', '2023-01-03 22:29:36');

-- --------------------------------------------------------

--
-- Stand-in structure for view `products_details`
-- (See below for the actual view)
--
CREATE TABLE `products_details` (
`id` bigint(20) unsigned
,`name_en` varchar(50)
,`name_ar` varchar(50)
,`price` decimal(7,0)
,`quantity` smallint(3)
,`status` tinyint(1)
,`desc_en` varchar(1000)
,`decs_ar` varchar(1000)
,`image` varchar(50)
,`brand_id` bigint(20) unsigned
,`subcategory_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`subcategory_name_en` varchar(50)
,`brand_name_en` varchar(50)
,`category_id` bigint(20) unsigned
,`category_name_en` varchar(25)
,`reviews_count` bigint(21)
,`reviews_avg` decimal(2,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `products_offers`
--

CREATE TABLE `products_offers` (
  `offre_id` bigint(20) UNSIGNED NOT NULL,
  `products_id` bigint(20) UNSIGNED NOT NULL,
  `price_after_discount` mediumint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_order`
--

CREATE TABLE `products_order` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `price_after_order` mediumint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products_order`
--

INSERT INTO `products_order` (`product_id`, `order_id`, `price_after_order`) VALUES
(31, 6, 55555),
(40, 7, 44444),
(42, 5, 33333),
(35, 8, 66666),
(40, 9, 55555),
(40, 6, 44444),
(42, 6, 33333),
(40, 10, 55555),
(40, 6, 44444),
(38, 6, 40000),
(32, 6, 5656),
(30, 9, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 => active , 0 => not active',
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name_en`, `name_ar`, `status`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'side basher', 'side basher', 1, 2, '2023-01-06 19:43:24', '2023-01-06 19:43:24'),
(2, 'el manshy', 'elmanshy', 1, 2, '2023-01-06 19:43:24', '2023-01-06 19:43:24'),
(3, 'zmalk', 'zmalk', 1, 1, '2023-01-06 19:43:24', '2023-01-06 19:43:24'),
(4, 'embaba', 'embaba', 1, 3, '2023-01-06 19:43:24', '2023-01-06 19:43:24'),
(5, 'el tahrer', 'el tahrer', 1, 1, '2023-01-06 19:43:24', '2023-01-06 19:43:24'),
(6, 'masr new', 'masr new', 1, 1, '2023-01-06 19:43:24', '2023-01-06 19:43:24'),
(7, 'Pyramids', 'Pyramids', 1, 3, '2023-01-06 19:44:48', '2023-01-06 19:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `products_id` bigint(20) UNSIGNED NOT NULL,
  `user-id` bigint(20) UNSIGNED NOT NULL,
  `value` enum('0','1','2','3','4','5') NOT NULL,
  `comment` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created-at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated-at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`products_id`, `user-id`, `value`, `comment`, `created-at`, `updated-at`) VALUES
(31, 8, '2', 'exslent', '2023-01-01 17:16:17', '2023-01-04 21:23:40'),
(31, 18, '3', 'Vary good', '2023-01-01 17:16:17', '2023-01-01 17:16:17'),
(31, 51, '3', 'Good', '2023-01-01 17:16:17', '2023-01-01 17:16:17'),
(38, 7, '4', 'good', '2023-01-01 17:16:17', '2023-01-01 17:16:17'),
(38, 14, '0', 'bad', '2023-01-01 17:16:17', '2023-01-01 17:16:17'),
(41, 2, '3', '', '2023-01-01 17:16:17', '2023-01-01 17:16:17'),
(41, 3, '3', 'not bad', '2023-01-06 18:25:14', '2023-01-06 18:25:14'),
(41, 4, '3', 'amazing', '2023-01-06 18:49:20', '2023-01-06 18:49:20'),
(41, 5, '3', 'exlent', '2023-01-06 18:23:30', '2023-01-06 18:24:14'),
(41, 14, '4', 'good', '2023-01-06 18:23:30', '2023-01-06 18:23:30'),
(43, 56, '1', 'vary bad !!!!!!!!!', '2023-01-01 21:01:58', '2023-01-01 21:01:58'),
(45, 18, '3', 'wow that\'s amazing', '2023-01-06 18:27:48', '2023-01-06 18:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 => active , 0 not active',
  `image` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `craeted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name_en`, `name_ar`, `status`, `image`, `category_id`, `craeted_at`, `updated_at`) VALUES
(8, 'mobil', 'mobil', 1, 'default.jpg', 1, '2022-11-12 18:34:22', '2022-12-21 21:50:29'),
(9, 'bmw', 'bmw', 1, 'default.jpg', 2, '2022-11-12 18:34:22', '2022-11-12 18:34:22'),
(11, 'teshert', 'teshert', 1, 'default.jpg', 4, '2022-11-21 19:29:09', '2022-11-21 19:29:09'),
(12, 'fan', 'fan', 1, 'default.jpg', 1, '2022-11-21 19:29:09', '2022-12-21 21:49:03'),
(13, 'marseds', 'marseds', 1, 'default.jpg', 2, '2022-11-21 19:29:09', '2022-11-21 19:29:09'),
(14, 'lab tops', 'lab tops', 1, 'default.jpg', 1, '2022-11-21 19:30:23', '2022-12-21 21:52:07'),
(18, 'Shpse', 'shpse', 1, 'default.jpg', 6, '2022-12-21 17:38:30', '2022-12-21 17:38:30'),
(19, 'chair', 'chair', 1, 'default.jpg', 5, '2022-12-21 20:58:31', '2022-12-21 20:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0 => not varified , 1 => varified , 2 => block',
  `image` varchar(50) DEFAULT 'default.png',
  `code` mediumint(5) DEFAULT NULL,
  `gender` enum('m','f') NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `status`, `image`, `code`, `gender`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'hassan', 'mahmoud', 'hassan@gmail.com', '128758714', '123456', 1, 'default.png', NULL, 'm', 2, '2022-11-19 20:32:29', '2023-06-09 18:45:08'),
(2, 'hussen', 'mahmoud', 'hussen@gmail.com', '0124578923', '1234560', 1, 'default.png', NULL, 'm', 2, '2022-11-12 21:00:00', '2023-06-09 18:48:35'),
(3, 'ramz', 'mahmoud', 'aya@gmail.com', '0124577823', '1234567', 1, 'default.png', 1234, 'f', 2, '2022-11-12 21:00:00', '2023-06-09 18:48:35'),
(4, 'ali', 'mohamed', 'ali@gmail.com', '1234545678', '12456', 0, 'default.png', NULL, 'm', 2, '2022-11-15 11:29:48', '2023-06-09 18:48:35'),
(5, 'hossam', 'mahmoud', 'hossam@gmail.com', '01245678935', '123456', 1, 'default.png', 1234, 'm', 2, '2022-11-15 11:29:48', '2023-06-09 18:48:35'),
(6, 'rodina', 'essam', 'rodena@gmail.com', '01541313215', '123456', 1, 'default.png', 2323, 'f', 2, '2022-11-15 11:29:48', '2023-06-09 18:48:35'),
(7, 'rokyah', 'hassan', 'isra@gmail.com', '01234567891', '123456', 0, 'default.png', 93822, 'f', 2, '2022-11-15 11:29:48', '2023-06-09 18:48:35'),
(8, 'mone', 'mohamed', 'mone@gmail.com', '1244448488', '12456', 1, 'default.png', NULL, 'f', 2, '2022-11-22 20:36:41', '2023-06-09 18:48:35'),
(9, 'Hassan', 'Mahmoud', 'Hossen4543@gmail.com', '01287587178', 'Hassan@123456', 0, 'default.png', NULL, 'm', 2, '2022-11-29 20:43:48', '2023-06-09 18:48:35'),
(14, 'ahmad', 'essam', 'ahmad22@gmail.com', '012457823', 'b63ff0790a95493af854b1fad401ece8d6454cc7', 0, 'default.png', 26612, 'm', 2, '2022-11-29 21:38:44', '2023-06-09 18:48:35'),
(15, 'Hassan', 'Mahmoud', 'hassan3454@gmail.com', '01287587134', '948366cc33eb043a89c029ec9086513d61fdf904', 0, 'default.png', 34018, 'm', 2, '2022-12-03 16:15:55', '2023-06-09 18:48:35'),
(18, 'abdo', 'Mohamd', 'abdo@gmail.com', '01287587148', '948366cc33eb043a89c029ec9086513d61fdf904', 0, 'default.png', 20506, 'm', 2, '2022-12-03 16:58:09', '2023-06-09 18:48:35'),
(21, 'lama', 'wael', 'lama@gmail.com', '01287587122', 'b63ff0790a95493af854b1fad401ece8d6454cc7', 1, 'default.png', 28149, 'f', 2, '2022-12-03 17:51:03', '2023-06-18 20:51:01'),
(51, 'Hassan', 'Mahmoud', 'Hossen45@gmail.com', '01287587147', '948366cc33eb043a89c029ec9086513d61fdf904', 1, 'default.png', 22700, 'm', 2, '2022-12-07 19:09:09', '2023-06-09 18:48:35'),
(55, 'hissen', 'mahmoud', 'hussienbedawy@gmail.com', '01287654287', 'b63ff0790a95493af854b1fad401ece8d6454cc7', 1, 'default.png', 83477, 'm', 2, '2022-12-07 23:07:54', '2023-06-09 18:48:35'),
(56, 'hassan', 'Mahmoud', 'hassan333@gmail.com', '01287587444', 'b63ff0790a95493af854b1fad401ece8d6454cc7', 1, '1671032637-56.jpg', 99995, 'm', 2, '2022-12-08 13:57:29', '2023-06-09 18:48:35'),
(61, 'Hassan', 'Mahmoud', 'Hosseneljoker@gmail.com', '01004089065', 'b63ff0790a95493af854b1fad401ece8d6454cc7', 1, 'default.png', 53901, 'm', 2, '2023-12-16 21:51:40', '2023-12-16 21:52:26');

-- --------------------------------------------------------

--
-- Stand-in structure for view `users_reviews`
-- (See below for the actual view)
--
CREATE TABLE `users_reviews` (
`products_id` bigint(20) unsigned
,`user-id` bigint(20) unsigned
,`value` enum('0','1','2','3','4','5')
,`comment` varchar(1000)
,`created-at` timestamp
,`updated-at` timestamp
,`name_en` varchar(50)
,`desc_en` varchar(1000)
,`image` varchar(50)
,`price` decimal(7,0)
,`full_name` varchar(61)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_address`
-- (See below for the actual view)
--
CREATE TABLE `user_address` (
`user_email` varchar(50)
,`region_name_en` varchar(50)
,`region_name_ar` varchar(50)
,`id` bigint(20) unsigned
,`address` varchar(1000)
,`street` varchar(1000)
,`building` varchar(1000)
,`floor` varchar(1000)
,`flat` varchar(1000)
,`notes` varchar(1000)
,`user_id` bigint(20) unsigned
,`regions_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `waishlist`
--

CREATE TABLE `waishlist` (
  `products_id` bigint(20) UNSIGNED NOT NULL,
  `user-id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure for view `most_order`
--
DROP TABLE IF EXISTS `most_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `most_order`  AS   (select `products`.`name_en` AS `pro_name_en`,`products`.`desc_en` AS `pro_desc_en`,`products`.`image` AS `pro_image`,`products`.`price` AS `pro_price`,count(`products_order`.`order_id`) AS `count_product`,`products_order`.`product_id` AS `product_id` from (`products_order` join `products` on(`products`.`id` = `products_order`.`product_id`)) group by `products_order`.`product_id` order by count(`products_order`.`order_id`) desc)  ;

-- --------------------------------------------------------

--
-- Structure for view `products_details`
--
DROP TABLE IF EXISTS `products_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `products_details`  AS   (select `products`.`id` AS `id`,`products`.`name_en` AS `name_en`,`products`.`name_ar` AS `name_ar`,`products`.`price` AS `price`,`products`.`quantity` AS `quantity`,`products`.`status` AS `status`,`products`.`desc_en` AS `desc_en`,`products`.`decs_ar` AS `decs_ar`,`products`.`image` AS `image`,`products`.`brand_id` AS `brand_id`,`products`.`subcategory_id` AS `subcategory_id`,`products`.`created_at` AS `created_at`,`products`.`updated_at` AS `updated_at`,`subcategories`.`name_en` AS `subcategory_name_en`,`brands`.`name_en` AS `brand_name_en`,`categories`.`id` AS `category_id`,`categories`.`name_en` AS `category_name_en`,count(`reviews`.`products_id`) AS `reviews_count`,round(if(avg(`reviews`.`value`) is null,0,avg(`reviews`.`value`)),0) AS `reviews_avg` from ((((`products` left join `brands` on(`brands`.`id` = `products`.`brand_id`)) join `subcategories` on(`subcategories`.`id` = `products`.`subcategory_id`)) join `categories` on(`categories`.`id` = `subcategories`.`category_id`)) left join `reviews` on(`products`.`id` = `reviews`.`products_id`)) where `products`.`status` = 1 group by `products`.`id` order by `products`.`price`,`products`.`name_en`)  ;

-- --------------------------------------------------------

--
-- Structure for view `users_reviews`
--
DROP TABLE IF EXISTS `users_reviews`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users_reviews`  AS   (select `reviews`.`products_id` AS `products_id`,`reviews`.`user-id` AS `user-id`,`reviews`.`value` AS `value`,`reviews`.`comment` AS `comment`,`reviews`.`created-at` AS `created-at`,`reviews`.`updated-at` AS `updated-at`,`products`.`name_en` AS `name_en`,`products`.`desc_en` AS `desc_en`,`products`.`image` AS `image`,`products`.`price` AS `price`,concat(`users`.`first_name`,' ',`users`.`last_name`) AS `full_name` from ((`reviews` join `users` on(`users`.`id` = `reviews`.`user-id`)) join `products` on(`products`.`id` = `reviews`.`products_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `user_address`
--
DROP TABLE IF EXISTS `user_address`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_address`  AS   (select `users`.`email` AS `user_email`,`regions`.`name_en` AS `region_name_en`,`regions`.`name_ar` AS `region_name_ar`,`address`.`id` AS `id`,`address`.`address` AS `address`,`address`.`street` AS `street`,`address`.`building` AS `building`,`address`.`floor` AS `floor`,`address`.`flat` AS `flat`,`address`.`notes` AS `notes`,`address`.`user_id` AS `user_id`,`address`.`regions_id` AS `regions_id`,`address`.`created_at` AS `created_at`,`address`.`updated_at` AS `updated_at` from ((`address` join `users` on(`address`.`user_id` = `users`.`id`)) join `regions` on(`address`.`regions_id` = `regions`.`id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_regions_fk` (`regions_id`),
  ADD KEY `address_user_fk` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_fk` (`user_id`),
  ADD KEY `products_cart_fk` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_country_fk` (`country_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `order_coupons_fk` (`coupons_id`),
  ADD KEY `order_address_fk` (`address_id`),
  ADD KEY `coupons_id` (`coupons_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brrands_fk` (`brand_id`),
  ADD KEY `products_subcategories_fk` (`subcategory_id`);

--
-- Indexes for table `products_offers`
--
ALTER TABLE `products_offers`
  ADD KEY `products_offers_offer_fk` (`offre_id`),
  ADD KEY `products_offers_product_fk` (`products_id`);

--
-- Indexes for table `products_order`
--
ALTER TABLE `products_order`
  ADD KEY `products_order_product_fk` (`product_id`),
  ADD KEY `order` (`order_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_city_fk` (`city_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`products_id`,`user-id`),
  ADD KEY `revews_user_fk` (`user-id`) USING BTREE;

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_categories_fk` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `user_city_fk` (`city_id`);

--
-- Indexes for table `waishlist`
--
ALTER TABLE `waishlist`
  ADD PRIMARY KEY (`products_id`),
  ADD KEY `waishlist_uers_fk` (`user-id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_regions_fk` FOREIGN KEY (`regions_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `address_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_cart_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_country_fk` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_address_fk` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_coupons_fk` FOREIGN KEY (`coupons_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brrands_fk` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_subcategories_fk` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);

--
-- Constraints for table `products_offers`
--
ALTER TABLE `products_offers`
  ADD CONSTRAINT `products_offers_offer_fk` FOREIGN KEY (`offre_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_offers_product_fk` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_order`
--
ALTER TABLE `products_order`
  ADD CONSTRAINT `order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_order_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_city_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `revews_product_fk` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `revews_user_fk` FOREIGN KEY (`user-id`) REFERENCES `users` (`id`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_categories_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_city_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `waishlist`
--
ALTER TABLE `waishlist`
  ADD CONSTRAINT `waishlist_products_fk` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `waishlist_uers_fk` FOREIGN KEY (`user-id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
