-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 09:51 AM
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
(2, 2, 'Vinces Ville', 20.00, 'hectares', '2024-12-03 09:02:38', '2024-12-04 06:57:39');

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
(107, 3, 200.00, 'processing', '2024-12-07 07:16:34', '2024-12-07 07:17:01', 2);

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
(4, 4, 'Department of Argriculture Tanza', '09694887965', 'DoaTanza@gmail.com', '2024-12-03 09:05:52', '2024-12-04 07:04:16');

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
(16, 4, 'Farmer Meeting', 'will be conducted on the municipal of tanza, will be hosted by Jezreel Jaynos.', '2024-12-03 10:17:20', '2024-12-05 18:16:00', 'Department of Argriculture Tanza');

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
(1, 'John', 'Buena', 'Dela Cruz', '1980-01-01', 'Male', 'john@gmail.com', '$2y$10$/.ZKDIz0AX093UMPg/OdleRil7JB/dHZdnmqi4L5.HajmDboetLnq', '09685997862', 1, 1, 1, '2024-12-03 08:59:44', '2024-12-03 08:59:44'),
(2, 'Vince', ' Wackie', 'Espera', '1981-04-02', 'Male', 'vince@gmail.com', '$2y$10$H7wO/erACVYZC1V/8kO1Tu2dCp38vdWCR36e6NI4.QbUec6oM3yvu', '09698767853', 2, 2, 2, '2024-12-03 09:02:38', '2025-02-10 12:30:14'),
(3, 'Aliyah', ' ', 'Manalo', '1982-03-03', 'Female', 'aliyah@gmail.com', '$2y$10$jaack8V/imzmdntcLccS9./pMG8P/PpH5rRLjplimHbDXSCDbwapy', '09698664952', 3, 3, 3, '2024-12-03 09:03:37', '2024-12-04 05:58:33'),
(4, 'Jezreel', ' ', 'Jaynos', '1984-03-04', 'Female', 'doa@gmail.com', '$2y$10$C.6FkjHP7F6niupoJIQBQeoHJ7KGS8Nfy4ePYdeebVpFlMBopLwj6', '09697845961', 4, 4, 4, '2024-12-03 09:05:52', '2024-12-04 07:00:59');

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
(1, 1, 'farm', 'Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2024-12-03 08:59:44', '2024-12-03 08:59:44'),
(2, 2, 'farm', 'General Trias Cavite', 'Luzon', 'Region IV A', 'Cavite', 'General Trias', 4107, '2024-12-03 09:02:38', '2024-12-03 09:02:38'),
(3, 3, 'home', 'Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2024-12-03 09:03:37', '2024-12-03 09:03:37'),
(4, 4, 'business', 'Tanza Cavite', 'Luzon', 'Region IV A', 'Cavite', 'Tanza', 4108, '2024-12-03 09:05:52', '2024-12-03 09:05:52');

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
(1, 'Admin', '2024-12-03 09:00:07', '0000-00-00 00:00:00'),
(2, 'User', '2024-12-03 09:02:38', '0000-00-00 00:00:00'),
(3, 'User', '2024-12-03 09:03:37', '0000-00-00 00:00:00'),
(4, 'User', '2024-12-03 09:05:52', '0000-00-00 00:00:00');

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

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`Session_ID`, `User_ID`, `session_start`, `session_end`, `last_activity`, `session_status`, `created_at`, `modified_at`) VALUES
(1, 1, '2025-02-23 04:02:09', '2025-02-22 20:02:32', '2025-02-22 20:02:32', 'closed', '2025-02-23 04:02:09', '2025-02-23 04:02:32'),
(2, 3, '2025-02-23 04:02:40', '2025-02-22 20:08:10', '2025-02-22 20:08:10', 'closed', '2025-02-23 04:02:40', '2025-02-23 04:08:10'),
(3, 1, '2025-02-23 04:08:34', '2025-02-22 20:12:46', '2025-02-22 20:12:46', 'closed', '2025-02-23 04:08:34', '2025-02-23 04:12:46'),
(4, 3, '2025-02-23 04:12:53', '2025-02-22 22:36:56', '2025-02-22 22:36:56', 'closed', '2025-02-23 04:12:53', '2025-02-23 06:36:56');

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
(1, 'active', '2024-12-03 08:59:44', '2024-12-03 09:00:18'),
(2, 'active', '2024-12-03 09:02:38', '2025-02-10 10:49:05'),
(3, 'active', '2024-12-03 09:03:37', '2024-12-03 09:06:31'),
(4, 'active', '2024-12-03 09:05:52', '2024-12-03 09:06:32');

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
(1, 'Admin', 'Admin', '2024-12-03 08:59:44', '2024-12-03 09:00:29'),
(2, 'Farmer', 'Local Farmer', '2024-12-03 09:02:38', '2024-12-03 09:02:38'),
(3, 'Vendor', 'Local Vendor', '2024-12-03 09:03:37', '2024-12-03 09:03:37'),
(4, 'Organization', 'Agriculture Organization', '2024-12-03 09:05:52', '2024-12-03 09:05:52');

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
(3, 3, 'Aliyah Business', 'Wholesaler', '05', 5, 'Fruits and Vegetables', '2024-12-03 09:03:37', '2024-12-04 07:10:53');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `farmer_details`
--
ALTER TABLE `farmer_details`
  MODIFY `Farmer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `orderedItem_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `organization_details`
--
ALTER TABLE `organization_details`
  MODIFY `Organization_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `organization_notice`
--
ALTER TABLE `organization_notice`
  MODIFY `Notice_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_qa`
--
ALTER TABLE `product_qa`
  MODIFY `qa_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_quantity_updates`
--
ALTER TABLE `product_quantity_updates`
  MODIFY `Update_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

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
  MODIFY `cart_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `SubCategory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
