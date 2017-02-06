<?php
    //Inclut la début de la page, il est commun à toutes les pages du site
    include("head.php");

    /*
     * $date, $heure et $duree sont des variables contenant l'heure, la date et la durée de la consultation
     * Ces variables permettent de mettre ces données au format de la bdd
     */
    $date = $_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'] ; //annee-mois-jour
    $heure = $_POST['heure'].':'.$_POST['minutes'].':00' ;//h:min:sec
    $duree = '00:'.$_POST['duree'].':00' ;//h:min:sec

    // Si l'utilisateur a cliqué sur le bouton Ajouter
    if (isset($_POST['ajout'])) {

        //On vérifie que la consultation n'est pas déjà présente dans la bdd
        $verif = $bdd->prepare('SELECT * FROM `Consultation`
                                WHERE date = :data AND heureDebut = :hdeb AND duree = :duree
                                AND idPatient = :patient AND idMedecin  = :medecin') ;

        $verif->execute(array('data' => $date,
            'hdeb' => $heure,
            'duree' => $duree,
            'patient' => $_SESSION['id'],
            'medecin' => $_POST['selectMedecin']));

        $data = $verif->fetch();

        if ($data[0]){
            echo "la consultation est déjà présente dans la base de donnée." ;

        //sinon
        }else {

            // On vérifie que le médecin n'est pas occupé par une autre consultation
            $verif = $bdd->prepare('SELECT * FROM `Consultation`WHERE date = :data AND idMedecin = :medecin
                                    and (heureDebut = :hdeb or (heureDebut < :hdeb
                                    and heureDebut > (:hdeb-"01:00:00"))) ');

            $verif->execute(array('data' => $date,
                'hdeb' => $heure,
                'medecin' => $_POST['selectMedecin']));

            $data = $verif->fetch();
            if ($data[0]) {
                echo "Le médecin est occupé à cette heure-ci." ;

            //sinon
            } else {

                //On ajoute la consultation dans la bdd
                $ajout = $bdd->prepare('INSERT INTO `Consultation` (date, heureDebut, duree, idPatient, idMedecin)
                                    VALUES (:data, :hdeb, :duree, :patient, :medecin)');

                $ajout->execute(array('data' => $date,
                    'hdeb' => $heure,
                    'duree' => $duree,
                    'patient' => $_SESSION['id'],
                    'medecin' => $_POST['selectMedecin']));

                echo "La consultation a bien été ajouté" ;
            }
            $verif->closeCursor();
        }
    }
?>

<h1>Gestion des Consultation</h1>

<?php
    //Formulaire permettant le choix du patient
    $patient = new form("post", "ajoutConsult.php", "Choisir son patient") ;
    $patient->setSelect("Patient", "Patient", "pat") ;
    $patient->setSubmit("choix", "Envoyer") ;
    $patient->getForm() ;

    if (isset($_POST['choix'])){
        //id permettant de mettre par défaut le médecin référant du patient choisi par l'utilisateur
        $id = $_POST['pat'] ;
        $_SESSION['id'] = $id ;
        $patient = $bdd->query('Select * from Patient where idPatient = \''.$id.'\'') ;
        $data = $patient->fetch() ;
        //Formulaire permettant l'ajout d'une consultation
        $consult = new form("post", "ajoutConsult.php", "Ajouter une Consultation") ;
        $consult->setDate("Date") ;
        $consult->setTime("Heure de Début") ;
        $consult->setDuree("Durée") ;
        $consult->setText("Patient", "patient", NULL, $data['prenom'].' '.$data['nom'], NULL) ;
        $consult->setMedecin("Médecin", "selectMedecin", $id) ;
        $consult->setSubmit("ajout", "Ajouter") ;
        $consult->getForm() ;
    }

    //Inclut la fin de la page, elle est commune à toutes les pages du site
  include("foot.php");
?>
