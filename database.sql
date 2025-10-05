-- SQL tạo CSDL: student_dorm
-- Chạy từng dòng trong HeidiSQL / phpMyAdmin hoặc dòng lệnh MySQL

CREATE DATABASE IF NOT EXISTS `student_dorm` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `student_dorm`;

-- Bảng sinh viên
CREATE TABLE IF NOT EXISTS `students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_code` VARCHAR(20) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `phone` VARCHAR(20) NULL,
  `gender` ENUM('male','female','') NOT NULL DEFAULT '',
  `dob` DATE NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_students_code` (`student_code`),
  UNIQUE KEY `uniq_students_email` (`email`)
) ENGINE=InnoDB;

-- Bảng phòng
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_code` VARCHAR(20) NOT NULL,
  `capacity` INT UNSIGNED NOT NULL DEFAULT 4,
  `gender` ENUM('male','female','') NOT NULL DEFAULT '',
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_rooms_code` (`room_code`)
) ENGINE=InnoDB;

-- Bảng hợp đồng xếp phòng
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` INT UNSIGNED NOT NULL,
  `room_id` INT UNSIGNED NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contracts_student` (`student_id`),
  KEY `idx_contracts_room` (`room_id`),
  CONSTRAINT `fk_contracts_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_contracts_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Dữ liệu mẫu
INSERT INTO `students` (student_code, full_name, email, phone, gender, dob, created_at) VALUES
('SV001','Nguyễn Văn A','a@example.com','0901000001','male','2003-01-01', NOW()),
('SV002','Trần Thị B','b@example.com','0901000002','female','2003-05-12', NOW());

INSERT INTO `rooms` (room_code, capacity, gender, created_at) VALUES
('P101', 4, 'male', NOW()),
('P102', 4, 'female', NOW()),
('P103', 6, '', NOW());





