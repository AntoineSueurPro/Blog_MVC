<?php

ob_start();

?>
    <section class="round shadow-lg p-5 container-mobile dashboard d-flex">
        <?php if(isset($_GET['onglet'])) { ?>
            <input id="onglet" type="hidden" value="<?= $_GET['onglet'] ?>">
        <?php } ?>
        <div id="menuDashboard" class="myBackground largeur15 text-white fw-bold border p-3 rounded">
            <h1 class="mb-5 fs-3 text-center pb-2 border-bottom">Dashboard</h1>
            <div class="d-flex flex-column justify-content-center">
                <p id="vueEnsemble"><i class="far fa-chart-bar fs-3 mb-3 me-2"></i> Vue d'ensemble</p>
                <p id="vueArticles"><i class="far fa-newspaper fs-3 mb-3 me-2"></i> Articles</p>
                <p id="vueCategories"><i class="far fa-bookmark fs-3 mb-3 me-2"></i> Categories</p>
                <p id="vueMembres"><i class="far fa-user fs-3 mb-3 me-2"></i> Membres</p>
            </div>
        </div>
        <div id="contenuDashboard" class="largeur80 ms-5">
            <div id="overview">
                <h2 class="mb-3"><i class="far fa-chart-bar fs-2 mb-3 me-2"></i>Vue d'ensemble</h2>
                <div class="d-flex justify-content-between flex-wrap">

                    <div id="graphViews" class="largeur45 border p-2"></div>
                    <div id="graphMembers" class="largeur45 border p-2"></div>
                    <div id="graphContainer" class="largeur45 border p-2 mt-5"></div>
                    <div id="" class="largeur45 p-2 mt-5">
                        <h2 class="mb-4">Derniers commentaires :</h2>
                        <?php foreach ($lastComments as $commentaire) {
                            if ($commentaire['avatar'] === NULL) {
                            $commentaire['avatar'] = 'avatar.jpg';
                            } ?>
                            <div class="d-flex m-auto commentaire">
                                <div class="d-flex flex-column">
                                    <div>
                                        <img class="avatar_dashboard" src="public/img/<?= $commentaire['avatar'] ?>">
                                    </div>
                                    <p class="fw-bold text-center"><?= $commentaire['pseudo'] ?></p>
                                </div>

                                <div class="d-flex flex-column ms-3">
                                    <div class="d-flex">
                                        <p class="ms-3"><a class="text-danger"
                                                           href="index.php?route=article&action=deleteComment&commentId=<?= $commentaire['id_commentaire'] ?>"><i
                                                        class="far fa-trash-alt suppr"></i> Supprimer</a></p>
                                        <p class="ms-3"><a class="blue" target="_blank"
                                                           href="index.php?route=article&articleId=<?= $commentaire['id_article'] ?>"><i
                                                        class="fas fa-external-link-alt"></i> Voir l'article</a></p>

                                    </div>
                                    <?= substr(html_entity_decode($commentaire['contenu']), 0, 125) . '...' ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div id="sectionArticles" class="d-none ms-5">
                <h2 class="mb-3"><i class="far fa-newspaper fs-2 mb-3 me-2"></i>Articles</h2>
                <?= isset($_SESSION['info']['article']) ? '<p class="text-danger">' . $_SESSION['info']['article'] . '</p>' : '' ?>
                <?= isset($_SESSION['info']['articlemodif']) ? '<p class="text-success">' . $_SESSION['info']['articlemodif'] . '</p>' : '' ?>
                <?= isset($_SESSION['info']['articleadd']) ? '<p class="text-success">' . $_SESSION['info']['articleadd'] . '</p>' : '' ?>

                <p class="text-end"><a href="?route=dashboard&action=addArticle" class="bouton">Ajouter un article</a></p>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Contenu</th>
                        <th scope="col">Date publication</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Categorie</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach ($articles as $article) { ?>
                        <tr>
                            <th><?= $article['id_article'] ?></th>
                            <td><?= $article['titre'] ?></td>
                            <td> <?= substr($article['contenu'], 0, 350) . '...' ?></td>
                            <td><?= $article['created_at'] ?></td>
                            <td><?= $article['auteur'] ?></td>
                            <td><?= $article['categorie'] ?></td>
                            <td><p><a class="bouton d-inline-block w-100 text-center"
                                      href="?route=dashboard&action=editArticle&articleId=<?= $article['id_article'] ?>"> Modifier </a></p>
                                <a class="bouton-suppr d-inline-block w-100 text-center"
                                   href="?route=dashboard&action=deleteArticle&articleId=<?= $article['id_article'] ?>"> Supprimer </a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    } ?>
                </table>
            </div>
            <div id="sectionCategories" class="d-none ms-5">
                <h2 class=" mb-4" id="categorie"><i class="far fa-bookmark fs-2 mb-3 me-2"></i>Categories</h2>
                <?= isset($_SESSION['info']['categorie']) ? '<p class="text-danger">' . $_SESSION['info']['categorie'] . '</p>' : '' ?>
                <?= isset($_SESSION['success']) ? '<p class="text-success">' . $_SESSION['success'] . '</p>' : '' ?>
                <div class="toble">
                    <form action="" method="POST">
                        <input type="text" name="nom_categorie" id="nom_categorie">
                        <input type="submit" class="bouton" value="Ajouter">
                    </form>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($categories as $categorie) { ?>
                            <tr>
                                <th><?= $i ?></th>
                                <td><?= $categorie['nom_categorie'] ?></td>
                                <td class="text-center">
                                    <a class="bouton-suppr" href="?route=dashboard&action=deleteCategorie&categorieId=<?= $categorie['id_categorie'] ?>">
                                        Supprimer </a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        } ?>
                    </table>
                </div>
                <div id="graphCategories" class="border rounded p-2 mt-5"></div>
            </div>
            <div id="sectionMembres" class="d-none ms-5">
                <h2 class="mb-5" id="membre"><i class="far fa-user fs-2 mb-3 me-2"></i>Membres</h2>
                <?= isset($_SESSION['info']['membre']) ? '<p class="text-danger">' . $_SESSION['info']['membre'] . '</p>' : '' ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Pseudo</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($membres as $membre) { ?>
                        <tr>
                            <th><?= $membre['id_membre'] ?></th>
                            <td><?= $membre['pseudo'] ?></td>
                            <td><?= $membre['email'] ?></td>
                            <td><?= $membre['role'] === '0' ? 'Membre' : 'Admin' ?></td>

                            <td>
                                <a class="bouton-suppr" href="?route=dashboard&action=deleteMembre&membreId=<?= $membre['id_membre'] ?>"> Supprimer </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
<?php
unset($_SESSION['info']);
unset($_SESSION['success']);
$content = ob_get_clean();
$title = 'Dahsboard';
require('base.view.php');
?>