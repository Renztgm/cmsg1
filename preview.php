<?php 
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to recursively render content within a template
function renderContent($contents, $parentContentId = null) {
    $output = "";
    foreach ($contents as $content) {
        if ($content['parentContentId'] === $parentContentId) {
            // Build style string for this content item
            $contentStyle = '';
            if (!empty($content['width'])) $contentStyle .= 'width: ' . $content['width'] . '; ';
            if (!empty($content['height'])) $contentStyle .= 'height: ' . $content['height'] . '; ';
            if (!empty($content['backgroundColor'])) $contentStyle .= 'background-color: ' . $content['backgroundColor'] . '; ';
            if (!empty($content['fontsize'])) $contentStyle .= 'font-size: ' . $content['fontsize'] . '; ';
            if (!empty($content['fontcolor'])) $contentStyle .= 'color: ' . $content['fontcolor'] . '; ';
            if (!empty($content['fontfamily'])) $contentStyle .= 'font-family: ' . $content['fontfamily'] . '; ';
            if (!empty($content['fontstyle'])) $contentStyle .= 'font-style: ' . $content['fontstyle'] . '; ';
            if (!empty($content['borderValue']) && !empty($content['borderStyle']) && !empty($content['borderColor'])) {
                $contentStyle .= 'border: ' . $content['borderValue'] . ' ' . $content['borderStyle'] . ' #' . $content['borderColor'] . '; ';
            };
            if (!empty($content['margin'])) $contentStyle .= 'margin: ' . $content['margin'] . '; ';
            if (!empty($content['padding'])) $contentStyle .= 'padding: ' . $content['padding'] . '; ';
            // Only add style attribute if we have styles
            $styleAttr = !empty($contentStyle) ? 'style="' . $contentStyle . '"' : '';
            
            // If the content is an image, display it
            if ($content['tag'] === 'image') {
                $output .= '<img src="' . htmlspecialchars($content['imagePath']) . '" alt="Content image" ' . $styleAttr . '/>';
            } else {
                // For anchor tags, add href and target attributes
                $extraAttrs = '';
                if ($content['tag'] === 'a') {
                    $href = !empty($content['href']) ? htmlspecialchars($content['href']) : '#';
                    $target = !empty($content['target']) ? htmlspecialchars($content['target']) : '';
                    $extraAttrs .= ' href="' . $href . '"';
                    if (!empty($target)) {
                        $extraAttrs .= ' target="' . $target . '"';
                    }
                }
                
                $output .= "<{$content['tag']} {$styleAttr}{$extraAttrs}>";
                
                // Output the content text if it exists
                if (!empty($content['text'])) {
                    $output .= htmlspecialchars($content['text']);
                }
                
                // Recursive call for nested children
                $output .= renderContent($contents, $content['contentId']);
                
                $output .= "</{$content['tag']}>";
            }
        }
    }
    return $output;
}


// Function to recursively render templates
function renderTemplates($templates, $contents, $parentTemplateId = null) {
    $output = "";
    

    foreach ($templates as $template) {
        if (
            ($parentTemplateId === null && ($template['parentTemplateId'] === null || $template['parentTemplateId'] === '0' || $template['parentTemplateId'] === 0))
            || ($template['parentTemplateId'] == $parentTemplateId && $parentTemplateId !== null)
        ) {
            // Build template style
            $style = 'style="';
            if (!empty($template['borderValue']) && !empty($template['borderStyle']) && !empty($template['borderColor'])) {
                $style .= 'border: ' . $template['borderValue'] . ' ' . $template['borderStyle'] . ' #' . $template['borderColor'] . '; ';
            }
            $style .= !empty($template['padding']) ? 'padding: ' . $template['padding'] . '; ' : '';
            $style .= !empty($template['margin']) ? 'margin: ' . $template['margin'] . '; ' : '';
            $style .= !empty($template['backgroundColor']) ? 'background-color: ' . $template['backgroundColor'] . '; ' : '';
            $style .= !empty($template['width']) ? 'width: ' . $template['width'] . '; ' : '';
            $style .= !empty($template['height']) ? 'height: ' . $template['height'] . '; ' : '';
            $style .= 'display: flex; ';
            $style .= !empty($template['flexDirection']) ? 'flex-direction: ' . $template['flexDirection'] . '; ' : '';
            $style .= !empty($template['alignItems']) ? 'align-items: ' . $template['alignItems'] . '; ' : '';
            $style .= !empty($template['justifyContent']) ? 'justify-content: ' . $template['justifyContent'] . '; ' : '';
            $style .= 'box-sizing: border-box;"';
            
            // Template container class
            $templateClass = !empty($template['templateType']) ? 'template-' . strtolower($template['templateType']) : 'template-box';
            
            $output .= '<div class="' . $templateClass . '" ' . $style . ' data-template-id="' . $template['templateId'] . '">';
            
            // Add template name/title as a comment for debugging
            $output .= '<!-- Template: ' . htmlspecialchars($template['templateName'] ?? 'Unnamed Template ' . $template['templateId']) . ' -->';
            
            // Get content for this template
            $templateContents = array_filter($contents, function($content) use ($template) {
                return $content['templateId'] == $template['templateId'];
            });
            
            // Render content for this template
            if (!empty($templateContents)) {
                $output .= renderContent($templateContents, null);
            }
            
            // Recursively render child templates
            $output .= renderTemplates($templates, $contents, $template['templateId']);
            
            $output .= '</div>';
        }
    }
    
    return $output;
}

// Main rendering function
function renderPage($pageId) {
    global $conn;
    
    // Fetch all templates for this page
    $templateQuery = "SELECT * FROM templates WHERE pageId = ? ORDER BY orderTemp ASC";
    $stmt = $conn->prepare($templateQuery);
    $stmt->bind_param('i', $pageId);
    $stmt->execute();
    $templateResult = $stmt->get_result();
    
    if ($templateResult && $templateResult->num_rows > 0) {
        $templates = [];
        while ($row = $templateResult->fetch_assoc()) {
            $templates[] = $row;
        }
        
        // Fetch all content for this page's templates
        $templateIds = array_column($templates, 'templateId');
        $placeholders = implode(',', array_fill(0, count($templateIds), '?'));
        
        if (!empty($templateIds)) {
            $contentQuery = "SELECT * FROM contents WHERE templateId IN ($placeholders) ORDER BY orderContent ASC";
            $stmt = $conn->prepare($contentQuery);
            
            // Bind all template IDs as parameters
            $types = str_repeat('i', count($templateIds));
            $stmt->bind_param($types, ...$templateIds);
            $stmt->execute();
            $contentResult = $stmt->get_result();
            
            $contents = [];
            if ($contentResult && $contentResult->num_rows > 0) {
                while ($row = $contentResult->fetch_assoc()) {
                    $contents[] = $row;
                }
            }
            
            // Render top-level templates and their content
            return renderTemplates($templates, $contents, null);
        }
    }
    
    return "<p>No templates found for page ID: $pageId</p>";
}

// The page ID to render
$pageId = isset($_GET['pageId']) ? (int)$_GET['pageId'] : 2; // Default to page ID 2 if not specified

// Output the full HTML page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        a {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }
        .template-navigation a {
            padding: 10px 15px;
            color: #fff;
            font-weight: bold;
        }
        .template-navigation a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <?php echo renderPage($pageId); ?>
</body>
</html>

<?php
$conn->close();
?>