<?php
ini_set('display_errors', 1);

// Verifier si l'exécution se fait sur le serveur de développement (local) ou celui de la production:
if (stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168')) {
    $blnLocal = TRUE;
} else {
    $blnLocal = FALSE;
}

// Selon l'environnement d'exécution (développement ou production)
if ($blnLocal) {
    $strHost = 'localhost';
    $strBD='23_blockbuster';
    $strUser = '23_blockbuster';
    $strPassword= 'uql2117';
    error_reporting(E_ALL);
} else {
    $strHost = 'timunix2.cegep-ste-foy.qc.ca';
    $strBD='prgm1_course';
    $strUser = 'courseTim';
    $strPassword = 'c0urset1m';
    error_reporting(E_ALL & ~E_NOTICE);
}

//Data Source Name pour l'objet PDO
$strDsn = 'mysql:dbname='.$strBD.';host='.$strHost;
$pdoConnexion = new PDO('mysql:host=localhost;dbname=23_blockbuster', '23_blockbuster', 'uql2117');
//Tentative de connexion
//$pdoConnexion = new PDO($strDsn, $strUser, $strPassword);
//Changement d'encodage de l'ensemble des caractères pour UTF-8
$pdoConnexion->exec("SET CHARACTER SET utf8");
//Pour obtenir des rapports d'erreurs et d'exception avec errorInfo()
$pdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

?>