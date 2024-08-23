<?php
include 'config.php';

$error_message = ''; // Biến để lưu thông báo lỗi
$success_message = ''; // Biến để lưu thông báo thành công

// Kiểm tra nếu có form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'] ?? ''; // Sử dụng toán tử null coalescing
    $name = $_POST['name'] ?? ''; // Sử dụng toán tử null coalescing
    $rank = $_POST['rank'] ?? ''; // Sử dụng toán tử null coalescing
    $position = $_POST['position'] ?? ''; // Sử dụng toán tử null coalescing
    $salary = $_POST['salary'] ?? ''; // Sử dụng toán tử null coalescing

    // Cập nhật thông tin nhân viên trong cơ sở dữ liệu
    $sql = "UPDATE employees SET name = '$name', rank = '$rank', position = '$position', salary = '$salary' WHERE employee_id = '$employee_id'";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Cập nhật thông tin nhân viên thành công.";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}

// Lấy danh sách nhân viên từ cơ sở dữ liệu
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý nhân viên - Sửa thông tin</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="admin-container">
        <img src="images/logo.png" alt="Logo" class="logo">
        <h1>Quản lý nhân viên - Sửa thông tin</h1>

        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php elseif (!empty($success_message)): ?>
            <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <!-- Form để hiển thị và sửa thông tin nhân viên -->
        <form method="POST">
            <table>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Họ tên</th>
                    <th>Cấp bậc</th>
                    <th>Chức vụ</th>
                    <th>Lương</th>
                    <th>Thao tác</th>
                </tr>
                <?php while ($employee = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['employee_id'] ?? ''); ?></td>
                        <td><input type="text" name="name" value="<?php echo htmlspecialchars($employee['name'] ?? ''); ?>" required></td>
                        <td><input type="text" name="rank" value="<?php echo htmlspecialchars($employee['rank'] ?? ''); ?>" required></td>
                        <td><input type="text" name="position" value="<?php echo htmlspecialchars($employee['position'] ?? ''); ?>" required></td>
                        <td><input type="text" name="salary" value="<?php echo htmlspecialchars($employee['salary'] ?? ''); ?>" required></td>
                        <td>
                            <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee['employee_id'] ?? ''); ?>">
                            <input type="submit" value="Lưu">
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </form>

        <!-- Nút quay về trang Admin -->
        <a href="admin.php" class="back-button">Quay về trang Admin</a>
    </div>
</body>
</html>

