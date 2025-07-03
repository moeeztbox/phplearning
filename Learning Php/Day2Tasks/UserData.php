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
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "usersdata";

    $connection = mysqli_connect($servername, $username, $password, $database);
    if (!$connection) {
        die("Connection Failed");
    }
    echo "Connected to the DataBase SuccessFully<br>";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];

        $data = "INSERT INTO users (name, email) VALUES ('$name', '$email')";

        if (mysqli_query($connection, $data)) {
            echo "Data Inserted Successfully";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }

    $result = mysqli_query($connection, "SELECT * FROM users");

    if (mysqli_num_rows($result) > 0): ?>
        <h2>All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</body>
</html>
