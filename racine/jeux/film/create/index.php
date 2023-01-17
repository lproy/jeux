<?php

ini_set('display_errors', 1);
$niveau = '../../../';
include($niveau . 'inc/scripts/config.inc.php');


// Récupération des données du premier formulaire
$titre = $_GET['titre'];
$duree = $_GET['duree'];
$pegi = $_GET['pegi'];

// Sélection de tous les studios de cinéma dans la base de données
$stmt = $pdoConnexion->prepare('SELECT * FROM t_duree');
$stmt->execute();
$durees = $stmt->fetchAll();

$stmt->closeCursor();

// Sélection de tous les studios de cinéma dans la base de données
$stmt = $pdoConnexion->prepare('SELECT * FROM t_classification');
$stmt->execute();
$classifications = $stmt->fetchAll();


//Fonction utilitaire pour l'affichage des boutons radio
function ecrireChecked($valeurRadio, $nomRadio){
    $strCocher="";
    global $durees;
    if($valeurRadio == $durees[0]['id_'.$nomRadio]){
        $strCocher='checked="checked"';
    }
    return $strCocher;
}

//Fonction utilitaire pour l'affichage des boutons radio
function ecrireCheckedPegi($valeurRadio, $nomRadio){
    $strCocher="";
    global $classifications;
    if($valeurRadio == $classifications[0]['id_'.$nomRadio]){
        $strCocher='checked="checked"';
    }
    return $strCocher;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <!-- title / Liste des studios -->
    <title>Création d'un script</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Création d'un script</h1>
<h2>Information du film</h2>

<form action="etape2.php" method="get">
    <label for="titre">Titre :</label><br>
    <input type="text" id="titre" name="titre" value=""><br>
    <br>
    <fieldset>
        <legend>Durée :</legend>
        <?php foreach ($durees as $duree): ?>
            <label>
                <input type="radio" name="duree" id="<?php echo $duree['id_duree'];?>" value="<?php echo $duree['duree'];?>" <?php echo ecrireChecked($duree['id_duree'], 'duree')?>>
                <?php echo $duree['duree']; ?>
            </label>
        <?php endforeach; ?>
    </fieldset>
    <fieldset>
        <legend>Classification :</legend>
        <?php foreach ($classifications as $classification): ?>
            <label style="color: <?php echo $classification['hexadecimal'];?>">
                <input type="radio" name="pegi" id="<?php echo $classification['id_classification'];?>" value="<?php echo $classification['type'];?>" <?php echo ecrireCheckedPegi($classification['id_classification'], 'classification')?>>
                <?php echo $classification['type']; ?>
            </label>
        <?php endforeach; ?>
    </fieldset>
    <br>
    <input type="submit" value="Suivant">
</form>


</body>
</html>
