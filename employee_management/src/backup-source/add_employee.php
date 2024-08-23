<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $position = $_POST['position'];

    $sql = "INSERT INTO employees (employee_id, name, rank, position) VALUES ('$employee_id', '$name', '$rank', '$position')";
    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<form method="POST">
    <label for="employee_id">Mã nhân viên:</label>
    <input type="text" name="employee_id" required><br>
    <label for="name">Họ tên:</label>
    <input type="text" name="name" required><br>
    <label for="rank">Cấp bậc:</label>
    <input type="text" name="rank" required><br>
    <label for="position">Chức vụ:</label>
    <input type="text" name="position" required><br>
    <input type="submit" value="Thêm nhân viên">
</form>
