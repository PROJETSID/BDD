--supprime la s�quence et les donn�es de la table (pour chaque table)
drop sequence Seq_CategorieJoueur_idCat;
delete from CategorieJoueur;
CREATE SEQUENCE Seq_CategorieJoueur_idCat START WITH 1 INCREMENT BY 1 NOCYCLE;