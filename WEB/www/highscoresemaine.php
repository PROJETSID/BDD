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
	#tableau2
	{
		flex: 5;
		margin-top: 20px;
		background-color: blue
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
                <div id="tableau2">
			   <p>les high scores du la semaine</p>
                </div>
            </div>
        </div>
		
    </body>

</html>

