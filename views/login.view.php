<?php

ob_start();
?>
    <section class="form d-flex align-items-center">
        <div class="shadow-lg round largeurPerso m-auto pt-4 pe-5 ps-5 pb-4">
            <h1 class="text-myBlack text-center mb-4">Connexion</h1>
            <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                foreach ($_SESSION['error'] as $error) { ?>
                    <p class="text-danger text-center error-message"><?= $error ?></p>
                <?php }
            } ?>
            <form action="" method="POST" class="d-flex flex-column">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" required>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
                <p class="text-center p-xs">Envie de nous rejoindre ? <a href="index.php?route=inscription" class="text-primary">Créer un compte</a></p>
                <input type="submit" value="Se connecter" class="bouton w-100 m-auto mt-4">
            </form>
        </div>
    </section>
<?php
unset($_SESSION['error']);
$content = ob_get_clean();
$title = 'Connexion';
require('base.view.php');
?>