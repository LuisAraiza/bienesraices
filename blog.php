<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }
        .blog-post {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        .blog-post img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-right: 1px solid #ddd;
        }
        .blog-content {
            padding: 20px;
        }
        .blog-title {
            font-size: 18px;
            margin: 0 0 10px;
        }
        .blog-title a {
            color: #333;
            text-decoration: none;
        }
        .blog-title a:hover {
            color: #575757;
        }
        .blog-meta {
            font-size: 14px;
            color: #888;
            margin-bottom: 10px;
        }
        .blog-meta span {
            display: inline-block;
            margin-right: 10px;
        }
        .blog-description {
            color: #555;
        }
    </style>
</head>
<body>

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
        <h2>Nuestro Blog</h2>

        <!-- Publicación 1 -->
        <div class="blog-post">
            <img src="img/P-4-min.WEBP" alt="Imagen de la publicación">
            <div class="blog-content">
                <h3 class="blog-title">
                    <a href="detalles.php?id=1">Comprar casa o departamento: ¿Cuál te conviene más?</a>
                </h3>
                <p class="blog-meta">
                    <span>Escrito el: 12/11/2014</span>
                    <span>por: Admin</span>
                </p>
                <p class="blog-description">
                La decisión de comprar una casa o un departamento es una de las más importantes en la vida de cualquier persona. El mercado inmobiliario presenta diversas oportunidades y desafíos, y es crucial entender qué opción puede ser más conveniente según tus necesidades, estilo de vida y presupuesto
                </p>
            </div>
        </div>

        <!-- Publicación 2 -->
        <div class="blog-post">
            <img src="img/p-5-min-1170x600.WEBP" alt="Imagen de la publicación">
            <div class="blog-content">
                <h3 class="blog-title">
                    <a href="detalles.php?id=2">Mejores zonas para vivir en Saltillo</a>
                </h3>
                <p class="blog-meta">
                    <span>Escrito el: 20/10/2014</span>
                    <span>por: Admin</span>
                </p>
                <p class="blog-description">
                    Saltillo, la joya de Coahuila, es una ciudad que conjuga a la perfección historia y modernidad. Sus calles empedradas, sus edificios coloniales y sus museos albergan siglos de tradición. Desde la Plaza de Armas, corazón pulsante de la ciudad, hasta los rincones más escondidos de sus barrios, Saltillo te invita a descubrir un pasado rico y fascinante.
                </p>
            </div>
        </div>

        <!-- Publicación 3 -->
        <div class="blog-post">
            <img src="img/6-14-min-768x480.WEBP" alt="Imagen de la publicación">
            <div class="blog-content">
                <h3 class="blog-title">
                    <a href="detalles.php?id=3">Qué es una desarrolladora inmobiliaria y cuáles son sus funciones</a>
                </h3>
                <p class="blog-meta">
                    <span>Escrito el: 05/07/2014</span>
                    <span>por: Admin</span>
                </p>
                <p class="blog-description">
                El mundo es dinámico y cambiante, esto sin duda influye en múltiples actividades económicas como el de los bienes raíces, en los que las desarrolladoras desempeñan un papel fundamental, ya que son las responsables de crear, planificar, ejecutar y monitorear los proyectos de construcción.
                </p>
            </div>
        </div>

         <!-- Publicación 4 -->
         <div class="blog-post">
            <img src="img/5-32-768x480.webp" alt="Imagen de la publicación">
            <div class="blog-content">
                <h3 class="blog-title">
                    <a href="detalles.php?id=4">¿Qué son los bienes raíces?</a>
                </h3>
                <p class="blog-meta">
                    <span>Escrito el: 15/01/2014</span>
                    <span>por: Admin</span>
                </p>
                <p class="blog-description">
                Los bienes raíces, igualmente conocidos como propiedades inmobiliarias, son sumamente importantes en la economía global, de hecho, como se asevera en el diario El Mundo, significan el 60% del valor total de los principales activos de inversión convencional.
                </p>
            </div>
        </div>

        <!-- Publicación 5 -->
        <div class="blog-post">
            <img src="img/Como-comprar-la-casa-de-tus-suenos-con-Grupo-Caisa-1024x569.WEBP" alt="Imagen de la publicación">
            <div class="blog-content">
                <h3 class="blog-title">
                    <a href="detalles.php?id=5">Cómo comprar la casa de tus sueños</a>
                </h3>
                <p class="blog-meta">
                    <span>Escrito el: 02/12/2014</span>
                    <span>por: Admin</span>
                </p>
                <p class="blog-description">
                Comprar una casa es un momento emocionante y significativo en nuestra vida. En este artículo, te mostraremos los pasos esenciales para hacerlo realidad y asegurarnos de que sea una experiencia gratificante y sin contratiempos.
                </p>
            </div>
        </div>

        <!-- Más publicaciones puedes agregarlas aquí -->
    </div>

</body>
</html>
