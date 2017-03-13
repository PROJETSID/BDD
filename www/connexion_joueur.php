<?php

include("db/connect.php");
// Recuperation des données

//pseudo
if(isset($_POST['pseudo_connex']))
	$pseudo_connex = $_POST['pseudo_connex'];
else $pseudo_connex = "";

//mot de passe
if(isset($_POST['pass_connex']))
	$pass_connex = $_POST['pass_connex'];
else $pass_connex = ""; 

// on écrit la requête sql
// procedure de connexion de joueur php
$requete_connexion = "SELECT pseudoJ,motdepasseJ 
						FROM \"21400692\".Joueur 
						WHERE pseudoJ = '". $pseudo_connex ."' 
						AND motdepasseJ = '".$pass_connex."'; " ; 


$sql = oci_parse($dbConn, $requete_connexion);
$req = oci_execute($sql);

oci_fetch_all($sql,$res);
$a = oci_num_rows($sql);
echo $a;

//if ($nbrows < 1) {
	//echo $requete_connexion;
   // Redirection vers le fichier authentification
   //echo"<script language=\"javascript\">";
   // Boite d'alerte
   //echo" alert(\"Le pseudo ou le mot de passe est incorrect. Veuillez réessayer ! \") ;";
   //Retour à la page précédente
   //echo "history.back();";
   //echo"</script>";
	//echo 'Ca marche ! ';


  // Autre manière pour redirection : header('Location: http://localhost/mastermind/authentification.php'); 
 //} else {
 	//session_start();
 	//$_SESSION['pseudo_connex'] = $pseudo_connex;
 	//$_SESSION['pass_connex'] = $pass_connex;
 	//echo 'Bienvenue '.$_SESSION['pseudo_connex'];

   //echo"<script language=\"javascript\">";
   //echo" alert(\" Bienvenue !  \") ;";
   //echo "history.back();";
   //echo"</script>";

//echo 'On est bien !';
 	//header('location : index.php');
// };



?>

