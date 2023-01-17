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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form data
    if(empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {
        // Hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

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

            // Redirect to login page
            header("Location: menu/menu.php");
            exit();
        }
    }
}
?>

<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    <p><?php echo $strQuestion ?></p><a href="./index.php">Connectez-vous</a>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php if(isset($username)) { echo $username; } ?>"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br>

        <input type="submit" name="submit" value="Sign Up">

        <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</body>
</html>