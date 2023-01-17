<?php
ini_set('display_errors', 1);
$niveau = '../../../';
include($niveau . 'inc/scripts/config.inc.php');

// Récupération des données du premier formulaire
$titre = $_GET['titre'];
$duree = $_GET['duree'];
$pegi = $_GET['pegi'];
//$franchise = $_GET['franchise'];

// Affichage du deuxième formulaire
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
<h2>Genre</h2>

<form action="etape4.php" method="GET">
    <input type="hidden" name="titre" value="<?php echo $titre; ?>">
    <input type="hidden" name="duree" value="<?php echo $duree;?>">
    <input type="hidden" name="pegi" value="<?php echo $pegi;?>">
    <input type="submit" value="Suivant">
</form>
<br>
<table>
    <tr>
        <th align="right">Titre:</th>
        <td align="left"><?php echo $titre;?></td>
    </tr>
    <tr>
        <th align="right">Durée:</th>
        <td align="left"><?php echo $duree;?></td>
    </tr>
    <tr>
        <th align="right">Pegi:</th>
        <td align="left"><?php echo $pegi;?></td>
    </tr>
</table>

</body>
</html>