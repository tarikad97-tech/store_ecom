<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['id_cl'])) {
    echo "error";
    exit;
}

// Check if ID is provided
if (!isset($_POST['id'])) {
    echo "error";
    exit;
}

$id = $_POST['id'];

// Delete the item from the database
$sql = "DELETE FROM sous_card WHERE id_sdpa = $id";
$result = mysqli_query($db, $sql);

if ($result) {
    echo "success";
} else {
    echo "error";
}
?>