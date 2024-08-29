<?php

include_once('../connection/db.php');

// Get the current system time
$currentTime = date('Y-m-d H:i:s');

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
        $sql = "INSERT INTO employee_timer_records (start_time) VALUES ('$currentTime')";
        
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo json_encode(['success' => true, 'timerId' => $last_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }
    }
} elseif ($action === 'stop') {
    if ($timerId > 0) {
        // Update the end time for the specific timer_id
        $sql = "UPDATE employee_timer_records SET end_time = '$currentTime' WHERE timer_id = $timerId AND end_time IS NULL";
        
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

