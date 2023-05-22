-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2023 at 04:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_deliverydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int NOT NULL COMMENT '1 => admin,\r\n2 => staff\r\n3 => customer\r\n',
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL,
  `deleted_at` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `phone_number`, `address`, `password`, `deleted_at`) VALUES
(4, 'Thazin', 3, 'thazin123@gmail.com', '09422715702', 'Yangon', '$2y$10$ti/0LKXQgOe.Vau4oo1lqu76Qf5lXo1lkPdUOqFE5HDPQE0lWuh/K', 0),
(5, 'admin', 1, 'admin@gmail.com', '09422715702', 'Yangon', '$2y$10$ti/0LKXQgOe.Vau4oo1lqu76Qf5lXo1lkPdUOqFE5HDPQE0lWuh/K', 0),
(6, 'jahopakico', 2, 'darik@mailinator.com', '+1 (499) 303-9235', 'Cambodia', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 0),
(7, 'Selena Gomez3', 3, 'selena123@gmail.com', '093452435233', 'Okpo, Bago', '$2y$10$8xrk4x9Ovr4nO8cqnRDxpO3xnrWXB1CxC3vSNGj5P4usogGmFvEgm', 0),
(8, 'nenizaze2', 2, 'tujapiqoqi@mailinator.com', '+1 (786) 301-30072', 'Eos quis et neque i 1', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
