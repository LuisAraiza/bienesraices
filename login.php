<?php
session_start();
include 'db.php';

$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $secret_key = '6LeVOHUqAAAAAFEPAu3XoiHn2MpgnGXVa6E-XpS_';
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_response");
    $response_keys = json_decode($response, true);
    
    if(intval($response_keys["success"]) !== 1) {
        $mensaje_error = "Por favor completa el captcha.";
    } else {
        $sql = "SELECT * FROM usuario WHERE correo = :correo LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($usuario) {
            if (password_verify($password, $usuario['password'])) {
                if ($usuario['verificado'] == 1) {
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                    ];
                    header('Location: index.php'); 
                    exit();
                } else {
                    $mensaje_error = "Debes verificar tu correo antes de iniciar sesión.";
                }
            } else {
                $mensaje_error = "Correo o contraseña incorrectos.";
            }
        } else {
            $mensaje_error = "Correo o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 100%;
            height: 80%; /* Ajustar la altura total del contenedor */
        }

        .left-section {
            flex: 1;
            background-image: url('img/loginfotoj.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left-section .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Efecto oscuro */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left-section h3 {
            font-size: 24px;
            margin: 0;
        }

        .left-section p {
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
            max-width: 80%;
        }

        .right-section {
            flex: 1;
            padding: 40px;
        }

        .right-section h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .g-recaptcha {
            margin: 20px 0;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #575757;
        }

        .link-registrar {
            text-align: center;
            margin-top: 15px;
        }

        .link-registrar a {
            color: #333;
            text-decoration: none;
        }

        .link-registrar a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="overlay">
                <h3>HazTuHogar</h3>
                <p>"La casa propia es el sueño que transforma vidas y construye patrimonio."</p>
            </div>
        </div>
        <div class="right-section">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="g-recaptcha" data-sitekey="6LeVOHUqAAAAAB4YOcQg1NMPHVLPSxUVN1P4bFPo"></div>
                <button type="submit" class="submit-btn">Ingresar</button>
            </form>
            <div class="link-registrar">
                <p>¿No tienes una cuenta? <a href="registrar_usuario.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</body>
</html>
