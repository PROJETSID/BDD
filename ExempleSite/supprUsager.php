<?php
    //Inclut le début de la page, il est commun à toutes les pages
    include("head.php");
?>
        <h1>Gestion des Patients</h1>

<?php

	//si l'utilisateur a cliqué sur le bouton supprimer on supprime le patient correspondant
    if(isset($_POST['suppr'])) {
        $suppr = $bdd->prepare('DELETE from `Patient` where `idPatient` =:id');
        $suppr->execute(array('id' => $_POST['id']));
        echo "Le Patient a bien été supprimé" ;
    }

    //pour que le contenu du champs de saisie reste visible on met la valeur donnée par l'utilisateur dans une SESSION
    if (isset($_POST['searchSuppr'])){
        $value = $_POST['searchSuppr'] ;
        $_SESSION['valueSupprPat'] = $value ;
    }else{
        $value = $_SESSION['valueSupprPat'] ;
    }

	//Formulaire permettant la recherche des Patients
    $suppression= new form("post", "supprUsager.php", "Supprimer un patient") ;
    $suppression->setSearch("Rechercher", "searchSuppr", $value, "Recherche par nom et prénom des Patients") ;
    $suppression->setSubmit("searchSubmit", "Rechercher") ;
    $suppression->getForm() ;

    $saisie = strtolower($value);

    //on sélectionne le/les patient(s) correspondant à la saisie
    $selectionDuPatient = $bdd -> query('select * from `Patient` where `nom` like "%'.$saisie.'%"
                                        OR `prenom` LIKE "%'.$saisie.'%"');

    tabaffich($selectionDuPatient, 'supprUsager.php', 'supprimer') ;

    //Inclut le début de la page, elle est communne à toutes les pages
    include("foot.php") ;
?>