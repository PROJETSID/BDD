
drop table Jouer;
drop table Proposition_Joueur;
drop table Debloquer;
drop table Combinaison;
drop table Ligne;
drop table Partie;
drop table Joueur;
drop table Niveau;	
drop table CategorieJoueur;
drop table Historique;
drop table Bille;
drop table Collection;


 ---------------------------------------------------------------
 --    	Script Oracle.  
 ---------------------------------------------------------------

--Renommer les contraintes : Type Contrainte_ Nom de la table _ Nom attribut
------------------------------------------------------------
-- Table: Historique
------------------------------------------------------------
CREATE TABLE Historique(
    idHistorique  NUMBER   ,
    CONSTRAINT Pk_Historique_idHistorique PRIMARY KEY (idHistorique)
);

------------------------------------------------------------
-- Table: Partie
------------------------------------------------------------
CREATE TABLE Partie(
    idPartie  	NUMBER   ,
    scoreP    	NUMBER(10,0),
    dateP	DATE,
    resultatP 	NUMBER (1)    ,
    idHistorique  NUMBER(10,0),
    idNiveau  	NUMBER(10,0),
    CONSTRAINT Pk_Partie_idPartie PRIMARY KEY (idPartie) ,
    CONSTRAINT Ck_resultatP CHECK (resultatP IN (0,1))
);

------------------------------------------------------------
-- Table: Joueur
------------------------------------------------------------
CREATE TABLE Joueur(
    idJoueur 	NUMBER   ,
    pseudoJ  	VARCHAR2 (25) UNIQUE  ,
    experienceJ  NUMBER(10,0)  DEFAULT 0  ,
    motDePasseJ  VARCHAR2 (25)    ,
    idCat    	NUMBER(10,0) DEFAULT 0,
    CONSTRAINT Pk_Joueur_idJoueur PRIMARY KEY (idJoueur) ,
    CONSTRAINT Ck_Joueur_motdePasseJ CHECK (LENGTH(motDePasseJ) >= 8) ,
    CONSTRAINT Ck_Joueur_pseudoJ CHECK (LENGTH(pseudoJ) >= 2)
);

------------------------------------------------------------
-- Table: Ligne
------------------------------------------------------------
CREATE TABLE Ligne(
    idLigneL 	NUMBER   ,
    numeroL  	NUMBER(10,0),
    tempsLigneL  DATE,
    idPartie 	NUMBER(10,0),
    idJoueur 	NUMBER(10,0),

    CONSTRAINT PK_Ligne_idLigneL PRIMARY KEY (idLigneL)
);

------------------------------------------------------------
-- Table: Niveau
------------------------------------------------------------
CREATE TABLE Niveau(
    idNiveau	NUMBER   ,
    seuilExpN    	NUMBER(10,0),
    nbEmplacementsN  NUMBER(10,0),
    timerN  	DATE,
    idCollection 	NUMBER(10,0),
    CONSTRAINT Pk_Niveau_idNiveau PRIMARY KEY (idNiveau)
);

------------------------------------------------------------
-- Table: CategorieJoueur
------------------------------------------------------------
CREATE TABLE CategorieJoueur(
    idCat 	NUMBER   ,
    nomCat	VARCHAR2 (25)    ,
    imageCat  VARCHAR2 (25)    ,
    CONSTRAINT Pk_CategorieJoueur_idCat PRIMARY KEY (idCat)
);

------------------------------------------------------------
-- Table: Bille
------------------------------------------------------------
CREATE TABLE Bille(
    idBilles  NUMBER   ,
    urlB  	VARCHAR2 (25)    ,
    CONSTRAINT Pk_Bille_idBilles PRIMARY KEY (idBilles)
);

------------------------------------------------------------
-- Table: Collection
------------------------------------------------------------
CREATE TABLE Collection(
    idCollection    	NUMBER   ,
    nomCol	VARCHAR2 (25)    ,
    nbBillesCol	NUMBER(10,0),
    difficulteBilleCol  NUMBER(10,0),
    CONSTRAINT Pk_Collection_idCollection PRIMARY KEY (idCollection)
);

------------------------------------------------------------
-- Table: Jouer
------------------------------------------------------------
CREATE TABLE Jouer(
    idPartie  NUMBER(10,0),
    idJoueur  NUMBER(10,0),
    CONSTRAINT Pk_Jouer_idPartie_idJoueur PRIMARY KEY (idPartie,idJoueur)
);

------------------------------------------------------------
-- Table: Composer
------------------------------------------------------------
CREATE TABLE Composer(
    idBilles  	NUMBER(10,0),
    idCollection  NUMBER(10,0),
    CONSTRAINT Pk_Composer_idBi_Col PRIMARY KEY (idBilles,idCollection)
);

------------------------------------------------------------
-- Table: Proposition Joueur
------------------------------------------------------------
CREATE TABLE Proposition_Joueur(
    positionBilleLigne  NUMBER(10,0),
    idLigneL   	NUMBER(10,0),
    idBilles   	NUMBER(10,0),
    CONSTRAINT Proposition_Joueur_Pk PRIMARY KEY (idLigneL,idBilles)
);

------------------------------------------------------------
-- Table: Debloquer
------------------------------------------------------------
CREATE TABLE Debloquer(
    idJoueur  NUMBER(10,0),
    idNiveau  NUMBER(10,0),
    CONSTRAINT Pk_Debloquer_idJoueur_idNiveau PRIMARY KEY (idJoueur,idNiveau)
);

------------------------------------------------------------
-- Table: Combinaison
------------------------------------------------------------
CREATE TABLE Combinaison(
    positionBilleCombinaison  NUMBER(10,0)   ,
    idPartie    	NUMBER(10,0),
    idBilles    	NUMBER(10,0),
    CONSTRAINT Pk_Combinaison_idP_idB PRIMARY KEY (idPartie,idBilles)
);




ALTER TABLE Partie ADD CONSTRAINT FK_Partie_idHistorique FOREIGN KEY (idHistorique) REFERENCES Historique(idHistorique);

ALTER TABLE Partie ADD CONSTRAINT FK_Partie_idNiveau FOREIGN KEY (idNiveau) REFERENCES Niveau(idNiveau);

ALTER TABLE Joueur ADD CONSTRAINT FK_Joueur_idCat FOREIGN KEY (idCat) REFERENCES CategorieJoueur(idCat);

ALTER TABLE Ligne ADD CONSTRAINT FK_Ligne_idPartie FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);

ALTER TABLE Ligne ADD CONSTRAINT FK_Ligne_idJoueur FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);

ALTER TABLE Niveau ADD CONSTRAINT FK_Niveau_idCollection FOREIGN KEY (idCollection) REFERENCES Collection(idCollection);

ALTER TABLE Jouer ADD CONSTRAINT FK_Jouer_idPartie FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);

ALTER TABLE Jouer ADD CONSTRAINT FK_Jouer_idJoueur FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);

ALTER TABLE Composer ADD CONSTRAINT FK_Composer_idBilles FOREIGN KEY (idBilles) REFERENCES Bille(idBilles);

ALTER TABLE Composer ADD CONSTRAINT FK_Composer_idCollection FOREIGN KEY (idCollection) REFERENCES Collection(idCollection);

ALTER TABLE Proposition_Joueur ADD CONSTRAINT FK_Proposition_Joueur_idLigneL FOREIGN KEY (idLigneL) REFERENCES Ligne(idLigneL);

ALTER TABLE Proposition_Joueur ADD CONSTRAINT FK_Proposition_Joueur_idBilles FOREIGN KEY (idBilles) REFERENCES Bille(idBilles);

ALTER TABLE Debloquer ADD CONSTRAINT FK_Debloquer_idJoueur FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);
ALTER TABLE Debloquer ADD CONSTRAINT FK_Debloquer_idNiveau FOREIGN KEY (idNiveau) REFERENCES Niveau(idNiveau);

ALTER TABLE Combinaison ADD CONSTRAINT FK_Combinaison_idPartie FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);

ALTER TABLE Combinaison ADD CONSTRAINT FK_Combinaison_idBilles FOREIGN KEY (idBilles) REFERENCES Bille(idBilles);



CREATE SEQUENCE Seq_Historique_idHistorique START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Partie_idPartie START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Joueur_idJoueur START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Ligne_idLigneL START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Niveau_idNiveau START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_CategorieJoueur_idCat START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Bille_idBilles START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Collection_idCollection START WITH 1 INCREMENT BY 1 NOCYCLE;

