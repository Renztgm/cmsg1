<?php
session_start();
$pageId = $_GET['pageId'] ?? null;
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize POST data
$websiteId = $_POST['websiteId'];
$templateName = $conn->real_escape_string($_POST['templateName']);
$templateType = $conn->real_escape_string($_POST['templateType']);
$width = $conn->real_escape_string($_POST['width']) . $conn->real_escape_string($_POST['widthSuffix']);
$height = $conn->real_escape_string($_POST['height']) . $conn->real_escape_string($_POST['heightSuffix']);;
$backgroundColor = $conn->real_escape_string($_POST['backgroundColor']);
$borderValue = $conn->real_escape_string($_POST['borderValue']);
$borderStyle = $conn->real_escape_string($_POST['borderStyle']);
$borderColor = $conn->real_escape_string($_POST['borderColor']);
$flexDirection = $conn->real_escape_string($_POST['flexDirection']);
$alignItems = $conn->real_escape_string($_POST['alignItems']);
$justifyContent = $conn->real_escape_string($_POST['justifyContent']);
$margin = $conn->real_escape_string($_POST['margin']);
$padding = $conn->real_escape_string($_POST['padding']);
$orderTemp = $conn->real_escape_string($_POST['orderTemp']);
$pageId = $conn->real_escape_string($_POST['pageId']);
$parentTemplateId = empty($_POST['parentTemplateId']) ? null : $_POST['parentTemplateId'];


// Insert query - templateId is not included, as it should be auto-increment
$sql = "INSERT INTO templates (
    pageId, templateName, templateType, width, height, backgroundColor,
    borderValue, borderStyle, borderColor, flexDirection, alignItems,
    JustifyContent, margin, padding, orderTemp, parentTemplateId
) VALUES (
    '$pageId','$templateName', '$templateType', '$width', '$height', '$backgroundColor',
    '$borderValue', '$borderStyle', '$borderColor', '$flexDirection', '$alignItems',
    '$justifyContent', '$margin', '$padding', '$orderTemp', '$parentTemplateId'
)";

// Execute and check
if ($conn->query($sql) === TRUE) {
    echo "New template inserted successfully.";
    echo "the templateId is: " . $parentTemplateId;
    
    header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
    
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
