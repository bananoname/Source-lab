<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'];
    // Chạy lệnh ping để kiểm tra host
    $output = shell_exec("ping -c 4 " . $host);
    echo "<pre>$output</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Checker</title>
</head>
<body>
    <h1>Host Checker</h1>
    <form method="POST" action="">
        <label for="host">Nhập tên miền hoặc IP:</label>
        <input type="text" id="host" name="host" required>
        <button type="submit">Kiểm tra</button>
    </form>
</body>
</html>

