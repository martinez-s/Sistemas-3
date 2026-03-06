<?php
session_start();

require_once '../db/conexion.php';
require_once '../models/SitioWeb.php';
require_once '../models/EraMusical.php';
require_once '../models/FechaTour.php';
require_once '../controllers/TourController.php';

$sitio  = SitioWeb::obtenerInstancia();
$era    = EraMusical::crearDesdeNombre("Short n Sweet Era");
$ctrl   = new TourController($conexion);
$fechas = $ctrl->listarFechas();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour — Sabrina Carpenter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <?= $era->mostrarEstilo() ?>
</head>

<body>

    <?php require_once 'partials/navbar.php'; ?>

    <div class="page-header text-center py-5">
        <span class="section-eyebrow">✦ En vivo ✦</span>
        <h1 class="section-title">Short n Sweet Tour</h1>
        <p class="text-muted">Todas las fechas del tour mundial 2025</p>
    </div>

    <div class="container pb-5">

        <div class="d-flex gap-3 justify-content-center mb-4 flex-wrap">
            <span><span class="badge bg-success">Disponible</span> Entradas a la venta</span>
            <span><span class="badge bg-danger">Agotado</span> Sin entradas</span>
            <span><span class="badge bg-secondary">Próximamente</span> Preventa próxima</span>
        </div>

        <div class="text-center mb-4">
            <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm active"
                    onclick="filtrar('todos', this)">Todos</button>
                <button class="btn btn-outline-success btn-sm"
                    onclick="filtrar('disponible', this)">Disponibles</button>
                <button class="btn btn-outline-secondary btn-sm"
                    onclick="filtrar('proximo', this)">Próximamente</button>
            </div>
        </div>

        <?php if (empty($fechas)): ?>
            <p class="text-center text-muted py-5">No hay fechas disponibles.</p>
        <?php else: ?>

            <div class="row g-3" id="lista-fechas">
                <?php foreach ($fechas as $f): ?>
                    <div class="col-12 fecha-item" data-estado="<?= $f['estadoTicket'] ?>">
                        <div class="tour-card-full d-flex align-items-center gap-4 p-4">

                            <div class="tour-date-box text-center flex-shrink-0">
                                <span class="tour-month">
                                    <?= strtoupper(date('M', strtotime($f['fechaHora']))) ?>
                                </span>
                                <span class="tour-day">
                                    <?= date('d', strtotime($f['fechaHora'])) ?>
                                </span>
                                <span class="tour-year">
                                    <?= date('Y', strtotime($f['fechaHora'])) ?>
                                </span>
                            </div>

                            <div class="flex-grow-1">
                                <h5 class="mb-0 fw-bold">
                                    <?= htmlspecialchars($f['ciudad']) ?>,
                                    <span class="fw-normal text-muted">
                                        <?= htmlspecialchars($f['pais']) ?>
                                    </span>
                                </h5>
                                <p class="mb-0 text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    <?= htmlspecialchars($f['recinto']) ?>
                                </p>
                                <p class="mb-0 text-muted small">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('H:i', strtotime($f['fechaHora'])) ?> hrs
                                </p>
                            </div>

                            <div class="d-flex flex-column align-items-end gap-2">
                                <?php
                                $badge = match ($f['estadoTicket']) {
                                    'disponible' => ['success', 'Disponible'],
                                    'agotado'    => ['danger',  'Agotado'],
                                    default      => ['secondary', 'Próximamente'],
                                };
                                ?>
                                <span class="badge bg-<?= $badge[0] ?> rounded-pill px-3 py-2">
                                    <?= $badge[1] ?>
                                </span>

                                <?php if ($f['estadoTicket'] === 'disponible' && !empty($f['urlVentaExterna'])): ?>
                                    <a href="<?= htmlspecialchars($f['urlVentaExterna']) ?>"
                                        target="_blank" class="btn btn-sc-dark btn-sm">
                                        <i class="bi bi-ticket-perforated me-1"></i>Comprar
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>

    <section class="suscripcion-section py-5 text-center">
        <div class="container">
            <h4 class="fw-bold mb-2">¿No ves tu ciudad?</h4>
            <p class="text-muted">Suscríbete y sé el primero en enterarte de nuevas fechas.</p>
            <a href="index.php#suscripcion" class="btn btn-sc-primary px-5">Suscribirme</a>
        </div>
    </section>

    <?php require_once 'partials/footer.php'; ?>

    <script>
        function filtrar(estado, boton) {

            document.querySelectorAll('.btn-group .btn')
                .forEach(b => b.classList.remove('active'));

            boton.classList.add('active');

            document.querySelectorAll('.fecha-item').forEach(el => {
                if (estado === 'todos' || el.dataset.estado === estado) {
                    el.style.display = ''; 
                } else {
                    el.style.display = 'none'; 
                }
            });
        }
    </script>

</body>

</html>