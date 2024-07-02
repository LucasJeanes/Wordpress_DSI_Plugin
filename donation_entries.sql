-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 03:45 PM
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
-- Database: `donations`
--

-- --------------------------------------------------------

--
-- Table structure for table `donation_entries`
--

CREATE TABLE `donation_entries` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_entries`
--

INSERT INTO `donation_entries` (`id`, `amount`, `date`) VALUES
(1, 100.00, '2024-06-14 14:19:04'),
(2, 500.00, '2024-06-14 14:20:25'),
(3, 500.00, '2024-06-14 14:20:43'),
(4, 300.00, '2024-06-14 14:20:43'),
(5, 200.00, '2024-06-14 14:20:43'),
(6, 150.00, '2024-06-14 14:20:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donation_entries`
--
ALTER TABLE `donation_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donation_entries`
--
ALTER TABLE `donation_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
