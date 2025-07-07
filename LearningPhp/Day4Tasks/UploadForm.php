<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Form</title>
</head>
<body>
    <h1>Upload Image</h1>
    <form method="post" action="UploadImage.php" enctype="multipart/form-data">
        <label>Select Image</label>
        <input type="file" name="image" required>
        <button type="submit" name="submit">Upload</button>
    </form>
    
</body>
</html>