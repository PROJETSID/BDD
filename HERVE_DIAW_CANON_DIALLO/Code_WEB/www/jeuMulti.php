<!DOCTYPE html>



<!-- CODE PHP -->
<?php 
//Connexion à la base
include("db/connect.php");

// On commence la session
session_start();
include("test_connexion.php");
include("test_connexion2.php");



// Recuperation du niveau
$niveau = $_POST['niveaumulti'];


$pseudo = $_SESSION['pseudo_connex'] ; 
$pseudo2 = $_SESSION['pseudo_joueur2'] ;

// SELECTION DE L'ID DU JOUEUR 1
$requete_id_joueur = "SELECT idjoueur FROM \"21400692\".Joueur WHERE PSEUDOJ = '$pseudo'";
$req_id_joueur = oci_parse($dbConn,$requete_id_joueur);
	 if(!oci_execute($req_id_joueur)){
	     echo oci_error($req_id_joueur)['message'];
	     }else{

		while(oci_fetch($req_id_joueur)){
			$idjoueur = oci_result($req_id_joueur, 'IDJOUEUR');
	     };

	     };


// SELECTION DE L'ID DU JOUEUR 2
$requete_id_joueur = "SELECT idjoueur FROM \"21400692\".Joueur WHERE PSEUDOJ = '$pseudo2'";
$req_id_joueur = oci_parse($dbConn,$requete_id_joueur);
	 if(!oci_execute($req_id_joueur)){
	     echo oci_error($req_id_joueur)['message'];
	     }else{

		while(oci_fetch($req_id_joueur)){
			$idjoueur2 = oci_result($req_id_joueur, 'IDJOUEUR');
	     };
	     };



// INSERTION DE LA PARTIE POUR LES DEUX JOUEURS
$req_partie = "BEGIN \"21400692\".INSERTION_PARTIE_MULTI(:id, :id2, :niv);END;";
$stmt = oci_parse($dbConn, $req_partie);
oci_bind_by_name($stmt, ':id', $idjoueur);
oci_bind_by_name($stmt, ':id2', $idjoueur2);
oci_bind_by_name($stmt, ':niv', $niveau);

	 if(!oci_execute($stmt)){
	    echo oci_error($stmt)['message'];
	     };




// STOCKAGE DE L'ID DE LA PARTIE
$requete_id_partie = "SELECT IDPARTIE 
						FROM \"21400692\".Jouer 
						WHERE IDPARTIE = (SELECT MAX( IdPartie) 
										FROM \"21400692\".JOUER
										WHERE IDJOUEUR = $idjoueur)";
$req_id_partie = oci_parse($dbConn,$requete_id_partie);
	 if(!oci_execute($req_id_partie)){
	     echo oci_error($req_id_partie)['message'];
	     }else{

		while(oci_fetch($req_id_partie)){
			$idPartie = oci_result($req_id_partie, 'IDPARTIE');
	     };

	     };




// Selection du nombre de billes de la collection
$Requete_nb_billes_colles = "SELECT nbBillesCol 
							FROM \"21400692\".Collection 
							WHERE IdCollection = (SELECT IdCollection 
							FROM \"21400692\".Niveau 
							WHERE IdNiveau = $niveau)";


$req_nb_billes = oci_parse($dbConn,$Requete_nb_billes_colles);
	 if(!oci_execute($req_nb_billes)){
	     echo oci_error($req_nb_billes)['message'];
	     };



// Selection des URL de billes de la collection
$Requete_select_billes = "SELECT urlB FROM \"21400692\".BILLE , \"21400692\".COMPOSER 
							WHERE Bille.Idbille = Composer.idbille
              				AND IDcollection = (SELECT IDCOLLECTION 
              										FROM \"21400692\".NIVEAU 
              										WHERE IDNIVEAU =$niveau)";


$req_select_billes = oci_parse($dbConn,$Requete_select_billes);
	 if(!oci_execute($req_select_billes)){
	     echo oci_error($req_nb_billes)['message'];
	     }else{
// Affichage des urls
		// Stockage des urls dans une liste
		while(oci_fetch($req_select_billes)){
			//echo oci_result($req_select_billes, 'URLB'); 
			$url[] = oci_result($req_select_billes, 'URLB');
	     };
		};


// SELECTION DU TIMER ET DU NOMBRE D'EMPLACEMENTS
$Requete_emp_time = "SELECT nbEmplacementsN, timerN 
							FROM \"21400692\".NIVEAU 
              				WHERE IDNIVEAU =$niveau";


$req_emp_time = oci_parse($dbConn,$Requete_emp_time);
	 if(!oci_execute($req_emp_time)){
	      echo oci_error($req_nb_billes)['message'];
	     }else{

		while(oci_fetch($req_emp_time)){
		$nbemp = oci_result($req_emp_time, 'NBEMPLACEMENTSN'); 
		$timer = oci_result($req_emp_time, 'TIMERN');
	     };

	     };


// CREATION DE LA COMBINAISON POUR LA PARTIE CREE
$req_combi = "BEGIN \"21400692\".P_CREATION_COMBINAISON(:idpartie);END;";
$stmt_combi = oci_parse($dbConn, $req_combi);
oci_bind_by_name($stmt_combi, ':idpartie', $idPartie);

	 if(!oci_execute($stmt_combi)){
	    echo oci_error($stmt_combi)['message'];
	     };     


// SELECTION DES URLS DES BILLES POUR LA PARTIE CREE
$Requete_select_combi = "SELECT URLB FROM \"21400692\".BILLE, \"21400692\".COMBINAISON
WHERE BILLE.IDBILLE = COMBINAISON.IDBILLE 
AND COMBINAISON.IDPARTIE = $idPartie
ORDER BY POSITIONBILLECOMBINAISON ";


$req_select_combi = oci_parse($dbConn,$Requete_select_combi);
	 if(!oci_execute($req_select_combi)){
	     echo oci_error($req_nb_billes)['message'];
	     }else{

// Affichage des urls
		// Stockage des urls dans une liste
		while(oci_fetch($req_select_combi)){
			$combi[] = oci_result($req_select_combi, 'URLB');
	     };

		};





?>


<html>

    <head>

        <meta charset="utf-8" />

        <title>Mastermind multijoueur</title>
        <link rel="stylesheet" href="style.css" />
		<?php
		    include("head.php");
		?>

<!-- On inclut JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<!-- Script du timer -->

		<script language="javascript" type="text/javascript">

var compte = <?php echo $timer ?>;
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
       document.location.href = "http://localhost/mastermind/typeDePartie.php";

        }

    compte--;
}
var timer = setInterval('decompte()',1000);

</script>


    </head>


    <!-- BODY -->

    <body onload="decompte();">
   

<br>
		<div id="mettre_au_milieu_de_la_page">
			<div id="grille_des_niveaux">
				
					<div id="test">
					</div>


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

							for ($i = 1; $i <= $nbemp;$i++){
								echo "<td id = $ii ><a href=\"javascript:void(0)\",  class=\"button\" id=\"emp".$i."\"><img src=\"images/rsz_fond.jpg\" alt=\"err1\" onclick =\"jouer_bille(this)\" /></a></td>";
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

							for ($i = 1; $i <= $nbemp;$i++){
								echo "<td style = \"background-color : white; \"  class=\"button\" id=\"rb".$i."\">&nbsp&nbsp</td>";
								// remplacer les a1 par des &nbsp
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
						<?php echo $pseudo;?>
					</div>
						<div id="id_joueur" >
						 <?php echo $idjoueur; ?>
						</div>
					<div  style = " width:30px; height:30px;border : solid">
						<img  src="images/blanc.jpg" alt="err" id = "couleur_selectionnée" />
					</div>

					<!--Liste des billes de la collection -->
					<div id="bille_à_placer">

					<td><button onclick="insererLigne_Fin();test_combi();changer_joueur()" >Jouer</button></td>

						<table id="testAppendChild">
						<?php
							
	                       
							$req_nb_billes = oci_parse($dbConn,$Requete_nb_billes_colles);
	        								oci_execute($req_nb_billes);
	        								if(!oci_execute($req_nb_billes)){
	           								 echo oci_error($req_nb_billes);
	        								}


							
							$nbrow = 1 ;
							while (oci_fetch($req_nb_billes)) {
									for ($ii = 1 ; $ii <=$nbrow ; $ii++)
								{
									echo "<tr>";	
									$nb_billes_collections = oci_result($req_nb_billes, 1);

									for ($i = 1; $i <= $nb_billes_collections;$i++){
										$ind = ($i-1);
										echo "<td><a href=\"javascript:void(0)\",  class=\"button\" id=\"bille".$i."\"><img src=\"images".$url[$ind]."\" alt=\"err\" onclick=\"select_bille(this)\" /></a></td>";
												}	
									echo "</tr>";	
								}
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
    		var image = ligne_jeu[i].childNodes[0].childNodes[0].src;
    		var image_trunc = image.replace("http://localhost/mastermind/images", "");
    		coool.push(image_trunc);
    		position.push(i);
    };




// Stockage de la combinaison à trouver pour la partie
	var combi = <?php echo '[';

		for ($i=0;$i < $nbemp ;$i++){
			echo '"'.$combi[$i].'"'; 
			if ($i < $nbemp)
				echo ',';
		}
		echo ']';
	?>;



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





// Coloration des billes rouges et des billes blanches
    var tRB = document.getElementById("table_RB");

      // nombre de lignes dans la table (avant ajout de la ligne)
   	var nbLignes_tRB = tRB.rows[0].length;
   	ind_RB = nbLignes-1;

    for (i=0;i<compteurrouge;i++){
    	tRB.rows[ind_RB].cells[i].style.backgroundColor = 'red';
  
    };
        for (i=compteurrouge;i<(compteurrouge+compteurblanc);i++){
    	tRB.rows[ind_RB].cells[i].style.backgroundColor = 'blue';

    };



var idPartie = <?php echo '"'.$idPartie.'"' ?>;
var idJoueur = parseInt(document.getElementById("id_joueur").innerHTML);




// Envoi des données au fichier de traitement insert_ligne.php
$.post('insert_ligne.php', {numeroL: nbLignes,
	nbIndiceRougeL: compteurrouge,
	nbIndiceBlancL: compteurblanc,
	idPartie : idPartie,
	joueur: idJoueur,
	nbBilles : tableau.rows[0].cells.length , 
	positionBilleLigne :  position, 
	idbilles : coool
});

 
  	// FIN DE LA PARTIE
    if(compteurrouge == tableau.rows[0].cells.length){
    	alert('Vous avez trouvé la combinaison');
    	$.post('gestion_fin_partie.php', {idPartie : idPartie, idJoueur : idJoueur});
    	 document.location.href = "http://localhost/mastermind/typeDePartie.php";
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
    	//on construit une cellule du tableau qui contient <a><img /></a>
    	cell = ligne.insertCell(i);
    	cell.setAttribute('id',nbLignes+1);
		var caseA = document.createElement('a');
		var caseImg = document.createElement('img');

 		caseA.setAttribute('class','button');
 		caseA.setAttribute('href','javascript:void(0)');
 		caseA.setAttribute('id','bille'+i);

		caseImg.setAttribute('src','images/rsz_fond.jpg');
		caseImg.setAttribute('alt','rien');
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
  		cell.innerHTML = "&nbsp&nbsp";
	
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
	var idname = elmt.parentNode.parentNode;
	var numligne = idname.getAttribute('id');

	// on récupère l'identifiant (id) de la table qui sera modifiée
    var tableau = document.getElementById("table_grille");
    // nombre de lignes dans la table (avant ajout de la ligne)
    var nbLignes = tableau.rows.length;

	// Si on a pas selectionné de couleur
	if (cellule.src == "images/blanc.jpg"){
		alert('Veuillez sélectionner une couleur ! ');
	}
	// Si on clique sur une mauvaise ligne

	 else if (numligne != nbLignes)
	 {
	 	alert('Merci de cliquer sur la bonne ligne ! ');
	 }
	else {
	elmt.src =  cellule.src;
	cellule.src = "images/blanc.jpg" ; 
	}

}

// Fonction permettant de changer de joueur
function changer_joueur(){
	joueur = document.getElementById("score_joueur");
	id = document.getElementById("id_joueur");
	if (joueur.innerHTML.indexOf(<?php echo '"'.$pseudo.'"'?>) > -1){
		joueur.innerHTML = <?php echo '"'.$pseudo2.'"'?>;
		id.innerHTML = <?php echo '"'.$idjoueur2.'"'?>;

	} else if(joueur.innerHTML.indexOf(<?php echo '"'.$pseudo2.'"'?>) > -1){
	joueur.innerHTML = <?php echo '"'.$pseudo.'"'?>;
	id.innerHTML = <?php echo '"'.$idjoueur.'"'?>;
	}
};




</script>

		
    </body>

</html>




