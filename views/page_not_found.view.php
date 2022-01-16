<?php

ob_start();

?>
    <h1>Page non trouvée.</h1>


<?php

$content = ob_get_clean();
$title = 'Page non trouvée';
require('base.view.php');
?>