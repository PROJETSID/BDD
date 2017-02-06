<?php
    //Inclut le début de la page, il est commun à toutes les pages
    include("head.php");
?>
    <h1>Gestion des Consultations</h1>

<?php
    //Si l'utilisateur veut modifier une consultation
    if (isset($_POST['modif'])) {
        //On recherche la consultation pour en récupérer les données
        $search = $bdd->prepare('SELECT * FROM `Consultation` WHERE `idConsult`= :id');

        $search->execute(array('id' => strtolower($_POST['id'])));

        //On enregistre l'id de la consultation dans une session pour y avoir accès pour la mise à jour des données
        $_SESSION['id'] = $_POST['id'] ;

        $data = $search->fetch();


        // Création d'un formulaire contenant les informations de la consultation à modifier
        $consult = new form("post", "modifConsultation.php", "Modifier") ;
        $consult->setText("Date", "date", NULL, $data[1], "AAAA-MM-JJ") ;
        $consult->setText("Heure de Début", "hdeb", NULL, $data[2], "HH:MM:SS") ;
        $consult->setText("Durée", "duree", NULL, $data[3], "HH:MM:SS") ;
        $consult->setSelect("Patient", "Patient", "selectPatient") ;
        $consult->setSelect("Medecin", "Médecin", "selectMedecin") ;
        $consult->setSubmit("modifier", "Modifier") ;
        $consult->getForm() ;
    }

    //Si l'utilisateur a cliquer sur le deuxième Modifier, signifiant qu'il a finit de modifier la consultation
    if (isset($_POST['modifier'])) {

        //On vérifie que le médecin ne soit pas occupé par une autre consultation
        $verif = $bdd->prepare('SELECT * FROM `Consultation`WHERE date = :data AND idMedecin = :medecin
                                        and (heureDebut = :hdeb or (heureDebut < :hdeb
                                        and heureDebut > (:hdeb-"01:00:00"))) ');

        $verif->execute(array('data' => $_POST['date'],
            'hdeb' => $_POST['hdeb'],
            'medecin' => $_POST['selectMedecin']));

        $data = $verif->fetch();

        //si le médecin est occupé
        if ($data[0]) {
            echo "Le médecin est occupé à cette heure-ci." ;

        //sinon
        } else {

            //On met à jour la consultation
            $update= $bdd->prepare('Update `Consultation` SET `date` = :date, `heureDebut` = :hdeb, `duree` = :duree
                                `idPatient` = :patient, idMedecin = :medecin  where `idConsult` = :id');

            $update->execute(array('date' => $_POST['date'],
                'hdeb' => $_POST['hdeb'],
                'duree' => $_POST['duree'],
                'patient' => $_POST['selectPatient'],
                'medecin' => $_POST['selectMedecin'],
                'id' => $_SESSION['id']));

            echo "La consultation a bien été mise à jour" ;
        }
        $verif->closeCursor();
    }

    //pour que le contenu du champs de saisie reste visible on met la valeur donnée par l'utilisateur dans une SESSION

    if (isset($_POST['searchModif'])){
        $value = $_POST['searchModif'] ;
        $_SESSION['valueModifConsul'] = $value ;
    }else{
        $value = $_SESSION['valueModifConsul'] ;
    }

    //Formulaire permettant la recherche des consultations
    $modifier= new form("post", "modifConsultation.php", "Modifier une Consultation") ;
    $modifier->setSearch("Rechercher", "searchModif", $value, "Recherche par date 'AAAA-MM-JJ', heure 'HH:MM:SS',
                          nom, prénom des médecins et patients") ;
    $modifier->setSubmit("searchSubmit", "Rechercher") ;
    $modifier->getForm() ;

    //Variable stockant la valeur de la recherche de l'utilisateur mais tout en minuscule
    $saisie = strtolower($_SESSION['valueModifConsul']);

    //on sélectionne la/les consultation(s) correspondante(s) à la saisie
    $selectionConsultation = $bdd -> query('select * from `Consultation` where `date` like "%'.$saisie.'%"
                                        OR `heureDebut` LIKE "%'.$saisie.'%" OR `idMedecin` IN (Select idMedecin
                                        from Medecin where nom like "%'.$saisie.'%" or prenom like "%'.$saisie.'%")
                                        or idPatient IN (Select idPatient from Patient where nom like "%'.$saisie.'%"
                                        or prenom like "%'.$saisie.'%")');


    //Création d'un tableau pour afficher les résultat de la requête
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

    //Pour chaque résultat de la requête faire
    while($data=$selectionConsultation->fetch()) {
        $tabConsult->beginRow();

        // Ecrire le nom et prénom du médecin de la consultation
        $medecin = $bdd->query('SELECT * FROM `Medecin` WHERE `idMedecin` = \'' . $data['idMedecin'] . '\'');
        while ($dataMedecin = $medecin->fetch()) {
            $tabConsult->setCell($dataMedecin['nom'] . ' ' . $dataMedecin['prenom']);
        }

        //Ecrire le jour mois et année de la consultation

        /*
         * Comme le format d'une date est du type : AAAA-MM-JJ
         * On va diviser la chaîne pour récupérer les valeurs que l'on souhaite
         */

        $jour = str_split($data['date'],2) ;
        // $jour est un tableau contenant 2 caractères de la chaîne par cellules
        $nbMois = str_split($data['date'],5) ;
        // $nbMois est un tableau contenant 5 caractères de la chaîne par cellules
        $nbMois[1] = strstr($nbMois[1], '-', true) ;
        /*
         * $nbMois[1] contient MM-JJ
         * La fonction strstr('chaine', 'caractère', true) retourne une nouvelle chaîne
         * Cette nouvelle chaîne contient tous les caractères qu'il y avant le caractère spécifié
         * En l'occurence MM
         */
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
        //$annee est un tableau contenant 4 caractères de la chaîne par cellules
        $tabConsult->setCell($jour[4] . ' ' . $mois . ' ' . $annee[0]) ;

        //Ecrire l'heure de la consultation
        $heure = str_split($data['heureDebut'], 2);
        $minute = str_split($data['heureDebut'], 3);
        $minute[1] = str_replace(':', '', $minute[1]);
        /*
         * fonction str_replace ('caractère présent dans la chaîne', 'caractère qui le remplace', 'chaîne'
         * $minute[1] contenait MM:
         * $minute[1] contient désormais MM
         */
        $tabConsult->setCell($heure[0].':'.$minute[1]) ;

        //Ecrire le nom et le prénom du patient
        $patient = $bdd->query('SELECT * FROM `Patient` WHERE `idPatient` = \''.$data['idPatient'].'\'');
        while ($dataPatient = $patient->fetch()) {
            $tabConsult->setCell($dataPatient['nom'] . ' ' . $dataPatient['prenom']);
        }

        //Ajouter le bouton Modifier
        //Je n'ai pas trouvé le moyen de faire avec un la classe form, Louis
        $tabConsult->setCell('<form method="post" action="modifConsultation.php" class="form-horizontal">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="'.$data[0].'"><br>
                                    </div>
                                    <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                     <button type="submit" class="btn btn-default" name="modif">Modifier</button>
                                    </div>
                                   </div></form>');
        $tabConsult->finishRow();
    }

    $tabConsult->getTab() ;

    //Inclut la fin de la page, elle est commune à toutes les pages
    include("foot.php") ;
?>