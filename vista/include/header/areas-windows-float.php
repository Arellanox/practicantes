<?php if (
    $_SESSION['vista']['FACTURACIÓN'] == 1
) : ?>
    <li class="nav-item Recepción">
        <div class="dropdown ">
            <a class="dropdown-toggle" id="dropadmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-briefcase"></i> Administración
            </a>
            <!-- Estos botones se cargan en el servidor desde el archivo del include -->
            <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropadmin">
                <?php include "navbar-menu/navlink-droplist-admin.php"; ?>
            </ul>
        </div>
    </li>
<?php endif; ?>

<?php if ($_SESSION['perfil'] == 1) : ?>
    <li class="nav-item Recepción">
        <div class="dropdown ">
            <a class="dropdown-toggle" id="dropTI" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-motherboard"></i> TI
            </a>
            <!-- Estos botones se cargan en el servidor desde el archivo del include -->
            <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropTI">
                <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/administracion/#USUARIOS'; ?>">
                    <i class="bi bi-person-fill-gear"></i> Usuarios
                </a>
            </ul>
        </div>
    </li>
<?php endif; ?>