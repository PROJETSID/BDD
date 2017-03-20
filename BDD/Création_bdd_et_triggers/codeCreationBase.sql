 ---------------------------------------------------------------
 --        Script Oracle.  
 ---------------------------------------------------------------


------------------------------------------------------------
-- Table: Historique
------------------------------------------------------------
CREATE TABLE Historique(
	idHistorique  NUMBER NOT NULL  ,
	idJoueur      NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Historique_Pk PRIMARY KEY (idHistorique)
);

------------------------------------------------------------
-- Table: Partie
------------------------------------------------------------
CREATE TABLE Partie(
	idPartie      NUMBER NOT NULL ,
	scoreP        NUMBER(10,0)  NOT NULL default 0 ,
	dateP         DATE  NOT NULL  ,
	resultatP     NUMBER (1) NOT NULL default 0 ,
	idHistorique  NUMBER(10,0)  NOT NULL  ,
	idNiveau      NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Partie_Pk PRIMARY KEY (idPartie) ,
	CONSTRAINT CHK_BOOLEAN_resultatP CHECK (resultatP IN (0,1))
);

------------------------------------------------------------
-- Table: Joueur 
------------------------------------------------------------
CREATE TABLE Joueur(
	idJoueur     NUMBER NOT NULL ,
	pseudoJ      VARCHAR2 (25)NOT NULL  ,
	experienceJ  NUMBER(10,0)  NOT NULL default 0 ,
	motDePasseJ  VARCHAR2 (25) NOT NULL  ,
	idCat        NUMBER(10,0)  NOT NULL default 1 ,
	CONSTRAINT Joueur_Pk PRIMARY KEY (idJoueur) ,
	CONSTRAINT Joueur_Uniq UNIQUE (pseudoJ)
);

------------------------------------------------------------
-- Table: Ligne
------------------------------------------------------------
CREATE TABLE Ligne(
	idLigneL        NUMBER NOT NULL ,
	numeroL         NUMBER(10,0)  NOT NULL  ,
	tempsLigneL     DATE  NOT NULL  ,
	nbIndiceRougeL  VARCHAR2 (25) NOT NULL  ,
	nbIndiceBlancL  VARCHAR2 (25) NOT NULL  ,
	idPartie        NUMBER(10,0)  NOT NULL  ,
	idJoueur        NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Ligne_Pk PRIMARY KEY (idLigneL)
);

------------------------------------------------------------
-- Table: Niveau
------------------------------------------------------------
CREATE TABLE Niveau(
	idNiveau         NUMBER NOT NULL ,
	seuilExpN        NUMBER(10,0)  NOT NULL  ,
	nbEmplacementsN  NUMBER(10,0)  NOT NULL  ,
	timerN           DATE  NOT NULL  ,
	idCollection     NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Niveau_Pk PRIMARY KEY (idNiveau)
);

------------------------------------------------------------
-- Table: CategorieJoueur
------------------------------------------------------------
CREATE TABLE CategorieJoueur(
	idCat     NUMBER NOT NULL ,
	nomCat    VARCHAR2 (25) NOT NULL  ,
	imageCat  VARCHAR2 (100) NOT NULL  ,
	CONSTRAINT CategorieJoueur_Pk PRIMARY KEY (idCat)
);

------------------------------------------------------------
-- Table: Bille
------------------------------------------------------------
CREATE TABLE Bille(
	idBille  NUMBER NOT NULL ,
	urlB     VARCHAR2 (100) NOT NULL  ,
	CONSTRAINT Bille_Pk PRIMARY KEY (idBille)
);

------------------------------------------------------------
-- Table: Collection
------------------------------------------------------------
CREATE TABLE Collection(
	idCollection   NUMBER NOT NULL ,
	nomCol         VARCHAR2 (25) NOT NULL  ,
	nbBillesCol    NUMBER(10,0)  NOT NULL  ,
	difficulteCol  NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Collection_Pk PRIMARY KEY (idCollection)
);

------------------------------------------------------------
-- Table: Jouer
------------------------------------------------------------
CREATE TABLE Jouer(
	idPartie  NUMBER(10,0)  NOT NULL  ,
	idJoueur  NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Jouer_Pk PRIMARY KEY (idPartie,idJoueur)
);

------------------------------------------------------------
-- Table: Composer
------------------------------------------------------------
CREATE TABLE Composer(
	idBille       NUMBER(10,0)  NOT NULL  ,
	idCollection  NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Composer_Pk PRIMARY KEY (idBille,idCollection)
);

------------------------------------------------------------
-- Table: Proposition Joueur
------------------------------------------------------------
CREATE TABLE Proposition_Joueur(
	positionBilleLigne  NUMBER(10,0)  NOT NULL  ,
	idLigneL            NUMBER(10,0)  NOT NULL  ,
	idBille             NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Proposition_Joueur_Pk PRIMARY KEY (idLigneL,idBille)
);

------------------------------------------------------------
-- Table: Debloquer
------------------------------------------------------------
CREATE TABLE Debloquer(
	idJoueur  NUMBER(10,0)  NOT NULL  ,
	idNiveau  NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Debloquer_Pk PRIMARY KEY (idJoueur,idNiveau)
);

------------------------------------------------------------
-- Table: Combinaison
------------------------------------------------------------
CREATE TABLE Combinaison(
	positionBilleCombinaison  NUMBER(10,0)   ,
	idPartie                  NUMBER(10,0)  NOT NULL  ,
	idBille                   NUMBER(10,0)  NOT NULL  ,
	CONSTRAINT Combinaison_Pk PRIMARY KEY (idPartie,idBille)
);




ALTER TABLE Historique ADD FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);
ALTER TABLE Partie ADD FOREIGN KEY (idHistorique) REFERENCES Historique(idHistorique);
ALTER TABLE Partie ADD FOREIGN KEY (idNiveau) REFERENCES Niveau(idNiveau);
ALTER TABLE Joueur ADD FOREIGN KEY (idCat) REFERENCES CategorieJoueur(idCat);
ALTER TABLE Ligne ADD FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);
ALTER TABLE Ligne ADD FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);
ALTER TABLE Niveau ADD FOREIGN KEY (idCollection) REFERENCES Collection(idCollection);
ALTER TABLE Jouer ADD FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);
ALTER TABLE Jouer ADD FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);
ALTER TABLE Composer ADD FOREIGN KEY (idBille) REFERENCES Bille(idBille);
ALTER TABLE Composer ADD FOREIGN KEY (idCollection) REFERENCES Collection(idCollection);
ALTER TABLE Proposition_Joueur ADD FOREIGN KEY (idLigneL) REFERENCES Ligne(idLigneL);
ALTER TABLE Proposition_Joueur ADD FOREIGN KEY (idBille) REFERENCES Bille(idBille);
ALTER TABLE Debloquer ADD FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);
ALTER TABLE Debloquer ADD FOREIGN KEY (idNiveau) REFERENCES Niveau(idNiveau);
ALTER TABLE Combinaison ADD FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);
ALTER TABLE Combinaison ADD FOREIGN KEY (idBille) REFERENCES Bille(idBille);

CREATE SEQUENCE Seq_Historique_idHistorique START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Partie_idPartie START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Joueur_idJoueur START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Ligne_idLigneL START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Niveau_idNiveau START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_CategorieJoueur_idCat START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Bille_idBille START WITH 1 INCREMENT BY 1 NOCYCLE;
CREATE SEQUENCE Seq_Collection_idCollection START WITH 1 INCREMENT BY 1 NOCYCLE;


CREATE OR REPLACE TRIGGER Historique_idHistorique
	BEFORE INSERT ON Historique 
  FOR EACH ROW 
	WHEN (NEW.idHistorique IS NULL) 
	BEGIN
		 select Seq_Historique_idHistorique.NEXTVAL INTO :NEW.idHistorique from DUAL; 
	END;
CREATE OR REPLACE TRIGGER Partie_idPartie
	BEFORE INSERT ON Partie 
  FOR EACH ROW 
	WHEN (NEW.idPartie IS NULL) 
	BEGIN
		 select Seq_Partie_idPartie.NEXTVAL INTO :NEW.idPartie from DUAL; 
	END;
CREATE OR REPLACE TRIGGER Joueur_idJoueur
	BEFORE INSERT ON Joueur 
  FOR EACH ROW 
	WHEN (NEW.idJoueur IS NULL) 
	BEGIN
		 select Seq_Joueur_idJoueur.NEXTVAL INTO :NEW.idJoueur from DUAL; 
	END;
CREATE OR REPLACE TRIGGER Ligne_idLigneL
	BEFORE INSERT ON Ligne 
  FOR EACH ROW 
	WHEN (NEW.idLigneL IS NULL) 
	BEGIN
		 select Seq_Ligne_idLigneL.NEXTVAL INTO :NEW.idLigneL from DUAL; 
	END;
CREATE OR REPLACE TRIGGER Niveau_idNiveau
	BEFORE INSERT ON Niveau 
  FOR EACH ROW 
	WHEN (NEW.idNiveau IS NULL) 
	BEGIN
		 select Seq_Niveau_idNiveau.NEXTVAL INTO :NEW.idNiveau from DUAL; 
	END;
CREATE OR REPLACE TRIGGER CategorieJoueur_idCat
	BEFORE INSERT ON CategorieJoueur 
  FOR EACH ROW 
	WHEN (NEW.idCat IS NULL) 
	BEGIN
		 select Seq_CategorieJoueur_idCat.NEXTVAL INTO :NEW.idCat from DUAL; 
	END;
CREATE OR REPLACE TRIGGER Bille_idBille
	BEFORE INSERT ON Bille 
  FOR EACH ROW 
	WHEN (NEW.idBille IS NULL) 
	BEGIN
		 select Seq_Bille_idBille.NEXTVAL INTO :NEW.idBille from DUAL; 
	END;
CREATE OR REPLACE TRIGGER Collection_idCollection
	BEFORE INSERT ON Collection 
  FOR EACH ROW 
	WHEN (NEW.idCollection IS NULL) 
	BEGIN
		 select Seq_Collection_idCollection.NEXTVAL INTO :NEW.idCollection from DUAL; 
	END;

