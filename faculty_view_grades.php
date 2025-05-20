<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['faculty_id'])) {
    header("Location: facultylogin.php");
    exit();
}

$enrollmentId = $_GET['id'] ?? null;
if (!$enrollmentId) {
    echo "<h2>Invalid student.</h2>";
    exit();
}

// Fetch student info
$stmt = $pdo->prepare("SELECT firstName, lastName FROM enrollmentForm WHERE enrollmentId = ?");
$stmt->execute([$enrollmentId]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) {
    echo "<h2>Student not found.</h2>";
    exit();
}

// Handle add/edit grade
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gradeId = $_POST['gradeId'] ?? null;
    $professor = $_POST['professor'] ?? $_SESSION['faculty_name'];
    $subject = $_POST['subject'] ?? '';
    $grade = $_POST['grade'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $schoolYear = $_POST['schoolYear'] ?? '';

    if ($gradeId) {
        // Update existing grade
        $stmt = $pdo->prepare("UPDATE grades SET professor=?, subject=?, grade=?, semester=?, schoolYear=? WHERE gradeId=?");
        $stmt->execute([$professor, $subject, $grade, $semester, $schoolYear, $gradeId]);
    } else {
        // Insert new grade
        $stmt = $pdo->prepare("INSERT INTO grades (enrollmentId, professor, subject, grade, semester, schoolYear) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$enrollmentId, $professor, $subject, $grade, $semester, $schoolYear]);
    }
    header("Location: faculty_view_grades.php?id=$enrollmentId");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $gradeId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM grades WHERE gradeId = ? AND enrollmentId = ?");
    $stmt->execute([$gradeId, $enrollmentId]);
    header("Location: faculty_view_grades.php?id=$enrollmentId");
    exit();
}

// Fetch grades grouped by year and semester
$stmt = $pdo->prepare("SELECT * FROM grades WHERE enrollmentId = ? ORDER BY schoolYear DESC, semester ASC");
$stmt->execute([$enrollmentId]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped = [];
foreach ($grades as $row) {
    $key = $row['schoolYear'] . ' - ' . $row['semester'];
    $grouped[$key][] = $row;
}

// For edit form
$editGrade = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    foreach ($grades as $g) {
        if ($g['gradeId'] == $editId) {
            $editGrade = $g;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades for <?= htmlspecialchars($student['lastName'] . ', ' . $student['firstName']) ?></title>
    <link rel="stylesheet" href="styles.css">
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
            min-height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 28px 24px 18px 24px;
            border-radius: 10px;
            margin-bottom: 32px;
            box-shadow: 0 2px 8px rgba(179,33,19,0.06);
            max-width: 420px;
        }
        .form-container h2 {
            margin-top: 0;
            color: #B32113;
            font-size: 20px;
        }
        .form-container label {
            display: block;
            margin-bottom: 6px;
            color: #8F1600;
            font-weight: 500;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container select {
            width: 100%;
            padding: 9px 12px;
            margin-bottom: 16px;
            border: 1.5px solid #B32113;
            border-radius: 5px;
            font-size: 15px;
            background: #CBC3BE;
            color: #831005;
            transition: border-color 0.2s, background 0.2s;
            box-sizing: border-box;
        }
        .form-container input[type="text"]:focus,
        .form-container input[type="number"]:focus,
        .form-container select:focus {
            border-color: #8F1600;
            background: #fff;
            outline: none;
        }
        .form-container button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #B32113;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .form-container button[type="submit"]:hover {
            background: #831005;
        }
        .form-container a {
            color: #B32113;
            text-decoration: underline;
            margin-left: 12px;
            font-weight: bold;
        }
        .form-container a:hover {
            color: #8F1600;
        }
        .grades-section {
            max-width: 900px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(179,33,19,0.06);
        }
        th, td {
            border: 1px solid #A6A6AB;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #CBC3BE;
            color: #831005;
            font-weight: bold;
        }
        .edit-link, .delete-link {
            color: #B32113; text-decoration: underline; cursor: pointer; margin: 0 6px; font-weight: bold;
        }
        .delete-link { color: #8F1600; }
        .edit-link:hover { color: #8F1600; }
        .delete-link:hover { color: #B32113; }
        .back-link {
            display: inline-block;
            margin-top: 32px;
            color: #B32113;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            color: #8F1600;
        }
        @media (max-width: 900px) {
            .main-content { padding: 20px 5vw; }
            .grades-section { max-width: 100vw; }
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
        <h1 style="margin-top:0;">Grades for <?= htmlspecialchars($student['lastName'] . ', ' . $student['firstName']) ?></h1>
        <div class="form-container">
            <h2><?= $editGrade ? 'Edit Grade' : 'Add Grade' ?></h2>
            <form method="POST">
                <?php if ($editGrade): ?>
                    <input type="hidden" name="gradeId" value="<?= $editGrade['gradeId'] ?>">
                <?php endif; ?>
                <label>Professor</label>
                <input type="text" name="professor" value="<?= htmlspecialchars($editGrade['professor'] ?? $_SESSION['faculty_name']) ?>" required>
                <label>Subject</label>
                <input type="text" name="subject" value="<?= htmlspecialchars($editGrade['subject'] ?? '') ?>" required>
                <label>Grade</label>
                <input type="number" name="grade" value="<?= htmlspecialchars($editGrade['grade'] ?? '') ?>" required>
                <label>Semester</label>
                <select name="semester" required>
                    <?php
                    $semesters = ['1st Sem', '2nd Sem', '3rd Sem'];
                    foreach ($semesters as $sem):
                    ?>
                        <option value="<?= $sem ?>" <?= (isset($editGrade['semester']) && $editGrade['semester'] == $sem) ? 'selected' : '' ?>>
                            <?= $sem ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>School Year</label>
                <input type="text" name="schoolYear" value="<?= htmlspecialchars($editGrade['schoolYear'] ?? date('Y') . '-' . (date('Y')+1)) ?>" required>
                <button type="submit"><?= $editGrade ? 'Update' : 'Add' ?> Grade</button>
                <?php if ($editGrade): ?>
                    <a href="faculty_view_grades.php?id=<?= $enrollmentId ?>">Cancel</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="grades-section">
        <?php if ($grades): ?>
            <?php foreach ($grouped as $group => $rows): ?>
                <h3 style="margin-top:30px; color:#B32113;"><?= htmlspecialchars($group) ?></h3>
                <table>
                    <tr>
                        <th>Professor</th>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['professor']) ?></td>
                            <td><?= htmlspecialchars($row['subject']) ?></td>
                            <td><?= htmlspecialchars($row['grade']) ?></td>
                            <td>
                                <a class="edit-link" href="faculty_view_grades.php?id=<?= $enrollmentId ?>&edit=<?= $row['gradeId'] ?>">Edit</a>
                                <a class="delete-link" href="faculty_view_grades.php?id=<?= $enrollmentId ?>&delete=<?= $row['gradeId'] ?>" onclick="return confirm('Delete this grade?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="margin-top:24px;">No grades available.</div>
        <?php endif; ?>
        </div>
        <a class="back-link" href="faculty_grades.php">&larr; Back to student list</a>
    </div>
</body>
</html>