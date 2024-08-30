<?php

include_once('../connection/db.php');
include_once('../connection/common/db_helper.php');

// Get the current system time
$currentTime = date('Y-m-d H:i:s');
$user_id = get_user_get_id(); // Retrieve the user ID from the session

$action = isset($_GET['action']) ? $_GET['action'] : '';
$timerId = isset($_GET['timer_id']) ? intval($_GET['timer_id']) : 0;

if ($action === 'start') {
    // Check if there's an active timer (one that has started but not yet stopped)
    $sql = "SELECT timer_id FROM employee_timer_records WHERE end_time IS NULL AND user_id = $user_id LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Timer already exists, return existing timer_id
        $row = $result->fetch_assoc();
        $existingTimerId = $row['timer_id'];
        echo json_encode(['success' => true, 'timerId' => $existingTimerId]);
    } else {
        // Insert a new record for the start time with end_time as NULL and user_id
        $sql = "INSERT INTO employee_timer_records (start_time, end_time, user_id, created_at) VALUES (NOW(), NULL, $user_id, '$currentTime')";
        
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo json_encode(['success' => true, 'timerId' => $last_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }
    }
} elseif ($action === 'stop') {
    if ($timerId > 0) {
        // Calculate the duration
        $sql = "SELECT start_time FROM employee_timer_records WHERE timer_id = $timerId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $start_time = $row['start_time'];
            $duration = strtotime($currentTime) - strtotime($start_time);

            // Update the end time, duration, and updated_at for the specific timer_id
            $sql = "UPDATE employee_timer_records 
                    SET end_time = '$currentTime', duration = $duration, updated_at = '$currentTime' 
                    WHERE timer_id = $timerId AND end_time IS NULL";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid timer_id']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

