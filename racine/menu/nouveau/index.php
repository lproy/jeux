<?php
session_start();

///////////////*Erreur PHP*///////////////
error_reporting(0);
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

///////////////*Inclusion*///////////////

//Créer variable niveau
$niveau = "./../../";

//Inclusion du fichier de configuration
include ($niveau. 'inc/scripts/config.inc.php');

$strEnteteH1="Nouveau Studio";
$strEnteteH2 = "";


$arrrStudio = array();

//Multi-step Précédent et Suivant
$etape = isset($_GET['precedent']) ? (int) $_GET['etape'] - 1 : (int) $_GET['etape'] + 1;

// Affichage du contenu de l'étape correspondante
switch (true) {
    //Étape 2
    case $etape == 2:
        $strEnteteH2="Couleur du logo";
        break;
    //Étape 1
    default:
        $strEnteteH2="Studio";
}


//Donnée étape 1
$strNomStudio = isset($_GET["nom_studios"]) ? $_GET['nom_studios'] : "";
$strSurnom = isset($_GET["id_studio_surnom"]) ? $_GET['id_studio_surnom'] : 1;
$strModele = isset($_GET["id_studio_modele"]) ? $_GET['id_studio_modele'] : 0;
$strTypoNom = isset($_GET["id_typo_nom"]) ? $_GET['id_typo_nom'] : 0;
$strTypoSurnom = isset($_GET["id_typo_surnom"]) ? $_GET['id_typo_surnom'] : 0;

//Donnée étape 4
$strIdBackground = isset($_GET["id_couleur_background"]) ? $_GET['id_couleur_background'] : 2;
$strIdGraphique = isset($_GET["id_couleur_graphique"]) ? $_GET['id_couleur_graphique'] : 1;
$strIdTexte = isset($_GET["id_couleur_textes"]) ? $_GET['id_couleur_textes'] : 1;

$arrStudio[0]['nom_studios'] = $strNomStudio;
$arrStudio[0]['id_studio_surnom'] = $strSurnom;
$arrStudio[0]['id_studio_modele'] = $strModele;
$arrStudio[0]['id_typo_nom'] = $strTypoNom;
$arrStudio[0]['id_typo_surnom'] = $strTypoSurnom;
$arrStudio[0]['id_couleur_background'] = $strIdBackground;
$arrStudio[0]['id_couleur_graphique'] = $strIdGraphique;
$arrStudio[0]['id_couleur_textes'] = $strIdTexte;

// Sélection de tous les duree dans la base de données
$strRequeteBackground =  'SELECT * FROM t_couleur_background';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteBackground);

$arrBackground = array();

//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrBackground[$cptEnr]['id_couleur_background'] = $ligne['id_couleur_background'];
    $arrBackground[$cptEnr]['hexadecimal'] = $ligne['hexadecimal'];
    $arrBackground[$cptEnr]['nom_couleur'] = $ligne['nom_couleur'];
}

//Liberation de la 2e requête
$pdosResultat->closeCursor();

//Établissement de la chaine de requête
$strRequeteBackgroundWhere =  'SELECT * FROM t_couleur_background WHERE id_couleur_background=:id_couleur_background';

//Exécution de la 2e requête
$pdosResultat=$pdoConnexion->prepare($strRequeteBackgroundWhere);
$pdosResultat->bindValue(":id_couleur_background", $strIdBackground);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();
$arrBackgroundWhere = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrBackgroundWhere[0]['hexadecimal'] = $ligne['hexadecimal'];
}
$pdosResultat->closeCursor();


// Sélection de tous les duree dans la base de données
$strRequeteGraphique =  'SELECT * FROM t_couleur_graphique';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteGraphique);

$arrGraphique = array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrGraphique[$cptEnr]['id_couleur_graphique'] = $ligne['id_couleur_graphique'];
    $arrGraphique[$cptEnr]['hexadecimal'] = $ligne['hexadecimal'];
    $arrGraphique[$cptEnr]['nom_couleur'] = $ligne['nom_couleur'];
}
//Liberation de la 2e requête
$pdosResultat->closeCursor();

//Établissement de la chaine de requête
$strRequeteGraphiqueWhere =  'SELECT * FROM t_couleur_graphique WHERE id_couleur_graphique=:id_couleur_graphique';

//Exécution de la 2e requête
$pdosResultat=$pdoConnexion->prepare($strRequeteGraphiqueWhere);
$pdosResultat->bindValue(":id_couleur_graphique", $strIdGraphique);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();
$arrGraphiqueWhere = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrGraphiqueWhere[0]['hexadecimal'] = $ligne['hexadecimal'];
}
$pdosResultat->closeCursor();

// Sélection de tous les duree dans la base de données
$strRequeteTextes =  'SELECT * FROM t_couleur_textes';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteTextes);

$arrTextes = array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrTextes[$cptEnr]['id_couleur_textes'] = $ligne['id_couleur_textes'];
    $arrTextes[$cptEnr]['hexadecimal'] = $ligne['hexadecimal'];
    $arrTextes[$cptEnr]['nom_couleur'] = $ligne['nom_couleur'];
}
//Liberation de la 2e requête
$pdosResultat->closeCursor();

//Établissement de la chaine de requête
$strRequeteTextesWhere =  'SELECT * FROM t_couleur_textes WHERE id_couleur_textes=:id_couleur_textes';

//Exécution de la 2e requête
$pdosResultat=$pdoConnexion->prepare($strRequeteTextesWhere);
$pdosResultat->bindValue(":id_couleur_textes", $strIdTexte);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();
$arrTextesWhere = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrTextesWhere[0]['hexadecimal'] = $ligne['hexadecimal'];
}
$pdosResultat->closeCursor();

// Sélection de tous les surnom dans la base de données
$strRequeteSurnom =  'SELECT * FROM t_studio_surnom';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteSurnom);

$arrSurnom = array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrSurnom[$cptEnr]['id_studio_surnom'] = $ligne['id_studio_surnom'];
    $arrSurnom[$cptEnr]['nom'] = $ligne['nom'];
}
//Liberation de la 2e requête
$pdosResultat->closeCursor();

//Fonction utilitaire pour l'affichage des boutons radio
function ecrireChecked($valeurRadio, $nomRadio){
    $strCocher="";
    global $arrStudio;
    if($valeurRadio == $arrStudio[0]['id_'.$nomRadio]){
        $strCocher='checked="checked"';
    }
    return $strCocher;
}

//Fonction utilitaire pour l'affichage des select
function ecrireSelected($valeurOption, $nomSelection){
    $strSelection="";
    global $arrStudio;
    if($valeurOption == $arrStudio[0]["id_".$nomSelection]){
        $strSelection='selected="selected"';
    }
    return $strSelection;
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
    <link rel="stylesheet" href="../../css/style.css">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1><?php echo $strEnteteH1;?></h1>
<h2><?php echo $strEnteteH2;?></h2>

<form action="" method="get">

    <!--Donnée de l'étape-->
    <input type="hidden" name="etape" value="<?php echo $etape;?>">
    <!--Donnée de l'étape 1-->
    <input type="hidden" name="nom_studios" value="<?php echo $strNomStudio; ?>">
    <input type="hidden" name="id_studio_surnom" value="<?php echo $strSurnom; ?>">
    <input type="hidden" name="id_studio_modele" value="<?php echo $strModele; ?>">
    <input type="hidden" name="id_typo_nom" value="<?php echo $strTypoNom; ?>">
    <input type="hidden" name="id_typo_surnom" value="<?php echo $strTypoSurnom; ?>">
    <!--Donnée de l'étape 2-->
    <input type="hidden" name="id_couleur_background" value="<?php echo $strIdBackground; ?>">
    <input type="hidden" name="id_couleur_graphique" value="<?php echo $strIdGraphique; ?>">
    <input type="hidden" name="id_couleur_textes" value="<?php echo $strIdTexte; ?>">

    <?php if($etape == 1) { ?>
    <label for="nom">Nom</label><br>
    <input type="text" id="nom_studios" name="nom_studios" value="<?php echo $strNomStudio; ?>" onchange="functiontitre()">
    <br>
    <div>
        <label for="id_studio_surnom">Surnom</label><br>
        <select id="id_studio_surnom" name="id_studio_surnom" onchange="myFunction()">
            <?php for($cpt=0;$cpt<count($arrSurnom);$cpt++){ ?>
                <option id="<?php echo $arrSurnom[$cpt]['nom'];?>" value="<?php echo $arrSurnom[$cpt]['id_studio_surnom'];?>"
                    <?php echo ecrireSelected($arrSurnom[$cpt]['id_studio_surnom'], "studio_surnom"); ?>>
                    <?php echo $arrSurnom[$cpt]['nom']; ?></option>
            <?php } ?>
        </select>
    </div>
        <p>
            <label for="amount">Modèle</label><br>
            <input type="range" id="amount" name="amount" min="0" max="10" onchange="showValue(this.value)" />
        </p>
    <p>
        <label for="amount">Typo nom</label><br>
        <input type="range" id="amount" name="amount" min="0" max="10" onchange="showValue(this.value)" />
    </p>
    <p>
        <label for="rangeSelect">Typo surnom</label><br>
        <input type="range" id="rangeSelect" name="rangeSelect" min="0" max="10" />
    </p>
<?php } ?>
    <?php if($etape == 2) { ?>
    <fieldset>
        <legend>Principal</legend>
        <?php for($cpt=0;$cpt<count($arrBackground);$cpt++){ ?>
            <label class="radio_color" style="color: <?php echo $arrBackground[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrBackground[$cpt]['hexadecimal'];?>">
                <input class="radio_color-radio" type="radio" name="id_couleur_background" id="<?php echo $arrBackground[$cpt]['hexadecimal'];?>" value="<?php echo $arrBackground[$cpt]['id_couleur_background'];?>" onchange="functionCouleurPrincipal()"
                    <?php echo ecrireChecked($arrBackground[$cpt]['id_couleur_background'], 'couleur_background');?>>
                <span class="checkmark"></span>
            </label>

        <?php } ?>
    </fieldset>
    <fieldset>
        <legend>Texte</legend>
        <?php for($cpt=0;$cpt<count($arrTextes);$cpt++){ ?>
            <label style="color: <?php echo $arrTextes[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrTextes[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_couleur_textes" id="<?php echo $arrTextes[$cpt]['hexadecimal'];?>" value="<?php echo $arrTextes[$cpt]['id_couleur_textes'];?>" onchange="functionCouleurTexte()"
                    <?php echo ecrireChecked($arrTextes[$cpt]['id_couleur_textes'], 'couleur_textes')?>>
                <?php echo $arrTextes[$cpt]['nom_couleur']; ?>
            </label>
        <?php } ?>
    </fieldset>
    <fieldset>
        <legend>Graphique</legend>
        <?php for($cpt=0;$cpt<count($arrGraphique);$cpt++){ ?>
            <label style="color: <?php echo $arrGraphique[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrGraphique[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_couleur_graphique" id="<?php echo $arrGraphique[$cpt]['hexadecimal'];?>" value="<?php echo $arrGraphique[$cpt]['id_couleur_graphique'];?>" onchange="functionCouleurGraphique()"
                    <?php echo ecrireChecked($arrGraphique[$cpt]['id_couleur_graphique'], 'couleur_graphique')?>>
                <?php echo $arrGraphique[$cpt]['nom_couleur']; ?>
            </label>
        <?php } ?>
    </fieldset>
    <?php } ?>
    <?php if($etape == 1): ?>
        <input type="submit" name="suivant" value="Suivant">
    <?php else: ?>
        <input type="submit" name="precedent" value="Précédent">
    <?php endif; ?>
</form>
</body>
</html>
<script>
    function showValue(newValue)
    {
        document.getElementById("range").innerHTML=newValue;
    }
</script>
