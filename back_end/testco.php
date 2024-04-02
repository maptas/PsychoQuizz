<?php
include("connexionAdmin.php");
// Expressions régulière affain de tester si le mot de passe contient: Une majuscule, une minuscule, un chiffre, un caractère spécial et 8 caractères au minimum
function isValidMDP($mdp)
{
    return preg_match('/^(?=.* ?[A-Z])(?=.* ?[a-z])(?=.* ?[0-9])(?=.* ?[;§!@?]).{8,}$/', $mdp);
}
// SI le mot de passe et l'identifiant nesont pas vide :
if (isset($_POST['id']) && isset($_POST['mdp'])) {

    try {
        // Démarage d'une transaction
        $connexion->beginTransaction();
        // Récupération des identifiant et mots de passe
        $testmdpid = $connexion->prepare('SELECT mdp,identifiant from admin');
        $testmdpid->execute();
        $test = $testmdpid->fetchAll();
        $internauteId = $_POST['id'];
        $internauteMdp = $_POST['mdp'];

        foreach ($test as $ligne) {
            // Si le mot de passe et l'identifiant sont bon et que l'expression régulière est vérifié et que l'identifiant est bien un email alors
            if ($_POST['id'] == $ligne["identifiant"] && $_POST['mdp'] == $ligne["mdp"] && isValidMDP($_POST['mdp']) &&  filter_var($internauteId, FILTER_VALIDATE_EMAIL)) {
                // Redirection vers la page Accueil
                header('Location: ../acceuilAdmin.php');
            } else {
                // SI ce n'est pas bon alors retour a la pagede connexion
                header('Location: ../front_end/connectAdmin.php');
            }
        }

        // Validation de la transaction
        $connexion->commit();

    } catch (PDOException $e) {
        // Annulation de la transaction en cas d'erreur
        $connexion->rollBack();

        // Récupération du message dans une variable de session
        $_SESSION['message_erreur'] = $e->getMessage();
        header('Location: ../front_end/connectAdmin.php');
    }

}
?>