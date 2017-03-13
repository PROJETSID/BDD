<?php
    //Inclut la début de la page, il est commun à toutes les pages du site
    include("head.php") ;
?>

    <h1>Gestion d'un cabinet médical</h1>

<?php
    //Si l'utilisateur n'est pas connecté
    if(!$_SESSION['connecte']){
        //Formulaire permettant de créer un formulaire de connexion
        $connexion = new form('post', 'index.php', 'Connexion') ;
        $connexion->setText('Login', 'login', 'Michel', NULL, NULL) ;
        $connexion->setPwd('Mot de Passe', 'mdp') ;
        $connexion->setSubmit('co', 'Connexion') ;
        $connexion->getForm() ;
    }else{
        //Il n'y a qu'un seul utilisateur et son nom est Michel
        echo "Bienvenue Michel !" ;
    }

    //Inclut la fin de la page, elle est commune à toutes les pages du site
    include("foot.php") ;
?>
