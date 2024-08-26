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

// Hàm hiển thị tất cả người dùng
function viewAllUsers($conn) {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin') {
        $query = "SELECT employee_id, employee_code, full_name, position, username FROM employees";
        $result = $conn->query($query);

        if ($result === false) {
            // Xử lý lỗi truy vấn SQL
            return "<p class='error'>Lỗi khi truy vấn dữ liệu: " . htmlspecialchars($conn->error) . "</p>";
        }

        if ($result->num_rows > 0) {
            $users = "<table class='user-table'>";
            $users .= "<thead><tr><th>Employee ID</th><th>Employee Code</th><th>Full Name</th><th>Position</th><th>Username</th><th>Chi Tiết</th></tr></thead>";
            $users .= "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $users .= "<tr><td>" . htmlspecialchars($row['employee_id']) . "</td>";
                $users .= "<td>" . htmlspecialchars($row['employee_code']) . "</td>";
                $users .= "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                $users .= "<td>" . htmlspecialchars($row['position']) . "</td>";
                $users .= "<td>" . htmlspecialchars($row['username']) . "</td>";
                $users .= "<td><a href='viewuserdetails.php?employee_id=" . urlencode($row['employee_id']) . "' class='detail-link'>Xem Chi Tiết</a></td></tr>";
            }
            $users .= "</tbody></table>";
            return "<p class='info'>Danh sách người dùng:</p>" . $users;
        } else {
            return "<p class='info'>Không có người dùng nào.</p>";
        }
    } else {
        return "<p class='error'>Bạn không có quyền xem danh sách người dùng.</p>";
    }
}

// Xử lý các yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xác thực mã thông báo CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<p class='error'>Yêu cầu không hợp lệ.</p>";
    } else {
        if (isset($_POST['view_all_users'])) {
            $message = viewAllUsers($conn);
        } elseif (isset($_POST['back'])) {
            // Xử lý quay lại trang trước
            header("Location: login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Người Dùng</title>
    <link rel="stylesheet" href="css/viewuser-style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin'): ?>
            <h1>Danh Sách Người Dùng</h1>
            <!-- Các nút chức năng bổ sung -->
            <form method="post" action="">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button type="submit" name="view_all_users" class="view-all-users-button">Xem Tất Cả Người Dùng</button>
                <button type="submit" name="back" class="back-button">Trở Lại</button>
            </form>
            <!-- Hiển thị thông báo -->
            <div class="message-container">
                <?php echo $message; ?>
            </div>
        <?php else: ?>
            <p class='error'>Bạn cần đăng nhập với quyền admin để truy cập vào trang này.</p>
            <a href="login.php" class="back-button">Trở Lại Đăng Nhập</a>
        <?php endif; ?>
    </div>
</body>
</html>

