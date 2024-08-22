<?php
// Header
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Injection Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
        .note {
            margin-top: 20px;
            font-size: 14px;
            color: #ff5722;
            border: 1px solid #ff5722;
            padding: 10px;
        }
    </style>
</head>
<body>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cmd = $_POST['cmd'];

    // Define allowed commands and their corresponding shell commands
    $allowed_commands = [
        'list' => 'ls',
        'current_dir' => 'pwd',
        'view_passwd' => 'cat /etc/passwd',
    ];

    // Check if the command is allowed
    if (array_key_exists($cmd, $allowed_commands)) {
        // Construct the shell command with ${IFS} and execute it
        $command = $allowed_commands[$cmd];

        // Use escapeshellcmd to prevent injection
        $output = shell_exec(escapeshellcmd($command));

        // Display the output
        echo "<pre>$output</pre>";
    } else {
        echo "<p style='color: red;'>Invalid Command!</p>";
    }
}

// Form input for commands
echo '<h1>Enter a command:</h1>
<form method="post">
    <input type="text" name="cmd" placeholder="Type your command here" />
    <input type="submit" value="Execute" />
</form>';

// Instructions and Security Recommendations
echo '<div class="note">
    <h2>Demo Instructions:</h2>
    <p>To demonstrate a command injection attack:</p>
    <ul>
        <li>Try entering the following command to list files in the current directory: <code>list</code></li>
        <li>For viewing `/etc/passwd`, enter: <code>view_passwd</code></li>
        <li>Note: This is a basic example. In a real-world scenario, attackers might use various techniques to bypass filters.</li>
    </ul>
    <h2>Security Recommendations:</h2>
    <ul>
        <li>Use a whitelist of allowed commands instead of filtering characters.</li>
        <li>Avoid executing user inputs directly as system commands.</li>
        <li>Consider using safer alternatives like PHP functions or libraries that do not require command execution.</li>
    </ul>
</div>';

// Footer
echo '<footer style="margin-top: 20px; font-size: 14px; color: #666;">
    <p>&copy; 2024 Command Injection Demo. All rights reserved.</p>
</footer>
</body>
</html>';
?>

root@88b788083934:/var/www/html# ls
index.php  index.php.bk2  index.php.php
root@88b788083934:/var/www/html# cat index.php
<?php
// Header
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Injection Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
        .note {
            margin-top: 20px;
            font-size: 14px;
            color: #ff5722;
            border: 1px solid #ff5722;
            padding: 10px;
        }
    </style>
</head>
<body>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cmd = $_POST['cmd'];

    // Define allowed commands and their corresponding shell commands
    $allowed_commands = [
        'list' => 'ls',
        'current_dir' => 'pwd',
        'view_passwd' => 'cat /etc/passwd',
    ];

    // Check if the command is allowed
    if (array_key_exists($cmd, $allowed_commands)) {
        // Construct the shell command with ${IFS} and execute it
        $command = $allowed_commands[$cmd];

        // Use escapeshellcmd to prevent injection
        $output = shell_exec(escapeshellcmd($command));

        // Display the output
        echo "<pre>$output</pre>";
    } else {
        echo "<p style='color: red;'>Invalid Command!</p>";
    }
}

// Form input for commands
echo '<h1>Enter a command:</h1>
<form method="post">
    <input type="text" name="cmd" placeholder="Type your command here" />
    <input type="submit" value="Execute" />
</form>';

// Instructions and Security Recommendations
echo '<div class="note">
    <h2>Demo Instructions:</h2>
    <p>To demonstrate a command injection attack:</p>
    <ul>
        <li>Try entering the following command to list files in the current directory: <code>list</code></li>
        <li>For viewing `/etc/passwd`, enter: <code>view_passwd</code></li>
        <li>Note: This is a basic example. In a real-world scenario, attackers might use various techniques to bypass filters.</li>
    </ul>
    <h2>Security Recommendations:</h2>
    <ul>
        <li>Use a whitelist of allowed commands instead of filtering characters.</li>
        <li>Avoid executing user inputs directly as system commands.</li>
        <li>Consider using safer alternatives like PHP functions or libraries that do not require command execution.</li>
    </ul>
</div>';

// Footer
echo '<footer style="margin-top: 20px; font-size: 14px; color: #666;">
    <p>&copy; 2024 Command Injection Demo. All rights reserved.</p>
</footer>
</body>
</html>';
?>
