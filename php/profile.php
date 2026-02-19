<!--<?php
include '../navbar';
  ?>
     <?php

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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];

    // تحقق من القيم
    if(empty($name) || empty($email) || empty($phone) || empty($address)){
        die("All fields are required.");
    }

    // تحقق من أن الإيميل الجديد ما مكرر عند مستخدم آخر
    $stmt_check = $db->prepare("SELECT id_cl FROM log WHERE email = ? AND id_cl != ?");
    $stmt_check->bind_param("si", $email, $id_cl);
    $stmt_check->execute();
    $stmt_check->store_result();

    if($stmt_check->num_rows > 0){
        echo "Email already in use by another account.";
    } else {
        // تحديث client
        $stmt1 = $db->prepare("UPDATE client SET nom_cl = ?, tel = ?, adresse = ? WHERE id_cl = ?");
        $stmt1->bind_param("sssi", $name, $phone, $address, $id_cl);
        $stmt1->execute();

        // تحديث log (email)
        $stmt2 = $db->prepare("UPDATE log SET email = ? WHERE id_cl = ?");
        $stmt2->bind_param("si", $email, $id_cl);
        $stmt2->execute();

        echo "<div class='alert alert-success'>Profile updated successfully!</div>";

        // تحديث session إذا تغير الايميل
        $_SESSION['email'] = $email;
    }
}
?>


?>

<h1 class="text-center">Welcome, <?php echo htmlspecialchars($user['nom_cl']); ?>!</h1>

<div class="container mt-4 text-center">
    <form action="../profile">
    <h5>Full Name: <?php echo htmlspecialchars($user['nom_cl']); ?></h5>
    <h5>Telephone: <?php echo htmlspecialchars($user['tel']); ?></h5>
    <h5>Adresse: <?php echo htmlspecialchars($user['adresse']); ?></h5>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </form>
</div> 
    

        <!-- <?php
include '../footer';
  ?>  -->