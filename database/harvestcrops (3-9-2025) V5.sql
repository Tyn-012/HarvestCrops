-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 09:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `harvestcrops`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(100) NOT NULL,
  `Category_Desc` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `Category_Desc`, `created_at`, `modified_at`) VALUES
(121, 'Fruits', 'Apples, Watermelon, Banana etc.', '2025-03-01 19:58:59', '2025-03-01 19:58:59'),
(122, 'Grains', 'Rice, Wheat etc.', '2025-03-01 19:59:52', '2025-03-01 19:59:52'),
(123, 'Vegetables', 'Cabbage, Lettuce etc.', '2025-03-01 20:00:33', '2025-03-01 20:00:33'),
(124, 'Vegetables', 'Cabbage, Lettuce etc.', '2025-03-01 20:01:09', '2025-03-01 20:01:09'),
(125, 'Vegetables', 'Cabbage, Lettuce etc.', '2025-03-01 20:01:46', '2025-03-01 20:01:46'),
(126, 'Vegetables', 'Cabbage, Lettuce etc.', '2025-03-01 20:02:39', '2025-03-01 20:02:39'),
(127, 'Vegetables', 'Cabbage, Lettuce etc.', '2025-03-01 20:03:28', '2025-03-01 20:03:28'),
(128, 'Fruits', 'Apples, Watermelon, Banana etc.', '2025-03-01 20:04:05', '2025-03-01 20:04:05'),
(129, 'Fruits', 'Apples, Watermelon, Banana etc.', '2025-03-01 20:04:33', '2025-03-01 20:04:33'),
(130, 'Fruits', 'Apples, Watermelon, Banana etc.', '2025-03-01 20:05:00', '2025-03-01 20:05:00'),
(131, 'Fruits', 'Apples, Watermelon, Banana etc.', '2025-03-01 20:05:38', '2025-03-01 20:05:38'),
(132, 'Fruits', 'Apples, Watermelon, Banana etc.', '2025-03-01 20:06:16', '2025-03-01 20:06:16'),
(133, 'Rootcrops', 'Potatoes, Carrots, Sweet Potatoes etc.', '2025-03-01 20:06:55', '2025-03-01 20:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `farmer_details`
--

CREATE TABLE `farmer_details` (
  `Farmer_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `farm_name` varchar(255) DEFAULT NULL,
  `farm_size` decimal(10,2) DEFAULT NULL,
  `farm_size_unit` enum('hectares','acres') DEFAULT 'hectares',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer_details`
--

INSERT INTO `farmer_details` (`Farmer_ID`, `User_ID`, `farm_name`, `farm_size`, `farm_size_unit`, `created_at`, `modified_at`) VALUES
(1, 1, NULL, NULL, 'hectares', '2025-02-23 11:48:42', '2025-02-23 11:48:42'),
(5, 5, NULL, NULL, 'hectares', '2025-03-01 15:54:55', '2025-03-01 15:54:55');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Inventory_ID` int(11) NOT NULL,
  `harvest_date` date DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Inventory_ID`, `harvest_date`, `quantity`, `created_at`, `modified_at`) VALUES
(120, '2025-03-02', 90.00, '2025-03-01 19:58:59', '2025-03-01 20:17:24'),
(121, '2025-03-05', 150.00, '2025-03-01 19:59:52', '2025-03-01 19:59:52'),
(122, '2025-03-02', 30.00, '2025-03-01 20:00:33', '2025-03-01 20:17:28'),
(123, '2025-03-01', 100.00, '2025-03-01 20:01:09', '2025-03-01 20:01:09'),
(124, '2025-03-03', 50.00, '2025-03-01 20:01:46', '2025-03-01 20:17:34'),
(125, '2025-03-02', 130.00, '2025-03-01 20:02:39', '2025-03-01 20:02:39'),
(126, '2025-03-03', 60.00, '2025-03-01 20:03:28', '2025-03-01 20:03:28'),
(127, '2025-03-03', 100.00, '2025-03-01 20:04:05', '2025-03-01 20:04:05'),
(128, '2025-03-04', 500.00, '2025-03-01 20:04:33', '2025-03-01 20:04:33'),
(129, '2025-03-13', 40.00, '2025-03-01 20:05:00', '2025-03-01 20:05:00'),
(130, '2025-03-28', 250.00, '2025-03-01 20:05:39', '2025-03-01 20:05:39'),
(131, '2025-03-18', 15.00, '2025-03-01 20:06:16', '2025-03-01 20:17:50'),
(132, '2025-03-10', 85.00, '2025-03-01 20:06:55', '2025-03-01 20:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL CHECK (`total` >= 0),
  `order_status` enum('pending','processing','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_ID`, `user_ID`, `total`, `order_status`, `created_at`, `modified_at`, `seller_id`) VALUES
(132, 6, 10.00, 'pending', '2025-03-01 20:17:24', '2025-03-01 20:17:24', 5),
(133, 6, 20.00, 'pending', '2025-03-01 20:17:28', '2025-03-01 20:17:28', 5),
(134, 6, 50.00, 'pending', '2025-03-01 20:17:34', '2025-03-01 20:17:34', 5),
(135, 6, 15.00, 'pending', '2025-03-01 20:17:43', '2025-03-01 20:17:43', 1),
(136, 6, 15.00, 'pending', '2025-03-01 20:17:50', '2025-03-01 20:17:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `orderedItem_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`orderedItem_ID`, `order_ID`, `product_ID`, `quantity`, `created_at`, `modified_at`) VALUES
(122, 132, 123, 10, '2025-03-01 20:17:24', '2025-03-01 20:17:24'),
(123, 133, 125, 20, '2025-03-01 20:17:28', '2025-03-01 20:17:28'),
(124, 134, 127, 50, '2025-03-01 20:17:34', '2025-03-01 20:17:34'),
(125, 135, 135, 15, '2025-03-01 20:17:43', '2025-03-01 20:17:43'),
(126, 136, 134, 15, '2025-03-01 20:17:50', '2025-03-01 20:17:50');

--
-- Triggers `order_item`
--
DELIMITER $$
CREATE TRIGGER `after_order_delete` AFTER DELETE ON `order_item` FOR EACH ROW BEGIN
  -- Declare a variable to store the current inventory quantity before the update
  DECLARE current_stock_quantity INT;

  -- Fetch the current inventory quantity before the update (before deletion)
  SELECT quantity INTO current_stock_quantity
  FROM inventory
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = OLD.product_ID);

  -- Restore the quantity back to inventory after deletion
  UPDATE inventory
  SET quantity = quantity + OLD.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = OLD.product_ID);

  -- Log the quantity reduction in Product_Quantity_Updates table
  INSERT INTO Product_Quantity_Updates (Product_ID, stock_quantity, sold_quantity)
  VALUES (OLD.product_ID, current_stock_quantity, -OLD.quantity);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_order_insert` AFTER INSERT ON `order_item` FOR EACH ROW BEGIN
  -- Declare a variable to store the current inventory quantity
  DECLARE current_stock_quantity INT;

  -- Fetch the current inventory quantity before the update
  SELECT quantity INTO current_stock_quantity
  FROM inventory
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = NEW.product_ID);

  -- Update inventory: Decrease the inventory quantity based on the order
  UPDATE inventory
  SET quantity = quantity - NEW.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = NEW.product_ID);

  -- Log sold quantity in Product_Quantity_Updates table
  INSERT INTO Product_Quantity_Updates (Product_ID, stock_quantity, sold_quantity)
  VALUES (NEW.product_ID, current_stock_quantity, NEW.quantity);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_order_update` AFTER UPDATE ON `order_item` FOR EACH ROW BEGIN
  -- Declare a variable to store the current inventory quantity
  DECLARE current_stock_quantity INT;

  -- Capture the current stock quantity before any updates
  SELECT quantity INTO current_stock_quantity
  FROM inventory
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = OLD.product_ID);

  -- Restore the previous quantity to inventory (in case of a rollback or update)
  UPDATE inventory
  SET quantity = quantity + OLD.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = OLD.product_ID);

  -- Deduct the new quantity from inventory after the update
  UPDATE inventory
  SET quantity = quantity - NEW.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = NEW.product_ID);

  -- Log the quantity change in the Product_Quantity_Updates table
  INSERT INTO Product_Quantity_Updates (Product_ID, stock_quantity, sold_quantity)
  VALUES (NEW.product_ID, current_stock_quantity, NEW.quantity - OLD.quantity);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_order_insert` BEFORE INSERT ON `order_item` FOR EACH ROW BEGIN
  DECLARE available_quantity DECIMAL(10,2);
  
  SELECT quantity INTO available_quantity
  FROM inventory
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = NEW.product_ID);
  
  IF available_quantity < NEW.quantity THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Not enough inventory available';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `history_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `status` enum('pending','processing','cancelled','completed') DEFAULT NULL,
  `status_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_details`
--

CREATE TABLE `organization_details` (
  `Organization_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Organization_Name` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(20) DEFAULT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_details`
--

INSERT INTO `organization_details` (`Organization_ID`, `User_ID`, `Organization_Name`, `Contact_Number`, `Email_Address`, `created_at`, `modified_at`) VALUES
(4, 4, 'Department of Agriculture Tanza', '09589667859', 'DOA_Tanza@gmail.com', '2025-03-01 14:02:54', '2025-03-01 14:05:07'),
(7, 7, 'Department of Agriculture Trece Martires Cavite', '09587889583', 'DOA_Trece@gmail.com', '2025-03-01 15:58:14', '2025-03-01 16:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `organization_notice`
--

CREATE TABLE `organization_notice` (
  `Notice_ID` int(11) NOT NULL,
  `Organization_ID` int(11) NOT NULL,
  `Notice_Title` varchar(255) NOT NULL,
  `Notice_Content` text NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Notice_Schedule` datetime DEFAULT NULL,
  `Organization_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_notice`
--

INSERT INTO `organization_notice` (`Notice_ID`, `Organization_ID`, `Notice_Title`, `Notice_Content`, `Created_At`, `Notice_Schedule`, `Organization_Name`) VALUES
(18, 4, 'National Agricultural Innovation Summit 2025', ' a two-day event focusing on the latest agricultural technologies and sustainable farming practices. The summit will feature expert panels, workshops, and exhibitions. Key topics include digital farming, sustainability, and government funding programs for farmers.', '2025-03-01 14:12:02', '2025-03-07 15:12:00', 'Department of Agriculture Tanza'),
(19, 4, 'AgriTech Expo 2025', 'Explore the latest in agricultural technology at the AgriTech Expo 2025. The event will feature innovations in farming tools, smart irrigation systems, drones for agriculture, and much more. A must-attend for anyone involved in modern agriculture.', '2025-03-01 14:14:37', '2025-03-06 12:16:00', 'Department of Agriculture Tanza'),
(20, 4, 'Farmers\' Welfare Forum', 'This forum aims to discuss the pressing issues farmers face today, from market access to financial support. Government representatives, agricultural experts, and farmers will convene to find sustainable solutions for the agricultural sector.', '2025-03-01 14:15:11', '2025-03-23 08:40:00', 'Department of Agriculture Tanza'),
(21, 4, 'Sustainable Farming Practices Workshop', 'Learn how to incorporate sustainable farming practices into your agricultural operations. This hands-on workshop will cover topics like organic farming, soil conservation, and water management.', '2025-03-01 14:15:33', '2025-03-01 15:15:00', 'Department of Agriculture Tanza'),
(22, 4, 'National Rice Festival 2025', 'Celebrate the country\'s staple food, rice, with various cultural shows, cooking contests, and exhibits. Farmers will also get a chance to showcase their best rice varieties, with rewards for the top growers.', '2025-03-01 14:15:56', '2025-03-08 13:18:00', 'Department of Agriculture Tanza'),
(23, 4, 'Agri-Entrepreneurship Forum 2025', 'This forum is designed to help aspiring and current agricultural entrepreneurs navigate the complexities of starting and growing an agribusiness. Learn about financial strategies, marketing, and government support.', '2025-03-01 14:16:19', '2025-03-14 12:18:00', 'Department of Agriculture Tanza'),
(24, 7, 'DOA Farming Seminar Notice', 'Join us for a comprehensive DOA Farming Seminar focusing on sustainable farming practices, crop rotation techniques, and modern agricultural technologies. Our expert speakers will provide valuable insights into maximizing yields and improving farm productivity while maintaining environmental balance.', '2025-03-01 16:14:38', '2025-03-02 12:14:00', 'Department of Agriculture Trece Martires Cavite');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `reset_id` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `token_expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `SubCategory_ID` int(11) NOT NULL,
  `Inventory_ID` int(11) NOT NULL,
  `Product_Name` varchar(100) NOT NULL,
  `Product_Desc` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `average_rating` decimal(3,1) DEFAULT NULL,
  `shelf_life` int(11) DEFAULT NULL,
  `shelf_life_unit` enum('days','weeks','months') DEFAULT 'days',
  `is_organic` tinyint(1) DEFAULT 0,
  `bulk_available` tinyint(1) DEFAULT 0,
  `bulk_minimum_quantity` int(11) DEFAULT NULL,
  `sold_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Category_ID`, `SubCategory_ID`, `Inventory_ID`, `Product_Name`, `Product_Desc`, `product_price`, `average_rating`, `shelf_life`, `shelf_life_unit`, `is_organic`, `bulk_available`, `bulk_minimum_quantity`, `sold_quantity`, `created_at`, `modified_at`, `User_ID`) VALUES
(123, 121, 121, 120, 'Banana', 'Fresh', 120.00, NULL, 2, 'weeks', 1, 0, NULL, 0, '2025-03-01 19:58:59', '2025-03-01 19:58:59', 5),
(124, 122, 122, 121, 'Wheat', 'To be harvested', 60.00, NULL, 6, 'months', 1, 1, NULL, 0, '2025-03-01 19:59:52', '2025-03-01 19:59:52', 5),
(125, 123, 123, 122, 'Corn', 'Fresh', 100.00, NULL, 10, 'days', 1, 0, NULL, 0, '2025-03-01 20:00:33', '2025-03-01 20:00:33', 5),
(126, 124, 124, 123, 'Onion', 'Fresh', 100.00, NULL, 2, 'weeks', 0, 0, NULL, 0, '2025-03-01 20:01:09', '2025-03-01 20:01:09', 5),
(127, 125, 125, 124, 'Jalapeno', 'Fresh', 130.00, NULL, 7, 'days', 0, 0, NULL, 0, '2025-03-01 20:01:46', '2025-03-01 20:01:46', 5),
(128, 126, 126, 125, 'Tomato', 'Fresh', 130.00, NULL, 7, 'days', 1, 0, NULL, 0, '2025-03-01 20:02:39', '2025-03-01 20:02:39', 1),
(129, 127, 127, 126, 'Cucumber', 'Fresh', 80.00, NULL, 8, 'days', 1, 0, NULL, 0, '2025-03-01 20:03:28', '2025-03-01 20:03:28', 1),
(130, 128, 128, 127, 'Grapes', 'Fresh', 150.00, NULL, 2, 'weeks', 1, 1, NULL, 0, '2025-03-01 20:04:05', '2025-03-01 20:04:05', 1),
(131, 129, 129, 128, 'Mango', 'Fresh', 230.00, NULL, 10, 'days', 1, 0, NULL, 0, '2025-03-01 20:04:33', '2025-03-01 20:04:33', 1),
(132, 130, 130, 129, 'Guava', 'Fresh', 120.00, NULL, 2, 'weeks', 1, 0, NULL, 0, '2025-03-01 20:05:00', '2025-03-01 20:05:00', 1),
(133, 131, 131, 130, 'Orange', 'Fresh', 200.00, NULL, 7, 'days', 1, 0, NULL, 0, '2025-03-01 20:05:39', '2025-03-01 20:05:39', 1),
(134, 132, 132, 131, 'Watermelon', 'Fresh', 320.00, NULL, 2, 'weeks', 1, 0, NULL, 0, '2025-03-01 20:06:16', '2025-03-01 20:06:16', 1),
(135, 133, 133, 132, 'Carrot', 'Fresh', 90.00, NULL, 2, 'weeks', 1, 0, NULL, 0, '2025-03-01 20:06:55', '2025-03-01 20:06:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_ID`, `Product_ID`, `image_url`, `created_at`) VALUES
(114, 123, '../images/product_uploads/img_67c36701cc1569.97683583.jpg', '2025-03-01 19:58:59'),
(115, 124, '../images/product_uploads/img_67c36735826a49.92920050.jpg', '2025-03-01 19:59:52'),
(116, 125, '../images/product_uploads/img_67c36760542689.20955711.jpg', '2025-03-01 20:00:33'),
(117, 126, '../images/product_uploads/img_67c36784219640.64904336.jpg', '2025-03-01 20:01:09'),
(118, 127, '../images/product_uploads/img_67c367a9a0bd14.94189034.jpg', '2025-03-01 20:01:46'),
(119, 128, '../images/product_uploads/img_67c367de603d94.18508893.jpg', '2025-03-01 20:02:39'),
(120, 129, '../images/product_uploads/img_67c3680e41b905.41716891.jpg', '2025-03-01 20:03:28'),
(121, 130, '../images/product_uploads/img_67c368337cd288.17236016.jpg', '2025-03-01 20:04:05'),
(122, 131, '../images/product_uploads/img_67c3684f9c0be9.40148184.jpg', '2025-03-01 20:04:33'),
(123, 132, '../images/product_uploads/img_67c3686b64f371.19578627.jpg', '2025-03-01 20:05:00'),
(124, 133, '../images/product_uploads/img_67c36891b2a038.40061934.jpg', '2025-03-01 20:05:39'),
(125, 134, '../images/product_uploads/img_67c368b779a863.16349101.jpg', '2025-03-01 20:06:16'),
(126, 135, '../images/product_uploads/img_67c368ddf012c5.97564842.jpg', '2025-03-01 20:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_qa`
--

CREATE TABLE `product_qa` (
  `qa_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `is_answered` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `answered_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_quantity_updates`
--

CREATE TABLE `product_quantity_updates` (
  `Update_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `stock_quantity` decimal(10,2) DEFAULT 0.00,
  `sold_quantity` decimal(10,2) DEFAULT 0.00,
  `update_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_quantity_updates`
--

INSERT INTO `product_quantity_updates` (`Update_ID`, `Product_ID`, `stock_quantity`, `sold_quantity`, `update_date`) VALUES
(254, 123, 100.00, 10.00, '2025-03-01 20:17:24'),
(255, 125, 50.00, 20.00, '2025-03-01 20:17:28'),
(256, 127, 100.00, 50.00, '2025-03-01 20:17:34'),
(257, 135, 100.00, 15.00, '2025-03-01 20:17:43'),
(258, 134, 30.00, 15.00, '2025-03-01 20:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `review_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `helpful_votes` int(11) DEFAULT 0,
  `unhelpful_votes` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `tag_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `tag_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tag_relation`
--

CREATE TABLE `product_tag_relation` (
  `Product_ID` int(11) NOT NULL,
  `tag_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_ID`, `User_ID`, `Product_ID`, `quantity`, `added_at`) VALUES
(65, 6, 123, 10, '2025-03-01 20:17:24'),
(66, 6, 125, 20, '2025-03-01 20:17:28'),
(67, 6, 127, 50, '2025-03-01 20:17:34'),
(68, 6, 135, 15, '2025-03-01 20:17:43'),
(69, 6, 134, 15, '2025-03-01 20:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `SubCategory_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `SubCategory_Name` varchar(100) NOT NULL,
  `SubCategory_Desc` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`SubCategory_ID`, `Category_ID`, `SubCategory_Name`, `SubCategory_Desc`, `created_at`, `modified_at`) VALUES
(121, 121, 'Fruits', NULL, '2025-03-01 19:58:59', '2025-03-01 19:58:59'),
(122, 122, 'Grains', NULL, '2025-03-01 19:59:52', '2025-03-01 19:59:52'),
(123, 123, 'Vegetables', NULL, '2025-03-01 20:00:33', '2025-03-01 20:00:33'),
(124, 124, 'Vegetables', NULL, '2025-03-01 20:01:09', '2025-03-01 20:01:09'),
(125, 125, 'Vegetables', NULL, '2025-03-01 20:01:46', '2025-03-01 20:01:46'),
(126, 126, 'Vegetables', NULL, '2025-03-01 20:02:39', '2025-03-01 20:02:39'),
(127, 127, 'Vegetables', NULL, '2025-03-01 20:03:28', '2025-03-01 20:03:28'),
(128, 128, 'Fruits', NULL, '2025-03-01 20:04:05', '2025-03-01 20:04:05'),
(129, 129, 'Fruits', NULL, '2025-03-01 20:04:33', '2025-03-01 20:04:33'),
(130, 130, 'Fruits', NULL, '2025-03-01 20:05:00', '2025-03-01 20:05:00'),
(131, 131, 'Fruits', NULL, '2025-03-01 20:05:38', '2025-03-01 20:05:38'),
(132, 132, 'Fruits', NULL, '2025-03-01 20:06:16', '2025-03-01 20:06:16'),
(133, 133, 'Rootcrops', NULL, '2025-03-01 20:06:55', '2025-03-01 20:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `User_FirstName` varchar(60) NOT NULL,
  `User_MiddleName` varchar(10) DEFAULT NULL,
  `User_LastName` varchar(60) NOT NULL,
  `User_BirthDate` date DEFAULT NULL,
  `User_Gender` set('None','Male','Female','Other') DEFAULT 'None',
  `User_EmailAddress` varchar(100) NOT NULL,
  `User_Password` varchar(64) NOT NULL,
  `User_MobileNumber` varchar(20) NOT NULL,
  `Status_ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `User_FirstName`, `User_MiddleName`, `User_LastName`, `User_BirthDate`, `User_Gender`, `User_EmailAddress`, `User_Password`, `User_MobileNumber`, `Status_ID`, `Type_ID`, `Role_ID`, `created_at`, `modified_at`, `verified`) VALUES
(1, 'John', 'Bern', 'Hip', '1980-01-02', 'Male', 'tynn1240@gmail.com', '$2y$10$1cgxiuiGdV9Br0u.eJCGi.ufQA29k1GQz10IyGJWtVEy44tQMwmO2', '09589776952', 1, 1, 1, '2025-02-23 11:48:39', '2025-03-01 14:57:28', 1),
(2, 'John ', 'Lloyd', 'Dela Cruz', '1984-01-04', 'Male', 'jlbdc14@gmail.com', '$2y$10$WoQMcnXR4VhbRZyRTbQS6eInnCSSIy8rZPghZqzuWt/.ErpdKisbO', '09589774928', 2, 2, 2, '2025-02-23 15:22:36', '2025-02-23 15:23:31', 1),
(3, 'Hue', 'Lui', 'Pin', '1985-01-08', 'Female', 'fbkbdc14@gmail.com', '$2y$10$AT0oYwjCNsDTpLH4GLHAQeutDis6OL/90d4mf7avUorFpkRauRFzS', '09487995868', 3, 3, 3, '2025-02-23 16:00:03', '2025-02-23 16:01:07', 1),
(4, 'Julie', 'Ray', 'Miles', '1983-02-02', 'Female', 'lloyd.delacruz.jldc@gmail.com', '$2y$10$n2OW7dofJpbX7z8n.GBaaum4lO2RlCeAf325gZnU3lIBAJIqraNNa', '09658229374', 4, 4, 4, '2025-03-01 14:02:50', '2025-03-01 14:03:11', 1),
(5, 'Bonnie', 'Mae', 'Fuentes', '1981-01-04', 'Female', 'TestVendor@gmail.com', '$2y$10$4HR8.AM8uhDmWQ5nRkm7F.a4zW4R26pE/VsiZiR5m4CvH3vj2tGAC', '09589668957', 5, 5, 5, '2025-03-01 15:54:52', '2025-03-01 15:58:26', 1),
(6, 'Adolfo', 'Zue', 'Saunders', '1982-01-05', 'Male', 'TestVendee@gmail.com', '$2y$10$lpElRFMsmkqnJ7r/u8mZ1..prrw/ZiThQWGuqOcb1xE693pm2wKq6', '09389557846', 6, 6, 6, '2025-03-01 15:56:14', '2025-03-01 15:58:28', 1),
(7, 'Jan', 'Stone', 'Brock', '1981-03-13', 'Male', 'TestOrg@gmail.com', '$2y$10$.QLpjJz30wa8OWH9fQvjPOuKxXW1bYTR2o9888BcrBZ96nKhkKrdi', '09589978593', 7, 7, 7, '2025-03-01 15:58:11', '2025-03-01 15:58:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `Address_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Address_Type` set('home','farm','business','other') DEFAULT 'home',
  `User_Address` varchar(255) NOT NULL,
  `Island_Group` varchar(50) NOT NULL,
  `Region` varchar(50) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Barangay` varchar(100) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`Address_ID`, `User_ID`, `Address_Type`, `User_Address`, `Island_Group`, `Region`, `City`, `Barangay`, `zip_code`, `created_at`, `modified_at`) VALUES
(1, 1, 'farm', 'Blk 2 Lot 1 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-02-23 11:48:42', '2025-02-23 11:48:42'),
(2, 2, 'other', 'Blk 4 Lot 5 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-02-23 15:22:39', '2025-02-23 15:30:04'),
(3, 3, 'home', 'Blk 8 Lot 4 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-02-23 16:00:06', '2025-02-23 16:00:06'),
(4, 4, 'business', 'Blk 4 Lot 16 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-03-01 14:02:54', '2025-03-01 14:02:54'),
(5, 5, 'farm', 'Blk 5 Lot 6 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-03-01 15:54:55', '2025-03-01 15:54:55'),
(6, 6, 'home', 'Blk 14 Lot 5 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-03-01 15:56:17', '2025-03-01 15:56:17'),
(7, 7, 'business', 'Blk 1 Lot 2 Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2025-03-01 15:58:14', '2025-03-01 15:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `Role_ID` int(11) NOT NULL,
  `Role_Name` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`Role_ID`, `Role_Name`, `created_at`, `modified_at`) VALUES
(1, 'User', '2025-02-23 11:48:39', '0000-00-00 00:00:00'),
(2, 'Admin', '2025-02-23 15:31:26', '0000-00-00 00:00:00'),
(3, 'User', '2025-02-23 16:00:03', '0000-00-00 00:00:00'),
(4, 'User', '2025-03-01 14:02:50', '0000-00-00 00:00:00'),
(5, 'User', '2025-03-01 15:54:52', '0000-00-00 00:00:00'),
(6, 'User', '2025-03-01 15:56:14', '0000-00-00 00:00:00'),
(7, 'User', '2025-03-01 15:58:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_management`
--

CREATE TABLE `user_role_management` (
  `User_ID` int(11) NOT NULL,
  `Role_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role_management`
--

INSERT INTO `user_role_management` (`User_ID`, `Role_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `Session_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `session_start` timestamp NOT NULL DEFAULT current_timestamp(),
  `session_end` timestamp NULL DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `session_status` enum('active','expired','closed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`Session_ID`, `User_ID`, `session_start`, `session_end`, `last_activity`, `session_status`, `created_at`, `modified_at`) VALUES
(1, 5, '2025-03-01 19:32:20', '2025-03-01 12:01:51', '2025-03-01 12:01:51', 'closed', '2025-03-01 19:32:20', '2025-03-01 20:01:51'),
(2, 1, '2025-03-01 20:02:04', '2025-03-01 12:13:50', '2025-03-01 12:13:50', 'closed', '2025-03-01 20:02:04', '2025-03-01 20:13:50'),
(3, 2, '2025-03-01 20:13:59', '2025-03-01 12:14:26', '2025-03-01 12:14:26', 'closed', '2025-03-01 20:13:59', '2025-03-01 20:14:26'),
(4, 6, '2025-03-01 20:14:39', '2025-03-01 12:18:09', '2025-03-01 12:18:09', 'closed', '2025-03-01 20:14:39', '2025-03-01 20:18:09'),
(5, 5, '2025-03-01 20:18:20', '2025-03-01 12:19:01', '2025-03-01 12:19:01', 'closed', '2025-03-01 20:18:20', '2025-03-01 20:19:01'),
(6, 7, '2025-03-01 20:19:11', '2025-03-01 12:24:27', '2025-03-01 12:24:27', 'closed', '2025-03-01 20:19:11', '2025-03-01 20:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE `user_status` (
  `Status_ID` int(11) NOT NULL,
  `Status_Name` set('active','suspended','deactivated') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`Status_ID`, `Status_Name`, `created_at`, `modified_at`) VALUES
(1, 'active', '2025-02-23 11:48:39', '2025-03-01 14:57:28'),
(2, 'active', '2025-02-23 15:22:36', '2025-02-23 15:24:00'),
(3, 'active', '2025-02-23 16:00:03', '2025-02-23 16:01:07'),
(4, 'active', '2025-03-01 14:02:50', '2025-03-01 14:03:11'),
(5, 'active', '2025-03-01 15:54:52', '2025-03-01 15:58:46'),
(6, 'active', '2025-03-01 15:56:14', '2025-03-01 15:58:49'),
(7, 'active', '2025-03-01 15:58:11', '2025-03-01 15:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `Type_ID` int(11) NOT NULL,
  `Type_Name` varchar(50) NOT NULL,
  `Type_Description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`Type_ID`, `Type_Name`, `Type_Description`, `created_at`, `modified_at`) VALUES
(1, 'Farmer', 'Local Farmer', '2025-02-23 11:48:39', '2025-02-23 11:48:39'),
(2, 'Admin', 'Admin', '2025-02-23 15:22:36', '2025-02-23 15:31:14'),
(3, 'Vendor', 'Local Vendor', '2025-02-23 16:00:03', '2025-02-23 16:00:03'),
(4, 'Organization', 'Agriculture Organization', '2025-03-01 14:02:50', '2025-03-01 14:02:50'),
(5, 'Farmer', 'Local Farmer', '2025-03-01 15:54:52', '2025-03-01 15:54:52'),
(6, 'Vendor', 'Local Vendor', '2025-03-01 15:56:14', '2025-03-01 15:56:14'),
(7, 'Organization', 'Agriculture Organization', '2025-03-01 15:58:11', '2025-03-01 15:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_type_management`
--

CREATE TABLE `user_type_management` (
  `User_ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type_management`
--

INSERT INTO `user_type_management` (`User_ID`, `Type_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_details`
--

CREATE TABLE `vendor_details` (
  `Vendor_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_type` enum('Retailer','Wholesaler','Distributor','Other') DEFAULT 'Other',
  `tax_id` varchar(50) DEFAULT NULL,
  `years_in_business` int(11) DEFAULT NULL,
  `product_types` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_details`
--

INSERT INTO `vendor_details` (`Vendor_ID`, `User_ID`, `business_name`, `business_type`, `tax_id`, `years_in_business`, `product_types`, `created_at`, `modified_at`) VALUES
(3, 3, NULL, 'Other', NULL, NULL, NULL, '2025-02-23 16:00:06', '2025-02-23 16:00:06'),
(6, 6, NULL, 'Other', NULL, NULL, NULL, '2025-03-01 15:56:17', '2025-03-01 15:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `verification_tokens`
--

CREATE TABLE `verification_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `farmer_details`
--
ALTER TABLE `farmer_details`
  ADD PRIMARY KEY (`Farmer_ID`),
  ADD UNIQUE KEY `idx_user_id` (`User_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Inventory_ID`),
  ADD KEY `idx_harvest_date` (`harvest_date`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_ID`),
  ADD KEY `idx_user_orders` (`user_ID`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `Seller_ID` (`seller_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`orderedItem_ID`),
  ADD KEY `order_ID` (`order_ID`),
  ADD KEY `product_ID` (`product_ID`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`history_ID`),
  ADD KEY `idx_order_status` (`order_ID`,`status`);

--
-- Indexes for table `organization_details`
--
ALTER TABLE `organization_details`
  ADD PRIMARY KEY (`Organization_ID`),
  ADD KEY `idx_user_id` (`User_ID`);

--
-- Indexes for table `organization_notice`
--
ALTER TABLE `organization_notice`
  ADD PRIMARY KEY (`Notice_ID`),
  ADD KEY `idx_organization_id` (`Organization_ID`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`reset_id`),
  ADD UNIQUE KEY `idx_reset_token` (`reset_token`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Category_ID` (`Category_ID`),
  ADD KEY `SubCategory_ID` (`SubCategory_ID`),
  ADD KEY `Inventory_ID` (`Inventory_ID`),
  ADD KEY `idx_product_price` (`product_price`),
  ADD KEY `idx_average_rating` (`average_rating`),
  ADD KEY `idx_is_organic` (`is_organic`),
  ADD KEY `idx_bulk_available` (`bulk_available`),
  ADD KEY `User_ID` (`User_ID`);
ALTER TABLE `product` ADD FULLTEXT KEY `idx_product_search` (`Product_Name`,`Product_Desc`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `product_qa`
--
ALTER TABLE `product_qa`
  ADD PRIMARY KEY (`qa_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `product_quantity_updates`
--
ALTER TABLE `product_quantity_updates`
  ADD PRIMARY KEY (`Update_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`review_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `idx_product_review` (`Product_ID`),
  ADD KEY `idx_rating` (`rating`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`tag_ID`),
  ADD KEY `Product_ID` (`Product_ID`),
  ADD KEY `idx_tag_name` (`tag_name`);

--
-- Indexes for table `product_tag_relation`
--
ALTER TABLE `product_tag_relation`
  ADD PRIMARY KEY (`Product_ID`,`tag_ID`),
  ADD KEY `tag_ID` (`tag_ID`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_ID`),
  ADD KEY `Product_ID` (`Product_ID`),
  ADD KEY `idx_user_cart` (`User_ID`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`SubCategory_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `User_EmailAddress` (`User_EmailAddress`),
  ADD KEY `Role_ID` (`Role_ID`),
  ADD KEY `Status_ID` (`Status_ID`),
  ADD KEY `idx_user_email` (`User_EmailAddress`),
  ADD KEY `idx_user_type` (`Type_ID`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`Address_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `user_role_management`
--
ALTER TABLE `user_role_management`
  ADD PRIMARY KEY (`User_ID`,`Role_ID`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`Session_ID`),
  ADD KEY `idx_user_id` (`User_ID`),
  ADD KEY `idx_session_status` (`session_status`),
  ADD KEY `idx_user_status` (`User_ID`,`session_status`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`Status_ID`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`Type_ID`);

--
-- Indexes for table `user_type_management`
--
ALTER TABLE `user_type_management`
  ADD PRIMARY KEY (`User_ID`,`Type_ID`),
  ADD KEY `Type_ID` (`Type_ID`);

--
-- Indexes for table `vendor_details`
--
ALTER TABLE `vendor_details`
  ADD PRIMARY KEY (`Vendor_ID`),
  ADD UNIQUE KEY `idx_user_id` (`User_ID`);

--
-- Indexes for table `verification_tokens`
--
ALTER TABLE `verification_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `farmer_details`
--
ALTER TABLE `farmer_details`
  MODIFY `Farmer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `orderedItem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `organization_details`
--
ALTER TABLE `organization_details`
  MODIFY `Organization_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `organization_notice`
--
ALTER TABLE `organization_notice`
  MODIFY `Notice_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `product_qa`
--
ALTER TABLE `product_qa`
  MODIFY `qa_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_quantity_updates`
--
ALTER TABLE `product_quantity_updates`
  MODIFY `Update_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `review_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `tag_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `SubCategory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `Address_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `Session_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `user_status`
--
ALTER TABLE `user_status`
  MODIFY `Status_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vendor_details`
--
ALTER TABLE `vendor_details`
  MODIFY `Vendor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `verification_tokens`
--
ALTER TABLE `verification_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farmer_details`
--
ALTER TABLE `farmer_details`
  ADD CONSTRAINT `farmer_details_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `order_details` (`order_ID`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE CASCADE;

--
-- Constraints for table `organization_details`
--
ALTER TABLE `organization_details`
  ADD CONSTRAINT `organization_details_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `organization_notice`
--
ALTER TABLE `organization_notice`
  ADD CONSTRAINT `organization_notice_ibfk_1` FOREIGN KEY (`Organization_ID`) REFERENCES `organization_details` (`Organization_ID`);

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`SubCategory_ID`) REFERENCES `sub_category` (`SubCategory_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`Inventory_ID`) REFERENCES `inventory` (`Inventory_ID`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE CASCADE;

--
-- Constraints for table `product_qa`
--
ALTER TABLE `product_qa`
  ADD CONSTRAINT `product_qa_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `product_quantity_updates`
--
ALTER TABLE `product_quantity_updates`
  ADD CONSTRAINT `product_quantity_updates_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE CASCADE;

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_review_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `product_review_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `product_tag_relation`
--
ALTER TABLE `product_tag_relation`
  ADD CONSTRAINT `product_tag_relation_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `product_tag_relation_ibfk_2` FOREIGN KEY (`tag_ID`) REFERENCES `product_tags` (`tag_ID`);

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Type_ID`) REFERENCES `user_type` (`Type_ID`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `user_role` (`Role_ID`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`Status_ID`) REFERENCES `user_status` (`Status_ID`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user_role_management`
--
ALTER TABLE `user_role_management`
  ADD CONSTRAINT `user_role_management_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `user_role_management_ibfk_2` FOREIGN KEY (`Role_ID`) REFERENCES `user_role` (`Role_ID`);

--
-- Constraints for table `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user_type_management`
--
ALTER TABLE `user_type_management`
  ADD CONSTRAINT `user_type_management_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `user_type_management_ibfk_2` FOREIGN KEY (`Type_ID`) REFERENCES `user_type` (`Type_ID`);

--
-- Constraints for table `vendor_details`
--
ALTER TABLE `vendor_details`
  ADD CONSTRAINT `vendor_details_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `verification_tokens`
--
ALTER TABLE `verification_tokens`
  ADD CONSTRAINT `verification_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
