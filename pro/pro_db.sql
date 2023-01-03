-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2023 at 11:53 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pro_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `item_id` int(11) NOT NULL,
  `item_description` varchar(150) NOT NULL,
  `item_uom` varchar(10) NOT NULL,
  `item_stock` float NOT NULL,
  `item_status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`item_id`, `item_description`, `item_uom`, `item_stock`, `item_status`) VALUES
(2, 'Mustrad oil', 'Ltr..', 5000, 'Y'),
(5, 'Bricks', 'no', 2000, 'Y'),
(6, 'Pencil', 'no', 12, 'Y'),
(7, 'Paper', 'Roll', 50, 'Y'),
(8, 'chalk', 'no', 200, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `user_pass` varchar(20) NOT NULL,
  `user_type` enum('A','S','M') NOT NULL,
  `user_status` enum('Y','N') NOT NULL,
  `read_permission` enum('Y','N') NOT NULL,
  `view_permission` enum('Y','N') NOT NULL,
  `edit_permission` enum('Y','N') NOT NULL,
  `delet_permission` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_id`, `user_name`, `user_login`, `user_pass`, `user_type`, `user_status`, `read_permission`, `view_permission`, `edit_permission`, `delet_permission`) VALUES
(1, 'admin', 'admin', 'admin@123', 'A', 'Y', 'Y', 'Y', 'Y', 'Y'),
(3, 'sandeep', 'sandeep', 'admin@123', 'S', 'Y', 'N', 'Y', 'N', 'N'),
(4, 'joy', 'joy', 'admin@123', 'S', 'Y', 'Y', 'Y', 'Y', 'N'),
(5, 'madhu', 'madhu', 'admin@123', 'S', 'Y', 'Y', 'Y', 'Y', 'N'),
(6, 'mahesh', 'mahesh', 'admin@123', 'M', 'Y', 'N', 'N', 'N', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
