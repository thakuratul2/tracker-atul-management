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


$client_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($client_id) {
    // Update operation
    $update_sql = "UPDATE clients SET name = ?, username = ?, email = ?, password = ?, address = ?, mobile = ?, status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssi", $name, $username, $email, $hashed_password, $address, $mobile, $status, $client_id);

    if ($update_stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $update_stmt->error;
    }
} else {
    // Insert operation
    $check_sql = "SELECT * FROM clients WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Record already exists";
    } else {
        $insert_sql = "INSERT INTO clients (`name`, `username`, `email`, `password`, `address`, `mobile`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssssss", $name, $username, $email, $hashed_password, $address, $mobile, $status);

        if ($insert_stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $insert_stmt->error;
        }
    }
}
