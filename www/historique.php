<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Historique</title>
        <link rel="stylesheet" href="style.css" />
		 <?php
		    include("head.php");
		?>
    	<div id="mettre_au_milieu_de_la_page">
	<p> Veuillez choisir une partie dans la liste suivante : </p></br>
	</div>
	<div id="mettre_au_milieu_de_la_page">
	<form>
	<select name="nom" size="1">
	<option value="0">Choix de la partie à rejouer</option>
	<script type="text/javascript">
	var nbPartie=20
	for (i=1; i<nbPartie; i++){document.write("<option>"+"Partie"+i+"</option>")}	
	</script>
	</select>
	</form>
	</div>
	<div id="mettre_au_milieu_de_la_page">
	<input type="submit" value="Rejouer" onclick="document.location.href='RejouerPartie.php';">
	</div>
	<?php
	/*$conn=oci_connect('21607258','--mdp--','ntelline.cict.fr');
	if (!$conn){echo"non connecté au server"}
	$tab=array();
	for (i=1; i<nbPartie; i++){ 
	$tab[i]<=array();
	$Billes=oci_parse($conn,
	'select idBille from Ligne L where L.idJoueur="PseudoDuJoueur" and L.idPartie="Partie_sur_laquelle_Le_Joueur_a_cliqué"
	 order by numeroL, positionBilleLigne');
	oci_execute($Billes);
	var $j=1
	While ($row=oci_fetch_array($billes,OCI_NUM)) !=false){
		if($j<5){
		$j++
		echo $row[0]
		}
		else{
		$j=1
		echo"</br>"
		}
	}*/
	?>
    </head>
    <body>
    </body>

</html>
