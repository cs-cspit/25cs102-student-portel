-- ============================================================
-- STUDENTHUB - Relational Database Schema & Seed Data (Practical 08)
-- Database: studenthub
-- Engine: InnoDB | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
-- ============================================================

CREATE DATABASE IF NOT EXISTS `studenthub` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `studenthub`;

-- ------------------------------------------------------------
-- Table structure for table `users`
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `audit_logs`;
DROP TABLE IF EXISTS `registrations`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('student', 'admin') NOT NULL DEFAULT 'student',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_users_email` (`email`),
  INDEX `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table structure for table `students`
-- ------------------------------------------------------------
CREATE TABLE `students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mobile` VARCHAR(15) NOT NULL,
  `course` VARCHAR(50) NOT NULL,
  `year` VARCHAR(20) NOT NULL,
  `gender` VARCHAR(10) NOT NULL,
  `status` ENUM('Active', 'Pending', 'Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX `idx_students_course` (`course`),
  INDEX `idx_students_year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table structure for table `events`
-- ------------------------------------------------------------
CREATE TABLE `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `event_date` DATE NOT NULL,
  `time_slot` VARCHAR(50) NOT NULL DEFAULT '10:00 AM - 04:00 PM',
  `venue` VARCHAR(150) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `poster` VARCHAR(255) NOT NULL DEFAULT 'uploads/events/default.jpg',
  `seats` INT NOT NULL DEFAULT 100,
  `status` ENUM('Active', 'Upcoming', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_events_date` (`event_date`),
  INDEX `idx_events_category` (`category`),
  INDEX `idx_events_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table structure for table `registrations`
-- ------------------------------------------------------------
CREATE TABLE `registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `registration_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('Confirmed', 'Waitlisted', 'Cancelled') NOT NULL DEFAULT 'Confirmed',
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY `unique_student_event` (`student_id`, `event_id`),
  INDEX `idx_reg_student` (`student_id`),
  INDEX `idx_reg_event` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table structure for table `audit_logs`
-- ------------------------------------------------------------
CREATE TABLE `audit_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `action` VARCHAR(100) NOT NULL,
  `entity` VARCHAR(50) NOT NULL,
  `entity_id` INT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `details` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_audit_user` (`user_id`),
  INDEX `idx_audit_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED DATA INSERTION
-- Password hash for 'Admin@123' and 'Student@123':
-- $2y$10$eA0y5iUo0E/jWp8o7GZ1veD719.6yVb6i2fG7Q2UvG2K1d/w5YF3a
-- ============================================================

-- 1. Insert Administrator & Students into `users`
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Administrator (Dhara Ma\'am)', 'admin@studenthub.edu', '$2y$10$wV3GzT19XgqC4KzL8/zHquF/0t.hQGgYgY6n/pWb8X9kYq1z0101a', 'admin'),
(2, 'Daksh Shah', '25cs102@charusat.edu.in', '$2y$10$wV3GzT19XgqC4KzL8/zHquF/0t.hQGgYgY6n/pWb8X9kYq1z0101a', 'student'),
(3, 'Aarav Patel', 'aarav.ce@charusat.edu.in', '$2y$10$wV3GzT19XgqC4KzL8/zHquF/0t.hQGgYgY6n/pWb8X9kYq1z0101a', 'student'),
(4, 'Diya Sharma', 'diya.it@charusat.edu.in', '$2y$10$wV3GzT19XgqC4KzL8/zHquF/0t.hQGgYgY6n/pWb8X9kYq1z0101a', 'student'),
(5, 'Rohan Mehta', 'rohan.cse@charusat.edu.in', '$2y$10$wV3GzT19XgqC4KzL8/zHquF/0t.hQGgYgY6n/pWb8X9kYq1z0101a', 'student');

-- 2. Insert 20 Seed Student Records
INSERT INTO `students` (`id`, `user_id`, `name`, `email`, `mobile`, `course`, `year`, `gender`, `status`) VALUES
(1, 2, 'Daksh Shah', '25cs102@charusat.edu.in', '9876543210', 'B.Tech CSE', '2nd Year', 'Male', 'Active'),
(2, 3, 'Aarav Patel', 'aarav.ce@charusat.edu.in', '9823456781', 'B.Tech CE', '3rd Year', 'Male', 'Active'),
(3, 4, 'Diya Sharma', 'diya.it@charusat.edu.in', '9834567892', 'B.Tech IT', '2nd Year', 'Female', 'Active'),
(4, 5, 'Rohan Mehta', 'rohan.cse@charusat.edu.in', '9845678903', 'B.Tech CSE', '4th Year', 'Male', 'Active'),
(5, NULL, 'Ananya Joshi', 'ananya.ec@charusat.edu.in', '9856789014', 'B.Tech EC', '1st Year', 'Female', 'Active'),
(6, NULL, 'Kavya Desai', 'kavya.it@charusat.edu.in', '9867890125', 'B.Tech IT', '3rd Year', 'Female', 'Active'),
(7, NULL, 'Vivek Trivedi', 'vivek.ce@charusat.edu.in', '9878901236', 'B.Tech CE', '2nd Year', 'Male', 'Active'),
(8, NULL, 'Pooja Varma', 'pooja.cse@charusat.edu.in', '9889012347', 'B.Tech CSE', '3rd Year', 'Female', 'Active'),
(9, NULL, 'Harshil Dave', 'harshil.me@charusat.edu.in', '9890123458', 'B.Tech ME', '4th Year', 'Male', 'Active'),
(10, NULL, 'Neha Pandya', 'neha.ec@charusat.edu.in', '9801234569', 'B.Tech EC', '2nd Year', 'Female', 'Active'),
(11, NULL, 'Siddharth Rana', 'siddharth.cse@charusat.edu.in', '9712345670', 'B.Tech CSE', '1st Year', 'Male', 'Active'),
(12, NULL, 'Bhavya Solanki', 'bhavya.it@charusat.edu.in', '9723456781', 'B.Tech IT', '2nd Year', 'Female', 'Active'),
(13, NULL, 'Manan Parmar', 'manan.ce@charusat.edu.in', '9734567892', 'B.Tech CE', '3rd Year', 'Male', 'Active'),
(14, NULL, 'Riddhi Soni', 'riddhi.cse@charusat.edu.in', '9745678903', 'B.Tech CSE', '2nd Year', 'Female', 'Active'),
(15, NULL, 'Parth Bhatt', 'parth.me@charusat.edu.in', '9756789014', 'B.Tech ME', '4th Year', 'Male', 'Active'),
(16, NULL, 'Tanvi Shah', 'tanvi.it@charusat.edu.in', '9767890125', 'B.Tech IT', '1st Year', 'Female', 'Active'),
(17, NULL, 'Kunal Joshi', 'kunal.cse@charusat.edu.in', '9778901236', 'B.Tech CSE', '3rd Year', 'Male', 'Active'),
(18, NULL, 'Isha Panchal', 'isha.ce@charusat.edu.in', '9789012347', 'B.Tech CE', '2nd Year', 'Female', 'Active'),
(19, NULL, 'Jay Patel', 'jay.me@charusat.edu.in', '9790123458', 'B.Tech ME', '1st Year', 'Male', 'Active'),
(20, NULL, 'Maitri Dave', 'maitri.ec@charusat.edu.in', '9701234569', 'B.Tech EC', '4th Year', 'Female', 'Active');

-- 3. Insert 16 Seed Events
INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `time_slot`, `venue`, `category`, `poster`, `seats`, `status`) VALUES
(1, 'CodeSprint 2026: 24-Hour Hackathon', 'Annual flagship 24-hour coding hackathon focusing on AI, Cloud, and Full-Stack web solutions for university challenges.', '2026-10-15', '09:00 AM - 09:00 AM', 'CSPIT Computer Lab Complex 301-304', 'technical', 'pr2/html/assets/images/event1.jpg', 150, 'Active'),
(2, 'Full-Stack Web Dev Masterclass', 'Master PHP 8+, MySQL prepared statements, modern Vanilla JS ES6+, and responsive CSS Grid architecture.', '2026-10-22', '10:00 AM - 04:30 PM', 'Seminar Hall B, CSPIT', 'workshop', 'pr2/html/assets/images/event2.jpg', 100, 'Active'),
(3, 'Spandan 2026: Annual Youth Festival', 'Grand university cultural festival featuring battle of bands, theatrical plays, literary debate, and solo singing.', '2026-11-05', '05:00 PM - 10:30 PM', 'CHARUSAT Central Open Air Theatre', 'cultural', 'pr2/html/assets/images/event3.jpg', 500, 'Active'),
(4, 'RoboQuest: Autonomous Line Follower', 'Hands-on robotics competition to build and program microcontrollers to navigate obstacle tracks.', '2026-11-12', '11:00 AM - 03:30 PM', 'Robotics & IoT Laboratory', 'technical', 'pr2/html/assets/images/event1.jpg', 60, 'Active'),
(5, 'Cybersecurity & Ethical Hacking Bootcamp', 'Learn penetration testing basics, OWASP Top 10 vulnerabilities, and security hardening for enterprise networks.', '2026-11-19', '09:30 AM - 01:30 PM', 'Virtual Zoom Lecture Hall', 'workshop', 'pr2/html/assets/images/event2.jpg', 200, 'Active'),
(6, 'Inter-Department Badminton Tournament', 'Annual singles and doubles badminton knockout tournament open for all engineering students.', '2026-11-26', '08:00 AM - 06:00 PM', 'University Indoor Sports Complex', 'sports', 'pr2/html/assets/images/event3.jpg', 64, 'Active'),
(7, 'AI & Deep Learning Symposium', 'Keynote talks by industry leaders on Large Language Models, Transformer architectures, and generative media.', '2026-12-03', '10:00 AM - 04:00 PM', 'Auditorium 1, Changa Campus', 'workshop', 'pr2/html/assets/images/event1.jpg', 250, 'Active'),
(8, 'Speed Coding & Bug Bounty Arena', 'Competitive programming sprint solving data structure challenges under strict runtime constraints.', '2026-12-10', '02:00 PM - 05:00 PM', 'CSE Advanced Computing Lab', 'technical', 'pr2/html/assets/images/event2.jpg', 80, 'Active'),
(9, 'Campus Photography & Short Film Expo', 'Student visual showcase celebrating short films, nature photography, and creative campus storytelling.', '2026-12-17', '11:00 AM - 05:00 PM', 'Student Activity Center', 'cultural', 'pr2/html/assets/images/event3.jpg', 120, 'Active'),
(10, 'Cloud DevOps with Docker & Kubernetes', 'Master CI/CD pipelines, containerization, microservice orchestration, and automated server deployments.', '2027-01-08', '09:00 AM - 01:00 PM', 'IT Department Seminar Room', 'workshop', 'pr2/html/assets/images/event1.jpg', 90, 'Upcoming'),
(11, 'University Cricket League 2027', 'T20 inter-college cricket championship between engineering, pharmacy, and management institutes.', '2027-01-15', '08:30 AM - 05:30 PM', 'CHARUSAT Sports Ground', 'sports', 'pr2/html/assets/images/event2.jpg', 16, 'Upcoming'),
(12, 'UI/UX Design Sprint & Figma Masterclass', 'Design accessible design systems, user personas, interactive prototypes, and modern usability heuristics.', '2027-01-22', '10:30 AM - 03:30 PM', 'Multimedia Lab 102', 'workshop', 'pr2/html/assets/images/event3.jpg', 70, 'Upcoming'),
(13, 'National Level Tech Debate', 'High-stakes debate on AI ethics, data privacy laws, algorithmic governance, and quantum computing.', '2027-01-29', '01:30 PM - 05:00 PM', 'Council Room, Admin Block', 'cultural', 'pr2/html/assets/images/event1.jpg', 100, 'Upcoming'),
(14, 'AppDev with Flutter & Progressive Web Apps', 'Build high-performance cross-platform mobile and web applications with a single shared codebase.', '2027-02-05', '10:00 AM - 04:00 PM', 'Computer Engineering Lab 204', 'technical', 'pr2/html/assets/images/event2.jpg', 85, 'Upcoming'),
(15, 'University Table Tennis Championship', 'Fast-paced indoor table tennis singles and doubles tournament for boys and girls categories.', '2027-02-12', '09:00 AM - 04:00 PM', 'Indoor Games Hall', 'sports', 'pr2/html/assets/images/event3.jpg', 32, 'Upcoming'),
(16, 'Blockchain & Smart Contracts Masterclass', 'Introduction to decentralized applications, cryptographic consensus, and Solidity smart contract development.', '2027-02-19', '11:00 AM - 03:00 PM', 'Virtual Interactive Hall', 'technical', 'pr2/html/assets/images/event1.jpg', 120, 'Upcoming');

-- 4. Seed Registrations
INSERT INTO `registrations` (`id`, `student_id`, `event_id`, `status`) VALUES
(1, 1, 1, 'Confirmed'),
(2, 1, 2, 'Confirmed'),
(3, 1, 3, 'Waitlisted'),
(4, 2, 1, 'Confirmed'),
(5, 3, 2, 'Confirmed');

-- 5. Seed Audit Logs
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `entity`, `entity_id`, `ip_address`, `details`) VALUES
(1, 1, 'DATABASE_INITIALIZATION', 'SYSTEM', NULL, '127.0.0.1', 'StudentHub database schema and seed data loaded successfully.'),
(2, 1, 'USER_LOGIN', 'users', 1, '192.168.1.45', 'Admin Dhara Ma\'am logged in from campus network.'),
(3, 2, 'EVENT_REGISTRATION', 'events', 1, '10.0.4.18', 'Student Daksh Shah (25CS102) registered for CodeSprint 2026.');
