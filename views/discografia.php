<?php
session_start();

require_once '../db/conexion.php';
require_once '../models/SitioWeb.php';
require_once '../models/EraMusical.php';
require_once '../models/Album.php';
require_once '../controllers/AlbumController.php';

$sitio = SitioWeb::obtenerInstancia();
$era   = EraMusical::crearDesdeNombre("Short n Sweet Era");
$ctrl  = new AlbumController($conexion);

$detalle = null;
if (isset($_GET['album']) && is_numeric($_GET['album'])) {
    $detalle = $ctrl->detalle((int)$_GET['album']);
} else {
    $albums = $ctrl->listarAlbumes();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discografía — Sabrina Carpenter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <?= $era->mostrarEstilo() ?>
</head>

<body>

    <?php require_once 'partials/navbar.php'; ?>

    <div class="page-header text-center py-5">
        <span class="section-eyebrow">✦ Música ✦</span>
        <h1 class="section-title">Discografía</h1>
    </div>

    <div class="container pb-5">

        <?php if ($detalle): ?>

            <a href="discografia.php" class="btn btn-outline-secondary mb-4">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="album-card-detail">
                        <div class="album-cover-lg d-flex align-items-center justify-content-center">
                            <i class="bi bi-music-note-beamed fs-1 text-muted"></i>
                        </div>
                        <div class="p-3">
                            <h3 class="fw-bold"><?= htmlspecialchars($detalle['album']['titulo']) ?></h3>
                            <p class="text-muted">
                                <?= date('d/m/Y', strtotime($detalle['album']['fechaLanzamiento'])) ?>
                            </p>
                            <?php if (!empty($detalle['album']['descripcion'])): ?>
                                <p><?= htmlspecialchars($detalle['album']['descripcion']) ?></p>
                            <?php endif; ?>

                            <?php if (!empty($detalle['album']['spotifyUrl'])): ?>
                                <a href="<?= htmlspecialchars($detalle['album']['spotifyUrl']) ?>"
                                    target="_blank" class="btn btn-spotify">
                                    <i class="bi bi-spotify me-1"></i>Spotify
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <h4 class="mb-3 fw-bold">Lista de canciones</h4>

                    <?php if (empty($detalle['tracklist'])): ?>
                        <p class="text-muted">No hay canciones registradas aún.</p>
                    <?php else: ?>
                        <div class="tracklist">
                            <?php foreach ($detalle['tracklist'] as $c): ?>
                                <div class="track-item d-flex align-items-center gap-3 p-3">

                                    <span class="track-num">
                                        <?= str_pad($c['numeroPista'], 2, '0', STR_PAD_LEFT) ?>
                                    </span>

                                    <span class="track-title flex-grow-1">
                                        <?= htmlspecialchars($c['titulo']) ?>
                                    </span>

                                    <span class="track-duration text-muted small">
                                        <?= floor($c['duracionSegundos'] / 60) ?>:<?= str_pad($c['duracionSegundos'] % 60, 2, '0', STR_PAD_LEFT) ?>
                                    </span>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        <?php else: ?>

            <div class="row g-4">
                <?php foreach ($albums as $a): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="discografia.php?album=<?= $a['id'] ?>" class="text-decoration-none">
                            <div class="album-card h-100">
                                <div class="album-cover-placeholder">
                                    <div class="album-no-cover d-flex align-items-center justify-content-center">
                                        <i class="bi bi-music-note-beamed fs-1 text-muted"></i>
                                    </div>
                                </div>
                                <div class="album-info p-3">
                                    <h6 class="album-title mb-0"><?= htmlspecialchars($a['titulo']) ?></h6>
                                    <p class="album-meta small text-muted mb-0">
                                        <?= date('Y', strtotime($a['fechaLanzamiento'])) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>

    <?php require_once 'partials/footer.php'; ?>
</body>

</html>