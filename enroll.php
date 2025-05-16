<?php
// filepath: c:\xampp\htdocs\cmsg1\enroll.php
include_once 'db.php'; // Make sure this connects to your PDO $pdo
$websiteId = $_POST['websiteId'] ?? $_GET['websiteId'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $stmt = $pdo->prepare("INSERT INTO enrollmentForm 
        (websiteId, firstName, lastName, birthdate, sex, houseNo_streetName, baranggay, city, country, phoneNumber, course, semester, year, username, email, password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([
        $websiteId,
        $_POST['firstName'],
        $_POST['lastName'],
        $_POST['birthdate'],
        $_POST['sex'],
        $_POST['houseNo_streetName'],
        $_POST['baranggay'],
        $_POST['city'],
        $_POST['country'],
        $_POST['phoneNumber'],
        $_POST['course'],
        $_POST['semester'],
        $_POST['year'],
        $_POST['username'],
        $_POST['email'],
        password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);
    if ($success) {
        echo "<script>alert('Enrollment successful!');</script>";
        header("Location: enroll.php?websiteId=$websiteId");
        exit();
    } else {
        echo "<script>alert('Enrollment failed!');</script>";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrollment Form</title>
    <style>
        body {
            background: #f6f8fa;
            font-family: Arial, sans-serif;
        }
        .enroll-container {
            background: #fff;
            max-width: 400px;
            margin: 40px auto;
            padding: 32px 28px 24px 28px;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 28px;
        }
        .enroll-form label {
            display: block;
            margin-bottom: 6px;
            color: #444;
            font-weight: 500;
        }
        .enroll-form input[type="text"],
        .enroll-form input[type="date"],
        .enroll-form input[type="email"],
        .enroll-form input[type="number"],
        .enroll-form input[type="password"],
        .enroll-form select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 16px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 15px;
            background: #f9fafb;
            transition: border-color 0.2s;
        }
        .enroll-form input[type="text"]:focus,
        .enroll-form input[type="date"]:focus,
        .enroll-form input[type="email"]:focus,
        .enroll-form input[type="number"]:focus,
        .enroll-form input[type="password"]:focus,
        .enroll-form select:focus {
            border-color: #6366f1;
            outline: none;
            background: #fff;
        }
        .enroll-form button {
            width: 100%;
            padding: 12px;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 8px;
        }
        .enroll-form button:hover {
            background: #4f46e5;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .step-indicator {
            text-align: center;
            margin-bottom: 20px;
        }
        .step-indicator span {
            display: inline-block;
            width: 22px;
            height: 22px;
            line-height: 22px;
            border-radius: 50%;
            background: #e0e7ff;
            color: #6366f1;
            margin: 0 4px;
            font-weight: bold;
        }
        .step-indicator .active {
            background: #6366f1;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="enroll-container">
        <h2>Enrollment Form</h2>
        <div class="step-indicator">
            <span id="indicator-0" class="active">1</span>
            <span id="indicator-1">2</span>
            <span id="indicator-2">3</span>
            <span id="indicator-3">4</span>
        </div>
        <form class="enroll-form" method="POST" action="enroll.php?websiteId=<?= htmlspecialchars($websiteId) ?>">
            <input type="hidden" name="websiteId" value="<?= htmlspecialchars($websiteId) ?>">

            <!-- Step 1: Personal Info -->
            <div class="step active" id="step-0">
                <label>First Name</label>
                <input type="text" name="firstName" required style="text-transform:uppercase;">
                <label>Last Name</label>
                <input type="text" name="lastName" required style="text-transform:uppercase;">
                <label>Birthdate</label>
                <input type="date" name="birthdate" required>
                <label>Sex</label>
                <select name="sex" required>
                    <option value="">Select Sex</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="N">Other</option>
                </select>
                <button type="button" onclick="nextStep(0)">Next</button>
            </div>

            <!-- Step 2: Address and Phone -->
            <div class="step" id="step-1">
                <label>House No. & Street Name</label>
                <input type="text" name="houseNo_streetName" required style="text-transform:uppercase;">
                <label>Baranggay</label>
                <input type="text" name="baranggay" required style="text-transform:uppercase;">
                <label>City</label>
                <input type="text" name="city" required style="text-transform:uppercase;">
                <label>Country</label>
                <input type="text" name="country" required style="text-transform:uppercase;">
                <label>Phone Number</label>
                <input type="number" name="phoneNumber" required>
                <button type="button" onclick="prevStep(1)">Back</button>
                <button type="button" onclick="nextStep(1)">Next</button>
            </div>

            <!-- Step 3: Course -->
            <div class="step" id="step-2">
                <label>Course</label>
                <select name="course" required>
                    <option value="">Select Course</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BSCS">BSCS</option>
                    <option value="BSEd">BSEd</option>
                    <option value="BSBA">BSBA</option>
                    <option value="BSN">BSN</option>
                    <!-- Add more courses as needed -->
                </select>
                <label>Semester</label>
                <select name="semester" required>
                    <option value="FIRST SEM">First Semester</option>
                    <option value="SECOND SEM">Second Semester</option>
                    <option value="THIRD SEM">Third Semester</option>

                    <!-- Add more courses as needed -->
                </select>
                <label>Year</label>
                <select name="year" required>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                </select>
                <button type="button" onclick="prevStep(2)">Back</button>
                <button type="button" onclick="nextStep(2)">Next</button>
            </div>

            <!-- Step 4: Create a Login -->
            <div class="step" id="step-3">
                <label>Username</label>
                <input type="text" name="username" required style="text-transform:uppercase;">
                <label>Email</label>
                <input type="email" name="email" required>
                <label>Password</label>
                <input type="password" name="password" required>
                <button type="button" onclick="prevStep(3)">Back</button>
                <button type="submit" name="submit">Enroll</button>
            </div>
        </form>
    </div>
    <script>
        let currentStep = 0;
        function showStep(step) {
            document.querySelectorAll('.step').forEach((el, idx) => {
                el.classList.toggle('active', idx === step);
                document.getElementById('indicator-' + idx).classList.toggle('active', idx === step);
            });
            currentStep = step;
        }
        function nextStep(step) {
            showStep(step + 1);
        }
        function prevStep(step) {
            showStep(step - 1);
        }

        document.querySelectorAll('.enroll-form input[type="text"]:not([name="email"]):not([name="password"])').forEach(function(input) {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
</body>
</html>