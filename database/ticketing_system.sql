-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 09:17 AM
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
-- Database: `ticketing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `AdminUsername` varchar(50) NOT NULL,
  `AdminPassword` varchar(50) NOT NULL,
  `AdminEmail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `TimeSlotId` int(11) DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `VenueAddress` varchar(255) DEFAULT NULL,
  `VenueCascadedDropdown` varchar(255) DEFAULT NULL,
  `StateCityAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `OrgID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `ContactEmail` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Status` enum('Approved','Pending','Rejected') DEFAULT 'Pending',
  `ReasonofRegection` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Date` date DEFAULT NULL,
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
  `UserPassword` varchar(50) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
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
  ADD PRIMARY KEY (`OrgID`);

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
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`OrgID`) REFERENCES `organizations` (`OrgID`);

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
