<?php 
session_start();
include_once 'db.php';
$websiteId = $_SESSION['websiteId'] ?? null;
$pageId = $_GET['pageId'] ?? null;

// Prepare template values
$websiteId = $_POST['websiteId'];
$pageId = $_POST['pageId'];
$templateId = $_POST['templateId'];
$parentContentId = $_POST['parentContentId'] ?? null;
$tag = $_POST['tags'] ?? null;
$width = $_POST['width'] . $_POST['widthSuffix'] ?? null;
$height = $_POST['height'] . $_POST['heightSuffix']?? null;
$backgroundColor = $_POST['backgroundColor'] ?? null;
$text = $_POST['text'] ?? null;
$orderContent = $_POST['orderContent'] ?? null;
$href = $_POST['href'] ?? null;
$target = $_POST['target'] ?? null;
$fontcolor = $_POST['fontcolor'] ?? null;
$fontstyle = $_POST['fontstyle'] ?? null;
$fontsize = $_POST['fontsize'] . $_POST['fontsizeSuffix'] ?? null;
$fontfamily = $_POST['fontfamily'] ?? null;
$isclickable = $_POST['isclickable'] ?? null;

if (isset($_FILES['imagePath']) && $_FILES['imagePath']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filename = uniqid() . '_' . basename($_FILES['imagePath']['name']);
    $targetFile = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['imagePath']['tmp_name'], $targetFile)) {
        $imagePath = $targetFile;
    } else {
        $imagePath = null;
    }
} else {
    $imagePath = null;
}

// Prepare insert statement once
$insertContentSql = "INSERT INTO contents (
    templateId, parentContentId, tag, width, height, backgroundColor,
    text, orderContent, imagePath, href, target,
    fontcolor, fontstyle, fontsize, fontfamily, isclickable
) VALUES (
    :templateId, :parentContentId, :tag, :width, :height, :backgroundColor,
    :text, :orderContent, :imagePath, :href, :target,
    :fontcolor, :fontstyle, :fontsize, :fontfamily, :isclickable
)";

// Prepare the statement
$stmt = $pdo->prepare($insertContentSql);
// Bind parameters
$stmt->bindParam(':templateId', $templateId);
$stmt->bindParam(':parentContentId', $parentContentId);
$stmt->bindParam(':tag', $tag);
$stmt->bindParam(':width', $width);
$stmt->bindParam(':height', $height);
$stmt->bindParam(':backgroundColor', $backgroundColor);
$stmt->bindParam(':text', $text);
$stmt->bindParam(':orderContent', $orderContent);
$stmt->bindParam(':imagePath', $imagePath);
$stmt->bindParam(':href', $href);
$stmt->bindParam(':target', $target);
$stmt->bindParam(':fontcolor', $fontcolor);
$stmt->bindParam(':fontstyle', $fontstyle);
$stmt->bindParam(':fontsize', $fontsize);
$stmt->bindParam(':fontfamily', $fontfamily);
$stmt->bindParam(':isclickable', $isclickable);
// Execute the statement
$success = $stmt->execute();
if ($success) {
    if ($imagePath === null) {
        // Show alert if imagePath is null
        // echo "<script>alert('Warning: Image was not uploaded. imagePath is null.');</script>";
    }
    // Optionally, you can also redirect after the alert
    echo "<script>window.location.href='editpage.php?websiteId=$websiteId&pageId=$pageId';</script>";
    exit();
} else {
    $errorInfo = $stmt->errorInfo();
    echo "<script>alert('Error inserting content: " . addslashes($errorInfo[2]) . "');</script>";
}
?>