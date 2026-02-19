<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['id_cl'])) {
    header('Location: ../login.php');
    exit();
}

$id_cl = $_SESSION['id_cl'];

$stmt = $db->prepare("SELECT nom_cl, tel, adresse FROM client WHERE id_cl = ?");
$stmt->bind_param("i", $id_cl);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
<h1 class="text-center">Welcome, <?php echo htmlspecialchars($user['nom_cl']); ?>!</h1>

<div class="container mt-4 text-center">
    <form action="../profile">
    <h5>Full Name: <?php echo htmlspecialchars($user['nom_cl']); ?></h5>
    <h5>Telephone: <?php echo htmlspecialchars($user['tel']); ?></h5>
    <h5>Adresse: <?php echo htmlspecialchars($user['adresse']); ?></h5>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </form>
</div>
    
</body>
</html>