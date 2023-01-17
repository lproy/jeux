<?php

ini_set('display_errors', 1);
$niveau = '../../../';
include($niveau . 'inc/scripts/config.inc.php');

//tableau film
$arrFilm = array();

//chaine de caractère
$strCodeOperation="";
$arrMessagesErreur="";
$strIdClassification="";
$strIdDuree="";
$strEnteteH2="";
$strH2="";

//chaine de caractère précédent et suivant
$strPrecedentEtSuivant = "";

//id_film dans la Querystring
if(isset($_GET["id_film"]) == true){
    $strIdFilm=$_GET['id_film'];
} else{
    //Dans le cas ou il n'y a pas de Querystring
    $strIdFilm = 0;
}

//Multi-step
$etape = 1;

//Précédent
if(isset($_GET['precedent'])){
    $strPrecedentEtSuivant="precedent";
    $etape = (int) $_GET['etape'] - 1;
}
//Suivant
elseif(isset($_GET['suivant'])){
    $strPrecedentEtSuivant="suivant";
    $etape = (int) $_GET['etape'] + 1;
}

// Affichage du contenu de l'étape correspondante
switch (true) {
    //Étape 2
    case $etape == 2:
        //H2
        $strEnteteH2="Créer une franchise";
        $strH2="Choisir une franchise";

        $strIdClassification=$_GET['id_classification'];
        $strIdDuree=$_GET['id_duree'];
        break;
    //Étape 3
    case $etape == 3:
        //H2
        $strEnteteH2="Genre";
        $strH2="Acteurs";

        $strIdClassification=$_GET['id_classification'];
        $strIdDuree=$_GET['id_duree'];
        break;
    //Étape 4
    case $etape == 4:
        //H2
        $strEnteteH2="Couleur";

        $strIdClassification=$_GET['id_classification'];
        $strIdDuree=$_GET['id_duree'];
        if(isset($_GET["id_couleur_background"])){
            $strIdBackground = $_GET['id_couleur_background'];
        }else{
            $strIdBackground = 2;
        }
        break;
    default:
        $strEnteteH2="Information du film";
        if(isset($_GET["id_classification"])){
            $strIdClassification = $_GET['id_classification'];
        }else{
            $strIdClassification = 1;
        }
        if(isset($_GET['id_duree'])){
            $strIdDuree = $_GET['id_duree'];
        }else{
            $strIdDuree = 1;
        }
}
switch (true){
    case isset($_GET['btn_modifier']):
        $strCodeOperation="modifier";
        $strEnteteH1="Modifier";
        break;
    case isset($_GET['btn_ajouter']):
        $strCodeOperation="ajouter";
        $strEnteteH1="Ajouter";
        break;
    case isset($_GET['btn_nouveau']):
        $strCodeOperation="nouveau";
        $strEnteteH1="Nouveau";
        break;
    case isset($_GET['btn_supprimer']):
        $strCodeOperation="supprimer";
        $strEnteteH1="Supprimer";
        break;
    default:
        $strCodeOperation="Faire_une_suite";
        $strEnteteH1="Faire_une_suiter";
}

//**********************************************************************************
//Étape 1
//**********************************************************************************

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

    $arrFilm[0]['titre']="";
    $arrFilm[0]['id_duree'] = 1;
    $arrFilm[0]['id_classification'] = 1;
    $arrFilm[0]['id_couleur_background'] = 2;
    $arrFilm[0]['id_couleur_graphique'] = 1;
    $arrFilm[0]['id_couleur_textes'] = 1;
    $pdosResultat->closeCursor();

if($etape == 1){
    if(isset($_GET["titre"])){
        $arrFilm[0]['titre'] = $_GET['titre'];
    }else{
        $arrFilm[0]['titre'] = "";
    }
    if(isset($_GET["id_duree"])){
        $arrFilm[0]['id_duree'] = $_GET['id_duree'];
    }else{
        $arrFilm[0]['id_duree'] = 1;
    }
    if(isset($_GET["id_classification"])){
        $arrFilm[0]['id_classification'] = $_GET['id_classification'];
    }else{
        $arrFilm[0]['id_classification'] = 1;
    }
    //validation du nom
    if ($arrFilm[0]['titre']== "" || strlen($arrFilm[0]['titre'])>20) {
        //Si nom participant invalide...
        $strCodeErreur="-1";
        $arrMessagesErreur="*Veuillez rentrer un titre de film";
    }
}

if($etape == 2){
    $arrFilm[0]['titre'] =$_GET['titre'];
    $arrFilm[0]['id_duree'] = $_GET['id_duree'];
    $arrFilm[0]['id_classification'] = $_GET['id_classification'];
    if(isset($_GET["id_couleur_background"])){
        $arrFilm[0]['id_couleur_background'] = $_GET['id_couleur_background'];
    }else{
        $arrFilm[0]['id_couleur_background'] = 2;
    }
}
if($etape == 3){
    $arrFilm[0]['titre'] =$_GET['titre'];
    $arrFilm[0]['id_duree'] = $_GET['id_duree'];
    $arrFilm[0]['id_classification'] = $_GET['id_classification'];
    if(isset($_GET["id_couleur_background"])){
        $arrFilm[0]['id_couleur_background'] = $_GET['id_couleur_background'];
    }else{
        $arrFilm[0]['id_couleur_background'] = 2;
    }
}
if($etape == 4){
    $arrFilm[0]['titre'] =$_GET['titre'];
    $arrFilm[0]['id_duree'] = $_GET['id_duree'];
    $arrFilm[0]['id_classification'] = $_GET['id_classification'];
    if(isset($_GET["id_couleur_background"])){
        $arrFilm[0]['id_couleur_background'] = $_GET['id_couleur_background'];
    }else{
        $arrFilm[0]['id_couleur_background'] = 2;
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


//Fonction utilitaire pour l'affichage des boutons radio
function ecrireChecked($valeurRadio, $nomRadio){
    $strCocher="";
    global $arrFilm;
    if($valeurRadio == $arrFilm[0]['id_'.$nomRadio]){
        $strCocher='checked="checked"';
    }
    return $strCocher;
}

//Établissement de la chaine de requête
$strRequeteGenre =  'SELECT * FROM t_genre';

//Exécution de la 2e requête
$pdosResultat = $pdoConnexion->query($strRequeteGenre);

$arrGenre= array();
//Extraction des informations sur les sports
for($cptEnr=0;$ligne=$pdosResultat->fetch();$cptEnr++){
    $arrGenre[$cptEnr]['id_genre'] = $ligne['id_genre'];
    $arrGenre[$cptEnr]['nom'] = $ligne['nom'];
}

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
<!--    <link rel="stylesheet" href="../../../css/style.css">-->
    <!-- link icone -->
    <script src="https://kit.fontawesome.com/bb489e37eb.js" crossorigin="anonymous"></script>
</head>
<body>
<h1>Création du script</h1>
<h2><?php echo $strEnteteH2; ?></h2>
<form action="" method="get">
    <input type="hidden" name="etape" value="<?php echo $etape;?>">
    <?php if($etape == 1) { ?>
    <label for="titre">Titre :</label><br>
    <input type="text" id="titre" name="titre" value="<?php if(isset($_GET['titre'])){ echo $_GET['titre'];}?>" required>
        <span><?php echo $arrMessagesErreur; ?></span>
        <br>
    <br>
    <fieldset>
        <legend>Durée :</legend>
        <?php for($cpt=0;$cpt<count($arrDuree);$cpt++){ ?>
            <label>
                <input type="radio" name="id_duree" id="<?php echo $arrDuree[$cpt]['id_duree'];?>" value="<?php echo $arrDuree[$cpt]['id_duree'] ?>" <?php echo ecrireChecked($arrDuree[$cpt]['id_duree'], 'duree')?>>
                <?php echo $arrDuree[$cpt]['duree']; ?>
            </label>
        <?php } ?>
    </fieldset>
    <fieldset>
        <legend>Classification :</legend>
            <?php for($cpt=0;$cpt<count($arrClassification);$cpt++){ ?>
            <label style="color: <?php echo $arrClassification[$cpt]['hexadecimal'];?>">
                <input type="radio" name="id_classification" id="<?php echo $arrClassification[$cpt]['id_classification'];?>" value="<?php echo $arrClassification[$cpt]['id_classification'];?>"<?php echo ecrireChecked($arrClassification[$cpt]['id_classification'], 'classification')?>>
                <?php echo $arrClassification[$cpt]['type']; ?>
            </label>
            <?php } ?>
    </fieldset>
    <?php } ?>
    <?php if($etape == 2 ) { ?>
        <label for="titre">Franchise :</label><br>
        <input type="text" id="titre" name="titre" value="<?php if(isset($_GET['titre'])){ echo $_GET['titre'];}?>">
        <br>
        <p>Ou</p>
        <h2><a href="#"><?php echo $strH2; ?></a></h2>
        <br>
    <?php } ?>
    <?php if($etape == 3 ) { ?>
        <div>
            <label for="id_genre">Principal :</label>
            <select id="id_genre" name="id_genre">
                    <option value="0">Choisir un genre</option>
               <?php for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
                    <option value="<?php echo $arrGenre[$cpt]['nom'];?>">
                        <?php echo $arrGenre[$cpt]['nom']?></option>
                <?php } ?>
            </select>
        </div>
        <br>
        <div>
            <label for="id_genre">Sous-Genre :</label>
            <select id="id_genre" name="id_genre">
                <option value="0">Choisir un genre</option>
                <?php for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
                    <option value="<?php echo $arrGenre[$cpt]['nom'];?>">
                        <?php echo $arrGenre[$cpt]['nom']?></option>
                <?php } ?>
            </select>
        </div>
        <br>
        <div>
            <label for="id_genre">Sous-Genre :</label>
            <select id="id_genre" name="id_genre">
                <option value="0">Choisir un genre</option>
                <?php for($cpt=0;$cpt<count($arrGenre);$cpt++){ ?>
                    <option value="<?php echo $arrGenre[$cpt]['nom'];?>">
                        <?php echo $arrGenre[$cpt]['nom']?></option>
                <?php } ?>
            </select>
        </div>
        <br>
        <h2><?php echo $strH2; ?></h2>
        <br>
        <div>
            <label for="id_genre">Principal :</label>
            <select id="id_genre" name="id_genre">
                <option value="1">1</option>
            </select>
        </div>
        <div>
            <label for="id_genre">Secondaire :</label>
            <select id="id_genre" name="id_genre">
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
                    <input type="radio" name="id_couleur_background" id="<?php echo $arrBackground[$cpt]['id_couleur_background'];?>" value="<?php echo $arrBackground[$cpt]['id_couleur_background'];?>"
                        <?php echo ecrireChecked($arrBackground[$cpt]['id_couleur_background'], 'couleur_background')?>>
                    <?php echo $arrBackground[$cpt]['nom_couleur']; ?>
                </label>
            <?php } ?>
        </fieldset>
        <fieldset>
            <legend>Texte :</legend>
            <?php for($cpt=0;$cpt<count($arrTextes);$cpt++){ ?>
                <label style="color: <?php echo $arrTextes[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrTextes[$cpt]['hexadecimal'];?>">
                    <input type="radio" name="id_couleur_textes" id="<?php echo $arrTextes[$cpt]['id_couleur_textes'];?>" value="<?php echo $arrTextes[$cpt]['id_couleur_textes'];?>"
                        <?php echo ecrireChecked($arrTextes[$cpt]['id_couleur_textes'], 'couleur_textes')?>>
                    <?php echo $arrTextes[$cpt]['nom_couleur']; ?>
                </label>
            <?php } ?>
        </fieldset>
        <fieldset>
            <legend>Graphique :</legend>
            <?php for($cpt=0;$cpt<count($arrGraphique);$cpt++){ ?>
                <label style="color: <?php echo $arrGraphique[$cpt]['hexadecimal'];?>; background-color:<?php echo $arrGraphique[$cpt]['hexadecimal'];?>">
                    <input type="radio" name="id_couleur_graphique" id="<?php echo $arrGraphique[$cpt]['id_couleur_graphique'];?>" value="<?php echo $arrGraphique[$cpt]['id_couleur_graphique'];?>"
                        <?php echo ecrireChecked($arrGraphique[$cpt]['id_couleur_graphique'], 'couleur_graphique')?>>
                    <?php echo $arrGraphique[$cpt]['nom_couleur']; ?>
                </label>
            <?php } ?>
        </fieldset>
    <?php } ?>
    <?php if($etape != 1 ) { ?>
        <input type="hidden" name="titre" value="<?php if(isset($_GET['titre'])){ echo $_GET['titre'];} ?>">
        <input type="hidden" name="id_duree" value="<?php if(isset($_GET['id_duree'])){ echo $_GET['id_duree'];}?>">
        <input type="hidden" name="id_classification" value="<?php if(isset($_GET['id_classification'])){ echo $_GET['id_classification'];}?>">
    <?php } ?>
    <?php if($etape != 4 ) { ?>
        <input type="hidden" name="id_couleur_background" value="<?php if(isset($_GET['id_couleur_background'])){ echo $_GET['id_couleur_background'];}else{ echo 2; }?>">
        <input type="hidden" name="id_couleur_background" value="<?php if(isset($_GET['id_couleur_background'])){ echo $_GET['id_couleur_background'];}else{ echo 2; }?>">
    <?php } ?>
    <br>
    <?php if($etape == 1) { ?>
        <input type="submit" name="suivant" value="Suivant">
    <?php } ?>
    <?php if($etape !== 4 && $etape !== 1) { ?>
    <input type="submit" name="precedent" value="Précédent">
    <input type="submit" name="suivant" value="Suivant">
    <?php } ?>
    <?php if($etape == 4) { ?>
        <input type="submit" name="precedent" value="Précédent">
    <?php } ?>
</form>


<section class="affiche">
    <div class="affiche__background">
        <p>Future Nomination</p>
        <div class="affiche__ligne"></div>
        <p><?php if(isset($_GET['titre'])){ echo $_GET['titre'];} else { echo 'Titre du film'; }?></p>
        <p style="color: <?php echo $arrClassificationWhere[0]['hexadecimal'];?>"><?php echo $arrClassificationWhere[0]['type']?></p>
    </div>
        <table>
            <?php if($strCodeOperation!="nouveau") { ?>
            <tr>
                <th align="right">Titre :</th>
                <td align="left"><?php if(isset($_GET['titre'])){ echo $_GET['titre'];} ?></td>
            </tr>
            <tr>
                <th align="right">Durée :</th>
                <td align="left"><?php echo $arrDureeWhere[0]['duree']; ?></td>
            </tr>
            <tr>
                <th align="right">Classification :</th>
                <td style="color: <?php echo $arrClassificationWhere[0]['hexadecimal'];?>" align="left"><?php echo $arrClassificationWhere[0]['type']; ?></td>
            </tr>
            <?php if($etape == 3) { ?>
                    <tr>
                        <th align="right">Franchise :</th>
                        <td align="left"><?php if(isset($_GET['id_duree'])){ echo $_GET['id_duree'];} ?></td>
                    </tr>
                <?php } ?>
        <?php } ?>
    </table>
</section>
    <br>
<section>
    <a href="../../index.php">Annuler</a>
    <form action="" method="get">
        <?php if($etape != 4) { ?>
        <input type="submit" name="terminez_script" value="Terminez le script" disabled>
        <?php } ?>

        <?php if($etape == 4) { ?>
            <input type="submit" name="terminez_script" value="Terminez le script">
        <?php } ?>
    </form>
</section>
</body>
</html>
