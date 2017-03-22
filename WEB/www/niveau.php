<!-- Grille niveau -->

<!--
session_start(); // A integrer afin d'avoir accès aux variables de sessions

?>
-->

<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Authentification</title>
        <link rel="stylesheet" href="style.css" />
		 <?php
		    include("head.php");

		    //Connexion à la base
			include("db/connect.php");
		?>


    </head>


    <body>


        <div id="mettre_au_milieu_de_la_page">
			<div id="grille_des_niveaux">
			Selectionnez un niveau <?php echo $_SESSION['pseudo_connex']; ?>: 
		<table id = "table_niveau">
			<?php

				$nbrow = 5 ;
				$nbemp = 10;
				$a = 0;
				for ($ii = 1 ; $ii <=$nbrow ; $ii++)


				{
					echo "<tr>";			
					for ($i = 1; $i <= $nbemp;$i++){
						$a = $a+1;
						echo "<td><a href=\"jeu.php\", class=\"button_niveau\" id=\"".$a."\">".$a."</a></td>";
					}	
				echo "</tr>";	
								
				}


?> 
</table>

</div>
        </div>

		
    </body>

</html>


