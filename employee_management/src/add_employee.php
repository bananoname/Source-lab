<?php
include 'config.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    // Thực hiện truy vấn SQL với khả năng bị SQL Injection
    $sql = "INSERT INTO employees (employee_id, name, rank, position, salary) VALUES ('$employee_id', '$name', '$rank', '$position', '$salary')";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php'); // Quay lại trang quản lý nhân viên sau khi thêm thành công
        exit();
    } else {
        $error_message = "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm nhân viên</title>
    <link rel="stylesheet" type="text/css" href="css/add-styles.css">
</head>
<body>
    <div class="add-employee-container">
        <h1>Thêm nhân viên mới</h1>
        <form method="POST">
            <label for="employee_id">Mã nhân viên:</label>
            <input type="text" name="employee_id" required><br>

            <label for="name">Họ tên:</label>
            <input type="text" name="name" required><br>

            <label for="rank">Cấp bậc:</label>
            <input type="text" name="rank" required><br>

            <label for="position">Chức vụ:</label>
            <input type="text" name="position" required><br>

            <label for="salary">Lương:</label>
            <input type="text" name="salary" required><br>

            <input type="submit" value="Thêm nhân viên">
        </form>

        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Thêm nút quay về trang Admin -->
        <a href="admin.php" class="back-button">Quay về trang Admin</a>
    </div>
</body>
</html>

