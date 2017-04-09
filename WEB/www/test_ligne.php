<?php
echo 'TEST_UPDATE_PARTIE'; 

include("db/connect.php");

$update_partie = "UPDATE \"21400692\".PARTIE SET RESULTATP = 0 WHERE IDPARTIE = 1";
$req_update_partie = oci_parse($dbConn,$update_partie);
	 if(!oci_execute($req_update_partie)){
	     // echo oci_error($req_nb_billes);
	      echo 'Marche pas'; 
	     }else{
		echo 'ça marche !';};

?>