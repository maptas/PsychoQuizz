<?php
session_start();

// Connexion a la base de donnée en utilisateur
$machine = "localhost";
$port = '';
$id = "util";
$mdp = "Btssio2017";
$nomdebase = "quizz";

$connexion = new PDO(
    'mysql:host=' . $machine . ';port=' . $port . ';dbname=' . $nomdebase,
    $id,
    $mdp
);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>