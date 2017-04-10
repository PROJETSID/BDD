<!-- Fichier php gérant l'insertion des lignes-->
<?php

include("db/connect.php");

// Déclaration des variables en PHP
$nbBilles = $_POST['nbBilles'];
$positionBilleLigne = $_POST['positionBilleLigne'];
$idbilles = $_POST['idbilles']; 
$idPartie = $_POST['idPartie']; 



// Selection de la ligne maximale pour la partie : afin de recuperer le bon id ligne
$requete_select_idligne = "SELECT MAX(idligneL) AS IDLIGNE FROM \"21400692\".ligne WHERE IDPARTIE = $idPartie ";

$req_idligne = oci_parse($dbConn,$requete_select_idligne);
	 if(!oci_execute($req_idligne)){
	      echo oci_error($req_nb_billes)['MESSAGE'];
	      echo 'Marche pas'; 
	     }else{
		echo 'ça marche !';

//Stockage de la dernière ligne insérée pour la partie
		while(oci_fetch($req_idligne)){
		$idligne = oci_result($req_idligne, 'IDLIGNE'); }

	     };





// Requête d'insertion de la proposition du joueur
for ($i = 0;$i<$nbBilles;$i++){


// On récupère l'id de chaque bille
$requete_url_bille = "SELECT IDBILLE FROM \"21400692\".Bille WHERE urlB = '$idbilles[$i]'";
$req_urlbille = oci_parse($dbConn,$requete_url_bille);
	 if(!oci_execute($req_urlbille)){
	      //echo oci_error($req_urlbille)['MESSAGE'];
	      echo 'Marche pas'; 
	     }else{
		echo 'ça marche !         ';
	     };

//Stockage de la dernière ligne insérée pour la partie
while(oci_fetch($req_urlbille)){
$idbille = oci_result($req_urlbille, 'IDBILLE');};



// Requete d'insertion de la ligne
$requete_insertion_proposition =  "INSERT INTO \"21400692\".PROPOSITION_JOUEUR VALUES ($positionBilleLigne[$i], 
$idligne , $idbille) ";

echo $requete_insertion_proposition;

//Envoi de la requête
$sql = oci_parse($dbConn, $requete_insertion_proposition);

 if (! oci_execute($sql) ){
   
   $err = oci_error($sql);
  //Affichage du message d'erreur dans une fenêtre alert
   echo"<script language=\"javascript\">";
    echo" alert(\" ".htmlentities($err['message'])." \") ;";
    echo"</script>";
 }else{
echo 'ça marche';
 }

	};

?>