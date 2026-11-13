<?php
session_start();
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    

    <!-- Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../../css/tiny-slider.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <title>Artesanias De Tejidos Ortega</title>
</head>

<body>

    <?php require_once('encabezado.php'); ?>

    <div class="untree_co-section d-flex align-items-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-8 text-center">
                    <h2 class="mb-4 section-title">Bienvenid@ <?php echo $_SESSION['usuario']; ?></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 d-flex justify-content-center">
                    <div class="row w-100 text-center">
                        <div class="col-4">
                            <div class="service no-shadow align-items-center link d-flex flex-column justify-content-center" data-aos="fade-left" data-aos-delay="0">
                                <div class="service-icon color-1 mb-3">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="service-contents">
                                    <a href="<?php echo URL_BASE; ?>administrador/clientes.php">
                                        <p><b>CLIENTES</b></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="service no-shadow align-items-center link d-flex flex-column justify-content-center" data-aos="fade-left" data-aos-delay="0">
                                <div class="service-icon color-1 mb-3">
                                    <i class="bi bi-basket"></i>
                                </div>
                                <div class="service-contents">
                                    <a href="<?php echo URL_BASE; ?>administrador/productos.php">
                                        <p><b>PRODUCTOS</b></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="service no-shadow align-items-center link d-flex flex-column justify-content-center" data-aos="fade-left" data-aos-delay="0">
                                <div class="service-icon color-1 mb-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="service-contents">
                                    <a href="<?php echo URL_BASE; ?>administrador/usuarios.php">
                                        <p><b>USUARIOS</b></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/tiny-slider.js"></script>
    <script src="../../js/custom.js"></script>
</body>

</html>

