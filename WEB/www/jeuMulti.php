<!DOCTYPE html>



<!-- CODE PHP -->
<?php
		    //Connexion à la base
			include("db/connect.php");


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


    <!-- BODY -->

    <body onload="initialisations();">
   


<br>
		<div id="mettre_au_milieu_de_la_page">
			<div id="menu_choix_hs">
                    		<a id="hs_jour" href="">Joueur1 : Pseudo J1</a>
                    		<a id="hs_semaine" href="">    </a>
                    		<a id="hs_tous" href="">Joueur2 : Pseudo J2</a>
                	</div></br></br></br>
		</div>
		<div id="mettre_au_milieu_de_la_page">
			
			<div id="mettre">
			<!-- (colonne de gauche) -->
			<!-- la combinaison à trouver et la grille de jeu -->
				<div id="mettre">
					
					<div id="mettre">
					
					<!-- emp : emplacements -->

					<!--Code permettant de créer une grille en fonction du nombre de lignes et du nombre de
					colonnes indiquées -->
						<table id = "mettre">

						<?php

						$nbrow = 1 ;
						for ($ii = 1 ; $ii <=$nbrow ; $ii++)

						{
							echo "<tr id = \"ligne".$ii."\">";

							$nbemp = 4;
							for ($i = 1; $i <= $nbemp;$i++){
								echo "<td id = $ii ><a href=\"javascript:void(0)\", style = \"background-color : white\" onclick =\"jouer_bille(this)\" class=\"button\" id=\"emp".$i."\">emp".$i."</a></td>";
										}	
							echo "</tr>";
							
						}
							?> 


						</table>
					</div>

					<div>
					</div>

				</div>

				<!-- (colonne de droite) -->
				<!-- le timer, le score et la réserve de billes à placer (colonne de droite) -->

				<div id="fonctionnalités">
					
					<div id = "couleur_selectionnée" style = " width:30px; height:30px;border : solid">
					Bille
					</div>

					<!--Liste des billes de la collection -->
					<div id="bille_à_placer">

					<td><button onclick="insererLigne_Fin();test_combi()" action = "insert_prop.php">Jouer</button></td>

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


// Test de la combinaison
function test_combi(){

	// sauvegarde de la date
	//var date = date();

	//var cell, ligne;
    // on récupère l'identifiant (id) de la table qui sera modifiée
    var tableau = document.getElementById("table_grille");
    // nombre de lignes dans la table (avant ajout de la ligne)
    var nbLignes = tableau.rows.length-1;
    //alert (nbLignes);
    // Accès à la couleur d'un élément de la dernière ligne
    var idligne = "ligne" + nbLignes;
    var ligne_jeu = document.getElementById(idligne).childNodes;

	// Vecteurs pour stocker les couleurs et accessoirement, les positions
    var coool = [];
	// Récupérer les différentes couleurs
    	for (i = 0; i< ligne_jeu.length;i++){
    		var cell1 = ligne_jeu[i].childNodes;
    		coool.push(cell1[0].style.backgroundColor);
    };
    alert(coool);


// Initialisation d'une combinaison au hasard

	var combi = ["yellow","crimson","darkgray","blue"];

	var compteurblanc = 0; 
	var compteurrouge =0;


    // Test pour les billes rouges
    // fonction includes permet de savoir si la bille est dans la combinaison
    for (i=0;i<coool.length;i++){
    	if (combi.includes(coool[i])){
    		    	if (combi[i] == coool[i]){
    		compteurrouge++ ; 
    	} else {
			compteurblanc++ ; 
    	}
    	} 
    };


    alert('Billes rouges : '+compteurrouge + ' '+ compteurblanc + 'billes blanches');

    if(compteurrouge == tableau.rows[0].cells.length){
    	alert('Vous avez trouvé la combinaison');
    };

  
};


// Inserer une ligne à la fin du tableau
function insererLigne_Fin(){

    var cell, ligne;

    // on récupère l'identifiant (id) de la table qui sera modifiée
    var tableau = document.getElementById("table_grille");
    // nombre de lignes dans la table (avant ajout de la ligne)
    var nbLignes = tableau.rows.length;
 

	//Ajout de la ligne à la fin de la table
    ligne = tableau.insertRow(-1); // création d'une ligne pour ajout en fin de table
                                   // le paramètre est dans ce cas (-1)
 
 	ligne.setAttribute('id','ligne'+(nbLignes+1));
    // création et insertion des cellules dans la nouvelle ligne créée

    for (i = 0;i< tableau.rows[0].cells.length;i++){
    	cell = ligne.insertCell(i);
    	cell.setAttribute('id',nbLignes+1);
		var caseA = document.createElement('a');
 		caseA.setAttribute('class','button');
 		caseA.setAttribute('href','javascript:void(0)');
 		caseA.setAttribute('onclick','jouer_bille(this)');
 		caseA.setAttribute('id','bille'+i); 
 		cell.appendChild(caseA);
 		caseA.innerHTML = "emp" + (i+1);
	
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

	    // on récupère l'identifiant (id) de la table qui sera modifiée
    var tableau = document.getElementById("table_grille");
    // nombre de lignes dans la table (avant ajout de la ligne)
    var nbLignes = tableau.rows.length;



	// Si on a pas selectionné de couleur
	if (cellule.style.backgroundColor == 'white'){
		alert('Veuillez sélectionner une couleur ! ');
	}
	// Si on clique sur une mauvaise ligne
	else if (numligne != nbLignes)
	{
		alert('Merci de cliquer sur la bonne ligne ! ');
	}
	else {

	elmt.style.backgroundColor =  cellule.style.backgroundColor;
	cellule.style.backgroundColor = 'white' ; 
	}

}



function initialisations() {


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


		
	}
	</br></br>
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
	</br></br>
};


/*on appelle la fonction*/
initialisations();


</script>

		
    </body>

</html>



