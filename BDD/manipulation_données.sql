--supprime la séquence et les données de la table (pour chaque table)
drop sequence Seq_CategorieJoueur_idCat;
delete from CategorieJoueur;
CREATE SEQUENCE Seq_CategorieJoueur_idCat START WITH 1 INCREMENT BY 1 NOCYCLE;