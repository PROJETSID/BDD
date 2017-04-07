--supprime la séquence et les données de la table (pour chaque table)
drop sequence Seq_CategorieJoueur_idCat;
delete from CategorieJoueur;
CREATE SEQUENCE Seq_CategorieJoueur_idCat START WITH 1 INCREMENT BY 1 NOCYCLE;



--création d'une partie (partie, combinaison, ligne, proposition joueur, jouer, historique)
--7ème historique pour le joueur 1
Insert into Historique
values (7,1);
--partie
Insert into Partie
values (1,0,'07/04/2017',0,1,1);
--combinaison
Insert into Combinaison
values (1,1,1);
Insert into Combinaison
values (2,1,3);
Insert into Combinaison
values (3,1,2);
Insert into Combinaison
values (4,1,4);
--ligne1
Insert into Ligne
values (7,1,'07/04/2017',0,0,1,1);
--ligne2
Insert into Ligne
values (11,2,'07/04/2017',0,0,1,1);
--proposition joueur
--contenu ligne1
Insert into Proposition_Joueur
values (1,7,1);
Insert into Proposition_Joueur
values (2,7,3);
Insert into Proposition_Joueur
values (3,7,2);
Insert into Proposition_Joueur
values (4,7,4);
--contenu ligne2
Insert into Proposition_Joueur
values (1,11,1);
Insert into Proposition_Joueur
values (2,11,3);
Insert into Proposition_Joueur
values (3,11,2);
Insert into Proposition_Joueur
values (4,11,4);
--jouer
Insert into Jouer
values (1,1);



--test
set SERVEROUTPUT ON;
Select Rejouer(1,1) from dual;
