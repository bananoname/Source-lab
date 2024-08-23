<?php
include 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'edit') {
    include 'edit_employee.php';
} elseif ($action == 'delete') {
    include 'delete_employee.php';
} else {
    // Hiển thị danh sách nhân viên
    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="admin-container">
        <img src="images/logo.png" alt="Logo" class="logo">
        <h1>Quản lý nhân viên</h1>
        <a href="add_employee.php">Thêm nhân viên</a> <!-- Liên kết tới trang thêm nhân viên -->
        <a href="edit_employee.php">Sửa nhân viên</a>
        <a href="delete_employee.php">Xóa nhân viên</a>

        <?php if ($action == ''): ?>
            <table>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Họ tên</th>
                    <th>Cấp bậc</th>
                    <th>Chức vụ</th>
                    <th>Lương</th>
                </tr>
                <?php while ($employee = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['employee_id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($employee['name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($employee['rank'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($employee['position'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars(number_format($employee['salary'], 2)) ?? ''; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

