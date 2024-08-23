<?php
include 'config.php';

$employee_id = $_GET['id'];
$sql = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
    echo "<h1>Xin chào, " . $employee['name'] . "</h1>";
    echo "<p>Lương của bạn: " . $employee['salary'] . "</p>";
} else {
    echo "Không tìm thấy thông tin!";
}
?>
