<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />

        <title>Authentification</title>
        <link rel="stylesheet" href="style.css" />
		 <?php
		    include("head.php");
		    //Connexion à la base
			include("db/connect.php");
		?>
    </head>

    <body>
		<div id="mettre_au_milieu_de_la_page">
		<!-- le joueur choisit le type de partie -->
			<input type="submit" value="Mono Joueur" onclick="document.location.href='form_niveau.php';">
			<input type="submit" value="Multi Joueur" onclick="document.location.href='authentification2.php';">
			<input type="submit" value="Multi Joueur en Ligne" onclick="document.location.href='gestion_Niveau_Multi_En_Ligne.php';">
		</div>
    </body>

</html>
