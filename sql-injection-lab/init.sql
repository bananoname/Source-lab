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
('RA!{S3cur3_4_7h3_Fl4g!_#W3_G0!}', 'A tricky flag with special characters and numbers.', 'Active'),
('R3D{Th3_B3st_1n_Th3_W0rld_2024!}', 'A red team flag with a bit of fun.', 'Active'),
('CTF{H4ck3r_0n_Th3_1nsid3@2024}', 'Flag for insider hacking challenges.', 'Resolved'),
('FUN{F1rst_T0_7H3_Top!_#Tr1ck3r}', 'A fun flag to kick off the challenge.', 'Active'),
('SQL{1nj3ct10n_$0_Fun!_@2024}', 'SQL Injection themed flag for the database challenge.', 'Resolved');

-- Tạo bảng articles để lưu trữ các bài viết
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm dữ liệu mẫu vào bảng articles
INSERT INTO articles (title, content) VALUES
('What is Cloud Computing?', 'Cloud computing is the delivery of different services through the Internet.'),
('Introduction to Cybersecurity', 'Cybersecurity is the practice of protecting systems, networks, and programs from digital attacks.'),
('The Rise of Artificial Intelligence', 'Artificial Intelligence (AI) is the simulation of human intelligence in machines.'),
('Understanding Blockchain', 'Blockchain is a decentralized digital ledger that records transactions across many computers.'),
('DevOps Practices and Principles', 'DevOps is a set of practices that combine software development and IT operations.');

