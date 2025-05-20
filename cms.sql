-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 01:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `contentId` int(11) NOT NULL,
  `templateId` int(11) DEFAULT NULL,
  `parentContentId` int(11) DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `width` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `backgroundColor` varchar(50) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `orderContent` int(11) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `fontcolor` varchar(100) DEFAULT NULL,
  `fontstyle` varchar(100) DEFAULT NULL,
  `fontsize` varchar(100) DEFAULT NULL,
  `fontfamily` varchar(100) DEFAULT NULL,
  `isclickable` bit(1) DEFAULT b'0',
  `padding` varchar(100) DEFAULT NULL,
  `margin` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`contentId`, `templateId`, `parentContentId`, `tag`, `width`, `height`, `backgroundColor`, `text`, `orderContent`, `imagePath`, `href`, `target`, `fontcolor`, `fontstyle`, `fontsize`, `fontfamily`, `isclickable`, `padding`, `margin`) VALUES
(37, 43, NULL, 'image', '200px', 'auto', NULL, NULL, 2, 'uploads/6826994986c1f_682698bae110d_494578437_1739118630308518_8518738164588727574_n.png', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(38, 43, NULL, 'image', '50px', '50px', NULL, NULL, 2, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(39, 43, NULL, 'image', '50px', '50px', NULL, NULL, 2, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(40, 44, NULL, 'image', '5%', 'auto', NULL, NULL, 2, 'uploads/6826a26a6f33a_logo-design.png', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(41, 44, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(42, 44, NULL, 'image', '25px', '25px', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(43, 46, NULL, 'image', '25px', 'auto', NULL, '', 1, 'uploads/6826a26a6f33a_logo-design.png', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(44, 46, NULL, 'image', '25px', '25px', NULL, '', 3, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(45, 46, NULL, 'image', '50px', '50px', NULL, '', 2, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(49, 45, NULL, 'h1', 'auto', 'auto', '', 'hello world', NULL, NULL, NULL, NULL, '#000000', 'Normal', '12', '', NULL, NULL, NULL),
(50, 45, NULL, 'h1', '', '', NULL, 'hahahahahahahaha', NULL, NULL, NULL, NULL, '#000000', 'Normal', 'px', '', NULL, NULL, NULL),
(51, 45, NULL, 'p', 'auto', 'auto', NULL, 'Ano baaa', NULL, NULL, NULL, NULL, '#000000', 'Normal', 'px', '', NULL, NULL, NULL),
(63, 73, NULL, 'h1', 'auto', 'auto', NULL, '', NULL, NULL, NULL, NULL, '#000000', 'Normal', 'px', '', NULL, NULL, NULL),
(64, 77, NULL, 'image', '25px', 'auto', NULL, NULL, 2, 'uploads/682712d41015a_682697ecaf550_Mermaid Chart - Create complex, visual diagrams with text. A smarter way of creating diagrams.-2025-05-14-205641.svg', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(65, 77, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(66, 77, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(73, 12, NULL, 'a', 'auto', 'auto', NULL, 'Home', NULL, NULL, 'preview.php?pageId=10', '', '#000000', 'Normal', '', '', NULL, '', ''),
(111, 93, NULL, 'image', '25px', 'auto', NULL, NULL, 2, 'uploads/6827842f66072_6826fcf25a076_6826a26a6f33a_logo-design.png', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(112, 93, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(113, 93, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(124, 97, NULL, 'image', '50px', 'auto', NULL, '', 2, 'uploads/6827d26fb7bd8_logo.svg', '', '', '#000000', NULL, '', '', b'1', '', ''),
(125, 97, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(126, 97, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(128, 99, NULL, 'image', '100%', '100vh', NULL, '', NULL, 'uploads/6827d44ddb223_hero.jpg', '', '', '#000000', NULL, '', '', NULL, '', ''),
(129, 99, NULL, 'h1', 'auto', 'auto', NULL, 'This is our school!', NULL, NULL, NULL, NULL, '#000000', 'Normal', 'px', '', NULL, NULL, NULL),
(132, 101, NULL, 'image', '50px', 'auto', NULL, '', 2, 'uploads/682810e2df48e_6826fcf25a076_6826a26a6f33a_logo-design.png', '', '', '#000000', NULL, '', '', b'1', '', ''),
(133, 101, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(134, 101, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(135, 102, NULL, 'image', '50px', 'auto', NULL, '', 0, 'uploads/682816c12f71d_images.jfif', '', '', '#000000', NULL, '', '', b'1', '', ''),
(139, 104, NULL, 'image', '25px', 'auto', NULL, NULL, 2, 'uploads/682816c12f71d_images.jfif', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(140, 104, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(141, 104, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(144, 105, NULL, 'a', 'auto', 'auto', NULL, 'Home', 0, NULL, 'preview.php?websiteId=35&pageId=39', '', '#000000', 'Normal', '', '', NULL, '', ''),
(145, 105, NULL, 'a', 'auto', 'auto', NULL, 'About', 0, NULL, 'preview.php??websiteId=35&pageId=40', '', '#000000', 'Normal', '', '', NULL, '', ''),
(146, 107, NULL, 'image', '50px', 'auto', NULL, '', 2, 'uploads/682825be6b381_logo.svg', '', '', '#000000', NULL, '', '', b'1', '', ''),
(147, 107, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(148, 107, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(149, 108, NULL, 'image', '500px', 'auto', NULL, '', 0, 'uploads/682826b521176_133468.jpg', '', '', '#000000', NULL, '', '', NULL, '', ''),
(150, 110, NULL, 'image', '25px', 'auto', NULL, NULL, 2, 'uploads/682825be6b381_logo.svg', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(151, 110, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(152, 110, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(154, 109, NULL, 'a', NULL, NULL, NULL, 'Enroll Now!', NULL, NULL, 'enroll.php?websiteId=36', '_blank', NULL, NULL, NULL, NULL, b'0', NULL, NULL),
(155, 109, NULL, 'a', NULL, NULL, NULL, 'Student Login', NULL, NULL, 'login.php?websiteId=36', '_blank', NULL, NULL, NULL, NULL, b'0', NULL, NULL),
(156, 109, NULL, 'a', NULL, NULL, NULL, 'Faculty Register', NULL, NULL, 'facultyregister.php?websiteId=36', '_blank', NULL, NULL, NULL, NULL, b'0', NULL, NULL),
(157, 107, NULL, 'a', '', '', NULL, 'Enroll Now!', 5, NULL, 'enroll.php?websiteId=36', '_blank', '#000000', NULL, '', '', b'0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `enrollmentform`
--

CREATE TABLE `enrollmentform` (
  `enrollmentId` int(11) NOT NULL,
  `websiteId` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` enum('M','F','N','') NOT NULL,
  `houseNo_streetName` varchar(255) NOT NULL,
  `baranggay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phoneNumber` varchar(13) NOT NULL,
  `course` varchar(255) NOT NULL,
  `semester` int(10) NOT NULL,
  `year` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `status` enum('approved','pending','rejected','') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollmentform`
--

INSERT INTO `enrollmentform` (`enrollmentId`, `websiteId`, `firstName`, `lastName`, `birthdate`, `sex`, `houseNo_streetName`, `baranggay`, `city`, `country`, `phoneNumber`, `course`, `semester`, `year`, `username`, `email`, `password`, `status`) VALUES
(7, 0, 'LORENZ', 'BACON', '2004-05-02', 'M', '239 ', 'LB', 'TAGIG', 'PH', '09081621251', 'BSIT', 0, '2025', 'RENZTGM', 'renztgmbacon@gmail.com', '$2y$10$e6leOIjdqBcZUhwap7kjrePXM2yLP4pYMC/tPVPu82aSkikXbUdr2', 'approved'),
(8, 0, 'JUAN DELA', 'BACON', '2000-05-01', 'M', 'ASDASD', 'ASDASD', 'ASDASD', 'PH', '09080660152', 'BSCS', 0, '2025', 'JUAN', 'juandelacruz@email.com', '$2y$10$0k1tkoIWX4wytenfh674mO/AzewQdK5R2LWjvsIlY.foHuuQLhI7S', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `facultyId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`facultyId`, `username`, `password`, `fullName`, `email`) VALUES
(1, 'faculty1', '$2y$10$V8r5OXpFEJ0BrPWIkqCv.eKFMz6iZKxElMtloJnFG07ytdam8ZD.u', 'faculty1', 'faculty1@email.com'),
(2, 'joseph', '$2y$10$DmayeLCxf7PxhqGvh1qswOu3CKEdOjEGTMB8/nGZhuTuy76CyioQy', 'JOSEPH BA', 'joseph@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `gradeId` int(11) NOT NULL,
  `enrollmentId` int(11) NOT NULL,
  `professor` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `dateRecorded` datetime DEFAULT current_timestamp(),
  `semester` varchar(20) NOT NULL DEFAULT '1st Sem',
  `schoolYear` varchar(20) NOT NULL DEFAULT '2024-2025'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`gradeId`, `enrollmentId`, `professor`, `subject`, `grade`, `dateRecorded`, `semester`, `schoolYear`) VALUES
(6, 7, 'Prof. Santos', 'Mathematics', '92', '2025-05-17 03:32:42', '1st Sem', '2024-2025'),
(7, 7, 'Prof. Reyes', 'English', '88', '2025-05-17 03:32:42', '1st Sem', '2024-2025'),
(8, 7, 'Prof. Cruz', 'Science', '90', '2025-05-17 03:32:42', '2nd Sem', '2024-2025'),
(9, 7, 'Prof. Dela Rosa', 'History', '85', '2025-05-17 03:32:42', '2nd Sem', '2024-2025'),
(10, 7, 'Prof. Lim', 'PE', '90', '2025-05-17 03:32:42', '3rd Sem', '2024-2025'),
(11, 8, 'JOSEPH BA', 'SP101', '90', '2025-05-17 14:22:25', '1st Sem', '2025-2026');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `pageId` int(11) NOT NULL,
  `websiteId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`pageId`, `websiteId`, `name`, `description`) VALUES
(3, 5, 'Home', NULL),
(16, 14, 'Home', NULL),
(17, 15, 'Home', NULL),
(19, 17, 'Home', NULL),
(25, 0, 'Home', NULL),
(33, 30, 'Home', NULL),
(37, 33, 'Home', NULL),
(38, 34, 'Home', NULL),
(39, 35, 'Home', NULL),
(40, 35, 'About', 'about'),
(41, 36, 'Home', NULL),
(42, 36, 'About', 'this is about page');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `templateId` int(11) NOT NULL,
  `pageId` varchar(100) DEFAULT NULL,
  `templateName` varchar(255) NOT NULL,
  `templateType` varchar(255) NOT NULL,
  `width` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `backgroundColor` varchar(255) NOT NULL,
  `borderValue` varchar(255) NOT NULL,
  `borderStyle` varchar(255) NOT NULL,
  `borderColor` varchar(255) NOT NULL,
  `flexDirection` varchar(255) NOT NULL,
  `alignItems` varchar(255) NOT NULL,
  `justifyContent` varchar(255) NOT NULL,
  `margin` varchar(255) NOT NULL,
  `padding` varchar(255) NOT NULL,
  `orderTemp` varchar(255) NOT NULL,
  `parentTemplateId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`templateId`, `pageId`, `templateName`, `templateType`, `width`, `height`, `backgroundColor`, `borderValue`, `borderStyle`, `borderColor`, `flexDirection`, `alignItems`, `justifyContent`, `margin`, `padding`, `orderTemp`, `parentTemplateId`) VALUES
(12, '3', 'Navigation2', 'Navigation', '100%', '80px', '#5500bb', '0', '0', '0', 'row', 'center', 'center', '0', '0', '1', NULL),
(13, '3', 'Div3_1', 'Division', '100%', '100Vh', '#fff000', '0', '0', '0', 'column', 'center', 'center', '0', '0', '2', NULL),
(43, '16', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(44, '0', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(45, '17', 'main', 'Content', '100%', '100vh', '#000fff', '0', '0', '#fff000', '0', 'center', 'center', '0', '0', '2', NULL),
(46, '17', 'Navigation', 'Navigation', '100%', '80px', '#fff000', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(73, '17', 'Section3', 'Content', '100%', '100vw', '#ff00bb', '0', '0', '#000000', 'row', 'center', 'center', '0', '0', '3', 0),
(77, '19', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(93, '33', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(97, '37', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(99, '37', '', '', '100%', '050vw', '#ffffff', '0', '0', '#000000', 'column', 'flex-start', 'flex-start', '0', '0', '2', 0),
(101, '38', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(102, '39', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(104, '40', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(105, '39', 'Left nav', 'Navigation', '200px', '50px', '#ffffff', '0', 'solid', '#000000', 'row', 'center', 'space-between', '0', '0', '2', 102),
(106, '39', 'Hero', 'Content', '100%', '50vh', '#a1a1a1', '0', 'solid', '#000000', 'row', 'flex-start', 'flex-start', '0', '0', '2', 0),
(107, '41', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(108, '41', 'Hero', 'Content', '100%', '50vh', '#949494', '0', 'solid', '#000000', 'row', 'center', 'center', '0', '0', '2', 0),
(109, '41', 'Second Div', 'Content', '100%', '100vh', '#bababa', '0', 'solid', '#ff9e9e', 'column', 'center', 'center', '0', '0', '3', 0),
(110, '42', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `password`, `fullName`, `email`) VALUES
(1, 'renztgm', '$2y$10$v47UI5so9E7RVVLL6NRbu.gw/dFUyijPIUlFuNWmwZHKTYhgFpu6S', 'jhonlorenzbacon', 'baconjhonlorenz@gmail.com'),
(2, 'rei', '$2y$10$IW36cRVD28oo5n6OwN9ZPOSEzV.aNVxrzhAJzPGowqpEISR3Pzvq2', 'riu delica', 'rei@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `websiteId` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`websiteId`, `pageId`, `name`, `logo`, `description`) VALUES
(5, 0, 'nkdjas', '682444577418d_495073040_2197303414074012_8272612189865387795_n.png', '125678986532'),
(14, 0, 'qwe', '6826994986c1f_682698bae110d_494578437_1739118630308518_8518738164588727574_n.png', 'qwe'),
(15, 0, 'Princeton', '6826a26a6f33a_logo-design.png', 'qwe'),
(30, 0, 'asdasd', '6827842f66072_6826fcf25a076_6826a26a6f33a_logo-design.png', 'asdasd'),
(33, 0, 'New Website', '6827d26fb7bd8_logo.svg', 'Princeton'),
(34, 0, 'lkasndlasndi', '682810b1bb256_6827d26fb7bd8_logo.svg', 'asdasdasd'),
(35, 0, 'PLMUN', '682816c12f71d_images.jfif', 'Plmun main hub'),
(36, 0, 'Website', '682825be6b381_logo.svg', 'New Website');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`contentId`),
  ADD KEY `templateId` (`templateId`),
  ADD KEY `parentContentId` (`parentContentId`);

--
-- Indexes for table `enrollmentform`
--
ALTER TABLE `enrollmentform`
  ADD PRIMARY KEY (`enrollmentId`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`facultyId`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`gradeId`),
  ADD KEY `enrollmentId` (`enrollmentId`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`pageId`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`templateId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`websiteId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `contentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `enrollmentform`
--
ALTER TABLE `enrollmentform`
  MODIFY `enrollmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `facultyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `gradeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `pageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `templateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `websiteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `contents_ibfk_1` FOREIGN KEY (`templateId`) REFERENCES `templates` (`templateId`) ON DELETE CASCADE,
  ADD CONSTRAINT `contents_ibfk_2` FOREIGN KEY (`parentContentId`) REFERENCES `contents` (`contentId`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`enrollmentId`) REFERENCES `enrollmentform` (`enrollmentId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
