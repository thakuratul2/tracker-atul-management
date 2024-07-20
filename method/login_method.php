<?php
include_once ("../connection/common/session.php");
include_once ("../connection/db.php");

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $password = $_POST['password'];
   
    $sql = "SELECT `email`, `id`, `name`, `password`, `status` FROM `users` WHERE name = '$name' AND password = MD5('$password')";
   
    $result = mysqli_query($conn , $sql);

    $user = mysqli_fetch_assoc($result);
    
    if($user > 0){
        if($user['status'] == 1){
            header("location: ../index.php");
        }else{
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("location: ../dashboard.php");
        }
    }else{
        $sql = "SELECT `email`, `id`, `username`, `password` FROM `clients` WHERE username = '$name' AND password = MD5('$password')";
        $result = mysqli_query($conn , $sql);
        $client = mysqli_fetch_assoc($result);
        
        if($client > 0){
            $_SESSION['user_id'] = $client['id'];
            $_SESSION['user_name'] = $client['username'];
            $_SESSION['user_email'] = $client['email'];

            header("location: ../dashboard.php");

        }else{
            header("location: ../index.php");
        }
    }
}
