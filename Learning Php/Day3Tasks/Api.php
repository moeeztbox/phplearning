<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

$hostname = "localhost";
$username = "root";
$password = "";
$database = "usersdata";

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch all users
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to fetch users: " . $e->getMessage()]);
    }

} elseif ($method === 'POST') {
    // Insert new user
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['name']) || !isset($input['email'])) {
        http_response_code(400);
        echo json_encode(["error" => "Name and email are required"]);
        exit;
    }

    $name = $input['name'];
    $email = $input['email'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email
        ]);

        echo json_encode(["message" => "User created successfully"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to insert user: " . $e->getMessage()]);
    }

} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
$pdo=null;
?>
