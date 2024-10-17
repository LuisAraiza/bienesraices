<?php
session_start();

if (!isset($_SESSION['usuario']['id']) || $_SESSION['usuario']['id'] !== 4) {
    header('Location: index.php');
    exit();
}
include 'db.php'; 

$mensaje_exito = '';
$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];

    $query = "SELECT * FROM vendedores WHERE nombre = :nombre AND apellido = :apellido";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':nombre' => $nombre, ':apellido' => $apellido]);

    if ($stmt->rowCount() > 0) {
        $mensaje_error = "Ya existe un vendedor con el mismo nombre y apellido.";
    } else {
        $sql = "INSERT INTO vendedores (nombre, apellido, telefono) VALUES (:nombre, :apellido, :telefono)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':telefono' => $telefono
            ]);
            $mensaje_exito = "Vendedor agregado exitosamente.";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Vendedor</title>
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
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar img {
            height: 50px;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s;
            white-space: nowrap;
        }

        .nav-links a:hover {
            background-color: #575757;
        }

        .icono-regresar {
            position: absolute;
            top: 85px;
            left: 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .icono-regresar img {
            width: 30px;
            height: auto;
            margin-right: 8px;
        }

        .icono-regresar span {
            color: black;
            font-size: 16px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto; 
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        form {
            margin: 0;
        }

        form div {
            margin-bottom: 15px;
        }

        form label {
            display: block;
            margin-bottom: 5px; 
        }

        form input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px; 
        }

        button {
            background-color: #333; 
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 4px;
        }

        button:hover {
            background-color: #575757;
        }

        .mensaje-flotante {
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            border-radius: 5px;
            display: none;
        }

        .mensaje-exito {
            background-color: #4CAF50;
        }

        .mensaje-error {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="img/logochido.png" alt="Logo de la Empresa">
            </a>
        </div>
    </div>

    <a href="admin.php" class="icono-regresar">
        <img src="img/regresar.png" alt="Regresar" />
        <span>Regresar</span>
    </a>

    <?php if (!empty($mensaje_exito)): ?>
        <div class="mensaje-flotante mensaje-exito" id="mensaje-exito"><?php echo $mensaje_exito; ?></div>
    <?php endif; ?>

    <?php if (!empty($mensaje_error)): ?>
        <div class="mensaje-flotante mensaje-error" id="mensaje-error"><?php echo $mensaje_error; ?></div>
    <?php endif; ?>

    <div class="container">
        <h1>Agregar Vendedor</h1>
        <form action="agregar_vendedores.php" method="POST">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div>
                <button type="submit">Agregar Vendedor</button>
            </div>
        </form>
    </div>

    <script>
        window.onload = function() {
            var mensajeExito = document.getElementById('mensaje-exito');
            var mensajeError = document.getElementById('mensaje-error');
            
            if (mensajeExito) {
                mensajeExito.style.display = 'block';
                setTimeout(function() {
                    mensajeExito.style.display = 'none';
                }, 3000);
            }
            
            if (mensajeError) {
                mensajeError.style.display = 'block';
                setTimeout(function() {
                    mensajeError.style.display = 'none';
                }, 3000);
            }
        };
    </script>

</body>
</html>
