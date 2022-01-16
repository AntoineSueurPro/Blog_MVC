<?php

ob_start();

$created_at = explode("-", $article['created_at']);
$created_at = array_reverse($created_at);
$created_at = implode("-", $created_at)
?>
    <section class="round shadow-lg p-5 container-mobile">
        <?php if (isset($_SESSION['error']['contenu'])) {
            echo '<p class="text-danger text-center">' . $_SESSION['error']['contenu'] . '</p>';
        } ?>
        <div class="largeur90 m-auto">
            <h1 class="titre-xl text-myBlack mb-5">Mon Blog</h1>
            <div class="hero mb-5" style="background-image: url('public/img/<?= $article['image'] ?>')"></div>
            <div class="d-flex justify-content-center flex-column test_contenu">
                <div class="gap-3 mb-4 titre_categorie">
                    <h2 class="gros_h2"><?= $article['titre'] ?></h2>
                    <p class="text-center categorie-article item-categorie selected"> <?= $article['categorie'] ?></p>
                </div>
                <?= $article['contenu'] ?>
                <p class="text-end mt-3"><?= $article['auteur'] ?> le <?= $created_at ?></p>
                <p class="text-end"></p>
            </div>
            <h2 class="gros_h2 text-center mb-5 mt-5">Commentaires <span class="fw-regular">(<?= $nb_commentaires ?>)</span></h2>
            <?php
            if($nb_commentaires === 0) {
                echo '<p class="text-center">Il n\'y a aucun commentaires. Soyez le premier à commenter !</p>';
            }
            foreach ($commentaires as $commentaire) {
                if ($commentaire['avatar'] === NULL) {
                    $commentaire['avatar'] = 'avatar.jpg';
                };
                $commentaire['created_at'] = explode("-", $commentaire['created_at']);
                $commentaire['created_at'] = array_reverse($commentaire['created_at']);
                $commentaire['created_at'] = implode("-", $commentaire['created_at']);


                ?>

                <div class="d-flex m-auto commentaire">
                    <div class="d-flex flex-column">
                        <div>
                            <img class="avatar_article" src="public/img/<?= $commentaire['avatar'] ?>">
                        </div>
                        <p class="fw-bold text-center"><?= $commentaire['auteur'] ?></p>
                    </div>

                    <div class="d-flex flex-column ms-3">
                        <div class="d-flex">
                            <p class="date_article">• Le <?= $commentaire['created_at'] ?></p>
                            <?php if (isset($_SESSION['membre']) && $_SESSION['membre']['role'] === '1' || (isset($_SESSION['membre']) && $commentaire['id_membre'] === $_SESSION['membre']['id_membre'])) { ?>
                                <p class="ms-3"><a class="text-danger"
                                                   href="index.php?route=article&action=deleteComment&commentId=<?= $commentaire['id_commentaire'] ?>"><i
                                                class="far fa-trash-alt suppr"></i> Supprimer</a></p>
                            <?php } ?>
                        </div>
                        <?= html_entity_decode($commentaire['contenu']) ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['info'])) {
                echo '<p class="text-danger text-center">' . $_SESSION['info'] . '</p>';
            } ?>

            <div class="commenter m-auto">
                <h2 class="gros_h2 text-center mb-5 mt-5" id="commentaire">Publier un commentaire</h2>
                <?php
                if (isset($_SESSION['membre'])) { ?>
                    <form action="" method="POST">
                        <textarea name="contenu" id="contenu_com"></textarea>
                        <p class="text-end mt-3 commenter"><input type="submit" class="bouton d-inline-block" value="Publier"></p>
                    </form>

                <?php } else { ?>
                    <p class="text-center">Veuillez vous <a class="text-primary fw-bold" href="index.php?route=login">connecter</a> pour publier un commentaire.
                    </p>
                <?php } ?>
            </div>
        </div>

    </section>
    <script>
        tinymce.init({
            selector: '#contenu_com',
            menubar: false,
            toolbar: 'bold italic | align',
            resize: false
        });
    </script>
<?php
unset($_SESSION['error']['contenu']);
unset($_SESSION['info']);
$content = ob_get_clean();
require('base.view.php');
?>