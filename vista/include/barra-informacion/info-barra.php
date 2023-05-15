<!-- Cambiarlo dinamicamente a proximo... -->
<?php
$tipPanel = $_POST['tip'];
$nivel = isset($_POST['nivel']) ? $_POST['nivel'] : '';
 ?>
<div class="m-2">
  <?php
    include "tip/".$tipPanel.$nivel.".html";
  ?>
</div>
