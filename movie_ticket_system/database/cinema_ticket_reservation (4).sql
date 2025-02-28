-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 11:10 AM
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
-- Database: `cinema_ticket_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `AdminID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `OfficePhone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`AdminID`, `UserID`, `OfficePhone`) VALUES
(1, 1, '011165558755');

-- --------------------------------------------------------

--
-- Table structure for table `available_seat`
--

CREATE TABLE `available_seat` (
  `SeatID` int(11) NOT NULL,
  `SeatLevel` varchar(20) DEFAULT NULL,
  `ScheduleID` int(11) DEFAULT NULL,
  `seatNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_seat`
--

INSERT INTO `available_seat` (`SeatID`, `SeatLevel`, `ScheduleID`, `seatNo`) VALUES
(0, 'Standard', 4, 10),
(2, 'vip', 2, 23),
(3, 'vip', 2, 25),
(9, 'vip', 2, 27),
(11, 'vip', 2, 21),
(12, 'vip', 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `MovieID` int(11) DEFAULT NULL,
  `SeatID` int(11) DEFAULT NULL,
  `Rating` int(1) NOT NULL,
  `FeedbackDescription` text DEFAULT NULL,
  `FeedbackDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `MovieID`, `SeatID`, `Rating`, `FeedbackDescription`, `FeedbackDate`, `UserID`) VALUES
(1, NULL, NULL, 0, 'hwo are you', '2025-02-22 19:13:46', NULL),
(2, 1, NULL, 5, 'which is best', '2025-02-24 22:14:57', 13);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `MovieID` int(11) NOT NULL,
  `MovieTitle` varchar(255) DEFAULT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `Director` varchar(100) DEFAULT NULL,
  `Cast` text DEFAULT NULL,
  `CreatedDate` date DEFAULT NULL,
  `ProfileImage` varchar(255) DEFAULT NULL,
  `movie_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`MovieID`, `MovieTitle`, `Genre`, `Director`, `Cast`, `CreatedDate`, `ProfileImage`, `movie_description`) VALUES
(1, 'behig amlak', 'amharic full films', 'alemayehu', 'tariku baba,birhane', '2025-01-30', 'unale.jpeg', 'betawickiw actor tarik yetetewene wesagn yehone film'),
(2, 'lefikir sil', 'amharic full film', 'Adisalemayehu', 'mandela,selam', '2025-02-14', 'lefikir sil.jfif', 'te\r\n\r\nThe description introduces the storyline, main characters, and the kind of themes explored in the movie, such as societal pressure, love, and survival.'),
(3, 'kiya', 'amharic full film', 'getachew', 'keede,abebe', '2025-02-13', 'áŠªá‹«.jpg', 'adiss amergna film'),
(5, 'wuririd', 'amharic full film', 'abera', 'ayalnesh,alemitu,alex', '2025-02-07', 'áŠ¥áŠ•á‹° áˆ€áŒˆáˆ­.jpg', 'adis ameregna film'),
(6, 'gize mizan', 'amharic full film', 'belaynesh', 'ayalnesh,alemitu,alex', '2025-02-10', 'áŒŠá‹œ áˆšá‹›áŠ•.jpg', 'bene alex movie production yetesera'),
(7, 'Yetemeretutin', 'Amharic Full film', 'Tesema', 'tesema,temesgen,belete', '2025-02-01', 'yetemeretutin.jfif', 'be tawakai actor yete tewene film'),
(8, 'yagebagnalsw', 'Amharic Full film', 'temesgen', 'tesema,temesgen,belete', '2025-01-30', 'yagebagnal.jfif', 'be dibora records yetesera'),
(9, 'yale esu', 'Amharic Full film', 'belete', 'tesema,temesgen,belete', '2025-02-06', 'yale esu.jfif', 'be dibora records yetesera'),
(10, 'yeleba lig', 'Amharic Full film', 'ahlam', 'tesema,temesgen,belete', '2025-02-06', 'yeleba lig.jfif', 'be dibora records yetesera'),
(11, 'yewendoch good', 'Amharic Full film', 'ahlam', 'tesema,temesgen,belete', '2025-02-27', 'yewndoch gud.jfif', 'be dibora records yetesera'),
(12, 'hulet leand', 'Amharic Full film', 'ahlam', 'tesema,temesgen,belete', '2025-02-16', 'hulet le And.jfif', 'be dibora records yetesera');

-- --------------------------------------------------------

--
-- Table structure for table `movie_schedule`
--

CREATE TABLE `movie_schedule` (
  `ScheduleID` int(11) NOT NULL,
  `MovieID` int(11) DEFAULT NULL,
  `StartTime` datetime DEFAULT NULL,
  `EndTime` datetime DEFAULT NULL,
  `Duration` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `total_seat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_schedule`
--

INSERT INTO `movie_schedule` (`ScheduleID`, `MovieID`, `StartTime`, `EndTime`, `Duration`, `amount`, `total_seat`) VALUES
(2, 7, '2025-02-08 15:24:00', '2025-02-02 17:24:00', '2 hours', 10.00, 100),
(3, 6, '2025-02-14 15:26:00', '2025-02-14 19:26:00', '4 hours', 15.00, 100),
(4, 6, '2025-02-24 21:04:23', '2025-02-24 21:06:23', '2 hours', 19.00, 100),
(5, 5, '2025-02-12 21:25:00', '2025-02-12 23:25:00', '2 hours', 19.00, 100),
(6, 1, '2025-02-25 01:48:00', '2025-02-25 05:38:00', '4', 9.00, 100),
(7, 5, '2025-02-25 03:07:00', '2025-02-25 06:04:00', '3 hours', 30.00, 57);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `UserID`, `Salary`) VALUES
(2, 11, 4000.00),
(3, 15, 8000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransactionID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `SeatID` int(11) NOT NULL,
  `TransactionDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Amount` decimal(10,2) NOT NULL,
  `tx_ref` varchar(255) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `status` enum('success','fail','pending') DEFAULT 'success',
  `ScheduleID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`TransactionID`, `MovieID`, `SeatID`, `TransactionDate`, `Amount`, `tx_ref`, `payment_method`, `UserID`, `status`, `ScheduleID`) VALUES
(6, 7, 1, '2025-02-23 18:52:07', 8.00, 'TX-1740336727', '0', 13, 'success', NULL),
(7, 7, 1, '2025-02-23 18:56:04', 8.00, 'TX-1740336964', '0', 13, 'success', NULL),
(9, 7, 1, '2025-02-23 19:05:15', 9.00, 'TX-1740337515', '0', 13, 'success', NULL),
(10, 7, 1, '2025-02-23 19:09:44', 9.00, 'TX-1740337784', '0', 13, 'success', NULL),
(11, 7, 1, '2025-02-23 19:19:48', 9.00, 'TX-1740338388', '0', 13, 'success', NULL),
(12, 7, 1, '2025-02-23 19:24:21', 9.00, 'TX-1740338661', '0', 13, 'pending', NULL),
(13, 7, 1, '2025-02-23 19:28:43', 8.00, 'TX-1740338923', '0', 13, 'pending', NULL),
(14, 7, 1, '2025-02-23 19:31:07', 214.00, 'TX-1740339067', '0', 13, 'pending', NULL),
(15, 7, 1, '2025-02-23 19:33:29', 214.00, 'TX-1740339209', '0', 13, 'pending', NULL),
(16, 7, 1, '2025-02-23 19:37:29', 214.00, 'TX-1740339449', '0', 13, 'pending', NULL),
(17, 7, 1, '2025-02-23 19:38:02', 214.00, 'TX-1740339482', '0', 13, 'pending', NULL),
(18, 7, 1, '2025-02-23 19:38:07', 214.00, 'TX-1740339487', '0', 13, 'pending', NULL),
(19, 7, 1, '2025-02-23 19:38:07', 214.00, 'TX-1740339487', '0', 13, 'pending', NULL),
(20, 7, 1, '2025-02-23 19:47:36', 8.00, 'TX-1740340056', '0', 13, 'pending', NULL),
(21, 7, 1, '2025-02-23 19:48:46', 8.00, 'TX-1740340126', '0', 13, 'pending', NULL),
(22, 7, 1, '2025-02-23 19:49:21', 8.00, 'TX-1740340161', '0', 13, 'pending', NULL),
(23, 7, 1, '2025-02-23 19:51:24', 800.00, 'TX-1740340284', '0', 13, 'pending', NULL),
(24, 7, 1, '2025-02-24 11:55:26', 98.00, 'TX-1740398126', '0', 13, 'pending', NULL),
(25, 7, 1, '2025-02-24 13:53:17', 98.00, 'TX-1740405196', '0', 14, 'pending', NULL),
(27, 7, 1, '2025-02-24 14:32:34', 98.00, 'TX-1740407554', 'telebirr', 14, 'pending', NULL),
(28, 7, 1, '2025-02-24 14:43:48', 98.00, 'TX-1740408228', 'telebirr', 14, 'pending', NULL),
(29, 7, 1, '2025-02-24 14:44:33', 98.00, 'TX-1740408273', 'telebirr', 14, 'pending', NULL),
(30, 7, 1, '2025-02-24 14:58:14', 98.00, 'TX-1740409094', 'telebirr', 14, 'pending', NULL),
(35, 7, 1, '2025-02-24 18:45:45', 98.00, 'TX-1740422745', 'telebirr', 14, 'pending', NULL),
(36, 7, 1, '2025-02-24 18:46:24', 98.00, 'TX-1740422784', 'telebirr', 14, 'pending', NULL),
(37, 7, 1, '2025-02-24 18:49:17', 98.00, 'TX-1740422957', 'telebirr', 14, 'pending', NULL),
(38, 7, 1, '2025-02-24 19:37:28', 98.00, 'TX-1740425848', 'telebirr', 14, 'pending', NULL),
(39, 7, 1, '2025-02-24 19:40:23', 98.00, 'TX-1740426023', 'telebirr', 14, 'pending', NULL),
(40, 7, 1, '2025-02-24 19:43:05', 98.00, 'TX-1740426185', 'telebirr', 14, 'pending', NULL),
(41, 7, 1, '2025-02-24 19:50:09', 98.00, 'TX-1740426609', 'telebirr', 14, 'pending', NULL),
(42, 7, 1, '2025-02-24 19:53:12', 98.00, 'TX-1740426791', 'telebirr', 14, 'pending', NULL),
(43, 7, 2, '2025-02-24 20:41:42', 98.00, 'TX-1740429702', 'telebirr', 14, 'pending', NULL),
(44, 7, 1, '2025-02-24 20:43:32', 98.00, 'TX-1740429812', 'telebirr', 14, 'pending', NULL),
(45, 7, 9, '2025-02-25 00:38:39', 963.00, 'TX-1740443919', 'telebirr', 13, 'pending', NULL),
(46, 7, 9, '2025-02-25 00:45:38', 963.00, 'TX-1740444338', 'telebirr', 13, 'pending', NULL),
(47, 7, 0, '2025-02-25 00:48:43', 963.00, 'TX-1740444523', 'telebirr', 13, 'pending', NULL),
(48, 7, 0, '2025-02-25 00:48:45', 963.00, 'TX-1740444525', 'telebirr', 13, 'pending', NULL),
(49, 7, 3, '2025-02-25 01:03:30', 700.00, 'TX-1740445410', 'telebirr', 13, 'pending', NULL),
(50, 7, 2, '2025-02-25 02:43:17', 700.00, 'TX-1740451397', 'telebirr', 13, 'pending', NULL),
(51, 7, 11, '2025-02-25 03:46:13', 70.00, 'TX-1740455173', 'telebirr', 15, 'pending', NULL),
(52, 7, 12, '2025-02-25 03:59:03', 70.00, 'TX-1740455943', 'telebirr', 15, 'pending', NULL),
(53, 7, 12, '2025-02-25 03:59:20', 70.00, 'TX-1740455960', 'mpesa', 15, 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `Lname` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Sex` enum('Male','Female','Other') NOT NULL,
  `Age` int(3) NOT NULL CHECK (`Age` > 0),
  `RegistrationDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Role` enum('Admin','Customer','Staff') NOT NULL,
  `profilephoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Fname`, `Lname`, `Email`, `Phone`, `Username`, `Password`, `Sex`, `Age`, `RegistrationDate`, `Role`, `profilephoto`) VALUES
(1, 'Tesema', 'Melka', 'melkatesema@gmail.com', '0935433756', 'tese', '$2y$10$0Z2pt5wxPbZ7NOAowfR8w.UxK.EMxHSUYrypigpgXeomBpE/rqFee', 'Male', 22, '2025-02-22 18:49:41', 'Admin', NULL),
(11, 'Temesgens', 'degefa', 'temesgendegefa@gmail.com', '0963755163', 'temu', '$2y$10$XxQ.PGPT2SkTpB21oHCypuEBNZZUY0AAKdECb5ysQZcWuyhfyJzUK', 'Male', 23, '2025-02-22 19:26:25', 'Staff', NULL),
(13, 'demelash', 'gijamew', 'deme@gmail.com', '0965263526', 'deme', '$2y$10$CoqtvOs7JoC/IOAIMBK8kOsYCJRJipFbQZzd/txVcreX9M.EwnxyW', 'Male', 25, '2025-02-23 02:31:34', 'Customer', NULL),
(14, 'Belete', 'sisay', '21bsisay@gmail.com', '0928355613', 'bele', '$2y$10$Z3ITWB3/OSEQmggBJOz8cu0QKAVe8HF66owNN98ZVd9O7JzVgphey', 'Male', 23, '2025-02-23 20:37:27', 'Customer', NULL),
(15, 'ahlam', 'sied', 'ahlam@df.dr', '0900112233', 'ahl', '$2y$10$fu5on0jyM3ONmgxTl008K.KyXjXrbYxxM/L5/gxNFqPNC5EFHnkAq', 'Male', 98, '2025-02-24 10:14:45', 'Staff', 'default.jpg'),
(16, 'gemitew', 'reda', 'gemitew@hg.lg', '096456877', 'geme', '$2y$10$26OpN5NUQwJxQLZUH0Gq0O/H8uUvUj6BxSZQ3IIqGC3ZtNq0GQqm2', 'Male', 32, '2025-02-25 03:31:32', 'Customer', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`AdminID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `available_seat`
--
ALTER TABLE `available_seat`
  ADD PRIMARY KEY (`SeatID`),
  ADD UNIQUE KEY `seatNo` (`seatNo`),
  ADD KEY `ScheduleID` (`ScheduleID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `fk_feedback_movie` (`MovieID`),
  ADD KEY `fk_feedback_seat` (`SeatID`),
  ADD KEY `fk_feedback_userid` (`UserID`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`MovieID`);

--
-- Indexes for table `movie_schedule`
--
ALTER TABLE `movie_schedule`
  ADD PRIMARY KEY (`ScheduleID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `fk_movie` (`MovieID`),
  ADD KEY `fk_seat` (`SeatID`),
  ADD KEY `fk_transactions_userid` (`UserID`),
  ADD KEY `fk_transactions_schedule` (`ScheduleID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Phone` (`Phone`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `MovieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `movie_schedule`
--
ALTER TABLE `movie_schedule`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `available_seat`
--
ALTER TABLE `available_seat`
  ADD CONSTRAINT `available_seat_ibfk_1` FOREIGN KEY (`ScheduleID`) REFERENCES `movie_schedule` (`ScheduleID`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_movie` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`MovieID`),
  ADD CONSTRAINT `fk_feedback_seat` FOREIGN KEY (`SeatID`) REFERENCES `available_seat` (`SeatID`),
  ADD CONSTRAINT `fk_feedback_userid` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `movie_schedule`
--
ALTER TABLE `movie_schedule`
  ADD CONSTRAINT `movie_schedule_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`MovieID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_movie` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`MovieID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transactions_schedule` FOREIGN KEY (`ScheduleID`) REFERENCES `movie_schedule` (`ScheduleID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transactions_userid` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
