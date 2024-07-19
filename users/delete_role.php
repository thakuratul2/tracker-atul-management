<?php    
include_once ('../connection/db.php');

if(isset($_GET['role_id'])){
    $user_id = $_GET['role_id'];
    

    $sql = "DELETE FROM users_role where role_id = $user_id";
    $result = mysqli_query($conn , $sql);

    if($result){
        header("location: users_role.php");
    }
    else{
        echo "There is Some Error in Deleting the Data";
    }
}