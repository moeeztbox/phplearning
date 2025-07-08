<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['original_path'])) {
    $originalImage = $_POST['original_path'];
    $extension = strtolower(pathinfo($originalImage, PATHINFO_EXTENSION));

    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($originalImage);
            break;
        case 'png':
            $image = imagecreatefrompng($originalImage);
            break;
        case 'gif':
            $image = imagecreatefromgif($originalImage);
            break;
        case 'webp':
            $image = imagecreatefromwebp($originalImage);
            break;
        default:
            die("Unsupported file type.");
    }

    imagefilter($image, IMG_FILTER_GRAYSCALE);

    $grayDir = "uploads/grayscaleimage/";
    if (!is_dir($grayDir)) {
        mkdir($grayDir, 0777, true);
    }

    $grayPath = $grayDir . 'gray_' . basename($originalImage);

    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($image, $grayPath);
            break;
        case 'png':
            imagepng($image, $grayPath);
            break;
        case 'gif':
            imagegif($image, $grayPath);
            break;
        case 'webp':
            imagewebp($image, $grayPath);
            break;
    }

    imagedestroy($image);
} else {
    die("No image path received.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grayscale Conversion</title>
</head>
<body>
    <h2>Original Image:</h2>
    <img src="<?= htmlspecialchars($originalImage) ?>" width="300"><br><br>

    <h2>Grayscale Image:</h2>
    <img src="<?= htmlspecialchars($grayPath) ?>" width="300"><br><br>

    <a href="Form.php">← Try Another Image</a>
</body>
</html>
