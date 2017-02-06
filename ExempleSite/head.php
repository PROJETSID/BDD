<!DOCTYPE HTML>
<html>
<head>
    <title>Php-gestion</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://github.com/Eonasdan/bootstrap-datetimepicker/blob/master/build/css/bootstrap-datetimepicker.css"/>
    <link rel="stylesheet" href="https://raw.githubusercontent.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/npm.js"></script>
    <?php
        session_start() ;//Permet L'utilisation des variables de SESSION
        $_SESSION['login'] = 'Michel' ; //Login de l'utilisateur
        $_SESSION['mdp'] = 'crapaud' ; //Mot de passe de l'utilisateur

        //Si l'utilisateur a donné une valeur aux champs login et mdp
        if(isset($_POST['login'], $_POST['mdp'])){

            //si le login et le mdp sont justes alors la variable connecte est vrai
            if($_POST['login'] == $_SESSION['login'] && $_POST['mdp'] == $_SESSION['mdp']){
                $_SESSION['connecte'] = true ;
            //sinon la variable est fausse
            }else{
                $_SESSION['connecte'] = false ;
                echo "Le Login ou le mot de passe n'est pas correct veuillez réessayer" ;
            }
        }

        //Si l'utilisateur n'est pas connecte
        if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] == false){
            //On stocke l'url de la page courante dans la variable $url
            $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            //si la variable $url n'est pas égale à l'url de l'index du site alors on redirige l'utilisateur sur l'index
            if ($url != 'php-gestion-patient.esy.es/') {
                $delai = 1 ;
                $url='http://php-gestion-patient.esy.es/' ;
                header("Refresh: $delai;url=$url");
                $_SESSION['connecte'] = false ;
            }
        }

    ?>

</head>
<header>
    <!--Bouton permettant de revenir à l'index-->
    <nav>
        <ul class="nav nav-pills">
            <li role="presentation" class="active">
                <a href="index.php">Home</a>
            </li>
            <?php
            //si l'utilisateur est connecté alors afficher le menu
            if ($_SESSION['connecte'] == true) {
                ?>
                <!-- Menu de gestion des Patients -->
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role=button">
                        Patient<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a href="ajoutUsager.php">Ajouter un Patient</a></li>
                        <li role="presentation"><a href="modifUsager.php">Modifier un Patient</a></li>
                        <li role="presentation"><a href="supprUsager.php">Supprimer un Patient</a></li>
                    </ul>
                </li>
                <!-- Menu de gestion des Médecins -->
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role=button">
                        Médecin<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a href="ajoutMedecin.php">Ajouter un Médecin</a></li>
                        <li role="presentation"><a href="modifMedecin.php">Modifier un Médecin</a></li>
                        <li role="presentation"><a href="supprMedecin.php">Supprimer un Médecin</a></li>
                    </ul>
                </li>
                <!-- Menu de gestion des Consultations -->
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role=button">
                        Consultation<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a href="ajoutConsult.php">Ajouter une consultation</a></li>
                        <li role="presentation"><a href="affichConsult.php">Afficher les consultations</a></li>
                        <li role="presentation"><a href="modifConsultation.php">Modifier des consultations</a></li>
                        <li role="presentation"><a href="supprConsultation.php">Supprimer des consultations</a></li>
                    </ul>
                </li>
                <!-- Menu de gestion des Statistiques -->
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role=button">
                        Statistiques<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a href="statistiques.php">Statistiques</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</header>

<?php
    //inclut les classes formulaire et tableau, ainsi que tout le code répétitif
    include("Classe/form.php");
    include("Classe/tab.php");
    include("RepeatCode/connectBdd.php") ;
    include("RepeatCode/fonctions.php");
?>
<body>
