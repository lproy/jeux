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

$strEnteteH1="Nouveau jeu";
$strEnteteH2 = "";

//Multi-step Précédent et Suivant
$etape = isset($_GET['precedent']) ? (int) $_GET['etape'] - 1 : (int) $_GET['etape'] + 1;

//Donnée étape 1
$strTitre = isset($_GET["titre"]) ? $_GET['titre'] : "Titre du film";
$strIdClassification = isset($_GET['id_classification']) ? $_GET['id_classification'] : 1;
$strIdDuree = isset($_GET['id_duree']) ? $_GET['id_duree'] : 1;

//Donnée étape 2
$strFranchise = isset($_GET["franchise"]) ? $_GET['franchise'] : "";

//Donnée étape 3
$strGenrePrincipal = isset($_GET["id_genre_principal"]) ? $_GET['id_genre_principal'] : 0;
$strGenreSous = isset($_GET["id_genre_sous"]) ? $_GET['id_genre_sous'] : 0;
$strGenreSousDeux = isset($_GET["id_genre_sous_deux"]) ? $_GET['id_genre_sous_deux'] : 0;

//Donnée étape 4
$strIdBackground = isset($_GET["id_couleur_background"]) ? $_GET['id_couleur_background'] : 2;
$strIdGraphique = isset($_GET["id_couleur_graphique"]) ? $_GET['id_couleur_graphique'] : 1;
$strIdTexte = isset($_GET["id_couleur_textes"]) ? $_GET['id_couleur_textes'] : 1;

//requete générale pour les films
$query = "SELECT id_film, titre, t_duree.id_duree, duree, t_classification.id_classification, type, t_classification.hexadecimal, t_couleur_background.id_couleur_background, t_couleur_background.hexadecimal, t_couleur_graphique.id_couleur_graphique, t_couleur_textes.id_couleur_textes 
              FROM t_film 
              INNER JOIN t_duree ON t_film.id_duree = t_duree.id_duree 
              INNER JOIN t_classification ON t_film.id_classification = t_classification.id_classification
              INNER JOIN t_couleur_background ON t_film.id_couleur_background = t_couleur_background.id_couleur_background
              INNER JOIN t_couleur_graphique ON t_film.id_couleur_graphique = t_couleur_graphique.id_couleur_graphique     
              INNER JOIN t_couleur_textes ON t_film.id_couleur_textes = t_couleur_textes.id_couleur_textes
              WHERE id_film=:id_film";

$pdosResultat = $pdoConnexion->prepare($query);
$pdosResultat->bindParam(':id_film', $strIdFilm);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();

$arrFilm[0]['titre'] = $strTitre;
$arrFilm[0]['id_duree'] = $strIdDuree;
$arrFilm[0]['id_classification'] = $strIdClassification;
$arrFilm[0]['id_couleur_background'] = $strIdBackground;
$arrFilm[0]['id_couleur_graphique'] = $strIdGraphique;
$arrFilm[0]['id_couleur_textes'] = $strIdTexte;

$pdosResultat->closeCursor();


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

//Fonction utilitaire pour l'affichage des boutons radio
function ecrireChecked($valeurRadio, $nomRadio){
    $strCocher="";
    global $arrFilm;
    if($valeurRadio == $arrFilm[0]['id_'.$nomRadio]){
        $strCocher='checked="checked"';
    }
    return $strCocher;
}

//Fonction utilitaire pour l'affichage des select
function ecrireSelected($valeurOption, $nomSelection){
    $strSelection="";
    global $arrFilm;
    if($valeurOption == $arrFilm[0]["id_".$nomSelection]){
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
    <link rel="stylesheet" href="#">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1><?php echo $strEnteteH1;?></h1>
<h2><?php echo $strEnteteH2;?></h2>

<form action="" method="get">
    <label for="nom">Nom</label><br>
    <input type="text" id="nom" name="nom" value="<?php if(isset($_GET['nom'])){ echo $_GET['nom'];}?>" onchange="functiontitre()">
    <br>
    <div>
        <label for="id_genre">Surnom</label><br>
<!--        <select id="id_genre" name="id_genre_principal" onchange="myFunction()">-->
<!--            <option value="0">Choisir un genre</option>-->
<!--            --><?php //for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
<!--                <option value="--><?php //echo $arrGenre[$cpt]['nom'];?><!--">-->
<!--                    --><?php //echo $arrGenre[$cpt]['nom']; ?><!--</option>-->
<!--            --><?php //} ?>
<!--        </select>-->
    </div>
        <p>
            <label for="amount">Modèle</label><br>
            <input type="range" id="amount" name="amount" min="0" max="100" onchange="showValue(this.value)" />
        </p>
        <p>Value: <span id="range">50</span></p>
    <p>
        <label for="amount">Typo nom</label><br>
        <input type="range" id="amount" name="amount" min="0" max="100" onchange="showValue(this.value)" />
    </p>
    <p>Value: <span id="range">50</span></p>
    <p>
        <label for="amount">Typo surnom</label><br>
        <input type="range" id="amount" name="amount" min="0" max="100" onchange="showValue(this.value)" />
    </p>
    <p>Value: <span id="range">50</span></p>

    <fieldset>
        <legend>Principal :</legend>
        <?php for($cpt=0;$cpt<count($arrBackground);$cpt++){ ?>
            <label style="color: <?php echo $arrBackground[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrBackground[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_couleur_background" id="<?php echo $arrBackground[$cpt]['hexadecimal'];?>" value="<?php echo $arrBackground[$cpt]['id_couleur_background'];?>" onchange="functionCouleurPrincipal()"
                    <?php echo ecrireChecked($arrBackground[$cpt]['id_couleur_background'], 'couleur_background');?>>
                <?php echo $arrBackground[$cpt]['nom_couleur']; ?>
            </label>
        <?php } ?>
    </fieldset>
    <fieldset>
        <legend>Texte :</legend>
        <?php for($cpt=0;$cpt<count($arrTextes);$cpt++){ ?>
            <label style="color: <?php echo $arrTextes[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrTextes[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_couleur_textes" id="<?php echo $arrTextes[$cpt]['hexadecimal'];?>" value="<?php echo $arrTextes[$cpt]['id_couleur_textes'];?>" onchange="functionCouleurTexte()"
                    <?php echo ecrireChecked($arrTextes[$cpt]['id_couleur_textes'], 'couleur_textes')?>>
                <?php echo $arrTextes[$cpt]['nom_couleur']; ?>
            </label>
        <?php } ?>
    </fieldset>
    <fieldset>
        <legend>Graphique :</legend>
        <?php for($cpt=0;$cpt<count($arrGraphique);$cpt++){ ?>
            <label style="color: <?php echo $arrGraphique[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrGraphique[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_couleur_graphique" id="<?php echo $arrGraphique[$cpt]['hexadecimal'];?>" value="<?php echo $arrGraphique[$cpt]['id_couleur_graphique'];?>" onchange="functionCouleurGraphique()"
                    <?php echo ecrireChecked($arrGraphique[$cpt]['id_couleur_graphique'], 'couleur_graphique')?>>
                <?php echo $arrGraphique[$cpt]['nom_couleur']; ?>
            </label>
        <?php } ?>
    </fieldset>

</form>
</body>
</html>
<script>
    function showValue(newValue)
    {
        document.getElementById("range").innerHTML=newValue;
    }
</script>
