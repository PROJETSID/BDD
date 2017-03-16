<?php
    include("head.php");

	$moins25M = $bdd->query('SELECT Count(*) FROM `Patient` WHERE civilite=\'m\' and DATEDIFF(CurDate(),`dateNaissance`) < (25*365)') ;
	$moins25F = $bdd->query('SELECT Count(*) FROM `Patient` WHERE civilite=\'f\' and DATEDIFF(CurDate(),`dateNaissance`) < (25*365)') ;
	$entreM = $bdd->query('SELECT Count(*) FROM `Patient` WHERE civilite=\'m\' and (DATEDIFF(CurDate(),`dateNaissance`) > (25*365) and
						  DATEDIFF(CurDate(),`dateNaissance`) < (50*365))') ;
	$entreF = $bdd->query('SELECT Count(*) FROM `Patient` WHERE civilite=\'f\' and (DATEDIFF(CurDate(),`dateNaissance`) > (25*365) and
						  DATEDIFF(CurDate(),`dateNaissance`) < (50*365))') ;
	$plus50M = $bdd->query('SELECT Count(*) FROM `Patient` WHERE civilite=\'m\' and DATEDIFF(CurDate(),`dateNaissance`) > (50*365)') ;
	$plus50F = $bdd->query('SELECT Count(*) FROM `Patient` WHERE civilite=\'f\' and DATEDIFF(CurDate(),`dateNaissance`)	> (50*365)') ;

	$stats= new tab();

?>
	<h1>Statisques d'âges</h1><br>
<?php

	$stats->beginRow();
	$stats->setColumnTitle("Tranche d'âge");
	$stats->setCell("Moins de 25 ans");
	$stats->setCell("Entre 25 et 50 ans");
	$stats->setCell("Plus de 50 ans");
	$stats->finishRow();

	$stats->beginRow();
	$stats->setColumnTitle("Nb d'hommes");
	$data = $moins25M->fetch() ;
	$stats->setCell($data[0]) ;
	$data = $entreM->fetch() ;
	$stats->setCell($data[0]) ;
	$data = $plus50M->fetch() ;
	$stats->setCell($data[0]) ;
	$stats->finishRow();

	$stats->beginRow();
	$stats->setColumnTitle("Nb de femmes");
	$data = $moins25F->fetch() ;
	$stats->setCell($data[0]) ;
	$data = $entreF->fetch() ;
	$stats->setCell($data[0]) ;
	$data = $plus50F->fetch() ;
	$stats->setCell($data[0]) ;
	$stats->finishRow();

	$stats->getTab();
?>

<h1>Volume horaire des Médecins</h1><br>

<?php
	$medecin=$bdd->query('Select * from Medecin') ;

	$statMede = new tab() ;

	$statMede->beginRow();
	$statMede->setTitle() ;
	$statMede->setColumnTitle("Médecin");
	$statMede->setColumnTitle("Durée totale") ;
	$statMede->finishRow() ;
	$statMede->finishTitle() ;

	while($data=$medecin->fetch()){
		$statMede->setBody() ;
		$statMede->beginRow() ;
		$statMede->setCell($data['nom'].' '.$data['prenom']);
		$duree=$bdd->query('Select SEC_TO_TIME(Sum(TIME_TO_SEC(duree))) as dureeTotal from Consultation where
						idMedecin = \''.$data['idMedecin'].'\'') ;
		$dataDuree = $duree->fetch() ;
		$statMede->setCell($dataDuree[0]) ;
		$statMede->finishRow();
	}

	$statMede->getTab() ;

    include("foot.php") ;
?>