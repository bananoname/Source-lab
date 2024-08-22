CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    display_name VARCHAR(100),
    role VARCHAR(50),
    salary DECIMAL(10, 2),
    is_admin BOOLEAN DEFAULT FALSE
);

-- Thêm người dùng admin và nhân viên
INSERT INTO users (username, password, display_name, role, salary, is_admin) VALUES
('johndoe', 'password123', 'John Doe', 'Developer', 60000.00, FALSE),
('janedoe', 'password456', 'Jane Doe', 'Manager', 80000.00, FALSE),
('admin', 'adminpassword', 'Admin User', 'Administrator', NULL, TRUE),
('sarahsmith', 'sarahpassword', 'Sarah Smith', 'Designer', 55000.00, FALSE),
('michaeljohnson', 'michaelpassword', 'Michael Johnson', 'Analyst', 70000.00, FALSE),
('emilydavis', 'emilypassword', 'Emily Davis', 'Support', 45000.00, FALSE),
('davidwilson', 'davidpassword', 'David Wilson', 'Developer', 62000.00, FALSE),
('laurabrown', 'laurapassword', 'Laura Brown', 'HR Manager', 75000.00, FALSE),
('robertwhite', 'robertpassword', 'Robert White', 'Database Administrator', 72000.00, FALSE),
('olivialee', 'oliviapassword', 'Olivia Lee', 'Project Manager', 82000.00, FALSE);


