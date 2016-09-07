-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 07, 2016 at 06:50 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pepbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(20) NOT NULL AUTO_INCREMENT,
  `userFullName` varchar(50) NOT NULL,
  `userName` varchar(20) DEFAULT NULL,
  `userPassword` varchar(100) NOT NULL,
  `userAccountCreatedTime` datetime NOT NULL,
  `userLevel` int(1) NOT NULL DEFAULT '0',
  `userBanned` int(1) NOT NULL DEFAULT '0',
  `userEmail` varchar(50) NOT NULL,
  `userPhone` varchar(11) DEFAULT NULL,
  `collegeId` int(11) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmail` (`userEmail`),
  UNIQUE KEY `userPhone` (`userPhone`),
  KEY `collegeId` (`collegeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userFullName`, `userName`, `userPassword`, `userAccountCreatedTime`, `userLevel`, `userBanned`, `userEmail`, `userPhone`, `collegeId`) VALUES
(5, 'Jude Osbert K', NULL, '$2y$10$jTX3xpbuQpI3LoRvHqodEu2euvZXrLJCQDeFReFXfPMqhfA.1rhAK', '2016-09-07 12:52:51', 0, 0, 'jude.osbertk2014@vit.ac.in', NULL, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`collegeId`) REFERENCES `academicDomains` (`academicId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
