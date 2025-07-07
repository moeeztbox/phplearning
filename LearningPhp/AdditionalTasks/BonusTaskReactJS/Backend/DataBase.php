<?php
$hostname = "localhost";
$database = "usersdata";
$username = "root";
$password = "";
$charset = "utf8mb4";
$dsn = "mysql:host=$hostname;dbname=$database;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}
?>
