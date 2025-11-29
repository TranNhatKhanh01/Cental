<?php
    session_start();
    header('Content-Type: application/json');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "car_rental";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Database connection failed."]);
        exit;
    }

    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($login) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all fields."]);
        exit;
    }

    $sql = "SELECT * FROM users WHERE (email = ? OR phone = ?) AND role = 'customer' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        echo json_encode(["status" => "error", "message" => "Account not found."]);
        exit;
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        echo json_encode(["status" => "error", "message" => "Incorrect password."]);
        exit;
    }

    $_SESSION['user'] = [
        'id' => $user['id'],
        'full_name' => $user['full_name'],
        'email' => $user['email'],
        'role' => $user['role']
    ];

    echo json_encode([
        "status" => "success",
        "full_name" => $user['full_name'],
        "user_id" => $user['id'],
        "role" => $user['role']
    ]);
?>
