-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 10:14 AM
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
-- Database: `vehicle`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`, `mobile_number`) VALUES
(1, 'admin@gmail.com', '$2y$10$bstswVOaRPizI3xCKfLPye49PK83f4.kICe82qcTTn.E/ZlZ26ZJW', 'admin@gmail.com', '2024-11-10 09:57:16', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_content` text NOT NULL,
  `blog_post_date` date NOT NULL,
  `blog_category` varchar(100) DEFAULT NULL,
  `blog_image_path` varchar(255) DEFAULT NULL,
  `blog_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blog_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `category_status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `category_image`, `category_status`, `created_at`) VALUES
(1, 'Exterior Cleaning', NULL, 1, '2025-01-28 04:30:00'),
(2, 'Interior Cleaning', '', 1, '2025-01-28 04:35:00'),
(3, 'Full Body Wash', '', 1, '2025-01-28 04:40:00'),
(4, 'Engine Detailing', '', 1, '2025-01-28 04:45:00'),
(5, 'Premium Wash', '', 1, '2025-01-28 04:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_phone` varchar(15) DEFAULT NULL,
  `customer_image` varchar(255) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_description` text DEFAULT NULL,
  `service_image` varchar(255) NOT NULL,
  `service_price` decimal(10,2) DEFAULT NULL,
  `service_dis` varchar(255) DEFAULT NULL,
  `service_dis_value` decimal(10,2) DEFAULT NULL,
  `service_status` int(11) DEFAULT 1,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_name`, `service_description`, `service_image`, `service_price`, `service_dis`, `service_dis_value`, `service_status`, `category_id`, `created_at`) VALUES
(1, 'Basic Exterior Wash', 'A simple exterior car wash using high-pressure water.', '', 300.00, 'No', 0.00, 0, 1, '2025-01-28 05:00:00'),
(2, 'Interior Vacuuming', 'Thorough vacuuming of car interiors including seats and mats.', '', 500.00, 'Yes', 10.00, 0, 2, '2025-01-28 05:05:00'),
(3, 'Full Body Polish', 'Complete body polish for a shiny, scratch-free look.', '', 1000.00, 'Yes', 15.00, 0, 3, '2025-01-28 05:10:00'),
(4, 'Engine Steam Cleaning', 'Cleaning of the car engine using steam for enhanced performance.', '', 1200.00, 'No', 0.00, 0, 4, '2025-01-28 05:15:00'),
(5, 'Deluxe Premium Wash', 'A premium car wash with waxing and detailing for a showroom finish.', '', 2000.00, 'Yes', 20.00, 0, 5, '2025-01-28 05:20:00'),
(6, 'Waterless Exterior Wash', 'An eco-friendly car wash using minimal water and special cleaning agents.', '', 400.00, 'Yes', 5.00, 0, 1, '2025-01-28 05:30:00'),
(7, 'Exterior Wax Coating', 'Adds a protective wax layer to the car exterior for a glossy finish.', '', 800.00, 'No', 0.00, 0, 1, '2025-01-28 05:35:00'),
(8, 'Leather Seat Cleaning', 'Special treatment for leather seats to clean and protect them.', '', 600.00, 'Yes', 10.00, 0, 2, '2025-01-28 05:40:00'),
(9, 'Odor Removal', 'Removes unpleasant odors from car interiors using advanced techniques.', '', 700.00, 'No', 0.00, 0, 2, '2025-01-28 05:45:00'),
(10, 'Foam Wash', 'Complete body wash with thick foam for a deep clean.', '', 900.00, 'Yes', 10.00, 0, 3, '2025-01-28 05:50:00'),
(11, 'Underbody Wash', 'Specialized cleaning of the car\'s underbody to remove dirt and grime.', '', 1000.00, 'No', 0.00, 0, 3, '2025-01-28 05:55:00'),
(12, 'Engine Degreasing', 'Removes grease and oil buildup for a cleaner engine.', '', 1500.00, 'Yes', 15.00, 0, 4, '2025-01-28 06:00:00'),
(13, 'Battery Cleaning', 'Cleans car battery terminals and surroundings to improve performance.', '', 500.00, 'No', 0.00, 0, 4, '2025-01-28 06:05:00'),
(14, 'Ceramic Coating', 'High-quality ceramic coating for long-lasting paint protection.', '', 5000.00, 'Yes', 25.00, 0, 5, '2025-01-28 06:10:00'),
(15, 'Paint Restoration', 'Restores the car\'s paintwork to its original shine.', '', 3000.00, 'Yes', 20.00, 0, 5, '2025-01-28 06:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `slider_id` int(11) NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `slider_status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
