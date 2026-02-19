<?php
session_start();
require_once 'config.php';
if (isset($_SESSION['id_cl'])) {
    $id_cl = $_SESSION['id_cl'];
    $sql_count = "SELECT Count(*) AS total_items FROM sous_card sc JOIN card c ON sc.id_pa = c.id_pa WHERE c.id_cl = ?";
    $stmt_count = $db->prepare($sql_count);
    $stmt_count->bind_param("i", $id_cl);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $total_items = $row_count['total_items'] ?? 0;
    echo json_encode($total_items);
} else {
    echo json_encode(0);
}
if (!isset($_SESSION['id_cl'])) 
{
header('Location: ../login.php');

}
?>