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
    <style>
        body {
            margin: 0;
            background: #CBC3BE;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #B32113;
            color: #fff;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 32px 18px 18px 18px;
            box-shadow: 2px 0 8px rgba(179,33,19,0.08);
        }
        .sidebar h2 {
            margin: 0 0 32px 0;
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            letter-spacing: 1px;
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
            background: #8F1600;
            color: #CBC3BE;
        }
        .sidebar a.logout {
            color: #CBC3BE;
            font-weight: bold;
        }
        .sidebar a.logout:hover {
            background: #CBC3BE;
            color: #B32113;
        }
        .main-content {
            margin-left: 240px;
            padding: 40px 32px;
        }
        .main-content h1 {
            color: #B32113;
            font-size: 2.2em;
            margin-bottom: 18px;
        }
        .student-list {
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(179,33,19,0.06);
            padding: 24px 18px;
            max-width: 500px;
        }
        .student-list a {
            display: block;
            padding: 12px 18px;
            margin-bottom: 8px;
            background: #CBC3BE;
            border-radius: 6px;
            color: #831005;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            border: 1px solid #A6A6AB;
        }
        .student-list a:hover {
            background: #B32113;
            color: #fff;
            border-color: #831005;
        }
        .no-students {
            color: #B32113;
            text-align: center;
            font-weight: 500;
            margin-top: 12px;
        }
        @media (max-width: 900px) {
            .main-content { padding: 20px 5vw; margin-left: 0; }
            .student-list { max-width: 100vw; }
            .sidebar { position: static; width: 100vw; height: auto; flex-direction: row; align-items: center; padding: 16px 8px; }
            .sidebar h2 { margin: 0 16px 0 0; font-size: 1.1em; }
            .sidebar a { display: inline-block; width: auto; padding: 10px 14px; margin-bottom: 0; margin-right: 8px; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><?= htmlspecialchars($_SESSION['faculty_name']) ?></h2>
        <a href="faculty_dashboard.php">Dashboard Home</a>
        <a href="faculty_enrollments.php">Check Enrollment Forms</a>
        <a href="faculty_grades.php">Grades Per Student</a>
        <a href="logout.php" class="logout">Logout</a>
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
                <div class="no-students">No approved students found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>