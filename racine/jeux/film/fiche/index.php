<?php

//Créer variable niveau
$niveau = "../../../";

//Inclusion du fichier de configuration
include($niveau . 'inc/scripts/config.inc.php');

//Ici on récupère la Querystring
$strIDFilm=$_GET['id_film'];

//Établissement de la chaine de requête
$stmt = $pdoConnexion->prepare('SELECT * FROM t_film WHERE id_film='. $strIDFilm);
$stmt->execute();
$films = $stmt->fetchAll();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Information d'un film</title>
</head>
<body>
<h1>Information d'un film</h1>
<table>
    <tr>
        <th align="left">ID</th>
        <th align="left">Titre</th>
        <th align="left">Box Office</th>
    </tr>
    <?php foreach ($films as $film): ?>
        <tr>
            <td><?php echo $film['id_film']; ?></td>
            <td><?php echo $film['titre']; ?></a></td>
            <td>                <?php
                if($film['box_office']>=1000000000){
                    // Affiche le nombre en notation "B" (billion)
                    $formaterBox = number_format($film['box_office'] / 1000000000, 1) . 'B';
                } elseif ($film['box_office'] >= 1000000) {
                    // Affiche le nombre en notation "M" (million)
                    $formaterBox = number_format($film['box_office'] / 1000000, 1) . 'M';
                } elseif ($film['box_office'] >= 1000) {
                    // Affiche le nombre en notation "K" (thousand)
                    $formaterBox = number_format($film['box_office'] / 1000, 1) . 'K';
                } else {
                    // Affiche le nombre tel quel
                    $formaterBox = $film['box_office'];
                }
                echo $formaterBox; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="../index.php">Retour à la liste des films</a>
</body>
</html>
