<?php
require_once 'config.php';

if(isset($_POST['fname']) && isset($_POST['email']) && isset($_POST['password'])){
    $fname = $_POST['fname'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql_client = "INSERT INTO client (nom_cl, tel, adresse) VALUES ('$fname', '$telephone', '$adresse')";
    if ($db->query($sql_client) === TRUE) {   
        $id_cl = $db->insert_id;
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $sql_log = "INSERT INTO log (email, passeword, id_cl) VALUES ('$email', '$hashed_password', $id_cl)";
        if ($db->query($sql_log) === TRUE) {
            header('Location: ../login.php');
            exit();
        } else {
            echo "Erreur lors de l'insertion dans log: " . $db->error;
        }
    } else {
        echo "Erreur lors de l'insertion dans client: " . $db->error;
    }
}
?>