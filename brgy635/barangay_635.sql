-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 10:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay 635`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `text`, `date`) VALUES
(4, 'drytu', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid adipisci repellendus asperiores, velit qui ullam voluptate, sed temporibus aut, architecto rem odio esse natus et mollitia doloribus suscipit illo nobis?\r\n                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur doloribus voluptatem amet accusamus, labore omnis ullam totam molestiae delectus aspernatur explicabo dolorum praesentium iusto dolor expedita laboriosam soluta porro inventore?', '2024-10-02'),
(5, 'ANNOUNCEMENT#2', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid adipisci repellendus asperiores, velit qui ullam voluptate, \r\n                        sed temporibus aut, architecto rem odio esse natus et mollitia doloribus suscipit illo nobis?\r\n                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur doloribus voluptatem amet accusamus, \r\n                        labore omnis ullam totam molestiae delectus aspernatur explicabo dolorum praesentium iusto dolor expedita laboriosam soluta porro inventore?', '2024-07-20'),
(6, 'Announcement for tomorrow', 'ANNOUNCEMENT#2\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid adipisci repellendus asperiores, velit qui ullam voluptate, \r\n                        sed temporibus aut, architecto rem odio esse natus et mollitia doloribus suscipit illo nobis?\r\n                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur doloribus voluptatem amet accusamus, \r\n                        labore omnis ullam totam molestiae delectus aspernatur explicabo dolorum praesentium iusto dolor expedita laboriosam soluta porro inventore?\r\nANNOUNCEMENT#2\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid adipisci repellendus asperiores, velit qui ullam voluptate, \r\n                        sed temporibus aut, architecto rem odio esse natus et mollitia doloribus suscipit illo nobis?\r\n                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur doloribus voluptatem amet accusamus, \r\n                        labore omnis ullam totam molestiae delectus aspernatur explicabo dolorum praesentium iusto dolor expedita laboriosam soluta porro inventore?', '2024-07-22'),
(7, 'Claiming of ID for Senior Citizen', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid adipisci repellendus asperiores, velit qui ullam voluptate, \r\n                        sed temporibus aut, architecto rem odio esse natus et mollitia doloribus suscipit illo nobis?\r\n                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur doloribus voluptatem amet accusamus, \r\n                        labore omnis ullam totam molestiae delectus aspernatur explicabo dolorum praesentium iusto dolor expedita laboriosam soluta porro inventore?\r\nANNOUNCEMENT#2\r\nLorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid adipisci repellendus asperiores, velit qui ullam voluptate, \r\n                        sed temporibus aut, architecto rem odio esse natus et mollitia doloribus suscipit illo nobis?\r\n                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur doloribus voluptatem amet accusamus, \r\n                        labore omnis ullam totam molestiae delectus aspernatur explicabo dolorum praesentium iusto dolor expedita laboriosam soluta porro inventorefhgjhfd\r\nsurgyrg', '2024-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_clearance`
--

CREATE TABLE `barangay_clearance` (
  `id` int(11) NOT NULL,
  `req_name` varchar(100) NOT NULL,
  `postal_address` varchar(255) NOT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `citizenship` varchar(50) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Queue Status` varchar(250) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL DEFAULT 1,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_clearance`
--

CREATE TABLE `business_clearance` (
  `id` int(11) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `business_address` varchar(255) NOT NULL,
  `nature_business` varchar(100) DEFAULT NULL,
  `proprietor` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `ownership_type` varchar(50) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Queue Status` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL DEFAULT 2,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_of_indigency`
--

CREATE TABLE `certificate_of_indigency` (
  `id` int(11) NOT NULL,
  `req_name_indigency` varchar(100) NOT NULL,
  `postal_address_indigency` varchar(255) NOT NULL,
  `purpose_indigency` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Queue Status` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL DEFAULT 3,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_of_residency`
--

CREATE TABLE `certificate_of_residency` (
  `id` int(11) NOT NULL,
  `req_name_residency` varchar(100) NOT NULL,
  `postal_address_residency` varchar(255) NOT NULL,
  `purpose_residency` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Queue Status` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL DEFAULT 4,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `img_events`
--

CREATE TABLE `img_events` (
  `id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `image_type` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `img_upload`
--

CREATE TABLE `img_upload` (
  `id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `image_type` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `log_entry` text NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `admin_id`, `action`, `log_entry`, `log_date`) VALUES
(26, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-13 06:15:00'),
(27, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-13 06:15:58'),
(28, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-13 06:24:31'),
(29, 1, 'Update', 'Admin updated queue status to \'Pending\' for request ID 3 in table certificate_of_indigency.', '2024-10-14 00:32:10'),
(30, 1, 'Update', 'Admin updated queue status to \'ready to claim\' for request ID 3 in table certificate_of_indigency.', '2024-10-14 00:32:19'),
(31, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-14 00:32:30'),
(32, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-14 01:27:24'),
(33, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-14 01:32:05'),
(34, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-14 01:38:33'),
(35, 0, 'Document Generation', 'Admin generated a document: businessClearance', '2024-10-14 01:56:25'),
(36, 1, 'Update', 'Admin updated queue status to \'processing\' for request ID 5 in table certificate_of_residency.', '2024-10-14 03:09:45'),
(37, 0, 'Document Generation', 'Admin generated a document: residency', '2024-10-14 03:09:59'),
(38, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:42:19'),
(39, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:43:04'),
(40, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:43:20'),
(41, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:46:04'),
(42, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 5.', '2024-10-25 06:46:10'),
(43, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 1.', '2024-10-25 06:48:52'),
(44, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:49:42'),
(45, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:55:59'),
(46, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 17.', '2024-10-25 06:56:07'),
(47, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 06:57:43'),
(48, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 07:00:47'),
(49, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-25 07:01:41'),
(50, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-25 07:02:21'),
(51, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-25 20:02:11'),
(52, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 4.', '2024-10-25 20:02:33'),
(53, 1, 'Update', 'Admin updated queue status to \'Pending\' for request ID 9 in table barangay_clearance.', '2024-10-25 20:02:41'),
(54, 0, 'Document Generation', 'Admin generated a document: residency', '2024-10-26 00:48:12'),
(55, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-28 23:57:33'),
(56, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-28 23:58:18'),
(57, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 17.', '2024-10-28 23:58:58'),
(58, 0, 'Document Generation', 'Admin generated a document: businessClearance', '2024-10-28 23:59:07'),
(59, 0, 'Document Generation', 'Admin generated a document: indigency', '2024-10-28 23:59:20'),
(60, 0, 'Document Generation', 'Admin generated a document: residency', '2024-10-28 23:59:32'),
(61, 0, 'Document Generation', 'Admin generated a document: residency', '2024-10-29 07:07:24'),
(62, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 13.', '2024-10-29 07:07:43'),
(63, 1, 'Update', 'Admin updated queue status to \'processing\' for request ID 7 in table certificate_of_indigency.', '2024-10-30 01:07:19'),
(64, 1, 'Update', 'Admin Deleted indigency requested by resident id: 17.', '2024-10-30 01:07:55'),
(65, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 6.', '2024-10-30 01:08:24'),
(66, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 03:32:53'),
(67, 1, 'Update', 'Admin Deleted barangayClearance requested by resident id: 13.', '2024-10-30 03:33:10'),
(68, 1, 'Update', 'Admin updated queue status to \'Pending\' for request ID 14 in table barangay_clearance.', '2024-10-30 04:41:17'),
(69, 1, 'Update', 'Admin updated queue status to \'processing\' for request ID 4 in table business_clearance.', '2024-10-30 04:41:29'),
(70, 1, 'Update', 'Admin updated queue status to \'Pending\' for request ID 5 in table business_clearance.', '2024-10-30 04:41:33'),
(71, 1, 'Update', 'Admin Deleted businessClearance requested by resident id: 13.', '2024-10-30 04:59:12'),
(72, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 06:16:51'),
(73, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 06:19:26'),
(74, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 06:58:59'),
(75, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 06:59:41'),
(76, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 07:06:40'),
(77, 0, 'Document Generation', 'Admin generated a document: businessClearance', '2024-10-30 07:08:27'),
(78, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 07:08:54'),
(79, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 07:10:28'),
(80, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 07:13:14'),
(81, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-30 07:15:00'),
(82, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-10-31 00:10:16'),
(83, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-12-14 23:16:13'),
(84, 0, 'Document Generation', 'Admin generated a document: residency', '2024-12-14 23:22:58'),
(85, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2024-12-27 07:03:24'),
(86, 0, 'Document Generation', 'Admin generated a document: businessClearance', '2025-01-26 01:50:02'),
(87, 0, 'Document Generation', 'Admin generated a document: barangayClearance', '2025-01-26 01:52:02'),
(88, 0, 'Document Generation', 'Admin generated a document: indigency', '2025-01-26 02:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(11) NOT NULL,
  `birthday` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `hnum` varchar(50) NOT NULL,
  `street` varchar(100) NOT NULL,
  `others` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_barangay_clearance_resident` (`resident_id`);

--
-- Indexes for table `business_clearance`
--
ALTER TABLE `business_clearance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_business_clearance_resident` (`resident_id`);

--
-- Indexes for table `certificate_of_indigency`
--
ALTER TABLE `certificate_of_indigency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_certificate_of_indigency_resident` (`resident_id`);

--
-- Indexes for table `certificate_of_residency`
--
ALTER TABLE `certificate_of_residency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_certificate_of_residency_resident` (`resident_id`);

--
-- Indexes for table `img_events`
--
ALTER TABLE `img_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img_upload`
--
ALTER TABLE `img_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `business_clearance`
--
ALTER TABLE `business_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `certificate_of_indigency`
--
ALTER TABLE `certificate_of_indigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `certificate_of_residency`
--
ALTER TABLE `certificate_of_residency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `img_events`
--
ALTER TABLE `img_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `img_upload`
--
ALTER TABLE `img_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  ADD CONSTRAINT `fk_barangay_clearance_resident` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`);

--
-- Constraints for table `business_clearance`
--
ALTER TABLE `business_clearance`
  ADD CONSTRAINT `fk_business_clearance_resident` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`);

--
-- Constraints for table `certificate_of_indigency`
--
ALTER TABLE `certificate_of_indigency`
  ADD CONSTRAINT `fk_certificate_of_indigency_resident` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`);

--
-- Constraints for table `certificate_of_residency`
--
ALTER TABLE `certificate_of_residency`
  ADD CONSTRAINT `fk_certificate_of_residency_resident` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
