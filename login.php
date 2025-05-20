<?php
session_start();
include_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check username in enrollmentForm table
    $stmt = $pdo->prepare("SELECT * FROM enrollmentForm WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login success
        $_SESSION['user_id'] = $user['id'] ?? $user['enrollmentId'] ?? null;
        $_SESSION['username'] = $user['username'];
        header("Location: studentportal.php?id=" . $_SESSION['user_id']);
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background: #EDEDF9;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .form-container {
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,78,0.08);
            border-radius: 14px;
            padding: 40px 32px 32px 32px;
            margin: 60px auto;
            max-width: 350px;
            border: 2px solid #1873D3;
        }
        h1 {
            color: #020082;
            margin-bottom: 24px;
            font-size: 2em;
            text-align: center;
            font-weight: bold;
        }
        label {
            color: #020082;
            font-weight: 500;
            margin-top: 18px;
            margin-bottom: 6px;
            display: block;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 0 0 18px 0;
            border: 1.5px solid #1873D3;
            border-radius: 6px;
            background: #EDEDF9;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.2s, background 0.2s;
            display: block;
            color: #00004E;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #020082;
            background: #fff;
            outline: none;
        }
        button[type="submit"] {
            width: 100%;
            background: #1873D3;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #020082;
        }
        .register-link {
            margin-top: 18px;
            text-align: center;
        }
        .register-link a {
            color: #1873D3;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
            color: #020082;
        }
        .error-message {
            color: #e53935;
            margin-bottom: 16px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Login</h1>
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required autofocus>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        No account? <a href="enroll.php">Register</a>
    </div>
</div>
</body>
</html>