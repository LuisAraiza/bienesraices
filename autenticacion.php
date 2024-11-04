<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$correo = '';
$error = '';
$reenviado = false;  // Nueva variable para mostrar el mensaje

if (isset($_GET['correo'])) {
    $correo = $_GET['correo'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo'])) { // Verificar el código ingresado
        $codigoIngresado = $_POST['codigo'];

        $sql = "SELECT * FROM usuario WHERE correo = :correo AND codigo_verificacion = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':correo' => $correo, ':codigo' => $codigoIngresado]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $sqlActualizar = "UPDATE usuario SET verificado = 1 WHERE correo = :correo";
            $stmtActualizar = $pdo->prepare($sqlActualizar);
            $stmtActualizar->execute([':correo' => $correo]);

            header('Location: login.php');
            exit();
        } else {
            $error = "Código de verificación incorrecto.";
        }
    } elseif (isset($_POST['reenviar'])) { // Reenviar el código
        $nuevoCodigo = rand(1000, 9999);

        $sqlActualizarCodigo = "UPDATE usuario SET codigo_verificacion = :codigo WHERE correo = :correo";
        $stmtActualizarCodigo = $pdo->prepare($sqlActualizarCodigo);
        $stmtActualizarCodigo->execute([':codigo' => $nuevoCodigo, ':correo' => $correo]);

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bienes739@gmail.com'; 
            $mail->Password = 'gozg jhqf maty juqc'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('bienes739@gmail.com', 'Administrador');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Reenvío de Código de Verificación';
            $mail->Body = 'Tu nuevo código de verificación es: ' . $nuevoCodigo;

            $mail->send();
            $reenviado = true;  // Mostrar mensaje de éxito
        } catch (Exception $e) {
            $error = 'Error al enviar el correo: ' . $mail->ErrorInfo;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            background-color: #333; /* Color de la barra de navegación */
            padding: 10px;
            text-align: left; /* Alineación a la izquierda */
            position: fixed;
            width: 100%;
            top: 0;
            display: flex; /* Flex para alinear el logo y el icono */
            align-items: center; /* Alineación vertical */
        }
        .navbar img {
            height: 40px; /* Ajustar el tamaño del logo */
            margin-right: 20px; /* Espaciado entre el logo y el ícono */
        }
        .container {
            max-width: 400px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 60px; /* Margen para evitar que se superponga con la navbar */
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #575757;
        }
        .link {
            text-align: center;
            margin-top: 15px;
            cursor: pointer;
            color: #333; /* Color del enlace */
            text-decoration: underline; /* Subrayado */
        }
        .mensaje-error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        #contador {
            text-align: center;
            margin-top: 10px;
            color: gray;
        }
        .mensaje-flotante {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            display: none;
        }
        .login-container .link-reenviar {
            text-align: center;
            margin-top: 10px;
        }
        .login-container .link-reenviar a {
            color: #333; /* Color del enlace */
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .login-container .link-reenviar a:hover {
            color: #333; /* Color al hacer hover */
            text-decoration: underline;
        }
        
        
    </style>
</head>
<body>
    <?php if ($reenviado): ?>
        <div class="mensaje-flotante" id="mensaje-flotante">Código reenviado con éxito</div>
    <?php endif; ?>
    
    <div class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="img/logochido.png" alt="Logo de la Empresa">
            </a>
        </div>
    </div>

    <div class="container">
        <h2>Verificar Código</h2>
        <?php if ($error): ?>
            <div class="mensaje-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="autenticacion.php?correo=<?php echo urlencode($correo); ?>" method="POST">
            <div>
                <label for="codigo">Código de verificación:</label>
                <input type="text" id="codigo" name="codigo" required>
            </div>
            <div>
                <button type="submit">Verificar</button>
            </div>
        </form>

        <form id="reenviar-form" action="autenticacion.php?correo=<?php echo urlencode($correo); ?>" method="POST" style="display:none;">
            <input type="hidden" name="reenviar" value="1">
        </form>

        <div class="link" id="reenviar-link" onclick="reenviarCodigo()">Reenviar Código</div>
        <div id="contador">Espera 15 segundos para reenviar otro código.</div>
    </div>

    <script>
        let tiempoRestante = 15;
        const reenviarLink = document.getElementById('reenviar-link');
        const contador = document.getElementById('contador');
        const reenviarForm = document.getElementById('reenviar-form');
        const mensajeFlotante = document.getElementById('mensaje-flotante');

        reenviarLink.style.pointerEvents = 'none'; // Deshabilitar al inicio

        const interval = setInterval(() => {
            tiempoRestante--;
            contador.textContent = `Espera ${tiempoRestante} segundos para reenviar otro código.`;

            if (tiempoRestante <= 0) {
                clearInterval(interval);
                reenviarLink.style.pointerEvents = 'auto'; // Habilitar
                reenviarLink.style.color = '#0066cc';
                contador.textContent = 'Ahora puedes reenviar el código.';
            }
        }, 1000);

        function reenviarCodigo() {
            reenviarForm.submit();
            reenviarLink.style.pointerEvents = 'none'; // Deshabilitar nuevamente
            tiempoRestante = 15; // Reiniciar el contador
            contador.textContent = `Espera ${tiempoRestante} segundos para reenviar otro código.`;
            const mensajeFlotante = document.getElementById('mensaje-flotante');
            mensajeFlotante.style.display = 'block'; // Mostrar mensaje
            setTimeout(() => {
                mensajeFlotante.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
