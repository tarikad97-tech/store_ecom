<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$fname=$_POST['fname'];
$email=$_POST['email'];

$message=$_POST['message'];
try {
    // Configuration SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'elkoubaiadnane2004@gmail.com';
    $mail->Password   = 'axyn tuwt lqsm ykoz';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Expéditeur
    $mail->setFrom($email, $fname);

    // Destinataire
    $mail->addAddress('elkoubaiadnane2004@gmail.com', $fname);

    // Contenu
    $mail->isHTML(true);
    
    $mail->Body    = $message;
    $mail->AltBody = 'Email envoyé avec PHPMailer';

    $mail->send();
    // echo "message envoye";
    header('location: ../contact.php?status=1');
} catch (Exception $e) {
    // echo "Erreur : {$mail->ErrorInfo}";
    header('location: ../contact.php?status=0');

}
?>


<!-- composer require phpmailer/phpmailer -->