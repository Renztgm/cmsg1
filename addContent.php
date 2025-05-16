<?php
include_once 'db.php';

$showColorInput = false;
$backgroundColor = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $showColorInput = isset($_POST['show_color']);
    $backgroundColor = $showColorInput ? ($_POST['background-color'] ?? null) : null;
}
?>

<h1>Add Content</h1>
<form id="addContentForm" method="POST" action="insert_content.php" enctype="multipart/form-data">
    <input type="hidden" name="websiteId" value="<?php echo htmlspecialchars($_GET['websiteId']); ?>">
    <input type="hidden" name="pageId" value="<?php echo htmlspecialchars($_GET['pageId']); ?>">
    
    <label for="parentTemplateId">Parent Template ID:</label>
    <select name="templateId" id="parentTemplateId">
        <?php
        // Fetch all templates for the dropdown
        $stmt = $pdo->query("SELECT templateId, templateName FROM templates where pageId = $pageId");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . htmlspecialchars($row['templateId']) . '">' . htmlspecialchars($row['templateName']) . '</option>';
        }
        ?>
    </select><br><br>

    <label>width</label>
    <input type="text" name="width" placeholder="Width">
    <select name="widthSuffix">
        <option value="auto">auto</option>
        <option value="px">px</option>
        <option value="rem">rem</option>
        <option value="%">%</option>
        <option value="vw">vw</option>
    </select><br><br>

    <label>height</label>
    <input type="text" name="height" placeholder="Height">
    <select name="heightSuffix">
        <option value="auto">auto</option>
        <option value="px">px</option>
        <option value="rem">rem</option>
        <option value="%">%</option>
        <option value="vh">vh</option>
    </select><br><br>

    <label>
        <input type="checkbox" name="show_color" id="showColorCheckbox" <?php if ($showColorInput) echo 'checked'; ?> onchange="toggleColorPicker()">
        Show Background Color Picker
    </label><br><br>

    <div id="colorPickerContainer" style="display: <?php echo $showColorInput ? 'block' : 'none'; ?>;">
        <input type="color" name="background-color" value="<?php echo htmlspecialchars($backgroundColor ?? '#ffffff'); ?>"><br><br>
    </div>

    <script>
        function toggleColorPicker() {
            const checkbox = document.getElementById('showColorCheckbox');
            const colorPickerContainer = document.getElementById('colorPickerContainer');
            colorPickerContainer.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>


    <label for="tags">Select Tag Type:</label>
    <select name="tags" id="tags">
        <option value="h1">h1</option>
        <option value="h2">h2</option>
        <option value="h3">h3</option>
        <option value="p">p</option>
        <option value="a">a</option>
        <option value="image">image</option>
    </select>

    <div id="dynamicFields" class="field-container">
    </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagSelect = document.getElementById('tags');
            const dynamicFields = document.getElementById('dynamicFields');
            
            // Call initially to set up the form based on default selection
            updateFields(tagSelect.value);
            
            // Add event listener for changes
            tagSelect.addEventListener('change', function() {
                updateFields(this.value);
            });
            
            function updateFields(tagType) {
                // Clear previous fields
                dynamicFields.innerHTML = '';
                
                if (tagType === 'image') {
                    dynamicFields.innerHTML = `
                        <h3>Image Settings</h3>
                        <div class="form-group">
                            <label for="imagepath">Select Image:</label>
                            <input type="file" name="imagePath" id="imagepath">
                        </div>
                    `;
                } else if (tagType === 'a') {
                    // For anchor tags
                    dynamicFields.innerHTML = `
                        <h3>Link Settings</h3>
                        <div class="form-group">
                            <label for="fontsize">Font Size:</label>
                            <input type="number" name="fontsize" id="fontsize">
                            <select name="fontsizeSuffix">
                                <option value="px">px</option>
                                <option value="rem">em</option>
                                <option value="%">%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fontcolor">Font Color:</label>
                            <input type="color" name="fontcolor" id="fontcolor">
                        </div>
                        <div class="form-group">
                            <label for="fontfamily">Font Family:</label>
                            <input type="text" name="fontfamily" id="fontfamily">
                        </div>
                        <div class="form-group">
                            <label for="fontstyle">Font Style:</label>
                            <select name="fontstyle" id="fontstyle">
                                <option value="Normal">Normal</option>
                                <option value="italic">Italic</option>
                                <option value="oblique">Oblique</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="href">Link Target:</label>
                            <select name="href" id="href">
                                <option value="None">None</option>
                                <!-- PHP would insert options here in your actual implementation -->
                                <option value="1">Example Page 1</option>
                                <option value="2">Example Page 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="text">Link Text:</label>
                            <input type="text" name="text" id="text" placeholder="Enter the link text">
                        </div>
                    `;
                } else {
                    // For text-related tags (h1, h2, h3, p)
                    dynamicFields.innerHTML = `
                        <h3>Text Settings</h3>
                        <div class="form-group">
                            <label for="fontsize">Font Size:</label>
                            <input type="text" name="fontsize" id="fontsize">
                            <select name="fontsizeSuffix">
                                <option value="px">px</option>
                                <option value="rem">em</option>
                                <option value="%">%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fontcolor">Font Color:</label>
                            <input type="color" name="fontcolor" id="fontcolor">
                        </div>
                        <div class="form-group">
                            <label for="fontfamily">Font Family:</label>
                            <input type="text" name="fontfamily" id="fontfamily">
                        </div>
                        <div class="form-group">
                            <label for="fontstyle">Font Style:</label>
                            <select name="fontstyle" id="fontstyle">
                                <option value="Normal">Normal</option>
                                <option value="italic">Italic</option>
                                <option value="oblique">Oblique</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="text">Content:</label>
                            <input type="text" name="text" id="text" placeholder="Enter the content of the tag">
                        </div>
                    `;
                }
            }
        });
    </script>
    <button type="submit">Add Content</button>

</form>

