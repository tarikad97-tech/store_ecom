<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['id_cl'])) {
    header("Location: ../login");
    exit;
}

if (!isset($_GET['id_pr']) || !is_numeric($_GET['id_pr'])) {
   echo "<script>
        // alert('Produit ajouté au panier');
        window.history.go(-1);
      </script>";
    exit;
}

$id_pr = (int)$_GET['id_pr'];
$id_cl = $_SESSION['id_cl'];

$sql_card = "SELECT id_pa FROM card WHERE id_cl = ?";
$stmt = $db->prepare($sql_card);
$stmt->bind_param("i", $id_cl);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $card = $result->fetch_assoc();
    $id_pa = $card['id_pa'];
} else {
    $sql_insert_card = "INSERT INTO card (id_cl) VALUES (?)";
    $stmt_insert = $db->prepare($sql_insert_card);
    $stmt_insert->bind_param("i", $id_cl);
    $stmt_insert->execute();
    $id_pa = $stmt_insert->insert_id;
}

$sql_sous = "SELECT id_sdpa, qte FROM sous_card WHERE id_pa = ? AND id_pr = ?";
$stmt_sous = $db->prepare($sql_sous);
$stmt_sous->bind_param("ii", $id_pa, $id_pr);
$stmt_sous->execute();
$result_sous = $stmt_sous->get_result();

if ($result_sous->num_rows > 0) {
    $sous = $result_sous->fetch_assoc();
    $new_qty = $sous['qte'] + 1;
    $sql_update = "UPDATE sous_card SET qte = ? WHERE id_sdpa = ?";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->bind_param("ii", $new_qty, $sous['id_sdpa']);
    $stmt_update->execute();
} else {
    $sql_insert_sous = "INSERT INTO sous_card (id_pa, id_pr, qte) VALUES (?, ?, 1)";
    $stmt_insert_sous = $db->prepare($sql_insert_sous);
    $stmt_insert_sous->bind_param("ii", $id_pa, $id_pr);
    $stmt_insert_sous->execute();
}   

echo "<script>
        // alert('Produit ajouté au panier');
        window.history.go(-1);
      </script>";
exit;
?>
