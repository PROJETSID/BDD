<!-- Gestion des utilisateurs -->


<?php

include("db/connect.php");
// Recuperation des données

//pseudo
if(isset($_POST['pseudo']))
	$pseudo = $_POST['pseudo'];
else $pseudo = "";

//mot de passe
if(isset($_POST['pass']))
	$pass = $_POST['pass'];
else $pass = ""; 

// on écrit la requête sql
$requete_insert = "Insert into \"21400692\".Joueur(IDJOUEUR,pseudoJ,motdepasseJ) VALUES (Seq_Joueur_idJoueur.nextval,'".$pseudo."','".$pass."')";

$sql = oci_parse($dbConn, $requete_insert);
//$req = oci_execute($sql);


if ( ! oci_execute($sql) ){
	echo 'test';
$err = oci_error($sql);


   echo"<script language=\"javascript\">";
   echo" alert(\" ".htmlentities($err['message'])." \") ;";
   echo "history.back();";
   echo"</script>";

//Afficher le code de l'erreur
//echo htmlentities($err['code']);

//Affichier le message d'erreur
//echo htmlentities($err['message']);

// pouvoir recuperer les codes SQL et afficher ce que je veux

//if (!$req) {
  // $e = oci_error($sql);  // Pour les erreurs oci_parse, passez le gestionnaire de connexion
  	// trigger_error(htmlentities($e['message']), E_USER_ERROR);
  	
 }
 else{echo $requete_insert; 
echo 'Vos infos ont été ajoutées.';
echo $pseudo;
echo $pass;


}

 	// on affiche le résultat pour le visiteur

;


?>



