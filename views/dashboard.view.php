<?php

ob_start();

?>
    <section class="round shadow-lg p-5 container-mobile">
        <h1 class="text-center mb-5">Dashboard</h1>

        <h2 class="mb-3">Articles</h2>
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
                    <th><?= $i ?></th>
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
        <h2 class="mt-5 mb-4" id="categorie">Categories</h2>
        <?= isset($_SESSION['info']['categorie']) ? '<p class="text-danger">' . $_SESSION['info']['categorie'] . '</p>' : '' ?>
        <?= isset($_SESSION['info']['categorieadd']) ? '<p class="text-success">' . $_SESSION['info']['categorieadd'] . '</p>' : '' ?>
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
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                foreach ($categories as $categorie) { ?>
                    <tr>
                        <th><?= $i ?></th>
                        <td><?= $categorie['nom_categorie'] ?></td>
                        <td>
                            <a class="bouton-suppr" href="?route=dashboard&action=deleteCategorie&categorieId=<?= $categorie['id_categorie'] ?>"> Supprimer </a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                } ?>
            </table>
        </div>

        <h2 class="mt-5 mb-5" id="membre">Membres</h2>
        <?= isset($_SESSION['info']['membre']) ? '<p class="text-danger">' . $_SESSION['info']['membre'] . '</p>' : '' ?>
        <table class="table largeur70 m-auto">
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
    </section>
<?php
unset($_SESSION['info']);
$content = ob_get_clean();
require('base.view.php');
?>