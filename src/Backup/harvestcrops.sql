-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 04:59 AM
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
(13, 'grains', 'Rice, Wheat etc.', '2024-11-18 12:16:18', '2024-11-18 12:16:18'),
(14, 'fruits', 'Apples, Watermelon, Banana etc.', '2024-11-18 12:17:20', '2024-11-18 12:17:20'),
(15, 'rootcrops', 'Potatoes, Carrots, Sweet Potatoes etc.', '2024-11-18 12:18:06', '2024-11-18 12:18:06'),
(17, 'fruits', 'Apples, Watermelon, Banana etc.', '2024-11-18 13:01:52', '2024-11-18 13:01:52'),
(18, 'fruits', 'Apples, Watermelon, Banana etc.', '2024-11-18 13:02:44', '2024-11-18 13:02:44'),
(19, 'fruits', 'Apples, Watermelon, Banana etc.', '2024-11-18 13:58:02', '2024-11-18 13:58:02'),
(20, 'rootcrops', 'Potatoes, Carrots, Sweet Potatoes etc.', '2024-11-19 07:25:50', '2024-11-19 07:25:50');

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
(1, 1, 'John Farm', 15.00, 'hectares', '2024-11-18 08:03:16', '2024-11-18 08:06:41'),
(3, 3, 'Hans Farm VIlle', 100.00, 'hectares', '2024-11-18 12:08:08', '2024-11-18 12:08:43');

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
(12, '2024-11-30', 3990.00, '2024-11-18 12:16:18', '2024-11-22 02:42:23'),
(13, '2024-11-26', 120.00, '2024-11-18 12:17:20', '2024-11-22 02:43:53'),
(14, '2024-11-26', 500.00, '2024-11-18 12:18:06', '2024-11-22 03:17:49'),
(16, '2024-11-17', 98.00, '2024-11-18 13:01:52', '2024-11-22 03:51:40'),
(17, '2024-11-19', 70.00, '2024-11-18 13:02:44', '2024-11-22 03:51:49'),
(18, '2024-11-25', 116.00, '2024-11-18 13:58:02', '2024-11-20 09:50:08'),
(19, '2024-11-20', 3990.00, '2024-11-19 07:25:50', '2024-11-20 09:50:21');

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
(59, 4, 2.00, 'processing', '2024-11-20 09:47:41', '2024-11-22 03:51:40', 1),
(60, 4, 30.00, 'processing', '2024-11-20 09:47:50', '2024-11-22 03:51:49', 1),
(61, 4, 14.00, 'processing', '2024-11-20 09:50:08', '2024-11-20 10:12:41', 1),
(62, 4, 10.00, 'completed', '2024-11-20 09:50:21', '2024-11-20 10:20:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `orderedItem_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `sold_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`orderedItem_ID`, `order_ID`, `product_ID`, `quantity`, `sold_quantity`, `created_at`, `modified_at`) VALUES
(49, 59, 19, 2, 0, '2024-11-20 09:47:41', '2024-11-22 03:50:11'),
(50, 60, 20, 30, 0, '2024-11-20 09:47:50', '2024-11-22 03:51:49'),
(51, 61, 21, 14, 0, '2024-11-20 09:50:08', '2024-11-20 09:50:08'),
(52, 62, 22, 10, 0, '2024-11-20 09:50:21', '2024-11-20 09:50:21');

--
-- Triggers `order_item`
--
DELIMITER $$
CREATE TRIGGER `after_order_delete` AFTER DELETE ON `order_item` FOR EACH ROW BEGIN
  UPDATE inventory
  SET quantity = quantity + OLD.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = OLD.product_ID);
  
  -- Log sold quantity reduction in Product_Quantity_Updates table
  INSERT INTO Product_Quantity_Updates (Product_ID, stock_quantity, sold_quantity)
  VALUES (OLD.product_ID, 0, -OLD.quantity);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_order_insert` AFTER INSERT ON `order_item` FOR EACH ROW BEGIN
  -- Update inventory
  UPDATE inventory
  SET quantity = quantity - NEW.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = NEW.product_ID);
  
  -- Log sold quantity in Product_Quantity_Updates table
  INSERT INTO Product_Quantity_Updates (Product_ID, stock_quantity, sold_quantity)
  VALUES (NEW.product_ID, 0, NEW.quantity);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_order_update` AFTER UPDATE ON `order_item` FOR EACH ROW BEGIN
  -- Restore the previous quantity to inventory
  UPDATE inventory
  SET quantity = quantity + OLD.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = OLD.product_ID);
  
  -- Deduct the new quantity from inventory
  UPDATE inventory
  SET quantity = quantity - NEW.quantity
  WHERE Inventory_ID = (SELECT Inventory_ID FROM Product WHERE Product_ID = NEW.product_ID);
  
  -- Log sold quantity change in Product_Quantity_Updates table
  INSERT INTO Product_Quantity_Updates (Product_ID, stock_quantity, sold_quantity)
  VALUES (NEW.product_ID, 0, NEW.quantity - OLD.quantity);
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
  `product_SKU` varchar(100) DEFAULT NULL,
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

INSERT INTO `product` (`Product_ID`, `Category_ID`, `SubCategory_ID`, `Inventory_ID`, `Product_Name`, `Product_Desc`, `product_SKU`, `product_price`, `average_rating`, `shelf_life`, `shelf_life_unit`, `is_organic`, `bulk_available`, `bulk_minimum_quantity`, `sold_quantity`, `created_at`, `modified_at`, `User_ID`) VALUES
(15, 13, 13, 12, 'Wheat', 'New Harvest', '1', 100.00, NULL, 30, 'days', 1, 1, NULL, 0, '2024-11-18 12:16:18', '2024-11-18 12:16:18', 3),
(16, 14, 14, 13, 'Banana', 'New Harvest', '2', 45.00, NULL, 20, 'days', 1, 0, NULL, 0, '2024-11-18 12:17:20', '2024-11-18 12:17:20', 3),
(17, 15, 15, 14, 'Potato', 'New Harvest', '3', 35.00, NULL, 10, 'days', 0, 0, NULL, 0, '2024-11-18 12:18:06', '2024-11-18 12:18:06', 3),
(19, 17, 17, 16, 'watermelon', 'fresh', '5', 100.00, NULL, 10, 'days', 1, 0, NULL, 0, '2024-11-18 13:01:52', '2024-11-18 13:01:52', 1),
(20, 18, 18, 17, 'Apple', 'fresh', '4', 10.00, NULL, 5, 'days', 1, 0, NULL, 0, '2024-11-18 13:02:44', '2024-11-19 07:30:54', 1),
(21, 19, 19, 18, 'Orange', 'New Harvest', '7', 30.00, NULL, 10, 'days', 1, 0, NULL, 0, '2024-11-18 13:58:02', '2024-11-18 13:58:02', 1),
(22, 20, 20, 19, 'Carrot', 'New Harvest', '10', 27.00, NULL, 21, 'days', 1, 1, NULL, 0, '2024-11-19 07:25:50', '2024-11-19 07:25:50', 1);

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
(7, 15, '../images/product_uploads/img_673b3012e67cc6.18249776.jpg', '2024-11-18 12:16:18'),
(8, 16, '../images/product_uploads/img_673b3050d57839.85096462.jpg', '2024-11-18 12:17:20'),
(9, 17, '../images/product_uploads/img_673b307e61a980.60116733.jpg', '2024-11-18 12:18:06'),
(11, 19, '../images/product_uploads/img_673b3ac09936c8.93614192.jpg', '2024-11-18 13:01:52'),
(12, 20, '../images/product_uploads/img_673b3af48a93a5.80577716.jpg', '2024-11-18 13:02:44'),
(13, 21, '../images/product_uploads/img_673b47ea5da193.81982663.jpg', '2024-11-18 13:58:02'),
(14, 22, '../images/product_uploads/img_673c3d7eb0f918.65353263.png', '2024-11-19 07:25:50');

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
(97, 15, 0.00, 11.00, '2024-11-20 09:46:54'),
(98, 16, 0.00, 12.00, '2024-11-20 09:47:13'),
(99, 17, 0.00, 11.00, '2024-11-20 09:47:31'),
(100, 19, 0.00, 11.00, '2024-11-20 09:47:41'),
(101, 20, 0.00, 13.00, '2024-11-20 09:47:50'),
(102, 21, 0.00, 14.00, '2024-11-20 09:50:08'),
(103, 22, 0.00, 10.00, '2024-11-20 09:50:21'),
(106, 15, 0.00, -1.00, '2024-11-20 10:04:27'),
(107, 15, 0.00, -1.00, '2024-11-20 10:04:27'),
(108, 15, 0.00, -11.00, '2024-11-22 02:42:23'),
(109, 16, 0.00, -12.00, '2024-11-22 02:43:53'),
(110, 17, 0.00, -11.00, '2024-11-22 03:17:49'),
(111, 19, 0.00, -9.00, '2024-11-22 03:50:11'),
(112, 19, 0.00, 0.00, '2024-11-22 03:51:40'),
(113, 20, 0.00, 17.00, '2024-11-22 03:51:49');

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
(13, 13, 'grains', NULL, '2024-11-18 12:16:18', '2024-11-18 12:16:18'),
(14, 14, 'fruits', NULL, '2024-11-18 12:17:20', '2024-11-18 12:17:20'),
(15, 15, 'rootcrops', NULL, '2024-11-18 12:18:06', '2024-11-18 12:18:06'),
(17, 17, 'fruits', NULL, '2024-11-18 13:01:52', '2024-11-18 13:01:52'),
(18, 18, 'fruits', NULL, '2024-11-18 13:02:44', '2024-11-18 13:02:44'),
(19, 19, 'fruits', NULL, '2024-11-18 13:58:02', '2024-11-18 13:58:02'),
(20, 20, 'rootcrops', NULL, '2024-11-19 07:25:50', '2024-11-19 07:25:50');

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
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `User_FirstName`, `User_MiddleName`, `User_LastName`, `User_BirthDate`, `User_Gender`, `User_EmailAddress`, `User_Password`, `User_MobileNumber`, `Status_ID`, `Type_ID`, `Role_ID`, `created_at`, `modified_at`) VALUES
(1, 'John Lloyd', 'Buena', 'Dela Cruz', '2002-02-03', 'Male', 'tyn@gmail.com', '12345678', '09645539284', 1, 1, 1, '2024-11-18 08:03:16', '2024-11-18 08:05:54'),
(2, 'Leila Aliyah', 'Jambaro', 'Manalo', '2005-02-05', 'Female', 'aliyah@gmail.com', '12345678', '09685147954', 2, 2, 2, '2024-11-18 08:04:01', '2024-11-18 08:04:01'),
(3, 'Hans Kyle', ' ', 'Bertoso', '2002-01-05', 'Male', 'Hans@gmail.com', '12345678', '09685147954', 3, 3, 3, '2024-11-18 12:08:08', '2024-11-18 12:08:08'),
(4, 'Joe', 'Bill', 'Biden', '2003-02-05', 'Male', 'Joe@gmail.com', '12345678', '09685147954', 4, 4, 4, '2024-11-18 13:04:16', '2024-11-18 13:04:16');

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
(1, 1, 'farm', 'Tanza Cavite', 'Luzon', 'Region IV - A', 'Cavite', 'Tanza', 4108, '2024-11-18 08:03:16', '2024-11-18 08:03:16'),
(2, 2, 'farm', 'Tanza Cavite', 'Luzon', 'Region IV - A', 'Cavite', 'Tanza', 4108, '2024-11-18 08:04:01', '2024-11-18 08:04:01'),
(3, 3, 'farm', 'Tanza Cavite', 'Luzon', 'Region IV - A', 'Cavite', 'Tanza', 4108, '2024-11-18 12:08:08', '2024-11-18 12:08:08'),
(4, 4, 'home', 'Tanza Cavite', 'Luzon', 'Region IV - A', 'Cavite', 'Tanza', 4108, '2024-11-18 13:04:16', '2024-11-18 13:04:16');

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
(1, 'User', '2024-11-18 08:03:16', '0000-00-00 00:00:00'),
(2, 'Admin', '2024-11-18 08:05:19', '0000-00-00 00:00:00'),
(3, 'User', '2024-11-18 12:08:08', '0000-00-00 00:00:00'),
(4, 'User', '2024-11-18 13:04:16', '0000-00-00 00:00:00');

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
(4, 4);

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
(1, 'active', '2024-11-18 08:03:16', '2024-11-18 08:05:59'),
(2, 'active', '2024-11-18 08:04:01', '2024-11-18 08:05:11'),
(3, 'active', '2024-11-18 12:08:08', '2024-11-18 12:08:18'),
(4, 'active', '2024-11-18 13:04:15', '2024-11-18 13:04:32');

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
(1, 'Farmer', 'Local Farmer', '2024-11-18 08:03:16', '2024-11-18 08:03:16'),
(2, 'Admin', 'Admin', '2024-11-18 08:04:01', '2024-11-18 08:05:05'),
(3, 'Farmer', 'Local Farmer', '2024-11-18 12:08:08', '2024-11-18 12:08:08'),
(4, 'Vendor', 'Local Vendor', '2024-11-18 13:04:15', '2024-11-18 13:04:15');

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
(4, 4);

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
(4, 4, 'Joe Business', 'Retailer', '05', 5, 'Grains', '2024-11-18 13:04:16', '2024-11-18 13:08:06');

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
  ADD UNIQUE KEY `product_SKU` (`product_SKU`),
  ADD KEY `Category_ID` (`Category_ID`),
  ADD KEY `SubCategory_ID` (`SubCategory_ID`),
  ADD KEY `Inventory_ID` (`Inventory_ID`),
  ADD KEY `idx_product_price` (`product_price`),
  ADD KEY `idx_average_rating` (`average_rating`),
  ADD KEY `idx_is_organic` (`is_organic`),
  ADD KEY `idx_bulk_available` (`bulk_available`),
  ADD KEY `idx_product_sku` (`product_SKU`),
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `farmer_details`
--
ALTER TABLE `farmer_details`
  MODIFY `Farmer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `orderedItem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_qa`
--
ALTER TABLE `product_qa`
  MODIFY `qa_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_quantity_updates`
--
ALTER TABLE `product_quantity_updates`
  MODIFY `Update_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

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
  MODIFY `cart_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `SubCategory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `Address_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `Session_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_status`
--
ALTER TABLE `user_status`
  MODIFY `Status_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendor_details`
--
ALTER TABLE `vendor_details`
  MODIFY `Vendor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farmer_details`
--
ALTER TABLE `farmer_details`
  ADD CONSTRAINT `farmer_details_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `order_details` (`order_ID`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `order_details` (`order_ID`);

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`SubCategory_ID`) REFERENCES `sub_category` (`SubCategory_ID`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`Inventory_ID`) REFERENCES `inventory` (`Inventory_ID`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `product_qa`
--
ALTER TABLE `product_qa`
  ADD CONSTRAINT `product_qa_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `product_quantity_updates`
--
ALTER TABLE `product_quantity_updates`
  ADD CONSTRAINT `product_quantity_updates_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

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
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
