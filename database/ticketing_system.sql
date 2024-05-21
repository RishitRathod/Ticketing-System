-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 02:06 PM
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
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `AdminUsername`, `Password`, `Email`) VALUES
(1, 'aryan', '$2y$10$VjB8.iWew5BURxaT2IMJ8OS8vKm3NgCRJDOXG5sh3zNMOUUTA9xRC', 'aryanmahida2@gmail.com'),
(2, 'aryan', '$2y$10$7UQoP9lIJD6V2jZK/I1fPe3oWPHZgzwPSjaRNzoNLZR2f5Misct3a', '');

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
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `ContactNumber` int(20) DEFAULT NULL,
  `ContactEmail` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Status` enum('Approved','Pending','Rejected') DEFAULT 'Pending',
  `ReasonofRegection` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`OrgID`, `Name`, `Password`, `Email`, `ContactNumber`, `ContactEmail`, `Address`, `Status`, `ReasonofRegection`) VALUES
(1, 'name', 'password', 'email', 1234567890, 'contactEmail', 'address', 'Pending', NULL),
(2, 'Aryan Jagdishbhai mahida', '1234567890', 'aryan.mahida118299@marwadiuniversity.ac.in', 1234567890, 'aryanmahida2@gmai.com', '\"ARYAN \" st. no.  1 , ambedkarnagar co.op society, op. love temple,  kalavad road, rajkot', 'Pending', NULL),
(3, 'Rishit', '$2y$10$b0HgDbD5227ORXm0Y4nyp.lWDxL8OTsjyiy8hu/FnWL', 'aryanmahida619@gmail.com', 1234567890, 'aryanmahida619@gmail.com', 'sasti seri probandar ni', 'Pending', NULL),
(4, 'Aryan Jagdishbhai mahida', '$2y$10$q7aN7j8pu1.YbWp9woPd1uHRFy2TOCA/noVhMB8xvfp/xJEYrKE06', 'chandrasinh.parmar@marwadieducation.edu.in', 1234567890, 'chandrasinh.parmar@marwadieducation.edu.in', '\"ARYAN \" st. no.  1 , ambedkarnagar co.op society, op. love temple,  kalavad road, rajkot', 'Pending', NULL);

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
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UserPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `UserPhoto`) VALUES
(7, 'ary', '$2y$10$9kMCJqDjsJEg0thF.X9l.ubGVwr0AxMBRcMLMVimipzw2YQyXsEY2', 'ar@gamil.com', 'uploads/ary/hitler.jpeg');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `PakageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticketsales`
--
ALTER TABLE `ticketsales`
  MODIFY `TicketSalesID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `TimeSlotID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeusage`
--
ALTER TABLE `timeusage`
  MODIFY `TimeUsageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
