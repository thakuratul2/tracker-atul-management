<?php
include_once ('../connection/db.php');



//project type added code

$project_type_name = $_POST['project_type'];
$status = $_POST['status'];

// Check if the record already exists
$check_sql = "SELECT * FROM project_type WHERE project_type = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $project_type_name);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "Record already exists";
} else {
    
    $insert_sql = "INSERT INTO project_type (`project_type`, `status`) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sd", $project_type_name, $status);

    if ($insert_stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $insert_stmt->error;
    }
}