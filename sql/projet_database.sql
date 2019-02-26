-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 19, 2017 at 10:28 
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2017_projet6_stages`
--

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `eid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etudiants`
--

INSERT INTO `etudiants` (`eid`, `nom`, `prenom`, `email`, `tel`) VALUES
(1, 'Dapol', 'ahmed', 'ahmed@gmail.com', '07888755'),
(2, 'ALjamee', 'Lina', 'lina@hhh.com', '87895678'),
(15, 'yosef', 'hala', 'ww@ke.w', '65564534'),
(22, 'yosef', 'hala', 'ibrahim@is.ml', '65564534'),
(23, 'khaled', 'jomana', 'jomana@syr.com', '65564534'),
(24, 'khaled', 'jomana', 'jomana@syr.com', '65564534'),
(25, 'mohammad', 'saleh', 'saleh@ff.cv', '657654212456'),
(26, 'khaled', 'mosa', 'siniorabeso@gmail.com', '657654212456'),
(27, 'ibrahim', 'nbmnb', 'vnbvbn@rr.mn', '56443447567');

-- --------------------------------------------------------

--
-- Table structure for table `gestionnaires`
--

CREATE TABLE `gestionnaires` (
  `gid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gestionnaires`
--

INSERT INTO `gestionnaires` (`gid`, `nom`, `prenom`, `email`, `token`) VALUES
(1, 'hello', 'world', 'hello@ww.l', 'erer'),
(2, 'yosef', 'ahmed', 'yosef@ahmed.com', 'weeowqje'),
(3, 'nn', 'n b', 'bb@jj.x', 'bb');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `nid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `note` int(10) UNSIGNED NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `soutenances`
--

CREATE TABLE `soutenances` (
  `stid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `tuteur1` int(11) NOT NULL,
  `tuteur2` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `salle` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `soutenances`
--

INSERT INTO `soutenances` (`stid`, `sid`, `tuteur1`, `tuteur2`, `date`, `salle`) VALUES
(15, 8, 9, 2, '2018-09-12 00:00:00', 'amphi 2');

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

CREATE TABLE `stages` (
  `sid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tuteurE` varchar(40) NOT NULL,
  `emailTE` varchar(30) NOT NULL,
  `tuteurP` int(11) DEFAULT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stages`
--

INSERT INTO `stages` (`sid`, `eid`, `titre`, `description`, `tuteurE`, `emailTE`, `tuteurP`, `dateDebut`, `dateFin`) VALUES
(5, 1, 'ewewqe3211w', ',,mknjhuyucgvrrf', 'uyttyg', 'ytrt@rr.jj', 2, '2017-04-28', '2017-04-30'),
(6, 15, 'informatique', 'html,java,c', 'jean', 'hhh@gg.x', NULL, '2018-06-08', '2018-08-08'),
(8, 23, 'medecine', 'urgence', 'alex', 'alex@a.com', 5, '2018-06-10', '2018-10-10'),
(9, 25, 'informatique', 'c#', 'ayman', 'ayman@rr.m', NULL, '2018-06-08', '2018-10-10'),
(10, 26, 'informatique', 'c#', 'alex', 'ww@ww.s', NULL, '2018-06-08', '2018-10-10'),
(11, 27, 'trtewqdsfsf', 'dsdsewwqds', 'fdfsfsf', 'fdsfds@dg.mn', NULL, '2018-06-10', '2018-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `actif` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `nom`, `prenom`, `login`, `mdp`, `role`, `actif`) VALUES
(1, 'Admin', 'User', 'admin', '$2y$10$WUXmfWOTO3gf.QIwxuHH0ecG51cmEsgW5YmHbQaAHcYL6wV11GgOm', 'admin', b'0'),
(2, 'Test', 'User', 'test', '$2y$10$rwE2jgPjPrw1i8DBi5xgY.aZuqV..6w9ZEFQmiYAy1G3slnJpKFVy', 'user', b'0'),
(3, 'ABDIN', 'Basma', 'basma', '1c6637a8f2e1f75e06ff9984894d6bd16a3a36a9', 'admin', b'1'),
(5, 'sdsad', 'dsadsa', 'sdsad', '70e0707c10f8f5cf09a9ca5f472c088171081bb1', 'user', b'1'),
(9, 'jj', 'j', 'rr', 'd1854cae891ec7b29161ccaf79a24b00c274bdaa', 'user', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `gestionnaires`
--
ALTER TABLE `gestionnaires`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `soutenances`
--
ALTER TABLE `soutenances`
  ADD PRIMARY KEY (`stid`),
  ADD KEY `eid` (`sid`),
  ADD KEY `tuteur1` (`tuteur1`),
  ADD KEY `tuteur2` (`tuteur2`);

--
-- Indexes for table `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `eid` (`eid`),
  ADD KEY `tuteurP` (`tuteurP`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `gestionnaires`
--
ALTER TABLE `gestionnaires`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `soutenances`
--
ALTER TABLE `soutenances`
  MODIFY `stid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `stages`
--
ALTER TABLE `stages`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `stages` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soutenances`
--
ALTER TABLE `soutenances`
  ADD CONSTRAINT `soutenances_ibfk_2` FOREIGN KEY (`tuteur1`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soutenances_ibfk_3` FOREIGN KEY (`tuteur2`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soutenances_ibfk_4` FOREIGN KEY (`sid`) REFERENCES `stages` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stages`
--
ALTER TABLE `stages`
  ADD CONSTRAINT `stages_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `etudiants` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stages_ibfk_2` FOREIGN KEY (`tuteurP`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
