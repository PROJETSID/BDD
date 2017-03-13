<?php
    //Inclut le début de la page, il est commun à toutes les pages
    include("head.php");
?>
    <h1>Gestion des Médecins</h1>

<?php

    //si l'utilisateur veut modifier un médecin
    if (isset($_POST['modif'])) {

        //On sélectionne le médecin sélectionner par l'utilisateur
        $search = $bdd->prepare('SELECT * FROM `Medecin` WHERE `idMedecin`= :id');

        $search->execute(array('id' => strtolower($_POST['id'])));

        //On enregistre l'id du médecin pour pouvoir l'utiliser dans la mise à jour
        $_SESSION['id'] = $_POST['id'] ;

        $data = $search->fetch();

        //Création d'un formulaire contenant les informations du médecin à modifier
        $medecin = new form("post", "modifMedecin.php", "Modifier $data[2] $data[1]") ;
        $medecin->setText("Nom", "nom", NULL, $data[1], NULL) ;
        $medecin->setText("Prénom", "prenom", NULL, $data[2], NULL) ;
        $medecin->setText("Civilite/Sexe", "civilite", NULL, $data[3], NULL) ;
        $medecin->setSubmit("modifier", "Modifier") ;
        $medecin->getForm() ;
    }

    //Si l'utilisateur a cliquer sur le deuxième Modifier, signifiant qu'il a finit de modifier le médecin
    if (isset($_POST['modifier'])) {
        //On modifie le médecin
        $update= $bdd->prepare('Update`Medecin` SET `nom` = :nom, `prenom` = :prenom, `civilite` = :civilite
                                                        where `idMedecin` = :id');

        $update->execute(array('nom' => strtolower($_POST['nom']),
            'prenom' => strtolower($_POST['prenom']),
            'civilite' =>  strtolower($_POST['civilite']),
            'id' => $_SESSION['id']));

        echo "Le médecin a bien été mis à jour" ;
    }

    //pour que le contenu du champs de saisie reste visible on met la valeur donnée par l'utilisateur dans une SESSION
    if (isset($_POST['searchModif'])){
        $value = $_POST['searchModif'] ;
        $_SESSION['valueModifMede'] = $value ;
    }else{
        $value = $_SESSION['valueModifMede'] ;
    }

    //Formulaire permettant la recherche des médecins
    $modifier= new form("post", "modifMedecin.php", "Modifier un médecin") ;
    $modifier->setSearch("Rechercher", "searchModif", $value, "Recherche par nom et prénom des médecin") ;
    $modifier->setSubmit("searchSubmit", "Rechercher") ;
    $modifier->getForm() ;

    //Variable stockant la valeur de la recherche de l'utilisateur mais tout en minuscule
    $saisie = strtolower($_SESSION['valueModifMede']);

    //on sélectionne le/les médecin(s) correspondant(s) à la saisie
    $selectionDuMedecin = $bdd -> query('select * from `Medecin` where `nom` like "%'.$saisie.'%"
                                            OR `prenom` LIKE "%'.$saisie.'%"');



    tabaffich($selectionDuMedecin, 'modifMedecin.php', 'modifier') ;

    //Inclut la fin de la page, elle est commune à toutes les pages
    include("foot.php") ;
?>