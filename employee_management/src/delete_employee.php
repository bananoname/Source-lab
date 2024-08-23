<?php
include 'config.php';

$error_message = '';

$employee_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($employee_id) {
    // Xóa nhân viên khỏi database
    $sql = "DELETE FROM employees WHERE employee_id = '$employee_id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php'); // Quay lại trang quản lý nhân viên sau khi xóa thành công
        exit();
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
} else {
    $error_message = "Không tìm thấy nhân viên.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xóa nhân viên</title>
    <link rel="stylesheet" type="text/css" href="css/add-styles.css">
</head>
<body>
    <div class="delete-employee-container">
        <h1>Xóa nhân viên</h1>
        <?php if (empty($error_message)): ?>
            <p>Nhân viên đã được xóa thành công.</p>
        <?php else: ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Thêm nút quay về trang Admin -->
        <a href="admin.php" class="back-button">Quay về trang Admin</a>
    </div>
</body>
</html>

