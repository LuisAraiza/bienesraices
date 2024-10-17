<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$esAdmin = isset($_SESSION['usuario']['id']) && $_SESSION['usuario']['id'] === 4;


include 'db.php';

$propiedades = $pdo->query("SELECT * FROM propiedades")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Propiedades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            padding: 15px;
            display: flex;
            align-items: center;
        }

        .navbar img {
            height: 40px;
            margin-right: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            font-size: 18px;
        }

        .propiedades {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .propiedad {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: auto; 
        }

        .propiedad img {
            width: 100%;
            height: 300px; 
            object-fit: cover;
            border-radius: 8px;
        }

        .propiedad h3 {
            margin: 10px 0;
        }

        .propiedad p {
            margin: 5px 0;
        }

        .iconos-caracteristicas {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: flex-start;
            margin: 10px 0;
        }

        .icono-con-numero {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .icono-con-numero img {
            width: 30px;
            height: 30px;
        }

        .boton-ver {
            display: inline-block;
            padding: 10px 15px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .boton-ver:hover {
            background-color: #575757;
        }

        .icono-cerrar {
            position: fixed;
            bottom: 20px;
            right: 20px; 
            background-color: #333; 
            border-radius: 50%;
            padding: 10px;
            color: white; 
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .icono-cerrar img, .icono-cerrar i {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="logo-link">
            <img src="img/logochido.png" alt="Logo">
        </a>
        <?php if ($esAdmin): ?>
        <a href="admin.php">Administrar</a>
    <?php endif; ?>
    </div>

    <h1>Propiedades en Venta</h1>
    <div class="propiedades">
        <?php foreach ($propiedades as $propiedad): ?>
        <div class="propiedad">
            <img src="<?php echo $propiedad['imagen']; ?>" alt="Imagen de la propiedad">
            <h3><?php echo $propiedad['titulo']; ?></h3>
            <p><?php echo number_format($propiedad['precio'], 2, ',', '.'); ?> $ MXN</p>
            
            <div class="iconos-caracteristicas">
                <div class="icono-con-numero">
                    <img src="img/cama.png" alt="Icono habitaciones">
                    <span><?php echo $propiedad['habitaciones']; ?></span>
                </div>
                <div class="icono-con-numero">
                    <img src="img/wc.png" alt="Icono baños">
                    <span><?php echo $propiedad['wc']; ?></span>
                </div>
                <div class="icono-con-numero">
                    <img src="img/carro.png" alt="Icono estacionamiento">
                    <span><?php echo $propiedad['estacionamiento']; ?></span>
                </div>
            </div>

            <a href="ver_propiedad.php?id=<?php echo $propiedad['id']; ?>" class="boton-ver">Ver Propiedad</a>
        </div>
        <?php endforeach; ?>
    </div>

    <a href="cerrar_sesion.php" class="icono-cerrar">
        <img src="img/cerrar.png" alt="Cerrar" />
    </a>
</body>
</html>
