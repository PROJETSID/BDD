<!DOCTYPE html>



<!-- CODE PHP -->
<?php 

//Connexion à la base
include("db/connect.php");
include("test_connexion.php");

// Requête qui récupère les infos du joueur connecté
$requete_info_joueur = "SELECT J.experienceJ , Cat.nomCat, Cat.imageCat
FROM \"21400692\".Joueur J, \"21400692\".CategorieJoueur Cat
WHERE J.idcat = Cat.idcat
AND J.pseudoJ = 'Joueur27' "; 

$sql = oci_parse($dbConn, $requete_info_joueur);


if (!oci_execute($sql) ){
   $err = oci_error($sql);
  //Affichage du message d'erreur dans une fenêtre alert
   echo"<script language=\"javascript\">";
   echo" alert(\" ".htmlentities($err['message'])." \") ;";
   echo "history.back();";
   echo"</script>";
}else { 
   //Lecture des lignes du résultats
   while( oci_fetch($sql) )
   {
      $experience  = oci_result($sql, 1); 
      $nomcat  = oci_result($sql, 2); 
      $imagecat   = oci_result($sql, 3); 
   }
};
   

?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Jeu</title>
        <link rel="stylesheet" href="style.css" />
		<?php
		    include("head.php");
		?>
    </head>

    <body >
      <div>
        Bienvenue dans ton profil 
      </div>

      <div>
          Expérience : <?php echo  $experience ; ?>
      </div>

      <div>
      Catégorie : <?php echo $nomcat ; ?>
      </div>

      <div>
         <img src = "<?php echo $imagecat ; ?>">
         <?php echo $imagecat ?>
      </div>


    </body>

</html>
