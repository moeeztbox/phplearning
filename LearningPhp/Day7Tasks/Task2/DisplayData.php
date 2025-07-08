<?php

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

$url = "http://localhost/LearningPhp/Day7Tasks/Task2/GetData.php?page=$page&limit=$limit";

$response = file_get_contents($url);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Paginated Users</title>
</head>
<body>
    <h2>Users - Page <?= $page ?></h2>

    <?php if (!empty($data['results'])): ?>
        <ul>
            <?php foreach ($data['results'] as $user): ?>
                <li>
                    <strong><?= htmlspecialchars($user['name']) ?></strong> (<?= htmlspecialchars($user['email']) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
    <div>
        <a href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>" <?= ($page <= 1 ? 'style="display:none;"' : '') ?>>Previous</a>
        <a href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">Next</a>
    </div>
</body>
</html>
