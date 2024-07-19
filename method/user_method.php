<?php 

include_once ('../connection/db.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$salary = $_POST['salary'];
$status = $_POST['status'];
$role = $_POST['role_id'];

$hashed_password = md5($password);

$client_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($client_id) {
    // Update operation
    $update_sql = "UPDATE users SET name = ?, email = ?, password = ?, address = ?, salary = ?, status = ?, role_id = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssii", $name, $email, $hashed_password, $address, $salary, $status, $role, $client_id);

    if ($update_stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $update_stmt->error;
    }
} else {
    // Insert operation
    $check_sql = "SELECT * FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Record already exists";
    } else {
        $insert_sql = "INSERT INTO users (`name`, `email`, `password`, `address`, `salary`, `status`, `role_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssssi", $name, $email, $hashed_password, $address, $salary, $status, $role);

        if ($insert_stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $insert_stmt->error;
        }
    }
}
