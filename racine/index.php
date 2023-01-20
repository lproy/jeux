<?php
session_start();
///////////////*Erreur PHP*///////////////
error_reporting(0);
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

///////////////*Inclusion*///////////////

//Créer variable niveau
$niveau = "./";

//Inclusion du fichier de configuration
include ($niveau. 'inc/scripts/config.inc.php');

//if(isset($_SESSION['id_utilisateur'])){
//    header('Location:menu.php');
//    exit;
//}
//
////include json
//$strFichierTexte=file_get_contents($niveau. 'js/messages_erreur.json');
//$jsonMessagesErreur=json_decode($strFichierTexte);

////Liste des champs fautifs
//$arrChampErreur=array();
//
////Liste des messages d'erreur à afficher dans le formulaire
//$arrMessagesErreur=array();
//$arrMessagesErreur["nom_utilisateur"]="";
//$arrMessagesErreur["mot_de_passe"]="";
//$arrMessagesErreur["courriel"]="";
//$arrMessagesErreur["erreurGeneral"]="";
//
//$strCodeErreur="00000";
//
////Créer variable script
$strCodeOperation="";
$erreurStatus= "";

$strMessage="";

$strEnteteH1="";
$username="";
$password="";

//$arrUtilisateur = array();

switch (true){
    //Page connexion
    case isset($_GET['btn_connecter']):
        $strCodeOperation="connexion";
        $strEnteteH1="Connexion";
        $strQuestion = "Vous n’avez pas de compte?";
        break;
    //Page affichage
    default:
        $strCodeOperation="afficher";
        $strEnteteH1="Connexion";
        $strQuestion = "Vous n’avez pas de compte?";
}

///////////////*Chercher tous le user et mot de passe pour les comparer*///////////////

if(isset($_POST['btn_connecter'])) {
    $username = $_POST['nom_utilisateur'];
    $password = $_POST['mot_de_passe'];
    // Use prepared statements to prevent SQL injection attacks
    $stmt = $pdoConnexion->prepare("SELECT * FROM t_utilisateur WHERE nom_utilisateur=:nom_utilisateur AND mot_de_passe=:mot_de_passe");

    $stmt->bindParam(':nom_utilisateur', $username);

    $stmt->bindParam(':mot_de_passe', $password);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['id_utilisateur'] = $row['id_utilisateur'];
        header("Location: menu/menu.php");
    } else {
        echo "Invalid username or password";
    }
}




//    //La, on créer une première requete
//    $strRequete = 'SELECT id_utilisateur, nom_utilisateur, courriel, mot_de_passe, status
//                   FROM t_utilisateur';
//
//    //Exécution de la requête
//    $pdosResultat = $pdoConnexion->prepare($strRequete);
//    $pdosResultat->execute();
//    $strCodeErreur = $pdoConnexion->errorCode();
//    $pdosResultat->closeCursor();
//}
//if ($strCodeOperation=="connexion") {
//    $arrUtilisateur[0]['nom_utilisateur'] = $_GET['nom_utilisateur'];
//    $arrUtilisateur[0]['mot_de_passe'] = $_GET['mot_de_passe'];
//    $arrUtilisateur[0]['courriel'] = $_GET['courriel'];
//    $arrUtilisateur[0]['status'] = $_GET['status'];
//
//    ///////////////*Validation des champs dans connexion *///////////////
//    ///////////////*Validation des champs*///////////////
//    //validation du nom_utilisateur
//    if ($arrUtilisateur[0]["nom_utilisateur"] == "") {
//        //Si nom participant invalide...
//        $strCodeErreur = "-1";
//        array_push($arrChampErreur, "nom_utilisateur");
//    } else {
//        $strCodeErreur = "00000";
//    }
//    //validation du mot_de_passe
//    if ($arrUtilisateur[0]['mot_de_passe'] == "") {
//        //Si mot de passe est invalide...;
//        $strCodeErreur = "-1";
//        array_push($arrChampErreur, "mot_de_passe");
//    } else {
//        $strCodeErreur = "00000";
//    }
//    //Validation courriel
//    if ($arrUtilisateur[0]['courriel'] == "") {
//        //Si mot de passe est invalide...;
//        $strCodeErreur = "-1";
//        array_push($arrChampErreur, "courriel");
//    } else {
//        $strCodeErreur = "00000";
//    }
//
//    // les champs pseudo & mdp sont bien GETés et pas vides, on sécurise les données entrées par l'utilisateur
//    //le htmlentities() passera les guillemets en entités HTML, ce qui empêchera en partie, les injections SQL
//    $Pseudo = htmlentities($_GET['nom_utilisateur'], ENT_QUOTES, "UTF-8");
//    $MotDePasse = htmlentities($_GET['mot_de_passe'], ENT_QUOTES, "UTF-8");
//
//    //on se connecte à la base de données:
//    $mysqli = mysqli_connect("localhost", "23_jeuxBox", "uql2117", "23_jeuxBox");
//    //on vérifie que la connexion s'effectue correctement:
//    if (!$mysqli) {
//        echo "Erreur de connexion à la base de données.";
//    } else {
//        //on fait maintenant la requête dans la base de données pour rechercher si ces données existent et correspondent:
//        $Requete = mysqli_query($mysqli, "SELECT * FROM t_utilisateur WHERE nom_utilisateur = '" . $Pseudo . "' AND mot_de_passe = '" . $MotDePasse . "'");
//
//        //si il y a un résultat, mysqli_num_rows() nous donnera alors 1
//        //si mysqli_num_rows() retourne 0 c'est qu'il a trouvé aucun résultat
//        if (mysqli_num_rows($Requete) == 0) {
//            array_push($arrChampErreur, "erreurGeneral");
//            $strCodeErreur = "-1";
//        } else {
//            //on ouvre la session avec $_SESSION:
//            //la session peut être appelée différemment et son contenu aussi peut être autre chose que le pseudo
//            $_SESSION['nom_utilisateur'] = $Pseudo;
//            $erreurStatus = "Vous êtes à présent connecté!";
//            $strCodeErreur = "00000";
//
//            header('Location:menu.php');
//
//        }
//    }
//}
////Gestion des erreurs **************
////S'il y a une erreur
//if($strCodeErreur!="00000"){
////    $strMessage=$jsonMessagesErreur->{"echouer"};
//    for ($cpt=0;$cpt<count($arrChampErreur);$cpt++){
//        $champ=$arrChampErreur[$cpt];
//        $arrMessagesErreur[$champ]=$jsonMessagesErreur->{$champ};
//    }
//}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <!-- title / Connexion ou Création de compte -->
    <title>Connexion</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1><?php echo $strEnteteH1;?></h1>

<p><?php echo $strQuestion ?> <a href="./sign_up.php">Créer un compte</a></p>

<p><?php echo $strMessage;?></p>
    <form method="post">
            <span><?php echo $erreurStatus; ?></span>
        <div>
            <label for="nom_utilisateur">Nom d'usager</label><br>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo $username ?>">
            <span><?php ?></span>
        </div>
       <br>
        <div>
            <label for="mot_de_passe">Mot de passe</label><br>
            <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?php echo $password ?>">
            <span><?php ?></span>
        </div>
        <span><?php ?></span>
        <br>
        <div>
            <input type="submit" value="Se connecter" name="btn_connecter">
        </div>
    </form>
<p>ML2@uql8</p>
</body>
</html>
