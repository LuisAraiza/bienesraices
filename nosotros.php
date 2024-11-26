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
    <title>Nosotros</title>
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
        text-align: center;
    }
    .section-title {
        font-size: 24px;
        margin-bottom: 30px;
        color: #333;
    }

    .hero {
        position: relative;
        height: 100vh;
        overflow: hidden;
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
        max-width: 600px;
        background-color: rgba(0, 0, 0, 0.6); /* Fondo semi-transparente */
        padding: 20px;
        border-radius: 8px;
        color: #fff;
        z-index: 2; /* Asegura que el texto quede sobre el video */
        margin: auto;
        top: 50%;
        transform: translateY(-50%);
    }
    .hero h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }
    .hero p {
        font-size: 18px;
        margin-bottom: 20px;
    }
    .hero .btn {
        display: inline-block;
        background-color: #d72638;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }
    .hero .btn:hover {
        background-color: #a61e2b;
    }

    /* Estilos para los cuadros */
    .cards {
        display: flex;
        justify-content: space-around;
        margin: 50px auto; /* Añade separación entre las cards y el video */
    }
    .card {
        position: relative;
        width: 200px;
        height: 200px;
        perspective: 1000px;
    }
    .card-content {
        width: 100%;
        height: 100%;
        position: absolute;
        transform-style: preserve-3d;
        transition: transform 0.6s;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .card-content:hover {
        transform: rotateY(180deg);
    }
    .card-front, .card-back {
        position: absolute;
        backface-visibility: hidden;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
    }
    .card-front {
        background-color: #fff;
    }
    .card-back {
        background-color: #f1f1f1;
        color: #333;
        padding: 20px;
        font-size: 16px;
        transform: rotateY(180deg);
    }
    .card-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        z-index: 1;
    }
    .card-icon img {
        max-width: 70%;
        max-height: 70%;
        object-fit: contain;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2; /* Asegura que el texto esté encima de la imagen */
        background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
        padding: 5px;
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

<div class="hero">
    <!-- Video de fondo -->
    <video autoplay muted loop>
        <source src="img/vecteezy_interior-of-an-abandoned-wooden-village-house-old-farmhouse_46873370.mp4" type="video/mp4">
        Tu navegador no soporta la reproducción de este video.
    </video>

    <div class="hero-content">
        <h1>Bienvenido a HazTuHogar</h1>
        <p>Somos una empresa dedicada a transformar espacios en hogares. Creemos que un hogar es más que un lugar para vivir es un refugio donde crear recuerdos y construir una vida plena. Nuestro compromiso es ayudarte a encontrar el hogar perfecto que se adapte a tus necesidades y estilo de vida.</p>
        <a href="contactanos.php" class="btn">Contáctanos</a>
    </div>
</div>

<div class="container">
    <h2 class="section-title">Conoce más sobre nosotros</h2>
    
    <!-- Cards -->
    <div class="cards">
        <!-- Card 1: Misión -->
        <div class="card">
            <div class="card-content">
                <div class="card-front">
                    <div class="card-icon">
                        <img src="img/objetivo.png" alt="Misión">
                    </div>
                    <div class="card-title">Misión</div>
                </div>
                <div class="card-back">
                    <p>Nuestra misión es brindar soluciones habitacionales de alta calidad, con un enfoque en la sostenibilidad y la satisfacción total de nuestros clientes.</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Visión -->
        <div class="card">
            <div class="card-content">
                <div class="card-front">
                    <div class="card-icon">
                        <img src="img/vision.png" alt="Visión">
                    </div>
                    <div class="card-title">Visión</div>
                </div>
                <div class="card-back">
                    <p>Ser líderes en el desarrollo de proyectos inmobiliarios sostenibles, generando un impacto positivo en las comunidades y contribuyendo al desarrollo del entorno urbano.</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Valores -->
        <div class="card">
            <div class="card-content">
                <div class="card-front">
                    <div class="card-icon">
                        <img src="img/cliente.png" alt="Valores">
                    </div>
                    <div class="card-title">Valores</div>
                </div>
                <div class="card-back">
                    <p>Nos guiamos por principios de integridad, respeto y compromiso, buscando siempre la excelencia en cada proyecto que emprendemos.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
