<?php
    //Inclut la début de la page, il est commun à toutes les pages du site
    include("head.php");

    //Si l'utilisateur a cliqué sur le bouton Ajouter
    if (isset($_POST['ajout'])) {

        //On vérifie que le médecin n'est pas déjà présent dans la base de donnée
        $verif = $bdd->prepare('SELECT * FROM `Medecin` WHERE nom = :nom AND prenom = :prenom AND civilite = :civilite') ;

        $verif->execute(array('nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'civilite' =>  $_POST['civilite']));

        $data = $verif->fetch();

        //Si la consultation est dans la bdd
        if ($data[0]){
            echo "le médecin est déjà présent dans la base de donnée." ;

        //sinon
        }else {

            //On ajoute le médecin
            $ajout = $bdd->prepare('INSERT INTO `Medecin` (nom, prenom, civilite)
                                            VALUES (:nom, :prenom, :civilite)');
            //La fonction strtolower permet de mettre tous les caractères d'une chaîne en minuscules
            $ajout->execute(array('nom' => strtolower($_POST['nom']),
                'prenom' => strtolower($_POST['prenom']),
                'civilite' =>  strtolower($_POST['civilite'])));

            echo "Le médecin a bien été ajouté à la base de données" ;
        }

        $verif->closeCursor() ;
    }
?>

<h1>Gestion des Médecin</h1>

<?php
    //Création d'un formulaire permettant d'ajouter un Médecin
    $medecin = new form("post", "ajoutMedecin.php", "Ajouter un Médecin") ;
    $medecin->setText("Nom", "nom", "Dupont", NULL, NULL) ;
    $medecin->setText("Prénom", "prenom", "Bernard", NULL, NULL) ;
    $medecin->setText("Civilite/Sexe", "civilite", "M", NULL, NULL) ;
    $medecin->setSubmit("ajout", "Ajouter") ;
    $medecin->getForm() ;

    //Inclut la fin de la page, elle est commune à toutes les pages du site
    include("foot.php");
?>
