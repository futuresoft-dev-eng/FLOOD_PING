-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 05:01 AM
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
-- Database: `floodping`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_accounts`
--

CREATE TABLE `archive_accounts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `house_lot_number` varchar(255) DEFAULT NULL,
  `street_subdivision_name` varchar(255) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `archived_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_accounts`
--

INSERT INTO `archive_accounts` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `contact_no`, `sex`, `birthdate`, `email`, `city`, `barangay`, `house_lot_number`, `street_subdivision_name`, `role`, `position`, `schedule`, `shift`, `profile_photo`, `archived_at`) VALUES
(34, '00003', 'Lumiere', 'Law', 'Choi', '', '09154664654', 'Male', '2024-11-23', 'angela@gmail.com', 'Quezon City', 'Bagbag', 'Blk 2 Lot 19', 'Blas Roque Subdivision', 'Admin', 'Executive Officer', 'TUE', 'Morning Shift', '', '2024-11-22 10:45:58'),
(35, '00003', 'Lumiere', 'Law', 'Choi', '', '09789456123', 'Male', '2024-11-05', 'terry@gmail.com', 'Quezon City', 'Bagbag', 'Blk 2 Lot 19', 'Blas Roque Subdivision', 'Admin', 'Executive Officer', NULL, NULL, '', '2024-11-22 11:05:07'),
(36, '00003', 'Lumiere', 'Law', 'Choi', '', '09654565455', 'Male', '2024-11-03', 'angelatallon.123@gmail.com', 'Quezon City', 'Bagbag', 'Blk 2 Lot 19', 'Blas Roque Subdivision', 'Admin', 'Executive Officer', NULL, NULL, 'uploads/67401d619b837_Screenshot 2024-08-28 155113.png', '2024-11-22 13:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_type` varchar(50) NOT NULL,
  `category_value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_type`, `category_value`) VALUES
(1, 'account_status', 'Active'),
(2, 'account_status', 'Deactivated'),
(3, 'civil_status', 'Single'),
(4, 'civil_status', 'Married'),
(5, 'civil_status', 'Separated'),
(6, 'civil_status', 'Widowed'),
(7, 'socioeconomic_category', 'Indigent'),
(8, 'socioeconomic_category', 'Single Parent'),
(9, 'socioeconomic_category', 'Senior Citizen'),
(10, 'socioeconomic_category', 'PWD'),
(11, 'socioeconomic_category', 'Indigenous Person'),
(12, 'socioeconomic_category', 'Solo Dweller'),
(13, 'socioeconomic_category', 'Child-Headed Household'),
(14, 'socioeconomic_category', 'Non-Vulnerable'),
(15, 'health_status', 'In good health'),
(16, 'health_status', 'Disabled'),
(17, 'health_status', 'Chronically ill'),
(18, 'health_status', 'Mentally ill'),
(19, 'health_status', 'Pregnant'),
(20, 'health_status', 'Veteran'),
(21, 'health_status', 'Elderly'),
(22, 'health_status', 'Medical care dependent'),
(23, 'sex', 'Male'),
(24, 'sex', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `flood_alerts`
--

CREATE TABLE `flood_alerts` (
  `flood_alert_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `water_level` float NOT NULL,
  `flow` varchar(50) NOT NULL,
  `height` float NOT NULL,
  `height_rate` float NOT NULL,
  `sms_status` varchar(50) NOT NULL,
  `sms_status_reason` varchar(255) NOT NULL,
  `alert_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(64) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `resident_id` varchar(7) GENERATED ALWAYS AS (concat('00-',lpad(`id`,4,'0'))) VIRTUAL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile_number` varchar(11) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `house_lot_number` varchar(50) DEFAULT NULL,
  `street_subdivision_name` varchar(100) DEFAULT NULL,
  `barangay` varchar(50) DEFAULT 'Bagbag',
  `municipality` varchar(50) DEFAULT 'Quezon City',
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `account_status_id` int(11) DEFAULT NULL,
  `civil_status_id` int(11) DEFAULT NULL,
  `health_status_id` int(11) DEFAULT NULL,
  `sex_id` int(11) DEFAULT NULL,
  `socioeconomic_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `date_of_birth`, `mobile_number`, `email_address`, `house_lot_number`, `street_subdivision_name`, `barangay`, `municipality`, `profile_photo_path`, `account_status_id`, `civil_status_id`, `health_status_id`, `sex_id`, `socioeconomic_category_id`) VALUES
(1, 'ROSE ANN', 'DE VERA', 'DOMINGO', NULL, '2004-11-04', '09106411147', 'roseanndevera079@gmail.com', '10', '10', 'Bagbag', 'Quezon City', './uploads/photo_6215426656886176412_x.jpg', 1, 6, 16, 23, 14),
(2, 'DANIEL JOHN', 'ARTIOLA', 'DOROTEO', '', '2001-08-17', '09123654789', 'mine@gmail.com', '6', 'Secret', 'Bagbag', 'Quezon City', './uploads/taee.jpg', 1, 3, 15, 23, 7),
(3, 'Pinky', 'Gutom', 'Na ako ', 'Weh', '2000-01-28', '09365471589', 'sd@gmail.com', '6', 'Asd', 'Bagbag', 'Quezon city', './uploads/Pink and Black Pastel Floral Teacher Student School Desktop Wallpaper Background.png', 1, 3, 15, 24, 7),
(4, 'John', 'A.', 'Doe', NULL, '1990-01-01', '09103547896', 'johndoe@gmail.com', '123', 'Sunset St.', 'Bagbag', 'Quezon City', NULL, 1, 3, 15, 23, 7),
(5, 'Jane', 'B.', 'Smith', 'Jr.', '1985-05-15', '09103547897', 'janesmith@gmail.com', '456', 'Maple Ave.', 'Bagbag', 'Quezon City', NULL, 1, 4, 16, 24, 8),
(6, 'Alice', 'C.', 'Johnson', NULL, '1992-07-20', '09103547898', 'alicej@gmail.com', '789', 'Oak Blvd.', 'Bagbag', 'Quezon City', NULL, 2, 3, 17, 23, 9),
(7, 'Bob', 'D.', 'Brown', NULL, '1988-12-10', '09103547891', 'bobbrown@gmail.com', '321', 'Pine St.', 'Bagbag', 'Quezon City', NULL, 1, 4, 18, 24, 10),
(8, 'Charlie', 'E.', 'Davis', NULL, '1995-03-25', '09103547892', 'charlied@gmail.com', '654', 'Elm St.', 'Bagbag', 'Quezon City', NULL, 1, 5, 19, 23, 11),
(9, 'Diana', 'F.', 'Miller', 'III', '1993-09-09', '09103547893', 'dianam@gmail.com', '987', 'Cedar Ave.', 'Bagbag', 'Quezon City', NULL, 2, 6, 20, 24, 12),
(10, 'Evan', 'G.', 'Wilson', NULL, '1997-11-30', '09103547894', 'evanw@gmail.com', '159', 'Birch Dr.', 'Bagbag', 'Quezon City', NULL, 2, 3, 21, 23, 13);

--
-- Triggers `residents`
--
DELIMITER $$
CREATE TRIGGER `validate_age` BEFORE INSERT ON `residents` FOR EACH ROW BEGIN
    IF TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE()) < 18 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid age. Resident must be at least 18 years old.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_age_update` BEFORE UPDATE ON `residents` FOR EACH ROW BEGIN
    IF TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE()) < 18 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid age. Resident must be at least 18 years old.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_email_address` BEFORE INSERT ON `residents` FOR EACH ROW BEGIN
    IF NEW.email_address NOT REGEXP '^[A-Za-z0-9._%+-]+@gmail.com$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid email address. Must end with @gmail.com.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_email_address_update` BEFORE UPDATE ON `residents` FOR EACH ROW BEGIN
    IF NEW.email_address NOT REGEXP '^[A-Za-z0-9._%+-]+@gmail.com$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid email address. Must end with @gmail.com.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_mobile_number` BEFORE INSERT ON `residents` FOR EACH ROW BEGIN
    IF NEW.mobile_number NOT REGEXP '^09[0-9]{9}$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid mobile number. Must be 11 digits and start with 09.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_mobile_number_update` BEFORE UPDATE ON `residents` FOR EACH ROW BEGIN
    IF NEW.mobile_number NOT REGEXP '^09[0-9]{9}$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid mobile number. Must be 11 digits and start with 09.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sensor_data`
--

CREATE TABLE `sensor_data` (
  `id` int(11) NOT NULL,
  `meters` float DEFAULT NULL,
  `rate` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `alert_level` varchar(20) DEFAULT NULL,
  `status` enum('NEW','ENTRY') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_data`
--

INSERT INTO `sensor_data` (`id`, `meters`, `rate`, `timestamp`, `alert_level`, `status`) VALUES
(5942, 0.9, 0.5, '2024-11-28 01:05:32', 'CRITICAL LEVEL', 'NEW'),
(5979, 1.5, 0.5, '2024-11-28 01:00:00', 'CRITICAL LEVEL', 'ENTRY'),
(5980, 1.5, 0.5, '2024-11-28 01:05:00', 'CRITICAL LEVEL', 'ENTRY'),
(5981, 1.2, 0.3, '2024-11-28 01:10:00', 'MEDIUM LEVEL', 'NEW'),
(5982, 1.3, 0.4, '2024-11-28 01:15:00', 'MEDIUM LEVEL', 'ENTRY'),
(5983, 1.4, 0.6, '2024-11-28 01:20:00', 'LOW LEVEL', 'NEW'),
(5984, 1.2, 0.3, '2024-11-28 01:25:00', 'LOW LEVEL', 'ENTRY'),
(5985, 1.6, 0.7, '2024-11-28 01:30:00', 'CRITICAL LEVEL', 'NEW'),
(5986, 1.4, 0.6, '2024-11-28 01:35:00', 'CRITICAL LEVEL', 'ENTRY'),
(5987, 2, 0.6, '2024-11-28 01:40:00', 'LOW LEVEL', 'NEW'),
(5988, 1.8, 0.5, '2024-11-28 01:45:00', 'LOW LEVEL', 'ENTRY'),
(5989, 1.6, 0.4, '2024-11-28 01:50:00', 'MEDIUM LEVEL', 'NEW'),
(5990, 5, 0.5, '2024-11-28 01:55:00', 'MEDIUM LEVEL', 'ENTRY'),
(5991, 5, 0.7, '2024-11-28 02:00:00', 'CRITICAL LEVEL', 'NEW'),
(5992, 1.6, 0.6, '2024-11-28 02:05:00', 'CRITICAL LEVEL', 'ENTRY'),
(5993, 1.2, 0.3, '2024-11-30 01:15:32', 'MEDIUM LEVEL', 'NEW'),
(5994, 3.4, 0.3, '0000-00-00 00:00:00', 'LOW LEVEL', 'NEW');

--
-- Triggers `sensor_data`
--
DELIMITER $$
CREATE TRIGGER `assign_status` BEFORE INSERT ON `sensor_data` FOR EACH ROW BEGIN
    DECLARE prev_alert_level VARCHAR(50);
    DECLARE prev_id INT;
    SELECT alert_level, id INTO prev_alert_level, prev_id
    FROM sensor_data
    ORDER BY id DESC
    LIMIT 1;
    IF prev_alert_level IS NULL OR NEW.alert_level != prev_alert_level THEN
        SET NEW.status = 'NEW';
    ELSE
        SET NEW.status = 'ENTRY';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `contact_no` varchar(15) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Local Authority') NOT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `account_status` enum('Active','Inactive','Locked') DEFAULT 'Active',
  `position` varchar(255) DEFAULT NULL,
  `house_lot_number` varchar(255) DEFAULT NULL,
  `street_subdivision_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_attempt_date` date DEFAULT NULL,
  `last_attempt_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `contact_no`, `sex`, `birthdate`, `email`, `password`, `role`, `schedule`, `profile_photo`, `shift`, `account_status`, `position`, `house_lot_number`, `street_subdivision_name`, `city`, `barangay`, `failed_attempts`, `last_attempt_date`, `last_attempt_time`) VALUES
(105, '00001', 'Beomgyu', 'Law', 'Choi', '', '09195738798', 'Male', '2024-03-13', 'beomgyu@gmail.com', '$2y$10$zMAxcmPJ3DQHyeX8CnNgXevkuO1ECMMsp0JZccbIWheYZbBK7AtVa', 'Admin', 'TUE, THU', 'uploads/1732107157_Screenshot 2024-11-13 140048.png', 'Mid Shift', 'Active', 'Executive Officer', 'Blk 2 Lot 19', 'Blas Roque Subdivision', 'Quezon City', 'Bagbag', 0, NULL, NULL),
(106, '00002', 'Taehyun', 'Law', 'Kang', '', '09303530960', 'Male', '2024-02-05', 'ms4ngela@gmail.com', '$2y$10$C6W4tpImoXtHv1zUSQ8XK.C0oivcVnwZixVSdCvC2JLxYr2hPrHou', 'Local Authority', 'MON, TUE, WED', 'uploads/1732107236_Screenshot 2024-11-13 135944.png', 'Morning Shift', 'Active', 'Executive Officer', 'Blk 2 Lot 19', 'Blas Roque Subdivision', 'Quezon City', 'Bagbag', 0, NULL, NULL),
(119, '00003', 'Taehyung', 'Mine', 'Kim', '', '09254156354', 'Female', '2024-11-23', 'taehyung@gmail.com', '$2y$10$onZoRjSA2r5Dg2rV8ppEyO2PRkNveRNTHxaV6tHr5eBTDk.lkHH0m', 'Local Authority', NULL, '', NULL, 'Active', 'Executive Officer', '299', 'Asd', 'Quezon City', 'Bagbag', 0, NULL, NULL),
(120, '00004', 'Rose Ann', 'De Vera', 'Domingo', '', '09124380882', 'Female', '2000-09-23', 'roseanndevera079@gmail.com', '$2y$10$uznZmCQOO7PPVUXisvhn9OUcVjdkoaxAjGvuzaYoFLzzXGBLpZlbG', 'Admin', NULL, '', NULL, 'Active', 'Executive Officer', '299', 'weh', 'Quezon City', 'Bagbag', 0, NULL, NULL);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `check_duplicate_contact` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    -- Check if the contact number already exists in the database
    IF EXISTS (SELECT 1 FROM users WHERE contact_no = NEW.contact_no) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Contact number already exists.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_duplicate_contact_before_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    IF OLD.contact_no != NEW.contact_no AND EXISTS (SELECT 1 FROM users WHERE contact_no = NEW.contact_no) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Contact number already exists.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_duplicate_email_before_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    IF OLD.email != NEW.email AND EXISTS (SELECT 1 FROM users WHERE email = NEW.email) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Email address already exists.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `prevent_duplicate_email` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT 1
        FROM users
        WHERE email = NEW.email
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Duplicate email addresses are not allowed.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_contact_no` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.contact_no NOT REGEXP '^09[0-9]{9}$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid mobile number. Must be 11 digits and start with 09.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_contact_no_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    IF NEW.contact_no NOT REGEXP '^09[0-9]{9}$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid mobile number. Must be 11 digits and start with 09.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_email` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.email NOT REGEXP '^[A-Za-z0-9._%+-]+@gmail.com$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid email address. Must end with @gmail.com.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_email_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    IF NEW.email NOT REGEXP '^[A-Za-z0-9._%+-]+@gmail.com$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid email address. Must end with @gmail.com.';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_accounts`
--
ALTER TABLE `archive_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `flood_alerts`
--
ALTER TABLE `flood_alerts`
  ADD PRIMARY KEY (`flood_alert_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `reset_token` (`reset_token`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_resident` (`first_name`,`last_name`,`date_of_birth`,`email_address`),
  ADD KEY `fk_account_status` (`account_status_id`),
  ADD KEY `fk_civil_status` (`civil_status_id`),
  ADD KEY `fk_health_status` (`health_status_id`),
  ADD KEY `fk_sex` (`sex_id`),
  ADD KEY `fk_socioeconomic_category` (`socioeconomic_category_id`);

--
-- Indexes for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_accounts`
--
ALTER TABLE `archive_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5995;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `fk_account_status` FOREIGN KEY (`account_status_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_civil_status` FOREIGN KEY (`civil_status_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_health_status` FOREIGN KEY (`health_status_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_sex` FOREIGN KEY (`sex_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_socioeconomic_category` FOREIGN KEY (`socioeconomic_category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
