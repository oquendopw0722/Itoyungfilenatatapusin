-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 05:54 AM
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
-- Database: `myfirstdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `posted_by` int(11) NOT NULL,
  `posted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `posted_by`, `posted_at`) VALUES
(1, 'Test Announcement 1', 'Testing Announcement', 25, '2025-11-05 10:35:01'),
(2, 'Test Announcement 2', 'Hello Dear Parents\r\n\r\nWelcome!', 25, '2025-11-05 10:36:03'),
(3, 'Test Announcement 3', 'Hello Dear Parents\r\nX\r\nX\r\nWelcome!!!\r\nX\r\nX\r\nX', 25, '2025-11-05 10:36:19'),
(4, 'Test announcement 4', 'The FV4007 (A41) Centurion was the primary main battle tank of the British Army during the post-World War II period. Introduced in 1945, it is one of the most successful post-war tank designs, remaining in production into the 1960s, and seeing combat into the 1980s.', 25, '2025-11-05 10:36:45'),
(5, 'test announcement 5', 'Stephen Curry\r\nLebron James\r\nSteve Nash\r\n\r\n\r\nMind the Game podcast\r\n\r\nX\r\nX', 25, '2025-11-05 10:37:22'),
(6, 'test announcement 6', 'Too Lazy\r\nToo brain dead\r\nToo uncreative\r\nToo procrastinate', 25, '2025-11-06 06:25:19'),
(7, 'Test announcement 7', 'Hello Parents and Teachers!\r\n\r\n\r\nWelcome to School year 2026\r\nBatch 1 !!!', 25, '2025-11-07 23:57:58'),
(8, 'test announcement 8', 'Words of Encouragement\r\n\r\nDont Give up!\r\nIt is Okay.', 25, '2025-11-08 05:43:38'),
(9, 'Test Announcement 9', 'As we end the current batch,\r\n\r\nWe would like to invite you to the event. Let us come together and enjoy!', 25, '2025-11-08 05:45:11'),
(10, 'Test announcement 10', 'HELLO\r\n\r\nHELLO\r\n\r\nHELLO\r\n\r\nHELLO xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 25, '2025-11-08 06:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `lrn` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `section` varchar(50) NOT NULL,
  `school_year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `parent_id`, `teacher_id`, `name`, `age`, `gender`, `lrn`, `created_at`, `section`, `school_year`) VALUES
(1, 28, 21, 'Charlson', 6, 'Male', NULL, '2025-10-29 06:01:21', 'Sampaguita', '2025'),
(2, 27, 21, 'Maxson', 6, 'Male', NULL, '2025-10-29 06:02:31', 'Rosas', '2026'),
(3, 20, 23, 'George W. Bush', 5, 'Male', NULL, '2025-11-12 02:54:42', 'Gumamela', '2025'),
(4, 20, 23, 'Albert W. Bush', 7, 'Male', NULL, '2025-11-12 02:56:18', 'Sunflower', '2026');

--
-- Triggers `children`
--
DELIMITER $$
CREATE TRIGGER `validate_teacher_role_before_insert` BEFORE INSERT ON `children` FOR EACH ROW BEGIN
    IF NEW.teacher_id IS NOT NULL THEN
        IF (SELECT role FROM users WHERE id = NEW.teacher_id) <> 'teacher' THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'teacher_id must refer to a user with role = teacher';
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `validate_teacher_role_before_update` BEFORE UPDATE ON `children` FOR EACH ROW BEGIN
    IF NEW.teacher_id IS NOT NULL THEN
        IF (SELECT role FROM users WHERE id = NEW.teacher_id) <> 'teacher' THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'teacher_id must refer to a user with role = teacher';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT curtime(),
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `username`, `comment_text`, `created_at`, `users_id`) VALUES
(1, 'cajachan', 'Hello, this is okay, the website is still in progress', '2025-10-14 03:00:52', 1),
(2, 'cajachan', 'Hello, this is 2nd comment', '2025-10-15 04:52:58', 1),
(3, 'cajachan', 'Hello, this is 3rd comment', '2025-10-15 04:52:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `eccd_progress`
--

CREATE TABLE `eccd_progress` (
  `id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `domain` varchar(50) NOT NULL,
  `progress_percentage` int(11) NOT NULL CHECK (`progress_percentage` >= 0 and `progress_percentage` <= 100),
  `checklist_items` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eccd_progress`
--

INSERT INTO `eccd_progress` (`id`, `child_id`, `domain`, `progress_percentage`, `checklist_items`, `updated_at`) VALUES
(1, 1, 'Gross Motor', 85, 'still a bit clumsy\r\nbut can walk straight can run', '2025-10-29 06:01:21'),
(2, 2, 'Cognitive', 77, 'normal abilities relative to age. Need further monitoring', '2025-10-29 06:02:31'),
(3, 1, 'OTHERS', 60, 'needs improvement', '2025-10-29 06:44:45'),
(4, 1, 'Gross Motor', 55, 'testing', '2025-10-29 06:45:54'),
(5, 3, 'Gross Motor', 89, 'needs improvement', '2025-11-12 03:06:32'),
(6, 4, 'Gross Motor', 93, 'needs improvement', '2025-11-12 03:06:42'),
(7, 4, 'Gross Motor', 81, 'Can walk steadily:1', '2025-11-12 03:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_date`, `title`, `description`, `created_by`, `created_at`) VALUES
(1, '2025-11-08', 'Pre defense 1', 'Pre defense 1\r\n\r\n-sir Julian', 25, '2025-11-07 10:04:05'),
(2, '2025-11-30', 'Party??', 'Party??', 25, '2025-11-07 10:04:31'),
(3, '2025-11-22', 'C# submission', 'Submission Deadline for C# project\r\n\r\nXXX', 25, '2025-11-08 00:30:44'),
(4, '2025-12-25', 'Christmas', 'Merry Christmas!!!\r\n\r\nHOHOHO', 24, '2025-11-08 05:52:53'),
(5, '2025-12-31', 'New Year\'s Eve', 'New Year\'s Eve', 24, '2025-11-08 05:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `learning_materials`
--

CREATE TABLE `learning_materials` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` enum('pdf','video') NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_materials`
--

INSERT INTO `learning_materials` (`id`, `title`, `description`, `file_path`, `file_type`, `uploaded_by`, `uploaded_at`) VALUES
(1, 'ECCD Council Member Agencies and Programs', 'ECCD Council Member Agencies and Programs', 'uploads/690239023e593_ECCD Council Member Agencies and Programs.mp4', '', 25, '2025-10-29 15:55:46'),
(2, 'ECCD checklist', 'checklist - for testing', 'uploads/6902394055116_ECCD-Checklist-Child-s-Record-2.pdf', 'pdf', 25, '2025-10-29 15:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `report_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `child_id`, `teacher_id`, `report_text`, `created_at`) VALUES
(1, 1, 23, 'need normal amount of attention', '2025-10-29 06:01:21'),
(2, 2, 23, 'need special attention for cognitive', '2025-10-29 06:02:31'),
(3, 1, 23, 'need high attention on others', '2025-10-29 06:44:45'),
(4, 1, 23, 'testing', '2025-10-29 06:45:54'),
(5, 3, 21, 'need special attention for cognitive kasi baliw', '2025-11-12 02:54:42'),
(6, 4, 21, 'need special attention for cognitive kasi baliw', '2025-11-12 02:56:18'),
(7, 4, 23, 'Medications for craziness', '2025-11-12 03:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `student_status`
--

CREATE TABLE `student_status` (
  `id` int(11) NOT NULL,
  `children_id` int(11) NOT NULL,
  `status` enum('draft','enrolled','graduated','withdrawn','suspended') NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_status`
--

INSERT INTO `student_status` (`id`, `children_id`, `status`, `last_updated`) VALUES
(1, 1, 'enrolled', '2025-11-23 04:52:57'),
(2, 2, 'draft', '2025-11-23 04:52:57'),
(3, 3, 'enrolled', '2025-11-23 04:52:57'),
(4, 4, 'graduated', '2025-11-23 04:52:57');

-- --------------------------------------------------------

--
-- Table structure for table `test1`
--

CREATE TABLE `test1` (
  `entry_id` int(11) NOT NULL,
  `user_entry` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT curtime(),
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test1`
--

INSERT INTO `test1` (`entry_id`, `user_entry`, `created_at`, `users_id`) VALUES
(1, 'LOREM IPSUM		\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.			', '2025-10-16 11:07:58', NULL),
(2, '	waahahahahahahhaahahhahah			', '2025-10-16 12:05:13', NULL),
(3, '							', '2025-10-16 12:37:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT curtime(),
  `role` enum('parent','teacher','admin') NOT NULL DEFAULT 'parent',
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `phone` varchar(18) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `email`, `created_at`, `role`, `first_name`, `last_name`, `phone`, `updated_at`, `is_active`, `status`) VALUES
(1, 'cajachan', 'pass1234', 'johndoe1@kmail.com', '2025-10-14', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(2, 'ferrari', 'ferrari123', 'ferrari@email.com', '2025-10-14', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(3, 'mercedes', 'mercedes', 'mercedes@email.com', '2025-10-14', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(6, 'number4wasdeleted', 'hahahaha789', 'wahaha@email.com', '2025-10-14', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(7, 'test22', 'test22', 'test22@email.com', '2025-10-15', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(8, 'test33', 'test33', 'test33@email.com', '2025-10-15', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(10, 'chanchan', 'chachan', 'chan123@email.com', '2025-10-15', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(11, 'test444', 'test444', 'test444@email.com', '2025-10-16', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(12, 'test47', '', 'test47@email.com', '2025-10-16', 'parent', NULL, NULL, NULL, '2025-10-24 01:39:53', 1, 'active'),
(13, 'test5555', 'test5555', 'test5555@email.com', '2025-10-16', 'parent', NULL, NULL, NULL, '2025-10-24 01:39:53', 1, 'active'),
(14, 'max', 'max123', 'max@email.com', '2025-10-16', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(15, 'testor', 'testor', 'testor@email.com', '2025-10-16', 'parent', NULL, NULL, NULL, '2025-10-24 01:39:53', 1, 'active'),
(16, 'verstappen', 'verstappen', 'verstappen@email.com', '2025-10-16', 'parent', NULL, NULL, NULL, '2025-10-24 01:39:53', 1, 'active'),
(17, 'Christian', 'christian', 'christian@email.com', '2025-10-20', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(18, 'maria', '$2y$12$m7D2aSllw1t2vY6PezWDbesov9Z2UEObcGpsADJhAXuPORQlrEWsi', 'maria@email.com', '2025-10-21', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(19, 'cccc', '$2y$12$bk73Ok5lOV.nTu3B.oGAq.vC5xC40TW0DqwWCAnTFmvM3DBk9mkIu', 'cccc@email.com', '2025-10-21', 'parent', NULL, NULL, NULL, '2025-11-12 06:00:50', 1, 'active'),
(20, 'Jakiro', '$2y$10$k0Iacn4mNeHOiwPkqIrJcOlRfDGjwH2G508r3StUitKq2aSJ7JPzu', 'jakiro@email.com', '2025-10-24', 'parent', 'Christian', 'Chan', '', '2025-11-12 06:00:50', 1, 'active'),
(21, 'teacher1', '$2y$10$k0Iacn4mNeHOiwPkqIrJcOlRfDGjwH2G508r3StUitKq2aSJ7JPzu', 'teacher1@email.com', '2025-10-24', 'teacher', 'teacher1', 'teacher1', '', '2025-11-11 03:07:53', 1, 'active'),
(22, 'Admin1', '$2y$10$k0Iacn4mNeHOiwPkqIrJcOlRfDGjwH2G508r3StUitKq2aSJ7JPzu', 'admin1@email.com', '2025-10-24', 'admin', 'Admin1', 'Admin1', '', '2025-11-11 02:22:22', 1, 'active'),
(23, 'teacher2', '$2y$10$k0Iacn4mNeHOiwPkqIrJcOlRfDGjwH2G508r3StUitKq2aSJ7JPzu', 'teacher2@email.com', '2025-10-29', 'teacher', 'teacher2', 'teacher2', '', '2025-11-12 03:35:46', 1, 'active'),
(24, 'teacher3', '$2y$12$xzrKuPxi1Y8.Hsf0zx55h.fa.uswVnOa6ELHyYsA7bVxt/K.FY7fO', 'teacher3@email.com', '2025-10-29', 'teacher', 'teacher3', 'teacher3', '', '2025-10-29 05:05:52', 1, 'active'),
(25, '9999', '$2y$12$yIkDySRj0utaUDcKweV0b.A12T/mBCdRN5O46FcICc.FzfKKeZZJG', 'admin2@email.com', '2025-10-29', 'admin', 'Admin2', 'Admin2', '09158747165', '2025-10-29 05:08:01', 1, 'active'),
(26, '8888', '$2y$12$leDDuV9P56JzO3UhKlV1kOoqKSEcMfE7S1qb6ajjCk4oAF8OAa3iG', 'admin3@email.com', '2025-10-29', 'admin', 'Admin3', 'Admin3', '09770310037', '2025-10-29 05:10:22', 1, 'active'),
(27, 'maxver', '$2y$10$k0Iacn4mNeHOiwPkqIrJcOlRfDGjwH2G508r3StUitKq2aSJ7JPzu', 'maxracing@email.com', '2025-10-29', 'parent', 'Max', 'Verstappen', '76349823456', '2025-11-12 06:00:50', 1, 'active'),
(28, 'leclerc', '$2y$10$k0Iacn4mNeHOiwPkqIrJcOlRfDGjwH2G508r3StUitKq2aSJ7JPzu', 'leclerc16@email.com', '2025-10-29', 'parent', 'Charles', 'Leclerc', '09875412456', '2025-11-12 06:00:50', 1, 'active'),
(29, 'test4', '$2y$12$Oo2XMvsAGYsjLW2ptZD6ruSCMkaZE96CiC7nJPMSZqn0Rsr/un7/C', 'test4@email.com', '2025-11-06', 'parent', 'test4', 'test4', '', '2025-11-12 06:00:50', 1, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `fk_teacher_user` (`teacher_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `eccd_progress`
--
ALTER TABLE `eccd_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `student_status`
--
ALTER TABLE `student_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `children_id` (`children_id`);

--
-- Indexes for table `test1`
--
ALTER TABLE `test1`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eccd_progress`
--
ALTER TABLE `eccd_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_status`
--
ALTER TABLE `student_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test1`
--
ALTER TABLE `test1`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teacher_user` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `eccd_progress`
--
ALTER TABLE `eccd_progress`
  ADD CONSTRAINT `eccd_progress_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `learning_materials_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `student_status`
--
ALTER TABLE `student_status`
  ADD CONSTRAINT `student_status_ibfk_1` FOREIGN KEY (`children_id`) REFERENCES `children` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test1`
--
ALTER TABLE `test1`
  ADD CONSTRAINT `test1_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
