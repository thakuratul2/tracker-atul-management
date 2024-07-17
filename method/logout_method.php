<?php 

include_once ("../connection/common/session.php");

if(isset($_SESSION['user_id'])){
    session_destroy();
    header('location:../index.php');
}
else{
    header('location:../index.php');
}