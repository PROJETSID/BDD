<!--Code selecton du niveau en mono-joueur-->

<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Authentification</title>

        <link rel="stylesheet" href="style.css" />

         <?php

            // Inclusion du head
            include("head.php");
            //Connexion à la base
            include("db/connect.php");
            session_start();



            // Requête pour récupérer le niveau du joueur en mode monojoueur
             $get_niveau = "SELECT idNiveau FROM \"21400692\".Niveau 
                        WHERE seuilExpN <= 500
/*                        (
                                                SELECT experiencej
                                                FROM \"21400692\".joueur
                                                WHERE pseudoj like 'testblabla' 
                                                ) */
                        order by idNiveau";
            $pre_get_niveau = oci_parse($dbConn,$get_niveau);
            oci_execute($pre_get_niveau);

        ?>


    </head>


    <body>


        <div id="mettre_au_milieu_de_la_page">
            <div id="grille_des_niveaux">

        
    <form method="post" action="jeu.php">

       <label for="niveau"> Selectionnez un niveau </label><br/>

        <?php

        if(!oci_execute($pre_get_niveau))
        {
            echo oci_error($pre_get_niveau);
        }

        echo "<select id='niveau' name='niveau' size='1'>";

        echo "<option value='choisir un niveau' id='to_hide'> Choisir un niveau </option>";

        while (oci_fetch($pre_get_niveau))
        {
        echo "<option  value=" . oci_result($pre_get_niveau,1) . ">" . oci_result($pre_get_niveau,1) . "</option>";
        }

        echo "</select>";
        

        //$selected_val = $_POST['niveau'];  // On stocke la variable de selectionner
      //  $_SESSION['niveau'] = $selected_val;  // On la stocke dans une variable de session pour 
                                //par la suite pouvoir réutiliser le niveau

        ?>


        <input type='submit' value="Commencer" />

    </form>


</div>
        </div>

        
    </body>

</html>

