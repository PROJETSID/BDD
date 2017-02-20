<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Authentification</title>
        <link rel="stylesheet" href="style.css" />
		 <?php
		    include("head.php");
		?>
    </head>


    <body>
        <div id="mettre_au_milieu_de_la_page">

            <!-- formulaire de connexion -->
            <!-- changer et mettre traitement -->
            <form id="formulaire_authentification" method="post" action="traitement.php">

                <!-- pseudo et mot de passe à renseigner -->
                <p>
                    <!-- un label pour rendre le libellé cliquable -->
                   <label for="pseudo">Pseudo :</label>
                   <input type="text" name="pseudo" id="pseudo" />
                   <br />
                   <!-- un label pour rendre le libellé cliquable -->
                   <label for="pass">Mot de passe :</label>
                   <input type="password" name="pass" id="pass" />
               </p>

               <!-- bouton de connexion -->
               <input type="submit" value="Connexion" />
            </form>

        <!-- comment gérer la double connexion ??? Bon chance-->
        </div>

		
    </body>

</html>







