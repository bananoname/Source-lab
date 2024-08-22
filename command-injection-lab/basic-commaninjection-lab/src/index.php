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
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function openModal() {
            document.getElementById("codeModal").style.display = "block";
            return false;
        }

        function closeModal() {
            document.getElementById("codeModal").style.display = "none";
        }
    </script>
</head>
<body>';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['view_code'])) {
    $cmd = $_POST['cmd'];

    // Directly execute the user-provided command
    $output = shell_exec($cmd);

    // Display the output
    echo "<pre>$output</pre>";
}

// Form input for commands and view code button
echo '<h1>Enter a command:</h1>
<form method="post">
    <input type="text" name="cmd" placeholder="Type your command here" />
    <input type="submit" value="Execute" />
</form>
<form onsubmit="return openModal();">
    <input type="submit" value="View Code" />
</form>';

// Modal for displaying source code
echo '<div id="codeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Source Code:</h2>
        <pre>' . htmlspecialchars(file_get_contents(__FILE__)) . '</pre>
    </div>
</div>';

// Instructions and Security Recommendations
echo '<div class="note">
    <h2>Demo Instructions:</h2>
    <p>To demonstrate a command injection attack:</p>
    <ul>
        <li>Try entering a simple command like <code>ls</code> to list files.</li>
        <li>For more advanced attacks, try injecting additional commands like <code>ls; whoami</code>.</li>
        <li>Note: This is a basic example. In real-world scenarios, proper input validation is crucial to avoid security risks.</li>
    </ul>
    <h2>Security Recommendations:</h2>
    <ul>
        <li>Use a whitelist of allowed commands instead of directly executing user inputs.</li>
        <li>Avoid executing user inputs as system commands.</li>
        <li>Consider using safer alternatives to handle user inputs.</li>
    </ul>
</div>';

// Footer
echo '<footer style="margin-top: 20px; font-size: 14px; color: #666;">
    <p>&copy; 2024 Command Injection Demo. All rights reserved.</p>
</footer>
</body>
</html>';
?>

