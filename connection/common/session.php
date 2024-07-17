<?php 
session_start();

$url = explode('/', $_SERVER['REQUEST_URI']);

$base_url = "{$_SERVER['REQUEST_SCHEME']}://". $_SERVER['HTTP_HOST'] . "/" . $url[1];


date_default_timezone_set("Asia/Kolkata");