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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-container" style="max-width:350px;margin:60px auto;">
    <h1>Login</h1>
    <?php if ($error): ?>
        <div style="color:#f87171; margin-bottom:12px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required autofocus>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>