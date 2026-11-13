<?php
$servidor = $_SERVER['HTTP_HOST'];

define('URL_BASE', 'http://' . $servidor . '/HAMACAS sin/');
?>

<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark fixed-top p-0" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="<?php echo URL_BASE; ?>administrador/index.php">
            <img src="<?php echo URL_BASE; ?>img/LOGO HAMACAS.jpg" style="width: 10%;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo URL_BASE; ?>administrador/index.php">Inicio</a>
                </li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li><a class="nav-link" href="<?php echo URL_BASE; ?>login.php" title="ver perfil"><img src="<?php echo URL_BASE; ?>img/logo inicio.png" style="width: 20px;"></a></li>
                <li><a class="nav-link" href="<?php echo URL_BASE; ?>include/salir.php" title="Salir de la cuenta"><img src="<?php echo URL_BASE; ?>img/salida.png" style="width: 20px;"></a></li>
            </ul>
        </div>
    </div>
</nav>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="./bootstrap-5.2.3-dist/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="./bootstrap-5.2.3-dist/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">