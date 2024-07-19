<?php    
include_once ('../connection/db.php');

if(isset($_GET['p_type'])){
    $user_id = $_GET['p_type'];
    

    $sql = "DELETE FROM project_type where p_type = $user_id";
    $result = mysqli_query($conn , $sql);

    if($result){
        header("location: project_type.php");
    }
    else{
        echo "There is Some Error in Deleting the Data";
    }
}