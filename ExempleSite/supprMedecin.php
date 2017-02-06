<?php
    //Inclut le début de la page, il est commun à toutes les pages
    include("head.php");
?>
        <h1>Gestion des Médecins</h1>

<?php

	//si L'utilisateur clique sur le bouton Supprimer, alors on supprime le médecin
    if(isset($_POST['suppr'])) {
        $suppr = $bdd->prepare('DELETE from `Medecin` where `idMedecin` =:id');
        $suppr->execute(array('id' => $_POST['id']));
        echo "Le médecin a bien été supprimé" ;
    }

    //pour que le contenu du champs de saisie reste visible on met la valeur donnée par l'utilisateur dans une SESSION
    if (isset($_POST['searchSuppr'])){
        $value = $_POST['searchSuppr'] ;
        $_SESSION['valueSupprMede'] = $value ;
    }else{
        $value = $_SESSION['valueSupprMede'] ;
    }

    //Formulaire permettant la recherche des médecins
    $suppression= new form("post", "supprMedecin.php", "Supprimer un medecin") ;
    $suppression->setSearch("Rechercher", "searchSuppr", $value, "Recherche par nom et prénom des médecin") ;
    $suppression->setSubmit("searchSubmit", "Rechercher") ;
    $suppression->getForm() ;

    //Variable contenant la saisie envoyée par l'utilisateur en minuscule
    $saisie = strtolower($_SESSION['valueSupprMede']);

    //on sélectionne le/les Medecin(s) correspondant(s) à la saisie
    $selectionDuMedecin = $bdd -> query('select * from `Medecin` where `nom` like "%'.$saisie.'%"
                                        OR `prenom` LIKE "%'.$saisie.'%"');


    tabaffich($selectionDuMedecin, 'supprMedecin.php', 'supprimer') ;

    //Inclut le début de la page, elle est communne à toutes les pages
    include("foot.php") ;
?>