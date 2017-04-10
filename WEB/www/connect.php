<?php 
/*initialisation des paramètres de connexion*/
$dbHost = "ntelline.cict.fr";
$dbHostPort="1522";
$dbServiceName = "etupre";
$usr = "21605127";
$pswd = "320323";
/*création de la chaîne de caractère contenant les commandes de connexion*/
$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
        (HOST=".$dbHost.")(PORT=".$dbHostPort."))
        (CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";
/*vérification si il y a des erreurs à la connexion*/
if(!$dbConn = oci_connect($usr,$pswd,$dbConnStr)){
  $err = oci_error();
  trigger_error('Could not establish a connection: ' . $err['message'], E_USER_ERROR);
}

?>
