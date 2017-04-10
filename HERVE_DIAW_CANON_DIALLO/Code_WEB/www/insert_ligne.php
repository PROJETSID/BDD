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


$nbBilles = $_POST['nbBilles'];
$positionBilleLigne = $_POST['positionBilleLigne'];
$idbilles = $_POST['idbilles']; 


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
	     };


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