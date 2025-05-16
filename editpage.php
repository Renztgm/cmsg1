<?php
session_start();
include_once 'db.php';
include_once 'checkpageassign.php';

$websiteId = $_GET['websiteId'] ?? null;
$pageId = $_GET['pageId'] ?? null;

// Delete template and its contents
if (isset($_GET['delete_template'])) {
    $templateId = $_GET['delete_template'];
    $pdo->prepare("DELETE FROM contents WHERE templateId = ?")->execute([$templateId]);
    $pdo->prepare("DELETE FROM templates WHERE templateId = ?")->execute([$templateId]);
    header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
    exit();
}

// Delete content
if (isset($_GET['delete_content'])) {
    $contentId = $_GET['delete_content'];
    $pdo->prepare("DELETE FROM contents WHERE contentId = ?")->execute([$contentId]);
    header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
    exit();
}

// Fetch templates and contents
$stmtTemplates = $pdo->prepare("SELECT * FROM templates WHERE pageId = ?");
$stmtTemplates->execute([$pageId]);
$templates = $stmtTemplates->fetchAll(PDO::FETCH_ASSOC);

$templateIds = array_column($templates, 'templateId');
$contents = [];
if (!empty($templateIds)) {
    $placeholders = implode(',', array_fill(0, count($templateIds), '?'));
    $stmtContents = $pdo->prepare("SELECT * FROM contents WHERE templateId IN ($placeholders)");
    $stmtContents->execute($templateIds);
    $contents = $stmtContents->fetchAll(PDO::FETCH_ASSOC);
}

// Update multiple content texts (Tab 2 bulk update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contentIds'])) {
    foreach ($_POST['contentIds'] as $index => $contentId) {
        $text = $_POST['texts'][$index] ?? '';
        $pdo->prepare("UPDATE contents SET text = ? WHERE contentId = ?")->execute([$text, $contentId]);
    }
    $updateSuccess = true;
}

// Update single content (modal)
$updateFailed = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contentId'])) {
    $contentId = $_POST['contentId'];
    $width = $_POST['width'] ?? null;
    $height = $_POST['height'] ?? null;
    $backgroundColor = (isset($_POST['backgroundColor']) && $_POST['backgroundColor'] !== '') ? $_POST['backgroundColor'] : null;
    $text = $_POST['text'] ?? null;
    $margin = $_POST['margin'] ?? null;
    $padding = $_POST['padding'] ?? null;
    $success = true;

    // Handle image upload
    if (isset($_FILES['imagePath']) && $_FILES['imagePath']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = uniqid() . '_' . basename($_FILES['imagePath']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['imagePath']['tmp_name'], $targetFile)) {
            $stmt = $pdo->prepare("UPDATE contents SET imagePath = ? WHERE contentId = ?");
            if (!$stmt->execute([$targetFile, $contentId])) $success = false;
        } else {
            $success = false;
        }
    }

    // Update other fields
    $stmt = $pdo->prepare("UPDATE contents SET width = ?, height = ?, backgroundColor = ?, text = ?, margin = ?, padding = ? WHERE contentId = ?");
    if (!$stmt->execute([$width, $height, $backgroundColor, $text, $margin, $padding, $contentId])) $success = false;

    if (!$success) $updateFailed = true;
}

// Update template (modal)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editTemplateId'])) {
    $templateId = $_POST['editTemplateId'];
    $templateName = $_POST['templateName'] ?? '';
    $templateType = $_POST['templateType'] ?? '';
    $width = $_POST['width'] ?? '';
    $height = $_POST['height'] ?? '';
    $backgroundColor = $_POST['backgroundColor'] ?? '';
    $flexDirection = $_POST['flexDirection'] ?? '';
    $alignItems = $_POST['alignItems'] ?? '';
    $justifyContent = $_POST['justifyContent'] ?? '';
    $margin = $_POST['margin'] ?? '';
    $padding = $_POST['padding'] ?? '';

    $stmt = $pdo->prepare("UPDATE templates SET templateName=?, templateType=?, width=?, height=?, backgroundColor=?, flexDirection=?, alignItems=?, justifyContent=?, margin=?, padding=? WHERE templateId=?");
    $success = $stmt->execute([
        $templateName, $templateType, $width, $height, $backgroundColor,
        $flexDirection, $alignItems, $justifyContent, $margin, $padding, $templateId
    ]);
    if ($success) {
        header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
        exit();
    } else {
        $updateFailed = true;
    }
}

// Add "Enroll Now!" link
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_enroll_link'])) {
    $enrollLink = 'enroll.php?websiteId=' . $websiteId;
    $target = '_blank';
    $enrollnow = 'Enroll Now!';
    $templateId = $_POST['enroll_template_id'] ?? null;
    if ($templateId) {
        $stmt = $pdo->prepare("INSERT INTO contents (templateId, tag, text, href, target) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$templateId, 'a', $enrollnow, $enrollLink, $target]);
    }
    header("Location: editpage.php?websiteId=$websiteId&pageId=$pageId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="height: 100vh; overflow: auto;">
    <header style="z-index: 999;">
        <div class="template-navigation" style="z-index: 999; height: 60px;background-color: #333; padding: 10px; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
            <h1 style="color: #fff;">Edit Page</h1>
            <div class="editpagenavigationsection">
                <a href="index.php" style="color: #fff; text-decoration: none; font-weight: bold;">Home</a>
                <a href="preview.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>" target="_blank" style="color: #fff; text-decoration: none; font-weight: bold;">Preview</a>
            </div>
        </div>  
    </header>
    <div class="container" style="background-color: #ffffff; display: flex; flex-direction: row; padding: 0;">
        <div class="preview" style="overflow: auto; height: 80vh; z-index: 0; width: 60%; margin: 20px; background-color: #f4f4f4;">
            <?php include 'preview.php'; ?>
        </div>
        <div class="tabs" style="overflow: auto; height: 80vh; z-index: 1000;width: 40%; padding: 20px; background-color: #fff; border-left: 1px solid #ccc;"> 
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('container1')">Tab 1</button>
                <button class="tab-btn" onclick="showTab('container')">Tab 2</button>
                <button class="tab-btn" onclick="showTab('container2')">Tab 3</button>
            </div>
            <div class="hayxx" style="z-index: 1000; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div id="container1" class="tab-content" style="display: block;">
                    <?php include 'addtemplate.php'?>
                    <?php include 'addContent.php'?>
                    <div class="form-container" style="margin: 20px 0;">
                        <div class="enroll-link-section">
                            <form method="POST" style="display:flex; align-items:center; gap:12px;">
                                <input type="hidden" name="add_enroll_link" value="1">
                                <label for="enroll_template_id">Add to template:</label>
                                <select name="enroll_template_id" id="enroll_template_id" required>
                                    <option value="">Select Template</option>
                                    <?php foreach ($templates as $template): ?>
                                        <option value="<?= $template['templateId'] ?>">
                                            <?= htmlspecialchars($template['templateName'] ?: 'Unnamed Template') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit">
                                    Add "Enroll Now!" Link to Page
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="container" class="tab-content" style="display: none;">
                    <div class="contentnito">
                        <form method="POST" action="edit_content.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>">
                            <input type="hidden" name="websiteId" value="<?= $websiteId ?>">
                            <input type="hidden" name="pageId" value="<?= $pageId ?>">
                            <?php foreach ($templates as $template): ?>
                                <div class="template-card">
                                    <h3>
                                        Template: <?= htmlspecialchars($template['templateName'] ?? 'Unnamed') ?>
                                        <button type="button" class="edit-btn"
                                            onclick='editTemplate(<?= json_encode($template, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                            Edit
                                        </button>
                                        <a href="editpage.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>&delete_template=<?= $template['templateId'] ?>"
                                           class="delete-btn"
                                           onclick="return confirm('Delete this template and all its contents?');">Delete</a>
                                    </h3>
                                    <ul>
                                        <?php foreach ($contents as $content): ?>
                                            <?php if ($content['templateId'] == $template['templateId']): ?>
                                                <li>
                                                    <input type="hidden" name="contentIds[]" value="<?= $content['contentId'] ?>">
                                                    <label>Content ID <?= $content['contentId'] ?>:</label>
                                                    <?php if (!in_array($content['tag'], ['img', 'image'])): ?>
                                                        <input type="text" name="texts[]" value="<?= htmlspecialchars($content['text'] ?? '') ?>" style="width:180px;">
                                                    <?php endif; ?>
                                                    <button type="button" class="edit-btn"
                                                        onclick='openModal(<?= json_encode($content, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                                        Edit
                                                    </button>
                                                    <a href="editpage.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>&delete_content=<?= $content['contentId'] ?>"
                                                       class="delete-btn"
                                                       onclick="return confirm('Delete this content?');">Delete</a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                            <!-- <button type="submit" class="tab-btn" style="margin-top:10px;">Update All Content</button> -->
                        </form>
                    </div>
                </div>
                <div id="container2" class="tab-content" style="display: none;">
                    <div class="contentnito">
                        <p>Tab 3 content (container2)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Edit Content Modal -->
<div id="editContentModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:2000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:8px; min-width:320px; max-width:90vw; position:relative;">
        <button onclick="closeModal()" style="position:absolute; top:10px; right:10px;">&times;</button>
        <form id="modalEditForm" method="POST" enctype="multipart/form-data" action="edit_content.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>">
            <input type="hidden" name="contentId" id="modalContentId">
            <input type="hidden" name="websiteId" value="<?= $websiteId ?>">
            <input type="hidden" name="pageId" value="<?= $pageId ?>">
            <div>
                <label>Content ID:</label>
                <span id="modalContentIdLabel"></span>
            </div>
            <div>
                <label>Width:</label>
                <input type="text" name="width" id="modalWidth">
            </div>
            <div>
                <label>Height:</label>
                <input type="text" name="height" id="modalHeight">
            </div>
            <div>
                <label>Margin:</label>
                <input type="text" name="margin" id="modalMargin">
            </div>
            <div>
                <label>Padding:</label>
                <input type="text" name="padding" id="modalPadding">
            </div>
            <div>
                <label>Background Color:</label>
                <input type="checkbox" id="bgColorCheckbox" onclick="toggleBgColorInput()"> Enable
                <input type="color" name="backgroundColor" id="modalBgColor" style="display:none;">
            </div>
            <div id="textFields" style="display:none;">
                <label>Text:</label>
                <textarea name="text" id="modalText"></textarea>
                <label>Font Family:</label>
                <input type="text" name="fontFamily" id="modalFontFamily">
                <label>Font Size:</label>
                <input type="text" name="fontSize" id="modalFontSize">
                <label>Font Color:</label>
                <input type="color" name="fontColor" id="modalFontColor">
            </div>
            <div id="imageFields" style="display:none;">
                <label>Image Path:</label>
                <input type="file" name="imagePath" id="modalImagePath">
            </div>
            <div id="linkFields" style="display:none;">
                <label>Text:</label>
                <input type="text" name="text" id="modalLinkText">
                <label>Font Family:</label>
                <input type="text" name="fontFamily" id="modalLinkFontFamily">
                <label>Font Size:</label>
                <input type="text" name="fontSize" id="modalLinkFontSize">
                <label>Font Color:</label>
                <input type="color" name="fontColor" id="modalLinkFontColor">
                <label>Href:</label>
                <input type="text" name="href" id="modalHref">
                <label>Target:</label>
                <input type="text" name="target" id="modalTarget">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Edit Template Modal -->
<div id="editTemplateModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:3000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:8px; min-width:320px; max-width:90vw; position:relative;">
        <button onclick="closeTemplateModal()" style="position:absolute; top:10px; right:10px;">&times;</button>
        <form id="modalEditTemplateForm" method="POST" action="editpage.php?websiteId=<?= $websiteId ?>&pageId=<?= $pageId ?>">
            <input type="hidden" name="editTemplateId" id="modalTemplateId">
            <div>
                <label>Template Name:</label>
                <input type="text" name="templateName" id="modalTemplateName" disabled>
            </div>
            <div>
                <label>Type:</label>
                <input type="text" name="templateType" id="modalTemplateType" disabled>
            </div>
            <div>
                <label>Width:</label>
                <input type="text" name="width" id="modalTemplateWidth">
            </div>
            <div>
                <label>Height:</label>
                <input type="text" name="height" id="modalTemplateHeight">
            </div>
            <div>
                <label>Background Color:</label>
                <input type="color" name="backgroundColor" id="modalTemplateBgColor">
            </div>
            <div>
                <label>Flex Direction:</label>
                <select name="flexDirection" id="modalTemplateFlexDirection">
                    <option value="row">row</option>
                    <option value="row-reverse">row-reverse</option>
                    <option value="column">column</option>
                    <option value="column-reverse">column-reverse</option>
                </select>
            </div>
            <div>
                <label>Align Items:</label>
                <select name="alignItems" id="modalTemplateAlignItems">
                    <option value="flex-start">flex-start</option>
                    <option value="flex-end">flex-end</option>
                    <option value="center">center</option>
                    <option value="baseline">baseline</option>
                    <option value="stretch">stretch</option>
                </select>
            </div>
            <div>
                <label>Justify Content:</label>
                <select name="justifyContent" id="modalTemplateJustifyContent">
                    <option value="flex-start">flex-start</option>
                    <option value="flex-end">flex-end</option>
                    <option value="center">center</option>
                    <option value="space-between">space-between</option>
                    <option value="space-around">space-around</option>
                </select>
            </div>
            <div>
                <label>Margin:</label>
                <input type="text" name="margin" id="modalTemplateMargin">
            </div>
            <div>
                <label>Padding:</label>
                <input type="text" name="padding" id="modalTemplatePadding">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<?php if (!empty($updateFailed)): ?>
<script>
    alert('Update failed. Please try again.');
</script>
<?php endif; ?>

<script>
function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.style.display = 'none');
    const selected = document.getElementById(tabId);
    if (selected) selected.style.display = 'block';
}

function toggleBgColorInput() {
    const checkbox = document.getElementById('bgColorCheckbox');
    const colorInput = document.getElementById('modalBgColor');
    if (checkbox.checked) {
        colorInput.style.display = '';
        colorInput.disabled = false;
    } else {
        colorInput.style.display = 'none';
        colorInput.value = '';
        colorInput.disabled = true;
    }
}

function openModal(content) {
    document.getElementById('modalContentId').value = content.contentId;
    document.getElementById('modalContentIdLabel').innerText = content.contentId;
    document.getElementById('modalWidth').value = content.width || '';
    document.getElementById('modalHeight').value = content.height || '';
    document.getElementById('modalMargin').value = content.margin || '';
    document.getElementById('modalPadding').value = content.padding || '';
    const bgCheckbox = document.getElementById('bgColorCheckbox');
    const bgInput = document.getElementById('modalBgColor');
    if (content.backgroundColor && content.backgroundColor !== 'null' && content.backgroundColor !== '') {
        bgCheckbox.checked = true;
        bgInput.style.display = '';
        bgInput.disabled = false;
        bgInput.value = content.backgroundColor;
    } else {
        bgCheckbox.checked = false;
        bgInput.style.display = 'none';
        bgInput.value = '';
        bgInput.disabled = true;
    }
    document.getElementById('textFields').style.display = 'none';
    document.getElementById('imageFields').style.display = 'none';
    document.getElementById('linkFields').style.display = 'none';
    if(['h1','h2','h3','h4','p'].includes(content.tag)) {
        document.getElementById('textFields').style.display = 'block';
        document.getElementById('modalText').value = content.text || '';
        document.getElementById('modalFontFamily').value = content.fontFamily || '';
        document.getElementById('modalFontSize').value = content.fontSize || '';
        document.getElementById('modalFontColor').value = content.fontColor || '#000000';
    } else if(content.tag === 'img' || content.tag === 'image') {
        document.getElementById('imageFields').style.display = 'block';
    } else if(content.tag === 'a') {
        document.getElementById('linkFields').style.display = 'block';
        document.getElementById('modalLinkText').value = content.text || '';
        document.getElementById('modalLinkFontFamily').value = content.fontFamily || '';
        document.getElementById('modalLinkFontSize').value = content.fontSize || '';
        document.getElementById('modalLinkFontColor').value = content.fontColor || '#000000';
        document.getElementById('modalHref').value = content.href || '';
        document.getElementById('modalTarget').value = content.target || '';
    }
    document.getElementById('editContentModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('editContentModal').style.display = 'none';
}

function editTemplate(template) {
    document.getElementById('modalTemplateId').value = template.templateId;
    document.getElementById('modalTemplateName').value = template.templateName || '';
    document.getElementById('modalTemplateType').value = template.templateType || '';
    document.getElementById('modalTemplateWidth').value = template.width || '';
    document.getElementById('modalTemplateHeight').value = template.height || '';
    document.getElementById('modalTemplateBgColor').value = template.backgroundColor || '#ffffff';
    document.getElementById('modalTemplateFlexDirection').value = template.flexDirection || '';
    document.getElementById('modalTemplateAlignItems').value = template.alignItems || '';
    document.getElementById('modalTemplateJustifyContent').value = template.justifyContent || '';
    document.getElementById('modalTemplateMargin').value = template.margin || '';
    document.getElementById('modalTemplatePadding').value = template.padding || '';
    document.getElementById('editTemplateModal').style.display = 'flex';
}

function closeTemplateModal() {
    document.getElementById('editTemplateModal').style.display = 'none';
}
</script>
</body>
</html>

