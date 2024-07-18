<?php 

include_once ('../connection/db.php');

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$mobile = $_POST['mobile'];
$status = $_POST['status'];

$hashed_password = md5($password);

// Check if the record already exists
$check_sql = "SELECT * FROM clients WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "Record already exists";
} else {
    $check_user_sql = "SELECT * FROM users WHERE email = ?";
    $check_user_stmt = $conn->prepare($check_user_sql);
    $check_user_stmt->bind_param("s", $email);
    $check_user_stmt->execute();
    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows > 0) {
        echo "Email already exists in user table";
    } else {
        $insert_sql = "INSERT INTO clients (`name`, `username`, `email`, `password`, `address`, `mobile`, `status`) VALUES ('$name', '$username', '$email', '$password', '$address', '$mobile', '$status')";
        $insert_stmt = $conn->prepare($insert_sql);

        if ($insert_stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $insert_stmt->error;
        }
    }
}
