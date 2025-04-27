-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 08:58 AM
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
-- Database: `house_hunt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
('BcjKNX58e4x7bIqIvxG7', 'PritamPatika', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
('qpEpLu3ai414Xa39dWOI', 'BidusmitaPidika', 'ab6ad881e7d1e78559ff2f9cb718f888bcd4d596');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL,
  `price_label` varchar(10) NOT NULL,
  `property_type` varchar(10) NOT NULL,
  `offer` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image_01` varchar(50) NOT NULL,
  `image_02` varchar(50) NOT NULL,
  `image_03` varchar(50) NOT NULL,
  `image_04` varchar(50) NOT NULL,
  `image_05` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `lot_size` varchar(10) NOT NULL,
  `rooms` varchar(2) NOT NULL,
  `bedrooms` varchar(2) NOT NULL,
  `bathrooms` varchar(2) NOT NULL,
  `custom_id` varchar(50) NOT NULL,
  `garages` varchar(10) NOT NULL,
  `house_age` varchar(30) NOT NULL,
  `garage_size` varchar(30) NOT NULL,
  `date_listed` date NOT NULL,
  `basement` varchar(10) NOT NULL,
  `bhk` varchar(10) NOT NULL,
  `structure_type` varchar(50) NOT NULL,
  `floors` varchar(10) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`amenities`)),
  `video_url` varchar(50) DEFAULT NULL,
  `equipped_kitchen` varchar(3) NOT NULL DEFAULT 'no',
  `gym` varchar(3) NOT NULL DEFAULT 'no',
  `laundry` varchar(3) NOT NULL DEFAULT 'no',
  `media_room` varchar(3) NOT NULL DEFAULT 'no',
  `backyard` varchar(3) NOT NULL DEFAULT 'no',
  `basket_ball_court` varchar(3) NOT NULL DEFAULT 'no',
  `front_yard` varchar(3) NOT NULL DEFAULT 'no',
  `garage_attached` varchar(3) NOT NULL DEFAULT 'no',
  `hot_bath` varchar(3) NOT NULL DEFAULT 'no',
  `pool` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `user_id`, `title`, `description`, `price`, `price_label`, `property_type`, `offer`, `status`, `image_01`, `image_02`, `image_03`, `image_04`, `image_05`, `address`, `country`, `state`, `city`, `zip`, `size`, `lot_size`, `rooms`, `bedrooms`, `bathrooms`, `custom_id`, `garages`, `house_age`, `garage_size`, `date_listed`, `basement`, `bhk`, `structure_type`, `floors`, `amenities`, `video_url`, `equipped_kitchen`, `gym`, `laundry`, `media_room`, `backyard`, `basket_ball_court`, `front_yard`, `garage_attached`, `hot_bath`, `pool`) VALUES
('goGzJa8uW8zonjFHJDry', 'tm6gkIlcofiF0gYc13CY', 'Beautiful 3-Bedroom Family Home', 'A spacious and well-maintained family home located in a peaceful neighborhood. Perfect for families ', '30000', '/month', 'House', 'Rental', 'Active', 'yBwTdgarqr6FuuhbBLML.jpg', 'eR7rVuuPrUOr9wi56kjd.jpg', 'TglEaRjLMocagKcWS7PE.jpg', 'U9qwWo8xZQzAT1Httw0X.jpg', 'fViGOCgQsVnbj54wxrXy.jpg', '456 Bhubaneswar Road', 'India', 'Odisha', 'Bhubaneswar', '751001', '1500', '5000', '6', '3', '2', '12345AB', '1', '10', '200sqft', '2024-10-15', 'Yes', '3', 'Cement', '2', '[\"Equipped Kitchen\",\"Gym\",\"Laundry\",\"Back Yard\",\"Front Yard\",\"Garage Attached\"]', NULL, 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no'),
('j8Yy9Pq1FFedLQZRqTf1', 'tm6gkIlcofiF0gYc13CY', 'A Beautfull family House', 'This property is a beautiful two-story home inspired by traditional East Asian architecture, featuri', '500000', '/total', 'House', 'Sales', 'Active', 's88qp9xrm5uIkm8KYxhT.jpg', 'W75izY0u49Q7TwZiZs4d.jpg', 'ijtPZGeWq0tDcZCD4stk.jpg', 'jhdivsFsNGbDLt0EUzNM.jpg', 'fFkcv73NAMy8XaffjGyG.jpg', 'P-16 ROURKELA, CIVIL TOWNSHIP', 'India', 'Odisha', 'ROURKELA', '770038', '3500', '5000', '8', '4', '3', 'H1234', '2', '5', '500sqft', '2024-10-12', 'yes', '4 BHK', 'Cement', '1', '[\"Equipped Kitchen\",\"Laundry\",\"Media Room\",\"Back Yard\",\"Garage Attached\"]', NULL, 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no'),
('zc0yConuVJzbdBjuVjcb', 'tm6gkIlcofiF0gYc13CY', 'A Luxurious House', 'A beautiful luxurious house situated at the heart of the city. It is a Big Family House with a big k', '50000', '/month', 'House', 'Rental', 'Active', 'pDmyugATIea7BpiDwba9.jpg', 'H3ks8KUXY0L3xUp14VGS.jpg', '8IwV82sl6tvQUapLwzh0.jpg', 'B9WAEqez04w8GoVCXKHl.jpg', 'ZSSnqoBAlaolj1HzsVxx.jpg', 'P-09, ROURKELA, SECTOR 19', 'India', 'Odisha', 'ROURKELA', '770038', '4500', '5500', '5', '4', '3', 'H243', '2 car gara', '3', '450sqft', '2024-10-14', 'yes', '5', 'Cement', '2', '[\"Equipped Kitchen\",\"Laundry\",\"Back Yard\",\"Front Yard\",\"Garage Attached\",\"Pool\"]', NULL, 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `property_id`, `sender`, `receiver`, `date`) VALUES
('HTgpvOKYG6QeGKXVXoxN', 'goGzJa8uW8zonjFHJDry', 'tm6gkIlcofiF0gYc13CY', 'tm6gkIlcofiF0gYc13CY', '2024-10-15'),
('d03lebDwTfaNYSh8eSwP', 'goGzJa8uW8zonjFHJDry', 'CjDZLOUZMAqP0iybB7rK', 'tm6gkIlcofiF0gYc13CY', '2024-10-23');

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved`
--

INSERT INTO `saved` (`id`, `property_id`, `user_id`) VALUES
('KYkkM8zoQG3lEKazrkOY', 'j8Yy9Pq1FFedLQZRqTf1', 'CjDZLOUZMAqP0iybB7rK'),
('wZRhbdUKHEaDbV1KGlt7', 'zc0yConuVJzbdBjuVjcb', 'tm6gkIlcofiF0gYc13CY'),
('G73MRKFs6kLRDkd6L9Fu', 'goGzJa8uW8zonjFHJDry', 'CjDZLOUZMAqP0iybB7rK'),
('NguCvyYA7tf5djc1xZU7', 'goGzJa8uW8zonjFHJDry', 'tm6gkIlcofiF0gYc13CY');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `address`, `password`, `profile_image`) VALUES
('tm6gkIlcofiF0gYc13CY', 'Piyush Chaudhry', '9439786224', 'pritampatika2004@gmail.com', '15\\A Rourkela, Civil Township', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL),
('CjDZLOUZMAqP0iybB7rK', 'Pritam Kumar Patika', '7077100805', 'pratimapatika224@gmail.com', 'Bonaigarh, Main Market', '273e01c21d0580650021e21056b4d30dedcdc76b', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
