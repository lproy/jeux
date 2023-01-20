<?php
///////////////*Erreur PHP*///////////////
error_reporting(0);
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

///////////////*Inclusion*///////////////

//Créer variable niveau
$niveau = "./";

//Inclusion du fichier de configuration
include ($niveau. 'inc/scripts/config.inc.php');

//include json
$strFichierTexte=file_get_contents($niveau. 'js/messages_erreur.json');
$jsonMessagesErreur=json_decode($strFichierTexte);

//Liste des champs fautifs
$arrChampErreur=array();

//Liste des messages d'erreur à afficher dans le formulaire
$arrMessagesErreur=array();
$arrMessagesErreur["nom_utilisateur"]="";
$arrMessagesErreur["mot_de_passe"]="";
$arrMessagesErreur["courriel"]="";
$arrMessagesErreur["erreurGeneral"]="";

$strCodeErreur="00000";

//Créer variable script
$strCodeOperation="";

$strMessage="";

$strEnteteH1="";

$arrUtilisateur = array();

switch (true){
    //Page création
    case isset($_GET['btn_creation_de_compte']):
        $strCodeOperation="creation_de_compte";
        $strEnteteH1="Creation de compte";
        $strQuestion = "Vous avez un compte?";
        break;
    //Page affichage
    default:
        $strCodeOperation="afficher";
        $strEnteteH1="Creation de compte";
        $strQuestion = "Vous avez un compte?";
}

///////////////*Chercher tous le user et mot de passe pour les comparer*///////////////
// Check if form is submitted
if(isset($_POST['submit'])) {
    // Get form data
    $username = $_POST['nom_utilisateur'];
    $email = $_POST['courriel'];
    $password = $_POST['mot_de_passe'];

    // Validate form data
    if(empty($username) || empty($email) || empty($password)) {
        $error = "Tous les champs son demander";
    } else {
        // Hash password
//        $password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $stmt = $pdoConnexion->prepare("SELECT * FROM t_utilisateur WHERE courriel=:courriel");
        $stmt->bindParam(':courriel', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result) {
            $error = "Email already exists";
        } else {
            // Insert new user into database
            $stmt = $pdoConnexion->prepare("INSERT INTO t_utilisateur (nom_utilisateur, courriel, mot_de_passe) VALUES (:nom_utilisateur, :courriel, :mot_de_passe)");
            $stmt->bindParam(':nom_utilisateur', $username);
            $stmt->bindParam(':courriel', $email);
            $stmt->bindParam(':mot_de_passe', $password);
            $stmt->execute();

            // Get the generated user ID
            $id_utilisateur = $pdoConnexion->lastInsertId();

            //start a session
            session_start();

            //store the user_id in session
            $_SESSION['id_utilisateur'] = $id_utilisateur;

            var_dump($_SESSION['id_utilisateur']);

            // Redirect to login page
            header("Location: menu/menu.php");
            exit();
        }
    }
}
?>

<html>
<head>
    <title>Création de compte</title>
</head>
<body>
    <h1>Création de compte</h1>
    <p><?php echo $strQuestion ?> <a href="./index.php">Connectez-vous</a></p>
    <form method="post">
        <input type="hidden" value="<?php if(isset($id_utilisateur)) { echo $id_utilisateur; } ?>">
        <div>
            <label for="nom_utilisateur">Nom d’usager</label><br>
            <input type="text" name="nom_utilisateur" id="nom_utilisateur" value="<?php if(isset($username)) { echo $username; } ?>">
        </div>
        <br>
        <div>
            <label for="courriel">Courriel</label><br>
            <input type="email" name="courriel" id="courriel" value="<?php if(isset($email)) { echo $email; } ?>">
        </div>
        <br>
        <div>
            <label for="mot_de_passe">Choisir un mot de passe</label><br>
            <input type="password" name="mot_de_passe" id="mot_de_passe">
        </div>
        <br>
        <input type="submit" name="submit" value="Créer un compte">

        <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</body>
</html>