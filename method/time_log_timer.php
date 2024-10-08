<?php

include_once('../connection/db.php');
include_once('../connection/common/db_helper.php');

// Get the current system time
$currentTime = date('Y-m-d H:i:s');

//send the userid when the timer is running
$user_id = get_user_get_id();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$timerId = isset($_GET['timer_id']) ? intval($_GET['timer_id']) : 0;

if ($action === 'start') {
    // Check if there's an active timer (one that has started but not yet stopped)
    $sql = "SELECT timer_id FROM employee_timer_records WHERE end_time IS NULL LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Timer already exists, return existing timer_id
        $row = $result->fetch_assoc();
        $existingTimerId = $row['timer_id'];
        echo json_encode(['success' => true, 'timerId' => $existingTimerId]);
    } else {
        // Insert a new record for the start time
        $sql = "INSERT INTO employee_timer_records (user_id, start_time, end_time, duration) VALUES ($user_id, NOW(), null, null)";
        
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo json_encode(['success' => true, 'timerId' => $last_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }
    }
} elseif ($action === 'stop') {
    if ($timerId > 0) {
        // Calculate the duration between start_time and NOW()
        $sql = "UPDATE employee_timer_records 
                SET end_time = NOW(), 
                    duration = TIMEDIFF(NOW(), start_time) 
                WHERE timer_id = $timerId AND end_time IS NULL";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid timer_id']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

?>
