<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>High Scores</title>
        <link rel="stylesheet" href="style.css" />
        <?php
       		include("head.php");
		include("db/connect.php");
        ?>
    </head>
	<style>
	#tableau1
	{
		flex: 5;
		margin-top: 20px;
		background-color: yellow
	}
	</style>
    <body>

        <div id="mettre_au_milieu_de_la_page">
            <div id="high_scores">
                <!-- menu choix : jour/semaine/tous -->
                <nav id="menu_choix_hs">
                    <a href="http://localhost/mastermind/www/highscoreJour.php" class="button" id="hs_jour">Jour</a>
                    <a href="http://localhost/mastermind/www/highscoresemaine.php" class="button" id="hs_semaine">Semaine</a>
                    <a href="http://localhost/mastermind/www/highscoretous.php" class="button" id="hs_tous">Tous</a>
                </nav>
                <!-- tableaux qui affichent les meilleurs joueurs (plus haut score) -->
                <div id="tableau1">
				   <p>les high scores du jour</p>
					<?php
					/*récupération des données à afficher et gestion des erreurs*/
						$Req_score = "SELECT * FROM \"21400692\".HighscoreJour";

						$req_select = oci_parse($dbConn,$Req_score);
			 			if(!oci_execute($req_select)){
			   			   echo 'ERREUR D\'EXÉCUTION'; 
			    		}
						else{

						echo 'REQUÊTE EXÉCUTÉ AVEC SUCCÈS !';
						echo '<br>Idjoueur Score';
							while(oci_fetch($req_select))
							{
								echo '<br>';
								echo oci_result($req_select,'IDJOUEUR').'&nbsp;&nbsp;&nbsp;';
								echo oci_result($req_select,'SCOREP').'<br>'; 
							  
							};
						};
					?>
                </div>
            </div>
        </div>
		
    </body>

</html>

