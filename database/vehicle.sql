-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 11:29 AM
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
-- Table structure for table `tbl_bookings`
--

CREATE TABLE `tbl_bookings` (
  `booking_id` int(11) NOT NULL,
  `booking_category_id` int(11) NOT NULL,
  `booking_service_id` int(11) NOT NULL,
  `booking_customer_id` int(11) NOT NULL,
  `booking_time` time NOT NULL,
  `booking_date` date NOT NULL,
  `booking_washing_point` varchar(255) DEFAULT NULL,
  `booking_message` text DEFAULT NULL,
  `booking_status` int(11) DEFAULT 1,
  `booking_price` decimal(10,2) NOT NULL,
  `booking_payment_method` varchar(255) DEFAULT NULL,
  `booking_payment_status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`booking_id`, `booking_category_id`, `booking_service_id`, `booking_customer_id`, `booking_time`, `booking_date`, `booking_washing_point`, `booking_message`, `booking_status`, `booking_price`, `booking_payment_method`, `booking_payment_status`) VALUES
(1, 2, 8, 9, '03:25:00', '2025-02-22', '1', 'udya pasun ', 2, 600.00, '1', 1),
(2, 5, 5, 9, '04:51:00', '2025-02-28', '1', 'gjjh\n', 2, 2000.00, '1', 1),
(3, 1, 1, 6, '05:56:00', '2025-02-14', '2', 'ddd', 2, 300.00, '1', 1);

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
(1, 'Exterior Cleaning', 'washing-jpg-500x500.jpg', 1, '2025-01-28 04:30:00'),
(2, 'Interior Cleaning', 'interior-cleaning.jpg', 1, '2025-01-28 04:35:00'),
(3, 'Full Body Wash', 'Car-Wash-Liquid-Shampoo-Washing-Liquid-Safe-to-Car-Body-Yt04-20L (1).jpg', 1, '2025-01-28 04:40:00'),
(4, 'Engine Detailing', 'INGINE.jpg', 1, '2025-01-28 04:45:00'),
(5, 'Premium Wash', '5000-premium-car-wash-gel-unleash-the-ultimate-shine-car-washing-original-imagwrvugunfyzbw.jpg', 1, '2025-01-28 04:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `city_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`city_id`, `city_name`, `city_status`) VALUES
(1, 'Solapur', 1),
(2, 'Pune', 1),
(3, 'कोल्हापूर', 1);

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

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `customer_name`, `customer_email`, `customer_password`, `customer_phone`, `customer_image`, `customer_address`, `customer_status`, `created_at`) VALUES
(6, 'Akash Kadam', 'akash@gmail.com', '$2y$10$Do3IU7gT7LKH9vFVc4wP6OTmPufngn1HBs.XRfoqEBbbJQjxNwVqi', '9322648858', '', 'bmt', 1, '2025-02-04 09:46:59'),
(7, 'Sanket Jadhav ', 'sanket@gmail.com', '$2y$10$wfcX1sUnysWD4vxUucOJU.VoLC5vejZ8bTW9eB.XkHy92L31VZFsy', '988776677665', '1000015792.jpg', 'Phaltan', 1, '2025-02-14 05:54:08'),
(9, 'ak', 'ak@gmail.com', '$2y$10$hSPTEpFolZzT4AO6cCZoTOv3CivaTLtPmQ/9LUkrwSX6PmUS4x74.', '97755755765', '1000016164.jpg', 'mmt', 1, '2025-02-14 05:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_email` varchar(150) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `employee_phone` varchar(15) NOT NULL,
  `employee_address` text NOT NULL,
  `employee_position` varchar(100) NOT NULL,
  `employee_salary` decimal(10,2) NOT NULL,
  `employee_status` enum('1','2') DEFAULT '1',
  `employee_image` varchar(255) DEFAULT NULL,
  `employee_joined_at` datetime NOT NULL,
  `employee_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`employee_id`, `employee_name`, `employee_email`, `employee_password`, `employee_phone`, `employee_address`, `employee_position`, `employee_salary`, `employee_status`, `employee_image`, `employee_joined_at`, `employee_created_at`) VALUES
(1, 'Sanket Jadhav', 'sanket@gmail.com', '$2y$10$CumXx9XOEFLggiDW3IJ4YOIqC3WULCL9i.dXEQm.7QDcsCPC7FGEy', 'sanket@gmail.co', 'Test\r\n\r\n', 'Head', 890.00, '1', '', '0000-00-00 00:00:00', '2025-02-08 17:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `rating_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_rating` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ratings`
--

INSERT INTO `tbl_ratings` (`rating_id`, `booking_id`, `service_id`, `customer_id`, `rating`, `review_rating`, `created_at`) VALUES
(1, 1, 2, 6, 3, 'ok', NULL);

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
(1, 'Basic Exterior Wash', 'A simple exterior car wash using high-pressure water.', 'basicWash1.png', 300.00, '', 0.00, 2, 1, '2025-01-28 05:00:00'),
(2, 'Interior Vacuuming', 'Thorough vacuuming of car interiors including seats and mats.', 'how-to-clean-tinted-car-windows.jpg', 500.00, '', 10.00, 2, 2, '2025-01-28 05:05:00'),
(3, 'Full Body Polish', 'Complete body polish for a shiny, scratch-free look.', 'abcsCar.jpg', 1000.00, '', 15.00, 2, 3, '2025-01-28 05:10:00'),
(4, 'Engine Steam Cleaning', 'Cleaning of the car engine using steam for enhanced performance.', '', 1200.00, 'No', 0.00, 0, 4, '2025-01-28 05:15:00'),
(5, 'Deluxe Premium Wash', 'A premium car wash with waxing and detailing for a showroom finish.', '', 2000.00, 'Yes', 20.00, 0, 5, '2025-01-28 05:20:00'),
(6, 'Waterless Exterior Wash', 'An eco-friendly car wash using minimal water and special cleaning agents.', 'Waterless Exterior Wash.jpg', 400.00, '', 5.00, 2, 1, '2025-01-28 05:30:00'),
(7, 'Exterior Wax Coating', 'Adds a protective wax layer to the car exterior for a glossy finish.', 'carwaxpolish.jpg', 800.00, '', 0.00, 2, 1, '2025-01-28 05:35:00'),
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
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`slider_id`, `slider_image`, `slider_status`, `created_at`) VALUES
(4, 'how-to-clean-tinted-car-windows.jpg', 1, '2025-01-31 11:09:50'),
(5, '5000-premium-car-wash-gel-unleash-the-ultimate-shine-car-washing-original-imagwrvugunfyzbw.jpg', 1, '2025-02-14 06:59:33'),
(6, 'Car-Wash-Liquid-Shampoo-Washing-Liquid-Safe-to-Car-Body-Yt04-20L (1).jpg', 1, '2025-02-14 06:59:43'),
(7, 'abcsCar.jpg', 1, '2025-02-14 07:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_washing_point`
--

CREATE TABLE `tbl_washing_point` (
  `washing_id` int(11) NOT NULL,
  `washing_city_id` int(11) NOT NULL,
  `washing_location` varchar(255) DEFAULT NULL,
  `washing_landmark` varchar(255) DEFAULT NULL,
  `washing_status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_washing_point`
--

INSERT INTO `tbl_washing_point` (`washing_id`, `washing_city_id`, `washing_location`, `washing_landmark`, `washing_status`) VALUES
(1, 1, 'Natepute', 'near in bus Stand', 1),
(2, 2, 'Baramati', 'Near in bus Stand', 1),
(3, 3, ' खु. कोल्हापूर', 'near in mandir', 1),
(4, 1, 'Malshiras', 'near by pandre garmentes', 1);

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
-- Indexes for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `booking_category_id` (`booking_category_id`),
  ADD KEY `booking_service_id` (`booking_service_id`),
  ADD KEY `booking_customer_id` (`booking_customer_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `employee_email` (`employee_email`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`rating_id`);

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
-- Indexes for table `tbl_washing_point`
--
ALTER TABLE `tbl_washing_point`
  ADD PRIMARY KEY (`washing_id`),
  ADD KEY `washing_city_id` (`washing_city_id`);

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
-- AUTO_INCREMENT for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_washing_point`
--
ALTER TABLE `tbl_washing_point`
  MODIFY `washing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD CONSTRAINT `tbl_bookings_ibfk_1` FOREIGN KEY (`booking_category_id`) REFERENCES `tbl_category` (`category_id`),
  ADD CONSTRAINT `tbl_bookings_ibfk_2` FOREIGN KEY (`booking_service_id`) REFERENCES `tbl_services` (`service_id`),
  ADD CONSTRAINT `tbl_bookings_ibfk_3` FOREIGN KEY (`booking_customer_id`) REFERENCES `tbl_customer` (`customer_id`);

--
-- Constraints for table `tbl_washing_point`
--
ALTER TABLE `tbl_washing_point`
  ADD CONSTRAINT `tbl_washing_point_ibfk_1` FOREIGN KEY (`washing_city_id`) REFERENCES `tbl_city` (`city_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
