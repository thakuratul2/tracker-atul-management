<?php    
include_once ('../connection/db.php');

if(isset($_GET['id'])){
    $user_id = $_GET['id'];
    

    $sql = "DELETE FROM users where id = $user_id";
    $result = mysqli_query($conn , $sql);

    if($result){
        header("location: all_user.php");
    }
    else{
        echo "There is Some Error in Deleting the Data";
    }
}





?>