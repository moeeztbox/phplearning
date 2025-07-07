<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require 'DataBase.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name'], $data['email'])) {
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->execute([
        'name' => $data['name'],
        'email' => $data['email']
    ]);
    echo json_encode(["message" => "User inserted"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>
