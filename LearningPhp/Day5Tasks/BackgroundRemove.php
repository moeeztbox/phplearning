<?php
$apiKey = 'awDQxRsvCE4tNhxxrg13wr5D';

$outputDir = "uploads/removedbackground/";
if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);

if (isset($_POST['remove_bg']) && isset($_POST['original_path'])) {
    $originalImage = $_POST['original_path'];
    $fileName = basename($originalImage);
    $outputFile = $outputDir . "no-bg-" . $fileName;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.remove.bg/v1.0/removebg');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'image_file' => new CURLFile($originalImage),
        'size' => 'auto'
    ]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-Api-Key: ' . $apiKey
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        exit;
    }

    curl_close($ch);
    file_put_contents($outputFile, $response);
} else {
    echo "No image provided.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Background Removed</title>
</head>
<body>
    <h3>Original Image:</h3>
    <img src="<?= htmlspecialchars($originalImage) ?>" width="300"><br><br>

    <h3>Background Removed Image:</h3>
    <img src="<?= htmlspecialchars($outputFile) ?>" width="300"><br><br>

    <a href="Form.php">Try Another Image</a>
</body>
</html>
