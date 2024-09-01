<?php
include_once ('../connection/db.php');


$title = $_POST['title'];
$status = $_POST['status'];
$approved = $_POST['approval_person'];

$task_id = isset($_GET['t_id']) ? $_GET['t_id'] : null;

if ($task_id) {

    $update_sql = "UPDATE tasks SET title = ?, status = ?, approval_person = ? WHERE t_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sisi", $title, $status, $approved, $task_id);

    if ($update_stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $update_stmt->error;
    }
} else {
    echo "Error: Task ID not found";
}