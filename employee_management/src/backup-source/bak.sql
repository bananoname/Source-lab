CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL
);

INSERT INTO employees (employee_id, name, role, password, salary) VALUES 
('E001', 'John Doe', 'employee', 'password123', 5000.00),
('E002', 'Jane Smith', 'employee', 'password123', 6000.00),
('E003', 'Admin', 'admin', 'admin123', 10000.00);
