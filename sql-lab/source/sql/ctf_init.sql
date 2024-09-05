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

-- Thêm dữ liệu mẫu vào bảng ctf_flags với ký tự đặc biệt
INSERT INTO ctf_flags (flag_code, description, status) VALUES
('RA!{S3cur3_4_7h3_Fl4g!_#W3_G0!}', 'A tricky flag with special characters and numbers.', 'Active'),
('R3D{Th3_B3st_1n_Th3_W0rld_2024!}', 'A red team flag with a bit of fun.', 'Active'),
('CTF{H4ck3r_0n_Th3_1nsid3@2024}', 'Flag for insider hacking challenges.', 'Resolved'),
('FUN{F1rst_T0_7H3_Top!_#Tr1ck3r}', 'A fun flag to kick off the challenge.', 'Active'),
('SQL{1nj3ct10n_$0_Fun!_@2024}', 'SQL Injection themed flag for the database challenge.', 'Resolved');
