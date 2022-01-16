<?php
ob_start();

?>
    <section class="form d-flex align-items-center container-mobile-2">
        <div class="shadow-lg round largeurPerso m-auto pt-4 pe-5 ps-5 pb-4">
            <h1 class="text-myBlack text-center mb-4">Modifier l'avatar</h1>
            <?php
            if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                foreach ($_SESSION['error'] as $error) { ?>
                    <p class="text-danger text-center"><?= $error ?></p>
                <?php }
            } ?>
            <div class="mb-2"><img class="w-100 round" alt="avatar" src="public/img/<?= $_SESSION['membre']['avatar'] ?>"></div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="MAX_SIZE_FILE" value="1000000">
                <input class="fichierAvatar" type="file" name="avatar" required>
                <p class="text-center mt-5"><input type="submit" class="bouton w-75 d-inline-block" value="Modifier"></p>
                <p class="text-myBlue text-center"><a href="index.php?route=profil">Retour</a></p>
            </form>
        </div>
    </section>
<?php
unset($_SESSION['error']);
$content = ob_get_clean();
$title = 'Modification de l\'avatar';
require('base.view.php');
?>

