<?php
require_once 'config.php';

$fname=$_POST['fname'];
$adresse=$_POST['adresse'];
$telephone=$_POST['telephone'];
$email=$_POST['email'];
$password=$_POST['password'];


// CREATE TABLE client (
//   id_cl INT NOT NULL AUTO_INCREMENT,
//   nom_cl VARCHAR(255) NOT NULL,
//   tel VARCHAR(30) NOT NULL,           -- mieux que INT (peut contenir +212, espaces, etc.)
//   adresse VARCHAR(255) NOT NULL,
//   PRIMARY KEY (id_cl)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

// -- =========================
// -- TABLE: log (auth)
// -- =========================
// CREATE TABLE log (
//   id_log INT NOT NULL AUTO_INCREMENT,
//   email VARCHAR(255) NOT NULL,
//   passeword VARCHAR(255) NOT NULL,    -- en pratique: hash (bcrypt) => 60+ chars
//   id_cl INT NOT NULL,
//   PRIMARY KEY (id_log),
//   UNIQUE KEY uq_log_email (email),
//   KEY idx_log_client (id_cl),
//   CONSTRAINT fk_log_client
//     FOREIGN KEY (id_cl) REFERENCES client(id_cl)
//     ON UPDATE CASCADE
//     ON DELETE CASCADE
// )


// Insérer le client
$sql_client = "INSERT INTO client (nom_cl, tel, adresse) VALUES ('$fname', '$telephone', '$adresse')";
if ($db->query($sql_client) === TRUE) {   
    $id_cl = $db->insert_id;  // Récupérer l'ID du client inséré
   $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    // Insérer les infos de connexion
    $sql_log = "INSERT INTO log (email, passeword, id_cl) VALUES ('$email', '$hashed_password', $id_cl)";
    if ($db->query($sql_log) === TRUE) {
        // Succès: rediriger vers la page de login
        header('Location: ../login.php');
        exit();
    } else {
        echo "Erreur lors de l'insertion dans log: " . $db->error;
    }
} else {
    echo "Erreur lors de l'insertion dans client: " . $db->error;
}
?>