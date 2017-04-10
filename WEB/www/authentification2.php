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

            <!-- formulaire d'inscription -->
            <!-- changer et mettre traitement -->
            <form id="formulaire_authentification" method="post" action="traitement.php">

                <!-- pseudo et mot de passe à renseigner -->
                <p>
                <div class = text_authentification> Vous n'avez pas de compte ? </br> Inscrivez-vous ! </br>  </br></div>
                    <!-- un label pour rendre le libellé cliquable -->
                   <label for="pseudo">Pseudo :</label>
                   <input type="text" name="pseudo" id="pseudo" />
                   <br />
                   <!-- un label pour rendre le libellé cliquable -->
                   <label for="pass">Mot de passe :</label>
                   <input  type="password" name="pass" id="pass" />
               </p>

               <!-- bouton de connexion -->
               <input class ="bouton_auth" type="submit" value="S'inscrire" />
            </form>

            <!-- Formulaire de connexion au site -->
            <form id="formulaire_connexion" method="post" action="connexion_joueur2.php">

                <!-- pseudo et mot de passe à renseigner -->
                <p>
                <div class = text_authentification> Vous possédez un compte ?  </br> Connectez-vous ! </br>  </br> </div>
                    <!-- un label pour rendre le libellé cliquable -->
                   <label for="pseudo">Pseudo :</label>
                   <input type="text" name="pseudo_connex" id="pseudo_connex" />
                   <br />
                   <!-- un label pour rendre le libellé cliquable -->
                   <label for="pass">Mot de passe :</label>
                   <input type="password" name="pass_connex" id="pass_connex" />
               </p>

               <!-- bouton de connexion -->
               <input class ="bouton_auth" type="submit" value="Se connecter" /> </br>
               <p id = "text_err_connex">Le compte n'existe pas</p>
            </form>

        </div>

		
    </body>

</html>







