<?php
session_start();
require_once 'config.php'; 

// Check if user is logged in
if (!isset($_SESSION['id_cl'])) {
    echo "error: not logged in";
    exit;
}

// Check if ID is provided via POST
if (!isset($_POST['id'])) {
    echo "error: no id provided";
    exit;
}

$id = intval($_POST['id']); 


$sql = "DELETE FROM sous_card WHERE id_sdpa = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "success"; 
    } else {
        echo "error: item not found";
    }
} else {
    echo "error: " . mysqli_error($db);
}

mysqli_stmt_close($stmt);
?>