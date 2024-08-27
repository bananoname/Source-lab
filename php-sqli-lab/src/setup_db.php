<?php
$servername = "db";
$username = "user";
$password = "password";
$dbname = "testdb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo bảng employees và chèn dữ liệu mẫu
$conn->query("CREATE TABLE IF NOT EXISTS employees (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    position VARCHAR(50) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL
)");

$conn->query("INSERT INTO employees (name, position, salary) VALUES
('John Doe', 'Manager', 75000.00),
('Jane Smith', 'Developer', 65000.00),
('Emily Johnson', 'Designer', 55000.00),
('Michael Brown', 'Analyst', 60000.00),
('Chris Davis', 'Support', 50000.00)
");

// Tạo bảng products và chèn dữ liệu mẫu
$conn->query("CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
)");

$conn->query("INSERT INTO products (name, category, price) VALUES
('Laptop', 'Electronics', 1200.00),
('Smartphone', 'Electronics', 800.00),
('Tablet', 'Electronics', 400.00),
('Headphones', 'Accessories', 150.00),
('Monitor', 'Electronics', 300.00)
");

// Tạo bảng flags
$sql = "CREATE TABLE IF NOT EXISTS flags (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    flag_value VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Bảng 'flags' đã được tạo thành công.<br>";
} else {
    echo "Lỗi tạo bảng: " . $conn->error . "<br>";
}

// Chèn dữ liệu mẫu vào bảng flags
$sql = "INSERT INTO flags (flag_value) VALUES 
    ('FLAG{SQLInjectionSofun}')";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu flag đã được chèn thành công.<br>";
} else {
    echo "Lỗi chèn dữ liệu: " . $conn->error . "<br>";
}

// Tạo bảng users và chèn dữ liệu mẫu
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'users' đã được tạo thành công.<br>";
} else {
    echo "Lỗi tạo bảng: " . $conn->error . "<br>";
}

$sql = "INSERT INTO users (username, email) VALUES 
    ('alice', 'alice@officecontacts.com'),
    ('bob', 'bob@officecontacts.com'),
    ('charlie', 'charlie@officecontacts.com'),
    ('david', 'david@officecontacts.com'),
    ('eve', 'eve@officecontacts.com'),
    ('frank', 'frank@officecontacts.com'),
    ('grace', 'grace@officecontacts.com'),
    ('heidi', 'heidi@officecontacts.com'),
    ('ivan', 'ivan@officecontacts.com'),
    ('judy', 'judy@officecontacts.com'),
    ('karl', 'karl@officecontacts.com'),
    ('lisa', 'lisa@officecontacts.com'),
    ('mike', 'mike@officecontacts.com'),
    ('nina', 'nina@officecontacts.com'),
    ('olivia', 'olivia@officecontacts.com'),
    ('paul', 'paul@officecontacts.com'),
    ('quinn', 'quinn@officecontacts.com'),
    ('rachel', 'rachel@officecontacts.com'),
    ('sam', 'sam@officecontacts.com'),
    ('tina', 'tina@officecontacts.com'),
    ('ursula', 'ursula@officecontacts.com'),
    ('victor', 'victor@officecontacts.com'),
    ('wendy', 'wendy@officecontacts.com'),
    ('xander', 'xander@officecontacts.com'),
    ('yara', 'yara@officecontacts.com'),
    ('zach', 'zach@officecontacts.com')";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu mẫu đã được chèn thành công.<br>";
} else {
    echo "Lỗi chèn dữ liệu: " . $conn->error . "<br>";
}

// Đóng kết nối
$conn->close();

echo "Script hoàn tất.";
?>
