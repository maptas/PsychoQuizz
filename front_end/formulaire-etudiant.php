<?php
include("../back_end/connexion.php");
$_SESSION["id"] = 0;
?>

<!doctype html>
<html lang="fr">
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="../assets/css/formulaire_etudiant.css" rel="stylesheet" type="text/css">
    <?php include("../templates/navbar.php"); ?>
    <title>
        <?= $title ?? "formulaire etudiant" ?>
    </title>
</header>
<?php
// Si il y a un message d'erreur
    if (isset($_SESSION['message_erreur'])) {
        // Affichage de l'exception
        echo '<div class="error">' . $_SESSION['message_erreur'] . '</div>';
        echo 'Veuillez attendre 5 secondes';
        // Supression de la variable
        unset($_SESSION['message_erreur']);
        // Redirection vers cette page après 5 secondes
        header('Refresh: 5; url=formulaire-etudiant.php');
    } else {
?>
<body class="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="titre">
                    <h1>Entrez vos information</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form class="form" method="POST" action="../back_end/from_etudiant.php" id="formulaire">
                    <div class="row">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-2">
                            <select name="menu_age" id='menu_annee'>

                                <option type="text" name="age" id="ANNEE" value="18">18</option>
                                <option type="text" name="age" id="ANNEE" value="19">19</option>
                                <option type="text" name="age" id="ANNEE" value="20">20</option>
                                <option type="text" name="age" id="ANNEE" value="21">21</option>
                                <option type="text" name="age" id="ANNEE" value="22">22</option>
                                <option type="text" name="age" id="ANNEE" value="23">23</option>
                                <option type="text" name="age" id="ANNEE" value="24">24</option>
                                <option type="text" name="age" id="ANNEE" value="25">25</option>

                            </select>
                        </div>
                        <div class="col-sm-2">

                            <select name="menu_sexe" id='menu_sexe'>
                                <option type="text" name="sexe" id="SEXE" value="homme ">homme </option>
                                <option type="text" name="sexe" id="SEXE" value="femme">femme</option>
                                <option type="text" name="sexe" id="SEXE" value="autre">autre</option>

                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select name="menu_orien" id='menu_orientation'>
                                <option type="text" name="orientation" id="IDORIGINE" value="1">G NSI</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="2">STI2DSIN</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="3">STI2DNONSIN</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="4">G MATHS</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="5"> STMG</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="6"> PROSNRISC</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="7"> PROSAUTRE</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="8"> PROSNNONRISC</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="9"> RECURRENTIUT</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="10">RECURRENTAUTRE</option>
                                <option type="text" name="orientation" id="IDORIGINE" value="11">AUTRE</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" id='bouton'> valider</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>


</body>

</html>