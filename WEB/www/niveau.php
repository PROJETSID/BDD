<!-- Grille niveau -->
<div id="mettre_au_milieu_de_la_page">

<table id = "table_niveau">
<?php

		$nbrow = 5 ;
		$nbemp = 10;
		$a = 0;
	for ($ii = 1 ; $ii <=$nbrow ; $ii++)


//Ajouter une fonction javascript onclic pour choisir les bons emplacements
	{
	echo "<tr>";			
		for ($i = 1; $i <= $nbemp;$i++){
			$a = $a+1;
			echo "<td><a href=\"#\",class=\"button_niveau\" id=\"".$a."\">".$a."</a></td>";
				}	
				echo "</tr>";

							
		}
?> 
</table>
</div>

