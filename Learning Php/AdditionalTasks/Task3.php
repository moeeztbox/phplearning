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
    sendError(500, "Database connection failed", $e->getMessage());
}

function sendError($status, $error, $details = null) {
    http_response_code($status);
    $response = ["status" => $status, "error" => $error];
    if ($details) $response["details"] = $details;
    echo json_encode($response);
    exit;
}

function validateUserInput($input, $required = ['name', 'email']) {
    $errors = [];

    foreach ($required as $field) {
        if (empty($input[$field])) {
            $errors[] = ucfirst($field) . " is required.";
        }
    }

    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid.";
    }

    return $errors;
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
            sendError(500, "Failed to fetch users", $e->getMessage());
        }
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        $errors = validateUserInput($input);

        if (!empty($errors)) {
            sendError(400, $errors);
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
            sendError(500, "Failed to insert user", $e->getMessage());
        }
        break;

    case 'PUT':
        parse_str($_SERVER['QUERY_STRING'], $query);
        $id = $query['id'] ?? null;
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$id) {
            sendError(400, "User ID is required");
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingUser) {
            sendError(404, "User not found");
        }

        $fields = [];
        $params = [':id' => $id];

        if (!empty($input['name'])) {
            $fields[] = "name = :name";
            $params[':name'] = $input['name'];
        }

        if (!empty($input['email'])) {
            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                sendError(400, "Email format is invalid.");
            }
            $fields[] = "email = :email";
            $params[':email'] = $input['email'];
        }

        if (empty($fields)) {
            sendError(400, "Nothing to update. Provide name or email.");
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            echo json_encode([
                "status" => 200,
                "message" => $stmt->rowCount() > 0 ? "User updated successfully" : "No changes made (same values)"
            ]);
        } catch (PDOException $e) {
            sendError(500, "Failed to update user", $e->getMessage());
        }
        break;

    case 'DELETE':
        parse_str($_SERVER['QUERY_STRING'], $query);
        $id = $query['id'] ?? null;

        if (!$id) {
            sendError(400, "User ID is required");
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);

            echo json_encode([
                "status" => $stmt->rowCount() > 0 ? 200 : 404,
                "message" => $stmt->rowCount() > 0 ? "User deleted successfully" : "User not found or already deleted"
            ]);
        } catch (PDOException $e) {
            sendError(500, "Failed to delete user", $e->getMessage());
        }
        break;

    default:
        sendError(405, "Method not allowed");
        break;
}

$pdo = null;
