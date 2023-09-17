-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 04:10 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homebasedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbcampaigns`
--

CREATE TABLE `dbcampaigns` (
  `campaign_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `campaign_name` text NOT NULL,
  `campaign_start_date` text DEFAULT NULL,
  `campaign_end_date` text DEFAULT NULL,
  `campaign_working` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dbdates`
--

CREATE TABLE `dbdates` (
  `id` char(20) NOT NULL,
  `shifts` text DEFAULT NULL,
  `mgr_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dbevents`
--

CREATE TABLE dbevents (
  id text NOT NULL,
  event_date text DEFAULT NULL,
  start_time int(11) DEFAULT NULL,
  end_time int(11) DEFAULT NULL,
  venue text DEFAULT NULL,
  event_name text DEFAULT NULL,
  description text DEFAULT NULL,
  event_id text DEFAULT NULL,
  event_working text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dbfeedback`
--

CREATE TABLE `dbfeedback` (
  `id` int(10) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `date` varchar(20) NOT NULL,
  `satisfaction_rank` int(11) NOT NULL,
  `recommend_rank` int(11) NOT NULL,
  `volunteer_rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dbissues`
--

CREATE TABLE `dbissues` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `issue` text NOT NULL,
  `date` varchar(20) NOT NULL,
  `event_name` text NOT NULL,
  `event_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dblog`
--

CREATE TABLE `dblog` (
  `id` int(3) NOT NULL,
  `time` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `venue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Table structure for table `dbmasterschedule`
--

CREATE TABLE `dbmasterschedule` (
  `venue` text DEFAULT NULL,
  `day` text NOT NULL,
  `week_no` text NOT NULL,
  `hours` text DEFAULT NULL,
  `slots` int(11) DEFAULT NULL,
  `persons` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `id` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dbpersons`
--

CREATE TABLE `dbpersons` (
  `id` text NOT NULL,
  `start_date` text DEFAULT NULL,
  `venue` text DEFAULT NULL,
  `first_name` text NOT NULL,
  `last_name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` text DEFAULT NULL,
  `phone1` varchar(12) NOT NULL,
  `phone1type` text DEFAULT NULL,
  `phone2` varchar(12) DEFAULT NULL,
  `phone2type` text DEFAULT NULL,
  `birthday` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `shirt_size` varchar(3) DEFAULT NULL,
  `computer` varchar(3) DEFAULT NULL,
  `camera` varchar(3) NOT NULL,
  `transportation` varchar(3) NOT NULL,
  `contact_name` text NOT NULL,
  `contact_num` varchar(12) NOT NULL,
  `relation` text NOT NULL,
  `contact_time` text NOT NULL,
  `cMethod` text DEFAULT NULL,
  `position` text DEFAULT NULL,
  `credithours` text DEFAULT NULL,
  `howdidyouhear` text DEFAULT NULL,
  `commitment` text DEFAULT NULL,
  `motivation` text DEFAULT NULL,
  `specialties` text DEFAULT NULL,
  `convictions` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `availability` text DEFAULT NULL,
  `schedule` text DEFAULT NULL,
  `hours` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dbpersons`
--

INSERT INTO `dbpersons` (`id`, `start_date`, `venue`, `first_name`, `last_name`, `address`, `city`, `state`, `zip`, `phone1`, `phone1type`, `phone2`, `phone2type`, `birthday`, `email`, `shirt_size`, `computer`, `camera`, `transportation`, `contact_name`, `contact_num`, `relation`, `contact_time`, `cMethod`, `position`, `credithours`, `howdidyouhear`, `commitment`, `motivation`, `specialties`, `convictions`, `type`, `status`, `availability`, `schedule`, `hours`, `notes`, `password`) VALUES
('Admin7037806282', '17-07-26', 'portland', 'Admin', 'Jones', '1 Gum Tree Rd', 'Ashburn', 'VA', '22222', '7037806282', '', '', '', '', 'admin@yahoo.com', 'S', 'No', 'No', 'No', 'Admin', '7777777777', 'Relative', '', '', '', '', '', '', '', '', '', 'manager', 'active', '', '', '', '', 'be6bef2c7a57bead38826deed4077d03');

-- --------------------------------------------------------

--
-- Table structure for table `dbscl`
--

CREATE TABLE `dbscl` (
  `id` char(25) NOT NULL,
  `persons` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `vacancies` text DEFAULT NULL,
  `time` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dbshifts`
--

CREATE TABLE `dbshifts` (
  `id` char(25) NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `venue` text DEFAULT NULL,
  `vacancies` int(11) DEFAULT NULL,
  `persons` text DEFAULT NULL,
  `removed_persons` text DEFAULT NULL,
  `sub_call_list` text DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dbweeks`
--

CREATE TABLE `dbweeks` (
  `id` char(20) NOT NULL,
  `dates` text DEFAULT NULL,
  `venue` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `end` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbcampaigns`
--
ALTER TABLE `dbcampaigns`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `dbdates`
--
ALTER TABLE `dbdates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbfeedback`
--
ALTER TABLE `dbfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbissues`
--
ALTER TABLE `dbissues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dblog`
--
ALTER TABLE `dblog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbscl`
--
ALTER TABLE `dbscl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbshifts`
--
ALTER TABLE `dbshifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbweeks`
--
ALTER TABLE `dbweeks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbcampaigns`
--
ALTER TABLE `dbcampaigns`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dbfeedback`
--
ALTER TABLE `dbfeedback`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `dbissues`
--
ALTER TABLE `dbissues`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `dblog`
--
ALTER TABLE `dblog`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
