<!-- Gestion de la création des utilisateurs -->


<?php


//Connexion à la base
include("db/connect.php");




//Verification du pseudo
if(isset($_POST['pseudo']))
   $pseudo = $_POST['pseudo'];
else $pseudo = "";

//Verification du mot de passe
if(isset($_POST['pass'])) 
   $pass = $_POST['pass'];
else $pass = ""; 



$sql = "BEGIN \"21400692\".INSERTION_JOUEUR(:pseudo, :pass); END;";
$stmt_id = oci_parse($dbConn, $sql);
oci_bind_by_name($stmt_id, ':pseudo', $pseudo);
oci_bind_by_name($stmt_id, ':pass', $pass);
//oci_execute($stmt_id);





if (!oci_execute($stmt_id)){

   $err = oci_error($stmt_id);

 // Affichage du message d'erreur dans une fenêtre alert
   echo"<script language=\"javascript\">";
   echo" alert(\" ".htmlentities($err['code'])." \") ;";   
   echo "history.back();";
   echo"</script>"; 
// Chercher comment récupérer le message d'erreur
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





