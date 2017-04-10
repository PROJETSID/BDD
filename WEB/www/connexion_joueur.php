<!-- Gestion de la connexion de joueur-->


<?php

//Connexion à la base
include("db/connect.php");


// Récupération des données

//Pseudo
if(isset($_POST['pseudo_connex']))
	$pseudo_connex = $_POST['pseudo_connex'];
else $pseudo_connex = "";

//Mot de passe
if(isset($_POST['pass_connex']))
	$pass_connex = $_POST['pass_connex'];
else $pass_connex = ""; 

// on écrit la requête sql
// procedure de connexion de joueur php
$requete_connexion = "SELECT pseudoJ
						FROM \"21400692\".Joueur 
						WHERE pseudoJ = '$pseudo_connex' 
                  AND motdepasseJ = '$pass_connex' " ; 
 

$sql = oci_parse($dbConn, $requete_connexion);



// Message d'erreur si la requête ne marche pas

if (! oci_execute($sql) ){
   
   $err = oci_error($sql);

  //Affichage du message d'erreur dans une fenêtre alert
   echo"<script language=\"javascript\">";
   echo" alert(\" ".htmlentities($err['message'])." \") ;";
   echo "history.back();";
   echo"</script>";
}

else { 

   // Compteur permettant de compter le nombre de ligne
   $i = 0 ;
   while( oci_fetch($sql) )
      $i=$i+1;

      if ($i < 1) {
         // Redirection vers le fichier authentification
         echo"<script language=\"javascript\">";
         //Boite d'alerte
         echo" alert(\"Le pseudo ou le mot de passe est incorrect. Veuillez réessayer ! \") ;";
         echo "history.back();";
         echo"</script>";
                   } 

      else {

         //Creation de la session de jeu
         session_start();

          $_SESSION['pseudo_connex'] = $pseudo_connex;
         //  Message de bienvenue et redirection vers la page de jeu
          echo"<script language=\"javascript\">";
          echo" alert(\" Bienvenue  $pseudo_connex !  \") ;";
          echo "window.location.replace(\"http://localhost/mastermind/typeDePartie.php\")";
          echo"</script>";

         };

}


?>

