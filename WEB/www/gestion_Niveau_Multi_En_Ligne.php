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
             $req = "SELECT pseudoJ FROM \"21400692\".Joueur";
            $parsereq = oci_parse($dbConn,$req);
            oci_execute($parsereq);

        ?>


    </head>


    <body>


        <div id="mettre_au_milieu_de_la_page">
            <div id="grille_des_niveaux">

        
    <form method="post" action="jeuMultiEnLigne.php">

       <label for="niveau"> Selectionnez un niveau </label><br/>

        <?php

        if(!oci_execute($parsereq))
        {
            echo oci_error($parsereq);
        }

        echo "<select id='niveau' name='niveau' size='1'>";

        echo "<option value='Sélectionnez un Joueur' id='to_hide'> Sélectionnez un Joueur </option>";

        while (oci_fetch($parsereq))
        {
        echo "<option  value=" . oci_result($parsereq,1) . ">" . oci_result($parsereq,1) . "</option>";
        }

        echo "</select>";
        

        //$selected_val = $_POST['niveau'];  // On stocke la variable de selectionner
      //  $_SESSION['niveau'] = $selected_val;  // On la stocke dans une variable de session pour 
                                //par la suite pouvoir réutiliser le niveau

        ?>


        <input type='submit' value="Défier" />

    </form>


</div>
        </div>

        
    </body>

</html>


