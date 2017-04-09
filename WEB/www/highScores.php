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
    <body>

        <div id="mettre_au_milieu_de_la_page">
            <div id="high_scores">
                <!-- menu choix : jour/semaine/tous -->
                <nav id="menu_choix_hs">
                    <a href="http://localhost/mastermind/www/highscoreJour.php" class="button" id="hs_jour">Jour</a>
                    <a href="http://localhost/mastermind/www/highscoresemaine.php" class="button" id="hs_semaine" href="">Semaine</a>
                    <a href="http://localhost/mastermind/www/highscoretous.php" class="button" id="hs_tous" href="">Tous</a>
                </nav>
                <!-- tableaux qui affichent les meilleurs joueurs (plus haut score) -->
                <div id="tableau_classement_joueurs">
			   <script language="javascript" type="text/javascript">
				/*var b1 = document.getElementById("hs_jour");
				var b2 = document.getElementById("hs_semaine");
				var b3 = document.getElementById("hs_tous");
				var couleurInitiale = getComputedStyle(r).backgroundColor;
				<?php
				$tab=array();
				$reqJ="exec(viewjour)";
				$reqS="exec(viewSemaine)";
				$reqT="exec(viewTous)";
				$tab=tab_score($reqJ);	
				?>
				b1.onclick = function() {
				document.getElementById('tableau_classement_joueurs').style.backgroundColor='red';
 			 	//r.style.backgroundColor= 'red';
					}
				b2.onclick = function() {
				r.style.backgroundColor='yellow';
					}
				b3.onclick = function() {
				r.style.backgroundColor=couleurInitiale;
					}*/
			</script>
                </div>
            </div>
        </div>
		
    </body>

</html>

