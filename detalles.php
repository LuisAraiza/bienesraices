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
    <title>Detalles del Blog</title>
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
        .hero-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }
        .blog-title {
            font-size: 28px;
            margin-top: 20px;
            color: #333;
            text-align: center;
        }
        .blog-meta {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }
        .blog-content {
            font-size: 16px;
            color: #555;
            margin-top: 20px;
            line-height: 1.8;
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
        <?php
        // Simular datos (normalmente provendrían de la base de datos)
        $id = isset($_GET['id']) ? $_GET['id'] : 1;
        $posts = [
            1 => [
                "titulo" => "Comprar casa o departamento: ¿Cuál te conviene más?",
                "fecha" => "12/11/2024",
                "autor" => "Admin",
                "imagen" => "img/P-4-min.WEBP", // Ruta de la imagen principal
                "contenido" => "
                    <p>La decisión de comprar una casa o un departamento es una de las más importantes en la vida de cualquier persona. El mercado inmobiliario presenta diversas oportunidades y desafíos, y es crucial entender qué opción puede ser más conveniente según tus necesidades, estilo de vida y presupuesto.</p>
                    <h4><strong>Tendencias actuales en el mercado inmobiliario</strong></h4>
                    <p><strong>Crecimiento de los Precios</strong><br>
                    Según el Índice de Precios de Vivienda de Zillow, los precios de las viviendas han aumentado un 5% en el último año. Esta alza ha sido impulsada por la alta demanda y la oferta limitada de propiedades disponibles. En áreas urbanas, donde la demanda es más alta, los precios han subido incluso más (Zillow, 2024).</p>
                    
                    <p><strong>Interés en la vida urbana: el auge de los departamentos como opción de vivienda</strong><br>
                    La demanda de departamentos ha crecido significativamente, especialmente en áreas urbanas, debido a la búsqueda de conveniencia y menor mantenimiento. Este interés se ha visto impulsado por el deseo de vivir más cerca del trabajo, servicios y áreas de entretenimiento, así como la necesidad de reducir costos de mantenimiento y energía (National Association of Realtors, 2024).</p>
                    
                    <p><strong>Tendencias de Home Office</strong><br>
                    El aumento de Home Office ha cambiado las prioridades de los compradores. Muchas personas buscan propiedades con espacios adicionales que puedan servir como oficinas en casa. Este cambio ha llevado a una mayor demanda de propiedades que ofrecen áreas flexibles y bien diseñadas para trabajar desde casa (Forbes, 2024).</p>
                    
                    <h4><strong>Ventajas de comprar una casa</strong></h4>
                    <p><strong>Espacio y privacidad</strong><br>
                    Una de las principales ventajas de comprar una casa es el espacio adicional que ofrece. Las casas suelen proporcionar una combinación de área interior y exterior en comparación con los departamentos. Esto es ideal para familias que buscan jardines, patios o habitaciones extra. Además, la mayor privacidad que ofrece una casa puede mejorar significativamente la calidad de vida al reducir las interacciones con vecinos y permitir un ambiente más tranquilo.</p>
                    
                    <p><strong>Personalización y valor a largo plazo</strong><br>
                    Comprar una casa te brinda la libertad de personalizar y remodelar el espacio según tus gustos y necesidades. Después de los plazos de garantías, puedes hacer cambios estructurales, elegir acabados, y adaptar la propiedad a tu estilo de vida. Además, las casas tienden a tener una mayor apreciación de valor a largo plazo, especialmente en áreas suburbanas en crecimiento. Esto puede resultar en una inversión más sólida y duradera, ya que el valor de las propiedades en estos lugares suele aumentar con el tiempo.</p>
                    
                    <h4><strong>Ventajas de comprar un departamento</strong></h4>
                    <p><strong>Menor mantenimiento y costos de entrada</strong><br>
                    Los departamentos suelen requerir menos mantenimiento que las casas. Las áreas comunes y el exterior son gestionados por la asociación de propietarios, lo que te permite disfrutar de una vida más libre de preocupaciones por el mantenimiento. Esto puede ser particularmente ventajoso para aquellos que prefieren un estilo de vida más sencillo o que tienen un tiempo limitado para dedicarse al cuidado de su hogar. Además, el costo inicial de comprar un departamento suele ser más asequible que el de una casa, lo que lo convierte en una opción atractiva para los compradores primerizos.</p>
                    
                    <p><strong>Ubicación y conveniencia</strong><br>
                    Los departamentos suelen estar ubicados en zonas urbanas o cerca de áreas de interés, lo que proporciona un acceso más fácil a servicios, transporte público y entretenimiento. Vivir en una ubicación central puede ofrecerte una gran comodidad, reduciendo el tiempo de viaje diario y facilitando el acceso a tiendas, restaurantes, y otras actividades sociales. Esta conveniencia es especialmente valiosa para quienes valoran la proximidad a centros de trabajo y servicios. Además, contar con una desarrolladora inmobiliaria como Grupo CAISA puede ayudarte a encontrar ubicaciones estratégicas y desarrollos pensados para la vida urbana.</p>
                    
                    <p><strong>Servicios y comunidad</strong><br>
                    Muchos departamentos ofrecen servicios adicionales como gimnasios, piscinas y áreas comunes que pueden enriquecer tu calidad de vida. Además, vivir en un departamento te permite formar parte de una comunidad con vecinos que pueden compartir intereses similares. Las áreas comunes y los eventos organizados por la asociación de propietarios pueden fomentar un sentido de comunidad y ofrecer oportunidades para socializar.</p>
                ",
            ],
            2 => [
                "titulo" => "Mejores zonas para vivir en Saltillo",
                "fecha" => "20/10/2024",
                "autor" => "Admin",
                "imagen" => "img/p-5-min-1170x600.WEBP",
                "contenido" => "
                    <p>Saltillo, la capital de Coahuila, es una ciudad que combina su rica historia cultural con un desarrollo urbano moderno. Vivir aquí ofrece una calidad de vida única, con opciones para todos los gustos y necesidades. A continuación, exploramos las mejores zonas para vivir en esta joya del norte de México.</p>
                    
                    <h4><strong>Zona Centro</strong></h4>
                    <p>El corazón histórico de Saltillo ofrece un ambiente lleno de encanto colonial. Aquí encontrarás casas antiguas, remodeladas con detalles modernos, ideales para quienes buscan vivir rodeados de historia y cultura. Además, la cercanía a museos, restaurantes y la Plaza de Armas hace que la vida en esta zona sea muy práctica y enriquecedora.</p>
                    
                    <h4><strong>San Isidro</strong></h4>
                    <p>Ubicada al norte de la ciudad, esta zona residencial es conocida por sus amplias avenidas y modernas construcciones. San Isidro es ideal para familias que buscan tranquilidad y seguridad, con fácil acceso a escuelas privadas, centros comerciales y parques recreativos. Su desarrollo constante ha hecho de esta área una de las más deseadas para vivir en Saltillo.</p>
                    
                    <h4><strong>Ramos Arizpe</strong></h4>
                    <p>A solo minutos de Saltillo, Ramos Arizpe se ha convertido en un polo de desarrollo industrial y residencial. Sus fraccionamientos privados ofrecen viviendas asequibles y modernas, ideales para quienes trabajan en la zona industrial cercana. Además, cuenta con amplias áreas verdes y opciones recreativas que lo convierten en un excelente lugar para vivir.</p>
                    
                    <h4><strong>Valle Real</strong></h4>
                    <p>Para aquellos que buscan lujo y exclusividad, Valle Real es la elección perfecta. Este fraccionamiento ofrece residencias de alto nivel, con seguridad privada y acceso a servicios premium. Sus calles arboladas y la cercanía a centros comerciales y restaurantes lo convierten en una de las zonas más exclusivas de la ciudad.</p>
                    
                    <h4><strong>Saltillo 2000</strong></h4>
                    <p>Una opción moderna y accesible para familias jóvenes. Saltillo 2000 cuenta con una excelente infraestructura, escuelas cercanas y una vibrante comunidad. Su ubicación estratégica permite un fácil acceso a las principales vialidades de la ciudad, haciéndolo ideal para quienes buscan comodidad y practicidad.</p>
                    
                    <h4><strong>Conclusión</strong></h4>
                    <p>Saltillo ofrece una diversidad de opciones habitacionales que se adaptan a diferentes estilos de vida y presupuestos. Ya sea que prefieras el encanto histórico del centro o la modernidad de fraccionamientos como Valle Real, esta ciudad tiene algo para todos. Con una combinación de seguridad, servicios y calidad de vida, no es de extrañar que Saltillo sea considerado uno de los mejores lugares para vivir en el norte de México.</p>
                ",
            ],            
            3 => [
                "titulo" => "¿Qué es una desarrolladora inmobiliaria? Funciones y objetivos",
                "fecha" => "05/07/2024",
                "autor" => "Admin",
                "imagen" => "img/6-14-min-768x480.WEBP",
                "contenido" => "
                    <h4><strong>Definición</strong></h4>
                    <p>Las desarrolladoras inmobiliarias son empresas o entidades dedicadas a la creación, desarrollo y comercialización de proyectos inmobiliarios. Estas son responsables de todas las etapas del proceso, desde la adquisición de terrenos hasta la comercialización o alquiler de las propiedades construidas. Su objetivo es transformar los espacios en infraestructura que genere valor económico y social, tanto para los propietarios como para los inversionistas involucrados.</p>
                    
                    <h4><strong>Funciones de una Desarrolladora Inmobiliaria</strong></h4>
                    
                    <h5><strong>Adquisición de terrenos</strong></h5>
                    <p>El primer paso de un proyecto inmobiliario es identificar el terreno ideal. Esto implica evaluar su ubicación, tipo de suelo y el proceso de adquisición. Se realizan estudios de mercado para determinar la viabilidad del desarrollo y seleccionar la mejor opción disponible.</p>
                    
                    <h5><strong>Planificación y diseño</strong></h5>
                    <p>Una vez adquirido el terreno, se trabaja con arquitectos, ingenieros y urbanistas para diseñar el proyecto. Esto incluye la planificación de la infraestructura, la distribución del espacio y el estilo arquitectónico, buscando siempre la funcionalidad y la estética.</p>
                    
                    <h5><strong>Financiación</strong></h5>
                    <p>Las desarrolladoras gestionan el financiamiento necesario para ejecutar el proyecto. Esto puede incluir la obtención de préstamos, la atracción de inversionistas y la elaboración de un presupuesto que contemple todos los costos involucrados, desde la construcción hasta el mantenimiento futuro.</p>
                    
                    <h5><strong>Permisos y regulaciones</strong></h5>
                    <p>Antes de iniciar la construcción, se deben obtener los permisos correspondientes y cumplir con las regulaciones locales y nacionales. Esto requiere trabajar con autoridades gubernamentales en temas de zonificación, construcción y medioambiente para garantizar que el proyecto avance sin contratiempos legales.</p>
                    
                    <h5><strong>Construcción</strong></h5>
                    <p>Con los permisos en regla, comienza la fase de construcción. Las desarrolladoras coordinan a contratistas y subcontratistas para asegurar que el proyecto se complete en el plazo previsto y dentro del presupuesto. También supervisan el uso de materiales para garantizar su calidad y cumplimiento normativo.</p>
                    
                    <h5><strong>Comercialización y venta</strong></h5>
                    <p>Una vez finalizado el proyecto, se implementan estrategias de marketing para promover la propiedad. La comunicación efectiva de los beneficios, como ubicación, diseño y seguridad, es clave para atraer compradores o arrendatarios, dependiendo del tipo de desarrollo (residencial, comercial o industrial).</p>
                    
                    <h5><strong>Gestión de propiedades</strong></h5>
                    <p>En esta última fase, las desarrolladoras gestionan las propiedades terminadas, incluyendo edificios residenciales, comerciales e industriales. Se encargan del mantenimiento, operación eficiente y reuniones periódicas para abordar temas operativos. Diversos especialistas participan en esta etapa para garantizar el éxito continuo del proyecto.</p>
                ",
            ],
            4 => [
                "titulo" => "Categorías de bienes raíces y sus funciones",
                "fecha" => "15/01/2024",
                "autor" => "Admin",
                "imagen" => "img/5-32-768x480.webp",
                "contenido" => "
                    <h4><strong>Categorías de bienes raíces y sus funciones</strong></h4>
                    <p>Los bienes raíces se dividen en cuatro categorías principales:</p>
                    
                    <h5><strong>Residenciales</strong></h5>
                    <p>Incluyen complejos de casas, viviendas unifamiliares, dúplex, tríplex, condominios y apartamentos, así como lofts. Es la categoría más conocida y, como ya se mencionó, la que más se construye. Asimismo, es la más accesible, debido a que comprende la construcción de viviendas que se habitan por parte de la ciudadanía.</p>
                    
                    <h5><strong>Comerciales</strong></h5>
                    <p>Las infraestructuras comerciales son propiedades usadas para negocios o actividades de retail, así como oficinas, tiendas, restaurantes y plazas con tiendas departamentales. Estas suelen estar ubicadas en áreas de bastante tránsito, debido a que deben estar disponibles y accesibles para los consumidores o clientes.</p>
                    
                    <h5><strong>Industriales</strong></h5>
                    <p>Se refiere a fábricas, almacenes y centros de distribución. Este tipo de propiedades se usan para la producción, almacenamiento y distribución de productos. Su ubicación es estratégica, ya que antes de su construcción, existe una logística detallada para garantizar un funcionamiento óptimo. En México, este tipo de bienes raíces está en tendencia desde 2015 debido al *nearshoring*. Se espera que el país reciba entre el 10% y el 20% de la inversión extranjera directa gracias a esta estrategia, como confirma *El Economista*.</p>
                    <p>Las zonas clave para la relocalización de empresas son:</p>
                    <ul>
                        <li>Monterrey</li>
                        <li>Ciudad de México</li>
                        <li>Saltillo</li>
                        <li>Tijuana</li>
                    </ul>
                    <p>En el Bajío:</p>
                    <ul>
                        <li>Querétaro</li>
                        <li>Guanajuato</li>
                    </ul>
                    
                    <h5><strong>Terrenos</strong></h5>
                    <p>Los terrenos son una inversión importante debido a que pueden aumentar su valor con el tiempo y dependiendo del contexto. Estos espacios, sin desarrollos previos, representan oportunidades para construir infraestructura a largo plazo, especialmente si están cercanos a zonas urbanizadas.</p>
                    
                    <h4><strong>La importancia de los bienes raíces</strong></h4>
                    <p>Este sector es esencial desde distintos ángulos: inversión, estabilidad financiera y contribución a la economía.</p>
                    
                    <h5><strong>Inversión y patrimonio</strong></h5>
                    <p>Los bienes raíces son una de las inversiones más seguras y rentables a largo plazo. Además, proporcionan ingresos pasivos mediante el alquiler, lo que los hace ideales para asegurar un patrimonio.</p>
                    
                    <h5><strong>Estabilidad financiera</strong></h5>
                    <p>Poseer propiedades proporciona estabilidad financiera al ser un activo tangible. Pueden servir para vivienda, comercio o incluso como garantía para préstamos importantes.</p>
                    
                    <h5><strong>Diversificación de portafolio</strong></h5>
                    <p>La inversión en bienes raíces diversifica el portafolio, reduciendo riesgos asociados a otras inversiones como acciones o bonos. Esto atrae tanto a agentes financieros como a quienes buscan seguridad económica.</p>
                    
                    <h5><strong>Contribución a la economía</strong></h5>
                    <p>El sector inmobiliario genera empleo, estimula la demanda de bienes y servicios, y pone en marcha la colaboración de diversos expertos como arquitectos, ingenieros y diseñadores. Por ejemplo, la relocalización de empresas no solo requiere infraestructura industrial, sino también vivienda, hospitales, bancos, espacios recreativos y más.</p>
                    
                    <h4><strong>Factores que influyen en el mercado de bienes raíces</strong></h4>
                    <p>El mercado inmobiliario está sujeto a diversos factores que afectan su funcionamiento:</p>
                    
                    <h5><strong>Ubicación</strong></h5>
                    <p>Propiedades en áreas con buen acceso a servicios como transporte, salud y educación tienen mayor valor y demanda.</p>
                    
                    <h5><strong>Economía</strong></h5>
                    <p>La situación económica influye en la demanda. Durante períodos de crecimiento, la demanda aumenta, mientras que en recesiones puede disminuir.</p>
                    
                    <h5><strong>Tasas de interés</strong></h5>
                    <p>Las tasas de interés afectan la capacidad de los compradores para obtener hipotecas. Tasas bajas incrementan la demanda, mientras que tasas altas pueden reducirla.</p>
                    
                    <h5><strong>Políticas gubernamentales</strong></h5>
                    <p>Regulaciones, incentivos fiscales y políticas de vivienda pueden influir significativamente en la oferta y la demanda. Una correcta gestión fomenta proyectos de alta calidad.</p>
                    
                    <h5><strong>Demografía</strong></h5>
                    <p>El crecimiento poblacional, migración y cambios en la estructura familiar afectan la demanda de propiedades. Esto exige a los desarrolladores ser visionarios y considerar riesgos con equipos multidisciplinarios.</p>
                ",
            ],
            5 => [
                "titulo" => "¿Cuáles son los pasos a seguir para comprar una casa?",
                "fecha" => "02/12/2024",
                "autor" => "Admin",
                "imagen" => "img/Como-comprar-la-casa-de-tus-suenos-con-Grupo-Caisa-1024x569.WEBP",
                "contenido" => "
                    <h4><strong>¿Cuáles son los pasos a seguir para comprar una casa?</strong></h4>
                    
                    <h5><strong>Define tus necesidades y presupuesto</strong></h5>
                    <p>En este paso es importante definir tus necesidades y prioridades al comprar una casa. Esto incluye determinar la ubicación, el tamaño, el estilo y el precio que estás dispuesto a pagar. También es esencial analizar tus finanzas personales para establecer un presupuesto adecuado a tu capacidad de pago.</p>
                    
                    <h5><strong>Busca opciones en el mercado</strong></h5>
                    <p>Investiga el mercado inmobiliario para conocer las opciones disponibles de acuerdo con tus necesidades y presupuesto. Considera diversos canales de búsqueda, como portales en línea, agencias inmobiliarias y publicaciones especializadas.</p>
                    
                    <h5><strong>Evalúa las opciones disponibles</strong></h5>
                    <p>Analiza las propiedades que cumplen con tus criterios para determinar cuál se adapta mejor a tus necesidades. Ten en cuenta factores como la ubicación, el tamaño, la calidad de la construcción, la infraestructura y los servicios que ofrece la zona.</p>
                    
                    <h5><strong>Realiza una oferta de compra</strong></h5>
                    <p>Una vez que encuentres la propiedad ideal, haz una oferta de compra al vendedor. Es importante negociar un precio justo para ambas partes.</p>
                    
                    <h5><strong>Realiza los trámites y documentos necesarios</strong></h5>
                    <p>Después de que se acepte tu oferta, inicia los trámites necesarios para formalizar la compra. Esto incluye revisar y obtener los documentos legales requeridos, así como gestionar un crédito hipotecario si es necesario.</p>
                    
                    <h5><strong>Firma del contrato de compraventa</strong></h5>
                    <p>Con los trámites y documentos en orden, se procede a la firma del contrato de compraventa. Este documento es legalmente vinculante y establece las condiciones y términos de la transacción.</p>
                    
                    <h5><strong>Entrega y recepción de la propiedad</strong></h5>
                    <p>Por último, se realiza la entrega y recepción de la propiedad. Aquí se verifica que la propiedad esté en buen estado y libre de adeudos. Se efectúa el pago final y la propiedad se transfiere al nuevo dueño.</p>
                    
                    <h4><strong>¿Cómo puedo saber si una propiedad es la adecuada para mí?</strong></h4>
                    <ul>
                        <li>Evalúa tus necesidades y preferencias personales.</li>
                        <li>Considera la ubicación y accesibilidad de la propiedad.</li>
                        <li>Examina la calidad y estado de la construcción.</li>
                        <li>Revisa los servicios y amenidades cercanas.</li>
                        <li>Consulta con un asesor inmobiliario para obtener más información.</li>
                    </ul>
                    
                    <h4><strong>¿Qué documentos necesito para comprar una casa?</strong></h4>
                    <ul>
                        <li>Identificación oficial vigente.</li>
                        <li>Comprobante de ingresos.</li>
                        <li>Comprobante de domicilio.</li>
                        <li>Historial crediticio.</li>
                        <li>Avalúo de la propiedad.</li>
                        <li>Contrato de compraventa.</li>
                        <li>Escrituras de la propiedad.</li>
                    </ul>
                    
                    <h4><strong>¿Qué pasa si no tengo todo el dinero para comprar una casa?</strong></h4>
                    <p>Existen diversas opciones de financiamiento con plazos y tasas accesibles. También se pueden explorar alternativas de cofinanciamiento con otras instituciones financieras para facilitar la compra de tu vivienda.</p>
                ",
            ],
                     
        ];

        $post = $posts[$id] ?? null;

        if ($post):
        ?>
            <img src="<?= htmlspecialchars($post['imagen']) ?>" alt="Imagen del artículo" class="hero-image">
            <h2 class="blog-title"><?= htmlspecialchars($post['titulo']) ?></h2>
            <p class="blog-meta">
                Escrito el: <?= htmlspecialchars($post['fecha']) ?> por <?= htmlspecialchars($post['autor']) ?>
            </p>
            <div class="blog-content">
                <?= $post['contenido'] ?>
            </div>
        <?php else: ?>
            <p>El artículo que buscas no existe.</p>
        <?php endif; ?>
    </div>

</body>
</html>
