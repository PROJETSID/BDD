<!-- Fichier php gérant l'insertion des lignes-->
<?php

include("db/connect.php");

 // On récupère les données et on les stocks dans des variables
$numeroL= $_POST['numeroL'];
$tempsLigneL= $_POST['tempsLigneL'];
$nbIndiceRougeL= $_POST['nbIndiceRougeL'];
$nbIndiceBlancL= $_POST['nbIndiceBlancL'];
$idPartie = $_POST['idPartie'];
$joueur= $_POST['joueur'];


// INSERTION DE LA LIGNE
$req_ligne = "BEGIN \"21400692\".INSERTION_LIGNE(:numL, :nbrouge, :nbblanc, :idpartie, :idjoueur);END;";
$stmt = oci_parse($dbConn, $req_ligne);
oci_bind_by_name($stmt, ':numL', $numeroL);
oci_bind_by_name($stmt, ':nbrouge', $nbIndiceRougeL);
oci_bind_by_name($stmt, ':nbblanc', $nbIndiceBlancL);
oci_bind_by_name($stmt, ':idpartie', $idPartie);
oci_bind_by_name($stmt, ':idjoueur', $joueur);
	 if(!oci_execute($stmt)){
	    echo oci_error($stmt)['message'];
	      echo 'Marche pas'; 
	     }else{
		echo 'ça marche !';
};




/*
//Envoi de la requête
 $req_l = oci_parse($dbConn, $requete_ligne);

 if (!oci_execute($req_l) ){
     $err = oci_error($req_l);
  //Affichage du message d'erreur dans une fenêtre alert
   	 echo $err['message'];
  }else{
     echo "Ca marche !"; 
  };
*/
 

?>