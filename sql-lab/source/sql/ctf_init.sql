-- Tạo cơ sở dữ liệu ctf_database nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS ctf_database;
USE ctf_database;

-- Tạo bảng ctf_flags
CREATE TABLE IF NOT EXISTS ctf_flags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag_code VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    status ENUM('Active', 'Resolved') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL
);

-- Thêm dữ liệu mẫu vào bảng ctf_flags
INSERT INTO ctf_flags (flag_code, description, status) VALUES
('CTF{flag_001}', 'This is the first flag for the CTF challenge.', 'Active'),
('CTF{flag_002}', 'This flag is part of the intermediate level.', 'Active'),
('CTF{flag_003}', 'Final flag for advanced challenges.', 'Resolved');
