<?php

include("db/connect.php");
 // On récupère les données et on les stocks dans des variables
$idPartie = $_POST['idPartie']; 
$idJoueur =  $_POST['idJoueur'];

$sql = "BEGIN \"21400692\".CalculScore(:idjoueur, :idpartie); END;";
$stmt_id = oci_parse($dbConn, $sql);
oci_bind_by_name($stmt_id, ':idjoueur', $idJoueur);
oci_bind_by_name($stmt_id, ':idpartie', $idPartie);
//oci_execute($stmt_id);


$update_partie = "UPDATE \"21400692\".PARTIE SET RESULTATP = 1 WHERE IDPARTIE = $idPartie";
$req_update_partie = oci_parse($dbConn,$update_partie);
	 if(!oci_execute($req_update_partie)){
	     // echo oci_error($req_nb_billes);
	      echo 'Marche pas'; 
	     }else{
		echo 'ça marche !';};

?>