<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php'; // <- esta es la que faltaba

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $telefono = trim($_POST['Phone'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    //$fecha = trim($_POST['fecha'] ?? '');
    //$hora = trim($_POST['horario'] ?? '');
    $frecuencia = trim($_POST['frecuencia'] ?? '');
    $Tipo = trim($_POST['Tipo'] ?? '');
    $instrucciones = trim($_POST['instrucciones'] ?? '');
    $cuartos = trim($_POST['Cuartos'] ?? '');
    $banios = trim($_POST['banios'] ?? '');

    if (!$nombre || !$correo || !$direccion /* || !$fecha */ || !$frecuencia || !$Tipo || !$telefono) {
        http_response_code(400);
        echo "❌ You must fill in all the fields.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@fanyscleaning.com'; // Usa aquí tu correo de Hostinger, no Gmail
        $mail->Password = 'Fanyscleaning_1';          // Usa la contraseña SMTP que Hostinger te da
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('admin@fanyscleaning.com', 'Fanys Cleaning');
        $mail->addAddress('Fanyscleaning10@gmail.com', 'Destinatario');
        $mail->addAddress('gescoto9@gmail.com');       // correo personal

        $mail->isHTML(true);
        $mail->Subject = "New service requested: {$nombre}";
        $mail->Body = "
            <h2>You have a service request from: {$nombre}</h2>
            <p><strong>Name:</strong> {$nombre}</p>
            <p><strong>Phone:</strong> {$telefono}</p>
            <p><strong>Email Adress:</strong> {$correo}</p>
            <p><strong>Adress:</strong> {$direccion}</p>
            <p><strong>How Often:</strong> {$frecuencia}</p>
            <p><strong>Service:</strong> {$Tipo}</p>
            <p><strong>Bedrooms:</strong> {$cuartos}</p>
            <p><strong>Bathrooms:</strong> {$banios}</p>
            <p><strong>Instructions:</strong> {$instrucciones}</p>
            
        ";

        $mail->send();
        echo "✅ Thank you for writing to us, we will be contacting you shortly.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "❌ The request could not be sent: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405);
    echo "Método no permitido";
}
