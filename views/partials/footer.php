<?php
?>

<footer class="footer-sc py-4">
    <div class="container text-center">

        <p class="mb-1 fw-bold">✦ Sabrina Carpenter ✦</p>
        <div class="d-flex justify-content-center gap-3 mb-2">
            <?php foreach ($sitio->redesSociales as $red => $url): ?>
                <a href="<?= $url ?>" target="_blank" class="footer-link">
                    <i class="bi bi-<?= $red ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>

        <p class="text-muted small mb-0">
            © <?= date('Y') ?> CMS Sabrina Carpenter
            — Proyecto Académico UNIMAR · Sistemas III
        </p>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>