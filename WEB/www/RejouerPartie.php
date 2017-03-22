<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>RejouerPartie</title>
	<link rel="stylesheet" href="style.css" />
	<?php include("head.php");	?>
</head>
<!-- Partie de test pour l'affichage périodique des lignes -->
<body>
	<div id="grilleJeu">
	</div>
	<div id="mettre_au_milieu_de_la_page">
	<table id = "table_niveau">
			<?php
				$nbLigne = 10 ;
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
							else { echo "<td><img src=\"images"."/"."4.jpg\" width=\"40\"/></td>"; }
					/*echo"<script language=\"javascript\">";
						echo "setTimeout(\" "<td><img src=\"images"."/"."2.jpg\" width=\"40\"/></td>\".",1000);
						echo"</script>"; 
							//$dt= new DateTime("now");*/
					}

						//sleep(1);
				echo "</tr>";	
								
				}


			?> 
	</table>
	</div>
<!-- Ce qu'il faut faire normalement-->
<script type="text/javascript">
	<?php
	/*
	include("rejouer.php");
	$tab=array();
	$Billes=oci_parse($dbConn,'exec(\"21400692\".RejouerLigne(Pidpartie))');
	oci_execute($Billes);
	var k=0;
	While ($row=oci_fetch_array($billes,OCI_NUM)) !=false){
		k++;
		$tab[k]=$row;
		}
	document.write("<tr>")
	$date=DateTime.now();
	for (i=0;i<k;i++){
	if(date+5==DateTime.now()){
		document.write("<td>$tab["+i+"]</td>")
		if(i%4==0 && i<k){document.write("</tr><tr>")}
		elseif(i==k){ document.write("</tr>")}
		}
	}*/
	?>
	</script>
</body>
</html>
