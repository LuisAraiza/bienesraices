<?php
include 'db.php'; 

$registroExitoso = false;
$errorRegistro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sqlVerificar = "SELECT COUNT(*) FROM usuario WHERE correo = :correo";
    $stmtVerificar = $pdo->prepare($sqlVerificar);
    $stmtVerificar->execute([':correo' => $correo]);
    $existeCorreo = $stmtVerificar->fetchColumn();

    if ($existeCorreo) {
        $errorRegistro = "El correo ya está registrado.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (correo, password) VALUES (:correo, :password)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([
                ':correo' => $correo,
                ':password' => $password_hash 
            ]);
            $registroExitoso = true;
        } catch (PDOException $e) {
            $errorRegistro = 'Error: ' . $e->getMessage();
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
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }
        .nav-links a:hover {
            background-color: #575757;
        }
        .container {
            max-width: 400px;
            margin: 120px auto 50px; 
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h2 {
            text-align: center;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"], input[type="password"] {
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
        }
        .mensaje-exito {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4caf50; 
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: <?php echo $registroExitoso ? 'block' : 'none'; ?>;
            z-index: 10;
            transition: opacity 0.5s ease;
        }
        .mensaje-error {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: <?php echo !empty($errorRegistro) ? 'block' : 'none'; ?>;
            z-index: 10;
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="img/logochido.png" alt="Logo de la Empresa">
        </div>
    </div>

    <div class="container">
        <?php if ($registroExitoso): ?>
            <div class="mensaje-exito" id="mensajeExito">Usuario registrado exitosamente.</div>
        <?php endif; ?>
        <?php if (!empty($errorRegistro)): ?>
            <div class="mensaje-error" id="mensajeError"><?php echo $errorRegistro; ?></div>
        <?php endif; ?>
        <h2>Registrar Usuario</h2>
        <form action="registrar_usuario.php" method="POST">
            <div>
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Registrar</button>
            </div>
        </form>
        <div class="link">
            <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
    </div>

    <script>
        setTimeout(function() {
            const mensajeExito = document.getElementById('mensajeExito');
            if (mensajeExito) {
                mensajeExito.style.opacity = '0';
                setTimeout(function() {
                    mensajeExito.style.display = 'none';
                }, 500);
            }
        }, 3000);

        setTimeout(function() {
            const mensajeError = document.getElementById('mensajeError');
            if (mensajeError) {
                mensajeError.style.opacity = '0';
                setTimeout(function() {
                    mensajeError.style.display = 'none';
                }, 500);
            }
        }, 5000);
    </script>
</body>
</html>
