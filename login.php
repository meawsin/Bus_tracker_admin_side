<?php
session_start();
include 'databaseconnect.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the username exists in the database
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Direct comparison of the password (no hashing)
        if ($password == $row['password']) {
            $_SESSION['adminName'] = $row['username'];
            header("Location: index.php");
            exit;
        } else {
            $errorMessage = "Invalid username or password";
        }
    } else {
        $errorMessage = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo i {
            font-size: 50px;
            color: #16501d;
        }

        h1 {
            text-align: center;
            color: #16501d;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #16501d;
            border-radius: 10px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #006400;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #16501d;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #006400;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #16501d;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="fas fa-bus"></i> <!-- FontAwesome bus icon -->
        </div>
        <h1>Login</h1>
        <form method="post" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>

            <?php if ($errorMessage): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
        <div class="footer">
            <p>Powered by Bus Tracker System</p>
        </div>
    </div>
</body>
</html>
