<?php
$uploadDir = "uploads/originalimage/";
$logFile = "logs/app.log";

if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
if (!file_exists(dirname($logFile))) mkdir(dirname($logFile), 0777, true);

function logActivity($message) {
    $timestamp = date("Y-m-d H:i:s");
    $logMessage = "\"$message\" ($timestamp)" . PHP_EOL;
    file_put_contents("logs/app.log", $logMessage, FILE_APPEND);
}

$originalImage = '';

if (isset($_POST['upload'])) {
    $fileName = basename($_FILES["image"]["name"]);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $originalImage = $targetFile;

        $logMsg = "$fileName successfully stored in $uploadDir folder";
        logActivity($logMsg);
    } else {
        echo "Failed to upload image.";
        logActivity("Failed to upload $fileName to $uploadDir");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Background Remover</title>
</head>
<body>
    <h2>Upload an Image</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <button type="submit" name="upload">Upload Image</button>
    </form>

    <?php if ($originalImage): ?>
        <h3>Uploaded Image:</h3>
        <img src="<?= $originalImage ?>" width="300"><br><br>

        <form method="post" action="BackgroundRemove.php">
            <input type="hidden" name="original_path" value="<?= $originalImage ?>">
            <button type="submit" name="remove_bg">Remove Background</button>
        </form>
    <?php endif; ?>
</body>
</html>
