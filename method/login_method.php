<?php
include_once ("../connection/db.php");



if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $password = $_POST['password'];
   
    $sql = "SELECT `name` , `password` FROM `users` WHERE name = '$name' AND password = MD5('$password')";
   
    $result = mysqli_query($conn , $sql);

    $row = mysqli_num_rows($result);
    
    if($row > 0){
         header("location: ../dashboard.php");
    }else{
        header("location: ../index.php");
    }
}
