<!-- Gestion de la connexion de joueur-->


<?php

//Connexion à la BDD
include("db/connect.php");


/*Récupération des données du joueur*/
/*Pseudo*/
if(isset($_POST['pseudo_connex']))
	$pseudo_connex = $_POST['pseudo_connex'];
else $pseudo_connex = "";

/*Mot de passe*/
if(isset($_POST['pass_connex']))
	$pass_connex = $_POST['pass_connex'];
else $pass_connex = ""; 

/*requête SQL de connexion du joueur*/
/*on récupère le joueur dans la base qui a le pseudo et le mot de passe ci-dessus (si il existe)*/
$requete_connexion = "SELECT pseudoJ
						FROM \"21400692\".Joueur 
						WHERE pseudoJ = '$pseudo_connex' 
                  AND motdepasseJ = '$pass_connex' " ; 
 
/*on affecte des valeurs aux paramètres de la requête*/
$sql = oci_parse($dbConn, $requete_connexion);



/*on vérifie que la requête s'éxécute sans erreurs, sinon on affiche un message d'erreur*/
if (! oci_execute($sql) ){
   
   $err = oci_error($sql);

  //Affichage du message d'erreur dans une fenêtre alert
   echo"<script language=\"javascript\">";
   echo" alert(\" ".htmlentities($err['message'])." \") ;";
   echo "history.back();";
   echo"</script>";
}

else { 

   // on compte le nombre de ligne retournée (c'est à dire le nombre de joueur) retourné par la requête
   $i = 0 ;
   while( oci_fetch($sql) )
      $i=$i+1;

      //si aucun joueur
      if ($i < 1) {
         // Redirection vers le fichier authentification
         echo"<script language=\"javascript\">";
         //Boite d'alerte
         echo" alert(\"Le pseudo ou le mot de passe est incorrect. Veuillez réessayer ! \") ;";
         echo "history.back();";
         echo"</script>";
                   } 

      //si un joueur
      else {
         //Creation de la session de jeu
         session_start();
         $_SESSION['pseudo_connex'] = $pseudo_connex;
         $_SESSION['pass_connex'] = $pass_connex;

         // Message de bienvenue et redirection vers la page de jeu
         echo"<script language=\"javascript\">";
         echo" alert(\" Bienvenue $pseudo_connex !  \") ;";
         echo "window.location.replace(\"http://localhost/mastermind/niveau.php\")";
         echo"</script>";
         
         };

}


?>

