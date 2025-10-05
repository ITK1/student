<?php
// Cấu hình chung ứng dụng

// Nếu bạn dùng Laragon, MySQL mặc định: host=localhost, user=root, pass rỗng
// Có thể sửa nhanh tại đây hoặc tạo file .env (không bắt buộc để đơn giản)

define('APP_NAME', 'Quản lý Sinh viên - Ký túc xá');

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'student_dorm');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

// Base URL tương đối (dùng với Laragon http://localhost/student-dorm/)
// Nếu đặt trong thư mục khác, chỉ cần đổi BASE_PATH.
define('BASE_PATH', '/student-dorm');





