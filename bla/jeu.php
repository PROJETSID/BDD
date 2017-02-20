<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Jeu</title>
        <link rel="stylesheet" href="style.css" />
		<?php
		    include("head.php");
		?>
    </head>

    <body>
    
		<div id="mettre_au_milieu_de_la_page">
			<div id="grille_des_niveaux">
				
			</div>
			<div id="espace_de_jeu">
			<!-- (colonne de gauche) -->
			<!-- la combinaison à trouver et la grille de jeu -->
				<div id="grille_de_jeu_et_combinaison">
					<div id="combinaison_à_trouver">
					
					</div>
					<div id="grille_de_jeu">
					
					</div>

				</div>
				<!-- (colonne de droite) -->
				<!-- le timer, le score et la réserve de billes à placer (colonne de droite) -->
				<div id="fonctionnalités">
					<div id="timer">
						
					</div>
					<div id="score_joueur">
						
					</div>
					<div id="bille_à_placer">

					</div>
				</div>

			</div>

		</div>
		
    </body>

</html>
