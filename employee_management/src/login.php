<?php
include 'config.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];

    // Truy vấn SQL với khả năng bị SQL Injection
    $sql = "SELECT * FROM employees WHERE employee_id = '$employee_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        if ($employee['role'] == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: employee.php?id=' . $employee['employee_id']);
        }
    } else {
        $error_message = "Sai thông tin đăng nhập!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập quản lý lương</title>
    <link rel="stylesheet" type="text/css" href="css/login-styles.css">
</head>
<body>
    <div class="login-container">
        <img src="images/logo.png" alt="Logo" class="logo">
        <h1>Đăng nhập quản lý lương</h1>
        <form method="POST">
            <label for="employee_id">Mã nhân viên:</label>
            <input type="text" name="employee_id" required><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Đăng nhập">
        </form>

        <!-- Thêm nút "Xem Code SQL Injection" -->
        <a href="?view_code=1">Xem Code SQL Injection</a>

        <?php if (isset($_GET['view_code']) && $_GET['view_code'] == '1'): ?>
            <h2>Đoạn Code SQL Injection</h2>
            <pre>
&lt;?php
include 'config.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];

    // Truy vấn SQL với khả năng bị SQL Injection
    $sql = "SELECT * FROM employees WHERE employee_id = '$employee_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        if ($employee['role'] == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: employee.php?id=' . $employee['employee_id']);
        }
    } else {
        $error_message = "Sai thông tin đăng nhập!";
    }
}
?&gt;
            </pre>
        <?php endif; ?>
    </div>

    <?php if (!empty($error_message)): ?>
        <script>
            alert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>
</body>
</html>
