-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 06:45 AM
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
-- Database: `seleramuda`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `gender`, `phone`, `address`, `created`, `updated`) VALUES
(1, 'Songkang', 'L', '0852364125', 'DIY', '2024-11-11 16:07:06', '2025-06-28 15:27:45'),
(2, 'Ningning', 'P', '082563256', 'Korea', '2024-11-13 23:33:21', '2025-06-28 15:27:29'),
(3, 'Umum', 'L', '0', '.', '2024-12-22 01:06:19', '2024-12-21 19:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `p_category`
--

CREATE TABLE `p_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `p_category`
--

INSERT INTO `p_category` (`category_id`, `name`, `created`, `updated`, `user_id`) VALUES
(1, 'Makanan', '2024-12-11 21:03:18', NULL, 1),
(8, 'Minuman', '2024-12-12 08:51:26', NULL, 1),
(9, 'Snack', '2024-12-12 08:53:20', NULL, 3),
(10, 'Kecap', '2024-12-13 21:26:57', NULL, 1),
(11, 'Minuman', '2025-06-21 20:23:55', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `p_item`
--

CREATE TABLE `p_item` (
  `item_id` int(11) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `stock` int(10) NOT NULL DEFAULT 0,
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `p_item`
--

INSERT INTO `p_item` (`item_id`, `barcode`, `name`, `category_id`, `unit_id`, `price`, `purchase_price`, `stock`, `image`, `created`, `updated`, `user_id`, `supplier_id`) VALUES
(1, 'A001', 'Chitato', 1, 7, 5000, NULL, 5, 'item-241211-77f88e13fb.jpg', '2024-12-11 21:05:00', '2025-10-28 07:38:17', 1, NULL),
(19, 'A002', 'Coca Cola', 8, 8, 5000, NULL, -5, 'item-241212-723044d4ba.png', '2024-12-12 08:52:41', '2025-10-28 07:38:17', 1, NULL),
(20, 'B001', 'Pizza', 9, 7, 7500, 2000.00, 51, 'item-241212-202ea06534.png', '2024-12-12 08:54:22', '2025-10-28 07:38:17', 3, 1),
(21, 'A003', 'Kecap Bango', 10, 8, 15000, NULL, -3, 'item-241213-0cebea51ee.png', '2024-12-13 21:27:34', '2025-10-28 07:38:17', 1, 1),
(22, 'G001', 'Sprite', 11, 8, 10000, 3000.00, 51, 'item-250621-37cbb180a1.jpeg', '2025-06-21 20:38:34', '2025-10-28 07:38:17', 3, 7),
(23, 'G110', 'Naspad', 9, 7, 10000, 5000.00, 52, 'item-250628-e53fa07bf3.jpeg', '2025-06-28 15:53:01', '2025-10-28 07:38:17', 3, 2),
(24, 'O001', 'Kusuka', 9, 7, 8500, 4500.00, 51, 'item-250629-ece8339794.jpeg', '2025-06-29 11:03:39', '2025-10-28 07:38:17', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `p_unit`
--

CREATE TABLE `p_unit` (
  `unit_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `p_unit`
--

INSERT INTO `p_unit` (`unit_id`, `name`, `created`, `updated`) VALUES
(2, 'Kilogram', '2024-11-15 23:53:20', '2024-11-16 13:52:09'),
(4, 'Lusin', '2024-11-16 00:15:21', '2024-11-16 13:52:14'),
(6, 'Buah', '2024-11-17 21:38:37', NULL),
(7, 'Gram', '2024-11-18 22:37:00', NULL),
(8, 'Ml', '2024-12-12 08:52:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `phone`, `address`, `description`, `created`, `updated`) VALUES
(1, 'Toko A', '025869365', 'Semarang', NULL, '2024-11-10 00:25:35', NULL),
(2, 'Toko B', '032541785', 'Solo', 'Toko Minuman ', '2024-11-10 00:25:35', NULL),
(7, 'PT Agung', '08123456799', 'Jakarta', 'Minuman  Bersoda', '2025-06-21 20:23:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_cart`
--

CREATE TABLE `t_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_sale`
--

CREATE TABLE `t_sale` (
  `sale_id` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `final_price` decimal(10,2) NOT NULL,
  `cash` decimal(10,2) NOT NULL,
  `remaining` decimal(10,2) NOT NULL,
  `note` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `cashier` varchar(255) NOT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `transaction_status` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_sale`
--

INSERT INTO `t_sale` (`sale_id`, `invoice`, `customer_id`, `total_price`, `discount`, `final_price`, `cash`, `remaining`, `note`, `date`, `user_id`, `created`, `cashier`, `payment_type`, `transaction_status`, `transaction_id`) VALUES
(159, 'MP2510280002', 3, 7500.00, 0.00, 7500.00, 10000.00, 2500.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:15:11', '', NULL, NULL, NULL),
(160, 'MP2510280003', 3, 8500.00, 0.00, 8500.00, 10000.00, 1500.00, 'Makasih', '2024-02-28 00:00:00', 0, '2025-10-28 08:17:07', '', NULL, NULL, NULL),
(161, 'MP2510280004', 3, 10000.00, 0.00, 10000.00, 10000.00, 0.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:17:19', '', NULL, NULL, NULL),
(162, 'MP2510280005', 3, 8500.00, 0.00, 8500.00, 10000.00, 1500.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:17:32', '', NULL, NULL, NULL),
(163, 'MP2510280006', 3, 16000.00, 0.00, 16000.00, 20000.00, 4000.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:17:43', '', NULL, NULL, NULL),
(164, 'MP2510280007', 3, 25500.00, 0.00, 25500.00, 26000.00, 500.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:17:55', '', NULL, NULL, NULL),
(165, 'MP2510280001', 3, 8500.00, 0.00, 8500.00, 5000.00, 0.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:19:42', '', NULL, NULL, NULL),
(168, 'MP2510280009', 3, 26000.00, 2000.00, 24000.00, 25000.00, 1000.00, '', '2024-12-31 00:00:00', 0, '2025-10-28 08:21:10', '', NULL, NULL, NULL),
(170, 'MP2510280011', 1, 10000.00, 0.00, 10000.00, 10000.00, 0.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:22:50', '', NULL, NULL, NULL),
(171, 'MP2510280012', 2, 23500.00, 0.00, 23500.00, 25000.00, 1500.00, '', '2025-10-28 00:00:00', 0, '2025-10-28 08:23:14', '', NULL, NULL, NULL),
(191, 'MP2510300001-1761808705530', 3, 8000.00, 0.00, 8000.00, 0.00, 0.00, 'Pembayaran via Midtrans', '2025-10-30 08:18:49', 0, '2025-10-30 14:18:49', 'Midtrans', 'bank_transfer', 'settlement', '741aa1e8-945c-499c-bdd9-322ec7f403bf'),
(193, 'MP2511050001-1762321257090', 3, 10000.00, 3000.00, 7000.00, 0.00, 0.00, 'Pembayaran via Midtrans', '2025-11-05 06:41:12', 0, '2025-11-05 12:41:12', 'Midtrans', 'bank_transfer', 'settlement', '678b3898-fa40-4f0b-b581-019177ca4eea');

-- --------------------------------------------------------

--
-- Table structure for table `t_sale_detail`
--

CREATE TABLE `t_sale_detail` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_sale_detail`
--

INSERT INTO `t_sale_detail` (`id`, `sale_id`, `item_id`, `price`, `qty`, `discount`, `total`) VALUES
(65, 159, 20, 7500.00, 1, 0.00, 7500.00),
(66, 160, 24, 8500.00, 1, 0.00, 8500.00),
(67, 161, 23, 10000.00, 1, 0.00, 10000.00),
(68, 162, 24, 8500.00, 1, 0.00, 8500.00),
(69, 163, 20, 7500.00, 1, 0.00, 7500.00),
(70, 163, 24, 8500.00, 1, 0.00, 8500.00),
(71, 164, 24, 8500.00, 3, 0.00, 25500.00),
(72, 165, 24, 8500.00, 1, 0.00, 8500.00),
(75, 168, 24, 8500.00, 1, 0.00, 8500.00),
(76, 168, 23, 10000.00, 1, 0.00, 10000.00),
(77, 168, 20, 7500.00, 1, 0.00, 7500.00),
(78, 170, 22, 10000.00, 1, 0.00, 10000.00),
(79, 171, 24, 8500.00, 1, 0.00, 8500.00),
(80, 171, 20, 7500.00, 2, 0.00, 15000.00),
(95, 191, 23, 10000.00, 1, 0.00, 10000.00),
(97, 193, 23, 10000.00, 1, 0.00, 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `t_stock`
--

CREATE TABLE `t_stock` (
  `stock_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` enum('in','out') NOT NULL,
  `detail` varchar(200) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `qty` int(10) NOT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_stock`
--

INSERT INTO `t_stock` (`stock_id`, `item_id`, `type`, `detail`, `supplier_id`, `qty`, `date`, `created`, `user_id`) VALUES
(6, 20, 'in', 'Warung', 1, 5, '2024-12-12', '2024-12-12 08:54:54', 3),
(10, 1, 'out', 'rusak', NULL, 2, '2024-12-16', '2024-12-16 16:31:56', 1),
(11, 21, 'out', 'rusak', NULL, 1, '2024-12-16', '2024-12-16 16:35:33', 1),
(12, 21, 'out', 'rusak', NULL, 1, '2024-12-16', '2024-12-16 16:41:14', 1),
(13, 19, 'out', 'hilang', NULL, 5, '2024-12-16', '2024-12-16 16:49:01', 1),
(14, 19, 'out', 'hilang', NULL, 5, '2024-12-16', '2024-12-16 16:50:50', 1),
(15, 19, 'out', 'hilang', NULL, 5, '2024-12-16', '2024-12-16 16:51:07', 1),
(16, 21, 'out', 'kadaluarsa', NULL, 1, '2024-12-16', '2024-12-16 16:52:54', 1),
(17, 21, 'out', 'kadaluarsa', NULL, 1, '2024-12-16', '2024-12-16 16:53:21', 1),
(18, 1, 'out', 'kadaluarsa', NULL, 2, '2024-12-16', '2024-12-16 16:55:09', 1),
(19, 1, 'out', 'rusak', NULL, 1, '2024-12-16', '2024-12-16 16:56:05', 1),
(21, 22, 'in', 'kulak', 1, 20, '2025-06-28', '2025-06-28 15:14:20', 3),
(22, 23, 'in', 'kulak', 2, 10, '2025-06-28', '2025-06-28 15:54:34', 3),
(23, 20, 'in', 'kulak', 1, 30, '2025-06-29', '2025-06-29 11:04:01', 3),
(24, 24, 'in', 'kulak', 2, 20, '2025-06-29', '2025-06-29 11:04:18', 3),
(25, 22, 'out', 'rusak', NULL, 1, '2025-07-24', '2025-07-24 23:10:42', 3),
(26, 20, 'in', 'kulak', 1, 50, '2025-10-28', '2025-10-28 12:03:14', 3),
(27, 24, 'in', 'kulak', 2, 40, '2025-10-28', '2025-10-28 12:03:27', 3),
(28, 20, 'out', 'rusak', NULL, 1, '2025-10-28', '2025-10-28 13:38:17', 3),
(29, 22, 'in', 'kulak', 1, 50, '2025-10-28', '2025-10-28 16:50:31', 3),
(30, 23, 'in', 'kulak', 2, 60, '2025-10-28', '2025-10-28 16:50:47', 3),
(31, 20, 'in', 'kulak', 1, 30, '2025-10-28', '2025-10-28 16:50:57', 3),
(32, 24, 'in', 'kulak', 7, 30, '2025-10-28', '2025-10-28 16:51:09', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `level` int(1) NOT NULL COMMENT '1:admin, 2:kasir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `name`, `address`, `level`) VALUES
(1, 'dimas', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'Jogja', 1),
(3, 'nanda', '16e8b7d240c81a0cbc6c0d5dcf00ef946b771823', 'nanda', 'sch', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `p_category`
--
ALTER TABLE `p_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `p_category_ibfk_1` (`user_id`);

--
-- Indexes for table `p_item`
--
ALTER TABLE `p_item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `p_item_ibfk_3` (`user_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `p_unit`
--
ALTER TABLE `p_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `t_cart`
--
ALTER TABLE `t_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_sale`
--
ALTER TABLE `t_sale`
  ADD PRIMARY KEY (`sale_id`),
  ADD UNIQUE KEY `invoice` (`invoice`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `t_sale_detail`
--
ALTER TABLE `t_sale_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `t_stock`
--
ALTER TABLE `t_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `p_category`
--
ALTER TABLE `p_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `p_item`
--
ALTER TABLE `p_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `p_unit`
--
ALTER TABLE `p_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_cart`
--
ALTER TABLE `t_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `t_sale`
--
ALTER TABLE `t_sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `t_sale_detail`
--
ALTER TABLE `t_sale_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `t_stock`
--
ALTER TABLE `t_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `p_category`
--
ALTER TABLE `p_category`
  ADD CONSTRAINT `p_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `p_item`
--
ALTER TABLE `p_item`
  ADD CONSTRAINT `p_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `p_category` (`category_id`),
  ADD CONSTRAINT `p_item_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `p_unit` (`unit_id`),
  ADD CONSTRAINT `p_item_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `p_item_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `t_cart`
--
ALTER TABLE `t_cart`
  ADD CONSTRAINT `t_cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `p_item` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `t_sale`
--
ALTER TABLE `t_sale`
  ADD CONSTRAINT `t_sale_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `t_sale_detail`
--
ALTER TABLE `t_sale_detail`
  ADD CONSTRAINT `t_sale_detail_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `t_sale` (`sale_id`),
  ADD CONSTRAINT `t_sale_detail_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `p_item` (`item_id`);

--
-- Constraints for table `t_stock`
--
ALTER TABLE `t_stock`
  ADD CONSTRAINT `t_stock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `p_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_stock_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `t_stock_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
