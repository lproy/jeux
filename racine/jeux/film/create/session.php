<?php

ini_set('display_errors', 1);
$niveau = '../../../';
include($niveau . 'inc/scripts/config.inc.php');

//tableau film
$arrFilm = array();

//chaine de caractère
$strCodeOperation="";
$arrMessagesErreur="";
$strEnteteH2="";
$strH2="";


//id_film dans la Querystring
$strIdFilm = isset($_GET["id_film"]) ? $_GET['id_film'] : 0;

if (isset($_GET['btn_nouveau'])) {
    $strCodeOperation = "nouveau";
    $strEnteteH1 = "Nouveau";
}

//Multi-step Précédent et Suivant
$etape = isset($_GET['precedent']) ? (int) $_GET['etape'] - 1 : (int) $_GET['etape'] + 1;

//Donnée étape 1
$strTitre = isset($_GET["titre"]) ? $_GET['titre'] : "";
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

//cloner film pour la franchise

// Affichage du contenu de l'étape correspondante
switch (true) {
    //Étape 2
    case $etape == 2:
        $strEnteteH2="Créer une franchise";
        $strH2="Choisir une franchise";
        break;
    //Étape 3
    case $etape == 3:
        $strEnteteH2="Genre";
        $strH2="Acteurs";
        break;
    //Étape 4
    case $etape == 4:
        $strEnteteH2="Couleur";
        break;
    //Étape 1
    default:
        $strEnteteH2="Information du film";
}

//**********************************************************************************
//Donnée dans une requete
//**********************************************************************************

//    //requete générale pour les films
//    $query = "SELECT id_film, titre, t_duree.id_duree, duree, t_classification.id_classification, type, t_classification.hexadecimal, t_couleur_background.id_couleur_background, t_couleur_background.hexadecimal, t_couleur_graphique.id_couleur_graphique, t_couleur_textes.id_couleur_textes, id_genre_film
//              FROM t_film
//              INNER JOIN t_duree ON t_film.id_duree = t_duree.id_duree
//              INNER JOIN t_classification ON t_film.id_classification = t_classification.id_classification
//              INNER JOIN t_couleur_background ON t_film.id_couleur_background = t_couleur_background.id_couleur_background
//              INNER JOIN t_couleur_graphique ON t_film.id_couleur_graphique = t_couleur_graphique.id_couleur_graphique
//              INNER JOIN t_couleur_textes ON t_film.id_couleur_textes = t_couleur_textes.id_couleur_textes
//              INNER JOIN ti_film_genre ON t_film.id_film_genre = ti_film_genre.id_film_genre
//              WHERE id_film=:id_film";
//
//    $pdosResultat = $pdoConnexion->prepare($query);
//    $pdosResultat->bindParam(':id_film', $strIdFilm);
//    $pdosResultat->execute();
//    $strCodeErreur = $pdoConnexion->errorCode();

    //étape 1
    $arrFilm[0]['titre'] = $strTitre;
    $arrFilm[0]['id_duree'] = $strIdDuree;
    $arrFilm[0]['id_classification'] = $strIdClassification;
    //étape 3
    $arrFilm[0]['id_genre_principal'] = $strGenrePrincipal;
    //étape 4
    $arrFilm[0]['id_couleur_background'] = $strIdBackground;
    $arrFilm[0]['id_couleur_graphique'] = $strIdGraphique;
    $arrFilm[0]['id_couleur_textes'] = $strIdTexte;

//    $pdosResultat->closeCursor();


if ($etape == 1) {
    if (isset($_GET['suivant'])) {
        //validation du nom
        if ($arrFilm[0]['titre'] == "" || strlen($arrFilm[0]['titre']) > 20) {
            //Si nom participant invalide...
            $strCodeErreur = "-1";
            $arrMessagesErreur = "*Veuillez rentrer un titre de film";
        }
        $etape=1;
    }
}

// Sélection de tous les duree dans la base de données
$strRequeteDuree =  'SELECT * FROM t_duree';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteDuree);

$arrDuree = array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrDuree[$cptEnr]['id_duree'] = $ligne['id_duree'];
    $arrDuree[$cptEnr]['duree'] = $ligne['duree'];
}
//Liberation de la 2e requête
$pdosResultat->closeCursor();

// Sélection de tous les classification dans la base de données
$strRequeteClassification =  'SELECT * FROM t_classification';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteClassification);

$arrClassification = array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrClassification[$cptEnr]['id_classification'] = $ligne['id_classification'];
    $arrClassification[$cptEnr]['type'] = $ligne['type'];
    $arrClassification[$cptEnr]['hexadecimal'] = $ligne['hexadecimal'];
}

//Liberation de la 2e requête
$pdosResultat->closeCursor();


//Établissement de la chaine de requête
$strRequeteClassificationWhere =  'SELECT * FROM t_classification WHERE id_classification=:id_classification';

//Exécution de la 2e requête
$pdosResultat=$pdoConnexion->prepare($strRequeteClassificationWhere);
$pdosResultat->bindValue(":id_classification", $strIdClassification);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();
$arrClassificationWhere = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrClassificationWhere[0]['type'] = $ligne['type'];
    $arrClassificationWhere[0]['hexadecimal'] = $ligne['hexadecimal'];
}
$pdosResultat->closeCursor();

//Établissement de la chaine de requête
$strRequeteDureeWhere =  'SELECT * FROM t_duree WHERE id_duree=:id_duree';

//Exécution de la 2e requête
$pdosResultat=$pdoConnexion->prepare($strRequeteDureeWhere);
$pdosResultat->bindValue(":id_duree", $strIdDuree);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();
$arrDureeWhere = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrDureeWhere[0]['duree'] = $ligne['duree'];
}
$pdosResultat->closeCursor();


//Établissement de la chaine de requête
$strRequeteGenre =  'SELECT * FROM t_genre';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteGenre);

$arrGenre= array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrGenre[$cptEnr]['id_genre'] = $ligne['id_genre'];
    $arrGenre[$cptEnr]['nom'] = $ligne['nom'];
    $arrGenre[$cptEnr]['typo'] = $ligne['typo'];

}
//Liberation de la 2e requête
$pdosResultat->closeCursor();

//Établissement de la chaine de requête
$strRequeteGenreWhere =  'SELECT * FROM t_genre WHERE id_genre=:id_genre_principal';

//Exécution de la 2e requête
$pdosResultat=$pdoConnexion->prepare($strRequeteGenreWhere);
$pdosResultat->bindValue(":id_genre_principal", $strGenrePrincipal);
$pdosResultat->execute();
$strCodeErreur = $pdoConnexion->errorCode();
$arrGenreWhere = array();

for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++) {
    $arrGenreWhere[0]['icone'] = $ligne['icone'];
}
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
    <!-- title / Liste des studios -->
    <title>Création du script</title>
    <!-- link css -->
    <link rel="stylesheet" href="../../../css/style.css">
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/8e8f598f58.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Création du script</h1>
<?php
$menuActifInfo = "";
$menuActifFranchise = "";
$menuActifGenre = "";
$menuActifDesign = "";
if (strpos($_SERVER['PHP_SELF'], '0')) {
    $suffixe = "Info";
} else if (strpos($_SERVER['PHP_SELF'], '1')) {
    $suffixe = "Franchise";
} else if (strpos($_SERVER['PHP_SELF'], '2')){
    $suffixe = "Genre";
} else{
    $suffixe = "Design";
}
${"menuActif" . $suffixe} = "nav__link--active";
?>
<nav role="navigation" class="nav nav--closed">
    <ul class="nav__list" id="navList">
        <li class="nav__list-item"><a class="nav__link <?php echo $menuActifInfo?>" href="session.php?etape=0">Info</a></li>
        <li class="nav__list-item"><a class="nav__link <?php echo $menuActifFranchise?>" href="session.php?etape=1">Franchise</a></li>
        <li class="nav__list-item"><a class="nav__link <?php echo $menuActifGenre?>" href="session.php?etape=2">Genre</a></li>
        <li class="nav__list-item"><a class="nav__link <?php echo $menuActifDesign?>" href="session.php?etape=3">Design</a></li>
    </ul>
</nav>

<form action="" method="get">
    <!--Donnée de l'étape-->
    <input type="hidden" name="etape" value="<?php echo $etape;?>">
    <!--Donnée de l'étape 1-->
    <input type="hidden" name="titre" value="<?php echo $strTitre; ?>">
    <input type="hidden" name="id_duree" value="<?php echo $strIdDuree; ?>">
    <input type="hidden" name="id_classification" value="<?php echo $strIdClassification; ?>">
    <!--Donnée de l'étape 2-->
    <input type="hidden" name="franchise" value="<?php echo $strFranchise; ?>">
    <!--Donnée de l'étape 3-->
    <input type="hidden" name="id_genre_principal" value="<?php echo $strGenrePrincipal; ?>">
    <input type="hidden" name="id_genre_sous" value="<?php echo $strGenreSous; ?>">
    <input type="hidden" name="id_genre_sous_deux" value="<?php echo $strGenreSousDeux; ?>">
    <!--Donnée de l'étape 4-->
    <input type="hidden" name="id_couleur_background" value="<?php echo $strIdBackground; ?>">
    <input type="hidden" name="id_couleur_textes" value="<?php echo $strIdTexte; ?>">
    <input type="hidden" name="id_couleur_graphique" value="<?php echo $strIdGraphique; ?>">
<h2><?php echo $strEnteteH2; ?></h2>

    <?php if($etape == 1) { ?>
        <label for="titre">Titre</label><br>
        <input type="text" id="titre" name="titre" value="<?php echo $strTitre; ?>" onchange="functionTitre()">
        <a href="#" class="fa-solid fa-dice-three fa-2xl" id="randomTitleButton"></a>
        <br><span><?php echo $arrMessagesErreur; ?></span>
        <br>
    <br>
    <fieldset>
        <legend>Durée</legend>
        <?php for($cpt=0;$cpt<count($arrDuree);$cpt++){ ?>
            <label>
                <input type="radio" name="id_duree" id="<?php echo $arrDuree[$cpt]['duree'];?>" value="<?php echo $arrDuree[$cpt]['id_duree'] ?>" onchange="functionDuree()" <?php echo ecrireChecked($arrDuree[$cpt]['id_duree'], 'duree')?>>
                <?php echo $arrDuree[$cpt]['duree']; ?>
            </label>
        <?php } ?>
    </fieldset>
    <fieldset>
        <legend>Classification</legend>
            <?php for($cpt=0;$cpt<count($arrClassification);$cpt++){ ?>
            <label style="color: <?php echo $arrClassification[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_classification" id="<?php echo $arrClassification[$cpt]['type'];?>" value="<?php echo $arrClassification[$cpt]['id_classification'];?>" onchange="functionClassification()"
                    <?php echo ecrireChecked($arrClassification[$cpt]['id_classification'], 'classification')?>>
                <?php echo $arrClassification[$cpt]['type']; ?>
            </label>
            <?php } ?>
    </fieldset>
    <?php } ?>
    <!--  Étape 2  -->
    <?php if($etape == 2 ) { ?>
        <label for="franchise">Franchise</label><br>
        <input type="text" id="franchise" name="franchise" value="<?php echo $strFranchise; ?>">
        <br>
        <p>Ou</p>
<!--        <h2><a href="#" id="overlay-link">--><?php //echo $strH2; ?><!--</a></h2>-->

        <a href="#" id="overlay-link"><?php echo $strH2; ?></a>
        <div id="overlay">
            <div id="overlay-content">
                <p>Contenu de l'overlay</p>
                <button id="overlay-close">Fermer</button>
            </div>
        </div>


        <br>
    <?php } ?>
    <!--  Étape 3  -->
    <?php if($etape == 3 ) { ?>
        <div>
            <label for="id_genre_principal">Principal</label><br>
            <select id="id_genre_principal" name="id_genre_principal" onchange="functionGenre()">
                    <option value="0">Choisir un genre</option>
               <?php for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
                    <option value="<?php echo $arrGenre[$cpt]['id_genre'];?>" <?php echo ecrireSelected($arrGenre[$cpt]["id_genre"], 'genre_principal');  ?>>
                        <?php echo $arrGenre[$cpt]['nom']; ?></option>
                <?php } ?>
            </select>
        </div>
        <br>
<!--        <div>-->
<!--            <label for="id_genre">Sous-Genre :</label>-->
<!--            <select id="id_genre" name="id_genre_sous">-->
<!--                <option value="0">Choisir un genre</option>-->
<!--                --><?php //for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
<!--                    <option value="--><?php //echo $arrGenre[$cpt]['id_genre'];?><!--">-->
<!--                        --><?php //echo $arrGenre[$cpt]['nom']?><!--</option>-->
<!--                --><?php //} ?>
<!--            </select>-->
<!--        </div>-->
<!--        <br>-->
<!--        <div>-->
<!--            <label for="id_genre">Sous-Genre :</label>-->
<!--            <select id="id_genre" name="id_genre_sous_deux">-->
<!--                <option value="0">Choisir un genre</option>-->
<!--                --><?php //for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
<!--                    <option value="--><?php //echo $arrGenre[$cpt]['id_genre'];?><!--">-->
<!--                        --><?php //echo $arrGenre[$cpt]['nom']?><!--</option>-->
<!--                --><?php //} ?>
<!--            </select>-->
<!--        </div>-->
        <br>
        <h2><?php echo $strH2; ?></h2>
        <br>
        <div>
            <label for="id_acteur_principal">Principal :</label>
            <select id="id_acteur_principal" name="id_acteur_principal">
                <option value="1">1</option>
            </select>
        </div>
        <div>
            <label for="id_acteur_secondaire">Secondaire :</label>
            <select id="id_acteur_secondaire" name="id_acteur_secondaire">
                <option value="1">0</option>
            </select>
        </div>
        <div>
            <p>Total</p>
            <p>Nombre total</p>
        </div>
    <?php } ?>
    <?php if($etape == 4 ) { ?>
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
    <?php } ?>
    <br>
    <?php if($etape == 1): ?>
        <input type="submit" name="suivant" value="Suivant">
    <?php elseif($etape == 4): ?>
        <input type="submit" name="precedent" value="Précédent">
    <?php else: ?>
        <input type="submit" name="precedent" value="Précédent">
        <input type="submit" name="suivant" value="Suivant">
    <?php endif; ?>
</form>
<section class="affiche">
    <div class="affiche__background" id="couleur_principal" style="background-color: <?php echo $arrBackgroundWhere[0]['hexadecimal']; ?>">
        <div class="affiche__texte" id="couleur_textes" style="color: <?php echo $arrTextesWhere[0]['hexadecimal']; ?>">
            <p>Future Nomination</p>
            <div class="affiche__ligne"></div>
            <i class="fa-solid fa-4x <?php echo $arrGenreWhere[0]['icone']; ?>" id="couleur_graphique" style="color: <?php echo $arrGraphiqueWhere[0]['hexadecimal']; ?>"></i>
            <p id="titre_du_film"><?php if(isset($_GET['titre'])){ echo $_GET['titre'];} else { echo 'Titre du film'; }?></p>
            <p id="type_classification-deux" style="color: <?php echo $arrClassificationWhere[0]['hexadecimal'];?>"><?php echo $arrClassificationWhere[0]['type']?></p>
        </div>
    </div>
    <div>
        <table>
            <?php if($strCodeOperation=="nouveau" || $etape == 1) { ?>
            <tr>
                <th style="text-align: end">Titre :</th>
                <td class="fa-fade" id="titre_2" style="text-align: start"><?php if(isset($_GET['titre'])){ echo $_GET['titre'];} ?></td>
            </tr>
            <tr>
                <th style="text-align: end">Durée :</th>
                <td class="fa-fade" id="film_duree" style="text-align: start"><?php echo $arrDureeWhere[0]['duree']; ?></td>
            </tr>
            <tr>
                <th style="text-align: end">Classification :</th>
                <td class="fa-fade" id="type_classification" style="text-align: start; color: <?php echo $arrClassificationWhere[0]['hexadecimal'];?>"><?php echo $arrClassificationWhere[0]['type']; ?></td>
            </tr>
            <?php } ?>
            <?php if($strCodeOperation!="nouveau" && $etape != 1) { ?>
            <tr>
                <th style="text-align: end">Titre :</th>
                <td id="titre_2" style="text-align: start"><?php if(isset($_GET['titre'])){ echo $_GET['titre'];} ?></td>
            </tr>
            <tr>
                <th style="text-align: end">Durée :</th>
                <td id="film_duree" style="text-align: start"><?php echo $arrDureeWhere[0]['duree']; ?></td>
            </tr>
            <tr>
                <th style="text-align: end">Classification :</th>
                <td id="type_classification" style="text-align: start; color: <?php echo $arrClassificationWhere[0]['hexadecimal'];?>"><?php echo $arrClassificationWhere[0]['type']; ?></td>
            </tr>
            <?php if ($etape == 3 || $etape == 4) { ?>
                    <tr>
                        <th style="text-align: end">Franchise :</th>
                        <td style="text-align: start"><?php if(isset($_GET['id_duree'])){ echo $_GET['id_duree'];} ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
</section>
<!--Annuler ou Terminez le script-->
<section class="">
    <a class="" href="../../index.php">Annuler</a>
    <form action="" method="get">
        <!--Le input terminez est seulement clicable à l'étape 4-->
        <input class="" type="submit" name="terminez_script" value="Terminez le script" <?php echo $etape == 4 ? '' : 'disabled' ?>>
    </form>
</section>

<!--javascript-->
<script src="../../../js/titre_film.js"></script>
</body>
</html>

<script>




    function functionTitre() {
        let strTitre = document.getElementById("titre").value;

        // Vérifie si la chaîne commence par une lettre majuscule
        strTitre = strTitre.charAt(0).toUpperCase() + strTitre.slice(1);

        // Enlève les caractères spéciaux de la chaîne
        strTitre = strTitre.replace(/[^a-zA-Z0-9 :-ÀÁÆÇÈÉÊÙÚÛàáæçèéêëùúû]/g, "");

        // Vérifie si la chaîne contient au moins 3 lettres
        if (!/[a-zA-Z]{3,}/.test(strTitre)) {
            alert("Le titre doit contenir au moins 3 lettres");
        }
        else {
            // Met à jour l'input avec la chaîne formatée
            document.getElementById("titre").value = strTitre;
            document.getElementById("titre_du_film").innerHTML = strTitre;
            document.getElementById("titre_2").innerHTML = strTitre;
        }
    }

    document.getElementById("randomTitleButton").addEventListener("click", function functionTitre() {

        // Génère un nombre au hasard entre 0 et la longueur du tableau filmTitles
        const filmTitles = ["Eternal Sunshine", "Vol au-dessus d'un nid de coucou", "Requiem for a Dream", "De battre mon cœur s'est arrêté", "Le Tombeau des lucioles", "Les Contes de la lune vague après la pluie", "Le Cercle des poètes disparus", "Une vie de bestiole", "16 rues", "Encore 17 ans", "24 heures avant nuit", "13 ans, bientôt 30", "Gone in 60 Seconds", "Edge, The"];
        const randomIndex = Math.floor(Math.random() * filmTitles.length);

        // Récupère le titre de film au hasard à partir de l'index aléatoire
        const randomTitle = filmTitles[randomIndex];

        // Met à jour l'input de titre avec le titre de film au hasard
        document.getElementById("titre").value = randomTitle;
        document.getElementById("titre_du_film").innerHTML = randomTitle;
        document.getElementById("titre_2").innerHTML = randomTitle;
    });


    function functionGenre() {
        let mylist = document.getElementById("id_genre_principal");
        document.getElementById("couleur_graphique").value = mylist.options[mylist.selectedIndex].text;

        // Get the selected value
        let selectedValue = mylist.options[mylist.selectedIndex].value;

        // Remove the class before adding the new one
        let elements = document.getElementsByClassName("fa-solid fa-4x");
        let classes = ["fa-explosion", "fa-gun", "fa-signs-post", "fa-user", "fa-mask", "fa-masks-theater", "fa-binoculars", "fa-handcuffs", "fa-hat-wizard", "fa-magnifying-glass-location", "fa-cloud-showers-heavy", "fa-landmark", "fa-candy-cane", "fa-ghost", "fa-mosquito", "fa-music", "fa-heart", "fa-robot", "fa-medal", "fa-user-secret", "fa-bat", "fa-hat-cowboy", "fa-face-disappointed", "fa-skull"];
        for (let i = 0; i < elements.length; i++) {
            elements[i].classList.remove(...classes);
        }
        // Add the class according to the selected value
        let classMap = {
            "1": "fa-explosion",
            "2": "fa-signs-post",
            "3": "fa-user",
            "4": "fa-masks-theater",
            "5": "fa-handcuffs",
            "6": "fa-cloud-showers-heavy",
            "7": "fa-hat-wizard",
            "8": "fa-landmark",
            "9": "fa-candy-cane",
            "10": "fa-ghost",
            "11": "fa-mosquito",
            "12": "fa-music",
            "13": "fa-magnifying-glass-location",
            "14": "fa-user-secret",
            "15": "fa-heart",
            "16": "fa-robot",
            "17": "fa-medal",
            "18": "fa-binoculars",
            "19": "fa-mask",
            "20": "fa-skull",
            "21": "fa-hat-cowboy"
        }
        let classToAdd = classMap[selectedValue];
        if (classToAdd) {
            document.getElementById("couleur_graphique").classList.add(classToAdd);
        }
    }

    function functionDuree() {
        let radios = document.getElementsByName("id_duree");
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                document.getElementById("film_duree").innerHTML =
                    document.getElementById(radios[i].id).id;
                break;
            }
        }
    }
    function functionClassification() {
        let radios = document.getElementsByName("id_classification");
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                document.getElementById("type_classification-deux").innerHTML =
                    document.getElementById(radios[i].id).id;
                document.getElementById("type_classification").innerHTML =
                    document.getElementById(radios[i].id).id;
                break;
            }
        }
    }
    function functionCouleurPrincipal() {
        let radios = document.getElementsByName("id_couleur_background");
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                document.getElementById("couleur_principal").style.background =
                    document.getElementById(radios[i].id).id;
                break;
            }
        }
    }
    function functionCouleurTexte() {
        let radios = document.getElementsByName("id_couleur_textes");
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                document.getElementById("couleur_textes").style.color =
                    document.getElementById(radios[i].id).id;
                break;
            }
        }
    }
    function functionCouleurGraphique() {
        let radios = document.getElementsByName("id_couleur_graphique");
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                document.getElementById("couleur_graphique").style.color =
                    document.getElementById(radios[i].id).id;
                break;
            }
        }
    }
</script>
