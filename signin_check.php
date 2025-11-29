<?php
    session_start();
    header('Content-Type: application/json');

    $response = ['loggedIn' => false];

    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'customer') {
        $response['loggedIn'] = true;
        $response['full_name'] = $_SESSION['user']['full_name'];
        $response['user_id'] = $_SESSION['user']['id'];
        $response['email'] = $_SESSION['user']['email'];
        $response['role'] = 'customer';
    }

    echo json_encode($response);
?>