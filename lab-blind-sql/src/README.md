# Bước 1: Tạo Cấu Trúc Dự Án
```
mkdir lab-php-mysql
cd lab-php-mysql
```
# Bước 2: Tạo file dockerfile
```
# Dockerfile cho PHP
FROM php:8.2-apache

# Cài đặt các phụ thuộc cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

# Sao chép mã nguồn vào thư mục của Apache
COPY src/ /var/www/html/

# Expose cổng 80
EXPOSE 80
```
# Bước 3: Tạo Tệp docker-compose.yml
```
version: '3.8'

services:
  web:
    build: .
    ports:
      - "80:80"
    depends_on:
      - db
    environment:
      - MYSQL_HOST=db
      - MYSQL_USER=root
      - MYSQL_PASSWORD=rootpassword
      - MYSQL_DATABASE=labdb

  db:
    image: mariadb:10.5
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: labdb
    volumes:
      - db_data:/var/lib/mysql
      - ./src/init.sql:/docker-entrypoint-initdb.d/init.sql

volumes:
  db_data:

```
# Bước 4: Tạo thư mục src/
```
mkdir src
cd src
```
# Bước 6: Tạo file index.php:
```
<?php
session_start();

$mysqli = new mysqli('db', 'root', 'rootpassword', 'labdb');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Chú ý: Lỗi SQL Injection bypass ở đây
    $query = "SELECT id, username, display_name, role, salary, is_admin FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: /');
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}

// Xử lý xem nhân viên
if (isset($_GET['view_employee'])) {
    $employee_id = $mysqli->real_escape_string($_GET['view_employee']);
    $query = "SELECT id, display_name, salary FROM users WHERE id = '$employee_id'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $employee = $result->fetch_assoc();
    } else {
        $employee = null;
    }
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .welcome {
            background: #e0f7fa;
            border-left: 5px solid #00acc1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .welcome h2 {
            margin: 0;
            color: #00796b;
        }
        .content {
            margin: 20px 0;
        }
        form {
            margin: 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #00796b;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #004d40;
        }
        a {
            color: #00796b;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .employee-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .employee-table th, .employee-table td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        .employee-table th {
            background-color: #00796b;
            color: white;
        }
        .employee-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .employee-table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo '<div class="welcome">';
    echo "<h2>Welcome, " . htmlspecialchars($user['display_name']) . "</h2>";
    echo "<p>Role: " . htmlspecialchars($user['role']) . "</p>";
    echo '</div>';

    echo '<div class="content">';

    if ($user['is_admin']) {
        echo "<h3>Employee List:</h3>";
        $query = "SELECT id, display_name, salary FROM users WHERE is_admin = FALSE";
        $result = $mysqli->query($query);
        if ($result->num_rows > 0) {
            echo '<table class="employee-table">
                    <tr>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['display_name']) . '</td>
                        <td>' . htmlspecialchars($row['salary']) . '</td>
                        <td><a href="?view_employee=' . urlencode($row['id']) . '">View Details</a></td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo "No employees found.";
        }
    } elseif (isset($employee)) {
        echo "<h3>Employee Details:</h3>";
        if ($employee) {
            echo "<p>Name: " . htmlspecialchars($employee['display_name']) . "</p>";
            echo "<p>Salary: " . htmlspecialchars($employee['salary']) . "</p>";
        } else {
            echo "Employee not found.";
        }
    } else {
        echo "<p>Salary: " . htmlspecialchars($user['salary']) . "</p>";
    }

    echo '</div>';

    echo '<a href="?logout=true">Logout</a> | <a href="?view_code=true">View Code</a>';
} else {
    if (isset($error_message)) {
        echo '<div class="error">' . htmlspecialchars($error_message) . '</div>';
    }
    echo '<form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
          </form>';
}

if (isset($_GET['view_code']) && isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
    echo '<div class="content">';
    highlight_file(__FILE__);
    echo '</div>';
}

echo '</div>
</body>
</html>';

$mysqli->close();

```
# Bước 7: tạo file init.sql
```
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

```
# Note:
- Lỗi SQL Injection bypass trong đoạn mã đăng nhập của bạn nằm ở cách xử lý truy vấn SQL. Cụ thể, lỗi xảy ra vì cách bạn chèn dữ liệu người dùng vào truy vấn SQL mà không sử dụng các phương pháp bảo mật thích hợp. Điều này cho phép kẻ tấn công chèn các chuỗi đặc biệt vào truy vấn để thay đổi hành vi của nó.
# Đoạn Mã Đăng Nhập Có Lỗi
```
$query = "SELECT id, username, display_name, role, salary, is_admin FROM users WHERE username = '$username' AND password = '$password'";
```
# Lỗi và Lý Do
1. Chèn Trực Tiếp Biến Vào Truy Vấn: Bạn đang chèn trực tiếp các biến **$username và $password** vào truy vấn SQL mà không kiểm tra hoặc làm sạch đầu vào. Điều này tạo điều kiện cho các cuộc tấn công SQL Injection.
Ví dụ: Nếu kẻ tấn công nhập vào **admin' --** trong trường username và bất kỳ giá trị nào trong password, truy vấn sẽ trở thành:
```
SELECT id, username, display_name, role, salary, is_admin 
FROM users 
WHERE username = 'admin' --' AND password = 'password'
```
**--** là ký tự để bình luận phần còn lại của truy vấn, vì vậy phần điều kiện password **= 'password'** bị bỏ qua.
2. SQL Injection Blind: Với lỗi này, một kẻ tấn công có thể truy vấn cơ sở dữ liệu để kiểm tra sự tồn tại của người dùng, liệu câu lệnh SQL có thành công hay không, và thậm chí có thể phát hiện thông tin nhạy cảm khác mà không thấy trực tiếp.
# Cách Khắc Phục
- Để bảo vệ ứng dụng của bạn khỏi SQL Injection, bạn nên sử dụng** prepared statements** và **parameterized queries**. Đây là cách làm đúng để đảm bảo rằng đầu vào người dùng không thể thay đổi cấu trúc của câu lệnh SQL.
# Cập Nhật Đoạn Mã Đăng Nhập
- Dưới đây là cách sửa lỗi SQL Injection bằng cách sử dụng prepared statements:
```
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Chuẩn bị câu lệnh SQL với placeholder
    $stmt = $mysqli->prepare("SELECT id, username, display_name, role, salary, is_admin FROM users WHERE username = ? AND password = ?");
    
    // Liên kết các biến với placeholder
    $stmt->bind_param('ss', $username, $password);
    
    // Thực thi câu lệnh
    $stmt->execute();
    
    // Lấy kết quả
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: /');
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
    
    // Đóng statement
    $stmt->close();
}
```
### Giải Thích
**$mysqli->prepare:** Tạo một prepared statement với các placeholder (?) thay vì chèn giá trị trực tiếp vào truy vấn.

**$stmt->bind_param:**Liên kết các biến với các placeholder trong câu lệnh SQL. Tham số ss cho biết loại của các biến là string.

**$stmt->execute:** Thực thi câu lệnh đã chuẩn bị với các giá trị đã liên kết.

**$stmt->get_result**: Lấy kết quả của truy vấn.
