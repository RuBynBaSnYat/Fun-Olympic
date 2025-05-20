-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 08:21 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `title`, `thumbnail`) VALUES
(24, 'Football Female', 'thumbnails/football.jpg'),
(25, 'Basketball', 'thumbnails/basketball.jpg'),
(26, 'VolleyBall', 'thumbnails/volleyball.jpg'),
(27, 'Boxing', 'thumbnails/boxing.jpg'),
(29, 'Football', 'thumbnails/football.jpg'),
(32, 'Football 555555', 'thumbnails/1.jpg'),
(33, 'Football', 'thumbnails/9.JPG'),
(34, 'aasd', 'thumbnails/basketball.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `youtube_link` varchar(255) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `is_live` tinyint(1) NOT NULL DEFAULT 0,
  `youtube_video_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `description`, `youtube_link`, `folder_id`, `is_live`, `youtube_video_id`, `created_at`) VALUES
(24, 'Sweden VS Canada', 'Female Football match between Brazil and', 'https://www.youtube.com/embed/F7IE7vB8484?si=k58yEOeVGF-xh2Wt', 24, 0, NULL, '2024-04-05 06:33:31'),
(25, 'France vs USA', 'Basketball match between France and USA', 'https://www.youtube.com/embed/8YSrNfcKvA0?si=w4ye21kWbOW5ZIV', 25, 0, NULL, '2024-04-05 06:36:02'),
(26, 'Italy vs Brazil', 'Watch the live volleyball match between Italy vs Brazil', 'https://www.youtube.com/embed/KLIa2UaE2KE?si=Ry0OCPg850k9Ylu3', 26, 0, NULL, '2024-04-05 06:37:17'),
(29, 'Boxing Live Match', 'Live Boxing match', 'https://www.youtube.com/embed/BXdc_pQY69Y?si=_en4BBspch-mueWS', 27, 0, NULL, '2024-04-05 06:45:21'),
(30, 'Brazil vs Germany', 'Live match of Brail vs Germany', 'https://www.youtube.com/embed/kn5uevla61U?si=0eaSCoxTEMjCsorW', 29, 0, NULL, '2024-04-05 06:47:11'),
(32, 'Live mactch', 'watch live match', 'https://www.youtube.com/embed/_BoScV4ey2Q?si=mUZGj0-FgcjU8_gu', 32, 0, NULL, '2024-04-05 13:48:56'),
(33, 'asdosaihdas', 'dasdsadasd', 'https://www.youtube.com/embed/Qgl1GITk0Js?si=KTFNmRZsegMfQwta', 33, 0, NULL, '2024-04-05 20:32:10'),
(34, 'asdosaihdasasdasdasads', 'asdas', 'https://www.youtube.com/embed/Qgl1GITk0Js?si=KTFNmRZsegMfQwta', 34, 0, NULL, '2024-04-05 20:36:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folder_id` (`folder_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
