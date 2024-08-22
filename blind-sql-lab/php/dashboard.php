<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit();
}

$mysqli = new mysqli("db", "user", "password", "employee_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

// SQL query dễ bị lỗi blind SQL injection
$sql = "SELECT * FROM employees WHERE user_id = $user_id";
$result = $mysqli->query($sql);

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Employee Dashboard</h2>
        <a href="logout.php" class="logout">Logout</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Salary</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['position']); ?></td>
                <td><?php echo htmlspecialchars($row['salary']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

