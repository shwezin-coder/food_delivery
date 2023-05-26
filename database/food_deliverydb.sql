-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2023 at 04:47 AM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `deleted_at` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `deleted_at`) VALUES
(1, 'desserts1', 1),
(2, 'Breakfast', 0),
(3, 'Lunch', 1),
(4, 'Cuisine', 0),
(5, 'Chinese', 0),
(6, 'Japanese', 0),
(7, 'Korean', 0),
(8, 'Thai', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int NOT NULL,
  `menu_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `noofitems` int NOT NULL,
  `image` text NOT NULL,
  `category_id` int NOT NULL,
  `price` float NOT NULL,
  `deleted_at` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `noofitems`, `image`, `category_id`, `price`, `deleted_at`) VALUES
(1, 'Song John Kii', 3, 'trashidea.png', 2, 30, 1),
(2, 'Kyay Oh Khout Swel ', 10, 'blog_up_child_step_3.png', 2, 5000, 1),
(3, 'Peaking Duck ', 10, 'peaking_duck.jpg', 5, 20000, 0),
(4, 'Vermicelli with duck blood ', 10, 'vermicelli_with_duck_blood.jpg', 5, 10000, 0),
(5, 'Fish Lemon', 10, 'steamed_fish_head_with_chop_bell_pepper.jpg', 4, 10000, 0),
(6, 'KungPao Chicken', 10, 'kungpao_chicken.jpg', 5, 10000, 0),
(7, 'Dumplings', 10, 'dumplings.jpg', 5, 7500, 0),
(8, 'Vegan Mapo Tofu', 10, 'vegan_mapo_tofu.jpg', 5, 10000, 0),
(9, 'Fried Noddles', 10, 'myanmar_noodle_fried.jpg', 4, 10000, 0),
(10, 'Vermicelli Fried ', 10, 'vermicelli.jpg', 5, 10000, 0),
(11, 'Papaya Salad', 10, 'Papaya Salad.jpg', 4, 4500, 0),
(12, 'Shrimp Tempura', 10, 'shrimp-tempura-recipe-8.jpg', 4, 10000, 0),
(13, 'Mar Lar Xiang Kuo', 10, 'mar lar xiang kuo.jpg', 4, 15000, 0),
(14, 'Mar lar Curry', 10, 'marlarcurry.jpg', 4, 10000, 0),
(15, 'Thai Pork Fried Rice', 10, 'THai Pork Fried Rice.jpg', 2, 5000, 0),
(16, 'Mont Hin Gar', 10, 'Mont Hin Gar.jpg', 2, 4500, 0),
(17, 'Kyay Oh', 10, 'kyay_oh.jpg', 2, 7500, 0),
(18, 'Kyay Oh Si Chat', 10, 'kyay_oh_si_chat.jpg', 2, 7500, 0),
(19, 'Shan Noodles', 10, 'Shan Noodle.jpg', 2, 5000, 0),
(20, 'Kaw Yay Khouk Swel ', 10, '1200px-Kaw_yay_khauk_swe.jpg', 2, 5000, 0),
(21, 'Sushi', 20, 'sushi.jpg', 6, 40000, 0),
(22, 'Bibimbap', 20, 'bibimbap.jpg', 7, 7500, 0),
(23, 'Thai Pad', 10, 'Authentic-Pad-Thai_square-1908.jpg', 8, 10000, 0),
(24, 'Nan Gyi Thote', 20, 'nan gyi thoke.jpg', 2, 4500, 0),
(25, 'Samusa Soup', 20, 'Burmese-Samosa-Soup-2.jpg', 2, 4500, 0),
(26, 'Pouk Si', 20, 'pouk si.jpg', 2, 2500, 0),
(27, 'Dim Sum Set', 20, 'DimsumShutterstock.jpg', 2, 25000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `image` text NOT NULL,
  `quantity` int NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `menu_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '1 => order,\r\n0 => not yet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_carts`
--

INSERT INTO `shopping_carts` (`id`, `user_id`, `menu_name`, `price`, `image`, `quantity`, `category_name`, `menu_id`, `status`) VALUES
(26, 4, 'Bibimbap', 7500, 'bibimbap.jpg', 4, 'Korean', 22, 0),
(27, 4, 'Kaw Yay Khouk Swel ', 5000, '1200px-Kaw_yay_khauk_swe.jpg', 3, 'Breakfast', 20, 0),
(28, 4, 'Kyay Oh Si Chat', 7500, 'kyay_oh_si_chat.jpg', 3, 'Breakfast', 18, 0),
(29, 4, 'Thai Pork Fried Rice', 5000, 'THai Pork Fried Rice.jpg', 3, 'Breakfast', 15, 0),
(30, 4, 'Thai Pad', 10000, 'Authentic-Pad-Thai_square-1908.jpg', 5, 'Thai', 23, 0),
(31, 4, 'KungPao Chicken', 10000, 'kungpao_chicken.jpg', 4, 'Chinese', 6, 0);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
