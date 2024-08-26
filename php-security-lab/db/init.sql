CREATE DATABASE IF NOT EXISTS lab_db;

USE lab_db;

CREATE TABLE IF NOT EXISTS employees (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_code VARCHAR(10) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    position VARCHAR(100) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO employees (employee_code, full_name, position, username, password) VALUES
('E001', 'Nguyễn Văn An', 'Manager', 'nguyenvana', '123456'),
('E002', 'Trần Thị Bích', 'Developer', 'tranthib', 'password'),
('E003', 'Lê Văn Cường', 'Tester', 'levanc', 'cuong123'),
('E004', 'Phạm Thị Diễm', 'Designer', 'phamthid', 'diem@123'),
('E005', 'Võ Văn Em', 'DevOps', 'vovane', 'abc12345'),
('ADMIN', 'Admin User', 'Administrator', 'admin', 'adminpassword');
