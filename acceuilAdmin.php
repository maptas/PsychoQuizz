<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Administrateur</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/css/main.css" rel="stylesheet" type="text/css">

</head>

<body>
<!-- Header -->
    <header>
        <?php include("templates/navbar.php"); ?>
    </header>
    <main>
        <section>
        <!-- Présentation -->
            <article>
                <div class="row">
                <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <h2> Bienvenue sur la page administrateur</h2>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="row">
                    <div class="col-sm-4">
                        <h4>Vous aller retrouver ici plein de truc</h4>
                    </div>
                </div>
            </article>
            <article>
            <!-- Bouton pour voir les deux graphiques -->
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3">
                        <p>Statistique sur le nombre d'étudiant dans les 2 spécialités en fonction de leurs origines.</p>
                        <a href="back_end/statOrigine.php">
                            <button type="button" class="btn shadow btn-secondary">
                                Voir l'histogramme
                            </button>
                        </a>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3">
                        <p>Statistique sur (voir avec Louan).</p>
                        <a href="">
                            <button type="button" class="btn shadow btn-secondary">
                                Voir le diagramme
                            </button>
                        </a>
                    </div>
                    <div class="col-sm-2"></div>
                <div class="row">
            </article>
        </section>
    </main>
</body>
<!-- Footer -->
<!--
<footer class="mt-3">
    <?php
    include("../templates/footer.php");
    ?>
</footer>
-->
</html>