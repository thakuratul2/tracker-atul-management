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
        echo "0";
    }
}

if(function_exists('get_total_clients'))
{
    echo "Function get_total_clients already exists";
}
else
{
    function get_total_clients($conn)
    {
        $sql = "select * from `clients`";
        $result = mysqli_query($conn , $sql);
        $rows = mysqli_num_rows($result);
        if($rows > 0){
            echo $rows;
        }
        else{
            echo "0";
        }
    }
}

if(function_exists('get_difference_client_status'))
{
    echo "Function get_difference_client_statu already exists";
}
else{

    function get_difference_client_status($conn)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $sql_yesterday = "SELECT COUNT(*) as count FROM clients WHERE DATE(created_at) = '$yesterday'";
        $result_yesterday = $conn->query($sql_yesterday);
        $row_yesterday = $result_yesterday->fetch_assoc();
        $clients_yesterday = $row_yesterday['count'];
    
      
        $today = date('Y-m-d');
        $sql_today = "SELECT COUNT(*) as count FROM clients WHERE DATE(created_at) = '$today'";
        $result_today = $conn->query($sql_today);
        $row_today = $result_today->fetch_assoc();
        $clients_today = $row_today['count'];
    
        
        $difference = $clients_today - $clients_yesterday;
        $class = $difference >= 0 ? 'text-success' : 'text-danger';
        $icon = $difference >= 0 ? 'mdi-menu-up' : 'mdi-menu-down';
        $difference_percentage = ($clients_yesterday == 0) ? $difference * 100 : abs(($difference / $clients_yesterday) * 100);
        $difference_text = number_format($difference_percentage, 1);
    
       
        return [
            'class' => $class,
            'icon' => $icon,
            'difference_text' => $difference_text
        ];
    }
}

if(function_exists('get_difference_user_status'))
{
    echo "Function get_difference_client_statu already exists";
}
else{

    function get_difference_user_status($conn)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $sql_yesterday = "SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = '$yesterday'";
        $result_yesterday = $conn->query($sql_yesterday);
        $row_yesterday = $result_yesterday->fetch_assoc();
        $clients_yesterday = $row_yesterday['count'];
    
      
        $today = date('Y-m-d');
        $sql_today = "SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = '$today'";
        $result_today = $conn->query($sql_today);
        $row_today = $result_today->fetch_assoc();
        $clients_today = $row_today['count'];
    
        
        $difference = $clients_today - $clients_yesterday;
        $class = $difference >= 0 ? 'text-success' : 'text-danger';
        $icon = $difference >= 0 ? 'mdi-menu-up' : 'mdi-menu-down';
        $difference_percentage = ($clients_yesterday == 0) ? $difference * 100 : abs(($difference / $clients_yesterday) * 100);
        $difference_text = number_format($difference_percentage, 1);
    
       
        return [
            'class' => $class,
            'icon' => $icon,
            'difference_text' => $difference_text
        ];
    }
}