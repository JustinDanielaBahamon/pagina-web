<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTESANIAS DE TEJIDOS ORTEGAS</title>
    <!-- Scripts y estilos de Bootstrap -->
    <script src="./bootstrap-5.2.3-dist/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="./bootstrap-5.2.3-dist/css/bootstrap.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="slider2H.css">
    <link rel="stylesheet" href="footer.css">
    <script src="comprar.js"></script>
</head>
<style>
       .btn-add-to-cart {
        background-color: #C8A2C8; /* Color de fondo */
        color: white; /* Color del texto */
        padding: 10px 20px; /* Espaciado interno */
        border: none; /* Sin borde */
        border-radius: 5px; /* Bordes redondeados */
        font-size: 16px; /* Tamaño de fuente */
        cursor: pointer; /* Cambia el cursor al pasar el mouse */
        transition: background-color 0.3s ease; /* Animación suave para hover */
    }

        .btn-add-to-cart:hover {
          background-color: #800080; /* Cambia el color al pasar el mouse */
        }

    </style>
<body>

 <!-- Footer fijo en la parte superior -->
<div id="top-footer" class="text-center py-2 fixed-top">
    <span id="footer-text">Llámanos al 3000000000</span>
</div>

<script>
    // Array de mensajes
    const messages = [
        'Llámanos al 3000000000',
        'Compra ahora: Envíos nacionales e internacionales',
        'Descubre nuestra variedad de hamacas hechas a mano',
        'Calidad garantizada en cada producto',
        'Visita nuestro sitio para más ofertas'
    ];

    let currentIndex = 0;

    function changeMessage() {
        // Cambia el texto al siguiente mensaje
        document.getElementById('footer-text').textContent = messages[currentIndex];

        // Incrementa el índice y reinicia si llega al final del array
        currentIndex = (currentIndex + 1) % messages.length;
    }

    // Cambia el mensaje cada 3 segundos (3000 ms)
    setInterval(changeMessage, 3000);
</script>

    <!-- NAV Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="../page/Inicio.php">
            <img src="img/LOGO HAMACAS.jpg" alt="Logo" style="width: 150px; height: auto;">
        </a>

        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" href="./Inicio.php"><b>INICIO</b></a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>PRODUCTOS</b>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="./hamacas.php">HAMACAS</a></li>
                    <li><a class="dropdown-item" href="./sillas_colgantes.php">SILLAS COLGANTES</a></li>
                    <li><a class="dropdown-item" href="./columpio.php">COLUMPIO</a></li>
                    <li><a class="dropdown-item" href="./cuna.php">CUNA</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="artesaniasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <b>ARTESANÍAS</b>
                </a>
                <ul class="dropdown-menu" aria-labelledby="artesaniasDropdown">
                    <li><a class="dropdown-item" href="./ponchos.php">Ponchos</a></li>
                    <li><a class="dropdown-item" href="./bolsos.php">Bolsos</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="./nosotros.php"><b>NOSOTROS</b></a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="./contactos.php"><b>CONTACTOS</b></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./login.php">
                    <img src="img/logo inicio.png" alt="Login" style="width: 30px; height: auto;">
                </a>
            </li>

            <!-- Icono de carrito de compras -->
            <li class="nav-item">
                <a class="nav-link" href="./comprar.php" title="Ver carrito">
                <img src="img/carrito.jpeg" alt="comprar"style="width: 30px; height: auto;"></i>
                    <span class="badge bg-danger" id="cart-count">0</span> <!-- Mostrar el número de artículos -->
                </a>
            </li>
        </ul>
    </div>
</nav>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    

    
<!--columna izquierd-->
<br>
<style>



.thumbnail:hover {
    transform: scale(1.1); /* Aumenta el tamaño al pasar el ratón */
    border-color: #000; /* Cambia el color del borde al pasar el ratón */
}


</style>
<br>
<div class="container text-center">
    <div class="row">
        <!-- Columna del Slider (Izquierda) -->
        <div class="col-sm-5 col-md-6">
            <div class="main-image">
                <img id="main-image" src="img/imgCLM/CML4.png" alt="Imagen Principal">
            </div>
            <div class="thumbnail-container">
                <img src="img/imagen3.png" alt="Miniatura 1" class="thumbnail" onclick="swapImages(this)">
                <img src="img/Medidas.png" alt="Miniatura 2" class="thumbnail" onclick="swapImages(this)">
                <img src="img/imagen1.png" alt="Miniatura 3" class="thumbnail" onclick="swapImages(this)">
                <img src="img/imagen2.png" alt="Miniatura 4" class="thumbnail" onclick="swapImages(this)">
            </div>
        </div>
        
        <!-- Columna de Contenido (Derecha) -->
        <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0 text-start">
            <h2>COLUMPIO ROSADO</h2><br>
            <p>Este columpio está hecha a mano con materiales de la más alta calidad, como algodón y orlón, lo que garantiza durabilidad y confort. Es perfecta para relajarse en el jardín, la terraza, o en cualquier lugar donde desees disfrutar de un momento de tranquilidad.</p>
            <ul>

                <div class="container mt-5">
                    
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Material</th>
                                <td>Algodón y orlón</td>
                            </tr>
                            <tr>
                                <th scope="row">Capacidad</th>
                                <td>1-2 personas</td>
                            </tr>
                            <tr>
                                <th scope="row">Colores Disponibles</th>
                                <td>Azul, Verde, Amarillo, Rojo</td>
                            </tr>
                            <tr>
                                <th scope="row">Precio</th>
                                <td>$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>   
               
            </ul><br>
            <button class="btn-add-to-cart" data-name="BOLSO5" data-price="60.000">Añadir al carrito</button>
        </div>
    </div>
</div>
<!--politicas de servicio-->
<div class="container mt-5">
    <h3>Políticas de Servicio</h3>
    
    <h5>Política de Envíos</h5>
    <p>Realizamos envíos a todo el país con un costo adicional según la ubicación. El tiempo de entrega estimado es de 5-7 días hábiles.</p>
    
    <h5>Política de Devoluciones</h5>
    <p>Aceptamos devoluciones dentro de los 30 días posteriores a la compra. El producto debe estar en su empaque original y sin signos de uso. El costo del envío de devolución corre por cuenta del cliente.</p>
    
    <h5>Garantía</h5>
    <p>Todas nuestras hamacas cuentan con una garantía de 1 año por defectos de fabricación. Para hacer válida la garantía, contáctanos con tu número de pedido y una descripción del problema.</p>

    <h5>Términos y Condiciones</h5>
    <p>Al realizar una compra en nuestro sitio web, aceptas nuestros términos y condiciones. Por favor, revisa esta sección regularmente para estar al tanto de cualquier cambio.</p>
</div>



<!--fin de politica-->
<script>
function swapImages(thumbnail) {
    // Obtener la URL de la imagen principal y la miniatura seleccionada
    var mainImage = document.getElementById("main-image");
    var tempSrc = mainImage.src;

    // Intercambiar las imágenes
    mainImage.src = thumbnail.src;
    thumbnail.src = tempSrc;
}

</script>

<br><br><br><br><br>

<!--footer-->
<br><br>
<!--footer-->
<br><br>
<footer class="footer-distributed">

    <div class="footer-left">

        <h3>HAMACAS <span> ARTESANIAS DE TEJIDOS ORTEGAS</span></h3>

        <p class="footer-links">
            <a href="Inicio.html" class="link-1">Inicio</a>
            
            <a href="hamacas.html">HAMACAS</a>
        
            <a href="Artesanias.html">ARTESANIAS</a>
        
            <a href="nosotros.html">NOSOTROS</a>
            
            <a href="contactos.html">CONTACTOS</a>
            
        
        </p>

        <p class="footer-company-name">Artesanias De Tejidos Ortega © 2024</p>
    </div>

    <div class="footer-center">

        <div>
            <i class="fa fa-map-marker"></i>
            <p><span>Direccion de ejemplo <br><br></span> Colombia, Huila Campoalegre</p>
            
        </div>
        
        <div>
            <i class="fa fa-phone"></i>
            <p>+57 3000000000</p>
        </div>

        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="contacto@ejemplo.com">contacto@ejemplo.com</a></p>
        </div>

    </div>

    <div class="footer-right">

        <p class="footer-company-about">
            <span>INFORMACION</span>
            todas las imagenes son propiedades exclusivas de ARTESANIAS DE TEJIDOS ORTEGAS, el uso de cualquier material sin el debido permiso, representa una violación de propiedad intelectual.
        </p>

        <div class="footer-icons">

            <a href="https://www.facebook.com"><i class="fa fa-facebook"></i></a>
            <a href="https://x.com/home"><i class="fa fa-twitter"></i></a>
            <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
            <a href="https://web.whatsapp.com/"><i class="fa fa-whatsapp"></i></a>

        </div>

    </div>

</footer>
<!--Fin Footer--> 
