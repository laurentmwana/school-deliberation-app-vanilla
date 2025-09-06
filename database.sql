-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           11.8.2-MariaDB
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------


CREATE DATABASE IF NOT EXISTS `school_deliberation_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `school_deliberation_app`;

-- Table levels
CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Table years
CREATE TABLE IF NOT EXISTS `years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `is_closed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Table students
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `gender` char(50) NOT NULL,
  `registration_token` varchar(50) NOT NULL,
  `level_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_token` (`registration_token`) USING BTREE,
  KEY `FK_students_levels` (`level_id`),
  CONSTRAINT `FK_students_levels` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Table courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `credits` int(11) NOT NULL DEFAULT 0,
  `level_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_courses_levels` (`level_id`),
  CONSTRAINT `FK_courses_levels` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Table notes
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `period` varchar(50) NOT NULL,
  `obtained` int(11) NOT NULL,
  `is_closed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_notes_levels` (`level_id`),
  KEY `FK_notes_years` (`year_id`),
  KEY `FK_notes_courses` (`course_id`),
  KEY `FK_notes_students` (`student_id`),
  CONSTRAINT `FK_notes_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_notes_levels` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_notes_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_notes_years` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Table results
CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `period` varchar(50) NOT NULL DEFAULT '',
  `mention` varchar(50) NOT NULL DEFAULT '',
  `percent` float NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_results_years` (`year_id`),
  KEY `FK_results_students` (`student_id`),
  KEY `FK_results_levels` (`level_id`),
  CONSTRAINT `FK_results_levels` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_results_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_results_years` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Table users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

