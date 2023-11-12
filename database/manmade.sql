-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2023 at 04:01 AM
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
-- Database: `manmade`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `session` text NOT NULL,
  `id` int(11) NOT NULL,
  `path` text NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `size` text NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `session` text NOT NULL,
  `order_id` text NOT NULL,
  `email` text NOT NULL,
  `country` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `address` text NOT NULL,
  `apartment_number` text NOT NULL,
  `postal_code` text NOT NULL,
  `phone_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `code` text NOT NULL DEFAULT 'IE4717',
  `percentage` double NOT NULL DEFAULT 0.05
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`code`, `percentage`) VALUES
('IE4717', 0.5),
('WAD', 0.05);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `tracking_id` text NOT NULL,
  `order_id` text NOT NULL,
  `name` text NOT NULL,
  `price` double NOT NULL,
  `size` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount_code` text DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `estimated_taxes` double NOT NULL,
  `total_price` double NOT NULL,
  `shipping_method` text DEFAULT NULL,
  `shipping_fee` double DEFAULT NULL,
  `payment_method` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `order_confirmation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(11) NOT NULL DEFAULT 1,
  `path` text NOT NULL DEFAULT '../assets/shoes/Oxford Brogues.webp',
  `city` text NOT NULL DEFAULT 'Northampton',
  `name` text NOT NULL DEFAULT 'Oxford Brogues',
  `price` double NOT NULL DEFAULT 80,
  `size` enum('35.5','36','36.5','37.5','38','38.5','39','40','40.5','41','42','42.5','43','44','44.5','45','45.5','46','47','47.5','48') NOT NULL DEFAULT '44'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`id`, `path`, `city`, `name`, `price`, `size`) VALUES
(1, '../assets/shoes/Oxford Brogues.webp', 'Northampton', 'Oxford Brogues', 80, '35.5'),
(2, '../assets/shoes/Derby Shoes.webp', 'Milan', 'Derby Shoes', 70, '36'),
(3, '../assets/shoes/Monk Strap Shoes.webp', 'Paris', 'Monk Strap Shoes', 100, '36.5'),
(4, '../assets/shoes/Loafers.webp', 'Florence', 'Loafers', 50, '37.5'),
(5, '../assets/shoes/Cap Toe Shoes.webp', 'London', 'Cap Toe Shoes', 80, '38'),
(6, '../assets/shoes/Clarks Shoes.webp', 'Barcelona', 'Clarks Shoes', 80, '38.5'),
(7, '../assets/shoes/Chelsea Boots.webp', 'New York City', 'Chelsea Boots', 60, '39'),
(8, '../assets/shoes/Wholecut Shoes.webp', 'Tokyo', 'Wholecut Shoes', 150, '40'),
(9, '../assets/shoes/Tassel Loafers.webp', 'Istanbul', 'Tassel Loafers', 80, '40.5'),
(10, '../assets/shoes/Chukka Boots.webp', 'Rio de Janeiro', 'Chukka Boots', 60, '41'),
(11, '../assets/shoes/Penny Loafers.webp', 'Rome', 'Penny Loafers', 60, '42'),
(12, '../assets/shoes/Bicycle Toe Shoes.webp', 'Buenos Aires', 'Bicycle Toe Shoes', 80, '42.5'),
(13, '../assets/shoes/Plain Toe Shoes.webp', 'Mumbai', 'Plain Toe Shoes', 70, '43'),
(14, '../assets/shoes/Golf Shoes.webp', 'Cairo', 'Golf Shoes', 80, '44'),
(15, '../assets/shoes/Dress Boots.webp', 'Seoul', 'Dress Boots', 80, '44.5'),
(16, '../assets/shoes/Opera Pumps.webp', 'Melbourne', 'Opera Pumps', 80, '45'),
(17, '../assets/shoes/Saddle Shoes.webp', 'Amsterdam', 'Saddle Shoes', 70, '45.5'),
(18, '../assets/shoes/Blucher Shoes.webp', 'São Paulo', 'Blucher Shoes', 60, '46'),
(19, '../assets/shoes/Suede Chukkas.webp', 'Montreal', 'Suede Chukkas', 60, '47'),
(20, '../assets/shoes/Formal Loafers.webp', 'Madrid', 'Formal Loafers', 50, '47.5'),
(21, '../assets/shoes/Slip-On Dress Shoes.webp', 'Guangzhou', 'Slip-On Dress Shoes', 50, '48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
