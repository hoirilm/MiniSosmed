-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2019 at 06:09 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Table structure for table `follow_users`
--

CREATE TABLE `follow_users` (
  `EMAIL` varchar(30) NOT NULL,
  `USE_EMAIL` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posting`
--

CREATE TABLE `posting` (
  `ID_POSTING` int(11) NOT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `POSTING` longtext,
  `TGL_POSTING` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `EMAIL` varchar(30) NOT NULL,
  `NAMA` varchar(30) DEFAULT NULL,
  `TGL_LAHIR` date DEFAULT NULL,
  `JK` varchar(10) DEFAULT NULL,
  `FOTO` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`EMAIL`, `NAMA`, `TGL_LAHIR`, `JK`, `FOTO`, `PASSWORD`) VALUES
('admin@gmail.com', 'adminD', '2017-01-01', 'Laki-laki', 'foto.png', '118ce622ea04079b64e8668ed91f16489dae763168ef03a03d0f3a00cb7ad5e2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow_users`
--
ALTER TABLE `follow_users`
  ADD PRIMARY KEY (`EMAIL`,`USE_EMAIL`),
  ADD KEY `FK_RELATIONSHIP_3` (`USE_EMAIL`);

--
-- Indexes for table `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`ID_POSTING`),
  ADD KEY `FK_RELATIONSHIP_1` (`EMAIL`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posting`
--
ALTER TABLE `posting`
  MODIFY `ID_POSTING` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follow_users`
--
ALTER TABLE `follow_users`
  ADD CONSTRAINT `FK_FOLLOW_USERS` FOREIGN KEY (`EMAIL`) REFERENCES `user` (`EMAIL`),
  ADD CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`USE_EMAIL`) REFERENCES `user` (`EMAIL`);

--
-- Constraints for table `posting`
--
ALTER TABLE `posting`
  ADD CONSTRAINT `FK_RELATIONSHIP_1` FOREIGN KEY (`EMAIL`) REFERENCES `user` (`EMAIL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
