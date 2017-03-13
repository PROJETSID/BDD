#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Historique
#------------------------------------------------------------

CREATE TABLE Historique(
        idHistorique int (11) Auto_increment  NOT NULL ,
        PRIMARY KEY (idHistorique )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Partie
#------------------------------------------------------------

CREATE TABLE Partie(
        idPartie     int (11) Auto_increment  NOT NULL ,
        scoreP       Int NOT NULL ,
        dateP        Date NOT NULL ,
        resultatP    Bool NOT NULL ,
        idHistorique Int NOT NULL ,
        idNiveau     Int NOT NULL ,
        PRIMARY KEY (idPartie )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Joueur 
#------------------------------------------------------------

CREATE TABLE Joueur(
        idJoueur    int (11) Auto_increment  NOT NULL ,
        pseudoJ     Varchar (25) NOT NULL ,
        experienceJ Varchar (25) NOT NULL ,
        motDePasseJ Varchar (25) NOT NULL ,
        idCat       Int NOT NULL ,
        PRIMARY KEY (idJoueur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Ligne
#------------------------------------------------------------

CREATE TABLE Ligne(
        idLigneL    int (11) Auto_increment  NOT NULL ,
        numeroL     Int NOT NULL ,
        tempsLigneL Date NOT NULL ,
        idPartie    Int NOT NULL ,
        idJoueur    Int NOT NULL ,
        PRIMARY KEY (idLigneL )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Niveau
#------------------------------------------------------------

CREATE TABLE Niveau(
        idNiveau        int (11) Auto_increment  NOT NULL ,
        seuilExpN       Int NOT NULL ,
        nbEmplacementsN Int NOT NULL ,
        tempsN          Date NOT NULL ,
        idCollection    Int NOT NULL ,
        PRIMARY KEY (idNiveau )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: CategorieJoueur
#------------------------------------------------------------

CREATE TABLE CategorieJoueur(
        idCat    int (11) Auto_increment  NOT NULL ,
        nomCat   Varchar (25) NOT NULL ,
        imageCat Varchar (25) NOT NULL ,
        PRIMARY KEY (idCat )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Bille
#------------------------------------------------------------

CREATE TABLE Bille(
        idBilles int (11) Auto_increment  NOT NULL ,
        urlB     Varchar (25) NOT NULL ,
        PRIMARY KEY (idBilles )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Collection
#------------------------------------------------------------

CREATE TABLE Collection(
        idCollection  int (11) Auto_increment  NOT NULL ,
        nomCol        Varchar (25) NOT NULL ,
        nbBillesCol   Int NOT NULL ,
        diffBillesCol Int NOT NULL ,
        PRIMARY KEY (idCollection )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Jouer
#------------------------------------------------------------

CREATE TABLE Jouer(
        idPartie Int NOT NULL ,
        idJoueur Int NOT NULL ,
        PRIMARY KEY (idPartie ,idJoueur )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Composer
#------------------------------------------------------------

CREATE TABLE Composer(
        idBilles     Int NOT NULL ,
        idCollection Int NOT NULL ,
        PRIMARY KEY (idBilles ,idCollection )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Composer de
#------------------------------------------------------------

CREATE TABLE Composer_de(
        idLigneL Int NOT NULL ,
        idBilles Int NOT NULL ,
        PRIMARY KEY (idLigneL ,idBilles )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Debloquer
#------------------------------------------------------------

CREATE TABLE Debloquer(
        idJoueur Int NOT NULL ,
        idNiveau Int NOT NULL ,
        PRIMARY KEY (idJoueur ,idNiveau )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Combinaison
#------------------------------------------------------------

CREATE TABLE Combinaison(
        positionBilleCombinaison Int ,
        idPartie                 Int NOT NULL ,
        idBilles                 Int NOT NULL ,
        PRIMARY KEY (idPartie ,idBilles )
)ENGINE=InnoDB;

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
ALTER TABLE Composer_de ADD CONSTRAINT FK_Composer_de_idLigneL FOREIGN KEY (idLigneL) REFERENCES Ligne(idLigneL);
ALTER TABLE Composer_de ADD CONSTRAINT FK_Composer_de_idBilles FOREIGN KEY (idBilles) REFERENCES Bille(idBilles);
ALTER TABLE Debloquer ADD CONSTRAINT FK_Debloquer_idJoueur FOREIGN KEY (idJoueur) REFERENCES Joueur(idJoueur);
ALTER TABLE Debloquer ADD CONSTRAINT FK_Debloquer_idNiveau FOREIGN KEY (idNiveau) REFERENCES Niveau(idNiveau);
ALTER TABLE Combinaison ADD CONSTRAINT FK_Combinaison_idPartie FOREIGN KEY (idPartie) REFERENCES Partie(idPartie);
ALTER TABLE Combinaison ADD CONSTRAINT FK_Combinaison_idBilles FOREIGN KEY (idBilles) REFERENCES Bille(idBilles);
