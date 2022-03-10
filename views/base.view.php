<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="public/img/favicon.ico" />
    <script src="https://cdn.tiny.cloud/1/kboxiw6t58hnx5roazu5n0ykco7bd00bo7xv0su7t7t3h5sk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <script src="https://kit.fontawesome.com/0ce4d10e41.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/styles.css">
    <script>
        tinymce.init({
            selector: '#contenu'
        });
    </script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon blog | <?= $title ?></title>
</head>
<header class="d-flex container-perso justify-content-between p-3">
    <p class="fw-bold fs-5"><a href="index.php"> MonBlog</a></p>
    <nav class="menu">
        <ul class="d-flex">
            <li>
                <a href="index.php">Accueil</a>
            </li>
            <li>
                <a href="?route=contact">Contact</a>
            </li>
            <?php if (!isset($_SESSION['membre'])) { ?>
                <li>
                    <a href="?route=login">Connexion</a>
                </li>
                <li>
                    <a href="?route=inscription" class="bouton">Inscription</a>
                </li>
            <?php } else { ?>
                <li>
                    <a href="?route=profil">Profil</a>
                </li>
                <?php
                if (isset($_SESSION['membre']) && $_SESSION['membre']['role'] != 0) { ?>
                    <li>
                        <a href="?route=dashboard">Dashboard</a>
                    </li>
                <?php } ?>
                <li>
                    <a href="?route=logout" class="bouton">Deconnexion</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <i class="fas fa-bars blue mt-2 animate__animated animate__fadeIn" id="open-menu"></i>
    <i class="fas fa-times blue mt-2 d-none animate__animated animate__fadeIn" id="close-menu"></i>
</header>
<nav class="menu-mobile shadow-bottom border d-none animate__animated animate__fadeInUp" id="menu">
    <ul>
        <li class="mb-2">
            <a href="index.php">Accueil</a>
        </li>
        <li class="mb-2 pt-2 border-top">
            <a href="?route=contact">Contact</a>
        </li>
        <?php if (!isset($_SESSION['membre'])) { ?>
            <li class="mb-2 pt-2 border-top">
                <a href="?route=login">Connexion</a>
            </li>
            <li class="mb-2 pt-2 border-top">
                <a href="?route=inscription">Inscription</a>
            </li>
        <?php } else { ?>
            <li class="mb-2 pt-2 border-top">
                <a href="?route=profil">Profil</a>
            </li>
            <?php
            if (isset($_SESSION['membre']) && $_SESSION['membre']['role'] != 0) { ?>
                <li class="mb-2 pt-2 border-top">
                    <a href="?route=dashboard">Dashboard</a>
                </li>
            <?php } ?>
            <li class="border-top pt-2">
                <a href="?route=logout" class="text-danger">Deconnexion</a>
            </li>
        <?php } ?>
    </ul>
</nav>
<body>

<div class="container-perso">
    <?= $content ?>
</div>
<a href="#" id="goUp"><i class=" fas fa-angle-double-up"></i></a>
<footer class="w-100 text-center p-3">
    © 2022 All rights reserved | Antoine Sueur | Developpeur Web & Web Mobile | <a href="?route=mentions">Mentions légales</a>
</footer>
<?php if (isset($_GET['route']) && $_GET['route']  === 'dashboard') { ?>
    <script type="text/javascript" src="public/js/dashboard-script.js"></script>
    <script type="text/javascript" src="public/js/bundle-graph.js"></script>
<?php } ?>
<?php if (!isset($_GET['route'])) { ?>
    <script type="text/javascript" src="public/js/functions.js"></script>
    <script type="text/javascript" src="public/js/index_main.js"></script>
<?php } ?>
<script type="text/javascript" src="public/js/menu-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>
