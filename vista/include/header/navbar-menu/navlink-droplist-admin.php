<?php
date_default_timezone_set('America/Mexico_City');
?>





<?php if ($_SESSION['vista']['FACTURACIÓN'] == 1) : ?>
    <!-- Facturacion -->
    <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-facturacion" aria-expanded="false">
        <i class="bi bi-calculator"></i> Facturación
    </a>
    <div class="collapse" id="board-facturacion">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <?php if ($_SESSION['vista']['FACTURACIÓN'] == 1) : ?>
                <li>
                    <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/facturacion/'; ?>" class="dropdown-a align-items-center" type="button">
                        <i class="bi bi-dot"></i> Crédito
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

<?php endif; ?>