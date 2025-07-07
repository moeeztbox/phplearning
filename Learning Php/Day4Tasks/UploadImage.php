<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "usersdata";
$charset  = "utf8mb4";

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=$charset", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<p style='color: green;'>Image uploaded successfully.</p>";
}

$allowedMimeTypes = ['image/jpeg','image/jpg', 'image/png', 'image/gif', 'image/webp'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $file     = $_FILES['image'];
        $filename = basename($file['name']);
        $tmpPath  = $file['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimeTypes)) {
            echo "<p style='color: red;'>File type not allowed: $mimeType</p>";
            exit;
        }

        $uploadPath = 'uploads/' . $filename;
        if (move_uploaded_file($tmpPath, $uploadPath)) {
            $stmt = $pdo->prepare("INSERT INTO images (file_path) VALUES (:file_path)");
            $stmt->execute(['file_path' => $uploadPath]);
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <label>Select an image:</label>
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>

<?php
$stmt   = $pdo->query("SELECT * FROM images");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($images) > 0): ?>
    <h2>Uploaded Images</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Path</th>
        </tr>
        <?php foreach ($images as $image): ?>
            <tr>
                <td><?= htmlspecialchars($image['id']) ?></td>
                <td><img src="<?= htmlspecialchars($image['file_path']) ?>" width="100"></td>
                <td><?= htmlspecialchars($image['file_path']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No images found.</p>
<?php endif; ?>
<?php $pdo = null; ?>
