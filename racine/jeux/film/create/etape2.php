<?php

ini_set('display_errors', 1);
$niveau = '../../../';
include($niveau . 'inc/scripts/config.inc.php');

// Récupération des données du premier formulaire
$titre = $_GET['titre'];
$duree = $_GET['duree'];
$pegi = $_GET['pegi'];

// Sélection de tous les studios de cinéma dans la base de données
$stmt = $pdoConnexion->prepare('SELECT * FROM t_classification WHERE type = '.$pegi);
$stmt->execute();
$classifications = $stmt->fetchAll();



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
    <link rel="stylesheet" href="../../../css/style.css">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Création d'un script</h1>
<h2>Créer une franchise</h2>
<form action="etape3.php" method="GET" id="my-form">
    <input type="hidden" name="titre" value="<?php echo $titre; ?>">
    <input type="hidden" name="duree" value="<?php echo $duree;?>">
    <input type="hidden" name="pegi" value="<?php echo $pegi;?>">
    <label for="budget">Franchise :</label><br>
    <input type="text" id="franchise" name="fanchise"><br>
    <a href="#overlay">Choisir une franchise</a><br>
    <form action="index.php" method="get">
    <input type="submit" id="submit-form">Submit form</input>
    </form>
    <input type="submit" value="Suivant">
</form>
<form action="index.php" method="GET">
    <input type="submit" value="Précédant">
</form>
<br>
<div id="overlay">
    <div id="overlay-content">
        <h2>Mon titre</h2>
        <button id="close-button" onclick="toggleOverlay()">Fermer</button>
    </div>
</div>
<section class="affiche">
   <div class="affiche__background">
    <p>Future Nomination</p>
       <div class="affiche__ligne"></div>
       <p><?php echo $titre;?></p>
       <p><?php echo $pegi;?></p>
    </div>
    <table>
        <tr>
            <th align="right">Titre :</th>
            <td align="left"><?php echo $titre;?></td>
        </tr>
        <tr>
            <th align="right">Durée :</th>
            <td align="left"><?php echo $duree;?></td>
        </tr>
        <tr>

            <th align="right">Pegi :</th>
            <td align="left"><?php echo $pegi;?></td>
        </tr>
    </table>
</section>

<input type="submit" id="submit-form">Submit form</input>


<script>
    $(document).ready(function() {
        $('#submit-form').click(function(e) {
            e.preventDefault(); // empêche le lien de suivre son action par défaut (c'est-à-dire de rediriger vers l'URL spécifiée dans l'attribut href)
            $('#my-form').submit(); // soumet le formulaire
        });
    });
</script>



</body>
</html>