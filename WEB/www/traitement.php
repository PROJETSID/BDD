<!-- Gestion de la création des utilisateurs -->


<?php


//Connexion à la base
include("db/connect.php");


// Recuperation des données

//Verification du pseudo
if(isset($_POST['pseudo']))
	$pseudo = $_POST['pseudo'];
else $pseudo = "";

//Verification du mot de passe
if(isset($_POST['pass'])) 
	$pass = $_POST['pass'];
else $pass = ""; 

//Requête SQL
$requete_insert = "Insert into \"21400692\".Joueur(IdJoueur,pseudoJ,motdepasseJ) 
                  VALUES (Seq_Joueur_idJoueur.nextval,'".$pseudo."','".$pass."')";

// Problème avec la séquence

                  
// Envoi et execution de la requête SQL
$sql = oci_parse($dbConn, $requete_insert);

if (!oci_execute($sql)){
$err = oci_error($sql);

  //Affichage du message d'erreur dans une fenêtre alert
   echo"<script language=\"javascript\">";
   echo" alert(\" ".htmlentities($err['message'])." \") ;";
   echo "history.back();";
   echo"</script>"; 

 }else{ 
   echo"<script language=\"javascript\">";
   echo" alert(\"Votre compte a bien été créé, vous pouvez désormais vous connecter.\") ;";
   echo "history.back();";
   echo"</script>";
};
 ?>




<!-- Afficher le code de l'erreur
echo htmlentities($err['code']);

Afficher le message d'erreur
echo htmlentities($err['message']);-->





