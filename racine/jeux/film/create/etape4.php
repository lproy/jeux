<?php
ini_set('display_errors', 1);
$niveau = '../../../';
include($niveau . 'inc/scripts/config.inc.php');

if (isset($_GET['previous_page'])) {
    // L'utilisateur a cliqué sur le bouton précédent, donc on le redirige vers la page précédente
    header("Location: " . $_GET['previous_page']);
    exit;
}

if (isset($_GET['next_page'])) {
    // L'utilisateur a cliqué sur le bouton suivant, donc on le redirige vers la page suivante
    header("Location: " . $_GET['next_page']);
    exit;
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <!-- title / Liste des studios -->
    <title>Création du script</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Création du script</h1>
<h2></h2>
<form action="etape4.php" method="get">
    <!-- Champ caché pour stocker l'URL de la page précédente -->
    <input type="hidden" name="previous_page" value="etape4.php">
    <!-- Bouton précédent qui envoie vers la page précédente -->
    <input type="submit" name="submit" value="Précédent">
</form>

<form action="etape4.php" method="get">
    <!-- Champ caché pour stocker l'URL de la page suivante -->
    <input type="hidden" name="next_page" value="etape4.php">
    <!-- Bouton suivant qui envoie vers la page suivante -->
    <input type="submit" name="submit" value="Suivant">
</form>


</body>
</html>