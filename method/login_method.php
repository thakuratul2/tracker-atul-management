<?php
include_once("../connection/common/session.php");
include_once("../connection/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // First check in users table
    $sql = "SELECT `email`, `id`, `name`, `role_id`, `password`, `status` FROM `users` WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            if ($user['status'] == 1) {
                // User inactive or blocked
                echo json_encode(['success' => false, 'message' => 'Your account is inactive. Please contact support.']);
            } else {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role_id'];

                echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
            }
        } else {
            // Password incorrect
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
        }
    } else {
        // Check in clients table
        $sql = "SELECT `email`, `id`, `username`, `password` FROM `clients` WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $client = mysqli_fetch_assoc($result);

        if ($client && password_verify($password, $client['password'])) {
            
            // Set session variables for client
            $_SESSION['user_id'] = $client['id'];
            
            $_SESSION['user_name'] = $client['username'];
            
            $_SESSION['user_email'] = $client['email'];

            echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
        } else {
            
            // Invalid email or password
            if ($client) {
                // Email exists but password is incorrect
                echo json_encode(['success' => false, 'message' => 'Incorrect password']);
            } else {
                // Email does not exist
                echo json_encode(['success' => false, 'message' => 'Invalid email']);
            }
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

