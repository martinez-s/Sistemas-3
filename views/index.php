<?php
session_start();

require_once '../db/conexion.php';
require_once '../models/SitioWeb.php';
require_once '../models/EraMusical.php';
require_once '../models/Album.php';
require_once '../models/FechaTour.php';
require_once '../controllers/AlbumController.php';
require_once '../controllers/TourController.php';

$sitio = SitioWeb::obtenerInstancia();
$seo   = $sitio->configurarSEO();
$era = EraMusical::crearDesdeNombre("Short n Sweet Era");
$albumCtrl = new AlbumController($conexion);
$albums    = array_slice($albumCtrl->listarAlbumes(), 0, 3);
$tourCtrl = new TourController($conexion);
$fechas   = array_slice($tourCtrl->listarFechas(), 0, 4);
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($seo['title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seo['description']) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <?= $era->mostrarEstilo() ?>
</head>

<body>

    <?php require_once 'partials/navbar.php'; ?>

    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['tipo'] === 'success' ? 'success' : 'danger' ?>
            alert-dismissible fade show m-0 text-center">
            <?= htmlspecialchars($flash['mensaje']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>


    <section class="hero-section">
        <div class="container position-relative z-1 py-5">
            <p class="hero-eyebrow">✦ Short n Sweet Tour — 2025 ✦</p>
            <h1 class="hero-title">Sabrina<br>Carpenter</h1>
            <p class="hero-subtitle">Música. Moda. Magia. Todo en un solo lugar.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                <a href="tour.php" class="btn btn-hero-primary btn-lg px-5">Ver Tour</a>
                <a href="discografia.php" class="btn btn-hero-outline btn-lg px-5">Discografía</a>
            </div>
        </div>
    </section>


    <section class="container my-5 py-3">
        <div class="section-header text-center mb-5">
            <span class="section-eyebrow">✦ Música ✦</span>
            <h2 class="section-title">Discografía</h2>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($albums as $a): ?>
                <div class="col-sm-6 col-md-4">
                    <div class="album-card">
                        <div class="album-cover-placeholder">
                            <div class="album-no-cover d-flex align-items-center justify-content-center">
                                <i class="bi bi-music-note-beamed fs-1 text-muted"></i>
                            </div>
                        </div>
                        <div class="album-info p-3">
                            <h5 class="album-title mb-1"><?= htmlspecialchars($a['titulo']) ?></h5>
                            <p class="album-meta mb-0">
                                <?= date('Y', strtotime($a['fechaLanzamiento'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4">
            <a href="discografia.php" class="btn btn-outline-sc">Ver toda la discografía →</a>
        </div>
    </section>


    <section class="tour-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-eyebrow">✦ En vivo ✦</span>
                <h2 class="section-title">Short n Sweet Tour</h2>
            </div>

            <div class="row g-3">
                <?php foreach ($fechas as $f): ?>
                    <div class="col-12 col-md-6">
                        <div class="tour-card d-flex align-items-center gap-3 p-3">

                            <div class="tour-date-box text-center">
                                <span class="tour-month">
                                    <?= strtoupper(date('M', strtotime($f['fechaHora']))) ?>
                                </span>
                                <span class="tour-day">
                                    <?= date('d', strtotime($f['fechaHora'])) ?>
                                </span>
                            </div>

                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($f['ciudad']) ?></h6>
                                <p class="mb-0 text-muted small"><?= htmlspecialchars($f['recinto']) ?></p>
                            </div>

                            <?php                       
                            $badge = match ($f['estadoTicket']) {
                                'disponible' => ['success', 'Disponible'],
                                'agotado'    => ['danger',  'Agotado'],
                                default      => ['secondary', 'Próximamente'],
                            };
                            ?>
                            <span class="badge bg-<?= $badge[0] ?> rounded-pill">
                                <?= $badge[1] ?>
                            </span>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="tour.php" class="btn btn-outline-sc">Ver todas las fechas →</a>
            </div>
        </div>
    </section>

    <section class="suscripcion-section py-5" id="suscripcion">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <span class="section-eyebrow">✦ Comunidad ✦</span>
                    <h2 class="section-title mb-2">Únete a los Carpenters</h2>
                    <p class="text-muted mb-4">
                        Suscríbete para recibir noticias exclusivas y acceso anticipado a boletos.
                    </p>

                    <form action="../controllers/SuscriptorController.php" method="POST">
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-sc"
                                name="email" placeholder="Tu correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select form-control-sc" name="pais" required>
                                <option value="" disabled selected>Selecciona tu país</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Mexico">México</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Colombia">Colombia</option>
                                <option value="España">España</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sc-primary w-100">
                            <i class="bi bi-envelope-heart me-2"></i>Suscribirme
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <?php require_once 'partials/footer.php'; ?>

</body>
</html>