<?php

session_start();
//Créer variable niveau
$niveau = "../";

//Inclusion du fichier de configuration
include($niveau . 'inc/scripts/config.inc.php');

$strIdUtilisateur = $_SESSION['id_utilisateur'];

// Sélection de tous les studios de cinéma dans la base de données
$stmt = $pdoConnexion->prepare('SELECT * FROM t_studios WHERE id_utilisateur = '. $strIdUtilisateur);
$stmt->execute();
$studios = $stmt->fetchAll();
$stmt->closeCursor();

foreach ($studios as $studio):

if($studio['argent']>=1000000000){
    // Affiche le nombre en notation "B" (billion)
    $formaterNombre = number_format($studio['argent'] / 1000000000, 1) . 'B';
} elseif ($studio['argent'] >= 1000000) {
    // Affiche le nombre en notation "M" (million)
    $formaterNombre = number_format($studio['argent'] / 1000000, 1) . 'M';
} elseif ($studio['argent'] >= 1000) {
    // Affiche le nombre en notation "K" (thousand)
    $formaterNombre = number_format($studio['argent'] / 1000, 1) . 'K';
} else {
    // Affiche le nombre tel quel
    $formaterNombre = $studio['argent'];
}
$studio['argent']=$formaterNombre;


endforeach;

//// Connexion à la base de données
//$pdoConnexion = new PDO("mysql:host=localhost;dbname=23_blockbuster", "23_blockbuster", "uql2117");
//
//// Préparez la requête d'insertion
//$query = $pdoConnexion->prepare("INSERT INTO t_semaine (annee, nombre_semaine, jour_actuel, mois) VALUES (?, ?, ?, ?)");
//
//// Définissez les variables à insérer dans la requête
//$year = 2025;
//$week = 1;
//$mois = 1;
//
//// Trouvez le jour de la semaine du 1er janvier de l'année en cours
//$day_of_week = date("N", strtotime("01-01-$year"));
//
//// Définissez le nombre de semaines par mois (4 en général)
//$weeks_per_month = 4;
//
//// Boucle pour insérer 52 semaines
//for ($i = 1; $i <= 1; $i++) {
//    // Liaison des variables à la requête
//    $query->bindParam(1, $year);
//    $query->bindParam(2, $i);
//    $query->bindParam(3, $current_day);
//    $query->bindParam(4, $month);
//
//    // Définissez la valeur de la variable current_day en fonction de la semaine en cours
//    $day_of_week = ($week + (($year - 1) * 52)) % 7;
//
//    if ($day_of_week == 1) {
//        $current_day = "Lundi";
//    } elseif ($day_of_week == 2) {
//        $current_day = "Mardi";
//    } elseif ($day_of_week == 3) {
//        $current_day = "Mercredi";
//    } elseif ($day_of_week == 4) {
//        $current_day = "Jeudi";
//    } elseif ($day_of_week == 5) {
//        $current_day = "Vendredi";
//    } elseif ($day_of_week == 6) {
//        $current_day = "Samedi";
//    } elseif ($day_of_week == 0) {
//        $current_day = "Dimanche";
//    }
//
//    // Mettre à jour le mois
//    $days_passed = date("z", mktime(0, 0, 0, 12, 31, $year)) + 1;
//    $month = date("n", strtotime("+$weeks_per_month days"));
//
//    $week ++;
//    $day_of_week++;
//    $mois ++;
//
//    // Exécutez la requête
//    if (!$query->execute()) {
//        echo "Erreur lors de l'insertion de la semaine $i : " . print_r($query->errorInfo(), true);
//    }
//}

// Fermez la requête et la connexion à la base de données
$query = null;
$pdoConnexion = null;


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <!-- title / Liste des studios -->
    <title>Page de démarrage du jeu</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Page de démarrage du jeu</h1>
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
            <td><?php echo $formaterNombre; ?></td>
        </tr>
    <?php endforeach; ?>

</table>
<br>
<form action="film/create/session.php" method="GET">
    <input type="hidden" name="etape" value="0">
    <div>
        <input type="submit" value="Créer un nouveau film" name="btn_nouveau">
    </div>
</form>
<a href="studios/index.php">Liste des studios</a>
<br>
<a href="film/index.php">Liste des film</a>
</body>
</html>

<?php


?>

