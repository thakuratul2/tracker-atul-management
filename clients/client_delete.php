<?php

include_once ('../connection/db.php');
if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

$query = "DELETE FROM clients WHERE id = $clientId";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Client deleted successfully');</script>";
    header("Location: all_client.php");
    exit();
} else {
    echo "Error deleting client: " . mysqli_error($conn);
}
}

