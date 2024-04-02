<?php
include("connexion.php");
//include("back_end/connexion.php");

//require_once('jpgraph/jpgraph-4.4.1/src/jpgraph.php');
//require_once('jpgraph/jpgraph-4.4.1/src/jpgraph_bar.php');
require_once('../assets/jpgraph/jpgraph-4.4.1/src/jpgraph.php');
require_once('../assets/jpgraph/jpgraph-4.4.1/src/jpgraph_bar.php');

/*Requête SQL pour récupérer les données et déclaration de variable pour le trie des données.*/
$dataSLAM = array(0,0,0,0,0,0,0,0,0,0,0);
$dataSISR = array(0,0,0,0,0,0,0,0,0,0,0);
$dataLes2 = array(0,0,0,0,0,0,0,0,0,0,0);
$origine = $connexion->prepare('SELECT sonde.IDORIGINE, sonde.CUMULDEV, sonde.CUMULRES, origine.NOM as nomOrigine FROM sonde, origine WHERE sonde.IDORIGINE = origine.IDORIGINE;');
$origine->execute();
$i = 0;
$origines = $origine->fetchAll();
/* Tri des données selon Origine et résultat du questionnaire*/
foreach($origines as $ligne){
    $Origine[$i] = $ligne["nomOrigine"];
    $i = $i + 1;
    if($ligne["CUMULDEV"]> 40 && $ligne["CUMULRES"]< 40){
        if($ligne["IDORIGINE"] == 1){
            $dataSLAM[0] = $dataSLAM[0] + 1;
        }elseif($ligne["IDORIGINE"] == 2){
            $dataSLAM[1] = $dataSLAM[1] + 1;
        }elseif($ligne["IDORIGINE"] == 3){
            $dataSLAM[2] = $dataSLAM[2] + 1;
        }elseif($ligne["IDORIGINE"] == 4){
            $dataSLAM[3] = $dataSLAM[3] + 1;
        }elseif($ligne["IDORIGINE"] == 5){
            $dataSLAM[4] = $dataSLAM[4] + 1;
        }elseif($ligne["IDORIGINE"] == 6){
            $dataSLAM[5] = $dataSLAM[5] + 1;
        }elseif($ligne["IDORIGINE"] == 7){
            $dataSLAM[6] = $dataSLAM[6] + 1;
        }elseif($ligne["IDORIGINE"] == 8){
            $dataSLAM[7] = $dataSLAM[7] + 1;
        }elseif($ligne["IDORIGINE"] == 9){
            $dataSLAM[8] = $dataSLAM[8] + 1;
        }elseif($ligne["IDORIGINE"] == 10){
            $dataSLAM[9] = $dataSLAM[9] + 1;
        }elseif($ligne["IDORIGINE"] == 11){
            $dataSLAM[10] = $dataSLAM[10] + 1;
        }
    }
    elseif($ligne["CUMULRES"]> 40 && $ligne["CUMULDEV"]< 40){
        if($ligne["IDORIGINE"] == 1){
            $dataSISR[0] = $dataSISR[0] + 1;
        }elseif($ligne["IDORIGINE"] == 2){
            $dataSISR[1] = $dataSISR[1] + 1;
        }elseif($ligne["IDORIGINE"] == 3){
            $dataSISR[2] = $dataSISR[2] + 1;
        }elseif($ligne["IDORIGINE"] == 4){
            $dataSISR[3] = $dataSISR[3] + 1;
        }elseif($ligne["IDORIGINE"] == 5){
            $dataSISR[4] = $dataSISR[4] + 1;
        }elseif($ligne["IDORIGINE"] == 6){
            $dataSISR[5] = $dataSISR[5] + 1;
        }elseif($ligne["IDORIGINE"] == 7){
            $dataSISR[6] = $dataSISR[6] + 1;
        }elseif($ligne["IDORIGINE"] == 8){
            $dataSISR[7] = $dataSISR[7] + 1;
        }elseif($ligne["IDORIGINE"] == 9){
            $dataSISR[8] = $dataSISR[8] + 1;
        }elseif($ligne["IDORIGINE"] == 10){
            $dataSISR[9] = $dataSISR[9] + 1;
        }elseif($ligne["IDORIGINE"] == 11){
            $dataSISR[10] = $dataSISR[10] + 1;
        }
    }
    else {
        if($ligne["IDORIGINE"] == 1){
            $dataLes2[0] = $dataLes2[0] + 1;
        }elseif($ligne["IDORIGINE"] == 2){
            $dataLes2[1] = $dataLes2[1] + 1;
        }elseif($ligne["IDORIGINE"] == 3){
            $dataLes2[2] = $dataLes2[2] + 1;
        }elseif($ligne["IDORIGINE"] == 4){
            $dataLes2[3] = $dataLes2[3] + 1;
        }elseif($ligne["IDORIGINE"] == 5){
            $dataLes2[4] = $dataLes2[4] + 1;
        }elseif($ligne["IDORIGINE"] == 6){
            $dataLes2[5] = $dataLes2[5] + 1;
        }elseif($ligne["IDORIGINE"] == 7){
            $dataLes2[6] = $dataLes2[6] + 1;
        }elseif($ligne["IDORIGINE"] == 8){
            $dataLes2[7] = $dataLes2[7] + 1;
        }elseif($ligne["IDORIGINE"] == 9){
            $dataLes2[8] = $dataLes2[8] + 1;
        }elseif($ligne["IDORIGINE"] == 10){
            $dataLes2[9] = $dataLes2[9] + 1;
        }elseif($ligne["IDORIGINE"] == 11){
            $dataLes2[10] = $dataLes2[10] + 1;
        }
    }
}
/*********Construction de tableaux de données*********/

$NbEleves = array(0,5,10,15,20,25,30);

//Essaie 1 avec 3 simples tableaux pour ajout de ceux-ci dans 3 BarPlot différents puis ajout des BarPlot dans GroupBarPlot <--Marche
//$dataSLAM = array($Or1SLAM,$Or2SLAM,$Or3SLAM,$Or4SLAM,$Or5SLAM,$Or6SLAM,$Or7SLAM,$Or8SLAM,$Or9SLAM,$Or10SLAM,$Or11SLAM);
//$dataSISR = array($Or1SISR,$Or2SISR,$Or3SISR,$Or4SISR,$Or5SISR,$Or6SISR,$Or7SISR,$Or8SISR,$Or9SISR,$Or10SISR,$Or11SISR);
//$dataLes2 = array($Or1Les2,$Or2Les2,$Or3Les2,$Or4Les2,$Or5Les2,$Or6Les2,$Or7Les2,$Or8Les2,$Or9Les2,$Or10Les2,$Or11Les2);

//Essaie 2 avec 1 tableau avec 3 Clés, SLAM, SISR, Les2, pour ajout de celui-ci dans GroupBarplot <- Inutile, réponse prb déjà trouvé
//$GroupData['SLAM'] = array($Or1SLAM,$Or2SLAM,$Or3SLAM,$Or4SLAM,$Or5SLAM,$Or6SLAM,$Or7SLAM,$Or8SLAM,$Or9SLAM,$Or10SLAM,$Or11SLAM);
//$GroupData['SISR'] = array($Or1SISR,$Or2SISR,$Or3SISR,$Or4SISR,$Or5SISR,$Or6SISR,$Or7SISR,$Or8SISR,$Or9SISR,$Or10SISR,$Or11SISR);
//$GroupData['Les2'] = array($Or1Les2,$Or2Les2,$Or3Les2,$Or4Les2,$Or5Les2,$Or6Les2,$Or7Les2,$Or8Les2,$Or9Les2,$Or10Les2,$Or11Les2);


/*********Construction de l'histogramme*********/

$graph = new Graph(1500,1250, 'auto');
$graph->setScale('textlin');
$graph->setMargin(40,30,20,40);

$graph->title->Set('Histogramme du nombre d\'élèves par spécialité selon leur origine');
$graph->title->SetMargin(6);

$graph->xaxis->title->Set('Origine', 'middle');
$graph->xaxis->SetTickLabels($Origine);
//$graph->xaxis->SetAutoMargin(4);//Pas fait de vérif pour savoir si ça marche

$graph->yaxis->title->Set('Nombre d\'élèves');
//$graph->yaxis->SetMargin(4);//Pas fait de vérif pour savoir si ça marche

$graph->legend->Pos(0.02,0.05);
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');


$barSLAM = new BarPlot($dataSLAM);
$barSLAM->SetFillColor('blue@0.4');
$barSLAM->SetShadow('black@0.4');

$barSISR = new BarPlot($dataSISR);
$barSISR->SetFillColor('green@0.4');
$barSISR->SetShadow('black@0.4');

$barLes2 = new BarPlot($dataLes2);
$barLes2->SetFillColor('red@0.4');
$barLes2->SetShadow('black@0.4');

$groupBar = array($barSLAM,$barSISR,$barLes2);
$gbar = new GroupBarPlot($groupBar);

$graph->Add($gbar);

//$graph->xaxis->SetAutoMax(100);
//$graph->yaxis->SetAutoMax(100);

/* Essaie avec 3 BarPlot ne marche pas, seulement 1 bar est afficher pour chaque origine au lieu de 3. +Couleur des bars mauvaise
$barSLAM = new BarPlot($dataSLAM);
$barSLAM->SetFillColor('blue');
$barSISR = new BarPlot($dataSISR);
$barSISR->SetFillColor('green');
$barLes2 = new BarPlot($dataLes2);
$barLes2->SetFillColor('red');

//$graph->yaxis->SetAutoMin(0);
//$graph->yaxis->SetAutoMax(35);

$graph->Add($barSLAM);
$graph->Add($barSISR);
$graph->Add($barLes2);
*/
$graph->Stroke();

/*
**Test des valeurs de BDD (GOOD)**
echo '---données SLAM---';
foreach($dataSLAM as $lignes)
{
    echo $lignes;
    echo " ";
}
echo '---données SISR---';
foreach($dataSISR as $lignes)
{
    echo $lignes;
    echo " ";
}
echo '---données Les 2---';
foreach($dataLes2 as $lignes)
{
    echo $lignes;
    echo " ";
}
*/
?>