<?php
ob_start();

$isEditing = isset($article) ?? true;
$isAdding = isset($article) ?? false;
?>

    <section class="d-flex align-items-center">
        <div class="round shadow-lg p-5 m-auto w-100">
            <h1 class="text-myBlack text-center mb-4"><?= $isEditing === true ? 'Modification d\'article' : 'Publication d\'article' ?></h1>
            <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                foreach ($_SESSION['error'] as $error) { ?>
                    <p class="text-danger text-center"><?= $error ?></p>
                <?php }
            } ?>
            <form action="" method="POST" enctype="multipart/form-data" class="d-flex flex-column">
                <label for="categorie" class="mb-1 fw-bold">Catégorie</label>
                <select class="d-inline-block largeur10 mb-2" name="categorie" id="categorie">
                    <option <?php if ($isAdding && $article['id_categorie'] === NULL)
                        echo 'selected' ?>></option>
                    <?php foreach ($categories as $categorie) { ?>
                        <option value="<?= $categorie['id_categorie'] ?>"
                            <?php if ($isEditing && $categorie['id_categorie'] === $article['id_categorie'])
                                echo 'selected'
                            ?>
                        ><?= $categorie['nom_categorie'] ?></option>
                    <?php } ?>
                </select>
                <label class="mb-1 fw-bold" for="image_article">Image de l'article <span class="text-danger fw-bold">*</span></label>
                <input type="hidden" name="MAX_SIZE_FILE" value="1000000">
                <input type="file" name="image_article">
                <label for="titre" class="mb-1 fw-bold">Titre de l'article <span class="text-danger fw-bold">*</span></label>
                <input class="w-25 mb-2" type="text" name="titre" id="titre" value="<?= $isEditing === true ? $article['titre'] : '' ?>">
                <label for="contenu" class="fw-bold mb-2">Article <span class="text-danger fw-bold">*</span></label>
                <textarea class="image_article" name="contenu" id="contenu"><?= $isEditing === true ? $article['contenu'] : '' ?></textarea>
                <div class="d-flex justify-content-between mt-3">
                    <p class="text-danger p-xs">* Obligatoire</p>
                    <p class="text-end"><input type="submit" class="bouton d-inline-block" value="Publier"></p></div>

            </form>
        </div>
    </section>
<?php
unset($_SESSION['error']);
$content = ob_get_clean();
require('base.view.php');
?>