<?php
include_once ('../connection/db.php');
include_once ('../connection/common/session.php');


$title = $_POST['title'];
$task_start = $_POST['task_start'];
$start_time = $_POST['start_time'];
$task_end = $_POST['task_end'];
$end_time = $_POST['end_time'];
$description = $_POST['description'];
$add_user = $_SESSION['user_name'];
$role_id = $_SESSION['user_role'];

$sql = "INSERT INTO tasks (title, task_start, start_time, task_end, end_time, description, add_user, role_id) VALUES ('$title', '$task_start', '$start_time', '$task_end', '$end_time', '$description', '$add_user', '$role_id')";
$row = mysqli_query($conn, $sql);

if($row){
    echo "Success";
}else{

    echo "Task Not Added";
}