<?php
ob_start();
if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    foreach ($_SESSION['error'] as $error) { ?>
        <p><?= $error ?></p>
    <?php }
}
unset($_SESSION['error']);
if(isset($_SESSION['info'])) { ?>
<p><?= $_SESSION['info']?></p>
<?php }
unset($_SESSION['info']);
?>

<?php foreach ($categories as $categorie) { ?>
    <p>Nom : <?= $categorie['nom_categorie']?></p>
        <?php }?>

    <form action="" method="POST">
        <label for="nom_categorie">Nom de la catégorie</label>
        <input type="text" name="nom_categorie" id="nom_categorie">
        <input type="submit" value="Ajouter">
    </form>
<?php

$content = ob_get_clean();
require('base.view.php');
?>