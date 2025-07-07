<?php
$apiKey = 'awDQxRsvCE4tNhxxrg13wr5D'; 

$outputDir = "uploads/removedbackground/";
$logFile = "logs/app.log"; 

if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);
if (!file_exists(dirname($logFile))) mkdir(dirname($logFile), 0777, true);

function logActivity($message) {
    $timestamp = date("Y-m-d H:i:s");
    $formatted = "\"$message\" ($timestamp)" . PHP_EOL;
    file_put_contents("logs/app.log", $formatted, FILE_APPEND);
}

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
        $errorMsg = curl_error($ch);
        echo 'Error: ' . $errorMsg;
        logActivity("Background removal FAILED for $fileName - CURL Error: $errorMsg");
        exit;
    }
    curl_close($ch);

    if (file_put_contents($outputFile, $response)) {
        logActivity("$fileName background removed and saved to $outputDir");
    } else {
        logActivity("Background removal FAILED to save for $fileName in $outputDir");
    }
} else {
    echo "No image provided.";
    logActivity("No image was provided for background removal.");
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
    <img src="<?= $originalImage ?>" width="300"><br><br>

    <h3>Background Removed Image:</h3>
    <img src="<?= $outputFile ?>" width="300"><br><br>

    <a href="Form.php" name="navigate">Try Another Image</a>
</body>
</html>
