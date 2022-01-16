<?php

ob_start();
?>
    <section class="form d-flex align-items-center container-mobile-2">
        <div class="shadow-lg round largeurPerso m-auto pt-4 pe-5 ps-5 pb-4">
            <h1 class="text-myBlack text-center mb-5">Inscription</h1>
            <?= isset($_SESSION['error']['exist']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['exist'] . '</p>' : '' ?>
            <form action="" method="POST" class="d-flex flex-column">
                <label for="pseudo">Pseudo <span class="text-danger fw-bold">*</span></label>
                <input type="text" name="pseudo" id="pseudo" required>
                <?= isset($_SESSION['error']['pseudo']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['pseudo'] . '</p>' : '' ?>
                <label for="email">E-mail <span class="text-danger fw-bold">*</span></label>
                <input type="email" name="email" id="email" required>
                <?= isset($_SESSION['error']['email']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['email'] . '</p>' : '' ?>
                <label for="password">Mot de passe <span class="text-danger fw-bold">*</span></label>
                <input type="password" name="password" id="password" required>
                <?= isset($_SESSION['error']['password']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['password'] . '</p>' : '' ?>
                <label for="password_confirm">Confirmez votre mot de passe <span class="text-danger fw-bold">*</span></label>
                <input type="password" name="password_confirm" id="password_confirm" required>
                <?= isset($_SESSION['error']['confirm']) ? '<p class="text-danger text-center error-message">' . $_SESSION['error']['confirm'] . '</p>' : '' ?>
                <p class="text-danger p-xs">* Obligatoire</p>
                <input type="submit" value="S'inscrire" class="bouton w-100 m-auto mt-4">
            </form>
        </div>
    </section>
<?php
unset($_SESSION['error']);
$content = ob_get_clean();
$title = 'Inscription';
require('base.view.php');
?>