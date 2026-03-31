-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 07:39 PM
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
-- Database: `dormitory`
--

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomNumber` char(4) NOT NULL,
  `typeID` char(3) NOT NULL,
  `tenantName` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ว่าง',
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomNumber`, `typeID`, `tenantName`, `status`, `image`) VALUES
('101', 'T01', 'สรวิช นะจ้ะ', 'มีคนเช่า', 'images.jpg'),
('102', 'T01', '', 'ว่าง', NULL),
('201', 'T02', 'สาระ หน่อยดิ', 'มีคนเช่า', NULL),
('202', 'T02', NULL, 'ว่าง', NULL),
('301', 'T03', 'พงศกร หมอนทอง', 'มีคนเช่า', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `typeID` char(3) NOT NULL,
  `typeName` varchar(30) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`typeID`, `typeName`, `price`) VALUES
('T01', 'ห้องพัดลม', 2500),
('T02', 'ห้องแอร์ธรรมดา', 3500),
('T03', 'ห้องแอร์ VIP (วิวสวยจัด)', 4500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomNumber`),
  ADD KEY `typeID` (`typeID`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`typeID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `FK_room_type` FOREIGN KEY (`typeID`) REFERENCES `room_type` (`typeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
