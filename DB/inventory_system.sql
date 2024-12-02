-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 01:08 AM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock_status` enum('in_stock','outof_stock') NOT NULL DEFAULT 'in_stock',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `product_category_id`, `price`, `stock_status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Men\'s Casual Shoe Bata 1', 1, 21.00, 'outof_stock', 1, '2024-11-28 02:48:32', '2024-11-28 03:46:21'),
(2, 'Men\'s Casual Shoe Bata 2', 1, 35.00, 'in_stock', 1, '2024-11-28 02:48:32', '2024-11-28 03:46:21'),
(3, 'Children T-shirts by polo 1', 2, 25.99, 'in_stock', 1, '2024-11-28 02:50:32', '2024-11-28 03:49:03'),
(5, 'Kid\'s Pants White', 3, 30.00, 'in_stock', 1, '2024-11-29 17:00:15', '0000-00-00 00:00:00'),
(7, 'Women Shoe Blue', 2, 60.00, 'outof_stock', 1, '2024-11-29 17:04:07', '0000-00-00 00:00:00'),
(9, 'Kid\'s Shoe Green', 3, 55.00, 'in_stock', 1, '2024-12-01 23:03:03', '0000-00-00 00:00:00'),
(10, 'Men\'s Sock Black', 4, 5.00, 'in_stock', 1, '2024-12-01 23:03:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `item`, `created_at`, `updated_at`) VALUES
(1, 'Men\'s Shoe', '2024-11-29 01:57:14', '2024-11-29 02:56:51'),
(2, 'Women Shoe', '2024-11-29 01:57:14', '2024-11-29 02:56:51'),
(3, 'Children Clothing', '2024-11-29 01:57:48', '2024-11-29 02:57:17'),
(4, 'Men\'s Clothing', '2024-11-29 01:57:48', '2024-11-29 02:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Nikhil Sen', 'nikhil', '8017d0408f41b75489701e3fb1c3e773', '2024-11-28 01:28:08', '2024-11-28 02:26:59'),
(2, 'Samir Das', 'samir', 'e10adc3949ba59abbe56e057f20f883e', '2024-11-28 01:28:08', '2024-11-28 02:26:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
