<?php

ob_start();

if ($_SESSION['membre']['avatar'] === NULL) {
    $_SESSION['membre']['avatar'] = 'avatar.jpg';
};
?>
    <section class="form d-flex align-items-center container-mobile-2">
        <div class="shadow-lg round largeurPerso m-auto pt-4 pe-5 ps-5 pb-4">
            <h1 class="text-myBlack text-center mb-4">Profil</h1>
            <?php
            if (isset($_SESSION['info']) && !empty($_SESSION['info'])) { ?>
                <p class="text-center text-success"><?= $_SESSION['info'] ?></p>
            <?php } ?>
            <div class=""><img class="w-100 round" alt="avatar" src="public/img/<?= $_SESSION['membre']['avatar'] ?>"></div>
            <p class="text-center fw-bold titre-md mt-1 marge-reset"><?= $_SESSION['membre']['pseudo'] ?></p>
            <p class="text-center p-xs"><?= $_SESSION['membre']['role'] === '0' ? 'Membre' : 'Admin' ?></p>
            <p class="text-center"><a class="bouton d-inline-block w-75" href="?route=profil&action=updateAvatar">Modifier son avatar</a></p>
            <p class="text-center"><a class="bouton d-inline-block w-75" href="?route=profil&action=updatePassword">Modifier son mot de passe</a></p>
            <?php if ($_SESSION['membre']['role'] != 1) { ?>
            <p class="text-center"><a class="bouton-suppr d-inline-block w-75" id="suppr">Supprimer son compte</a></p>
        </div>

        <?php
        } ?>
    </section>
    <script type="text/javascript" src="public/js/profil-script.js">
    </script>
<?php
unset($_SESSION['info']);
$content = ob_get_clean();
$title = 'Profil | ' . $_SESSION['membre']['pseudo'];
require('base.view.php');
?>