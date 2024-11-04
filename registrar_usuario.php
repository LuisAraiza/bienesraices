<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$registroExitoso = false;
$errorRegistro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Verificar si el correo ya existe
    $sqlVerificar = "SELECT * FROM usuario WHERE correo = :correo";
    $stmtVerificar = $pdo->prepare($sqlVerificar);
    $stmtVerificar->execute([':correo' => $correo]);
    $usuarioExistente = $stmtVerificar->fetch();

    if ($usuarioExistente) {
        // Si el usuario existe pero no está verificado, envía otro código de verificación
        if ($usuarioExistente['verificado'] == 0) {
            $codigo_verificacion = rand(1000, 9999);

            // Actualiza el código de verificación
            $sqlActualizar = "UPDATE usuario SET codigo_verificacion = :codigo WHERE correo = :correo";
            $stmtActualizar = $pdo->prepare($sqlActualizar);
            $stmtActualizar->execute([
                ':codigo' => $codigo_verificacion,
                ':correo' => $correo
            ]);

            // Enviar correo de verificación
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bienes739@gmail.com'; // Cambia por tu correo
            $mail->Password = 'gozg jhqf maty juqc'; // Cambia por tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('bienes739@gmail.com', 'Administrador');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu cuenta';
            $mail->Body = 'Tu nuevo código de verificación es: ' . $codigo_verificacion;

            $mail->send();
            $registroExitoso = true;
            header('Location: autenticacion.php?correo=' . urlencode($correo)); // Redirige a autenticacion.php
            exit();
        } else {
            $errorRegistro = "El correo ya está registrado y verificado.";
        }
    } else {
        // Si el correo no existe, crea un nuevo usuario
        $codigo_verificacion = rand(1000, 9999);

        // Inserta el correo, contraseña y código de verificación
        $sql = "INSERT INTO usuario (correo, password, codigo_verificacion, verificado) VALUES (:correo, :password, :codigo, 0)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':correo' => $correo,
                ':password' => password_hash($password, PASSWORD_DEFAULT), // Guarda la contraseña hasheada
                ':codigo' => $codigo_verificacion
            ]);
            // Enviar correo de verificación
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bienes739@gmail.com'; // Cambia por tu correo
            $mail->Password = 'gozg jhqf maty juqc'; // Cambia por tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('bienes739@gmail.com', 'Administrador');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu cuenta';
            $mail->Body = 'Tu código de verificación es: ' . $codigo_verificacion;

            $mail->send();
            $registroExitoso = true;
            header('Location: autenticacion.php?correo=' . urlencode($correo)); // Redirige a autenticacion.php
            exit();
        } catch (PDOException $e) {
            $errorRegistro = 'Error: ' . $e->getMessage();
        } catch (Exception $e) {
            $errorRegistro = 'No se pudo enviar el correo. Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px;
            width: 100%;
            position: fixed;
            top: 0;
        }

        .navbar img {
            height: 50px;
        }

        .register-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 100px;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-container label {
            display: block;
            margin-bottom: 5px;
        }

        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .register-container button:hover {
            background-color: #575757;
        }

        .register-container .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .register-container .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }

        .register-container .link-inicio {
            text-align: center;
            margin-top: 10px;
        }

        .register-container .link-inicio a {
            color: #333;
            text-decoration: none;
        }

        .register-container .link-inicio a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <img src="img/logochido.png" alt="Logo de la Empresa">
        </div>
    </div>

    <div class="register-container">
        <h2>Registrar Usuario</h2>

        <?php if ($errorRegistro): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorRegistro); ?></div>
        <?php endif; ?>

        <?php if ($registroExitoso): ?>
            <div class="success-message">Te hemos enviado un correo de verificación.</div>
        <?php endif; ?>

        <form action="registrar_usuario.php" method="POST">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrar</button>
        </form>

        <div class="link-inicio">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </div>

</body>
</html>
