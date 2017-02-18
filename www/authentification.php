<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="projetstyle.css" />
        <title>projet site web & bdd</title>
    </head>
    
    <body>
        <div id="bloc_page">
            <header>
                <div id="titre_principal">
                    <div id="logo">
                        <img src="images/logo.png" alt="Logo du jeu" />
                    </div>
                </div>
                
                <nav>
                    <ul id="navig">
                        <li><a href="projet.html" class="bouton">Accueil</a></li>
                        <li><a href="blog.php" class="bouton">Blog</a></li>
						<li><a href="historique.php" class="bouton">Historique</a></li>
						<li><a href="highscore.php" class="bouton">HighScore</a></li>
                        <li><a href="authentification.php" class="bouton">Authentification</a></li>
                    </ul>
                </nav>
            </header>
            <section>
                <article>
                    <h1><img src="images/ico_epingle.png" alt="Catégorie" class="ico_categorie" />Le jeu du MASTERMIND</h1>
					<h1>S'inscire</h1>
                    <form  method="post" action="traitement.php">
                        <p>
                         <label for="pseudo">Pseudo &nbsp:</label>
                         <input type="text" name="pseudo" id="pseudo" /><br/><br/>
                         <label for="pass">PassWord:</label>
                         <input type="password" name="pass" id="pass" /><br/><br/>
						 <label for="pass">Confirmer PassWord:</label>
                         <input type="password" name="pass" id="pass" /><br/><br/>
                         <input type="submit" value="s'inscrire" />
                        </p>
                    </form>

                </article>
                <aside>
                    <h1>Se Connecter</h1>
                    <img src="images/bulle.png" alt="" id="fleche_bulle" />
                    
                    <form  method="post" action="traitement.php">
                        <p>
                         <label for="pseudo">Pseudo &nbsp:</label>
                         <input type="text" name="pseudo" id="pseudo" /><br/><br/>
                         <label for="pass">PassWord:</label>
                         <input type="password" name="pass" id="pass" /><br/><br/>
                         <input type="submit" value="Connexion" />
                        </p>
                    </form>
                    <p id="photo_du_jeu"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2d/Mastermind.jpg/220px-Mastermind.jpg" alt="Photo du jeu" /></p>
                </aside>
            </section>
            
            <footer>
                <div id="ma_der">
                    <h1>Ma dernière Partie</h1>
                </div>
                <div id="ma_cat">
                    <h1>Ma Catégorie</h1>
                </div>
                <div id="mes_amis">
                    <h1>Mes amis</h1>
                </div>
            </footer>
        </div>
    </body>
</html>