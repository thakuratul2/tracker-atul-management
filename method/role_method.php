<?php

include_once('../connection/db.php');
include_once('../connection/common/db_helper.php');


$role = $_POST['userrole'];
$status = $_POST['status'];

$sql = "INSERT INTO `users_role` (`userrole` , `status`) values ('$role' , '$status')";
$result = mysqli_query($conn , $sql);
if($result){
    echo "Success";
}
else{
    echo "no insertion";
}



?>