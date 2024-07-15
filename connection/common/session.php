<?php 
session_start();

$url = explode('/', $_SERVER['REQUEST_URI']);

$base_url = "{$_SERVER['REQUEST_SCHEME']}://". $_SERVER['HTTP_HOST'] . "/" . $url[1];
if (!isset($_SESSION['User_ID'])) {
    echo "<script>top.location.href = '$base_url'</script>";
}

date_default_timezone_set("Asia/Kolkata");