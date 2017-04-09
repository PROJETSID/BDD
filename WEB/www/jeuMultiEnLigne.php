<!DOCTYPE html>


<html>

    <head>

        <meta charset="utf-8" />

        <title>Jeu</title>
        <link rel="stylesheet" href="style.css" />
	<?php
            include("head.php");
            include("db/connect.php");
            session_start();

		// selectionner le niveaux accessibles
             $get_niveau = "SELECT idNiveau FROM \"21400692\".Niveau 
                        WHERE seuilExpN <= 500
                        order by idNiveau";
            $pre_get_niveau = oci_parse($dbConn,$get_niveau);
            oci_execute($pre_get_niveau);

        ?>


    </head>
	
    <body>
	
	<div id="mettre_au_milieu_de_la_page">
	<div id="high_scores">
			<div id="menu_choix_hs">
                    		<a id="hs_jour" href="">Joueur1 : Pseudo J1</a>
                    		<a id="hs_semaine" href=""> VERSUS </a>
                    		<a id="hs_tous" href="">Joueur2 : Pseudo J2</a>
                	</div></br>
			<div id="menu_choix_hs" ;>
                    		<p><i>Liste des niveaux accessibles au joueur le moins expérimenté</i></p>
                	</div></br></br></br>
		<div id="mettre_au_milieu_de_la_page">
        	<div id="grille_des_niveaux">

        
		<form method="post" action="jeu.php">

       		<label for="niveau"> Selectionnez un niveau </label><br/>

        <?php

        if(!oci_execute($pre_get_niveau))
        {
            echo oci_error($pre_get_niveau);
        }

        echo "<select id='niveau' name='niveau' size='1'>";

        echo "<option value='choisir un niveau' id='to_hide'> Choisir un niveau </option>";

        while (oci_fetch($pre_get_niveau))
        {
        echo "<option  value=" . oci_result($pre_get_niveau,1) . ">" . oci_result($pre_get_niveau,1) . "</option>";
        }

        echo "</select>";

        ?>

        	<input type='submit' value="Commencer" />

 	   	</form>


	</div>
        </div>
	
    </body>

</html>




