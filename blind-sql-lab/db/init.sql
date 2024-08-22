CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL
);
INSERT INTO users (username, password) VALUES ('admin', 'admin');

INSERT INTO employees (user_id, name, position, salary) VALUES
(1, 'John Doe', 'Software Engineer', 60000.00),
(1, 'Jane Smith', 'Project Manager', 75000.00),
(2, 'Alice Johnson', 'Designer', 55000.00),
(2, 'Bob Brown', 'Analyst', 50000.00),
(3, 'Charlie Davis', 'Developer', 62000.00);
