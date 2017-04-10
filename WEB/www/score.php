<?php

include("db/connect.php");
 // On récupère les données et on les stocks dans des variables
$idPartie = 77; 
$idJoueur =  140;

$requete_score = "SELECT \"21400692\".calculscore($idJoueur,$idPartie) AS SCORE FROM dual";
$req_score = oci_parse($dbConn,$requete_score);
	 if(!oci_execute($req_score)){
	     echo oci_error($req_score)['message'];
	     }else{

		while(oci_fetch($req_score)){
			$score = oci_result($req_score, 'SCORE');
			echo $score;
	     };
	     };


$update_partie = "UPDATE \"21400692\".PARTIE SET RESULTATP = 1, SCOREP = $score WHERE IDPARTIE = $idPartie";
$req_update_partie = oci_parse($dbConn,$update_partie);
	 if(!oci_execute($req_update_partie)){
	      echo 'Marche pas'; 
	     }else{
		echo 'ça marche !';};

?>