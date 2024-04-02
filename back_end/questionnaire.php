<?php
include("connexion.php");

// Si c'est la dernière question, alors on renvoie versla page résultat
if ($_SESSION["terminer"] == 1) {
    header('Location: ../front_end/reponse.php');
}
try {
    // Démarage d'une transaction
    $connexion->beginTransaction();

    // Préparation des informations nécéssaire aux calculs
    $idsonde = $_SESSION["id"];
    $idtypes = $connexion->prepare('SELECT question.IDTYPEQUESTION, question.IDSCOREFERMEE, question.IDSCORECH, scorefermee.SCOREFRES, scorefermee.REP, scorefermee.SCOREFDEV, scorech.NBPTMULTRES, scorech.NBPTMULTDEV from question, sonde, scorefermee, scorech where question.IDQUESTION = sonde.QUESTIONRENDU AND scorefermee.IDSCOREF = question.IDSCOREFERMEE AND scorech.IDSCORECH = question.IDSCORECH AND sonde.IDSONDE = :id');
    $idtypes->bindParam(':id', $idsonde, PDO::PARAM_INT);
    $idtypes->execute();
    
    $idtypequestion = $idtypes->fetchAll();
    foreach ($idtypequestion as $ligne) {
        $idscoref = $ligne["IDSCOREFERMEE"];
        $idscorech = $ligne["IDSCORECH"];
        $scorefdev = $ligne["SCOREFDEV"];
        $scorefres = $ligne["SCOREFRES"];
        $scorechres = $ligne["NBPTMULTRES"];
        $scorechdev = $ligne["NBPTMULTDEV"];
        $rep = $ligne["REP"];
    }


    foreach ($idtypequestion as $ligne) {
        // Si la question est fermée
        if ($ligne["IDTYPEQUESTION"] == 1) {

            // SI le resultat de laquestion doit etre oui
            if ($_POST['rep_util'] == 1 && $rep == 1) {

                // Mise àjour de la base de données, cumul des points à chaque question
                $scoref = $connexion->prepare('UPDATE `sonde` SET CUMULDEV= CUMULDEV + :scorefdev, CUMULRES = CUMULRES + :scorefres WHERE IDSONDE = :id;');
                $scoref->bindParam(':scorefdev', $scorefdev, PDO::PARAM_INT);
                $scoref->bindParam(':scorefres', $scorefres, PDO::PARAM_INT);
                $scoref->bindParam(':id', $idsonde, PDO::PARAM_INT);
                $scoref->execute();
                // Validation de la transaction

            }
            // Si le résultat de la question est non
            elseif ($_POST['rep_util'] == 0 && $rep == 0) {
                // Mise à jour de la base de données, cumul des points à chaque question
                $scoref = $connexion->prepare('UPDATE `sonde` SET CUMULDEV= CUMULDEV + :scorefdev, CUMULRES = CUMULRES + :scorefres WHERE IDSONDE = :id;');
                $scoref->bindParam(':scorefdev', $scorefdev, PDO::PARAM_INT);
                $scoref->bindParam(':scorefres', $scorefres, PDO::PARAM_INT);
                $scoref->bindParam(':id', $idsonde, PDO::PARAM_INT);
                $scoref->execute();

            }
        } else //if($ligne["IDTYPEQUESTION"] == 2)
        {
            // Mise à jour de la base de données, cumul des points à chaque question
            $repbarre = $_POST['rep_util_barre'];
            $scorech = $connexion->prepare('UPDATE `sonde` SET CUMULDEV= CUMULDEV + (:scorebarre * :scorechdev), CUMULRES = CUMULRES + (:scorebarre * :scorechres) WHERE IDSONDE = :id;');
            $scorech->bindParam(':scorechres', $scorechres, PDO::PARAM_INT);
            $scorech->bindParam(':scorechdev', $scorechdev, PDO::PARAM_INT);
            $scorech->bindParam(':scorebarre', $repbarre, PDO::PARAM_INT);
            $scorech->bindParam(':id', $idsonde, PDO::PARAM_INT);
            $scorech->execute();

        }
    }

    // Modification de la question ou l'utilisateur est rendu (+1)
    $idetuds = $connexion->prepare('UPDATE `sonde` SET sonde.QUESTIONRENDU= sonde.QUESTIONRENDU +1 WHERE idsonde = :id;');
    $idetuds->bindParam(':id', $idsonde, PDO::PARAM_INT);
    $idetuds->execute();
    // Validation de la transaction
    $connexion->commit();

    if ($_SESSION["terminer"] == 0) {
        header('Location: ../front_end/pageRepQuestion.php');
    }

} catch (PDOException $e) {
    // Annulation de la transaction en cas d'erreur
    $connexion->rollBack();

    // Récupération du message dans une variable de session
    $_SESSION['message_erreur'] = $e->getMessage();
    header('Location: ../front_end/pageRepQuestion.php');
}

?>