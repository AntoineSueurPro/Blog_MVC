<?php

ob_start();
?>
    <section class="form d-flex align-items-center container-mobile-2">
        <div class="shadow-lg round largeurPerso m-auto pt-4 pe-5 ps-5 pb-4">
            <h1 class="text-myBlack text-center mb-5">Contact</h1>
            <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                foreach ($_SESSION['error'] as $error) { ?>
                    <p class="text-danger text-center error-message"><?= $error ?></p>
                <?php }
            }
            if (isset($_SESSION['info']) && !empty($_SESSION['info'])) { ?>
                <p class="text-success text-center"><?= $_SESSION['info'] ?></p>
            <?php } ?>
            <form action="" method="POST">
                <label for="nom">Nom <span class="text-danger fw-bold">*</span></label><br>
                <input type="text" name="nom" id="nom"><br>

                <label for="email">Email <span class="text-danger fw-bold">*</span></label><br>
                <input type="email" name="email" id="email"><br>

                <label for="objet">Objet </label><br>
                <input type="text" name="objet" id="objet"> <br>

                <label for="message">Message <span class="text-danger fw-bold">*</span></label><br>
                <textarea name="message" id="message" rows="10" class="w-100"></textarea><br>
                <p class="text-danger p-xs">* Obligatoire</p>
                <input type="submit" value="Envoyer" class="bouton w-100 m-auto mt-4">
            </form>
        </div>
    </section>
<?php
unset($_SESSION['error']);
$content = ob_get_clean();
require('base.view.php');
?>