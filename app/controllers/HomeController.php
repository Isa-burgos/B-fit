<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class HomeController{
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mail = new PHPMailer(true);
        
        try{
            $mail->isSMTP();
            $mail->Host = 'maildev';
            $mail->Port = 1025;
            $mail->SMTPAuth = false;
        
            $mail->setFrom('webmaster@example.com', 'Webmaster');
            $mail->addAddress('i.burgos.sabelle@gmail.com');
        
            $mail->isHTML(false);
            $mail->Subject = 'Nouveau message du formulaire de contact';
            $mail->Body = "Nom : " . ($_POST["name"] ?? '') . "\n" .
                            "Email : " . ($_POST["email"] ?? '') . "\n" .
                            "Téléphone : " . ($_POST["phone"] ?? '') . "\n" .
                            "Message : " . ($_POST["message"] ?? '');
        
                $mail->send();

        } catch(Exception $e) {
            echo 'Erreur lors de l’envoi du message : ' .$e->getMessage();
        }
    }
    include '../app/views/home.php';

    }
}


