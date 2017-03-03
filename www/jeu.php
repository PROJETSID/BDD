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

    <body onload="initialisations();">
    

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
					<!-- emp : emplacements -->
						<table>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="emp1">e1</a></td>
								<td><a href="#", class="button" id="emp2">e2</a></td>
								<td><a href="#", class="button" id="emp3">e3</a></td>
								<td><a href="#", class="button" id="emp4">e4</a></td>
								<td><a href="#", class="button" id="emp5">e5</a></td>
								<td><a href="#", class="button" id="emp6">e6</a></td>
								<td><a href="#", class="button" id="emp7">e7</a></td>
								<td><a href="#", class="button" id="emp8">e8</a></td>
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

						<table>
							<tr>
								<td><a href="#", class="button" id="bille1">b1</a></td>
								<td><a href="#", class="button" id="bille2">b2</a></td>
								<td><a href="#", class="button" id="bille3">b3</a></td>
								<td><a href="#", class="button" id="bille4">b4</a></td>
							</tr>
							<tr>
								
								<td><a href="#", class="button" id="bille5">b5</a></td>
								<td><a href="#", class="button" id="bille6">b6</a></td>
								<td><a href="#", class="button" id="bille7">b7</a></td>
								<td><a href="#", class="button" id="bille8">b8</a></td>
							</tr>
							<tr>
								
								<td><a href="#", class="button" id="bille9">b9</a></td>
								<td><a href="#", class="button" id="bille10">b10</a></td>
								<td><a href="#", class="button" id="bille11">b11</a></td>
								<td><a href="#", class="button" id="bille12">b12</a></td>
							</tr>
							<tr>
								<td><a href="#", class="button" id="bille13">b13</a></td>
								<td><a href="#", class="button" id="bille14">b14</a></td>
								<td><a href="#", class="button" id="bille15">b15</a></td>
								<td><a href="#", class="button" id="bille16">b16</a></td>
							</tr>
							<tr>
								
							</tr>
						</table>
					</div>
				</div>

			</div>

		</div>

<script>

/*les billes sont représentées par les cases d'un tableau avec une backgrounColor correspondant à la couleur de la bille
pour la suite lorsqu'on parlera de case ce sera pour désigner la bille correspondante*/

function initialisations() {

	/*on définit la taille du tableau a initialiser*/
	const NB_LIGNES = 1;
	const NB_CASES_PAR_LIGNE = 5;
	const NB_CASES = NB_LIGNES * NB_CASES_PAR_LIGNE

	/*on définit le nombre de billes*/
	const NB_BILLES = 4;

	/*variables temporaires*/
	var nom_case = "";
	var nom_emp = "";/*emp : emplacement*/

	/*on initialise les billes à placer*/
	for (var i = 1; i < NB_CASES; i++) {
		/*on calcule l'id de la case*/
		nom_case = "bille" + i;
		/*on récupère la case et on lui affecte une fonction*/
		var case = document.getElementById(nom_case);
		case.onclick = function () {
			/*on sauvegarde la couleur de la case*/
			//sélectionner la bonne bille !
			bille1.style.backgroundColor = "black";
		    /*couleur_bille_a_placer = bille1.style.backgroundColor;*/
		}
	}
	/*on initialise la grille de jeu*/
/*		for (var i = 1; i < NB_BILLES; i++) {
			/*on calcule l'id de l'emplacement
			nom_emp = "emp" + i;
			/*on récupère la case et on lui affecte une fonction
			var emp = document.getElementById(nom_emp);
			emp.onclick = function () {
				/*on affecte la couleur sauvegardée à la case
			    emp1.style.backgroundColor = couleur_bille_a_placer;
			}
		}*/
}

/*on appelle la fonction*/
initialisations();

</script>

		
    </body>

</html>


