<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

if (!isset($_GET['query']) || empty(trim($_GET['query']))) {
    echo json_encode(["error" => "Missing or empty 'query' parameter"]);
    http_response_code(400); 
    exit;
}

$searchTerm = trim($_GET['query']);

try {
    $hostname = 'localhost';
    $database = 'usersdata';
    $username = 'root';
    $password = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$hostname;dbname=$database;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT id, name, email FROM users WHERE name LIKE :search OR email LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$searchTerm%"]);

    $results = $stmt->fetchAll();

    echo json_encode([
        "query" => $searchTerm,
        "results" => $results
    ]); 

} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}
