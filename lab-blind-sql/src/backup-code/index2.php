<?php
session_start();

$mysqli = new mysqli('db', 'root', 'rootpassword', 'labdb');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Chú ý: Lỗi SQL Injection bypass ở đây
    $query = "SELECT id, username, display_name, role, salary, is_admin FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: /');
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}

// Xử lý xem nhân viên
if (isset($_GET['view_employee'])) {
    $employee_id = $mysqli->real_escape_string($_GET['view_employee']);
    $query = "SELECT id, display_name, salary FROM users WHERE id = '$employee_id'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $employee = $result->fetch_assoc();
    } else {
        $employee = null;
    }
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .welcome {
            background: #e0f7fa;
            border-left: 5px solid #00acc1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .welcome h2 {
            margin: 0;
            color: #00796b;
        }
        .content {
            margin: 20px 0;
        }
        form {
            margin: 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #00796b;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #004d40;
        }
        a {
            color: #00796b;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .employee-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .employee-table th, .employee-table td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        .employee-table th {
            background-color: #00796b;
            color: white;
        }
        .employee-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .employee-table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo '<div class="welcome">';
    echo "<h2>Welcome, " . htmlspecialchars($user['display_name']) . "</h2>";
    echo "<p>Role: " . htmlspecialchars($user['role']) . "</p>";
    echo '</div>';

    echo '<div class="content">';

    if ($user['is_admin']) {
        echo "<h3>Employee List:</h3>";
        $query = "SELECT id, display_name, salary FROM users WHERE is_admin = FALSE";
        $result = $mysqli->query($query);
        if ($result->num_rows > 0) {
            echo '<table class="employee-table">
                    <tr>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['display_name']) . '</td>
                        <td>' . htmlspecialchars($row['salary']) . '</td>
                        <td><a href="?view_employee=' . urlencode($row['id']) . '">View Details</a></td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo "No employees found.";
        }
    } elseif (isset($employee)) {
        echo "<h3>Employee Details:</h3>";
        if ($employee) {
            echo "<p>Name: " . htmlspecialchars($employee['display_name']) . "</p>";
            echo "<p>Salary: " . htmlspecialchars($employee['salary']) . "</p>";
        } else {
            echo "Employee not found.";
        }
    } else {
        echo "<p>Salary: " . htmlspecialchars($user['salary']) . "</p>";
    }

    echo '</div>';

    echo '<a href="?logout=true">Logout</a> | <a href="?view_code=true">View Code</a>';
} else {
    if (isset($error_message)) {
        echo '<div class="error">' . htmlspecialchars($error_message) . '</div>';
    }
    echo '<form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
          </form>';
}

if (isset($_GET['view_code']) && isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
    echo '<div class="content">';
    highlight_file(__FILE__);
    echo '</div>';
}

echo '</div>
</body>
</html>';

$mysqli->close();

root@4aad2b2be559:/var/www/html#
root@4aad2b2be559:/var/www/html# ls
index.php  index.php.bk  index.php.bk1  init.sql
root@4aad2b2be559:/var/www/html# cat index.php.bk
<?php
session_start();

$mysqli = new mysqli('db', 'root', 'rootpassword', 'labdb');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $query = "SELECT id, username, display_name, role, salary, is_admin FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: /');
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .welcome {
            background: #e0f7fa;
            border-left: 5px solid #00acc1;
            padding: 10px;
            margin-bottom: 20px;
        }
        .welcome h2 {
            margin: 0;
            color: #00796b;
        }
        .content {
            margin: 20px 0;
        }
        form {
            margin: 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #00796b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #004d40;
        }
        a {
            color: #00796b;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo '<div class="welcome">';
    echo "<h2>Welcome, " . htmlspecialchars($user['display_name']) . "</h2>";
    echo "<p>Role: " . htmlspecialchars($user['role']) . "</p>";
    echo '</div>';

    echo '<div class="content">';
    if ($user['is_admin']) {
        echo "<h3>Employee Salaries:</h3>";
        $query = "SELECT display_name, salary FROM users WHERE is_admin = FALSE";
        $result = $mysqli->query($query);
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['display_name']) . ": " . htmlspecialchars($row['salary']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "No employees found.";
        }
    } else {
        echo "<p>Salary: " . htmlspecialchars($user['salary']) . "</p>";
    }
    echo '</div>';

    // Thêm liên kết đăng xuất và xem mã nguồn
    echo '<a href="?logout=true">Logout</a> | <a href="?view_code=true">View Code</a>';
} else {
    if (isset($error_message)) {
        echo '<div class="error">' . htmlspecialchars($error_message) . '</div>';
    }
    echo '<form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
          </form>';
}

if (isset($_GET['view_code']) && isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
    echo '<div class="content">';
    highlight_file(__FILE__);
    echo '</div>';
}

echo '</div>
</body>
</html>';

$mysqli->close();

root@4aad2b2be559:/var/www/html# ls
index.php  index.php.bk  index.php.bk1  init.sql
root@4aad2b2be559:/var/www/html# nano index.php^C
root@4aad2b2be559:/var/www/html# cat index.php.bk1
<?php
session_start();

$mysqli = new mysqli('db', 'root', 'rootpassword', 'labdb');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $query = "SELECT id, username, display_name, role, salary, is_admin FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: /');
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}

// Xử lý xem chi tiết nhân viên
if (isset($_GET['view']) && isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
    $id = $mysqli->real_escape_string($_GET['view']);
    $query = "SELECT id, username, display_name, role, salary FROM users WHERE id = '$id'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $employee = $result->fetch_assoc();
        $employee_details = "<h3>Employee Details</h3>
                             <p>Username: " . htmlspecialchars($employee['username']) . "</p>
                             <p>Display Name: " . htmlspecialchars($employee['display_name']) . "</p>
                             <p>Role: " . htmlspecialchars($employee['role']) . "</p>
                             <p>Salary: " . htmlspecialchars($employee['salary']) . "</p>";
    } else {
        $employee_details = "<p>Employee not found.</p>";
    }
} else {
    $employee_details = "";
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .welcome {
            background: #e0f7fa;
            border-left: 5px solid #00acc1;
            padding: 10px;
            margin-bottom: 20px;
        }
        .welcome h2 {
            margin: 0;
            color: #00796b;
        }
        .content {
            margin: 20px 0;
        }
        form {
            margin: 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #00796b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #004d40;
        }
        a {
            color: #00796b;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo '<div class="welcome">';
    echo "<h2>Welcome, " . htmlspecialchars($user['display_name']) . "</h2>";
    echo "<p>Role: " . htmlspecialchars($user['role']) . "</p>";
    echo '</div>';

    echo '<div class="content">';
    if ($user['is_admin']) {
        echo "<h3>Employee List:</h3>";
        $query = "SELECT id, display_name, salary FROM users WHERE is_admin = FALSE";
        $result = $mysqli->query($query);
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['display_name']) . "</td>
                        <td>" . htmlspecialchars($row['salary']) . "</td>
                        <td><a href='?view=" . htmlspecialchars($row['id']) . "'>View Details</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No employees found.";
        }
        echo $employee_details;
    } else {
        echo "<p>Salary: " . htmlspecialchars($user['salary']) . "</p>";
    }
    echo '</div>';

    // Thêm liên kết đăng xuất và xem mã nguồn
    echo '<a href="?logout=true">Logout</a> | <a href="?view_code=true">View Code</a>';
} else {
    if (isset($error_message)) {
        echo '<div class="error">' . htmlspecialchars($error_message) . '</div>';
    }
    echo '<form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
          </form>';
}

if (isset($_GET['view_code']) && isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
    echo '<div class="content">';
    highlight_file(__FILE__);
    echo '</div>';
}

echo '</div>
</body>
</html>';

$mysqli->close();
