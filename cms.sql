-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 01:14 PM
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
(1, 1, NULL, 'image', '200px', 'auto', '', '', 2, 'uploads/logo-white.svg', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(2, 1, NULL, 'image', '25px', '25px', NULL, '', 1, 'icons/burger.svg', '#', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(3, 1, NULL, 'image', '25px', '25px', NULL, '', 3, 'icons/search.svg', '#', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(7, 10, NULL, 'image', '200px', '200px', NULL, '', NULL, 'uploads/flow.png', NULL, NULL, NULL, NULL, NULL, NULL, b'0', NULL, NULL),
(8, 10, NULL, 'text', NULL, NULL, NULL, 'Tangina di ko na alam gagawin ko', NULL, '', NULL, NULL, '', '', '12px', '', b'0', NULL, NULL),
(9, 10, NULL, 'a', '200px', 'auto', NULL, 'Home', NULL, NULL, 'Home', 'Home', NULL, NULL, NULL, NULL, b'1', NULL, NULL),
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
(52, 75, NULL, 'h1', 'auto', 'auto', NULL, 'This is another section', NULL, NULL, NULL, NULL, '#000000', 'Normal', 'px', 'Arial', NULL, NULL, NULL),
(53, 76, NULL, 'image', '55px', 'auto', NULL, '', 2, 'uploads/6826fcf25a076_6826a26a6f33a_logo-design.png', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(54, 76, NULL, 'image', '25px', '25px', NULL, '', 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(55, 76, NULL, 'image', '25px', '25px', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(63, 73, NULL, 'h1', 'auto', 'auto', NULL, '', NULL, NULL, NULL, NULL, '#000000', 'Normal', 'px', '', NULL, NULL, NULL),
(64, 77, NULL, 'image', '25px', 'auto', NULL, NULL, 2, 'uploads/682712d41015a_682697ecaf550_Mermaid Chart - Create complex, visual diagrams with text. A smarter way of creating diagrams.-2025-05-14-205641.svg', 'home', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(65, 77, NULL, 'image', '25px', '25px', NULL, NULL, 1, 'uploads/burger-bar.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(66, 77, NULL, 'image', '25px', 'auto', NULL, NULL, 3, 'uploads/magnifying-glass.png', NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL),
(73, 12, NULL, 'a', 'auto', 'auto', NULL, 'Home', NULL, NULL, '1', NULL, '#000000', 'Normal', 'px', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `pageId` int(11) NOT NULL,
  `websiteId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`pageId`, `websiteId`, `name`) VALUES
(2, 4, 'Home'),
(3, 5, 'Home'),
(16, 14, 'Home'),
(17, 15, 'Home'),
(18, 16, 'Home'),
(19, 17, 'Home'),
(21, 0, 'Home');

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
(1, '2', 'Navigation1', 'Navigation', '100%', '80px', '#3A3550', '0', '0', '0', 'row', 'center', 'space-between', '0', '0 20px 0 20px', '1', NULL),
(10, '2', 'Div', 'Div', '100%', '100vh', '', '0', '0', '0', 'column', 'initial', 'flex-start', '0', '0', '2', NULL),
(11, '2', 'Div2', 'Div', '50%', '50px', '#5500bb', '0', '0', '0', 'row', 'center', 'space-evenly', '0', '0', '3', NULL),
(12, '3', 'Navigation2', 'Navigation', '100%', '80px', '#5500bb', '0', '0', '0', 'row', 'center', 'center', '0', '0', '1', NULL),
(13, '3', 'Div3_1', 'Division', '100%', '100Vh', '#fff000', '0', '0', '0', 'column', 'center', 'center', '0', '0', '2', NULL),
(14, '2', 'Division', 'Navigation', '100px', '100px', '#b5a6a6', '0', '0', '#695959', '0', '0', '0', '0', '0', '3', NULL),
(43, '16', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(44, '0', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(45, '17', 'main', 'Content', '100%', '100vh', '#000fff', '0', '0', '#fff000', '0', 'center', 'center', '0', '0', '2', NULL),
(46, '17', 'Navigation', 'Navigation', '100%', '80px', '#fff000', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(73, '17', 'Section3', 'Content', '100%', '100vw', '#ff00bb', '0', '0', '#000000', 'row', 'center', 'center', '0', '0', '3', 0),
(75, '2', 'Section', 'Content', '100%', '50vw', '#a09898', '0', '0', '#000000', 'row', 'center', 'centefr', '0', '0', '3', 0),
(76, '18', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(77, '19', 'Navigation', 'Navigation', '100%', '80px', '#ffffff', '0px', 'none', 'none', 'row', 'center', 'space-between', '0px', '0 10px 0 10px', '1', NULL),
(80, '18', 'Hero', 'Content', '100%', '50vw', '#000000', '2', 'Solid', '#000000', 'row', 'center', 'center', '', '', '3', 0);

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
(4, 0, 'nkdjas', '682443b9177c4_495073040_2197303414074012_8272612189865387795_n.png', '125678986532'),
(5, 0, 'nkdjas', '682444577418d_495073040_2197303414074012_8272612189865387795_n.png', '125678986532'),
(14, 0, 'qwe', '6826994986c1f_682698bae110d_494578437_1739118630308518_8518738164588727574_n.png', 'qwe'),
(15, 0, 'Princeton', '6826a26a6f33a_logo-design.png', 'qwe'),
(16, 0, 'New Website', '6826fcf25a076_6826a26a6f33a_logo-design.png', 'Hello World');

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
  MODIFY `contentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `pageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `templateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `websiteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `contents_ibfk_1` FOREIGN KEY (`templateId`) REFERENCES `templates` (`templateId`) ON DELETE CASCADE,
  ADD CONSTRAINT `contents_ibfk_2` FOREIGN KEY (`parentContentId`) REFERENCES `contents` (`contentId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
