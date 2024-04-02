<?php
include("../back_end/connexion.php");
$idsonde = $_SESSION["id"];
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/cssReponse.css">
</head>
<header>
    <?php
    include("../templates/navbarHome.php");
    ?>
</header>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-4 my-5">
                <h3>Selon vos réponses, vous êtes :</h3>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="row">
            <div class="col-sm-5"></div>
            <div class="col-sm-2 my-5">
                <?php
                $reponses = $connexion->prepare('SELECT cumuldev, cumulres FROM sonde WHERE idsonde = :id;');
                $reponses->bindParam(':id', $idsonde, PDO::PARAM_INT);
                $reponses->execute();
                $reponse = $reponses->fetchAll();
                $min = 40;
                $max = 100;
                $profil = 1;
                /*A revoir par rapport au calcul final des points.*/
                foreach ($reponse as $ligne) {
                    if ($ligne["cumuldev"] > $min) {
                        if ($ligne["cumuldev"] < $max) {
                            echo '<h3>SLAM !</h3>';
                            $profil = 1;
                        }
                    } else if ($ligne["cumulres"] > $min) {
                        if ($ligne["cumulres"] < $max) {
                            echo "<h3>SISR !</h3>";
                            $profil = 2;
                        }
                    } else {
                        echo '<h3>mi-SLAM mi-SISR !</h3>';
                        $profil = 3;
                    }
                }
                ?>
            </div>
            <div class="col-sm-5"></div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-5" m-auto>
                <div class="card shadow bg-dark rounded espace">
                    <h4 id="souligne">Votre Profil<h4>
                            <p>
                                <?php
                                if ($profil == 1) {
                                    echo "Un.e vrai SLAMiste. 
                            Inventez votre petit monde en c#, tout en étant, attirer par le Python qui sommeille au fond de votre disque dur. 
                            Vous pourriez passer des nuits à coder et ne compter pas vos heures pour débusquer le bug, le moindre indice et le temps glisse sur vous.
                            En équipe, c’est toujours plus agile. 
                            Votre patience est légendaire derrière votre écran, difficile de vous en extraire.
                            Face à des utilisateurs un peu hackers ou pas dégourdis, vous pouvez être perfectionniste pour éviter les bugs de saisie. Et avec, tout cela, vous avez encore le temps de voir les nouveautés qui pourraient améliorer votre pratique.";
                                } else if ($profil == 2) {
                                    echo "Vous vous penchez non pas vers le côté obscur, mais bien vers l’option SISR !
                            Ne supportant pas de perdre votre temps et étant plutôt impatient votre désir de compléter tous vos services avec directement les bonnes commandes, c’est cela votre atout.
                            Être à l’aise avec différents systèmes d’exploitation et savoir dépanner vos proches quand ils sont au bout de leurs vies lorsque le WIFI est désactivé.
                            Voulant non pas rester toute votre journée derrière votre écran à taper sur votre clavier, vous aimez divaguer un peu partout et surveiller le bon fonctionnement de vos créations.";
                                } elseif ($profil == 3) {
                                    echo "Vous bricolez un peu de code pour des bots de jeu ou dépanner la famille.  Vous êtes essayé.e à HTML et CSS parce que c’est marrant de voir rapidement le résultat de son code mais, pour vos jeux préférés, vous pouvez réfléchir à la meilleure manière d’exploiter votre PC.
                            Un vrai technophile : vous avalez toutes les innovations techniques. Un peu branleur, try Hardeur, vous pouvez vous énerver facilement et vous aimez bien mener votre monde par le bout du nez. Votre idée : c’est aussi de choisir l’option où on bosse le moins tout en étant les rois du monde.
                            Le choix sera dur en décembre !!";
                                }
                                ?>
                            </p>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-2 m-5">
                        <a href="../banck_end/">
                            <button type="button" class="btn shadow btn-secondary">
                                Comparer mes réponses en fonction de l'année
                            </button>
                        </a>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-sm-2 m-5">
                        <a href="../back_end/statOrigine.php">
                            <button type="button" class="btn shadow btn-secondary">
                                Comparer mes réponses en fonctions des origines
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer class="mt-3">
    <?php
    include("../templates/footer.php");
    ?>
</footer>

</html>