<?php
session_start();
include 'db.php';

$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE correo = :correo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':correo' => $correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    

    if ($usuario) {
        // Verificar la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Verificar si el usuario está verificado
            if ($usuario['verificado'] == 1) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                ];
                header('Location: index.php'); // Redirige al usuario a la página principal
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 100px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #575757;
        }

        .login-container .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .login-container .link-registrar {
            text-align: center;
            margin-top: 10px;
        }

        .login-container .link-registrar a {
            color: #333;
            text-decoration: none;
        }

        .login-container .link-registrar a:hover {
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

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <?php if ($mensaje_error): ?>
            <div class="error-message"><?php echo htmlspecialchars($mensaje_error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Ingresar</button>
        </form>

        <div class="link-registrar">
            <p>¿No tienes una cuenta? <a href="registrar_usuario.php">Regístrate aquí</a></p>
        </div>
    </div>

</body>
</html>
