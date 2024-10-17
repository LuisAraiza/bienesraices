<?php
session_start();
if (!isset($_SESSION['usuario']['id']) || $_SESSION['usuario']['id'] !== 4) {
    header('Location: index.php');
    exit();
}

include 'db.php'; 

$mensaje = '';
$latitud = null;
$longitud = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $creado = date('Y-m-d');
    $vendedores_id = $_POST['vendedores_id'];

    if (isset($_POST['latitud']) && isset($_POST['longitud'])) {
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
    }

    $imagen = $_FILES['imagen']['name'];
    $ruta_imagen = 'img/' . basename($imagen);
    
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {

    } else {

    }

    $sql = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id, latitud, longitud)
            VALUES (:titulo, :precio, :imagen, :descripcion, :habitaciones, :wc, :estacionamiento, :creado, :vendedores_id, :latitud, :longitud)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':titulo' => $titulo,
            ':precio' => $precio,
            ':imagen' => $ruta_imagen,
            ':descripcion' => $descripcion,
            ':habitaciones' => $habitaciones,
            ':wc' => $wc,
            ':estacionamiento' => $estacionamiento,
            ':creado' => $creado,
            ':vendedores_id' => $vendedores_id,
            ':latitud' => $latitud,
            ':longitud' => $longitud
        ]);
        $mensaje = "Propiedad agregada exitosamente.";
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
    <title>Agregar Propiedad</title>
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
        
        #map {
            height: 400px; 
            width: 100%; 
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4drskHDqfMsBK_BG8znkDBhei3gjAmhE&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8
            });

            marker = new google.maps.Marker({
                position: { lat: -34.397, lng: 150.644 },
                map: map
            });

            map.addListener('click', function(event) {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            marker.setPosition(location);

            const latitud = location.lat();
            const longitud = location.lng();

            document.getElementById('latitud').value = latitud;
            document.getElementById('longitud').value = longitud;
        }
    </script>
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

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje-flotante" id="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="container">
        <h1>Agregar Propiedad</h1>
        <form action="agregar_propiedad.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" required>
            </div>
            <div>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            <div>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" required>
            </div>
            <div>
                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" required>
            </div>
            <div>
                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" required>
            </div>
            <div>
                <label for="vendedores_id">Vendedor:</label>
                <select name="vendedores_id" required>
                    <option value="">Seleccione un vendedor</option>
                    <?php foreach ($vendedores as $vendedor): ?>
                        <option value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" id="latitud" name="latitud">
            <input type="hidden" id="longitud" name="longitud">

            <button type="submit">Agregar Propiedad</button>
        </form>
        <div id="map"></div>
    </div>

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
