-- Drop the existing tables if they exist
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS ranks;
DROP TABLE IF EXISTS positions;

-- Create the ranks table
CREATE TABLE ranks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rank_name VARCHAR(100) NOT NULL
);

-- Create the positions table
CREATE TABLE positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    position_name VARCHAR(100) NOT NULL
);

-- Create the employees table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    rank_id INT NOT NULL,
    position_id INT NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    password VARCHAR(100) NOT NULL,
    FOREIGN KEY (rank_id) REFERENCES ranks(id),
    FOREIGN KEY (position_id) REFERENCES positions(id)
);

ALTER TABLE employees ADD COLUMN rank_id INT;
ALTER TABLE employees ADD COLUMN position_id INT;
ALTER TABLE employees ADD FOREIGN KEY (rank_id) REFERENCES ranks(id);
ALTER TABLE employees ADD FOREIGN KEY (position_id) REFERENCES

-- Insert sample data into the ranks table
INSERT INTO ranks (rank_name) VALUES
('Junior Developer'),
('Mid-Level Developer'),
('Senior Developer'),
('Lead Developer');

-- Insert sample data into the positions table
INSERT INTO positions (position_name) VALUES
('Software Engineer'),
('Project Manager'),
('CTO'),
('HR');

-- Insert sample data into the employees table
INSERT INTO employees (employee_id, name, rank_id, position_id, salary, password) VALUES
('E001', 'John Doe', 2, 1, 5000.00, 'password123'),
('E002', 'Jane Smith', 3, 2, 6000.00, 'password123'),
('E003', 'Admin', 4, 3, 10000.00, 'admin123');

