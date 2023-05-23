<?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;


        
        require '../phpmailer/src/PHPMailer.php';
        require '../phpmailer/src/SMTP.php';
        require '../phpmailer/src/Exception.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; // SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'jose.chacha.prg.16.19@gmail.com';                     //SMTP username
            $mail->Password   = 'Valentin_1_2_3/Chacha/Montalvo$$$';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jose.chacha.prg.16.19@gmail.com', 'Flash Electronics');
            $mail->addAddress('valentinmontalvo99@gmail.com', 'Tienda Flash Electronics');     //Add a recipient
           // $mail->addAddress('ellen@example.com');               //Name is optional
           // $mail->addReplyTo('', 'Informacion');
          

            //Agregar archivos, pero esto es opcional
            //  $mail->addAttachment('ruta');         //Add attachments
            //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Detalle de tu compra';

            $cuerpo = '<h4>Gracias por su compra</h4>';
            $cuerpo .= '<p>El ID de su compra es <b>' .$id_transaccion . '</b></p>';

            $mail->Body    = utf8_decode($cuerpo);
            
            $mail->AltBody = 'Le enviamos los detalles de su compra';


            $mail-> setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

            $mail->send();
            
        } catch (Exception $e) {
            echo "Error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
          
        }
