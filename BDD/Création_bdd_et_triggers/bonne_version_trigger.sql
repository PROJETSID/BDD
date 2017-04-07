--INSERTION joueur : insertion du niveau 1 dans la table debloquer
CREATE OR REPLACE TRIGGER tai_Joueur AFTER
  INSERT ON Joueur FOR EACH ROW BEGIN
  INSERT INTO Debloquer VALUES
    (:NEW.idJoueur,1);
END;
/
-- Code : OK ! 


-- Procédure d'insertion d'une partie
CREATE OR REPLACE PROCEDURE INSERTION_PARTIE(pIdjoueur JOUEUR.Idjoueur%TYPE, pidNiveau NIVEAU.idNiveau%TYPE) IS

-- Declaration de variables
vIdhistorique HISTORIQUE.IdHistorique%TYPE;
vIdpartie PARTIE.Idpartie%TYPE;
ecode NUMBER ;
emesg VARCHAR(20);


-- Debut de la procédure
BEGIN

-- On récupère le dernier id_historique pour le joueur
SELECT max(idhistorique) INTO vIdhistorique
FROM HISTORIQUE
WHERE Idjoueur = pIdjoueur ;

IF vIdhistorique IS NULL THEN
vIdhistorique := 0 ;
END IF;

-- Insertion dans historique : doit avoir lieu avant l'insertion dans partie
INSERT INTO HISTORIQUE VALUES (vIdhistorique,pidjoueur);


-- Insertion dans partie
INSERT INTO PARTIE(Idpartie,datep, idhistorique, idniveau) VALUES
(SEQ_PARTIE_IDPARTIE.nextval, sysdate, vIdhistorique, pidNiveau);


-- On récupère le idpartie correspondant au bon historique stocké
SELECT P.IDpartie INTO vIdpartie
FROM partie P, historique H
WHERE P.IdHistorique = H.IdHistorique
AND H.Idjoueur = pIdJoueur
AND H.IdHistorique = vIdhistorique;


-- Insertion dans la table JOUER
INSERT INTO JOUER VALUES (vIdpartie, pIdJoueur);


--Gestion des exceptions
EXCEPTION
WHEN OTHERS THEN
  ecode := SQLCODE;
  emesg := SQLERRM;
  DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
  ROLLBACK;
END;


--PROCEDURE INSERTION_JOUEUR
CREATE OR REPLACE PROCEDURE INSERTION_JOUEUR(pPseudoJ Joueur.PseudoJ%TYPE, 
pmotdepasseJ JOUEUR.MOTDEPASSEJ%TYPE) IS

    ecode                     NUMBER;
    emesg                     VARCHAR(20);

BEGIN 
INSERT INTO JOUEUR(IDJOUEUR,PSEUDOJ, MOTDEPASSEJ) VALUES (SEQ_JOUEUR_IDJOUEUR.nextval,
pPseudoJ, pmotdepasseJ);

EXCEPTION
      -- Gestion des autres erreurs possibles
WHEN OTHERS THEN
  ecode := SQLCODE;
  emesg := SQLERRM;
  DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
  ROLLBACK;
END;
/
-- Code : OK ! 




-- Création d'une partie : Ajout de la ligne numero un dans la table ligne pour le joueur
-- Commentaire : Insertion de la ligne devrait se faire une fois que le joueur clique sur le le bouton try it

CREATE OR REPLACE TRIGGER t_a_i_Partie AFTER
  INSERT ON Partie FOR EACH Row 
  DECLARE vidJoueur Jouer.idJoueur%TYPE;

  BEGIN
    --Selection de l'id du joueur qui a creee la partie
    SELECT idJoueur
    INTO vidJoueur
    FROM Jouer
    WHERE Jouer.idPartie = :new.idpartie;
  
    IF vidJoueur IS NULL THEN
    RAISE_APPLICATION_ERROR(-20010,'La partie n_existe pas');
    END IF ; 
    --Insertion de la premiere ligne
    INSERT
    INTO Ligne VALUES
      (
        Seq_Ligne_idLigneL.nextval,
        1,
        sysdate,
        '',
        '',
        :new.idpartie,
        vidJoueur
      );
END;
/
  -- Code : OK ! 

  
  
  
  
  -- Trigger :  Verifier que le nombre de billes jouables soit superieur
  -- ou egal au nombre d'emplacements
CREATE OR REPLACE TRIGGER t_b_i_Partie BEFORE
  INSERT ON Partie FOR EACH ROW
  
    -- Declaration des variables
    DECLARE vnbBilles NUMBER;
  vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;
  
  BEGIN
    -- Nombre de Billes a disposition du joueur
    SELECT COUNT(DISTINCT idBille)
    INTO vnbBilles
    FROM Collection Col,
      Composer Comp,
      Niveau Niv
    WHERE Col.idCollection = Comp.idCollection
    AND Col.idCollection   = Niv.idCollection
    AND Niv.idNiveau       = :NEW.idNiveau;
    
    -- Nombre d'emplacements pour le niveau
    SELECT nbEmplacementsN
    INTO vnbEmplacementsN
    FROM Niveau
    WHERE idNiveau      = :NEW.idNiveau;
    IF vnbEmplacementsN > vnbBilles THEN
      ROLLBACK;
      RAISE_APPLICATION_ERROR(-20004,'Trop peu de billes');
    END IF;
  END ;
  /
  -- Code : OK ! 






  -- PROCEDURE : Creer une combinaison avec aucune bille en double
CREATE OR REPLACE PROCEDURE P_creation_combinaison(
    pidPartie Partie.idPartie%TYPE) IS

    vidCollection Collection.idCollection%TYPE;
    vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;
    vNiveau Niveau.idNiveau%TYPE;
    nbidPartie NUMBER;
    ecode                     NUMBER;
    emesg                     VARCHAR(20);
    vidPartie                 NUMBER;
    flag                      NUMBER;
    E_partie_a_combinaison    EXCEPTION;
    cle_etrangere_combinaison EXCEPTION;
    PB_CLE_ETRANGERE EXCEPTION;
    i NUMBER := 1;
    
  BEGIN
    -- Une partie ne peut contenir qu'une seule combinaison. Il faut donc verifier
    -- que la partie n'ait pas de combinaison.
    SELECT DISTINCT COUNT(C.idPartie)
    INTO nbidPartie
    FROM Combinaison C
    WHERE C.idPartie = nbidPartie;
    IF nbidPartie   != 0 THEN
      RAISE E_partie_a_combinaison;
    END IF;
    
      -- Retrouver le niveau correspondant � la partie
      SELECT P.idNiveau
      INTO vNiveau
      FROM Partie P
      WHERE P.idPartie = pidPartie ;
      -- Selection de la bonne collection de billes pour le niveau et du nombre d'emplacements
      SELECT Niv.idCollection,
        Niv.nbEmplacementsN
      INTO vidCollection,
        vnbEmplacementsN
      FROM Niveau Niv
      WHERE Niv.idNiveau = vNiveau ;
      
-- Curseur permettant de selectionner le bon nombre d'identifiants de billes selon le niveau
  FOR c1_ligne IN
  (SELECT idBille
  FROM
    (SELECT B.idBille
    FROM Bille B,
      Composer Comp
    WHERE B.idBille       = Comp.idBille
    AND Comp.idCollection = vidCollection
    ORDER BY dbms_random.value
    )
  WHERE rownum <= vnbEmplacementsN
  )
  LOOP
    -- Gestion de l'insertion dans la table Combinaison
    INSERT
    INTO Combinaison VALUES
      (
        i,
        pidPartie,
        c1_ligne.idBille
      );
      -- Gere la position de la bille, on peut se passer de la sequence
      i := i+1;
  END LOOP ;  
COMMIT;

  -- Gestion des erreurs
EXCEPTION
  -- Une partie ne peut avoir qu'une seule et unique combinaison
WHEN E_partie_a_combinaison THEN
  DBMS_OUTPUT.PUT_LINE('Une combinaison existe deja pour la partie renseignee');
  
  -- Une bille ne peut etre utilisee qu'une seule fois dans la combinaison pour chaque partie
  -- (probleme de cle primaire)
WHEN DUP_VAL_ON_INDEX THEN
  DBMS_OUTPUT.PUT_LINE('La bille est deja utilisee dans la combinaison pour cette partie');
 
  -- Probleme de cle etrangere : la bille ou la partie n'existe pas (lors du insert)
WHEN PB_CLE_ETRANGERE THEN
  IF (SQLERRM LIKE '%FK_Combinaison_idBilles%') THEN
    DBMS_OUTPUT.PUT_LINE('La bille n existe pas');
  ELSIF (SQLERRM LIKE '%FK_Combinaison_idPartie%') THEN
      DBMS_OUTPUT.PUT_LINE('La partie n existe pas');
  END IF;
  
      -- Gestion des autres erreurs possibles
WHEN OTHERS THEN
  ecode := SQLCODE;
  emesg := SQLERRM;
  DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
  ROLLBACK;
END;
/

-- Code : Ok ! 





 --Une ligne doit etre completement remplie pour pouvoir etre soumise

CREATE OR REPLACE PROCEDURE Test_Ligne_Complete(pidPartie Partie.idPartie%TYPE)
     IS
     
      vnbEmplacements NUMBER;
      vnbBilles       NUMBER;
      ligne_incomplete EXCEPTION;
      
    BEGIN
      --on recupere le nombre d'emplacement disponible pour un niveau
      SELECT Niv.nbEmplacementsN INTO vnbEmplacements
      FROM Niveau Niv, Partie P
      WHERE Niv.idNiveau = P.idNiveau
      AND P.idPartie     = pidPartie;
      
      --on recupere le nombre de billes place sur la ligne pour une partie
      SELECT COUNT(PropJ.idBille) INTO vnbBilles
      FROM Proposition_Joueur Propj, Ligne L
      WHERE L.idPartie = pidPartie
      AND L.idLigneL    = Propj.idLigneL
      AND L.numeroL    =
        (SELECT MAX(L.numeroL) FROM Ligne L,Proposition_Joueur Propj
              WHERE L.idPartie = pidPartie
              AND L.idLigneL    = Propj.idLigneL
        );
        
        
      IF(vnbEmplacements-vnbBilles >= 0)THEN
      RAISE ligne_incomplete ;
      END IF; 
      
      EXCEPTION 
      WHEN ligne_incomplete THEN
        DBMS_OUTPUT.PUT_LINE('La Ligne n est pas complete !');
     END ;
    /


-- Code : OK ! 




-- Trigger : le joueur ne peut plus jouer pendant 4h si il a perdu 5 parties en une heure
-- Commentaire : Il fallait absolument récupérer l'identifiant du joueur pour que le trigger s'exécute

CREATE OR REPLACE TRIGGER tbi_Partie 
  BEFORE INSERT ON Partie 
  FOR EACH ROW 
  DECLARE CURSOR C(PidJoueur Joueur.idJoueur%TYPE) IS
  -- Curseur selectionnant toutes les parties que le joueur a perdu
    (SELECT P.dateP
    FROM Partie P, jouer J
    WHERE P.resultatP= 0
    AND J.idPartie  = P.idPartie
    AND J.idJoueur   = PidJoueur)
    ;
  vnb  NUMBER := 0;
  vdate_der_partie DATE;
  vidJoueur Joueur.idJoueur%TYPE;

  
  BEGIN
  
  -- Selection de l'ID du Joueur
  SELECT J.idJoueur INTO vidJoueur
  FROM Jouer J
  WHERE J.idpartie = :NEW.idPartie;
  

    --Selection de la date de la derniere partie du joueur
    SELECT P.dateP
    INTO vdate_der_partie
    FROM Partie P, jouer J
    WHERE J.idPartie=P.idPartie
    AND J.idJoueur = vidJoueur
    AND P.idPartie  = 
    (SELECT MAX (J.idPartie) FROM JOUER J WHERE J.idjoueur = vidJoueur
      );
         
    -- Debut du curseur
    -- Pour toutes les parties du joueur : 
    -- on compte le nb de parties perdues en 1h
    
    FOR C_ligne IN C(vidJoueur) LOOP
      IF ( (vdate_der_partie - C_ligne.dateP) *86400 < 3600) THEN
        vnb := vnb +1; 
      END IF ; 
    END LOOP;
    
    -- Code interessant de selection de calcul de secondes entre deux dates
    --select (sysdate - cast('01-JAN-1970' as date)) * 86400 
    --from dual;
    
    -- Si 5 parties ont été perdu, alors le joueur ne peut pas jouer
    IF (vnb = 5) THEN
      IF ( :NEW.dateP < vdate_der_partie + 4*3600 ) THEN
        RAISE_APPLICATION_ERROR(-20040,'Vous ne pourrez plus jouer pendant un moment');
        END IF; 
      END IF ;
    END;
    /
    
-- Code : OK ! 




-- PROCEDURE les lignes doivent etre rejouees dans l'ordre
CREATE OR REPLACE PROCEDURE Rejouer(PidJoueur Joueur.idJoueur%TYPE,
  Pidpartie Partie.idPartie%TYPE)
  IS
    --une ligne
    CURSOR C1 IS
      SELECT L.idlignel, L.numerol, L.tempslignel, L.nbindicerougel,L.nbindiceblancl
      FROM Ligne L
      WHERE L.idPartie= Pidpartie
      AND L.idJoueur  = PidJoueur
      ORDER BY L.numeroL ; 
    --une proposition joueur
    CURSOR C2(PidLigne Ligne.idLigneL%TYPE)
    IS
      SELECT PJ.positionbilleligne, PJ.idbille, B.urlb
      FROM Proposition_Joueur PJ, Bille B
      WHERE PJ.idLigneL = PidLigne
      AND PJ.idbille = b.idBille
      ORDER BY Pj.positionBilleLigne
      ;
      retour Varchar;
  BEGIN
    FOR C1_ligne IN C1
    LOOP
    -- Affichage de l'ID de la ligne
      DBMS_OUTPUT.PUT_LINE(C1_ligne.idLigneL);
      
      -- Affichage de la position de la bille, de l'id de la bille 
      --- ainsi que de son URL
      FOR C2_LIGNE IN C2(C1_ligne.idLigneL)
      LOOP
        DBMS_OUTPUT.PUT_LINE(C2_ligne.positionbilleligne);
         DBMS_OUTPUT.PUT_LINE(C2_ligne.idBille);
          DBMS_OUTPUT.PUT_LINE(C2_ligne.urlB);
      END LOOP ;
    END LOOP ;
  END ;
/

-- Code : OK !! 


-- Trigger : Verifier que le joueur puisse bien jouer 
-- Commentaire : Il faudrait aussi vérifier si le joueur est bien 
-- dans le niveau débloquer
CREATE OR REPLACE TRIGGER t_b_iPartie 
  BEFORE INSERT ON Partie 
  FOR EACH ROW
 
  DECLARE
  vseuilN NUMBER;
  vexperience NUMBER;
  
  BEGIN
  
  -- Selection du seuil pour le niveau
    SELECT seuilExpN INTO vseuilN
    FROM Niveau 
    WHERE idNiveau = :NEW.idNiveau;
    
  -- Selection de l_experience du joueur
    SELECT experienceJ
    INTO vexperience
    FROM Jouer Joue,
      Joueur J
    WHERE joue.idPartie = :new.idPartie
    AND joue.idJoueur   = J.idJoueur ;
    
    IF vseuilN > vexperience THEN
      RAISE_APPLICATION_ERROR(-20031,'Le niveau n_est pas encore debloque');
    END IF;
  END ;
  
  
-- Code : OK !!!! 



--- TRIGGER : mode mutijoueur
CREATE OR REPLACE TRIGGER t_b_i_multiJ_Partie 
  BEFORE INSERT ON Partie 
  FOR EACH ROW 
  
  DECLARE 
  
  vnbJoueur NUMBER;
  vExpMinJoueur NUMBER;
  vseuilN NUMBER;
  
  BEGIN
    --- compter le nombre de joueur pour la nouvelle partie cree
    SELECT COUNT (distinct idJoueur)
    INTO vnbJoueur
    FROM Jouer
    WHERE idPartie=:new.idPartie;
    
    
    --- Partie multijoueur
    IF vnbJoueur > 1 THEN
      --- Experience minimun de tous les joueurs
      SELECT MIN(experienceJ)
      INTO vExpMinJoueur
      FROM Jouer Joue,
        Joueur J
      WHERE joue.idPartie = :new.idPartie
      AND joue.idJoueur   = J.idJoueur;
      
      --- Seuil requis pour le niveau nouvellement cree
      SELECT seuilexpN
      INTO vseuilN
      FROM Niveau
      WHERE idNiveau = :new.idNiveau;
      
      
      IF vseuilN   >= vExpMinJoueur THEN
        RAISE_APPLICATION_ERROR(-20032,'Niveau pas encore debloquer par tous les joueurs');
      END IF;
    END IF;
  END ;
  
  
  --Trigger : l'experience du joueur ne peux pas baisser
CREATE OR REPLACE TRIGGER t_b_u_expJ BEFORE
  UPDATE ON JOUEUR FOR EACH row BEGIN IF :OLD.experienceJ > :NEW.experienceJ THEN RAISE_APPLICATION_ERROR(-20033,'L EXPERIENCE DU Joueur NE PEUX PAS BAISSER');
END IF;
END;

---Trigger : la categorie du joueur ne peux pas baisser
CREATE OR REPLACE TRIGGER t_b_u_catJ BEFORE
  UPDATE ON JOUEUR FOR EACH row BEGIN IF :OLD.idCat > :NEW.idCat THEN RAISE_APPLICATION_ERROR(-20034,'La categorie du joueur ne peux pas baisser');
END IF;
END;

-- Trigger : Insertion dans debloquer si la partie est gagnee
CREATE OR REPLACE TRIGGER t_a_u_partie AFTER
  UPDATE ON partie FOR EACH ROW
    --Declaration de variables
    DECLARE vseuilExpN NUMBER;
  vNbIdJoueur          NUMBER;
  vidJoueur Jouer.idJoueur%TYPE;
  
  BEGIN
    -- compter IDJOUEUR DANS JOUER
    SELECT COUNT(IDJOUEUR)
    INTO vNbIdJoueur
    FROM JOUER
    WHERE idPartie = :New.idPartie ;
    -- Test pour voir si la partie a ete gagne et si le joueur n'a pas
    -- deja debloque tous les niveaux
    --est-ce que la partie est gagnee ?
    IF (:New.resultatP = 1 ) THEN
      --pour 1 joueur
      IF (vNbIdJoueur = 1) THEN
        SELECT J.idJoueur
        INTO vidJoueur
        FROM Jouer J
        WHERE J.idpartie       = :NEW.idPartie;
        IF (:New.idniveau + 1 <= 50) THEN
          --Selection du seuil pour le niveau � atteindre
          SELECT seuilExpN
          INTO vseuilExpN
          FROM Niveau
          WHERE idNiveau = :New.idniveau+1 ;
          --Update de l'exp du joueur
          UPDATE JOUEUR
          SET experienceJ = vseuilExpN
          WHERE idjoueur  = vidJoueur;
          -- Insertion dans debloquer
          INSERT
          INTO DEBLOQUER VALUES
            (
              vidJoueur,
              :New.idniveau + 1
            );
        ELSE
          IF (:New.idniveau         + 1 > 50) THEN
            RAISE_APPLICATION_ERROR(-20030,'Le joueur a debloque tous les niveaux');
          END IF;
          --pour 2 joueur
          -- ELSE
          --requ�te pour savoir quel joueur a gagne la partie prendre en compte le calcul de l�exp�rience dans le sujet
        END IF;
      ELSE
        RAISE_APPLICATION_ERROR(-20031,'Le joueur n_existe pas');
      END IF;
    END IF;
  END;
  
  ---------------------------------------------
  --- CREATION DES FONCTIONS
  ---------------------------------------------
  
---- FONCTION : calculer le score de la partie du joueur 
CREATE OR REPLACE FUNCTION CalculScore(PidJoueur Joueur.idJoueur%TYPE, 
                        PidPartie Partie.idPartie%TYPE) RETURN NUMBER IS
                        
                                 
-- Declaration des variables

-- Nombre de lignes de la partie
vnbLigne Ligne.numeroL%TYPE; 

-- Nombre de billes de la bonne couleur mal placees
vnbpionBlanc NUMBER;        

-- Nombre de billes de la bonne couleur bien placees
vnbpionRouge NUMBER;

-- heure de debut de la Partie
vtempsDebutPartie Ligne.tempsLigneL%TYPE;

-- heure a laquelle il a joue la derniere ligne de la Partie
vtempsDerniereL Ligne.tempsLigneL%TYPE;

-- Le temps de jeu de la Partie
vtempsPartie NUMBER;

-- Score de la partie
vscore Partie.scoreP%TYPE; 


-- bonus d'une bille de la bonne couleur bien placee 
bonusPionRouge NUMBER := 3;

  -- sanction sur le nombre de ligne propose par le joueur
penaliteNbLigne NUMBER := 20;

  
BEGIN

  -- Nombre de BilleRouges et Nbre de BilleBlanches de la partie du joueur
  SELECT SUM(nbindiceRougeL),SUM(nbindiceBlancL)
  INTO vnbLigne, vnbpionRouge
  FROM Ligne L
  WHERE L.idJoueur= PidJoueur
  AND L.idPartie  = PidPartie;
  
  -- Nombre de lignes de la partie du joueur
  SELECT MAX(DISTINCT numeroL)
  INTO vnbLigne
  FROM Ligne L
  WHERE L.idJoueur = PidJoueur
  AND L.idPartie  = PidPartie;
  
  
  -- Heure a laquelle le joueur a commence la Partie
  SELECT dateP INTO vtempsDebutPartie
  FROM Partie P
  WHERE P.idPartie  =PidPartie ;
  
  
  -- selectionner l'heure a laquelle le joueur a joue la derniere 
  -- ligne de la Partie
  SELECT tempsLigneL INTO vtempsDerniereL
  FROM Ligne L
  WHERE L.idJoueur= PidJoueur
  AND L.idPartie  = PidPartie
  AND L.numeroL   = vnbLigne ;
  
  vtempsPartie    := vtempsDerniereL-vtempsDebutPartie;
  vscore          := (vnbpionBlanc +(vnbpionRouge*bonusPionRouge))/(vtempsPartie+(vnbLigne*penaliteNbLigne));
  RETURN (vscore);
END;

  
  ---------------------------------------------
  --- CREATION DES VUES
  ---------------------------------------------
  
  
  -- Highscore semaine
CREATE OR REPLACE VIEW HighscoreSemaine
AS
  SELECT J.idJoueur, P.scoreP
  FROM Joueur J, Partie P, Jouer Jo
  WHERE J.idJoueur=Jo.idJoueur
  AND Jo.idPartie =P.idPartie
    --SYSDATE renvoie la date et l'heure actuelles definies pour 
    --le systeme d'exploitation sur lequel la base de donnees reside.
    -- IW permet de recuperer le numero de la semaine
  AND TO_CHAR(to_date(P.dateP,'IW'))=to_char(to_date(SYSDATE,'IW'))
  AND rownum <11
  ORDER BY scoreP DESC;
-- On ne recupere que les 10 meilleurs scores de la semaine


-- Highscore Jour
CREATE OR REPLACE VIEW HighscoreJour
AS
  SELECT J.idJoueur, P.scoreP
  FROM Joueur J, Partie P, Jouer Jo
  WHERE J.idJoueur=Jo.idJoueur
  AND Jo.idPartie =P.idPartie
    --SYSDATE renvoie la date et l'heure actuelles definies pour 
    --le systeme d'exploitation sur lequel la base de donnees reside.
    -- IW permet de recuperer le numero de la semaine
  AND TO_CHAR(to_date(P.dateP,'DD/MM/YYYY'))=to_char(to_date(SYSDATE,'DD/MM/YYYY'))
  AND rownum <11
  ORDER BY scoreP DESC;
-- On ne recupere que les 10 meilleurs scores du jour


--les 10 meilleurs de tous les temps
CREATE or REPLACE VIEW HighscoreDeTous 
AS
SELECT J.idJoueur, P.scoreP
FROM Joueur J, Partie P, Jouer Jo
WHERE    J.idJoueur=Jo.idJoueur    
AND Jo.idPartie=P.idPartie
AND rownum <11
ORDER BY scoreP DESC;



