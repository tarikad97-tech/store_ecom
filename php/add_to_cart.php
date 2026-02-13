
<?php
session_start();


if (!isset($_SESSION['id_cl'])) { 
   
    header("Location: ../login.php");
    exit;
}


if (!isset($_GET['id_pr']) || !is_numeric($_GET['id_pr'])) {
    header("Location: ../index.php");
    exit;
}

$id = (int)$_GET['id_pr'];

if ($id <= 0) {
    header("Location: ../index.php");
    exit;
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

header("Location: ../index.php");
exit;

