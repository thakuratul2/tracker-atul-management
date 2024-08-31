<?php
include_once ('../connection/db.php');
include_once ('../connection/common/session.php');

$title = $_POST['title'];
$task_start = $_POST['task_start'];
$start_time = $_POST['start_time'];
$project_type = $_POST['project_type'];  
$task_type = $_POST['task_type'];
$add_user = $_SESSION['user_name'];
$role_id = $_SESSION['user_role'];

$sql = "INSERT INTO tasks (title, task_start, start_time, project_type, task_type, add_user, role_id) VALUES ('$title', '$task_start', '$start_time', '$project_type', '$task_type', '$add_user', '$role_id')";
$row = mysqli_query($conn, $sql);

if($row){
    echo "Success";
}else{
    echo "Task Not Added: " . mysqli_error($conn);  // Add error message for debugging
}
