<?php
include_once('../connection/db.php');
include_once('../connection/common/session.php');

$title = $_POST['title'] ?? '';
$task_start = $_POST['task_start'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$project_type = $_POST['project_type'] ?? '';
$task_type = $_POST['task_type'] ?? '';
$task_used_time = $_POST['task_used_time'] ?? ''; 
$add_user = $_SESSION['user_name'] ?? '';
$role_id = $_SESSION['user_role'] ?? '';
$task_id = $_POST['task_id'] ?? '';

if (empty($task_used_time)) {
    // Insert new task
    $sql = "INSERT INTO tasks (title, task_start, start_time, project_type, task_type, add_user, role_id) 
            VALUES ('$title', '$task_start', '$start_time', '$project_type', '$task_type', '$add_user', '$role_id')";

    $row = mysqli_query($conn, $sql);

    if ($row) {
        echo "Task Inserted Successfully";
    } else {
        echo "Task Not Added: " . mysqli_error($conn);
    }
} else {
    // Update existing task
    if (empty($task_id)) {
        echo "Task ID is required for updating.";
        exit();
    }

    // Fetch existing task_used_time
    $sql = "SELECT task_used_time FROM tasks WHERE t_id = '$task_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $existing_time = $row['task_used_time'];
        
        // Convert existing and new times to total seconds
        $existing_seconds = convertToSeconds($existing_time);
        $new_seconds = convertToSeconds($task_used_time);

        // Add new time to existing time
        $total_seconds = $existing_seconds + $new_seconds;
        $total_time = convertToTimeFormat($total_seconds);

        // Update the task with the new time
        $sql = "UPDATE tasks SET task_used_time = '$total_time' WHERE t_id = '$task_id'";
        $update_result = mysqli_query($conn, $sql);

        if ($update_result) {
            echo "Task Updated Successfully";
        } else {
            echo "Task Not Updated: " . mysqli_error($conn);
        }
    } else {
        echo "Task not found.";
    }
}

function convertToSeconds($time) {
    list($hours, $minutes, $seconds) = explode(':', $time);
    return ($hours * 3600) + ($minutes * 60) + $seconds;
}


function convertToTimeFormat($seconds) {
    $hours = str_pad(floor($seconds / 3600), 2, '0', STR_PAD_LEFT);
    $minutes = str_pad(floor(($seconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
    $seconds = str_pad($seconds % 60, 2, '0', STR_PAD_LEFT);
    return "$hours:$minutes:$seconds";
}

