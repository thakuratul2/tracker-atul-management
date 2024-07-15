<?php
include_once ('./common/session.php');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tracker_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Failed to connect to database");
echo "Connected to database successfully";