-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2020 at 04:01 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `house_lister`
--

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `house_id` int(11) NOT NULL,
  `owner_id` int(4) NOT NULL,
  `street` varchar(256) NOT NULL,
  `number` int(4) NOT NULL,
  `addition` varchar(5) NOT NULL,
  `zipCode` varchar(7) NOT NULL,
  `city` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`house_id`, `owner_id`, `street`, `number`, `addition`, `zipCode`, `city`) VALUES
(1, 32, 'Amsterdamse straat', 12, '', '1300 RK', 'Amsterdam'),
(2, 32, 'Lagedijk', 5, 'B', '1924AG', 'Heiloo'),
(3, 34, 'Lammerweg', 7023, 'B', '8235 JF', 'Den Haag');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `owner_id` int(4) NOT NULL,
  `house_id` int(11) NOT NULL,
  `type` varchar(256) NOT NULL,
  `width` int(5) NOT NULL,
  `length` int(5) NOT NULL,
  `height` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `owner_id`, `house_id`, `type`, `width`, `length`, `height`) VALUES
(2, 33, 1, 'Living room', 1500, 3000, 3000),
(3, 33, 1, 'Toilet', 2000, 2000, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(4) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `admin`) VALUES
(32, 'Test User', 'test@test.nl', 'test', 0),
(33, 'Test Admin', 'test@admin.nl', 'admin', 1),
(34, 'Ruud ruud ', 'rudie@hotmail.com', 'hello1123', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`house_id`),
  ADD KEY `Foreign key owner` (`owner_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `Foreign key house` (`house_id`) USING BTREE,
  ADD KEY `Foreign key owner` (`owner_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `houses`
--
ALTER TABLE `houses`
  ADD CONSTRAINT `Foreign key owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `house_id` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`),
  ADD CONSTRAINT `owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
