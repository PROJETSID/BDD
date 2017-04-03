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
	<input type="submit" value="Mono Joueur" onclick="document.location.href='niveau.php';">
	<input type="submit" value="Multi Joueur" onclick="document.location.href='authentification2.php';">
	</div>
    </body>

</html>
