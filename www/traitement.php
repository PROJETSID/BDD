<!-- Gestion des utilisateurs -->

<?php

// Connexion à la base
?>

<?php

include("db/connect.php");
// Recuperation des données

//pseudo
if(isset($_POST['pseudo']))
	$pseudo = $_POST['pseudo'];
else $pseudo = "";

//mot de passe
if(isset($_POST['pass']))
	$pass = $_POST['pass'];
else $pass = ""; 

// on écrit la requête sql
$sql = "INSERT INTO Joueur(idJoueur, motdepasseJ) VALUES('$pseudo','$pass')";
    
// on insère les informations du formulaire dans la table
mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());

// on affiche le résultat pour le visiteur
echo 'Vos infos on été ajoutées.';


?>



