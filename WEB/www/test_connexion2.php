<!-- Test de connexion pour le joueur 2-->

<?php

include("db/connect.php");
session_start();
if(!isset($_SESSION['pseudo_joueur2'])){
                echo"<script language=\"javascript\">";
                echo" alert(\"Un deuxième joueur doit être connecté pour accéder au menu multijoueur\") ;";
                echo"document.location.href=\"http://localhost/mastermind/authentification2.php\"";
                echo"</script>";
            };

?>