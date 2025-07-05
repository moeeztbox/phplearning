<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
// if (!isset($_COOKIE['user'])) {
//     header("Location: Login.php");
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>This is your home page.</p>
    <a href="Logout.php">Logout</a>
</body>
</html>
