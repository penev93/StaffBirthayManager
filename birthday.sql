-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2016 at 05:31 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `birthday`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(13) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp852;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `first_name`) VALUES
(4, 'valeri', '3a03768e66e1ed3d9699d538bbc97890', 'Валери'),
(5, 'valeri93', 'eedd970baa7548ed4c49b2ff60189027', 'Валери');

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE `gifts` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `price` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `lock_birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp852;

--
-- Dumping data for table `gifts`
--

INSERT INTO `gifts` (`id`, `year`, `price`, `user_id`, `lock_birthday`) VALUES
(126, 2016, 22.5, 1, '2016-11-14'),
(127, 2016, 16, 2, '2016-11-14'),
(128, 2016, 12, 3, '2016-11-14'),
(129, 2016, 10, 4, '2016-11-14'),
(130, 2017, 10, 1, '2016-11-15'),
(131, 2017, 15, 2, '2016-11-15'),
(132, 2017, 15, 3, '2016-11-15'),
(133, 2017, 15, 9, '2016-11-15'),
(134, 2017, 25, 10, '2016-11-15'),
(135, 2018, 20, 1, '2016-11-16'),
(136, 2018, 0, 3, NULL),
(137, 2018, 0, 9, NULL),
(138, 2018, 0, 10, NULL),
(139, 2018, 0, 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `middle_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(32) CHARACTER SET utf8 NOT NULL,
  `birthday` date NOT NULL,
  `is_delete` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp852;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `surname`, `birthday`, `is_delete`) VALUES
(1, 'Ценко', 'Чоков', 'Чоков', '1901-03-13', NULL),
(2, 'Генерал', 'Румен', 'Радев', '1982-01-01', '2016-11-16'),
(3, 'Валери', 'Бисеров', 'Пенев', '1993-03-02', NULL),
(4, 'Петър', 'Иванов', 'Ивано', '1983-10-01', '2016-11-15'),
(5, 'Петър', 'Мушков', 'Духчев', '1993-03-02', '2016-11-14'),
(6, 'сад', 'асдс', 'адад', '2016-11-23', '2016-11-14'),
(7, 'сад', 'сад', 'асдасд', '2016-11-22', '2016-11-14'),
(8, 'асд', 'асдас', 'дса', '2016-11-24', '2016-11-14'),
(9, 'Георги', 'Георгиев', 'Иванов', '2016-11-02', NULL),
(10, 'Явор', 'Георгиев', 'Петров', '1981-04-21', NULL),
(11, 'Валери', 'Асдс', 'Асд', '2016-11-29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_gifts`
--

CREATE TABLE `users_gifts` (
  `user_id_from` int(11) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `note` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=cp852;

--
-- Dumping data for table `users_gifts`
--

INSERT INTO `users_gifts` (`user_id_from`, `gift_id`, `is_active`, `is_paid`, `note`) VALUES
(1, 127, 0, 0, NULL),
(1, 128, 1, 0, NULL),
(1, 129, 1, 0, NULL),
(1, 131, 0, 0, NULL),
(1, 132, 0, 0, NULL),
(1, 133, 1, 0, NULL),
(1, 134, 1, 1, NULL),
(1, 136, 0, 0, NULL),
(1, 137, 0, 0, NULL),
(1, 138, 0, 0, NULL),
(1, 139, 0, 0, NULL),
(2, 126, 0, 0, 'Валери Плати'),
(2, 128, 0, 0, NULL),
(2, 129, 1, 0, NULL),
(2, 130, 1, 0, NULL),
(2, 132, 0, 0, NULL),
(2, 133, 1, 0, NULL),
(2, 134, 1, 1, NULL),
(3, 126, 1, 1, 'Валери Плати '),
(3, 127, 1, 1, NULL),
(3, 129, 1, 1, NULL),
(3, 130, 0, 0, NULL),
(3, 131, 0, 0, NULL),
(3, 133, 0, 0, NULL),
(3, 134, 1, 0, NULL),
(3, 135, 0, 0, NULL),
(3, 137, 0, 0, NULL),
(3, 138, 0, 0, NULL),
(3, 139, 0, 0, NULL),
(4, 126, 1, 1, NULL),
(4, 127, 1, 1, NULL),
(4, 128, 0, 0, NULL),
(9, 130, 1, 0, NULL),
(9, 131, 1, 0, NULL),
(9, 132, 1, 1, 'asdasdasdsadasdas'),
(9, 134, 1, 0, NULL),
(9, 135, 1, 1, NULL),
(9, 136, 0, 0, NULL),
(9, 138, 0, 0, NULL),
(9, 139, 0, 0, NULL),
(10, 130, 1, 0, NULL),
(10, 131, 1, 0, NULL),
(10, 132, 1, 1, ''),
(10, 133, 0, 0, NULL),
(10, 135, 1, 0, NULL),
(10, 136, 0, 0, NULL),
(10, 137, 0, 0, NULL),
(10, 139, 0, 0, NULL),
(11, 135, 1, 1, NULL),
(11, 136, 0, 0, NULL),
(11, 137, 0, 0, NULL),
(11, 138, 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gifts`
--
ALTER TABLE `gifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_gifts`
--
ALTER TABLE `users_gifts`
  ADD PRIMARY KEY (`user_id_from`,`gift_id`),
  ADD KEY `user_id_from` (`user_id_from`),
  ADD KEY `gift_id` (`gift_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gifts`
--
ALTER TABLE `gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `gifts`
--
ALTER TABLE `gifts`
  ADD CONSTRAINT `fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_gifts`
--
ALTER TABLE `users_gifts`
  ADD CONSTRAINT `fk_gift` FOREIGN KEY (`gift_id`) REFERENCES `gifts` (`id`),
  ADD CONSTRAINT `fk_user_id_from` FOREIGN KEY (`user_id_from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
