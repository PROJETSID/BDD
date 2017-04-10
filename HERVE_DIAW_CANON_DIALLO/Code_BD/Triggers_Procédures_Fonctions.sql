Triggers, Procédures et fonctions :


Triggers

--tai_Joueur
create or replace TRIGGER tai_Joueur AFTER
  INSERT ON Joueur FOR EACH ROW BEGIN
  INSERT INTO Debloquer VALUES
    (:NEW.idJoueur,1);
END;

--Ligne_idLigneL
create or replace TRIGGER Ligne_idLigneL
	BEFORE INSERT ON Ligne 
  FOR EACH ROW 
	WHEN (NEW.idLigneL IS NULL) 
	BEGIN
		 select Seq_Ligne_idLigneL.NEXTVAL INTO :NEW.idLigneL from DUAL; 
  END;

--t_a_u_partie
  create or replace TRIGGER t_a_u_partie AFTER
  UPDATE ON partie FOR EACH ROW
    --Declaration de variables
    DECLARE vseuilExpN NUMBER;
  vNbIdJoueur          NUMBER;
  vidJoueur Jouer.idJoueur%TYPE;
  maxniv Niveau.idNiveau%TYPE;
  
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
        -- On verifier si le joueur n'a pas déjà débloqué le niveau
        SELECT J.idJoueur
        INTO vidJoueur
        FROM Jouer J
        WHERE J.idpartie = :NEW.idPartie;
        -- On selectionne le niveau max qui a été débloqué par le joueur
        SELECT MAX(idniveau)
        INTO maxniv
        FROM DEBLOQUER
        WHERE IDJOUEUR         = vidjoueur;
        
        IF (:New.idniveau + 1 <= 50 AND MAXNIV <= :New.idniveau  ) THEN
          --Selection du seuil pour le niveau ¿ atteindre
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
       -- ELSE
         -- IF (:New.idniveau         + 1 > 50) THEN
           -- RAISE_APPLICATION_ERROR(-20030,'Le joueur a debloque tous les niveaux');
          --END IF;
          --pour 2 joueur
          -- ELSE
          --requ¿te pour savoir quel joueur a gagne la partie prendre en compte le calcul de l¿exp¿rience dans le sujet
        END IF;
      END IF;
      END IF;
    END;

--t_b_i_multiJ_Partie
  create or replace TRIGGER t_b_i_multiJ_Partie
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

--t_b_u_expJ
  create or replace TRIGGER t_b_u_expJ BEFORE
  UPDATE ON JOUEUR FOR EACH row BEGIN
  IF :OLD.experienceJ > :NEW.experienceJ THEN RAISE_APPLICATION_ERROR(-20033,'L EXPERIENCE DU Joueur NE PEUX PAS BAISSER');
END IF;
END;

--t_b_u_catJ
create or replace TRIGGER t_b_u_catJ BEFORE
  UPDATE ON JOUEUR FOR EACH row BEGIN IF :OLD.idCat > :NEW.idCat THEN RAISE_APPLICATION_ERROR(-20034,'La categorie du joueur ne peux pas baisser');
END IF;
END;


--T_B_I_Proposition_joueur
create or replace TRIGGER T_B_I_Proposition_joueur
     BEFORE INSERT ON Proposition_joueur
     FOR EACH ROW
     
     DECLARE
      vnbEmplacements NUMBER;
      vnbBilles       NUMBER;
      ligne_incomplete EXCEPTION;
      bille_double EXCEPTION;
      CURSOR c1 IS SELECT IDBILLE FROM Proposition_joueur Propj
      WHERE Propj.idLigneL = :New.idligneL;
      idbilleb_prop NUMBER; 
      
      
    BEGIN
      --on recupere le nombre d'emplacements disponibles pour un niveau
      SELECT Niv.nbEmplacementsN INTO vnbEmplacements
      FROM Niveau Niv, Partie P, Ligne L
      WHERE Niv.idNiveau = P.idNiveau
      AND P.idPartie     = L.idpartie
      AND L.idligneL = :new.idligneL ;
      
      
      --on recupere le nombre de billes place sur la ligne pour une partie
      SELECT COUNT(PropJ.idBille) INTO vnbBilles
      FROM Proposition_Joueur Propj
      WHERE  Propj.idLigneL = :New.idligneL;
        

        -- test de la ligne complète
      IF(vnbEmplacements-vnbBilles = 0)THEN
      RAISE ligne_incomplete ;
      END IF;
      
      -- Ouverture du curseur et test de l'url de la bille : doit être unique
      open c1;
      fetch c1 into idbilleb_prop;
      if idbilleb_prop = :new.idbille then
       RAISE bille_double ;
      end if;
      
      EXCEPTION
      WHEN ligne_incomplete THEN
        DBMS_OUTPUT.PUT_LINE('La Ligne est complète !');
        WHEN bille_double THEN
        DBMS_OUTPUT.PUT_LINE('La bille a deja ete jouee dans la proposition');
     END ;

--t_b_i_Partie
create or replace TRIGGER t_b_i_Partie BEFORE
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


Procédures

--P_creation_combinaison
create or replace PROCEDURE P_creation_combinaison(
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
    
      -- Retrouver le niveau correspondant ¿ la partie
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

--INSERTION_LIGNE
create or replace PROCEDURE INSERTION_LIGNE(pnumeroL Ligne.numeroL%TYPE,
pnbindicerougel Ligne.nbindicerougel%TYPE,
pnbIndiceBlancL Ligne.nbindiceblancL%TYPE,
pidpartie Partie.idpartie%TYPE,
pidjoueur Joueur.idjoueur%TYPE)

IS

ecode NUMBER ;
emesg VARCHAR(20);

BEGIN

INSERT INTO "21400692".LIGNE(idlignel,numeroL, tempsLignel,nbindicerougel, nbIndiceBlancL,
idpartie,idjoueur)
VALUES (SEQ_LIGNE_IDLIGNEL.nextval,pnumeroL, sysdate,pnbindicerougel, pnbIndiceBlancL,
pidpartie,pidjoueur);


EXCEPTION
      -- Gestion des autres erreurs possibles
WHEN OTHERS THEN
  ecode := SQLCODE;
  emesg := SQLERRM;
  DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
  ROLLBACK;
END;

--INSERTION_JOUEUR
create or replace PROCEDURE INSERTION_JOUEUR(pPseudoJ Joueur.PseudoJ%TYPE,
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

--INSERTION_PARTIE
create or replace PROCEDURE INSERTION_PARTIE(pIdjoueur JOUEUR.Idjoueur%TYPE, 
pidNiveau NIVEAU.idNiveau%TYPE) IS

-- Declaration de variables
--vIdhistorique HISTORIQUE.IdHistorique%TYPE;
vIdpartie PARTIE.Idpartie%TYPE;
ecode NUMBER ;
emesg VARCHAR(20);


-- Debut de la procédure
BEGIN

-- On récupère le dernier id_historique pour le joueur
--SELECT max(idhistorique) INTO vIdhistorique
--FROM HISTORIQUE;
--WHERE Idjoueur = pIdjoueur ;

--IF vIdhistorique IS NULL THEN
--vIdhistorique := 0 ;
--ELSE vIdhistorique :=vIdhistorique+1 ;
--END IF;

-- Insertion dans historique : doit avoir lieu avant l'insertion dans partie
--INSERT INTO HISTORIQUE VALUES (vIdhistorique,pidjoueur);

-- Insertion dans partie
INSERT INTO PARTIE(Idpartie,datep, idniveau) VALUES
(SEQ_PARTIE_IDPARTIE.nextval, sysdate, pidNiveau);


-- On récupère le idpartie 
SELECT max(P.IDpartie) INTO vIdpartie
FROM partie P;

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

--INSERTION_PARTIE_MULTI
create or replace PROCEDURE INSERTION_PARTIE_MULTI(pIdjoueur JOUEUR.Idjoueur%TYPE, 
pIdjoueur2 JOUEUR.Idjoueur%TYPE, pidNiveau NIVEAU.idNiveau%TYPE) IS

-- Declaration de variables
--vIdhistorique HISTORIQUE.IdHistorique%TYPE;
vIdpartie PARTIE.Idpartie%TYPE;
ecode NUMBER ;
emesg VARCHAR(20);

-- Debut de la procédure
BEGIN

-- Insertion dans partie
INSERT INTO PARTIE(Idpartie,datep, idniveau) VALUES
(SEQ_PARTIE_IDPARTIE.nextval, sysdate, pidNiveau);


-- On récupère le idpartie 
SELECT max(P.IDpartie) INTO vIdpartie
FROM partie P;

-- Insertion dans la table JOUER
INSERT INTO JOUER VALUES (vIdpartie, pIdJoueur);
INSERT INTO JOUER VALUES (vIdpartie, pIdJoueur2);


--Gestion des exceptions
EXCEPTION
WHEN OTHERS THEN
  ecode := SQLCODE;
  emesg := SQLERRM;
  DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
  ROLLBACK;
END;


--highscoretous
create or replace PROCEDURE highscoretous(pidniveau IN niveau.idNiveau%TYPE,
       c_highscoretous OUT SYS_REFCURSOR)
IS
BEGIN
  OPEN c_highscoretous FOR
  SELECT * FROM (
  SELECT J.pseudoj, P.scoreP  
  FROM Joueur J, Partie P, Jouer Jo 
  WHERE    J.idJoueur=Jo.idJoueur 
  AND P.idniveau = pidniveau
  AND Jo.idPartie=P.idPartie
  ORDER BY scoreP desc )
  WHERE rownum < 11;
END;


Fonctions

--CalculScore
create or replace FUNCTION CalculScore(PidJoueur Joueur.idJoueur%TYPE,
                        PidPartie Partie.idPartie%TYPE) RETURN number IS
                                                    
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
vtempsPartie NUMBER(10,0);

-- Score de la partie
vscore Partie.scoreP%TYPE;


-- bonus d'une bille de la bonne couleur bien placee
bonusPionRouge NUMBER := 10000;

-- bonus d'une bille de la bonne couleur bien placee
bonusPionBlanc NUMBER := 6000;

  -- sanction sur le nombre de ligne propose par le joueur
penaliteNbLigne NUMBER := 200;

 
BEGIN

  -- Nombre de BilleRouges et Nbre de BilleBlanches de la partie du joueur
  SELECT SUM(nbindiceRougeL),SUM(nbindiceBlancL)
  INTO vnbpionRouge, vnbpionBlanc
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
  vtempsPartie    := to_number(to_char(vtempsDerniereL,'SSSSS'))-to_number(to_char(vtempsDebutPartie,'SSSSS'));
  vscore          := (vnbpionBlanc*bonusPionBlanc +(vnbpionRouge*bonusPionRouge))/(vtempsPartie+(vnbLigne*penaliteNbLigne));
 

  RETURN vscore;
END;

--Niveau_Plus_Bas
create or replace FUNCTION Niveau_Plus_Bas(PseudoJ1 JoueursEnLigne.pseudoJ%TYPE,
											PseudoJ2 JoueursEnLigne.pseudoJ%TYPE)
							RETURN NUMBER AS
              
CURSOR C1 IS SELECT idNiveau FROM Niveau
              WHERE seuilExpN <= ( SELECT MIN(experiencej)
                              FROM Joueur
                              WHERE pseudoj IN (PseudoJ1,PseudoJ2))
              ORDER BY idNiveau;

BEGIN
FOR C1_ligne IN C1 LOOP
      RETURN C1_ligne.idNiveau;
END LOOP;
END;

--Rejouer
create or replace FUNCTION Rejouer(PidJoueur Joueur.idJoueur%TYPE,
  Pidpartie Partie.idPartie%TYPE)
  RETURN varchar2 AS
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
      retour Varchar2(32767);
  BEGIN
  retour := '';
    FOR C1_ligne IN C1
    LOOP
    -- Affichage de l'ID de la ligne
      retour := retour + to_char(C1_ligne.idLigneL) + ' ';
      -- Affichage de la position de la bille, de l'id de la bille 
      --- ainsi que de son URL
      FOR C2_LIGNE IN C2(C1_ligne.idLigneL)
      LOOP
        retour := retour + C2_ligne.positionbilleligne + ' ';
        retour := retour + C2_ligne.idBille + ' ';
        retour := retour + C2_ligne.urlB + ' ';
      END LOOP ;
    END LOOP ;
    return retour;
  END ;


