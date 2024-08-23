<?php
include 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'add') {
    include 'add_employee.php';
} elseif ($action == 'edit') {
    include 'edit_employee.php';
} elseif ($action == 'delete') {
    include 'delete_employee.php';
} elseif ($action == 'view') {
    include 'view_employee.php';
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
        <a href="?action=add">Thêm nhân viên</a>
        <a href="?action=edit">Sửa nhân viên</a>
        <a href="?action=delete">Xóa nhân viên</a>

        <?php if ($action == ''): ?>
            <table>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Họ tên</th>
                    <th>Cấp bậc</th>
                    <th>Chức vụ</th>
                    <th>Lương</th> <!-- Thêm cột lương -->
                    <th>Chi tiết</th>
                </tr>
                <?php while ($employee = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['employee_id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($employee['name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($employee['rank'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($employee['position'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars(number_format($employee['salary'], 2)) ?? ''; ?></td> <!-- Hiển thị lương -->
                        <td><a href="?action=view&employee_id=<?php echo urlencode($employee['employee_id'] ?? ''); ?>">Xem</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

