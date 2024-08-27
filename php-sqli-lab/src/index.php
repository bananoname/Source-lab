<?php
$servername = "db";
$username = "user";
$password = "password";
$dbname = "testdb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ truy vấn SQL
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection Lab</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .search { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SQL Injection Lab</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Tìm kiếm người dùng" value="<?php echo htmlspecialchars($search); ?>" class="search"/>
            <button type="submit">Tìm kiếm</button>
        </form>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có kết quả nào.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
