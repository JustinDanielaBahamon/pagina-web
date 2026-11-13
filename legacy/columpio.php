<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTESANIAS DE TEJIDOS ORTEGAS</title>
    <!-- Scripts y estilos de Bootstrap -->
    <script src="./bootstrap-5.2.3-dist/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="./bootstrap-5.2.3-dist/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="slider.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="style.css">
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=3000000000&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20el%20producto%202." class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i> 
</a>
<!-- Footer fijo en la parte superior -->
<div id="top-footer" class="text-center py-2 fixed-top">
    <span id="footer-text">Llámanos al  3000000000</span>
</div>

<script>
    // Array de mensajes
    const messages = [
        'Llámanos al  3000000000',
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
        <a class="navbar-brand" href="./Inicio.php">
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
    

     <!--carrusel2prod-->

<div id="productosCarousel" class="carousel slide" data-ride="carousel" data-interval="1000">
    <ol class="carousel-indicators">
        <li data-target="#productosCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#productosCarousel" data-slide-to="1"></li>
        <li data-target="#productosCarousel" data-slide-to="2"></li>
        <li data-target="#productosCarousel" data-slide-to="3"></li>
        <li data-target="#productosCarousel" data-slide-to="4"></li>
        <li data-target="#productosCarousel" data-slide-to="5"></li>
        <li data-target="#productosCarousel" data-slide-to="6"></li>
    </ol>
  
    
    <div class="product-carousel">
        <div class="product-carousel-inner">
            <div class="product-carousel-item">
                <a href="CLMod1.php">
                    <img src="img/imgCLM/CLM1.jpg" alt="COLUMPIO" style="width: 260px; height: auto;">
                </a>
                <div class="product-info">
                    <p class="product-name">COLUMPIO AZUL OSCURO</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="COLUMPIO" data-price="350000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="CLMod2.php">
                    <img src="img/imgCLM/CLM2.jpg" alt="COLUMPIO"style="width: 300px; height: auto;">
                </a>
                <div class="product-info">
                    <p class="product-name">COLUMPIO AZUL CLARO</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="COLUMPIO" data-price="350000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="Clmod3.php">
                    <img src="img/imgCLM/CML3.jpg" alt="COLUMPIO 3"style="width: 270px; height: auto;">
                </a>
                <div class="product-info">
                    <p class="product-name">COLUMPIO BLANCO</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="COLUMPIO" data-price="350000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="CLMod4.php">
                    <img src="img/imgCLM/CML4.png" alt="COLUMPIO 4"style="width: 310px; height: auto;">
                </a>
                <div class="product-info">
                    <p class="product-name">COLUMPIO ROSADO</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="COLUMPIO" data-price="350000">Añadir al carrito</button>
                </div>
            </div>
           
               
            
        </div>
    </div>
    <br><br><br>
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
 





