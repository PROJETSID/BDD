<?php
echo 'TEST_INSERT_LIGNE'; 

include("db/connect.php");
$requete_ligne =  "INSERT INTO \"21400692\".LIGNE(numeroL, tempsLignel,nbindicerougel, nbIndiceBlancL, idpartie,idjoueur) VALUES (1,sysdate,0,0,15,111)";



echo $requete_insertion_ligne;



//Envoi de la requête
$sql = oci_parse($dbConn, $requete_ligne);

if (!oci_execute($sql) ){
    $err = oci_error($sql);
  //Affichage du message d'erreur dans une fenêtre alert
 
 	echo $err['message'];
 }else{
    echo "Ca marche !"; 
 };

?>