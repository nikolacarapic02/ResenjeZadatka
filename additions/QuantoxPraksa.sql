-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 30, 2021 at 05:15 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `QuantoxPraksa`
--

-- --------------------------------------------------------

--
-- Table structure for table `grupe`
--

CREATE TABLE `grupe` (
  `id` int(11) NOT NULL,
  `naziv` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mentori`
--

CREATE TABLE `mentori` (
  `id` int(11) NOT NULL,
  `ime` varchar(128) NOT NULL,
  `prezime` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefon` varchar(128) NOT NULL,
  `id_grupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `praktikanti`
--

CREATE TABLE `praktikanti` (
  `id` int(11) NOT NULL,
  `ime` varchar(128) NOT NULL,
  `prezime` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefon` varchar(128) NOT NULL,
  `id_grupe` int(11) NOT NULL,
  `komentar` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grupe`
--
ALTER TABLE `grupe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentori`
--
ALTER TABLE `mentori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupe` (`id_grupe`);

--
-- Indexes for table `praktikanti`
--
ALTER TABLE `praktikanti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupe` (`id_grupe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grupe`
--
ALTER TABLE `grupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `mentori`
--
ALTER TABLE `mentori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `praktikanti`
--
ALTER TABLE `praktikanti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mentori`
--
ALTER TABLE `mentori`
  ADD CONSTRAINT `mentori_idfk_1` FOREIGN KEY (`id_grupe`) REFERENCES `grupe` (`id`);

--
-- Constraints for table `praktikanti`
--
ALTER TABLE `praktikanti`
  ADD CONSTRAINT `praktikanti_idfk_1` FOREIGN KEY (`id_grupe`) REFERENCES `grupe` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
