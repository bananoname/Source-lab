# 1. Khởi tạo và Kết nối Cơ sở dữ liệu
```
session_start();
$mysqli = new mysqli('db', 'root', 'rootpassword', 'labdb');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

```
- **session_start();:** Bắt đầu một phiên làm việc mới hoặc tiếp tục phiên hiện tại.

- **$mysqli = new mysqli('db', 'root', 'rootpassword', 'labdb');:** Tạo kết nối với cơ sở dữ liệu MySQL với các thông tin kết nối (hostname, username, password, database).

- **if ($mysqli->connect_error) { die("Connection failed: " . $mysqli->connect_error); }:** Kiểm tra lỗi kết nối và kết thúc script nếu kết nối thất bại.
# 2. Xử lý Đăng xuất
```
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
}

```
**Nếu có tham số logout trong URL, thì:**

- session_unset(); và session_destroy();: Xóa tất cả dữ liệu phiên và hủy phiên hiện tại.
- header('Location: /');: Chuyển hướng người dùng về trang chính.
- exit();: Ngừng thực thi script sau khi chuyển hướng.
# 3. Xử lý Đăng nhập
```
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

```
**Nếu yêu cầu HTTP là POST (người dùng gửi dữ liệu từ form):**
- **real_escape_string** được sử dụng để thoát các ký tự đặc biệt từ đầu vào của người dùng, nhưng đây vẫn là một lỗi SQL Injection vì không sử dụng prepared statements.

- **SELECT** truy vấn để xác thực người dùng dựa trên tên đăng nhập và mật khẩu. Nếu thành công, lưu thông tin người dùng vào biến phiên và chuyển hướng về trang chính. Nếu thất bại, hiển thị thông báo lỗi.
# 4. Xử lý Xem Thông tin Nhân viên
```
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
```
- Nếu tham số **view_employee** có trong URL, thực hiện truy vấn để lấy thông tin của nhân viên theo **id**. Nếu tìm thấy, lưu thông tin vào biến $employee, nếu không tìm thấy thì gán **$employee là null.**

# 5. Hiển thị HTML
- Phần đầu trang:
```
echo '<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* CSS Styles here */
    </style>
</head>
<body>
    <div class="container">';
```
- Hiển thị tiêu đề trang và các kiểu dáng CSS cơ bản cho giao diện người dùng.
- Hiển thị Nội dung Dựa trên Phiên Đăng Nhập
```
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
```
Nếu người dùng đã đăng nhập:
- Hiển thị thông tin chào mừng và thông tin người dùng.
- Nếu là quản trị viên, hiển thị danh sách nhân viên.
- Nếu không phải quản trị viên và có thông tin nhân viên, hiển thị thông tin nhân viên.
- Cung cấp liên kết để đăng xuất hoặc xem mã nguồn (nếu là quản trị viên).
- Nếu người dùng chưa đăng nhập, hiển thị form đăng nhập và thông báo lỗi (nếu có).
### Hiển thị Mã nguồn (Dành cho Quản trị viên)
```
if (isset($_GET['view_code']) && isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
    echo '<div class="content">';
    highlight_file(__FILE__);
    echo '</div>';
}

```
- Nếu tham số view_code có trong URL và người dùng là quản trị viên, hiển thị mã nguồn của file PHP hiện tại.

- Phần Cuối Trang
```
echo '    </div>
    <footer>
        <p>&copy; 2024 Employee Management System. All rights reserved.</p>
    </footer>
</body>
</html>';

$mysqli->close();

```
# Vấn đề Bảo mật

- SQL Injection: Đoạn mã hiện tại dễ bị tấn công SQL Injection vì sử dụng trực tiếp đầu vào người dùng trong câu truy vấn SQL mà không sử dụng prepared statements. Sử dụng prepared statements sẽ giúp bảo vệ ứng dụng khỏi các cuộc tấn công này.
- Lưu trữ Mật khẩu: Mật khẩu nên được mã hóa trước khi lưu vào cơ sở dữ liệu, chẳng hạn như sử dụng bcrypt. Hiện tại, mật khẩu được lưu trữ và so sánh dưới dạng văn bản thuần, điều này không an toàn.
- Thông tin nhạy cảm: Hiển thị mã nguồn PHP có thể tiết lộ thông tin nhạy cảm hoặc lỗi lập trình, đặc biệt là trong môi trường sản xuất.
- Hy vọng phân tích này giúp bạn hiểu rõ hơn về đoạn mã PHP và các vấn đề bảo mật liên quan.
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
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .welcome {
            background: #e0f7fa;
            border-left: 5px solid #00acc1;
            padding: 10px;
            margin-bottom: 20px;
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
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #00796b;
            color: #fff;
            border: none;
            padding: 10px 20px;
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
        echo "<h3>Employee Salaries:</h3>";
        $query = "SELECT display_name, salary FROM users WHERE is_admin = FALSE";
        $result = $mysqli->query($query);
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['display_name']) . ": " . htmlspecialchars($row['salary']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "No employees found.";
        }
    } else {
        echo "<p>Salary: " . htmlspecialchars($user['salary']) . "</p>";
    }
    echo '</div>';

    // Thêm liên kết đăng xuất và xem mã nguồn
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
