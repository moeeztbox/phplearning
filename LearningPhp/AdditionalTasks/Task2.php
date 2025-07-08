<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

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
    echo json_encode([
        "status" => 500,
        "error" => "Database connection failed",
        "details" => $e->getMessage()
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        try {
            $stmt = $pdo->query("SELECT * FROM users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                "status" => 200,
                "message" => "Users fetched successfully",
                "data" => $users
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => 500,
                "error" => "Failed to fetch users",
                "details" => $e->getMessage()
            ]);
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        if (empty($input['name']) || empty($input['email'])) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "error" => "Name and email are required"
            ]);
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
            $stmt->execute([
                ':name' => $input['name'],
                ':email' => $input['email']
            ]);

            http_response_code(201);
            echo json_encode([
                "status" => 201,
                "message" => "User created successfully"
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => 500,
                "error" => "Failed to insert user",
                "details" => $e->getMessage()
            ]);
        }
        break;

    case 'PUT':
        parse_str($_SERVER['QUERY_STRING'], $query);
        $id = $query['id'] ?? null;
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "error" => "User ID is required"
            ]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingUser) {
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "error" => "User not found"
            ]);
            exit;
        }

        $fields = [];
        $params = [':id' => $id];

        if (!empty($input['name'])) {
            $fields[] = "name = :name";
            $params[':name'] = $input['name'];
        }

        if (!empty($input['email'])) {
            $fields[] = "email = :email";
            $params[':email'] = $input['email'];
        }

        if (empty($fields)) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "error" => "Nothing to update. Provide name or email."
            ]);
            exit;
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            echo json_encode([
                "status" => 200,
                "message" => $stmt->rowCount() > 0
                    ? "User updated successfully"
                    : "No changes made (same values)"
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => 500,
                "error" => "Failed to update user",
                "details" => $e->getMessage()
            ]);
        }
        break;

    case 'DELETE':
        parse_str($_SERVER['QUERY_STRING'], $query);
        $id = $query['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "error" => "User ID is required"
            ]);
            exit;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode([
                    "status" => 404,
                    "message" => "User not found or already deleted"
                ]);
            } else {
                echo json_encode([
                    "status" => 200,
                    "message" => "User deleted successfully"
                ]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => 500,
                "error" => "Failed to delete user",
                "details" => $e->getMessage()
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            "status" => 405,
            "error" => "Method not allowed"
        ]);
        break;
}

$pdo = null;
