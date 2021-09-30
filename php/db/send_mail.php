<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require "../../mail/src/Exception.php";
    require '../../mail/src/PHPMailer.php';
    require '../../mail/src/SMTP.php';

    function send($email, $token){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Mailer     = "smtp";
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "web2020fmi@gmail.com";
        $mail->Password   = "170307650809Aa";

        $mail->IsHTML(true);
        $mail->AddAddress("$email", "ReviewBase user");
        $mail->SetFrom("web2020fmi@gmail.com", "ReviewBase administrator");
        $mail->Subject = "ReviewBase password reset";
        //$recovery_link = "http://localhost/puffinsecurity/php/password_reset/new_password.php?token=\"+$token+\"&newPass=\"+$newPass";
        $content = "Recovery code: $token <br> Copy it and place it in the ReviewBase website->Forgotten password->I have a recovery code";

        $mail->MsgHTML($content); 
        if(!$mail->Send()) {
            echo "Error while sending Email.";
            var_dump($mail);
        }
    }
?>