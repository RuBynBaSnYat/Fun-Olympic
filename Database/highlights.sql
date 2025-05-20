-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 08:22 AM
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
-- Database: `highlights`
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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `video_id`, `comment_text`, `created_at`, `user_email`) VALUES
(81, 22, 'Nice Goals!!!', '2024-04-05 13:22:20', 'kcg210807@ismt.edu.np');

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
(22, 'Football', 'thumbnails/football.jpg'),
(23, 'VolleyBall', 'thumbnails/volleyball.jpg'),
(24, 'Basketball', 'thumbnails/basketball.jpg'),
(25, 'Marathon', 'thumbnails/marathon.jpg'),
(26, 'Highlights', 'thumbnails/basketball.jpg'),
(28, 'sadasdasd', 'thumbnails/boxing.jpg');

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
(22, 'Germany vs Brazil', 'Highlights match of Brazil vs Mexico', 'https://www.youtube.com/embed/9WUQL03eNTM?si=9BdAFih8po5YXs0Y', 22, 0, NULL, '2024-04-05 11:43:09'),
(23, 'Italy vs Brazil', 'Highlights Match Between Italy and Brazil', 'https://www.youtube.com/embed/i3jaXmZWRTE?si=4c1Ee1MaFMPLClWC', 23, 0, NULL, '2024-04-05 11:45:57'),
(24, 'USA vs Spain', 'Volleyball Highlights match between USA and Spain.', 'https://www.youtube.com/embed/-eHxLqT21r8?si=Vy1WmkEuqYIuA2M6', 24, 0, NULL, '2024-04-05 11:47:31'),
(25, 'Marathon Highlight', 'Highlights', 'https://www.youtube.com/embed/2avwTfdlcD4?si=xtXt4XpaPH3A3b8P', 25, 0, NULL, '2024-04-05 11:51:48'),
(26, 'Skiting', 'Capture the best moment from this highlight of skiting.', 'https://www.youtube.com/embed/Qgl1GITk0Js?si=KTFNmRZsegMfQwta', 26, 0, NULL, '2024-04-05 13:58:15'),
(28, 'asdasdas', 'asdsad', 'https://www.youtube.com/embed/Qgl1GITk0Js?si=KTFNmRZsegMfQwta', 28, 0, NULL, '2024-04-05 20:47:04');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
