<?php

include("db/connect.php");
session_start();
if(!isset($_SESSION['pseudo_connex'])){
                echo"<script language=\"javascript\">";
                echo" alert(\"Vous n'êtes pas connecté, merci de vous connecter !\") ;";
                echo"document.location.href=\"http://localhost/mastermind/authentification.php\"";
                echo"</script>";
            };

?>
