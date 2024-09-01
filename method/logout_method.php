<?php 

include_once("../connection/common/session.php");
include_once("../connection/db.php");

if (isset($_SESSION['user_id'])) {
    // Check if there's an active timer (one that has started but not yet stopped)
    $sql = "SELECT timer_id FROM employee_timer_records WHERE end_time IS NULL LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Timer is running, prevent logout
        $_SESSION['error_message'] = 'Error: Timer is running. Please stop the timer before logging out.';
        header('Location: ../dashboard.php'); // Redirect to the dashboard or relevant page
        exit();
    } else {
        // No active timer, proceed with logout
        session_destroy();
        header('Location: ../index.php'); // Redirect to the login page after logout
        exit();
    }
} else {
    header('Location: ../index.php'); // Redirect to login page if not logged in
    exit();
}
