<!-- Fichier php gérant l'insertion des lignes-->
<?php
$nbBilles = $_POST['nbBilles'];
$positionBilleLigne = $_POST['positionBilleLigne'];
$idligne = $_POST['idligne'];
$idbilles = $_POST['idbilles']; 
$idPartie = $_POST['idPartie']; 


//for ($i =0; $i<$nbBilles;$i++){
//	${"positionBilleLigne" . $i} = $POST['positionBilleLigne$i']; 
//	${"idligne" . $i} = $POST['idligne$i'] ; 
	//${"idbilles" . $i} = $POST['idbilles$i']  ;

	//echo ${"positionBilleLigne" . $i} ;
	//echo ${"idligne" . $i};
	//echo ${"idbilles" . $i};



// Données à envoyer : test pour voir si ça marche

	echo "nbBilles : $VAR_NB_EMPLACEMENT, ";
	
		echo "$positionBilleLigne[0] , $idligne[2], $idbilles[3]" ;
		//if ($i <$VAR_NB_EMPLACEMENT-1){
		//	echo ", ";
		//}

//};

// Selection de la ligne maximale pour la partie : afin de recuperer le bon id ligne
$requete_select_idligne = "SELECT MAX(idligne) FROM ligne WHERE IDPARTIE = $idPartie ";



// Requête d'insertion de la proposition du joueur
for ($i = 0;$i<$nbBilles;$i++){
	// Requete d'insertion de la ligne
$requete_insertion_proposition =  "INSERT INTO \"21400692\".PROPOSITION_JOUEUR VALUES ($positionBilleLigne[$i], $idligne[$i] , $idbilles[$i]) ";

echo $requete_insertion_proposition;

//Envoi de la requête
//$sql = oci_parse($dbConn, $requete_insertion_proposition);

// if (! oci_execute($sql) ){
   
//    $err = oci_error($sql);

//   //Affichage du message d'erreur dans une fenêtre alert
//    echo"<script language=\"javascript\">";
//    echo" alert(\" ".htmlentities($err['message'])." \") ;";
//    echo"</script>";
// }

};

?>