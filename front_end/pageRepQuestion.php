<?php
include("../back_end/connexion.php");
$idsonde = $_SESSION["id"];
$_SESSION["terminer"] = 0;
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
    <link href="../assets/css/cssReponse.css" rel="stylesheet" type="text/css">

</head>
<header>
    <?php include("../templates/navbarSession.php"); ?>

</header>

<body>
    <h1>Questionnaire en ligne</h1>
    <?php
    // Si il y a un message d'erreur
    if (isset($_SESSION['message_erreur'])) {
        // Affichage de l'exception
        echo '<div class="error">' . $_SESSION['message_erreur'] . '</div>';
        // Supression de la variable
        unset($_SESSION['message_erreur']);
        // Redirection vers cette page après 5 secondes
        header('Refresh: 5; url=pageRepQuestion.php');
    } else {
        try {
            // Démarage d'une transaction
            $connexion->beginTransaction();

            // Recupération les informations de la question ou l'utilisateur est rendu
            $idetuds = $connexion->prepare('SELECT question.IDQUESTION, question.LIBELLE FROM sonde, question WHERE sonde.IDSONDE = :id AND question.IDQUESTION = sonde.QUESTIONRENDU;');
            $idetuds->bindParam(':id', $idsonde);
            $idetuds->execute();
            // Validation de la transaction
            $connexion->commit();
            $idetud = $idetuds->fetchAll();
            ?>
            <!-- Affiche le numéro de la question -->
            <h2>Question numéro
                <?php
                foreach ($idetud as $ligne) {
                    echo $ligne["IDQUESTION"];
                }
                ?>
            </h2>
            <!-- Affiche la question -->
            <div id="question">
                <!-- Création d'un formulaire renvoyant a la page questionnaire pour les tests et calculs -->
                <form method="post" action="../back_end/questionnaire.php">
                    <h3>
                        <?php
                        foreach ($idetud as $ligne) {
                            echo $ligne["LIBELLE"];
                        }
                        ?>
                    </h3>

                    <?php
                    // Démarage d'une transaction
                    $connexion->beginTransaction();

                    // Récupération du type de la question
                    $recup = $connexion->prepare('SELECT IDTYPEQUESTION FROM question, sonde WHERE sonde.IDSONDE = :id AND question.IDQUESTION = sonde.QUESTIONRENDU');
                    $recup->bindParam(':id', $idsonde, PDO::PARAM_INT);
                    $recup->execute();
                    // Validation de la transaction
                    $connexion->commit();
                    $idTypeRep = $recup->fetchAll();
                    foreach ($idTypeRep as $ligne) {
                        $IDquestion = $ligne["IDTYPEQUESTION"];
                    }

                    // Démarage d'une transaction
                    $connexion->beginTransaction();
                    // Si la question est fermé
                    if ($IDquestion == 1) {
                        ?>
                        <!-- Affichage de oui et non -->
                        <div id="oui_non">
                            <label for="rep_util">Réponse: </label>
                            <input type="radio" id="repon" name="rep_util" value="1" required>
                            <label for="oui">Oui</label>
                            <input type="radio" id="repon" name="rep_util" value="0">
                            <label for="non">Non</label><br>
                            <?php



                            // Récupération des valeurs pour savoir si c'est la dernière question
                            $nbQues = $connexion->prepare('SELECT COUNT(question.IDQUESTION) AS nbQuestion, sonde.QUESTIONRENDU FROM question, sonde WHERE sonde.IDSONDE = :id;');
                            $nbQues->bindParam(':id', $idsonde, PDO::PARAM_INT);
                            $nbQues->execute();

                            $nbQuestion = $nbQues->fetchAll();


                            foreach ($nbQuestion as $ligne) {
                                $MaxQuestion = $ligne['nbQuestion'];
                                $renduQuestion = $ligne['QUESTIONRENDU'];
                                // Si c'est la dernière question
                                if ($renduQuestion == $MaxQuestion) {
                                    $_SESSION["terminer"] = 1;
                                    ?>
                                    <!-- Bouton terminer -->
                                    <input type="submit" name="submit" value="Terminer">
                                    <?php

                                } else { // Pour toutes les autres questions
                                    ?>
                                    <!-- Bouton valider -->
                                    <input type="submit" name="submit" value="Valider">
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    } else {

                        ?>

                        <!-- Echelle constitué avec 5 boutton -->
                        <div id="barre_rep">
                            <label for="rep_util">Réponse de 1 (gauche=faible) à 5 (droite=fort): </label>
                            <input type="radio" id="repbarre" name="rep_util_barre" value="1" required>
                            <input type="radio" id="repbarre" name="rep_util_barre" value="2">
                            <input type="radio" id="repbarre" name="rep_util_barre" value="3">
                            <input type="radio" id="repbarre" name="rep_util_barre" value="4">
                            <input type="radio" id="repbarre" name="rep_util_barre" value="5">
                            <br>
                            <?php

                            $nbQues = $connexion->prepare('SELECT COUNT(question.IDQUESTION) AS nbQuestion, sonde.QUESTIONRENDU FROM question, sonde WHERE sonde.IDSONDE = :id;');
                            $nbQues->bindParam(':id', $idsonde, PDO::PARAM_INT);
                            $nbQues->execute();
                            $nbQuestion = $nbQues->fetchAll();
                            foreach ($nbQuestion as $ligne) {

                                $MaxQuestion = $ligne['nbQuestion'];
                                $renduQuestion = $ligne['QUESTIONRENDU'];
                                if ($renduQuestion == $MaxQuestion) {
                                    $_SESSION["terminer"] = 1;

                                    ?>
                                    <input type="submit" name="submit" value="Terminer">
                                    <?php
                                } else {
                                    ?>
                                    <input type="submit" name="submit" value="Valider">
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    // Validation de la transaction
                    $connexion->commit();
                    ?>
                </form>
            </div>

            <!-- Affichage de la question rendu sur le max de question-->
            <p>
                <?php
                // Démarage d'une transaction
                $connexion->beginTransaction();

                $nbqus = $connexion->prepare('SELECT COUNT(question.IDQUESTION) AS idmax, sonde.QUESTIONRENDU AS iqu FROM question, sonde WHERE sonde.IDSONDE = :id;');
                $nbqus->bindParam(':id', $idsonde, PDO::PARAM_INT);
                $nbqus->execute();
                $nbqu = $nbqus->fetchAll();
                foreach ($nbqu as $ligne) {
                    echo $ligne["iqu"]; ?>/
                    <?php echo $ligne["idmax"];
                }
                // Validation de la transaction
                $connexion->commit();

        } catch (PDOException $e) {
            // Annulation de la transaction en cas d'erreur
            $connexion->rollBack();

            // Récupération du message dans une variable de session
            $_SESSION['message_erreur'] = $e->getMessage();
            header('Location: pageRepQuestion.php');
        }

    }
    ?>

    </p>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>