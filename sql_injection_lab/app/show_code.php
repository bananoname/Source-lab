<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$code = <<<'EOD'
<?php
$search = $_GET['search'];
$query = "SELECT * FROM books WHERE title LIKE '%$search%'";
$result = $pdo->query($query);
?>
EOD;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vulnerable Code</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="code-container">
        <h2>Vulnerable Code</h2>
        <pre><?php echo htmlspecialchars($code); ?></pre>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
