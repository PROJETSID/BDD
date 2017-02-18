<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>High Scores</title>
        <link rel="stylesheet" href="projetstyle.css" />
        <?php
            include("head.php");
        ?>
    </head>
    <body>

        <div id="mettre_au_milieu_de_la_page">
            <div id="high_scores">
                <!-- menu choix : jour/semaine/tous -->
                <nav id="menu_choix_hs">
                    <a id="hs_jour" href="">Jour</a>
                    <a id="hs_semaine" href="">Semaine</a>
                    <a id="hs_tous" href="">Tous</a>
                </nav>
                <!-- tableaux qui affichent les meilleurs joueurs (plus haut score) -->
                <div id="tableau_classement_joueurs">

                </div>
            </div>
        </div>
		
    </body>

</html>

