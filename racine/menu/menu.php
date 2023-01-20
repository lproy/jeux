<?php
session_start();

///////////////*Erreur PHP*///////////////
error_reporting(0);
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

///////////////*Inclusion*///////////////

//Créer variable niveau
$niveau = "./../";

//Inclusion du fichier de configuration
include ($niveau. 'inc/scripts/config.inc.php');

$strEnteteH1="BlockBuster";

// Check if user is logged in
if(empty($_SESSION['id_utilisateur'])) {
    header("Location: ../index.php");
    exit();
}
$strIdUtilisateur = $_SESSION['id_utilisateur'];

$stmt = $pdoConnexion->prepare("SELECT * FROM t_utilisateur WHERE id_utilisateur=:id_utilisateur AND id_utilisateur = (SELECT id_studios FROM t_studios WHERE id_utilisateur NOT LIKE false)");

$stmt->bindParam(':id_utilisateur', $strIdUtilisateur);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user has a studio
$hasStudio = isset($user['id_utilisateur']) ? $user['id_utilisateur'] : false;

// Logout
if(isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();
    header("Location: ../index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; chaset=UTF-8">
    <meta charset="UTF-8">
    <title>Menu du jeu - BlockBuster</title>
    <!-- link css -->
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1><?php echo $strEnteteH1;?></h1>
<form action="nouveau/index.php" method="get">
    <input type="hidden" name="etape" value="0">
    <div>
        <input type="submit" value="Nouveau jeu" name="btn_nouveau">
    </div>
</form>
<?php if ($hasStudio == true): ?>
    <div>
        <a href="../jeux/index.php">Continuer jeu</a>
    </div>
<?php endif; ?>
<form action="" method="GET">
    <div>
        <input type="submit" value="Recharger sauvegarde" name="btn_recharger">
    </div>
</form>
<form action="" method="GET">
    <div>
        <input type="submit" value="Information du compte" name="btn_information">
    </div>
</form>
<form action="" method="GET">
    <div>
        <input type="submit" value="Paramètre de jeu" name="btn_parametre">
    </div>
</form>
<form action="" method="GET">
<a href='?logout=true'>Se Déconnectez</a>
</form>


</body>
</html>
