<?php
session_start();
include_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($username && $password && $fullName && $email) {
        if ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } else {
            // Check if username exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = "Username already exists.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password, fullName, email) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$username, $hash, $fullName, $email])) {
                    $success = "Registration successful! You can now <a href='userlogin.php'>login</a>.";
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Register</title>
    <style>
        body {
            background: #DEF2F1;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .form-container {
            background: #FEFFFF;
            box-shadow: 0 4px 24px rgba(42,122,120,0.08);
            border-radius: 12px;
            padding: 40px 32px 32px 32px;
            margin: 60px auto;
            max-width: 350px;
        }
        h1 {
            color: #2B7A78;
            margin-bottom: 24px;
            font-size: 2em;
            text-align: center;
        }
        label {
            color: #2B7A78;
            font-weight: 500;
            margin-top: 18px;
            margin-bottom: 6px;
            display: block;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 0 0 18px 0;
            border: 1.5px solid #3AAFA9;
            border-radius: 6px;
            background: #DEF2F1;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.2s, background 0.2s;
            display: block;
        }
        input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus {
            border-color: #2B7A78;
            background: #FEFFFF;
            outline: none;
        }
        button[type="submit"] {
            width: 100%;
            background: #2B7A78;
            color: #FEFFFF;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #17252A;
        }
        .success-message {
            color: #22c55e;
            margin-bottom: 16px;
            text-align: center;
            font-weight: 500;
        }
        .error-message {
            color: #f87171;
            margin-bottom: 16px;
            text-align: center;
            font-weight: 500;
        }
        .login-link {
            margin-top: 18px;
            text-align: center;
        }
        .login-link a {
            color: #3AAFA9;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>User Register</h1>
    <?php if ($error): ?><div class="error-message"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
    <form method="POST">
        <label for="fullName">Full Name</label>
        <input type="text" name="fullName" id="fullName" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <button type="submit">Register</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="userlogin.php">Login</a>
    </div>
</div>
</body>
</html>