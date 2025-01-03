-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 03, 2025 at 10:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Id`, `Name`) VALUES
(2, 'Languages'),
(1, 'Programming');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `Id` bigint(20) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(700) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `ImageUrl` varchar(255) DEFAULT NULL,
  `CategoryId` int(11) NOT NULL,
  `InstructorId` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`Id`, `Title`, `Description`, `Price`, `ImageUrl`, `CategoryId`, `InstructorId`) VALUES
(7, 'HTML', 'third', 150, '../assets/imgs/Courses/HTML.jpg', 1, 3),
(23, 'JavaScript', 'second', 300, '../assets/imgs/Courses/download (1).png', 1, 6),
(24, 'Microsoft SQL Server', 'second', 200, '../assets/imgs/Courses/BLOG-Whats-new-in-SQL-Server-2022.png', 1, 6),
(27, 'PHP', 'PHP#2', 300, '../assets/imgs/Courses/0925-3D_Data_Visualization_with_Open_Source_Tools_A_Tutorial_Using_VTK_Dan_Newsletter.png', 1, 3),
(28, 'Ruby', 'second', 150, '../assets/imgs/Courses/ruby-lang-ar21.jpeg', 1, 3),
(29, 'Java', 'second', 500, '../assets/imgs/Courses/download.png', 1, 3),
(30, 'Assembly', 'intro', 100, '../assets/imgs/Courses/Assembly.jpeg', 1, 3),
(32, 'Swift', 'second', 200, '../assets/imgs/Courses/swift.jpeg', 1, 6),
(33, 'ASP.NET MVC', 'intro', 700, '../assets/imgs/Courses/MVC-Logo-1.jpg', 1, 6),
(34, 'CSS', 'Third', 150, '../assets/imgs/Courses/sta-je-css.png', 1, 6),
(35, 'ASP.NET API', 'first', 400, '../assets/imgs/Courses/Microsoft_.NET_logo.svg.png', 1, 6),
(37, 'C#', 'intro', 300, '../assets/imgs/Courses/download.jpeg', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `courses_sections`
--

CREATE TABLE `courses_sections` (
  `Id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `Title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses_sections`
--

INSERT INTO `courses_sections` (`Id`, `course_id`, `Title`) VALUES
(18, 23, 'intro'),
(19, 23, 'second phase'),
(20, 24, 'intro'),
(21, 24, 'second phase'),
(22, 7, 'intro'),
(23, 7, 'second phase'),
(24, 7, 'Third'),
(31, 27, 'intro'),
(32, 27, 'second phase'),
(33, 28, 'intro'),
(34, 28, 'Installation on mac'),
(35, 29, 'intro'),
(36, 29, 'second phase'),
(37, 30, 'intro'),
(39, 32, 'What\'s Swift?'),
(40, 32, 'Swift#2'),
(41, 33, 'intro'),
(42, 34, 'intro'),
(43, 34, 'CSS#2'),
(44, 34, 'CSS#3'),
(45, 35, '#1'),
(48, 37, 'intro');

-- --------------------------------------------------------

--
-- Table structure for table `my_cart`
--

CREATE TABLE `my_cart` (
  `Id` bigint(11) NOT NULL,
  `StudentId` bigint(15) NOT NULL,
  `CourseId` bigint(15) NOT NULL,
  `Title` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Id` bigint(20) NOT NULL,
  `UserId` bigint(20) NOT NULL,
  `CourseId` bigint(20) NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Id`, `UserId`, `CourseId`, `PaymentDate`, `Status`) VALUES
(3, 7, 24, '2024-12-24 00:00:00', 'Paid'),
(5, 7, 23, '2024-12-24 00:00:00', 'Paid'),
(6, 7, 7, '2024-12-24 00:00:00', 'Paid'),
(7, 7, 30, '2024-12-24 00:00:00', 'Paid'),
(8, 8, 23, '2024-12-25 00:00:00', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Instructor'),
(3, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `sections_videos`
--

CREATE TABLE `sections_videos` (
  `Id` bigint(20) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections_videos`
--

INSERT INTO `sections_videos` (`Id`, `section_id`, `Title`, `video_url`) VALUES
(8, 18, 'Video 1', '../assets/Videos/سلسلة دروس جافا سكريبت - الدرس الأول_ ما هي لغة جافا سكريبت و ما أهميتها؟.mp4'),
(9, 19, 'Video 1', '../assets/Videos/4_ تسمية المتغيرات و التعامل معها.mp4'),
(10, 20, 'Video 1', '../assets/Videos/How to fix Microsoft SQL Server, Error 15404 (Database Diagrams).mp4'),
(11, 21, 'Video 1', '../assets/Videos/SSMS Failing To Connect To SQL Server.mp4'),
(12, 22, 'Video 1', '../assets/Videos/HTML1.mp4'),
(13, 23, 'Video 1', '../assets/Videos/videoplayback (1).mp4'),
(14, 24, 'Video 1', '../assets/Videos/HTML3.mp4'),
(21, 31, 'Video 1', '../assets/Videos/PHP Tutorial (& MySQL) #1 - Why Learn PHP_.mp4'),
(22, 32, 'Video 1', '../assets/Videos/PHP Tutorial (& MySQL) #2 - Installing PHP (XAMPP).mp4'),
(23, 33, 'Video 1', '../assets/Videos/Introduction _ Ruby _ Tutorial 1.mp4'),
(24, 34, 'Video 1', '../assets/Videos/Ruby2.mp4'),
(25, 35, 'Video 1', '../assets/Videos/Why take this Java Course_.mp4'),
(26, 36, 'Video 1', '../assets/Videos/Introduction to Java Programming.mp4'),
(27, 37, 'Video 1', '../assets/Videos/Assembly Language in 100 Seconds.mp4'),
(29, 39, 'Video 1', '../assets/Videos/Swift in 100 Seconds.mp4'),
(30, 40, 'Video 1', '../assets/Videos/Swift for Beginners Part 1_ Getting Started.mp4'),
(31, 41, 'Video 1', '../assets/Videos/mvc1.mp4'),
(32, 42, 'Video 1', '../assets/Videos/css1.mp4'),
(33, 43, 'Video 1', '../assets/Videos/css2.mp4'),
(34, 44, 'Video 1', '../assets/Videos/CSS Tutorial for Beginners - 03 - Multiple selectors and writing rule for more than one element.mp4'),
(35, 45, 'Video 1', '../assets/Videos/ASP.NET Tutorial _ ASP.NET Core Tutorial _ What is ASP.NET_ _ ASP.NET _ 2022 _ Simplilearn.mp4'),
(38, 48, 'Video 1', '../assets/Videos/C# Fundamentals_ 04- Writing to Console.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `students_courses`
--

CREATE TABLE `students_courses` (
  `Id` bigint(20) NOT NULL,
  `StudentId` bigint(20) NOT NULL,
  `CourseId` bigint(20) NOT NULL,
  `Grade` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_courses`
--

INSERT INTO `students_courses` (`Id`, `StudentId`, `CourseId`, `Grade`) VALUES
(19, 7, 23, NULL),
(22, 8, 23, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` bigint(20) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `verify_status` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `FirstName`, `LastName`, `Username`, `Email`, `Password`, `verify_token`, `verify_status`, `role_id`) VALUES
(1, 'Mohamed', 'Saad', 'Saad20', 'msaad@gmail.com', 'Ad@123456', '5469ebea4870ee7a30e487eae5fb6524', '', 3),
(2, 'Admin', 'Admin', 'Admin', 'Admin@gmail.com', 'Ad@123456', '', '', 1),
(3, 'Omar', 'Hesham', 'omarh', 'omar@gmail.com', 'Ad@123456', NULL, NULL, 2),
(4, 'Ziad', 'Ayman', 'ziad500', 'ziaday@gmail.com', 'Ad@123456', 'eb7fad6156e15a4c717157b45ea2d886', NULL, 3),
(5, 'Aya', 'Ramy', 'aya12', 'aya@gmail.com', 'Ad@123456', 'bd126285d800741331303ea8d924a840', NULL, 3),
(6, 'Ahmed', 'Mamdouh', 'ahmed12', 'mamdouh@gmail.com', 'Ad@123456', 'aad8d79ecddfa5a426851526b2251b03', NULL, 2),
(7, 'Mohamed', 'Abdelaziz', 'Zizo', 'zizo@gmail.com', 'Ad@12345', 'd7f6b03a034469bd8c9623c55ea9fee5', NULL, 3),
(8, '', 'b', 'root', 'a@b.com', '123!@#$%^', '2b18cc63365ff735c3eb9bcd59e8006e', NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_instructor` (`InstructorId`),
  ADD KEY `fk_category` (`CategoryId`);

--
-- Indexes for table `courses_sections`
--
ALTER TABLE `courses_sections`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `courses_sections_ibfk_1` (`course_id`);

--
-- Indexes for table `my_cart`
--
ALTER TABLE `my_cart`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk1` (`StudentId`),
  ADD KEY `fk2` (`CourseId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_user` (`UserId`),
  ADD KEY `fk_coursePayment` (`CourseId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sections_videos`
--
ALTER TABLE `sections_videos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `sections_videos_ibfk_1` (`section_id`);

--
-- Indexes for table `students_courses`
--
ALTER TABLE `students_courses`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_courseStudent` (`CourseId`),
  ADD KEY `fk_student` (`StudentId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `courses_sections`
--
ALTER TABLE `courses_sections`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `my_cart`
--
ALTER TABLE `my_cart`
  MODIFY `Id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sections_videos`
--
ALTER TABLE `sections_videos`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `students_courses`
--
ALTER TABLE `students_courses`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`CategoryId`) REFERENCES `categories` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_instructor` FOREIGN KEY (`InstructorId`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `courses_sections`
--
ALTER TABLE `courses_sections`
  ADD CONSTRAINT `courses_sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `my_cart`
--
ALTER TABLE `my_cart`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`StudentId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2` FOREIGN KEY (`CourseId`) REFERENCES `courses` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_coursePayment` FOREIGN KEY (`CourseId`) REFERENCES `courses` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `sections_videos`
--
ALTER TABLE `sections_videos`
  ADD CONSTRAINT `sections_videos_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `courses_sections` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_courses`
--
ALTER TABLE `students_courses`
  ADD CONSTRAINT `fk_courseStudent` FOREIGN KEY (`CourseId`) REFERENCES `courses` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`StudentId`) REFERENCES `users` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
