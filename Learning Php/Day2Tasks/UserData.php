<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Insert</title>
</head>
<body>
    <h1>Please Insert Your Data</h1>
    <form method="post">
        <label>Name</label>
        <input type="text" name="name" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <button type="submit" name="submit">Insert</button>
    </form>

    <?php

    $host = "localhost";
    $db = "usersdata";
    $user = "root";
    $pass = "";
    $charset = "utf8mb4";
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected to the Database Successfully<br>";
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];

        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute([
            'name' => $name,
            'email' => $email
        ]);

        echo "Data Inserted Successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if (count($users) > 0): ?>
        <h2>All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($users as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
    <?php $pdo=null; ?>
    
</body>
</html>
