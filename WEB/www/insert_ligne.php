<!-- Fichier php gérant l'insertion des lignes-->
<?php

 
 // On récupère les données et on les stocks dans des variables
$numeroL= $_POST['numeroL'];
$tempsLigneL= $_POST['tempsLigneL'];
$nbIndiceRougeL= $_POST['nbIndiceRougeL'];
$nbIndiceBlancL= $_POST['nbIndiceBlancL'];
$idPartie = $_POST['idPartie'];
$idJoueur= $_POST['idJoueur'];

//echo"<script language=\"javascript\">";
echo $numeroL, $tempsLigneL, $nbIndiceRougeL, $nbIndiceBlancL,$idPartie , $idJoueur; 
//	echo"</script>";





// Requete d'insertion de la ligne
$requete_insertion_ligne =  "INSERT INTO \"21400692\".LIGNE 
				VALUES (Seq_ligne_idligneL.nexval, $numeroL , sysdate ,  $nbIndiceRougeL , $nbIndiceBlancL, $idPartie, $idJoueur ) ";

echo $requete_insertion_ligne;
			// Il serait interessant que l'ID du joueur soit une variable de session, facilite les insertions !   

//Envoi de la requête
//$sql = oci_parse($dbConn, $requete_insertion_ligne);

// if (! oci_execute($sql) ){
   
//    $err = oci_error($sql);

//   //Affichage du message d'erreur dans une fenêtre alert
//    echo"<script language=\"javascript\">";
//    echo" alert(\" ".htmlentities($err['message'])." \") ;";
//    echo "history.back();";
//    echo"</script>";
// }



?>