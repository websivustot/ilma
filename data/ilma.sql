-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 17, 2018 at 07:19 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ilma`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `lon` varchar(12) NOT NULL,
  `lat` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `lon`, `lat`) VALUES
(1, 'Helsinki', '24.9375', '60.170833'),
(2, 'Jyväskylä', '25.744444', '62.240278'),
(3, 'Espoo', '24.655556', '60.205556'),
(4, 'Tampere', '23.760833', '61.498056'),
(5, 'Vantaa', '25.040278', '60.294444'),
(6, 'Oulu', '25.466667', '65.016667'),
(7, 'Turku', '22.266667', '60.451389'),
(8, 'Lahti', '25.655556', '60.983333'),
(9, 'Kuopio', '27.678333', '62.8925'),
(10, 'Pori', '21.797222 ', '61.484722'),
(11, 'Kouvola', '26.704167', '60.868056'),
(12, 'Joensuu', '29.763889 ', '62.6'),
(13, 'Lappeenranta', '28.183333', '61.066667'),
(14, 'Hämeenlinna', '24.465278', '60.995833'),
(15, 'Vaasa', '21.615278', '63.095833'),
(16, 'Seinäjoki', '22.840278', '62.790278'),
(17, 'Rovaniemi', '25.734722', '66.501389');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `time` varchar(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `forecast` int(11) NOT NULL,
  `temp` varchar(11) NOT NULL,
  `pres` varchar(11) NOT NULL,
  `hum` int(11) NOT NULL,
  `speed` varchar(20) NOT NULL,
  `dir` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `time`, `city_id`, `forecast`, `temp`, `pres`, `hum`, `speed`, `dir`) VALUES
(3, '2018040100', 1, 0, '268.531', '100912', 86, '1.4424852080711', '80.094080239086'),
(4, '2018040100', 2, 0, '265.951', '99624.3', 90, '0.83393902070233', '184.05826531773'),
(5, '2018040100', 3, 0, '268.091', '100692', 87, '1.4318186671168', '74.686157940837'),
(6, '2018040100', 4, 0, '266.711', '99696.3', 88, '1.4181221614731', '143.628078376'),
(7, '2018040100', 5, 0, '268.531', '100912', 86, '1.4424852080711', '80.094080239086'),
(8, '2018040100', 6, 0, '266.221', '100853', 92, '2.5047360549289', '194.78094985852'),
(9, '2018040100', 7, 0, '270.001', '100784', 80, '1.5842571683612', '93.685946772656'),
(10, '2018040100', 8, 0, '266.161', '99891.5', 88, '0.37241175795751', '206.99095240725'),
(11, '2018040100', 9, 0, '264.501', '100213', 94, '0.58410243747565', '191.75714943423'),
(12, '2018040100', 10, 0, '269.021', '100877', 83, '1.5499643271714', '127.42034270079'),
(13, '2018040100', 11, 0, '267.271', '100720', 87, '0.36976110864313', '51.900761883727'),
(14, '2018040100', 12, 0, '264.931', '100384', 95, '1.5747281622112', '172.66739660039'),
(15, '2018040100', 13, 0, '267.431', '100466', 86, '0.39208320222244', '157.35167309466'),
(16, '2018040100', 14, 0, '267.271', '99793.9', 89, '1.0226714514672', '177.70337761609'),
(17, '2018040100', 15, 0, '266.341', '101036', 85, '2.754213576479', '171.20788694592'),
(18, '2018040100', 16, 0, '266.391', '100325', 90, '1.6657195877041', '170.28866072822'),
(19, '2018040100', 17, 0, '264.651', '99302.7', 97, '2.1779303439045', '209.69835038742');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(5) NOT NULL,
  `url` varchar(255) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `title` varchar(100) NOT NULL,
  `keywords` varchar(300) NOT NULL,
  `description` varchar(500) NOT NULL,
  `language` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `url`, `content`, `title`, `keywords`, `description`, `language`) VALUES
(1, '', '<h1>Main page</h1>\r\n\r\n<p>text of page</p>\r\n\r\n<p>text of page</p>\r\n\r\n<p>text of page</p>\r\n\r\n<p>text of page</p>\r\n\r\n<p>text of page</p>\r\n\r\n<p>text of page</p>\r\n\r\n<p>text of page</p>\r\n', '', '', '', 0),
(2, 'weather', '<h1>Sää ja lämpötilat tänään</h1>', 'Sää ja lämpötilat tänään', 'Sää ja lämpötilat tänään', 'Sää ja lämpötilat tänään', 0),
(3, 'fi/news', '<h1>Uutiset</h1>', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `status`) VALUES
(3, 'admin', '1940cdc35447abeddfaa2bce493f2ac4', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
