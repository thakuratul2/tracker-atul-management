<?php 


include_once ('../connection/db.php');

if(isset($_GET['p_id'])){
    $client_id = $_GET['p_id'];
    $delete_sql = "DELETE FROM projects WHERE p_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $client_id);
    if($delete_stmt->execute()){
        header('Location: all_project.php');
    }else{
        echo "Error: " . $delete_stmt->error;
    }
}