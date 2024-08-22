<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$host = 'db';
$dbname = 'books_db';
$username = 'root';
$password = 'rootpassword';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $search = $_GET['search'] ?? '';
    $result = null;

    if (!empty($search)) {
        // Sử dụng câu lệnh chuẩn bị để tránh SQL Injection
        $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE :search");
        $stmt->execute(['search' => "%$search%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="book-container">
        <h2>Book Management</h2>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search books..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($search)): ?>
            <ul>
                <?php if ($result): ?>
                    <?php foreach ($result as $row): ?>
                        <li><?php echo htmlspecialchars($row['title']); ?> by <?php echo htmlspecialchars($row['author']); ?> (<?php echo htmlspecialchars($row['year']); ?>)</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No results found.</li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        <a href="show_code.php">View Vulnerable Code</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
