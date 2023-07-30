-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 30, 2023 at 05:02 PM
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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int NOT NULL,
  `location_range` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `fees` int NOT NULL,
  `deleted_at` int NOT NULL DEFAULT '0' COMMENT '0 => not\r\n1 => deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_range`, `duration`, `fees`, `deleted_at`) VALUES
(1, 'Hledan To Sanchaung', '35 minutes', 1500, 0),
(2, 'Myay Ni Gone To Bo Ta Htaung', '40 minutes ', 2000, 0),
(3, 'Shwe Pyi Tha to Hledan', '1 hour 30 minutes', 2500, 0);

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `delivery_id` int NOT NULL,
  `order_information` json NOT NULL,
  `delivered_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `special_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `order_status` int NOT NULL DEFAULT '0' COMMENT '0 => pending,\r\n1 => processing,\r\n2 => delivered',
  `deleted_at` int NOT NULL DEFAULT '0',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `delivery_id`, `order_information`, `delivered_address`, `special_note`, `order_status`, `deleted_at`, `order_date`) VALUES
(2, 4, 9, '[{\"id\": \"26\", \"price\": \"7500\", \"total\": \"37500\", \"quantity\": \"5\", \"menu_name\": \"Bibimbap\"}, {\"id\": \"27\", \"price\": \"5000\", \"total\": \"15000\", \"quantity\": \"3\", \"menu_name\": \"Kaw Yay Khouk Swel \"}, {\"id\": \"28\", \"price\": \"7500\", \"total\": \"22500\", \"quantity\": \"3\", \"menu_name\": \"Kyay Oh Si Chat\"}, {\"id\": \"29\", \"price\": \"5000\", \"total\": \"15000\", \"quantity\": \"3\", \"menu_name\": \"Thai Pork Fried Rice\"}, {\"id\": \"30\", \"price\": \"10000\", \"total\": \"50000\", \"quantity\": \"5\", \"menu_name\": \"Thai Pad\"}, {\"id\": \"31\", \"price\": \"10000\", \"total\": \"40000\", \"quantity\": \"4\", \"menu_name\": \"KungPao Chicken\"}]', '', '', 0, 0, '2023-05-31 08:20:38'),
(3, 10, 9, '[{\"id\": \"33\", \"price\": \"25000\", \"total\": \"25000\", \"quantity\": \"1\", \"menu_name\": \"Dim Sum Set\"}]', '', '', 0, 0, '2023-07-30 14:47:19'),
(4, 10, 9, '[{\"id\": \"34\", \"price\": \"25000\", \"total\": \"75000\", \"quantity\": \"3\", \"menu_name\": \"Dim Sum Set\"}]', '', '', 0, 0, '2023-07-30 14:54:22'),
(5, 10, 9, '[{\"id\": \"35\", \"price\": \"2500\", \"total\": \"5000\", \"quantity\": \"2\", \"menu_name\": \"Pouk Si\"}]', '', '', 0, 0, '2023-07-30 14:55:08'),
(6, 10, 9, '[{\"id\": \"36\", \"price\": \"4500\", \"total\": \"13500\", \"quantity\": \"3\", \"menu_name\": \"Samusa Soup\"}]', '', '', 0, 0, '2023-07-30 15:00:09'),
(7, 10, 9, '[{\"id\": \"37\", \"price\": \"4500\", \"total\": \"18000\", \"quantity\": \"4\", \"menu_name\": \"Samusa Soup\"}]', '', '', 0, 0, '2023-07-30 15:03:29'),
(8, 10, 9, '[{\"id\": \"38\", \"price\": \"4500\", \"total\": \"13500\", \"quantity\": \"3\", \"menu_name\": \"Nan Gyi Thote\"}]', '', '', 0, 0, '2023-07-30 15:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `paymenttype_id` int NOT NULL,
  `transaction_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `paymenttype_id`, `transaction_no`, `created_at`, `amount`) VALUES
(1, 6, 1, '12345', '2023-07-30 15:00:09', 14000),
(2, 8, 1, '12345', '2023-07-30 15:04:17', 13500);

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `deleted_at` int NOT NULL DEFAULT '0' COMMENT '0 => not\r\n1 => deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `type`, `deleted_at`) VALUES
(1, 'Kbz pay', 0),
(2, 'Aya Pay', 0),
(3, 'Wave Pay', 0),
(4, 'CB Pay', 0);

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
  `special_note` text NOT NULL,
  `menu_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '1 => order,\r\n0 => not yet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_carts`
--

INSERT INTO `shopping_carts` (`id`, `user_id`, `menu_name`, `price`, `image`, `quantity`, `category_name`, `special_note`, `menu_id`, `status`) VALUES
(26, 4, 'Bibimbap', 7500, 'bibimbap.jpg', 5, 'Korean', '', 22, 1),
(27, 4, 'Kaw Yay Khouk Swel ', 5000, '1200px-Kaw_yay_khauk_swe.jpg', 3, 'Breakfast', '', 20, 1),
(28, 4, 'Kyay Oh Si Chat', 7500, 'kyay_oh_si_chat.jpg', 3, 'Breakfast', '', 18, 1),
(29, 4, 'Thai Pork Fried Rice', 5000, 'THai Pork Fried Rice.jpg', 3, 'Breakfast', '', 15, 1),
(30, 4, 'Thai Pad', 10000, 'Authentic-Pad-Thai_square-1908.jpg', 5, 'Thai', '', 23, 1),
(31, 4, 'KungPao Chicken', 10000, 'kungpao_chicken.jpg', 4, 'Chinese', '', 6, 1),
(32, 5, 'Dim Sum Set', 25000, 'DimsumShutterstock.jpg', 3, 'Breakfast', 'Pouk Si - 1 Set\nShrimp - 1 Set\nSpirullina - 1 Set', 27, 0),
(33, 10, 'Dim Sum Set', 25000, 'DimsumShutterstock.jpg', 1, 'Breakfast', '', 27, 1),
(34, 10, 'Dim Sum Set', 25000, 'DimsumShutterstock.jpg', 3, 'Breakfast', '', 27, 1),
(35, 10, 'Pouk Si', 2500, 'pouk si.jpg', 2, 'Breakfast', '', 26, 1),
(36, 10, 'Samusa Soup', 4500, 'Burmese-Samosa-Soup-2.jpg', 3, 'Breakfast', '', 25, 1),
(37, 10, 'Samusa Soup', 4500, 'Burmese-Samosa-Soup-2.jpg', 4, 'Breakfast', '', 25, 1),
(38, 10, 'Nan Gyi Thote', 4500, 'nan gyi thoke.jpg', 3, 'Breakfast', '', 24, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int NOT NULL COMMENT '1 => admin,\r\n2 => staff,\r\n3 => customer,\r\n4 => delivery\r\n',
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL,
  `delivery_status` int NOT NULL DEFAULT '0' COMMENT '0 => available,\r\n1 => unavailable',
  `deleted_at` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `phone_number`, `address`, `password`, `delivery_status`, `deleted_at`) VALUES
(4, 'Thazin', 3, 'thazin123@gmail.com', '09422715702', 'Yangon', '$2y$10$ti/0LKXQgOe.Vau4oo1lqu76Qf5lXo1lkPdUOqFE5HDPQE0lWuh/K', 0, 0),
(5, 'admin', 1, 'admin@gmail.com', '09422715702', 'Yangon', '$2y$10$ti/0LKXQgOe.Vau4oo1lqu76Qf5lXo1lkPdUOqFE5HDPQE0lWuh/K', 0, 0),
(6, 'jahopakico1', 4, 'darik@mailinator.com', '+1 (499) 303-9235', 'Cambodia', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 1, 0),
(7, 'Selena Gomez', 3, 'selena123@gmail.com', '093452435233', 'Okpo, Bago', '$2y$10$8xrk4x9Ovr4nO8cqnRDxpO3xnrWXB1CxC3vSNGj5P4usogGmFvEgm', 0, 0),
(8, 'nenizaze2', 2, 'tujapiqoqi@mailinator.com', '+1 (786) 301-30072', 'Eos quis et neque i 1', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 0, 1),
(9, 'verewakequ', 4, 'xowygarywy@mailinator.com', '+1 (987) 982-3634', 'Cupiditate eu except', 'ac748cb38ff28d1ea98458b16695739d7e90f22d', 0, 0),
(10, 'Song John Kii', 3, 'Sjk123@gmail.com', '09422715702', 'Okpho', '$2y$10$0itlN3fmL/6VwTPnjE2rRedeSWFnmUtVhkaDpZNo4V3yK0jJ0UfnW', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
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
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
