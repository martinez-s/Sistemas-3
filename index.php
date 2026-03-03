<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabrina Carpenter - Sitio Oficial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-color: #f8c8d8;
            padding: 100px 0;
            text-align: center;
        }
        .btn-custom {
            background-color: #d1495b;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sabrina Carpenter</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#discografia">Discografía</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tour">Tour</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Nueva Era, Nuevo Tour</h1>
            <p class="lead">Descubre las últimas novedades, música y fechas de conciertos oficiales.</p>
            <a href="#tour" class="btn btn-custom btn-lg mt-3">Ver Fechas del Tour</a>
        </div>
    </section>

    <section class="container my-5" id="suscripcion">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h2>Únete a la comunidad</h2>
                <p>Suscríbete para recibir noticias exclusivas y acceso anticipado a boletos.</p>
                
                <form action="procesar_suscripcion.php" method="POST" class="mt-4">
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="pais" required>
                            <option value="" disabled selected>Selecciona tu país</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Mexico">México</option>
                            <option value="Argentina">Argentina</option>
                            <option value="España">España</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Suscribirme</button>
                </form>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>