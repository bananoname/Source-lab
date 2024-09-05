<?php
// Kết nối tới cơ sở dữ liệu MySQL
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "demo_login";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Nhận giá trị từ form đăng nhập
$user = isset($_POST['username']) ? $_POST['username'] : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';

// Câu truy vấn có thể bị SQL Injection
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";

// Thực hiện truy vấn và kiểm tra lỗi
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        // Nếu tìm thấy user
        echo "<h2>Login successful!</h2>";
        echo "<p>Welcome, " . htmlspecialchars($user) . "</p>";
    } else {
        // Nếu không tìm thấy user
        echo "<h2>Invalid username or password</h2>";
    }
} else {
    // Hiển thị thông báo lỗi SQL Injection
    echo "<h2>SQL Injection Syntax Error:</h2>";
    echo "<p>An error occurred: " . htmlspecialchars($conn->error) . "</p>";
}

// Đóng kết nối
$conn->close();
?>

