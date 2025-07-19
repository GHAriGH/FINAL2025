<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../PhPMailer/src/PHPMailer.php';
require '../PhPMailer/src/SMTP.php';
require '../PhPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'pruebasoft2025@gmail.com';                    
    $mail->Password   = 'setr erns cpbp gybo
';                             
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          
    $mail->Port       = 587;                                    

    $mail->setFrom('pruebasoft2025@gmail.com', 'Tienda Online Gimnasio');
    $mail->addAddress('aripazosgm@gmail.com', 'Usuario');     
   
    $mail->isHTML(true);                                  
    $mail->Subject = 'Detalle de su compra';
    $cuerpo = '<h4>GRACIAS POR SU COMPRA</h4>';
    $cuerpo .= '<p>El ID de su compra es <b>' . $id_transaccion . '</b></p>';
    $mail->Body    = $cuerpo;
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLanguage('es', '../PhPMailer/language/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
    //exit;
}

?>