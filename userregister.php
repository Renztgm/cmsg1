<?php
session_start();
include_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($username && $password && $fullName && $email) {
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-container" style="max-width:350px;margin:60px auto;">
    <h1>User Register</h1>
    <?php if ($error): ?><div style="color:#f87171;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div style="color:#22c55e;"><?= $success ?></div><?php endif; ?>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="fullName" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Register</button>
    </form>
    <div style="margin-top:10px;">
        Already have an account? <a href="userlogin.php">Login</a>
    </div>
</div>
</body>
</html>