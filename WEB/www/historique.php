<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Historique</title>
        <link rel="stylesheet" href="style.css" />
		 <?php

		 //Connexion à la base
include("db/connect.php");
		 session_start(); 


			$pseudo = $_SESSION['pseudo_connex'];
		    include("head.php");
		    

			    // On stocke toute les parties que le joueur a joué
			$requete_select_histo = "SELECT idpartie FROM \"21400692\".JOUER
			WHERE idjoueur = (Select idjoueur from \"21400692\".JOUEUR where pseudoj = '$pseudo')";

			$req_histo = oci_parse($dbConn,$requete_select_histo);


		?>
    	<div id="mettre_au_milieu_de_la_page">
	<p> Veuillez choisir une partie dans la liste suivante : </p></br>
	</div>
	<div id="mettre_au_milieu_de_la_page">
	   <form method="post" action="RejouerPartie.php">
	
        <?php

        if(!oci_execute($req_histo))
        {
            echo oci_error($req_histo);
        }

        echo "<select id='partie' name='partie' size='1'>";

        echo "<option value='choisir un partie' id='to_hide'> Choisir une partie </option>";

        while (oci_fetch($req_histo))
        {
        echo "<option  value=" . oci_result($req_histo,1) . ">" . oci_result($req_histo,1) . "</option>";
        }

        echo "</select>";
        
        ?>

        	 <input type='submit' value="Rejouer" />
	</form>
	</div>

    </head>
    <body>
    </body>

</html>
