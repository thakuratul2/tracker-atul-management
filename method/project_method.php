<?php 

include_once ('../connection/db.php');
$name = $_POST['project_name'];
$start_date = $_POST['project_start'];
$end_date = $_POST['project_end'];
$budget = $_POST['project_budget'];
$type = $_POST['project_type'];
$status = $_POST['status'];
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : null;

if ($p_id) {
    // Update operation
    $update_sql = "UPDATE projects SET project_name = ?, project_start = ?, project_end = ?, project_budget = ?, project_type = ?, status = ? WHERE p_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssdsi", $name, $start_date, $end_date, $budget, $type, $status, $p_id);

    if ($update_stmt->execute()) {
        echo "Success";
    } else {
        echo "Error updating project: " . $update_stmt->error;
    }
} else {
    // Insert operation
    $check_sql = "SELECT * FROM projects WHERE project_name = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $name);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Record already exists";
    } else {
        $insert_sql = "INSERT INTO projects (`project_name`, `project_start`, `project_end`, `project_budget`, `project_type`, `status`) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssds", $name, $start_date, $end_date, $budget, $type, $status);

        if ($insert_stmt->execute()) {
            echo "Success";
        } else {
            echo "Error creating project: " . $insert_stmt->error;
        }
    }
}

// Close statements and connection (optional but good practice)
if ($p_id && isset($update_stmt)) $update_stmt->close();
if (!$p_id && isset($check_stmt)) $check_stmt->close();
if (!$p_id && isset($insert_stmt)) $insert_stmt->close();

