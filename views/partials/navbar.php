<?php
$paginaActual = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-sc sticky-top">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">✦ Sabrina Carpenter</a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-2">

                <?php
                $enlaces = [
                    "index.php"       => "Inicio",
                    "discografia.php" => "Discografía",
                    "tour.php"        => "Tour",
                ];

                foreach ($enlaces as $url => $nombre):
                    $activo = ($paginaActual === $url) ? "active" : "";
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $activo ?>" href="<?= $url ?>">
                            <?= $nombre ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <li class="nav-item">
                    <a class="nav-link" href="index.php#suscripcion">Comunidad</a>
                </li>

            </ul>

            <div class="ms-3 d-flex gap-2">
                <?php foreach ($sitio->redesSociales as $red => $url): ?>
                    <a href="<?= $url ?>" target="_blank"
                        class="btn btn-sm btn-outline-dark rounded-circle"
                        title="<?= ucfirst($red) ?>">
                        <i class="bi bi-<?= $red ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</nav>