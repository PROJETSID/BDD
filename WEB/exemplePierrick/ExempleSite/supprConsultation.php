<?php
    //Inclut le début de la page, il est commun à toutes les pages
    include("head.php");
?>
    <h1>Gestion des Consultations</h1>

<?php
    //si l'utilisateur a cliqué sur supprimer, on supprime l'utilisateur correspondant
    if(isset($_POST['suppr'])) {
        $suppr = $bdd->prepare('DELETE from `Consultation` where `idConsult` =:id');
        $suppr->execute(array('id' => $_POST['id']));
        echo "La Consultation a bien été supprimée" ;
    }

    //pour que le contenu du champs de saisie reste visible on met la valeur donnée par l'utilisateur dans une SESSION
    if (isset($_POST['searchSuppr'])){
        $value = $_POST['searchSuppr'] ;
        $_SESSION['valueSupprConsult'] = $value ;
    }else{
        $value = $_SESSION['valueSupprConsult'] ;
    }

    //Formulaire permettant la recherche des consultations
    $suppression= new form("post", "supprConsultation.php", "Supprimer une Consultation") ;
    $suppression->setSearch("Rechercher", "searchSuppr", $value, "Recherche par date 'AAAA-MM-JJ', heure 'HH:MM:SS',
                              nom, prénom des médecins et patients") ;
    $suppression->setSubmit("searchSubmit", "Rechercher") ;
    $suppression->getForm() ;

    //Variable contenant la valeur donnée par l'utilisateur en minuscule
    $saisie = strtolower($_SESSION['valueSupprConsult']);

    //on sélectionne la/les consultation(s) correspondante à la saisie
    $selectionConsultation = $bdd -> query('select * from `Consultation` where `date` like "%'.$saisie.'%"
                                            OR `heureDebut` LIKE "%'.$saisie.'%" OR `idMedecin` IN (Select idMedecin
                                            from Medecin where nom like "%'.$saisie.'%" or prenom like "%'.$saisie.'%")
                                            or idPatient IN (Select idPatient from Patient where nom like "%'.$saisie.'%"
                                            or prenom like "%'.$saisie.'%")');


    //On affiche les résultats dans le même type de tableau que celui dans modifConsulation.php
    $tabConsult = new tab() ;
    $tabConsult->beginRow() ;
    $tabConsult->setColumnTitle("Médecin") ;
    $tabConsult->setColumnTitle("Date");
    $tabConsult->setColumnTitle("Heure");
    $tabConsult->setColumnTitle("Patient");
    $tabConsult->setColumnTitle("Action");
    $tabConsult->finishRow() ;
    $tabConsult->finishTitle() ;
    $tabConsult->setBody() ;
    while($data=$selectionConsultation->fetch()) {
        $tabConsult->beginRow();
        $medecin = $bdd->query('SELECT * FROM `Medecin` WHERE `idMedecin` = \'' . $data['idMedecin'] . '\'');
        while ($dataMedecin = $medecin->fetch()) {
            $tabConsult->setCell($dataMedecin['nom'] . ' ' . $dataMedecin['prenom']);
        }


        $jour = str_split($data['date'],2) ;
        $nbMois = str_split($data['date'],5) ;
        $nbMois[1] = strstr($nbMois[1], '-', true) ;
        if($nbMois[1] == '1'){
            $mois = 'Janvier' ;
        }elseif($nbMois[1] == '2'){
            $mois = 'Février' ;
        }elseif($nbMois[1] == '3'){
            $mois = 'Mars' ;
        }elseif($nbMois[1] == '4'){
            $mois = 'Avril' ;
        }elseif($nbMois[1] == '5'){
            $mois = 'Mai' ;
        }elseif($nbMois[1] == '6'){
            $mois = 'Juin' ;
        }elseif($nbMois[1] == '7'){
            $mois = 'Juillet' ;
        }elseif($nbMois[1] == '8'){
            $mois = 'Août' ;
        }elseif($nbMois[1] == '9'){
            $mois = 'Septembre' ;
        }elseif($nbMois[1] == '10'){
            $mois = 'Octobre' ;
        }elseif($nbMois[1] == '11'){
            $mois = 'Novembre' ;
        }elseif($nbMois[1] == '12'){
            $mois = 'Décembre' ;
        }
        $annee = str_split($data['date'],4) ;
        $tabConsult->setCell($jour[4] . ' ' . $mois . ' ' . $annee[0]) ;

        //colonne heure
        $heure = str_split($data['heureDebut'], 2);
        $minute = str_split($data['heureDebut'], 3);
        $minute[1] = str_replace(':', '', $minute[1]);
        $tabConsult->setCell($heure[0].':'.$minute[1]) ;

        //colonne Patient
        $patient = $bdd->query('SELECT * FROM `Patient` WHERE `idPatient` = \''.$data['idPatient'].'\'');
        while ($dataPatient = $patient->fetch()) {
            $tabConsult->setCell($dataPatient['nom'] . ' ' . $dataPatient['prenom']);
        }
        $tabConsult->setCell('<form method="post" action="supprConsultation.php" class="form-horizontal">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="'.$data[0].'"><br>
                                    </div>
                                    <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                     <button type="submit" class="btn btn-default" name="suppr">Supprimer</button>
                                    </div>
                                   </div></form>');
        $tabConsult->finishRow();
    }

    $tabConsult->getTab() ;

    //Inclut le début de la page, elle est communne à toutes les pages
    include("foot.php") ;
?>