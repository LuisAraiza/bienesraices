<?php
session_start();

if (!isset($_SESSION['usuario']['id']) || $_SESSION['usuario']['id'] !== 4) {
    header('Location: index.php');
    exit();
}
include 'db.php'; 

$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']);

$query = "SELECT * FROM propiedades";
$stmt = $pdo->prepare($query);
$stmt->execute();
$propiedades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Propiedades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            display: flex;
            align-items: center;
            padding: 10px;
            color: white;
        }

        .navbar img {
            height: 40px;
            margin-right: 20px;
        }

        .navbar h1 {
            font-size: 24px;
            margin: 0;
        }

        .titulo {
            text-align: center;
            margin: 20px 0;
            font-size: 28px;
        }

        .container {
            padding: 20px;
        }

        .boton-nueva {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-right: 10px;
        }

        .boton-nueva:hover {
            background-color: darkgreen;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .boton {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .actualizar {
            background-color: orange;
        }

        .eliminar {
            background-color: red;
        }

        .actualizar:hover {
            background-color: darkorange;
        }

        .eliminar:hover {
            background-color: darkred;
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

        .mensaje-flotante {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
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

    <a href="index.php" class="icono-regresar">
        <img src="img/regresar.png" alt="Regresar" />
        <span>Regresar</span>
    </a>

    <div class="titulo">
        <h2>Administrador de Propiedades</h2>
    </div>

    <div class="container">
        <a href="agregar_propiedad.php" class="boton-nueva">Nueva Propiedad</a>
        <a href="agregar_vendedores.php" class="boton-nueva">Nuevo Vendedor</a>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje-flotante" id="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($propiedades):
                    foreach ($propiedades as $propiedad): ?>
                    <tr>
                        <td><?php echo $propiedad['id']; ?></td>
                        <td><?php echo $propiedad['titulo']; ?></td>
                        <td><img src="<?php echo $propiedad['imagen'];?>" alt="Imagen Propiedad" style="width:200px;"></td>
                        <td><?php echo number_format($propiedad['precio'], 2, ',', '.'); ?> $ MXN</td>
                        <td>
                            <a href="actualizar_propiedad.php?id=<?php echo $propiedad['id']; ?>" class="boton actualizar">Actualizar</a>
                            <a href="eliminar_propiedad.php?id=<?php echo $propiedad['id']; ?>" class="boton eliminar" onclick="return confirm('¿Estás seguro de eliminar esta propiedad?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="5">No hay propiedades registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            var mensaje = document.getElementById('mensaje');
            if (mensaje) {
                mensaje.style.display = 'block';
                setTimeout(function() {
                    mensaje.style.display = 'none';
                }, 5000);
            }
        };
    </script>

</body>
</html>
