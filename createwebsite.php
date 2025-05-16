<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Check if a file is uploaded
    if (!empty($_FILES['logo']['name'])) {
        // Create a unique filename to avoid overwriting
        $logoFilename = uniqid() . "_" . basename($_FILES['logo']['name']);
        $targetPath = "uploads/" . $logoFilename;

        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the folder if it doesn't exist
        }

        // Move uploaded file to the destination folder
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
            // Save to DB
            $query = "INSERT INTO website (name, logo, description) VALUES (:name, :logo, :description)";
            $stmt = $pdo->prepare($query);

            if ($stmt->execute([
                ':name' => $name,
                ':logo' => $logoFilename,
                ':description' => $description
            ])) {
                echo "<script>alert('New record created successfully.');</script>";
            } else {
                echo "<script>alert('Database error: " . $stmt->errorInfo()[2],"');</script>";
            }
        } else {
            echo "<script>alert('Error moving uploaded file.');</script>";
        }
    } else {
        echo "<script>alert('Logo is required.');</script>";
    }
}

?>