<?php
    ob_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $response = [];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=car_rental;charset=utf8mb4", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = preg_replace('/\D/', '', $_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = 'customer';

        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $response = ["status" => "error", "message" => "Phone number must be exactly 10 digits."];
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = ["status" => "error", "message" => "Invalid email address."];
        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/", $password)) {
            $response = ["status" => "error", "message" => "Password must contain at least 8 characters including uppercase, lowercase, number, and special character."];
        } else {
            $check = $pdo->prepare("SELECT id FROM users WHERE email = :email OR phone = :phone");
            $check->execute(['email' => $email, 'phone' => $phone]);

            if ($check->rowCount() > 0) {
                $response = ["status" => "error", "message" => "Email or phone already exists."];
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("INSERT INTO users (email, password, role, full_name, phone) VALUES (:email, :password, :role, :full_name, :phone)");
                $insert->execute([
                    'email' => $email,
                    'password' => $hashed,
                    'role' => $role,
                    'full_name' => $full_name,
                    'phone' => $phone
                ]);

                $new_user_id = $pdo->lastInsertId();

                $_SESSION['user'] = [
                    'id' => $new_user_id,
                    'full_name' => $full_name,
                    'role' => $role
                ];

                $response = [
                    "status" => "success",
                    "message" => "Registration successful. You are now logged in.",
                    "full_name" => $full_name,
                    "user_id" => $new_user_id,
                    "role" => $role
                ];
            }
        }
    } catch (PDOException $e) {
        $response = ["status" => "error", "message" => "Lỗi: " . $e->getMessage()];
    }

    echo json_encode($response);
    exit;
?>