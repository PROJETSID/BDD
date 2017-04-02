<!DOCTYPE html>



<!-- CODE PHP -->
<?php 

//Connexion à la base
include("db/connect.php");


?>


<html>

    <head>

        <meta charset="utf-8" />

        <title>Jeu</title>
        <link rel="stylesheet" href="style.css" />
		<?php
		    include("head.php");
		?>

<!-- On inclut JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<!-- Script du timer -->

		<script language="javascript" type="text/javascript">

var compte = 60 ;
function decompte()
{
        if(compte <= 1) {
        pluriel = "";
        } else {
        pluriel = "s";
        }
 
    document.getElementById("timer").innerHTML = compte + " seconde" + pluriel;
 
        if(compte == 0 || compte < 0) {
        compte = 0;
 		alert('Vous avez perdu !');
        clearInterval(timer);
       // Redirection vers la page niveau
       // document.location.href = "http://localhost/mastermind/niveau.php";
        }
 
    compte--;
}
var timer = setInterval('decompte()',1000);

</script>


    </head>


    <!-- BODY -->

    <body onload="initialisations();decompte();">
   


<br>
		<div id="mettre_au_milieu_de_la_page">
			<div id="grille_des_niveaux">
				
					<div id="test">
					</div>

    		    <!--// <?php
		    //include("niveau.php");
		?>   -->

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

						$nbrow = 1 ;
						for ($ii = 1 ; $ii <=$nbrow ; $ii++)

						{
							echo "<tr id = \"ligne".$ii."\">";

							$nbemp = 4;
							for ($i = 1; $i <= $nbemp;$i++){
								echo "<td id = $ii ><a href=\"javascript:void(0)\", style = \"background-color : white\"  class=\"button\" id=\"emp".$i."\"><img src=\"\" alt=\"err1\" onclick =\"jouer_bille(this)\" /></a></td>";
										}	
							echo "</tr>";
							
						}
							?> 


						</table>
					</div>

					<div>
					</div>

				</div>

				<div id="grille_de_jeu_et_combinaison">
					<div id="combinaison_à_trouver">

					<!-- Billes rouges et blanches -->
					<br><br>
					<table id = "table_RB">

						<?php

						$nbrow = 1 ;
						for ($ii = 1 ; $ii <=$nbrow ; $ii++)

						{
							echo "<tr id = \"ligne_combi".$ii."\">";

							$nbemp = 4;
							for ($i = 1; $i <= $nbemp;$i++){
								echo "<td style = \"background-color : white; \"  class=\"button\" id=\"rb".$i."\">a".$i."</td>";
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
					<p> Temps restant avant la fin de la partie</p>
					<div id="timer">
						
					</div>

					<div id="score_joueur">
						
					</div>

					<div  style = " width:30px; height:30px;border : solid">
						<img src="" alt="err" id = "couleur_selectionnée" />
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
								echo "<td><a href=\"javascript:void(0)\", class=\"button\" id=\"bille".$i."\"><img src=\"1.jpg\" alt=\"err\" onclick=\"select_bille(this)\" /></a></td>";
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

	// Vecteurs pour stocker les couleurs et les positions
    var coool = [];
    var position = [];
	// Récupérer les différentes couleurs
    	for (i = 0; i< ligne_jeu.length;i++){
    		var cell1 = ligne_jeu[i].childNodes;
    		coool.push(cell1[0].style.backgroundColor);
    		position.push(i);
    };
    alert(coool);


// Initialisation d'une combinaison au hasard

	var combi = ["yellow","crimson","darkgray","blue"];



// Test pour la combinaison

	// pions de la bonne couleur et bien placé : pion rouge 
	// pions de la bonne couleur mais mal placé : pion blanc

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




// Coloration des billes rouges et des billes blanches
    var tRB = document.getElementById("table_RB");

      // nombre de lignes dans la table (avant ajout de la ligne)
   	var nbLignes_tRB = tRB.rows[0].length;
   	ind_RB = nbLignes-1;

    for (i=0;i<compteurrouge;i++){
    	tRB.rows[ind_RB].cells[i].style.backgroundColor = 'yellow';
  
    };
        for (i=compteurrouge;i<(compteurrouge+compteurblanc);i++){
    	tRB.rows[ind_RB].cells[i].style.backgroundColor = 'blue';

    };






var tempsL = "teeemps";
var idPartie = "IdPartie";
var idJoueur = "idJoueur";


  	// FIN DE LA PARTIE
    if(compteurrouge == tableau.rows[0].cells.length){
    	alert('Vous avez trouvé la combinaison');
    	$.post('gestion_fin_partie.php', {idPartie : idPartie,idJoueur}).done(function(data) {
    alert(data);
});
    };



// Envoi des données au fichier de traitement insert_ligne.php
$.post('insert_ligne.php', {numeroL: nbLignes,
	tempsLigneL: tempsL,
	nbIndiceRougeL: compteurrouge,
	nbIndiceBlancL: compteurblanc,
	idPartie : idPartie,
	idJoueur: idJoueur
}).done(function(data) {
    alert(data);
});



// Envoi des données au fichier de traitement insert_proposition_joueur.php
$.post('insert_proposition_joueur.php', {
	idPartie : idPartie, nbBilles : tableau.rows[0].cells.length , 
	positionBilleLigne :  position, idligne : idligne, idbilles : coool
}).done(function(data) {
    alert(data);
});

   
  
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
    	//on construit une cellule du tableau qui contient <a><img /></a>
    	cell = ligne.insertCell(i);
    	cell.setAttribute('id',nbLignes+1);
		var caseA = document.createElement('a');
		var caseImg = document.createElement('img');

 		caseA.setAttribute('class','button');
 		caseA.setAttribute('href','javascript:void(0)');
 		caseA.setAttribute('id','bille'+i);

		caseImg.setAttribute('src','""');
		caseImg.setAttribute('alt','err');
 		caseImg.setAttribute('onclick','jouer_bille(this)');

 		caseA.appendChild(caseImg);
 		cell.appendChild(caseA);
	
    };

  //   // on récupère l'identifiant (id) de la table qui sera modifiée
      var tab_RB = document.getElementById("table_RB");

	 // //Ajout de la ligne à la fin de la table
      ligneRB = tab_RB.insertRow(-1);

     for (i = 0;i< tableau.rows[0].cells.length;i++){
     	cell = ligneRB.insertCell(i);
      	cell.setAttribute('style','background-color : white');
  		cell.innerHTML = "a" + (i+1);
	
     }



};







// Transfert du background de la bille selectionnée
function select_bille(elmt){
	var cellule = document.getElementById("couleur_selectionnée");
	cellule.src =  elmt.src ;
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
	if (cellule.src == "err"){
		alert('Veuillez sélectionner une couleur ! ');
	}
	// Si on clique sur une mauvaise ligne
	///////////////err
	else if (numligne != nbLignes)
	{
		alert('Merci de cliquer sur la bonne ligne ! ');
	}
	else {

	elmt.src =  cellule.src;
	cellule.src = "" ; 
	}

}



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
		nom_emp = "err" + i;
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




