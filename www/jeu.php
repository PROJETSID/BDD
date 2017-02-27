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
					<div>

					</div>
						<table>
							<tr>
								<td>a</td>
								<td>a</td>
								<td>a</td>
								<td>a</td>
							</tr>
							<tr>
								<td>q</td>
								<td>s</td>
								<td>d</td>
								<td>f</td>
							</tr>
							<tr>
								<td>h</td>
								<td>u</td>
								<td>d</td>
								<td>j</td>
							</tr>
							<tr>
								<td>q</td>
								<td>s</td>
								<td>d</td>
								<td>f</td>
							</tr>
							<tr>
								<td>h</td>
								<td>u</td>
								<td>d</td>
								<td>j</td>
							</tr>
							<tr>
								<td>q</td>
								<td>s</td>
								<td>d</td>
								<td>f</td>
							</tr>
							<tr>
								<td>h</td>
								<td>u</td>
								<td>d</td>
								<td>j</td>
							</tr>
							<tr>
								<td>q</td>
								<td>s</td>
								<td>d</td>
								<td>f</td>
							</tr>
							<tr>
								<td>h</td>
								<td>u</td>
								<td>d</td>
								<td>j</td>
							</tr>
							<tr>
								<td>q</td>
								<td>s</td>
								<td>d</td>
								<td>f</td>
							</tr>
							<tr>
								<td>h</td>
								<td>u</td>
								<td>d</td>
								<td>j</td>
							</tr>
						</table>
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
						<a href="#", class="button" id="bille1"> Bouton 1</a>
						<p>blaazdzadz</p>

						<table>
							<tr>
								<td id="bille1" >a</td>
								<td id="bille2" >a</td>
								<td id="bille3" >a</td>
							</tr>
							<tr>
								<td id="bille4" >a</td>
								<td id="bille5" >a</td>
								<td id="bille6" >a</td>
							</tr>
							<tr>
								<td id="bille7" >a</td>
								<td id="bille8" >a</td>
								<td id="bille9" >a</td>
							</tr>
							<tr>
								<td id="bille10" >a</td>
								<td id="bille11" >a</td>
								<td id="bille12" >a</td>
							</tr>
							<tr>
								<td id="bille13" >a</td>
								<td id="bille14" >a</td>
								<td id="bille15" >a</td>
							</tr>
							</table>
					</div>
				</div>

			</div>

		</div>


<p>This example uses the HTML DOM to assign an "onclick" event to a p element.</p>

<p id="bille1">Click me.</p>






<script>
/*	var bille1 = document.getElementById("bille1");*/
	var bille2 = document.getElementById("bille2");
	var bille3 = document.getElementById("bille3");
	var bille4 = document.getElementById("bille4");
	var bille5 = document.getElementById("bille5");
	var bille6 = document.getElementById("bille6");
	var bille7 = document.getElementById("bille7");
	var bille8 = document.getElementById("bille8");
	var bille9 = document.getElementById("bille9");
	var bille10 = document.getElementById("bille10");
	var bille11 = document.getElementById("bille11");
	var bille12 = document.getElementById("bille12");
	var bille13 = document.getElementById("bille13");
	var bille14 = document.getElementById("bille14");
	var bille15 = document.getElementById("bille15");



/*	bille1.onClick = function() {
		on passe de snake_case dans le CSS a camelCase dans le JavaScript
		r.style.backgroundColor = 'black';
		write("bla");
		/*r.style.visibility = 'hiden';
	}*/



document.getElementById("bille1").onclick = function() {myFunction()};

function myFunction() {
    r.style.backgroundColor = 'black';
}

</script>

		
    </body>

</html>
