<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['faculty_id'])) {
    header("Location: facultylogin.php");
    exit();
}

// Fetch all enrollment forms
$stmt = $pdo->query("SELECT enrollmentId, firstName, lastName, status FROM enrollmentForm ORDER BY status, lastName");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Enrollment Forms</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #6366f1;
            color: #fff;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 32px 18px 18px 18px;
            box-shadow: 2px 0 8px rgba(99,102,241,0.08);
        }
        .sidebar h2 {
            margin: 0 0 32px 0;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
        }
        .sidebar a {
            display: block;
            width: 100%;
            background: none;
            border: none;
            color: #fff;
            text-align: left;
            padding: 12px 0 12px 8px;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #4f46e5;
            color: #e0e7ff;
        }
        .main-content {
            margin-left: 240px;
            padding: 40px 32px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(99,102,241,0.06);
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f3f4f6;
        }
        .status-pending { color: #f59e42; font-weight: bold; }
        .status-approved { color: #22c55e; font-weight: bold; }
        .status-rejected { color: #f87171; font-weight: bold; }
        @media (max-width: 900px) {
            .main-content { padding: 20px 5vw; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><?= htmlspecialchars($_SESSION['faculty_name']) ?></h2>
        <a href="faculty_dashboard.php">Dashboard Home</a>
        <a href="faculty_enrollments.php">Check Enrollment Forms</a>
        <a href="faculty_grades.php">Grades Per Student</a>
        <a href="logout.php" style="color:#f87171;">Logout</a>
    </div>
    <div class="main-content">
        <h1>Enrollment Forms</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['lastName'] . ', ' . $student['firstName']) ?></td>
                <td class="status-<?= strtolower($student['status']) ?>">
                    <?= htmlspecialchars(ucfirst($student['status'])) ?>
                </td>
                <td>
                    <a href="studentportal.php?id=<?= $student['enrollmentId'] ?>" target="_blank" style="color:#6366f1;text-decoration:underline;">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>