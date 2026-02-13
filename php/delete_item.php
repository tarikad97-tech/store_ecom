<?php
require_once 'config.php';

$id = intval($_POST['id'] ?? 0);

if ($id > 0) {
    $sql = "DELETE FROM sous_card WHERE id_sdpa = $id";
    if ($db->query($sql)) {
        echo "Item deleted successfully.";
    } else {
        echo "Error: " . $db->error;
    }
} else {
    echo "No item ID provided.";
}
?>