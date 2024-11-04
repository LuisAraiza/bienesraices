<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Cargar PHPMailer

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];

    // Configuración del correo
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bienes739@gmail.com';
        $mail->Password = 'gozg jhqf maty juqc'; // Reemplaza con tu contraseña o contraseña de aplicación
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
            background-color: #f4f4f4;
            margin: 0;
            padding-top: 70px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar img {
            height: 50px;
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
        /* Estilo para el mensaje flotante */
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
    <div class="navbar">
        <a href="index.php">
            <img src="img/logochido.png" alt="Logo">
        </a>
    </div>

    <div class="container">
        <h1>Contáctanos</h1>
        <form action="Contactanos.php" method="POST">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
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
                <input type="number" id="cantidad" name="cantidad" required>
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
