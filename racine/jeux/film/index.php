<?php

//Créer variable niveau
$niveau = "../../";

//Inclusion de la classe Film
//require_once($niveau . 'lib/classes/Studio.php');

//Inclusion du fichier de configuration
include($niveau . 'inc/scripts/config.inc.php');

// Sélection de tous les studios de cinéma dans la base de données
$stmt ='SELECT *  FROM t_film
        INNER JOIN t_couleur_background ON t_film.id_couleur_graphique = t_couleur_background.id_couleur_background';

//Exécution de la requête
$pdosResultat = $pdoConnexion->query($stmt);

$strCodeErreur = $pdoConnexion->errorCode();

$arrFilm = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrFilm[$cptEnr]['id_film'] = $ligne['id_film'];
    $arrFilm[$cptEnr]['titre'] = $ligne['titre'];
    $arrFilm[$cptEnr]['box_office'] = $ligne['box_office'];

    $requete = "SELECT hexadecimal FROM t_couleur_background
            WHERE id_couleur_background = (SELECT id_couleur_background FROM t_film
                WHERE id_film = :id_film)";

    $pdosSousResultat = $pdoConnexion->prepare($requete);
    $pdosSousResultat->bindParam(':id_film', $ligne['id_film']);
    $pdosSousResultat->execute();

    $ligneHexadecimale = $pdosSousResultat->fetch();
    $strHexadecimale = "";
    while($ligneHexadecimale){
        $strHexadecimale = $strHexadecimale . $ligneHexadecimale['hexadecimal'];
        $ligneHexadecimale = $pdosSousResultat->fetch();
    }

    $arrFilm[$cptEnr]['hexadecimal'] = $strHexadecimale;

    $pdosSousResultat->closeCursor();

    $requeteGraphique = "SELECT hexadecimal AS graphique FROM t_couleur_graphique
            WHERE id_couleur_graphique = (SELECT id_couleur_graphique FROM t_film
                WHERE id_film = :id_film)";

    $pdosSousResultat = $pdoConnexion->prepare($requeteGraphique);
    $pdosSousResultat->bindParam(':id_film', $ligne['id_film']);
    $pdosSousResultat->execute();

    $ligneHexadecimaleGraphique = $pdosSousResultat->fetch();
    $strHexadecimaleGraphique = "";
    while($ligneHexadecimaleGraphique){
        $strHexadecimaleGraphique = $strHexadecimaleGraphique . $ligneHexadecimaleGraphique['graphique'];
        $ligneHexadecimaleGraphique = $pdosSousResultat->fetch();
    }

    $arrFilm[$cptEnr]['graphique'] = $strHexadecimaleGraphique;

    $pdosSousResultat->closeCursor();

    $requeteTextes = "SELECT hexadecimal AS textes FROM t_couleur_textes
            WHERE id_couleur_textes= (SELECT id_couleur_textes FROM t_film
                WHERE id_film = :id_film)";


    $pdosSousResultat = $pdoConnexion->prepare($requeteTextes);
    $pdosSousResultat->bindParam(':id_film', $ligne['id_film']);
    $pdosSousResultat->execute();

    $ligneHexadecimaleTextes = $pdosSousResultat->fetch();
    $strHexadecimaleTextes = "";
    while($ligneHexadecimaleTextes){
        $strHexadecimaleTextes = $strHexadecimaleTextes. $ligneHexadecimaleTextes['textes'];
        $ligneHexadecimaleTextes = $pdosSousResultat->fetch();
    }

    $arrFilm[$cptEnr]['textes'] = $strHexadecimaleTextes;

    $pdosSousResultat->closeCursor();

    $requeteClassification= "SELECT type FROM t_classification
            WHERE id_classification = (SELECT id_classification FROM t_film
                WHERE id_film = :id_film)";

    $pdosSousResultat = $pdoConnexion->prepare($requeteClassification);

    $pdosSousResultat->bindParam(':id_film', $ligne['id_film']);
    $pdosSousResultat->execute();

    $ligneClassification = $pdosSousResultat->fetch();
    $strClassification = "";
    while($ligneClassification){
        $strClassification = $strClassification. $ligneClassification['type'];
        $ligneClassification = $pdosSousResultat->fetch();
    }
    $arrFilm[$cptEnr]['type'] = $strClassification;
    $pdosSousResultat->closeCursor();

    $requeteStudios= "SELECT nom_studios FROM t_studios
            WHERE id_studios = (SELECT id_studios FROM t_film
                WHERE id_film = :id_film)";

    $pdosSousResultat = $pdoConnexion->prepare($requeteStudios);

    $pdosSousResultat->bindParam(':id_film', $ligne['id_film']);
    $pdosSousResultat->execute();

    $ligneStudios = $pdosSousResultat->fetch();
    $strStudios = "";
    while($ligneStudios){
        $strStudios= $strStudios. $ligneStudios['nom_studios'];
        $ligneStudios = $pdosSousResultat->fetch();
    }
    $arrFilm[$cptEnr]['nom_studios'] = $strStudios;
    $pdosSousResultat->closeCursor();
}
//Liberation de la 1ere requête
$pdosResultat->closeCursor();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <!-- title / Liste des studios -->
    <title>Liste des film</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Liste des film</h1>
<table>
    <tr>
        <th align="left">ID</th>
        <th align="left">Affiche</th>
        <th align="left">Titre</th>
        <th align="left">Box Office</th>
    </tr>
    <?php for ($cptEnr = 0; $cptEnr < count($arrFilm); $cptEnr++){ ?>
        <tr>
            <td><?php echo $arrFilm[$cptEnr]['id_film']; ?></td>
            <td><div style="background-color: <?php echo $arrFilm[$cptEnr]['hexadecimal'];?>; color:<?php echo $arrFilm[$cptEnr]['textes'];?>;">
                    <p>Future Nomination</p>
                    <p style="color: <?php echo $arrFilm[$cptEnr]['graphique'];?>">Graphique</p>
                    <p><?php echo $arrFilm[$cptEnr]['titre']; ?></p>
                    <p><?php echo $arrFilm[$cptEnr]['type']; ?></p>
                    <p><?php echo $arrFilm[$cptEnr]['nom_studios']; ?></p>
                </div>
            </td>
            <td><a href="fiche/index.php?id_film=<?php echo $arrFilm[$cptEnr]['id_film'];?>"><?php echo $arrFilm[$cptEnr]['titre']; ?></a></td>
            <td>
                <?php
                if($arrFilm[$cptEnr]['box_office']>=1000000000){
                    // Affiche le nombre en notation "B" (billion)
                    $formaterBox = number_format($arrFilm[$cptEnr]['box_office'] / 1000000000, 1) . 'B';
                } elseif ($arrFilm[$cptEnr]['box_office'] >= 1000000) {
                    // Affiche le nombre en notation "M" (million)
                    $formaterBox = number_format($arrFilm[$cptEnr]['box_office'] / 1000000, 1) . 'M';
                } elseif ($arrFilm[$cptEnr]['box_office'] >= 1000) {
                    // Affiche le nombre en notation "K" (thousand)
                    $formaterBox = number_format($arrFilm[$cptEnr]['box_office'] / 1000, 1) . 'K';
                } else {
                    // Affiche le nombre tel quel
                    $formaterBox = $arrFilm[$cptEnr]['box_office'];
                }
                echo $formaterBox; ?></td>
        </tr>
    <?php } ?>
</table>
<a href="../index.php">Retour</a>
</body>
</html>

