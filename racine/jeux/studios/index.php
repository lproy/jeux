<?php

//Créer variable niveau
$niveau = "../../";

//Inclusion de la classe Studio
require_once($niveau . 'lib/classes/Studio.php');

//Inclusion du fichier de configuration
include($niveau . 'inc/scripts/config.inc.php');

// Sélection de tous les studios de cinéma dans la base de données
$stmt = $pdoConnexion->prepare('SELECT * FROM t_studios');
$stmt->execute();
$studios = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <!-- title / Liste des studios -->
    <title>Liste des studios</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Liste des studios</h1>
<table>
    <tr>
        <th align="left">ID</th>
        <th align="left">Nom</th>
        <th align="left">Argent</th>
    </tr>
    <?php foreach ($studios as $studio): ?>
        <tr>
            <td><?php echo $studio['id_studios']; ?></td>
            <td><?php echo $studio['nom_studios']; ?></td>
            <td>                <?php
                if($studio['argent']>=1000000000){
                    // Affiche le nombre en notation "B" (billion)
                    $formaterBox = number_format($studio['argent'] / 1000000000, 1) . 'B';
                } elseif ($studio['argent'] >= 1000000) {
                    // Affiche le nombre en notation "M" (million)
                    $formaterBox = number_format($studio['argent'] / 1000000, 1) . 'M';
                } elseif ($studio['argent'] >= 1000) {
                    // Affiche le nombre en notation "K" (thousand)
                    $formaterBox = number_format($studio['argent'] / 1000, 1) . 'K';
                } else {
                    // Affiche le nombre tel quel
                    $formaterBox = $studio['argent'];
                }
                echo $formaterBox; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="../index.php">Retour</a>
</body>
</html>
