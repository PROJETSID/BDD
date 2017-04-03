<form method="post" action="jeu.php">

       <label for="niveau">selectionnez un niveau </label><br />

        <?php

        include("db/connect.php");
        $get_niveau = "SELECT idNiveau FROM \"21400692\".Niveau 
                        WHERE seuilExpN <= 500
                        order by idNiveau";
        $pre_get_niveau = oci_parse($dbConn,$get_niveau);
        oci_execute($pre_get_niveau);
        if(!oci_execute($pre_get_niveau)){
            echo oci_error($pre_get_niveau);
        }
        echo "<select name='niveau' size='1'>";
        echo "<option value='choisir un niveau' id='to_hide'> choisir un niveau </option>";
        while (oci_fetch($pre_get_niveau)){
        echo "<option value=" . oci_result($pre_get_niveau,1) . ">" . oci_result($pre_get_niveau,1) . "</option>";
      }
      echo "</select>"
        ?>
        <input type='submit' value="Commencer" />


    </form>

   