<?php

include("connexion.php");

// on récupère les donnée 
$ANNEE = $_POST['menu_age'];
$ORIGINE = ($_POST['menu_orien']);
$SEXE = ($_POST['menu_sexe']);
try {
    // Démarage d'une transaction
    $connexion->beginTransaction();

    $idSONDES = $connexion->prepare('SELECT MAX(IDSONDE) AS maxid from sonde');
    $idSONDES->execute();
    $idSONDE = $idSONDES->fetchAll();

    foreach ($idSONDE as $ligne) {
        $ids = $ligne["maxid"] + 1;
    }

    // on écrit la requète 
    $ajoutsondes = $connexion->prepare('INSERT INTO `sonde`(`Age`,`SEXE`,`IDORIGINE`,`IDSONDE`) VALUES (:ANNEE,:SEXE,:IDORIGINE,:ids);');
    $ajoutsondes->bindParam(':ANNEE', $ANNEE, PDO::PARAM_INT);
    $ajoutsondes->bindParam(':SEXE', $SEXE, PDO::PARAM_STR_CHAR);
    $ajoutsondes->bindParam(':IDORIGINE', $ORIGINE, PDO::PARAM_STR);
    $ajoutsondes->bindParam(':ids', $ids);
    // on prepare la requète
    $ajoutsondes->execute();
    $_SESSION['id'] = $ids;
    // Validation de la transaction
    $connexion->commit();
    header('Location: ../front_end/pageRepQuestion.php');

} catch (PDOException $e) {
    // Annulation de la transaction en cas d'erreur
    $connexion->rollBack();

    // Récupération du message dans une variable de session
    $_SESSION['message_erreur'] = $e->getMessage();
    header('Location: ../front_end/formulaire-etudiant.php');
}

?>