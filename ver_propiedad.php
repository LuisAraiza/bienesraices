<?php
include 'db.php';

$id = $_GET['id'];
$propiedad = $pdo->query("SELECT * FROM propiedades WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $propiedad['titulo']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            display: flex;
            padding: 20px;
            align-items: flex-start;
        }

        .imagen-container {
            width: 60%;
            margin-bottom: 20px;
        }

        .propiedad-imagen {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .detalle-y-mapa {
            display: flex;
            flex-direction: column; 
            width: 40%;
            margin-left: 20px;
        }

        .detalle-propiedad {
            padding: 20px; 
            background-color: #f9f9f9; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            margin-bottom: 20px; 
        }

        .detalle-propiedad h1 {
            font-size: 2em;
            margin: 0;
        }

        .detalle-propiedad p {
            font-size: 1.2em;
            margin: 5px 0;
        }

        .icons {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .icons img {
            width: 30px;
            margin-right: 10px;
        }

        .icons p {
            margin-right: 30px;
            font-size: 1.2em;
        }

        .boton-contacto {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .boton-contacto:hover {
            background-color: #575757;
        }

        .map-container {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4drskHDqfMsBK_BG8znkDBhei3gjAmhE"></script>
    <script>
        function initMap() {
            const latitud = <?php echo $propiedad['latitud']; ?>;
            const longitud = <?php echo $propiedad['longitud']; ?>;

            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: latitud, lng: longitud },
                zoom: 10
            });

            const marker = new google.maps.Marker({
                position: { lat: latitud, lng: longitud },
                map: map,
                title: '<?php echo $propiedad['titulo']; ?>'
            });
        }
    </script>
</head>
<body onload="initMap()">

    <header class="header">
        <h1>HazTuHogar</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="nosotros.php">Nosotros</a>
            <a href="blog.php">Blog</a>
            <a href="contactanos.php">Contacto</a>
        </nav>
    </header>

    <div class="container">
        <div class="imagen-container">
            <img class="propiedad-imagen" src="<?php echo $propiedad['imagen']; ?>" alt="Imagen de la propiedad">
        </div>

        <div class="detalle-y-mapa">
            <div class="detalle-propiedad">
                <h1><?php echo $propiedad['titulo']; ?></h1>
                <p><?php echo $propiedad['precio']; ?> $ MXN</p>

                <div class="icons">
                    <img src="img/cama.png" alt="Habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>

                    <img src="img/wc.png" alt="Baños">
                    <p><?php echo $propiedad['wc']; ?></p>

                    <img src="img/carro.png" alt="Estacionamientos">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </div>

                <p><?php echo $propiedad['descripcion']; ?></p>

                <a href="contactanos.php" class="boton-contacto">Contáctanos</a>
            </div>

            <div class="map-container" id="map"></div>
        </div>
    </div>
</body>
</html>
