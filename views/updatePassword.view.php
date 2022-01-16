<?php

ob_start();

?>
    <section class="form d-flex align-items-center mb-5 container-mobile-2">
        <div class="shadow-lg round largeurPerso m-auto pt-4 pe-5 ps-5 pb-4">
            <h1 class="text-myBlack text-center mb-5">Modifier son mot de passe</h1>
            <form action="" method="POST" class="d-flex flex-column">
                <label for="old_password">Mot de passe actuel <span class="text-danger fw-bold">*</span></label>
                <input type="password" name="old_password" id="old_password">
                <?= isset($_SESSION['error']['actuel']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['actuel'] . '</p>' : '' ?>
                <label for="new_password">Nouveau mot de passe <span class="text-danger fw-bold">*</span></label>
                <input type="password" name="new_password" id="new_password">
                <?= isset($_SESSION['error']['taille']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['taille'] . '</p>' : '' ?>
                <label for="new_password_confirm">Confirmer le mot de passe <span class="text-danger fw-bold">*</span></label>
                <input type="password" name="new_password_confirm" id="new_password_confirm">
                <?= isset($_SESSION['error']['confirm']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['confirm'] . '</p>' : '' ?>
                <p class="text-danger p-xs">* Obligatoire</p>
                <p class="text-center mt-4"><input type="submit" value="Modifier" class="bouton d-inline-block w-75"></p>
                <p class="text-myBlue text-center"><a href="index.php?route=profil">Retour</a></p>
            </form>
        </div>
    </section>
<?php
unset($_SESSION['error']);
$content = ob_get_clean();
$title = 'Modifier son mot de passe';
require('base.view.php');
?>