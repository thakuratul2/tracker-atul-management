<?php 

include_once ('../connection/db.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$salary = $_POST['salary'];
$status = $_POST['status'];

$hashed_password = md5($password);

// Check if the record already exists
$check_sql = "SELECT * FROM users WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "Record already exists";
} else {
    
    $insert_sql = "INSERT INTO users (name, email, password, address, salary, status) VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ssssds", $name, $email, $hashed_password, $address, $salary, $status);

    if ($insert_stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $insert_stmt->error;
    }
}