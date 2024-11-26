<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];

    // Validación adicional
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/", $nombre)) {
        $mensaje = "El nombre solo puede contener letras y espacios.";
    } elseif (!preg_match("/^\d{10}$/", $telefono)) {
        $mensaje = "El teléfono debe contener solo 10 números.";
    } elseif (!is_numeric($cantidad)) {
        $mensaje = "El presupuesto debe ser un número válido.";
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bienes739@gmail.com';
            $mail->Password = 'gozg jhqf maty juqc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('bienes739@gmail.com', 'Contacto Web');
            $mail->addAddress('bienes739@gmail.com', 'Admin');

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo mensaje de contacto';
            $mail->Body = "
                <h1>Nuevo mensaje de contacto</h1>
                <p><strong>Nombre:</strong> $nombre</p>
                <p><strong>Correo:</strong> $correo</p>
                <p><strong>Teléfono:</strong> $telefono</p>
                <p><strong>Interés:</strong> $tipo</p>
                <p><strong>Presupuesto:</strong> $cantidad MXN</p>
            ";

            $mail->send();
            $mensaje = 'Mensaje enviado correctamente.';
        } catch (Exception $e) {
            $mensaje = "Error al enviar el mensaje: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .header a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        form div {
            margin-bottom: 15px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input, form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #575757;
        }
        .mensaje-flotante {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>

<header class="header">
    <h1>HazTuHogar</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="nosotros.php">Nosotros</a>
        <a href="blog.php">Blog</a>
        <a href="contactanos.php">Contacto</a>
    </nav>
</header>

<div class="container">
    <h1>Contáctanos</h1>
    <form action="Contactanos.php" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required pattern="[A-Za-záéíóúÁÉÍÓÚÑñ\s]+" title="Solo letras y espacios son permitidos.">
        </div>
        <div>
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required maxlength="10" pattern="\d{10}" title="El teléfono debe contener solo 10 números.">
        </div>
        <div>
            <label for="tipo">Interés</label>
            <select id="tipo" name="tipo" required>
                <option value="Venta">Venta</option>
                <option value="Compra">Compra</option>
            </select>
        </div>
        <div>
            <label for="cantidad">Presupuesto (en MXN):</label>
            <input type="number" id="cantidad" name="cantidad" required min="1">
        </div>
        <button type="submit">Enviar</button>
    </form>
</div>

<div class="mensaje-flotante" id="mensaje"><?php echo $mensaje; ?></div>

<script>
    <?php if (!empty($mensaje)): ?>
        document.getElementById('mensaje').style.display = 'block';
        setTimeout(function() {
            document.getElementById('mensaje').style.display = 'none';
        }, 5000);
    <?php endif; ?>
</script>

</body>
</html>
