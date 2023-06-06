<?php
date_default_timezone_set('America/Mexico_City');
?>

<?php if ($_SESSION['vista']['CLIENTES'] == 1) : ?>
    <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/clientes/'; ?>">
        <i class="bi bi-people-fill"></i> Clientes
    </a>
<?php endif; ?>

<?php
if ($_SESSION['vista']['SERVICIOS (EQUIPOS)'] == 1) : ?>
    <!-- Administrativos -->
    <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-servicios" aria-expanded="false">
        <i class="bi bi-clipboard-heart"></i> Servicios
    </a>
    <div class="collapse" id="board-servicios">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <?php if ($_SESSION['vista']['SERVICIOS (EQUIPOS)'] == 1 || $_SESSION['vista']['SERVICIOS'] == 1) : ?>
                <li><a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/servicios/#Equipos'; ?>"><i class="bi bi-dot"></i> Equipos</a></li>
            <?php endif; ?>
        </ul>
    </div>

<?php endif; ?>




<?php if ($_SESSION['vista']['FACTURACIÓN'] == 1) : ?>
    <!-- Facturacion -->
    <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-facturacion" aria-expanded="false">
        <i class="bi bi-calculator"></i> Facturación
    </a>
    <div class="collapse" id="board-facturacion">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/facturacion/#CONTADO'; ?>"><i class="bi bi-dot"></i> Contado</a></li>
        </ul>
    </div>

<?php endif; ?>


<?php if (
    $_SESSION['vista']['LISTA_PRECIOS'] == 1 ||
    $_SESSION['vista']['PAQUETES_ESTUDIOS'] == 1 ||
    $_SESSION['vista']['COTIZACIONES_ESTUDIOS'] == 1
) : ?>
    <!-- Contaduria -->
    <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-listaprecios" aria-expanded="false">
        <i class="bi bi-tag"></i> Lista de Estudios
    </a>
    <div class="collapse" id="board-listaprecios">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <?php if ($_SESSION['vista']['PAQUETES_ESTUDIOS'] == 1) : ?>
                <li>
                    <a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/lista-precio/#LISTA_PRECIOS'; ?>">
                        <i class="bi bi-dot"></i> Listado de precios
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['vista']['LISTA_PRECIOS'] == 1) : ?>
                <li>
                    <a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/lista-precio/#PAQUETES_ESTUDIOS'; ?>">
                        <i class="bi bi-dot"></i> Paquetes
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['vista']['COTIZACIONES_ESTUDIOS'] == 1) : ?>
                <li>
                    <a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/lista-precio/#COTIZACIONES_ESTUDIOS'; ?>">
                        <i class="bi bi-dot"></i> Cotizaciones
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

<?php endif; ?>

<?php if ($_SESSION['vista']['CURSOS BIMO'] == 1) : ?>
    <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-TALENTOHUMANO" aria-expanded="false">
        <i class="bi bi-people"></i> Talento Humano
    </a>
    <div class="collapse" id="board-TALENTOHUMANO">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <?php if ($_SESSION['vista']['CURSOS BIMO'] == 1) : ?>
                <li>
                    <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/cursos-bimo/'; ?>" class="dropdown-a" type="button">
                        <i class="bi bi-dot"></i> Cursos
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

<?php endif; ?>