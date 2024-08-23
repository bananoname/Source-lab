<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid employee ID.");
}

$employee_id = intval($_GET['id']);

$sql = "SELECT e.*, r.rank_name, p.position_name 
        FROM employees e
        JOIN ranks r ON e.rank_id = r.id
        JOIN positions p ON e.position_id = p.id
        WHERE e.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Employee not found.");
}

$employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết nhân viên</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="admin-container">
        <img src="images/logo.png" alt="Logo" class="logo">
        <h1>Chi tiết nhân viên</h1>
        <p><strong>Mã nhân viên:</strong> <?php echo htmlspecialchars($employee['employee_id']); ?></p>
        <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($employee['name']); ?></p>
        <p><strong>Cấp bậc:</strong> <?php echo htmlspecialchars($employee['rank_name']); ?></p>
        <p><strong>Chức vụ:</strong> <?php echo htmlspecialchars($employee['position_name']); ?></p>
        <p><strong>Lương:</strong> <?php echo htmlspecialchars($employee['salary']); ?></p>
        <p><strong>Mật khẩu:</strong> <?php echo htmlspecialchars($employee['password']); ?></p>
        <a href="admin.php">Quay lại trang quản lý nhân viên</a>
    </div>
</body>
</html>

