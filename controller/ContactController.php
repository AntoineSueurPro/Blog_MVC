<?php
namespace controller;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactController {

    public function index() {

        if(!empty($_POST)) {
            $email = htmlspecialchars($_POST['email']);
            $nom = htmlspecialchars($_POST['nom']);
            $objet = htmlspecialchars($_POST['objet']);
            $message = htmlspecialchars(stripslashes(trim($_POST['message'])));
            $error = 0;

            if (!isset($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error++;
                $_SESSION['error']['email'] = "L'email n'est pas valide";
            }

            if (!isset($_POST['nom']) || strlen($nom) < 2) {
                $error++;
                $_SESSION['error']['nom'] = "Le nom doit contenir au moins 2 caractères";
            }

            if (!isset($_POST['message']) || strlen($message) < 1) {
                $error++;
                $_SESSION['error']['message'] = "Le message ne doit pas être vide";
            }

            if (!isset($erreur)) {

                $mail = new PHPMailer(true);

                try {

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'antoine.sueur17@gmail.com';
                    $mail->Password = 'jydvkacwasjejunz';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom($email, $nom);
                    $mail->addReplyTo($email, $nom);
                    $mail->addAddress('antoine.sueur17@gmail.com', 'Antoine Sueur');


                    $mail->isHTML(true);
                    $mail->Subject = $objet;
                    $mail->Body = $message;
                    $mail->AltBody = $message;
                    $mail->SMTPDebug = 0;

                    if ($mail->send()) {
                        $_SESSION['info'] = "L'email a bien été envoyé. Merci !";
                    } else {
                        $_SESSION['error']['envoi'] = "Erreur dans l'envoi du mail";
                    }
                } catch (Exception $e) {
                    $error = $e;
                }
            }

        }
        require('views/contact.view.php');
    }
}