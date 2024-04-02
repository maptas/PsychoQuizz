<?php
session_start();

// Connexion a la base de donnée en root
$machine = "localhost";
$port = 3306;
$id = "administrateur";
$mdp = "Rootsio2017";
$nomdebase = "quizz";

$connexion = new PDO(
    'mysql:host=' . $machine . ';port=' . $port . ';dbname=' . $nomdebase,
    $id,
    $mdp
);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>