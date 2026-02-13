<?php
require_once 'config.php';

$email=$_POST['email'];
$password=$_POST['password'];

$sql = "SELECT * FROM log WHERE email='$email'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $password_hash = $row['passeword'];
    
    if (password_verify($password, $password_hash)) {
        // Authentification réussie
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['id_cl'] = $row['id_cl'];
        header('Location: ../index.php');
        exit();
    } else {
        // Mot de passe incorrect
        echo "Mot de passe incorrect.";
    }
} else {
    // Email non trouvé
    echo "Email non trouvé.";
}


?>