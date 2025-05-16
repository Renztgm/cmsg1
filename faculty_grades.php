<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['faculty_id'])) {
    header("Location: facultylogin.php");
    exit();
}

// Fetch all students
$stmt = $pdo->query("SELECT enrollmentId, firstName, lastName FROM enrollmentForm WHERE status = 'approved' ORDER BY lastName");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades Per Student</title>
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
        .student-list {
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(99,102,241,0.06);
            padding: 24px 18px;
            max-width: 500px;
        }
        .student-list a {
            display: block;
            padding: 12px 18px;
            margin-bottom: 8px;
            background: #f3f4f6;
            border-radius: 6px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .student-list a:hover {
            background: #6366f1;
            color: #fff;
        }
        @media (max-width: 900px) {
            .main-content { padding: 20px 5vw; }
            .student-list { max-width: 100vw; }
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
        <h1>Grades Per Student</h1>
        <div class="student-list">
            <?php if ($students): ?>
                <?php foreach ($students as $student): ?>
                    <a href="faculty_view_grades.php?id=<?= $student['enrollmentId'] ?>">
                        <?= htmlspecialchars($student['lastName'] . ', ' . $student['firstName']) ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="color:#f87171;">No approved students found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>