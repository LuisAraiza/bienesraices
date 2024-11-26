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
    <!-- Favicon -->
    <link rel="icon" href="img/logochido.png" type="image/png" sizes="32x32">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Ajustes generales */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
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

        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
        }

        .hero video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            border-radius: 10px;
        }

        /* Proceso de Compra */
        .proceso-compra {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 50px 300px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .proceso-compra h2 {
            font-size: 3rem;
            margin: 0;
        }

        .pasos {
            width: 70%;
        }

        .paso {
            display: flex;
            align-items: flex-start;
            margin-bottom: 40px;
        }

        .paso .numero {
            font-size: 4rem;
            font-weight: bold;
            margin-right: 20px;
        }

        .paso .contenido h3 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .paso .contenido p {
            font-size: 1rem;
            color: #ddd;
            line-height: 1.5;
        }

        /* Carrusel */
        .carrusel-contenedor {
            position: relative;
            overflow: hidden;
            margin: 20px auto;
            width: 90%;
        }

        .propiedades {
            display: flex;
            gap: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .propiedad {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            color: #333;
            min-width: 300px;
            flex-shrink: 0;
        }

        .propiedad img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        .propiedad h3 {
            margin: 10px 0;
            font-size: 1.2rem;
        }

        .propiedad p {
            margin: 5px 0;
            font-size: 1rem;
            color: #555;
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
            align-self: flex-start;
        }

        .boton-ver:hover {
            background-color: #575757;
        }
        h1 {
    text-align: center;
    margin: 20px 0;
    font-size: 2.5rem;
}


        /* Botones del carrusel */
        .boton-carrusel {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            z-index: 2;
        }

        .boton-carrusel.izquierda {
            left: 0;
        }

        .boton-carrusel.derecha {
            right: 0;
        }

        .boton-carrusel:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>
<header class="header">
    <h1>HazTuHogar</h1>
    <nav>
        <a href="nosotros.php">Nosotros</a>
        <a href="blog.php">Blog</a>
        <a href="contactanos.php">Contacto</a>
        <?php if ($esAdmin): ?>
            <a href="admin.php">Administrar</a>
        <?php endif; ?>
    </nav>
</header>

<a href="cerrar_sesion.php" title="Cerrar sesión">
    <img src="img/cerrar.png" alt="Cerrar sesión" style="position: fixed; bottom: 10px; right: 10px; width: 40px; height: 40px;">
</a>

<!-- Hero -->
<div class="hero">
    <video autoplay muted loop>
        <source src="img/vecteezy_a-village-full-of-traditional-houses-with-vintage-style-made_19942683.mp4" type="video/mp4">
        Tu navegador no soporta la reproducción de este video.
    </video>
    <div class="hero-content">
        <h2>Hogares excepcionales, experiencia inigualable. El lujo que se vive.</h2>
    </div>
</div>

<!-- Proceso de Compra -->
<div class="proceso-compra">
    <h2>PROCESO DE COMPRA</h2>
    <div class="pasos">
        <div class="paso">
            <div class="numero">1</div>
            <div class="contenido">
                <h3>VISITA DE LA CASA</h3>
                <p>Te ayudamos a encontrar el hogar perfecto con visitas guiadas según tus necesidades.</p>
            </div>
        </div>
        <div class="paso">
            <div class="numero">2</div>
            <div class="contenido">
                <h3>TÉRMINOS DE NEGOCIACIÓN</h3>
                <p>Negociamos los mejores términos con el vendedor adaptándonos a tu presupuesto.</p>
            </div>
        </div>
        <div class="paso">
            <div class="numero">3</div>
            <div class="contenido">
                <h3>CIERRE SIN PREOCUPACIONES</h3>
                <p>Te entregamos las llaves de tu nuevo hogar sin complicaciones.</p>
            </div>
        </div>
    </div>
</div>

<!-- Carrusel de Propiedades -->
<h1>Propiedades en Venta</h1>
<div class="carrusel-contenedor">
    <button class="boton-carrusel izquierda">&lt;</button>
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
    <button class="boton-carrusel derecha">&gt;</button>
</div>

<script>
    const carrusel = document.querySelector('.propiedades');
    const botonIzquierda = document.querySelector('.boton-carrusel.izquierda');
    const botonDerecha = document.querySelector('.boton-carrusel.derecha');
    const propiedades = document.querySelectorAll('.propiedad');
    const carruselContenedor = document.querySelector('.carrusel-contenedor');

    // Ancho total del carrusel y del contenedor visible
    const anchoPropiedad = propiedades[0].offsetWidth + 20; // Ancho + margen
    const anchoVisible = carruselContenedor.offsetWidth;
    const anchoTotal = propiedades.length * anchoPropiedad;

    let scrollAmount = 0;

    botonIzquierda.addEventListener('click', () => {
        // Si no está al inicio, permite moverse a la izquierda
        if (scrollAmount < 0) {
            scrollAmount += anchoPropiedad;
            carrusel.style.transform = `translateX(${scrollAmount}px)`;
        }
    });

    botonDerecha.addEventListener('click', () => {
        // Si no se ha llegado al final, permite moverse a la derecha
        if (Math.abs(scrollAmount) + anchoVisible < anchoTotal) {
            scrollAmount -= anchoPropiedad;
            carrusel.style.transform = `translateX(${scrollAmount}px)`;
        }
    });
</script>
</body>
</html>
