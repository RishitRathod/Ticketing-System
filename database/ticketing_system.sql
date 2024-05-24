-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 07:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `AdminUsername` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `AdminUsername`, `Password`, `Email`) VALUES
(3, 'r', '$2y$10$VnRUJhqyCEe8R/v7vhn1GuIkNBpVNEy69b8m94H9ZnIR2j1rD7mzy', 'r@gmail.com\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `EventName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `EventType` enum('Beauty','Business','Comedy','Culture','Dance','Education','Experience','Health','Music','Sports') NOT NULL,
  `EventPoster` varchar(255) DEFAULT NULL,
  `QR_CODE` varchar(255) DEFAULT NULL,
  `VenueAddress` varchar(255) DEFAULT NULL,
  `VenueCascadedDropdown` varchar(255) DEFAULT NULL,
  `StateCityAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `OrgID`, `EventName`, `Description`, `StartDate`, `EndDate`, `Capacity`, `EventType`, `EventPoster`, `QR_CODE`, `VenueAddress`, `VenueCascadedDropdown`, `StateCityAddress`) VALUES
(27, 2, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Beauty', NULL, NULL, '', NULL, NULL),
(28, 1, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Beauty', NULL, NULL, '', NULL, NULL),
(29, 3, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Beauty', NULL, NULL, '', NULL, NULL),
(31, 2, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Beauty', NULL, NULL, '', NULL, NULL),
(41, 1, 'kkkkkkkkkk', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', NULL, NULL, NULL, NULL, NULL),
(42, 1, 'wfwew', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', NULL, NULL, NULL, NULL, NULL),
(72, 4, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `OrgID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `ContactEmail` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Status` enum('Approved','Pending','Rejected') DEFAULT 'Pending',
  `ReasonofRegection` text DEFAULT NULL,
  `PakageID` int(11) DEFAULT NULL,
  `ContactName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`OrgID`, `Name`, `Password`, `Email`, `ContactNumber`, `ContactEmail`, `Address`, `Status`, `ReasonofRegection`, `PakageID`, `ContactName`) VALUES
(1, 'Tech Innovators', '$2y$10$QUfy1XP2sddSqiK2yf4PH.EY7ufAaezvWRa/wKqbl8GV7k4EpjQb2', 'rishirathod645@gmail.com', '123-456-7890', 'johndoe@techinnovators.com', 'Millpara Street No 1 \"Harshad Nivas\"', 'Pending', NULL, NULL, 'John Doe'),
(2, 'r', '$2y$10$Wqx8hmaWDGnpah3cG/DK2.ZQprIwiWB3xpbD1omqSbr', 'rishirathod6445@gmail.com', '1234', 'asfghj1@gmail.com', 'c', 'Pending', NULL, NULL, ''),
(3, '', '$2y$10$efCR78RlLH9D6VdNlsMx.ezsfSLCx6i3djHZZ.BDTWrWnmHAOEwk6', '', '', '', '', 'Rejected', 'no nedd', NULL, ''),
(4, 'jkhgbfvc', '$2y$10$zKtWO9o.vs.upzQeLJKd0evcOy.a4SNnIZP.FmwR9BSHvGzSp26T2', 'dcsddsd@gmail.com', '098765432', 'hgfasfghj@gmail.com', 'jhgbfvcxz', 'Pending', NULL, NULL, ''),
(5, 'rrr', '$2y$10$.gny9pR/KHEM/blU77yoDO39HJnpEG2qlntXjwraJwR8BDZsrrkA6', 'df@gmail.com', '1234t', 'asfgdfdfdhj@gmail.com', 'asdffwefb', 'Pending', NULL, NULL, ''),
(6, 'kirtan1234', '$2y$10$UrsdPUBu33tnbMhhDb3S5eSmlH4ua3G0A0PyH0/.SB/Sqp0z/IUh.', 'dcsddfefwefwesd@gmail.com', '123456789', 'asfgddefwefewfewwfewfdfdhj@gmail.com', 'Millpara Street No 1 \"Harshad Nivas\"', 'Pending', NULL, NULL, ''),
(7, 'mahida', '$2y$10$dMCwtTXAX5uBFwvXXhLB6O.zRL0GYOEbShBSjq59CQj6wtiF50qEu', 'mahida@gmail.com', '6731746328', 'Mahida123@gmail.com', 'esrdfhjkm', 'Pending', NULL, NULL, ''),
(8, 'jjjk', '$2y$10$JbJ/mug1QQ/ZXGXkBHFAEe1R7ImRGhDUe4oO9IYNjLfW9WOh/6PYq', 'jj@gmail.com', '12345678987654', 'jjj@gmail.cvom', 'aewrdfghbjn', 'Pending', NULL, NULL, 'kkit');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `PakageID` int(11) NOT NULL,
  `PakageName` varchar(100) NOT NULL,
  `PakageType` enum('TimeBased','TicketBased') NOT NULL,
  `Amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `TicketID` int(11) NOT NULL,
  `TicketType` enum('Regular','VIP','Use in Any timeslot') NOT NULL,
  `EventID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `QR_CODE` varchar(255) DEFAULT NULL,
  `LimitQuantity` int(11) DEFAULT NULL,
  `Discount` decimal(10,2) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`TicketID`, `TicketType`, `EventID`, `Quantity`, `QR_CODE`, `LimitQuantity`, `Discount`, `Price`) VALUES
(4, 'Regular', 28, 5, NULL, 4, 2.00, 1.00),
(6, 'VIP', 31, NULL, NULL, NULL, NULL, NULL),
(7, '', 27, 0, NULL, 0, 0.00, 0.00),
(8, '', 27, 0, NULL, 0, 0.00, 4.00),
(9, '', 27, 0, NULL, 0, 443.00, 0.00),
(10, '', 27, 0, NULL, 0, 44.00, 0.00),
(12, 'Regular', 27, 0, NULL, 0, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `ticketsales`
--

CREATE TABLE `ticketsales` (
  `TicketSalesID` int(11) NOT NULL,
  `TicketID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `TimeSlotID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Availability` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timeusage`
--

CREATE TABLE `timeusage` (
  `TimeUsageID` int(11) NOT NULL,
  `TicketID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `EntryTime` datetime DEFAULT NULL,
  `ExitTime` datetime DEFAULT NULL,
  `TimeslotID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UserPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `OrgID` (`OrgID`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`OrgID`),
  ADD KEY `FK_Package` (`PakageID`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`PakageID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `ticketsales`
--
ALTER TABLE `ticketsales`
  ADD PRIMARY KEY (`TicketSalesID`),
  ADD KEY `TicketID` (`TicketID`),
  ADD KEY `EventID` (`EventID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`TimeSlotID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `timeusage`
--
ALTER TABLE `timeusage`
  ADD PRIMARY KEY (`TimeUsageID`),
  ADD KEY `TicketID` (`TicketID`),
  ADD KEY `EventID` (`EventID`),
  ADD KEY `TimeslotID` (`TimeslotID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`);

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `FK_Package` FOREIGN KEY (`PakageID`) REFERENCES `packages` (`PakageID`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`);

--
-- Constraints for table `ticketsales`
--
ALTER TABLE `ticketsales`
  ADD CONSTRAINT `ticketsales_ibfk_1` FOREIGN KEY (`TicketID`) REFERENCES `tickets` (`TicketID`),
  ADD CONSTRAINT `ticketsales_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`),
  ADD CONSTRAINT `ticketsales_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD CONSTRAINT `timeslots_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`);

--
-- Constraints for table `timeusage`
--
ALTER TABLE `timeusage`
  ADD CONSTRAINT `timeusage_ibfk_1` FOREIGN KEY (`TicketID`) REFERENCES `tickets` (`TicketID`),
  ADD CONSTRAINT `timeusage_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `events` (`EventID`),
  ADD CONSTRAINT `timeusage_ibfk_3` FOREIGN KEY (`TimeslotID`) REFERENCES `timeslots` (`TimeSlotID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
