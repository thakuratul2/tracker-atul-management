<?php 

include_once ('../connection/db.php');

if($_GET['t_id'])
{
    try {
        $t_id = $_GET['t_id'];
       
        $sql = "DELETE FROM tasks where t_id = '$t_id'";

       $result = mysqli_query($conn, $sql);

       if($result){
           header('location: all_task.php');
       }else{  
              echo "Error: " . $sql . "<br>" . $conn->error;
         }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}