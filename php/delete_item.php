<?php
session_start();
require_once 'config.php';

// Verify user is logged in
if (!isset($_SESSION['id_cl'])) {
    echo "Unauthorized access.";
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id > 0) {
    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM sous_card WHERE id_sdpa = ?";
    $stmt = mysqli_prepare($db, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Item deleted successfully.";
        } else {
            echo "Error: " . mysqli_error($db);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($db);
    }
} else {
    echo "No item ID provided.";
}
?>