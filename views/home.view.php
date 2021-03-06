<?php

ob_start();
if (isset($_SESSION['info']) && !empty($_SESSION['info'])) { ?>
    <p><?= $_SESSION['info'] ?></p>
<?php }
unset($_SESSION['info']);
$created_at = explode("-", $article['created_at']);
$created_at = array_reverse($created_at);
$created_at = implode("-", $created_at)
?>
<section class="round shadow-lg p-5 container-mobile">
    <h1 class="titre-xl mb-5 text-myBlack">Mon Blog</h1>
    <div class="hero hero_image d-flex align-items-end" style="background-image: url('public/img/<?= $article['image']?>')">
        <div class="hero-text p-3">
            <div class="hero-text-content">
                <p class="hero-date"><?= $created_at ?></p>
                <h2 class="gros_h2"><a class="text-white" href="index.php?route=article&articleId=<?= $article['id_article']?>"> <?= $article['titre'] ?></a></h2>
                <div class="hero-p">
                    <?= substr($article['contenu'], 0, 92) . '...'?>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex div_categorie gap-3 w-75 justify-content-center m-auto">
        <div class="categorie selected item-categorie">Tout</div>
        <?php foreach ($categories as $categorie) { ?>
            <div class="categorie item-categorie"><?= $categorie['nom_categorie'] ?></div>
        <?php } ?>
    </div>


    <div id="content" class="d-flex flex-wrap gap-5 conteneur_article justify-content-center justify-content-lg-start"></div>
</section>
<?php
$content = ob_get_clean();
$title = 'Accueil';
require('base.view.php');
?>