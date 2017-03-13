<?php
    //Inclut le début de la page, il est commun à toutes les pages
    include("head.php");
?>
        <h1>Gestion des Patients</h1>

<?php
    //Si l'utilisateur veut modifier un patient
    if (isset($_POST['modif'])) {

        //On le recherche dans la bdd pour avoir ces données
        $search = $bdd->prepare('SELECT * FROM `Patient` WHERE `idPatient`= :id');

        $search->execute(array('id' => strtolower($_POST['id'])));

        //On stocke l'id dans une session pour pouvoir l'utiliser dans la requête
        $_SESSION['id'] = $_POST['id'] ;

        $data = $search->fetch();

        //Formulaire contenant les données du patient choisi
        $usager = new form("post", "modifUsager.php", "Modifier $data[2] $data[1]") ;
        $usager->setText("Nom", "nom", NULL, $data[1], NULL) ;
        $usager->setText("Prénom", "prenom", NULL, $data[2], NULL) ;
        $usager->setText("Adresse", "adresse", NULL, $data[3], NULL) ;
        $usager->setText("Code Postal", "cp", "31000", $data[4], NULL) ;
        $usager->setText("Ville", "ville", NULL, $data[5], NULL) ;
        $usager->setText("Pays", "pays", NULL, $data[6], NULL) ;
        $usager->setText("Date de Naissance", "dateNaissance", NULL, $data[7], "AAAA-MM-JJ") ;
        $usager->setText("Lieu de Naissance", "lieuNaissance", NULL, $data[8], NULL) ;
        $usager->setSelect("Medecin", "Médecin", "selectMedecin") ;
        $usager->setText("Numéro de Sécurité", "numeroSecu", NULL, $data[10], NULL) ;
        $usager->setText("Civilite/Sexe", "civilite", NULL, $data[11], NULL) ;
        $usager->setSubmit("modifier", "Modifier") ;
        $usager->getForm() ;
    }

    //Si l'utilisateur a cliqué sur le deuxième bouton modifier, signifiant qu'il a terminé de modifier le patient
    if (isset($_POST['modifier'])) {
        //On modifie le patient
        $update= $bdd->prepare('Update`Patient` SET `nom` = :nom, `prenom` = :prenom, `adresse` = :adresse, `cp`= :cp,
                                                    `ville` = :ville, `pays` = :pays, `dateNaissance` = :dateNaissance,
                                                    `lieuNaissance` = :lieuNaissance, `medecinReferant` = :medecinReferant,
                                                    `numeroSecu` = :numeroSecu, `civilite` = :civilite
                                                    where `idPatient` = :id');

        $update->execute(array('nom' => strtolower($_POST['nom']),
            'prenom' => strtolower($_POST['prenom']),
            'adresse' => strtolower($_POST['adresse']),
            'cp' => strtolower($_POST['cp']),
            'ville' => strtolower($_POST['ville']),
            'pays' => strtolower($_POST['pays']),
            'dateNaissance' => strtolower($_POST['dateNaissance']),
            'lieuNaissance' => strtolower($_POST['lieuNaissance']),
            'medecinReferant' => strtolower($_POST['selectMedecin']),
            'numeroSecu' => strtolower($_POST['numeroSecu']),
            'civilite' =>  strtolower($_POST['civilite']),
            'id' => $_SESSION['id']));

        echo "Le patient a bien été mis à jour" ;
    }

    //pour que le contenu du champs de saisie reste visible on met la valeur donnée par l'utilisateur dans une SESSION
    if (isset($_POST['searchModif'])){
        $value = $_POST['searchModif'] ;
        $_SESSION['valueModifPat'] = $value ;
    }else{
        $value = $_SESSION['valueModifPat'] ;
    }

	//Formulaire permettant la recherche des Patients
    $search= new form("post", "modifUsager.php", "Modifier un patient") ;
    $search->setSearch("Rechercher", "searchModif", $value, "Recherche par nom et prénom des Patients") ;
    $search->setSubmit("searchSubmit", "Rechercher") ;
    $search->getForm() ;

    //Variable stockant la valeur de la recherche de l'utilisateur mais tout en minuscule
    $saisie = strtolower($_SESSION['valueModifPat']);

    //on sélectionne le/les patient(s) correspondant(s) à la saisie
    $selectionDuPatient = $bdd -> query('select * from `Patient` where `nom` like "%'.$saisie.'%"
                                        OR `prenom` LIKE "%'.$saisie.'%"');



    tabaffich($selectionDuPatient, 'modifUsager.php', 'modifier') ;

    //Inclut la fin de la page, elle est commune à toutes les pages
    include("foot.php") ;
?>