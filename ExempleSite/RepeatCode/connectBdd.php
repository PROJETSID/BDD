<?php

    /*
     * Connexion à la base de donnée
     */

    $login = 'u450364109_loui' ;
    $mdp = 'etudiant' ;

    try {

        //Bdd de Hostinger
        $bdd = new PDO('mysql:host=mysql.hostinger.fr; dbname=u450364109_gest', $login , $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)) ;
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
?>