<?php

ob_start();

?>
    <h1>Erreur serveur.</h1>


<?php

$content = ob_get_clean();
require('base.view.php');
?>