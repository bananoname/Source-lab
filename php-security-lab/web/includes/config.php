<?php
// config.php
$servername = "db";
$username = "user";
$password = "userpassword";
$dbname = "lab_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
