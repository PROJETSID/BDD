<?php
    //Inclut la début de la page, il est commun à toutes les pages du site
    include("head.php");
?>
    <h1>Gestion des consultations</h1>

<?php
    /*
     * Liste déroulante permettant de filtrer les consultations en fonction du médecin
     */
    $filtre = new form("post", "affichConsult.php", "Filtrer les consultations") ;
    $filtre->setSelect("Medecin", "Médecin", "selectMedecin") ;
    $filtre->setSubmit("filtre", "Filtrer") ;
    $filtre->getForm() ;

    // si l'utilisateur a choisi un médecin dans la liste
    if (isset($_POST['filtre'])){
        $afficher = $bdd->query('SELECT * FROM `Consultation` WHERE `idMedecin` = \''.$_POST['selectMedecin'].'\'
                                  ORDER BY `date` DESC ') ;
    //sinon
    }else{
        $afficher = $bdd->query('SELECT * FROM `Consultation` ORDER BY `date` DESC ') ;
    }

    //Création d'un tableau pour afficher les résultat de la requête
    $tabConsult = new tab() ;
    $tabConsult->beginRow() ;
    $tabConsult->setColumnTitle("Médecin") ;
    $tabConsult->setColumnTitle("Date");
    $tabConsult->setColumnTitle("Heure");
    $tabConsult->setColumnTitle("Patient");
    $tabConsult->finishRow() ;
    $tabConsult->finishTitle() ;
    $tabConsult->setBody() ;

    //Pour chaque résultat de la requête faire
    while($data=$afficher->fetch()) {
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
        $tabConsult->finishRow();
    }

    $tabConsult->getTab() ;

    //Inclut la fin de la page, elle est commune à toutes les pages
    include("foot.php");
?>