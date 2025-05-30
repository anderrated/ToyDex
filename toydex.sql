-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 07:12 AM
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
-- Database: `toydex`
--

-- --------------------------------------------------------

--
-- Table structure for table `has`
--

CREATE TABLE `has` (
  `item_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `has` (`item_id`, `image_id`) VALUES
(1, 1),
(2, 2),
(3, 3);
--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `manufacturer_id` int(11) NOT NULL,
  `manufacturer_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `manufacturer` (`manufacturer_id`, `manufacturer_name`, `location`) VALUES
(1, 'SnuggleToys Inc.', 'Japan'),
(2, 'BrickMakers Ltd.', 'Germany'),
(3, 'ZoomWheels Corp.', 'USA');
--
-- Table structure for table `manufactures`
--

CREATE TABLE `manufactures` (
  `manufacturer_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `manufactures` (`manufacturer_id`, `item_id`) VALUES
(1,1),
(2,2);
--
-- Table structure for table `provides`
--

CREATE TABLE `provides` (
  `manufacturer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `provides` (`manufacturer_id`, `supplier_id`) VALUES
(1,1),
(2,2);
--
-- Table structure for table `purchaseathrough`
--

CREATE TABLE `purchaseathrough` (
  `item_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_ordered` date DEFAULT NULL,
  `date_acquired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `purchaseathrough` (`item_id`, `supplier_id`, `date_ordered`, `date_acquired`) VALUES
(1,1, '2025-04-01', '2025-04-05'),
(2,2, '2025-04-02', '2025-04-06');
--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `email`) VALUES
(1, 'ToyDistributor A', 'distA@example.com'),
(2, 'ToyWarehouse B', 'warehouseB@example.com');
--
-- Table structure for table `toyimage`
--

CREATE TABLE `toyimage` (
  `image_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_primary_image` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
INSERT INTO `toyimage` (`image_id`, `image_url`, `description`, `is_primary_image`) VALUES
(1, 'https://fastly.picsum.photos/id/2/5000/3333.jpg?hmac=_KDkqQVttXw_nM-RyJfLImIbafFrqLsuGO5YuHqD-qQ', 'Front view of teddy bear', 1),
(2, 'https://fastly.picsum.photos/id/3/5000/3333.jpg?hmac=GDjZ2uNWE3V59PkdDaOzTOuV3tPWWxJSf4fNcxu4S2g', 'Box image of lego set', 1),
(3, 'https://fastly.picsum.photos/id/7/4728/3168.jpg?hmac=c5B5tfYFM9blHHMhuu4UKmhnbZoJqrzNOP9xjkV4w3o', 'Side view of race car', 0);
--
-- Table structure for table `toyitem`
--

CREATE TABLE `toyitem` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- ----------------------------------------------------------
INSERT INTO `toyitem` (`item_id`, `name`, `description`, `brand`, `category`) VALUES
(1, 'Teddy Bear', 'A soft and cuddly teddy bear.', 'SnuggleToys', 'Stuffed Toys'),
(2, 'Lego Set', 'A 500-piece building block set.', 'BrickMakers', 'Blocks'),
(3, 'Race Car', 'A fast toy race car for kids.', 'ZoomWheels', 'Cars');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `has`
--
ALTER TABLE `has`
  ADD KEY `item_id` (`item_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indexes for table `manufactures`
--
ALTER TABLE `manufactures`
  ADD KEY `manufacturer_id` (`manufacturer_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `provides`
--
ALTER TABLE `provides`
  ADD PRIMARY KEY (`manufacturer_id`,`supplier_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `purchaseathrough`
--
ALTER TABLE `purchaseathrough`
  ADD PRIMARY KEY (`item_id`,`supplier_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `toyimage`
--
ALTER TABLE `toyimage`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `toyitem`
--
ALTER TABLE `toyitem`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toyimage`
--
ALTER TABLE `toyimage`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toyitem`
--
ALTER TABLE `toyitem`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `has`
--
ALTER TABLE `has`
  ADD CONSTRAINT `has_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `toyitem` (`item_id`),
  ADD CONSTRAINT `has_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `toyimage` (`image_id`);

--
-- Constraints for table `manufactures`
--
ALTER TABLE `manufactures`
  ADD CONSTRAINT `manufactures_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`manufacturer_id`),
  ADD CONSTRAINT `manufactures_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `toyitem` (`item_id`);

--
-- Constraints for table `provides`
--
ALTER TABLE `provides`
  ADD CONSTRAINT `provides_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`manufacturer_id`),
  ADD CONSTRAINT `provides_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `purchaseathrough`
--
ALTER TABLE `purchaseathrough`
  ADD CONSTRAINT `purchaseathrough_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `toyitem` (`item_id`),
  ADD CONSTRAINT `purchaseathrough_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
