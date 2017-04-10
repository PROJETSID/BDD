<!--Code selecton du niveau en multi-joueur-->

<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Niveau</title>
        <link rel="stylesheet" href="style.css" />
         <?php

            // Inclusion du head
            include("head.php");

            //Connexion à la base
            include("db/connect.php");
            include("test_connexion.php");
            include("test_connexion2.php");

            $pseudo = $_SESSION['pseudo_connex'] ; 
            $pseudo2 = $_SESSION['pseudo_joueur2'] ;


          // Requête pour récupérer le niveau du joueur
             $get_niveau = "SELECT idNiveau FROM \"21400692\".Niveau 
                            WHERE seuilExpN  <= (
                                                SELECT min(experiencej)
                                                FROM \"21400692\".joueur
                                                WHERE pseudoj like '$pseudo' 
                                                OR pseudoj like  '$pseudo2'
                                                ) 
                            ORDER BY idNiveau";
            $pre_get_niveau = oci_parse($dbConn,$get_niveau);
            oci_execute($pre_get_niveau);

        ?>


    </head>

    <body>


        <div id="mettre_au_milieu_de_la_page">
            <div id="grille_des_niveaux">

        
                <form method="post" action="jeuMulti.php">

                   <label for="niveau">Selectionnez un niveau </label><br/>
                   Seuls les niveaux du joueur ayant la plus petite expérience sont affichés <br/>

                    <?php

                        if(!oci_execute($pre_get_niveau))
                        {
                            echo oci_error($pre_get_niveau);
                        }

                        echo "<select id='niveaumulti' name='niveaumulti' size='1'>";

                        echo "<option value='choisir un niveau' id='to_hide'> Choisir un niveau </option>";

                        while (oci_fetch($pre_get_niveau))
                        {
                        echo "<option value=" . oci_result($pre_get_niveau,1) . ">" . oci_result($pre_get_niveau,1) . "</option>";
                        }

                        echo "</select>";
                    ?>
                    <input type='submit' value="Commencer" />

                </form>

            </div>
        </div>

        
    </body>

</html>