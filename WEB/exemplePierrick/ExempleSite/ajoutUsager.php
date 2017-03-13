<?php
    //Inclut la début de la page, il est commun à toutes les pages du site
    include("head.php");

    //Si l'utilisateur a cliqué sur le bouton Ajouter
    if (isset($_POST['ajout'])) {

        /*
         * $date est une variable contenant la date de naissance du patient
         * Cette variables permet de mettre cette donnée au format de la bdd
         */
        $date = $_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'] ; //annee-mois-jour

        // On vérifie que le patient n'est pas déjà présent dans la bdd
        $verif = $bdd->prepare('SELECT * FROM `Patient` WHERE numeroSecu = :numeroSecu') ;

        $verif->execute(array('numeroSecu' => strtolower($_POST['numeroSecu']))) ;

        $data = $verif->fetch();

        //Si le patient est présent dans la bdd
        if ($data[0]){
            echo "l'usager est déjà présent dans la base de donnée." ;

        //sinon
        }else {

            //On ajoute le patient dans la bdd
            $ajout = $bdd->prepare('INSERT INTO `Patient` (nom, prenom, adresse, cp, ville, pays,
                                            dateNaissance, lieuNaissance, medecinReferant, numeroSecu, civilite)
                                            VALUES (:nom, :prenom, :adresse, :cp, :ville, :pays, :dateNaissance,
                                            :lieuNaissance, :medecinReferant, :numeroSecu, :civilite)');
            //La fonction strtolower permet de mettre tous les caractères d'une chaîne en minuscules
            $ajout->execute(array('nom' => strtolower($_POST['nom']),
                'prenom' => strtolower($_POST['prenom']),
                'adresse' => strtolower($_POST['adresse']),
                'cp' => strtolower($_POST['cp']),
                'ville' => strtolower($_POST['ville']),
                'pays' => strtolower($_POST['pays']),
                'dateNaissance' => $date,
                'lieuNaissance' => strtolower($_POST['lieuNaissance']),
                'medecinReferant' => $_POST['selectMedecin'],
                'numeroSecu' => strtolower($_POST['numeroSecu']),
                'civilite' =>  strtolower($_POST['civilite'])));

            echo "Le patient a bien été ajouté à la base de données" ;
        }

        $verif->closeCursor() ;
    }
?>

<h1>Gestion des Usager</h1>

<?php
    //Formulaire permettant l'ajout d'un patient dans la bdd
    $usager = new form("post", "ajoutUsager.php", "Ajouter un Usager") ;
    $usager->setText("Nom", "nom", "Dupont", NULL, NULL) ;
    $usager->setText("Prénom", "prenom", "Bernard", NULL, NULL) ;
    $usager->setText("Adresse", "adresse", "120 rue de la République", NULL, NULL) ;
    $usager->setText("Code Postal", "cp", "31000", NULL, NULL) ;
    $usager->setText("Ville", "ville", "Toulouse", NULL, NULL) ;
    $usager->setText("Pays", "pays", "France", NULL, NULL) ;
    $usager->setDate("Date de Naissance") ;
    $usager->setText("Lieu de Naissance", "lieuNaissance", "Montauban", NULL, NULL) ;
    $usager->setSelect("Medecin", "Médecin", "selectMedecin") ;
    $usager->setText("Numéro de Sécurité", "numeroSecu", "0123456789", NULL, NULL) ;
    $usager->setText("Civilite/Sexe", "civilite", "M", NULL, NULL) ;
    $usager->setSubmit("ajout", "Ajouter") ;
    $usager->getForm() ;

    //Inclut la fin de la page, elle est commune à toutes les pages du site
    include("foot.php");
?>
