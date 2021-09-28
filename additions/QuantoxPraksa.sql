-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 27, 2021 at 10:46 AM
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
  `naziv` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grupe`
--

INSERT INTO `grupe` (`id`, `naziv`) VALUES
(1, 'Čačak'),
(2, 'Kragujevac'),
(3, 'Beograd'),
(4, 'Novi Sad');

-- --------------------------------------------------------

--
-- Table structure for table `mentori`
--

CREATE TABLE `mentori` (
  `id` int(11) NOT NULL,
  `ime` varchar(64) NOT NULL,
  `prezime` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `telefon` varchar(64) NOT NULL,
  `id_grupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mentori`
--

INSERT INTO `mentori` (`id`, `ime`, `prezime`, `email`, `telefon`, `id_grupe`) VALUES
(1, 'Davonte', 'Fritsch', 'berge.ephraim@yahoo.com', '332-766-8172', 4),
(2, 'Edgardo', 'Toy', 'cherzog@hotmail.com', '(449)412-5601x236', 3),
(3, 'Hugh', 'Weimann', 'ulesch@monahan.com', '1-066-115-9261', 1),
(4, 'Savion', 'Ortiz', 'cade.vandervort@yahoo.com', '1-565-071-8163', 3),
(5, 'Colton', 'Hessel', 'shaniya.mcclure@gmail.com', '+82(6)5220380630', 2),
(6, 'Adriana', 'Kunde', 'ledner.melany@hayes.com', '08146040181', 1),
(7, 'Tamia', 'Gerhold', 'hahn.gloria@bartell.com', '(611)832-2803', 4);

-- --------------------------------------------------------

--
-- Table structure for table `praktikanti`
--

CREATE TABLE `praktikanti` (
  `id` int(11) NOT NULL,
  `ime` varchar(64) NOT NULL,
  `prezime` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `telefon` varchar(64) NOT NULL,
  `id_grupe` int(11) NOT NULL,
  `komentar` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `praktikanti`
--

INSERT INTO `praktikanti` (`id`, `ime`, `prezime`, `email`, `telefon`, `id_grupe`, `komentar`) VALUES
(1, 'Eliseo', 'Mertz', 'olson.selena@yahoo.com', '223-057-5635', 1, ''),
(2, 'Sherwood', 'Ebert', 'nfritsch@gmail.com', '063-981-1222', 3, ''),
(3, 'Lorenz', 'Beier', 'thalvorson@auer.com', '135-608-0873', 4, ''),
(4, 'Wayne', 'Kemmer', 'purdy.rashad@shields.org', '+80(9)4682643417', 3, ''),
(5, 'Lizeth', 'Rau', 'qsawayn@jakubowski.com', '(301)714-7757x22840', 2, ''),
(6, 'Winona', 'Fay', 'herman.tina@monahan.com', '+00(3)8727814591', 1, ''),
(7, 'Stella', 'Aufderhar', 'mosciski.vesta@hotmail.com', '(281)994-1978', 4, ''),
(8, 'Lukas', 'Schneider', 'augustine.gaylord@yahoo.com', '(315)805-6059x75719', 2, ''),
(9, 'Reggie', 'Beier', 'haley.vicente@hirthe.info', '218-557-2101', 2, ''),
(10, 'Reva', 'Prosacco', 'fay.maxwell@gmail.com', '869-854-6504', 1, ''),
(11, 'Imani', 'Abshire', 'fay.gust@yahoo.com', '273.367.6070x98938', 3, ''),
(12, 'Ena', 'Wisoky', 'colten59@yahoo.com', '324-794-6799x1743', 4, ''),
(13, 'Vada', 'Rice', 'damon.aufderhar@gmail.com', '(446)249-4269x1095', 2, ''),
(14, 'Vickie', 'Lang', 'sid.rodriguez@jakubowski.biz', '(248)700-8890x376', 3, ''),
(15, 'Milan', 'Mills', 'onienow@hotmail.com', '+81(6)4281695785', 3, '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mentori`
--
ALTER TABLE `mentori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `praktikanti`
--
ALTER TABLE `praktikanti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
