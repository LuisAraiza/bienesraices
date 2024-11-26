<?php
session_start();
if (!isset($_SESSION['usuario']['id']) || $_SESSION['usuario']['id'] !== 4) {
    header('Location: index.php');
    exit();
}

include 'db.php';

$mensaje = '';
$propiedad_id = $_GET['id'] ?? null;

if (!$propiedad_id) {
    header('Location: admin.php');
    exit();
}

$propiedad = $pdo->prepare("SELECT * FROM propiedades WHERE id = :id");
$propiedad->execute([':id' => $propiedad_id]);
$propiedad = $propiedad->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedores_id = $_POST['vendedores_id'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $imagen = $propiedad['imagen']; // Imagen existente
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = 'img/' . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);
    }

    $sql = "UPDATE propiedades 
            SET titulo = :titulo, precio = :precio, imagen = :imagen, descripcion = :descripcion, 
                habitaciones = :habitaciones, wc = :wc, estacionamiento = :estacionamiento, 
                vendedores_id = :vendedores_id, latitud = :latitud, longitud = :longitud 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            ':titulo' => $titulo,
            ':precio' => $precio,
            ':imagen' => $imagen,
            ':descripcion' => $descripcion,
            ':habitaciones' => $habitaciones,
            ':wc' => $wc,
            ':estacionamiento' => $estacionamiento,
            ':vendedores_id' => $vendedores_id,
            ':latitud' => $latitud,
            ':longitud' => $longitud,
            ':id' => $propiedad_id
        ]);
        $mensaje = "Propiedad actualizada correctamente.";
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

$vendedores = $pdo->query("SELECT * FROM vendedores")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Propiedad</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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

        form input, form textarea, form select {
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

        #map {
            height: 400px;
            width: 100%;
        }

        .mensaje-flotante {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            font-size: 16px;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4drskHDqfMsBK_BG8znkDBhei3gjAmhE&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;

        function initMap() {
            const lat = <?php echo $propiedad['latitud'] ?? '0'; ?>;
            const lng = <?php echo $propiedad['longitud'] ?? '0'; ?>;

            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat, lng },
                zoom: 8
            });

            marker = new google.maps.Marker({
                position: { lat, lng },
                map: map
            });

            map.addListener('click', function(event) {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            marker.setPosition(location);
            document.getElementById('latitud').value = location.lat();
            document.getElementById('longitud').value = location.lng();
        }

        function mostrarMensaje() {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                setTimeout(() => {
                    mensaje.style.display = 'none';
                    window.location.href = 'admin.php';
                }, 3000);
            }
        }
    </script>
</head>
<body onload="mostrarMensaje()">
<header class="header">
    <h1>HazTuHogar</h1>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="nosotros.php">Nosotros</a>
        <a href="blog.php">Blog</a>
        <a href="contactanos.php">Contacto</a>
    </nav>
</header>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje-flotante" id="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="container">
        <h1>Actualizar Propiedad</h1>
        <form action="actualizar_propiedad.php?id=<?php echo $propiedad_id; ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $propiedad['titulo']; ?>" required>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $propiedad['precio']; ?>" required>
            </div>
            <div>
    <label for="imagen">Nueva Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*">
    <?php if (!empty($propiedad['imagen'])): ?>
        <p>Imagen actual:</p>
        <img src="<?php echo $propiedad['imagen']; ?>" alt="Imagen de la propiedad" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 5px;">
    <?php endif; ?>
</div>

            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo $propiedad['descripcion']; ?></textarea>
            </div>
            <div>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $propiedad['habitaciones']; ?>" required>
            </div>
            <div>
                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" value="<?php echo $propiedad['wc']; ?>" required>
            </div>
            <div>
                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" value="<?php echo $propiedad['estacionamiento']; ?>" required>
            </div>
            <div>
                <label for="vendedores_id">Vendedor:</label>
                <select name="vendedores_id" required>
                    <option value="">Seleccione un vendedor</option>
                    <?php foreach ($vendedores as $vendedor): ?>
                        <option value="<?php echo $vendedor['id']; ?>" <?php echo $vendedor['id'] == $propiedad['vendedores_id'] ? 'selected' : ''; ?>>
                            <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="map">Ubicación:</label>
                <div id="map"></div>
            </div>
            <input type="hidden" id="latitud" name="latitud" value="<?php echo $propiedad['latitud']; ?>">
            <input type="hidden" id="longitud" name="longitud" value="<?php echo $propiedad['longitud']; ?>">
            <button type="submit">Actualizar Propiedad</button>
        </form>
    </div>
</body>
</html>
