<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];

    // Cảnh báo: Lỗ hổng path traversal có thể xảy ra nếu `employee_id` không được kiểm tra cẩn thận
    $sql = "DELETE FROM employees WHERE employee_id = '$employee_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Xóa nhân viên thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<form method="POST">
    <label for="employee_id">Mã nhân viên:</label>
    <input type="text" name="employee_id" required><br>
    <input type="submit" value="Xóa nhân viên">
</form>
