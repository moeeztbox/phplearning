<?php
$uploadDir = "uploads/originalimage/";
$outputDir = "uploads/pythonbgremove/";

if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);

$originalImage = '';
$outputFile = '';

if (isset($_POST['uploadpython']) && isset($_POST['original_path'])) {
    $originalImage = $_POST['original_path'];
    $fileName = basename($originalImage);

    $inputPath = realpath($originalImage);
    $outputPath = realpath($outputDir) . DIRECTORY_SEPARATOR . "no-bg-" . $fileName;

    $rembgExe = '"C:\\Users\\MOEEZ JAMIL\\AppData\\Local\\Programs\\Python\\Python312\\Scripts\\rembg.exe"';
    $command = $rembgExe . " i " . escapeshellarg($inputPath) . " " . escapeshellarg($outputPath);
    $output = shell_exec($command);

    if (file_exists($outputPath)) {
        $outputFile = "uploads/pythonbgremove/no-bg-" . $fileName;
    } else {
        echo "<p style='color:red;'>Background removal failed using rembg.</p>";
    }
} else {
    echo "<p style='color:red;'>No image received.</p>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Background Removed Using Python</title></head>
<body>
    <h3>Original Image:</h3>
    <img src="<?= htmlspecialchars($originalImage) ?>" width="300"><br><br>

    <h3>Background Removed Image:</h3>
    <img src="<?= htmlspecialchars($outputFile) ?>" width="300"><br><br>
<a href="Form.php">← Try Another Image</a>
</body>
</html>
