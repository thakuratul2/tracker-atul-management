<?php 
include_once ("session.php");

/*

This is the db helper where we write all common sql here


*/


if(function_exists('get_user_get_id')) {
    echo "Function get_user_get_id already exists";
} else {
    function get_user_get_id()
    {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return false;
        }
    }
}

function user_login(){

    if (isset($_SESSION['user_id'])) {
        header("Location: ./dashboard.php");
        exit;
      }
}

function user_not_login(){

    if (!isset($_SESSION['user_id'])) {
        header("Location: ./index.php");
        exit;
      }
}



function greetfunction(){
    $time = date('H');
    if($time >= 5 && $time <= 11){
        echo "Good Morning";
    }
    else if($time >= 12 && $time <= 18){
        echo "Good Afternoon";
    }
    else if($time >= 19 && $time <= 4){
        echo "Good Evening";
    }
}


function totalusers($conn){

    $sql = "select * from `users`";
    $result = mysqli_query($conn , $sql);
    $rows = mysqli_num_rows($result);
    if($rows > 0){
        echo $rows;
    }
    else{
        echo "No User";
    }
}