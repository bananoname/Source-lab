<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/config.php';
session_start(); // Bắt đầu phiên làm việc

// Tạo mã thông báo CSRF nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
$userDetails = '';

function getUserDetails($conn, $employee_id) {
    $query = "SELECT * FROM employees WHERE employee_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return "<p class='error'>Lỗi khi truy vấn dữ liệu: " . htmlspecialchars($conn->error) . "</p>";
    }

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $details = "<div class='user-details'>";
        $details .= "<p><strong>Employee ID:</strong> " . htmlspecialchars($user['employee_id']) . "</p>";
        $details .= "<p><strong>Employee Code:</strong> " . htmlspecialchars($user['employee_code']) . "</p>";
        $details .= "<p><strong>Full Name:</strong> " . htmlspecialchars($user['full_name']) . "</p>";
        $details .= "<p><strong>Position:</strong> " . htmlspecialchars($user['position']) . "</p>";
        $details .= "<p><strong>Username:</strong> " . htmlspecialchars($user['username']) . "</p>";
        $details .= "</div>";
        return $details;
    } else {
        return "<p class='info'>Không tìm thấy thông tin người dùng.</p>";
    }
}

// Xử lý các yêu cầu GET
if (isset($_GET['employee_id'])) {
    $employee_id = intval($_GET['employee_id']);
    $userDetails = getUserDetails($conn, $employee_id);
} else {
    $message = "<p class='error'>ID người dùng không được cung cấp.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Người Dùng</title>
    <link rel="stylesheet" href="css/viewuserdetails-style.css">
</head>
<body>
    <div class="container">
        <h1>Chi Tiết Người Dùng</h1>
        <div class="message-container">
            <?php echo $message; ?>
            <?php echo $userDetails; ?>
        </div>
        <a href="viewuser.php" class="back-button">Trở Lại Danh Sách Người Dùng</a>
    </div>
</body>
</html>

