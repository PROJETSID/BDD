<!DOCTYPE html>


<?php

// Variable nombre d'emplacement pour un niveau
$Requete_nb_emp = "SELECT nbemblacementsN 
					FROM Niveau 
					WHERE IdNiveau = $niveau ";

// Variable nb billes collection
$Requete_nb_billes_colles = "SELECT nbBillesCol 
								FROM Collection 
								WHERE IdCollection = (SELECT IdCollection FROM Niveau WHERE IdNiveau = $niveau)";

?>


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
    

    		 <?php
		    include("niveau.php");
		?>


<br>
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

					<!--Code permettant de créer une grille en fonction du nombre de lignes et du nombre de
					colonnes indiquées -->
						<table id = "table_grille">

						<?php

						$nbrow = 10 ;
						for ($ii = 1 ; $ii <=$nbrow ; $ii++)

						{
							echo "<tr >";	

							$nbemp = 4;
							for ($i = 1; $i <= $nbemp;$i++){
								echo "<td id = $ii ><a href=\"javascript:void(0)\", style = \"background-color : white\" onclick =\"jouer_bille(this)\" class=\"button\" id=\"emp".$i."\">emp".$i."</a></td>";
										}	
							echo "</tr>";
							
						}
							?> 


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

					<div id = "couleur_selectionnée" style = " width:30px; height:30px;border : solid">
					Bille
					</div>

					<!--Liste des billes de la collection -->
					<div id="bille_à_placer">

					<td><button onclick="insererLigne_Fin()">Try it</button></td>

						<table id="testAppendChild">
						<?php

						$nbrow = 1 ;
						for ($ii = 1 ; $ii <=$nbrow ; $ii++)
						{
							echo "<tr>";	
							$nb_billes_collections = 6;
							for ($i = 1; $i <= $nb_billes_collections;$i++){
								echo "<td><a href=\"javascript:void(0)\", onclick=\"select_bille(this)\" class=\"button\" id=\"bille".$i."\">b".$i."</a></td>";
										}	
							echo "</tr>";	
						}
							?> 
							<tr>	
							</tr>
						</table>
					</div>
				</div>

			</div>

		</div>

<script>



function insererLigne_Fin(){

    var cell, ligne;

    // on récupère l'identifiant (id) de la table qui sera modifiée
    var tableau = document.getElementById("table_grille");
    // nombre de lignes dans la table (avant ajout de la ligne)
    var nbLignes = tableau.rows.length;
 
    ligne = tableau.insertRow(-1); // création d'une ligne pour ajout en fin de table
                                   // le paramètre est dans ce cas (-1)
 
    // création et insertion des cellules dans la nouvelle ligne créée


    for (i = 0;i< tableau.rows[0].cells.length;i++){
    	cell = ligne.insertCell(i);
		cell.innerHTML = "emp" + (i+1);
		// Problème de balise
    }

 
};



// Transfert du background de la bille selectionnée
function select_bille(elmt){
	var cellule = document.getElementById("couleur_selectionnée");
	cellule.style.backgroundColor =  elmt.style.backgroundColor  ;
};


// Transfert à la case selectionnée 
function jouer_bille(elmt){
	var cellule = document.getElementById("couleur_selectionnée");

	// Numéro de la ligne 
	// Réfléchir pour que le numero de ligne change au fur et à mesure que l'on clique sur Try It
	var idname = elmt.parentNode;
	var numligne = idname.getAttribute('id');

	// Si on a pas selectionné de couleur
	if (cellule.style.backgroundColor == 'white'){
		alert('Veuillez sélectionner une couleur ! ');
	}
	// Si on clique sur une mauvaise ligne
	else if (numligne > 1)
	{
		alert('Merci de cliquer sur la bonne ligne ! ');
	}
	else {

	elmt.style.backgroundColor =  cellule.style.backgroundColor;
	cellule.style.backgroundColor = 'white' ; 
	}

}


// // Code ci-dessous marche mais n'affiche pas le texte

// function nouvelleLigne() {
	
// 	// Recuperation de l'élément contenant la grille
// 	var v_grille = document.getElementById("table_grille");

// 	//Création d'une nouvelle ligne
// 	var v_nouvelle_ligne = document.createElement('tr');

// 	//Ajout de la ligne au tableau
// 	v_grille.appendChild(v_nouvelle_ligne);

// 	//Création d'une nouvelle case
// 	for (i=1;i <= 4;i++){

// 		var v_nouvelle_case = document.createElement('td');
// 		v_nouvelle_ligne.appendChild(v_nouvelle_case);

// 		var v_nouveau_a = document.createElement('a');
// 		v_nouvelle_a.setAttribute('class','button');
// 		v_nouvelle_a.setAttribute('href','#');
		

// 		v_nouvelle_case.appendChild(v_nouveau_a);

// 		var text = document.createTextNode('Teest');
// 		v_nouvelle_case.style.backgroundColor = "red";
// 		v_nouvelle_a.appendChild(text);
		
		
// 	}

	

// };

/*les billes sont représentées par les cases d'un tableau avec une backgrounColor correspondant à la couleur de la bille
pour la suite lorsqu'on parlera de case ce sera pour désigner la bille correspondante*/

function initialisations() {

	/*on définit la taille du tableau a initialiser*/
	// const NB_LIGNES = 1;
	// const NB_CASES_PAR_LIGNE = 5;
	// const NB_CASES = NB_LIGNES * NB_CASES_PAR_LIGNE

	// on définit le nombre de billes
	// const NB_BILLES = 4;

	// /*variables temporaires*/
	 var nom_case = "";
	// var nom_emp = "";/*emp : emplacement*/

	// Liste de couleurs 
	var couleur = ["","yellow","crimson","darkgray","blue","deeppink","green","lightseagreen","lightsalmon","mediumaquamarine"]; 


	// On suppose que l'on propose 6 billes à joueur
	var nb_billes_collections = 6; 

	/*Couleurs pour le niveau */
	for (var i = 1; i <= nb_billes_collections; i++) {

		/*on calcule l'id de la case*/
		nom_case = "bille" + i;
		/*on récupère la case et on lui affecte une fonction*/
		var bille = document.getElementById(nom_case);
		bille.style.backgroundColor = couleur[i];


			/*on sauvegarde la couleur de la case*/
			//sélectionner la bonne bille !

			/*plutôt gérer avec des images*/
			/*bille1.style.backgroundImage = "black"; ?*/

			//bille2.style.backgroundColor = "pink";
			//bille3.style.backgroundColor = "blue";
		    //couleur_bille_a_placer = bille2.style.backgroundColor;
		
	}




	/*on initialise la grille de jeu*/
	for (var i = 1; i < NB_BILLES; i++) {
		/*on calcule l'id de l'emplacement*/
		nom_emp = "emp" + i;
		/*on récupère la case et on lui affecte une fonction*/
		var emplacement = document.getElementById(nom_emp);
		emplacement.onclick = function () {
			/*on affecte la couleur sauvegardée à la case*/
			emp1.style.backgroundColor = couleur_bille_a_placer;
		}
	}
};

/*on appelle la fonction*/
initialisations();


</script>

		
    </body>

</html>




