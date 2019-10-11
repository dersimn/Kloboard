-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Oct 10, 2019 at 08:09 AM
-- Server version: 5.7.27
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kloboard`
--
CREATE DATABASE IF NOT EXISTS `kloboard` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `kloboard`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `klo_hash` varchar(64) NOT NULL,
  `message` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `klo_hash`, `message`, `created`, `ip`) VALUES
(3, 'foo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi et consectetur turpis. Curabitur tempor sit amet lacus tristique mollis.', '2019-10-10 08:07:06', '172.19.0.1'),
(4, 'foo', 'Aenean sed mi at nunc vestibulum varius quis nec risus. Suspendisse felis sapien, condimentum nec ipsum vitae, laoreet bibendum arcu. Phasellus eros ligula, pellentesque id tincidunt a, pharetra quis risus. Nullam convallis ornare laoreet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', '2019-10-10 08:07:13', '172.19.0.1'),
(5, 'foo', '$\\rm\\LaTeX$', '2019-10-10 08:07:21', '172.19.0.1'),
(6, 'foo', '😵😄', '2019-10-10 08:07:27', '172.19.0.1'),
(7, 'foo', 'Just a few things using *markdown*.', '2019-10-10 08:07:35', '172.19.0.1'),
(8, 'foo', '    var s = \"JavaScript syntax highlighting\";\r\n    alert(s);', '2019-10-10 08:07:51', '172.19.0.1'),
(9, 'foo', '#😵😄', '2019-10-10 08:08:01', '172.19.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `klos`
--

CREATE TABLE `klos` (
  `hash` varchar(64) NOT NULL,
  `short_url` varchar(64) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klos`
--
ALTER TABLE `klos`
  ADD PRIMARY KEY (`hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
