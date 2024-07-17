<?php
include_once ("../connection/common/session.php");
include_once ("../connection/db.php");

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $password = $_POST['password'];
   
    $sql = "SELECT `email`, `id`, `name`, `password` FROM `users` WHERE name = '$name' AND password = MD5('$password')";
   
    $result = mysqli_query($conn , $sql);

    $user = mysqli_fetch_assoc($result);
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];


    if($user > 0){
         header("location: ../dashboard.php");
    }else{
        header("location: ../index.php");
    }
}
