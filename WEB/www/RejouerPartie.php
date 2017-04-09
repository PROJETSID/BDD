<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>RejouerPartie</title>
	<link rel="stylesheet" href="style.css" />
	<?php include("head.php");	
	include("db/connect.php");
	session_start();
	?>


</head>
<!-- Partie de test pour l'affichage périodique des lignes -->
<body>


<?php

$partie = $_POST['partie'];
//echo $partie;

//Selection des id_ligne de la partie 

$req_rej_idligne = "SELECT IDLIGNEL , NUMEROL 
					FROM \"21400692\".LIGNE 
					WHERE IDPARTIE = $partie 
					ORDER BY IDLIGNEL";


$req_idligne = oci_parse($dbConn,$req_rej_idligne);
	 if(!oci_execute($req_idligne)){
	     echo oci_error($req_nb_billes);
	    //  echo 'Marche pas'; 
	     }else{
		//echo 'ça marche !';
		while(oci_fetch($req_idligne)){
			//On stocke les idligne dans une liste
		$idligne[] = oci_result($req_idligne, 'IDLIGNEL'); 

		//echo $idligne; 
	     };

	     };


	?>
	<div id="grilleJeu">
	</div>
	<div id="mettre_au_milieu_de_la_page">
	<table id = "table_niveau">

	


			<?php
			for ($i = 0; $i < sizeof($idligne);$i++){
				echo "<tr>";

				//echo $i; 
				// Selection des urls pour la ligne
					$req_urlb_ligne = "SELECT URLB FROM \"21400692\".BILLE, \"21400692\".PROPOSITION_JOUEUR 
				WHERE BILLE.IDBILLE = PROPOSITION_JOUEUR.idbille 
				AND PROPOSITION_JOUEUR.idlignel = $idligne[$i]
				ORDER BY PROPOSITION_JOUEUR.POSITIONBILLELIGNE "; 

					$req_urlb = oci_parse($dbConn,$req_urlb_ligne);

					 if(!oci_execute($req_urlb)){
		     			echo oci_error($req_nb_billes);
	      				//echo 'Marche pas'; 
	     				}else{
						//echo 'ça marche !';
						while(oci_fetch($req_urlb)){
						//On stocke les idligne dans une liste
						$urlb = oci_result($req_urlb, 'URLB'); 
						echo "<td>";
						echo "<img src=\"images/$urlb\"/>";
						echo "</td>";
	     				};

	    					 };

				echo "</tr>";
				//sleep(5);
						}

			?>





			<?php
			/*	$nbLigne = 10 ;
				$nbEmpl = 8;
				$dt = new DateTime("now");
				for ($ii = 1 ; $ii <=$nbLigne ; $ii++){
					echo "<tr>";			
					for ($j = 1; $j <= $nbEmpl;$j++){
						//if ($dt+5 > new DateTime("now"))
							if ($j<5){
							echo "<td><img src=\"images"."/"."2.jpg\" width=\"40\"/></td>";
							$dt= new DateTime("now");
							}
							else { echo "<td><img src=\"images"."/"."4.jpg\" width=\"40\"/></td>"; }*/
					/*echo"<script language=\"javascript\">";
						echo "setTimeout(\" "<td><img src=\"images"."/"."2.jpg\" width=\"40\"/></td>\".",1000);
						echo"</script>"; 
							//$dt= new DateTime("now");*/
					/*}

						//sleep(1);
				echo "</tr>";	
								
				}*/


			?> 
	</table>
	</div>

</body>
</html>
