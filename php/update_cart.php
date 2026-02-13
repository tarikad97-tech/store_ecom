<?php

session_start();
require_once 'config.php';
if (!isset($_SESSION['id_cl'])) {
    header("Location: ../login");
    exit;
}
// udapte_cart qte
if (isset($_POST['id_sdpa']) && isset($_POST['qte'])) {
    $id_sdpa = (int)$_POST['id_sdpa'];
    $qte = (int)$_POST['qte'];

    if ($qte < 1) {
        echo json_encode(['success' => false, 'message' => 'Quantity must be at least 1']);
        exit;
    }

    $sql_update = "UPDATE sous_card SET qte = ? WHERE id_sdpa = ?";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bind_param("ii", $qte, $id_sdpa);
    
    if ($stmt_update->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}


?>