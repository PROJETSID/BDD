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


// Requete d'insertion de la ligne
$requete_ligne =  "INSERT INTO \"21400692\".LIGNE(numeroL, tempsLignel,nbindicerougel, nbIndiceBlancL, idpartie,idjoueur) VALUES ($numeroL,sysdate,$nbIndiceRougeL,$nbIndiceBlancL,13,111)";



echo $requete_ligne;



//Envoi de la requête
// $req_l = oci_parse($dbConn, $requete_ligne);

// if (!oci_execute($req_l) ){
//     $err = oci_error($req_l);
//   //Affichage du message d'erreur dans une fenêtre alert
//   	 echo $err['message'];
//  }else{
//     echo "Ca marche !"; 
//  };

// 

?>