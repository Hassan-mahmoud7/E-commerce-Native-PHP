-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 11:14 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brrands_fk` (`brand_id`),
  ADD KEY `products_subcategories_fk` (`subcategory_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brrands_fk` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_subcategories_fk` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
