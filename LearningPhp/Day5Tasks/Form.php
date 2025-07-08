<?php
$uploadDir = "uploads/originalimage/";
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

$originalImage = '';

if (isset($_POST['upload'])) {
    $fileName = basename($_FILES["image"]["name"]);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $originalImage = $targetFile;
    } else {
        echo "Failed to upload image.";
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

        <form method="post" action="BackgroundRemove.php" style="display: inline-block;">
            <input type="hidden" name="original_path" value="<?= $originalImage ?>">
            <button type="submit" name="remove_bg">Remove Background</button>
        </form>

        <form method="post" action="GrayScale.php" style="display: inline-block;">
            <input type="hidden" name="original_path" value="<?= $originalImage ?>">
            <button type="submit" name="grayscale">Convert to Grayscale</button>
        </form>

        <form method="post" action="PythonBgRemove.php" style="display: inline-block;">
            <input type="hidden" name="original_path" value="<?= $originalImage ?>">
            <button type="submit" name="uploadpython">Remove Background Using Python</button>
        </form>
    <?php endif; ?>
</body>
</html>
