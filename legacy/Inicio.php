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
    <link rel="stylesheet" href="slider1.css">
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
   

<!--carrusel-->

<style>
.carousel-container {
    max-width: 1200px; /* Cambia este valor según sea necesario */
    margin: 0 auto; /* Centra el contenedor */
    padding: 20px; /* Espacio alrededor del carrusel */
    overflow: hidden; /* Oculta el contenido que sobresale */
}

.carousel-inner img {
    border-radius: 20px; /* Otras opciones de estilo */
    height: 500px; /* Ajusta este valor según lo necesites */
    object-fit: cover; /* Recorta la imagen si es más grande que el contenedor */
}
</style>

<div class="carousel-container">
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="img/carrusel 1.jpg" class="d-block w-100 img-fluid" alt="">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="img/carrusel 2.jpg" class="d-block w-100 img-fluid" alt="">
            </div>
            <div class="carousel-item">
                <img src="img/carrusel 3.jpg" class="d-block w-100 img-fluid" alt="">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

    
    
   
  
      
    <!-- Enlace a Google Fonts para incluir la nueva fuente -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

<center>
    <h1 style="
        font-family: 'Playfair Display', 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 25px;
        color: #121213;
        text-shadow:  #a4f3f8, 0 0 40px  #0b0b0e;
    ">
        Encuentre en nuestra tienda de hamacas la mejor calidad, para amantes de la maestría artesanal y piezas espectaculares.
    </h1>
</center>

<br><br>

<center>
    <h2 style="font-family: 'Playfair Display', serif;">PRODUCTOS DESTACADOS</h2><br>
</center>

    
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
                <a href="/Producto/pro_destacado1.php">
                    <img src="img/imgH/h14.jpg" alt="Hamaca 1">
                </a>
                <div class="product-info">
                    <p class="product-name">HAMACA CON PALO</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="HAMACA CLASICA" data-price="310.000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="/Producto/pro_destacado2.php">
                    <img src="img/imgH/h25.jpg" alt="Hamaca 2">
                </a>
                <div class="product-info">
                    <p class="product-name">HAMACA CLASICA </p>
                    <p class="product-price">$310.000</p>
                    <button class="btn-add-to-cart" data-name="HAMACA CLASICA" data-price="310.000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="/Producto/pro_destacado3.php">
                    <img src="img/imgSC/SC25.jpg" alt="Hamaca 3">
                </a>
                <div class="product-info">
                    <p class="product-name">SILLAS COLGANTES</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="SILLA COLGANTES" data-price="350.000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="/Producto/pro_destacado4.php">
                    <img src="img/imgSC/SC34.jpg" alt="Hamaca 4">
                </a>
                <div class="product-info">
                    <p class="product-name"> COLUMPIO </p>
                    <p class="product-price">$200.000</p>
                    <button class="btn-add-to-cart" data-name="COLUMPIO" data-price="200.000">Añadir al carrito</button>
                </div>
            </div>
            <div class="product-carousel-item">
                <a href="/Producto/pro_destacado5.php">
                    <img src="img/imgCUN/CUN4.jpg" alt="Hamaca 5">
                </a>
                <div class="product-info">
                    <p class="product-name"> CUNA</p>
                    <p class="product-price">$350.000</p>
                    <button class="btn-add-to-cart" data-name="CUNA" data-price="350.000">Añadir al carrito</button>
                </div>
            </div>
        </div>
    </div>

    <!--INFORMACION-->
    <div class="container mt-5">
        <div class="row">
          <!-- Envíos Gratis -->
          <div class="col-md-4 mb-4">
            <div class="card text-center h-100 shadow-sm" style="background-color: #f8f9fa;">
              <div class="card-body">
                <i class="fas fa-shipping-fast fa-3x mb-3" style="color: #28a745;"></i>
                <h5 class="card-title" style="color: #28a745;">Envíos a toda Colombia</h5>
                <p class="card-text">Cualquier hamaca que compres será enviada con un costo adicional a Bogotá, Medellín, Cali o cualquier otra ciudad de Colombia.</p>
              </div>
            </div>
          </div>
          <!-- Calidad Garantizada -->
          <div class="col-md-4 mb-4">
            <div class="card text-center h-100 shadow-sm" style="background-color: #fff3cd;">
              <div class="card-body">
                <i class="fas fa-certificate fa-3x mb-3" style="color: #ffc107;"></i>
                <h5 class="card-title" style="color: #ffc107;">Calidad Garantizada</h5>
                <p class="card-text">Nuestras hamacas artesanales están garantizadas por un año en cuerpo, uniones y amarres.</p>
              </div>
            </div>
          </div>
          <!-- Plataforma de pagos segura -->
          <div class="col-md-4 mb-4">
            <div class="card text-center h-100 shadow-sm" style="background-color: #e2e3e5;">
              <div class="card-body">
                <i class="fas fa-lock fa-3x mb-3" style="color: #17a2b8;"></i>
                <h5 class="card-title" style="color: #17a2b8;">Plataforma de Pagos Segura</h5>
                <p class="card-text">Realiza el pago de tus hamacas de forma fácil y segura a través de PayU,Nequi, la mejor plataforma de pagos en Colombia.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Envíos a Todo el Mundo -->
          <div class="col-md-4 mb-4">
            <div class="card text-center h-100 shadow-sm" style="background-color: #d1ecf1;">
              <div class="card-body">
                <i class="fas fa-globe fa-3x mb-3" style="color: #0dcaf0;"></i>
                <h5 class="card-title" style="color: #0dcaf0;">Envíos a Todo el Mundo</h5>
                <p class="card-text">Hacemos envíos al exterior mediante correo express o regular certificado, garantizado.</p>
              </div>
            </div>
          </div>
          <!-- Satisfacción Garantizada -->
          <div class="col-md-4 mb-4">
            <div class="card text-center h-100 shadow-sm" style="background-color: #d4edda;">
              <div class="card-body">
                <i class="fas fa-smile fa-3x mb-3" style="color: #28a745;"></i>
                <h5 class="card-title" style="color: #28a745;">Satisfacción 100% Garantizada</h5>
                <p class="card-text">Compra con confianza. Satisfacción garantizada o reembolso del 100% de tu dinero.</p>
              </div>
            </div>
          </div>
          <!-- Métodos de Pago -->
          <div class="col-md-4 mb-4">
            <div class="card text-center h-100 shadow-sm" style="background-color: #f8d7da;">
              <div class="card-body">
                <i class="fas fa-credit-card fa-3x mb-3" style="color: #dc3545;"></i>
                <h5 class="card-title" style="color: #dc3545;">Métodos de Pago</h5>
                <p class="card-text">Puedes pagar con tarjeta débito, crédito o mediante transferencia bancaria.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      
   
   
</div>
      
  <br><br><br><br>
  
  
  


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
     









