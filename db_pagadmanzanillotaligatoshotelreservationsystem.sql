-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 05:12 PM
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
-- Database: `db_pagadmanzanillotaligatoshotelreservationsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminID` int(11) NOT NULL,
  `adminName` varchar(100) NOT NULL,
  `adminPass` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminID`, `adminName`, `adminPass`) VALUES
(1, 'admin', '$2y$10$WNt1otu6OdQalgMePDUdJeyL3s6v.ScU640fBCAPALL6L9ZyeBJYu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guests`
--

CREATE TABLE `tbl_guests` (
  `guestID` int(11) NOT NULL,
  `guestName` varchar(50) DEFAULT NULL,
  `guestContact` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='guest information of hotel reservation';

--
-- Dumping data for table `tbl_guests`
--

INSERT INTO `tbl_guests` (`guestID`, `guestName`, `guestContact`) VALUES
(1, 'Tester Anderson', '09111111111'),
(2, 'Another Test', '11111111112'),
(3, 'Zion Pagad', '1234568910'),
(4, 'Another Reservation', '66666666666');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `paymentID` int(11) NOT NULL,
  `guestID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `paymentSubTotal` decimal(8,2) NOT NULL,
  `paymentDiscount` decimal(8,2) NOT NULL,
  `paymentGrandTotal` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`paymentID`, `guestID`, `reservationID`, `paymentSubTotal`, `paymentDiscount`, `paymentGrandTotal`) VALUES
(1, 1, 1, 2200.00, 0.00, 2200.00),
(2, 2, 2, 2520.00, 0.00, 2520.00),
(3, 3, 3, 315.00, 0.00, 315.00),
(4, 4, 4, 2000.00, 300.00, 1700.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `reservationID` int(11) NOT NULL,
  `guestID` int(11) NOT NULL,
  `reservationDate` date DEFAULT NULL,
  `reservationStartDate` date DEFAULT NULL,
  `reservationEndDate` date DEFAULT NULL,
  `reservationRoomType` varchar(7) DEFAULT NULL,
  `reservationRoomCapacity` varchar(6) DEFAULT NULL,
  `reservationPaymentType` varchar(11) DEFAULT NULL,
  `reservationNoOfDays` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`reservationID`, `guestID`, `reservationDate`, `reservationStartDate`, `reservationEndDate`, `reservationRoomType`, `reservationRoomCapacity`, `reservationPaymentType`, `reservationNoOfDays`) VALUES
(1, 1, '2026-03-31', '2026-03-31', '2026-04-02', 'Suite', 'Family', 'Credit Card', 2),
(2, 2, '2026-03-31', '2026-03-31', '2026-04-08', 'Deluxe', 'Single', 'Check', 8),
(3, 3, '2026-03-31', '2026-04-15', '2026-04-16', 'Deluxe', 'Single', 'Check', 1),
(4, 4, '2026-03-31', '2026-03-31', '2026-04-10', 'Regular', 'Double', 'Cash', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `tbl_guests`
--
ALTER TABLE `tbl_guests`
  ADD PRIMARY KEY (`guestID`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `guestID` (`guestID`),
  ADD KEY `reservationID` (`reservationID`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `guestID` (`guestID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_guests`
--
ALTER TABLE `tbl_guests`
  MODIFY `guestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `fk_payment_reservation` FOREIGN KEY (`reservationID`) REFERENCES `tbl_reservation` (`reservationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_payments_ibfk_1` FOREIGN KEY (`guestID`) REFERENCES `tbl_guests` (`guestID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD CONSTRAINT `tbl_reservation_ibfk_1` FOREIGN KEY (`guestID`) REFERENCES `tbl_guests` (`guestID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
