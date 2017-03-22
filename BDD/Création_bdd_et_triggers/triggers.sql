--INSERTION joueur : insertion du niveau 1 dans la table d�bloquer
CREATE OR REPLACE TRIGGER tai_Joueur AFTER
  INSERT ON Joueur FOR EACH ROW BEGIN
  INSERT INTO Debloquer VALUES
    (:NEW.idJoueur,1);
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
  
  
  
  
  -- PROCEDURE : Cr�er une combinaison avec aucune bille en double
  -- PLUTOT UNE FONCTION NON ? Puisque �a retourne des �l�ments
CREATE OR REPLACE PROCEDURE P_creation_combinaison(
    pidPartie Partie.idPartie%TYPE)
IS
  DECLARE
    vidCollection Collection.idCollection%TYPE;
    vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;
    vNiveau Niveau.idNiveau%TYPE ;
    ecode                     NUMBER;
    emesg                     VARCHAR(20);
    vidPartie                 NUMBER;
    flag                      NUMBER;
    E_partie_a_combinaison    EXCEPTION;
    cle_etrangere_combinaison EXCEPTION;
  BEGIN
    -- Une partie ne peut contenir qu'une seule combinaison. Il faut donc v�rifier
    -- que la partie n'ait pas de combinaison.
    SELECT DISTINCT COUNT(C.idPartie)
    INTO nbidPartie
    FROM Combinaison C
    WHERE C.idPartie = nbidPartie;
    IF nbidPartie   != 0 THEN
      RAISE E_partie_a_combinaison;
      -- Retrouver le niveau correspondant � la partie
      SELECT P.idNiveau
      INTO vNiveau
      FROM PARTIE
      WHERE P.idPartie = pidPartie ;
      -- Selection de la bonne collection de billes pour le niveau et du nombre d'emplacements
      SELECT Niv.idCollection,
        Niv.nbEmplacementsN
      INTO vidCollection,
        vnbEmplacementsN
      FROM Niveau Niv
      WHERE Niv.idNiveau = vNiveau ;
      -- Sequence pour l'insertion dans la table Combinaison
CREATE SEQUENCE Seq_Combinaison_positionBilles START WITH 1 INCREMENT BY 1 NOCYCLE;
  -- Curseur permettant de s�lectionner le bon nombre d'identifiants de billes selon le niveau
  FOR c1_ligne IN
  (SELECT idBille
  FROM
    (SELECT idBille
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
        Seq_Combinaison_positionsBilles.nextval,
        pidPartie,
        c1_ligne.idBille
      );
  END LOOP ;
  DROP Seq_Combinaison_positionBilles ;
  COMMIT ;
  -- Gestion des erreurs
EXCEPTION
  -- Une partie ne peut avoir qu'une seule et unique combinaison
WHEN E_partie_a_combinaison THEN
  DBMS_OUTPUT.PUT_LINE("Une combinaison existe d�j� pour la partie renseign�e");
  -- Une bille ne peut �tre utilis�e qu'une seule fois dans la combinaison pour chaque partie
  -- (probl�me de cl� primaire)
WHEN DUP_VAL_ON_INDEX THEN
  DBMS_OUTPUT.PUT_LINE("La bille est d�j� utilis�e dans la combinaison pour cette partie");
  -- Probl�me de cl� �trang�re : la bille ou la partie n'existe pas (lors du insert)
WHEN PB_CLE_ETRANGERE THEN
  IF (SQLERRM LIKE %FK_Combinaison_idBilles%) THEN
    DBMS_OUTPUT.PUT_LINE("La bille n'existe pas");
  ELSE
    IF (SQLERRM LIKE %FK_Combinaison_idPartie%) THEN
      DBMS_OUTPUT.PUT_LINE("La partie n'existe pas");
      -- Gestion des autres erreurs possibles
    WHEN OTHERS THEN
      ecode := SQLCODE;
      emesg := SQLERRM;
      DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
    END;
    /
    --une ligne doit �tre compl�tement remplie pour pouvoir �tre soumise
    /*tester nombre emplacements billes
    et nombre effectif de bille*/
CREATE OR REPLACE PROCEDURE Test_Ligne_Compl�te(
      pidPartie Partie.idPartie%TYPE)
  IS
    DECLARE
      vnbEmplacements NUMBER;
      vnbBilles       NUMBER;
    BEGIN
      --on r�cup�re le nombre d�emplacement disponible
      SELECT Niv.nbEmplacementsN
      INTO vnbEmplacements
      FROM Niveau Niv,
        Partie P
      WHERE Niv.idNiveau = P.idNiveau
      AND P.idPartie     = pidPartie;
      --on r�cup�re le nombre de bille plac� sur la ligne
      SELECT COUNT(PropJ.idBille)
      INTO vnbBilles
      FROM PropositionJoueur PropJ,
        Ligne L
      WHERE L.idPartie = PidPartie
      AND L.idLigne    = PropJ.idLigne
      AND L.numeroL    =
        (SELECT MAX(L.numeroL) FROM Ligne L
        );
      IF(vnbEmplacements        - vnbBilles >= 0)THEN
        RAISE_APPLICATION_ERROR(-20001,"La Ligne n'est pas compl�te !");
      END IF;
    END ;
    /
    -- le joueur ne peut plus jouer pendant 4h si il a perdu 5 parties en une heure
CREATE OR REPLACE TRIGGER tbi_Partie BEFORE
  INSERT ON Partie FOR EACH ROW DECLARE CURSOR C(PidJoueur Joueur.idJoueur%TYPE) IS
    (SELECT P.dateP
    FROM Partie P,
      jouer J
    WHERE P.resultatP= FALSE
    AND J.idPartie   =P.idPartie
    AND J.idJoueur   =PidJoueur
    );
  vnb              NUMBER;
  sanction         EXCEPTION;
  vdate_der_partie DATE;
  BEGIN
    --date de la derni�re partie
    SELECT P.dateP
    INTO vdate_der_partie
    FROM Partie P,
      jouer J
    WHERE J.idPartie=P.idPartie
    AND P.idPartie  =
      (SELECT MAX (idPartie)
      );
    FOR C_ligne IN C
    LOOP
      SELECT COUNT(*)
      INTO vnb
      FROM Partie P
      WHERE (P.resultatP                                              = FALSE)
      AND (timestamps (vdate_der_partie) � timestamps(C_ligne.dateP)) < 3600);
      -- 3600: c'est � dire 3600 secondes => �quivalent � une heure
    END LOOP ;
    IF (vnb                          =5) THEN
      WHILE (timestamps (:NEW.dateP) < timestamps (vdate_der_partie + 4*3600))
      LOOP
        RAISE sanction ;
      END IF ;
      COMMIT ;
      -- A v�rifier
      --EXCEPTION
    WHEN NO_DATA_FOUND THEN
      DBMS_OUTPUT.PUT_LINE(�Le joueur n�a pas encore jouer de parties�);
    WHEN sanction THEN
      DBMS_OUTPUT.PUT_LINE (�Vous pourriez plus jouer pendant un moment�);
      --pr�ciser l�heure ?
      -- Gestion des autres erreurs possibles
    WHEN OTHERS THEN
      DBMS_OUTPUT.PUT_LINE(SQLCODE||'-'||SQLERRM);
    END;
    /
    -- les lignes doivent �tre rejou�es dans l'ordre
CREATE OR REPLACE PROCEDURE Rejouer(
      Pidpartie Partie.idPartie%TYPE)
  IS
    --g�rer le multi Pierrick
    CURSOR C1(PidJoueur Joueur.idJoueur%TYPE)
    IS
      (SELECT *
      FROM Ligne L
      WHERE L.idPartie=Pidpartie
      AND L.idJoueur  =PidJoueur
      ORDER BY L.numeroL
      ) ;
    CURSOR C2 (PidLigne Ligne.idLigne%TYPE)
    IS
      (SELECT *
      FROM PropositionJoueur PJ
      WHERE PJ.idLigne=PidLigne
      ORDER BY positionBilleLigne
      ) ;
  BEGIN
    FOR C1_ligne IN C1
    LOOP
      FOR C2_LIGNE IN C2(C1_ligne.idLigne)
      LOOP
        DBMS_OUTPUT.PUT_LINE(C2_ligne.idLigne)
      END LOOP ;
    END LOOP ;
  END ;
/
--pour un m�me niveau la combinaison doit �tre diff�rente de la partie pr�c�dente
CREATE OR REPLACE TRIGGER tbi_Combinaison BEFORE
  INSERT ON Combinaison FOR EACH ROW DECLARE
    -- CURSOR retournant la combinaison du niveau correspond � la derniere partie d'un joueur donn�
    --d�couper le curseur en plusieurs bouts
    CURSOR C1 (PidJoueur Joueur.idJoueur%TYPE) IS
    (SELECT positionBilleCombinaison,
      idBille
    FROM Combinaison C ,
      Niveau N,
      Partie P,
      Jouer J
    WHERE C.idPartie=P.idPartie
    AND P.idNiveau  =N.idNiveau
    AND P.dateP     =
      (SELECT MAX(UNIX_TIMESTAMP(dateP))
      FROM Partie P,
        Jouer J
      WHERE J.idPartie=P.idPartie
      AND J.idJoueur  =PidJoueur
      )
    AND J.idPartie=P.idPartie
    AND J.idJoueur=PidJoueur
    ) ;
  vnb                 NUMBER :=0;
  changer_combinaison EXCEPTION;
  vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;
  BEGIN
    --mettre une contrainte concernant le niveau (pour travailler sur le m�me niveau)
    -- S�lection du nombre d'emplacements du niveau de la partie
    SELECT nbEmplacementsN
    INTO vnbEmplacementsN
    FROM Niveau N,
      Partie P,
      Jouer J
    WHERE N.idNiveau=P.idNiveau
    AND P.idPartie  =J.idPartie
    AND J.idJoueur  =PidJoueur FOR C1_ligne IN C1 LOOP
      -- comparaison des billes de l'ancienne combinaison � la nouvelle
      -- incr�menter vnb tant qu'on a une m�me bille plac�e � une m�me position
      WHILE (vnb                           <C1_ligne.nbEmplacementsN)
      && (C1_ligne.idBille                 =:NEW.idBille)
      && (C1_ligne.positionBilleCombinaison=:NEW.positionBilleCombinaison) LOOP vnb=vnb+1
  END LOOP;
-- Si vnb est �gal au nombre d'emplacements alors les deux combinaisons sont identiques
IF (vnb=C1_ligne.nbEmplacementsN) THEN
  RAISE changer_combinaison;
END IF;
END LOOP;
EXCEPTION
WHEN changer_combinaison THEN
  -- appeler la proc�dure cr�er combinaison avec :NEW.idPartie
  P_creation_combinaison(:NEW.idPartie);
WHEN OTHERS THEN
  DBMS_OUTPUT.PUT_LINE(SQLCODE||SQLERRM);
END;
/
--faire moins compliqu� � lire ?
--yaya
---MOde monoJoueur
-- pour g�rer les joueurs cr��e avec beaucoup d�exp qui n�ont pas encore jou� de partie
CREATE OR REPLACE TRIGGER t_b_iPartie before
  INSERT ON Partie FOR EACH row DECLARE vseuilN NUMBER;
  vexperience NUMBER;
  BEGIN
    SELECT seuilN INTO vseuilN FROM Niveau WHERE idNiveau = :NEW.idNiveau;
    SELECT experienceJ
    INTO vexperience
    FROM Jouer Joue,
      Joueur J
    WHERE joue.idPartie = :new.idPartie
    AND joue.idJoueur   = J.idJoueur ;
    IF vseuilN          > vexperience THEN
      RAISE_APPLICATION_ERROR(-20031,"Niveau pas encore debloquer");
    END IF;
  END ;
--- mode mutijoueur
CREATE OR REPLACE TRIGGER t_b_i_multiJ_Partie before
  INSERT ON Partie FOR EACH row DECLARE vnbJoueur NUMBER;
  vExpMinJoueur NUMBER;
  vseuilN       NUMBER;
  BEGIN
    --- compter le nombre de joueur pour la nouvelle partie cr�e
    SELECT COUNT(dictinct idJoueur)
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
      --- Seuil requis pour le niveau nouvellement cr�e
      SELECT seuilexpN
      INTO vseuilN
      FROM Niveau
      WHERE idNiveau = :new.idNiveau;
      IF vseuilN    >= vExpMinJoueur THEN
        RAISE_APPLICATION_ERROR(-20032,"Niveau pas encore debloquer par tous les joueur");
      END IF;
    END IF;
  END ;
  ------------------High Score
  -- enrober dans une proc�dure avec comme param�tre le niveau dont on souhaite conna�tre les highscores
  --les 10 meilleurs du jour
  -- m�me code que semaine mais SANS le IW
  --les 10 meilleurs de la semaine
CREATE OR REPLACE VIEW HighscoreSemaine
AS
  SELECT idJoueur,
    scoreP,
    COUNT(*) AS nb,
  FROM Joueur J,
    Partie P,
    Jouer Jo
  WHERE J.idJoueur=Jo.idJoueur
  AND Jo.idPartie =P.idPartie
    --SYSDATE renvoie la date et l'heure actuelles d�finies pour le syst�me d'exploitation sur lequel la base de donn�es r�side.
    -- IW permet de r�cup�rer le num�ro de la semaine
  AND TO_CHAR(to_date(P.dateP,'DD/MM/YYYY'')=to_char(to_date(SYSDATE,'DD/MM/YYYY'))
ORDER BY scoreP DESC
-- On ne r�cup�re que les 10 meilleurs scores de la semaine
HAVING nb<11;

--les 10 meilleurs du mois
CREATE or REPLACE VIEW HighscoreMois AS
SELECT idJoueur, scoreP, count(*) as nb,
FROM Joueur J, Partie P, Jouer Jo
WHERE    J.idJoueur=Jo.idJoueur    
AND Jo.idPartie=P.idPartie    
--SYSDATE renvoie la date et l'heure actuelles d�finies pour le syst�me d'exploitation sur lequel la base de donn�es r�side.    
AND to_char(to_date(P.dateP,'DD/MM/YYYY'))=to_char(to_date(SYSDATE,'DD/MM/YYYY
    '))
ORDER BY scoreP DESC
HAVING nb<11

--les 10 meilleurs de tous les temps
CREATE or REPLACE VIEW HighscoreDeTous AS
SELECT idJoueur, scoreP, count(*) as nb,
FROM Joueur J, Partie P, Jouer Jo
WHERE    J.idJoueur=Jo.idJoueur    
AND Jo.idPartie=P.idPartie
ORDER BY scoreP DESC
HAVING nb<11;







----Proc�dure pour calculer le score de la partie du joueur (plut�t une fonction)
CREATE OR REPLACE FUNCTION CalculScore(PidJoueur Joueur.idJoueur%TYPE, PidPartie Partie.idPartie%TYPE) RETURN NUMBER IS
DECLARE
vnbLigne Ligne.numeroL%TYPE; -- Nombre de lignes de la partie
vnbpionBlanc NUMBER;        -- Nombre de billes de la bonne couleur mal plac�es
-- Nombre de billes de la bonne couleur bien plac�es
vnbpionRouge NUMBER;
-- heure de debut de la Partie
vtempsDebutPartie Ligne.tempsLigneL%TYPE;
-- heure � laquelle il a jou� la derni�re ligne de la Partie
vtempsDerniereL Ligne.tempsLigneL%TYPE;
-- Le temps de jeu de la Partie
vtempsPartie Ligne.tempsLigneL%TYPE;
vscore Partie.scoreP%TYPE; -- penser � modifier le TYPE de scoreP en NUMBER
-- bonus d'
    une bille de la bonne couleur bien plac�e bonusPionRouge NUMBER=3;
  -- sanction sur le nombre de ligne propos� par le joueur
  penaliteNbLigne NUMBER=20;
BEGIN
  -- selection du nbre de lignes, du nbre de BilleRouges et du nbre de BilleBlancs de la Partie du joueur
  SELECT MAX(numeroL),
    COUNT(nbindiceRougeL),
    COUNT(nbindiceBlancL)
  INTO vnbLigne,
    vnbpionRouge,
    vnbpionBlanc
  FROM Ligne L
  WHERE L.idJoueur=PidJoueur
  AND L.idPartie  =PidPartie;
  -- selectionner l'heure � laquelle le joueur a commenc� la Partie
  SELECT dateP
  INTO vtempsDebutPartie
  FROM Partie P,
    Ligne L
  WHERE L.idJoueur=PidJoueur
  AND L.idPartie  =P.idPartie
  AND L.idPartie  =PidPartie ;
  -- selectionner l'heure � laquelle le joueur a jou� la derni�re ligne de la Partie
  SELECT tempsLigneL
  INTO vtempsDerniereL
  FROM Ligne L
  WHERE L.idJoueur=PidJoueur
  AND L.idPartie  =PidPartie
  AND L.numeroL   =vnbLigne ;
  vtempsPartie    =vtempsDerniereL-vtempsPremiereL;
  vscore          =(vnbpionBlanc  +(vnbpionRouge*bonusPionRouge))/(vtempsPartie+(vnbLigne*penaliteNbLigne))
  RETURN (vscore);
END;
/
--INSERTION joueur : insertion du niveau 1 dans la table d�bloquer
CREATE OR REPLACE TRIGGER tai_Joueur AFTER
  INSERT ON Joueur FOR EACH ROW BEGIN
  INSERT INTO Debloquer VALUES
    (:NEW.idJoueur,1
    ) END;
/
----yaya
--l'experience du joueur ne peux pas baisser
CREATE OR REPLACE TRIGGER t_b_u_expJ BEFORE
  UPDATE ON JOUEUR FOR EACH row BEGIN IF :OLD.experienceJ > :NEW.experienceJ THEN RAISE_APPLICATION_ERROR(-20033,'L EXPERIENCE DU Joueur NE PEUX PAS BAISSER');
END IF;
END;
---la categorie du joueur ne peux pas baisser
CREATE OR REPLACE TRIGGER t_b_u_catJ BEFORE
  UPDATE ON JOUEUR FOR EACH row BEGIN IF :OLD.idCat > :NEW.idCat THEN RAISE_APPLICATION_ERROR(-20034,'La categorie du joueur ne peux pas baisser');
END IF;
END;
-- Trigger : Insertion dans d�bloquer si la partie est gagn�e
CREATE OR REPLACE TRIGGER t_a_u_partie AFTER
  UPDATE ON partie FOR EACH ROW
    --Declaration de variables
    DECLARE vseuilExpN NUMBER;
  vNbIdJoueur          NUMBER;
  -- compter IDJOUEUR DANS JOUER
  SELECT COUNT(IDJOUEUR)
  INTO vNbIdJoueur
  FROM JOUER
  WHERE idPartie = :New.idPartie ;
  -- Test pour voir si la partie a �t� gagn� et si le joueur n'a pas d�j� d�bloqu� tous les niveaux
  --est-ce que la partie est gagn�e ?
  IF (:New.resultat = 1 ) THEN
    --pour 1 joueur
    IF (vNbIdJoueur          = 1) THEN
      IF (:New.idniveau + 1 <= 50) THEN
        --Selection du seuil pour le niveau � atteindre
        SELECT seuilExpN
        INTO vseuilExpN
        FROM Niveau
        WHERE idNiveau = :New.idniveau+1 ;
        --Update de l'exp du joueur
        UPDATE JOUEUR
        SET experienceJ = vseuilExpN
        WHERE idjoueur  = :New.idjoueur;
        -- Insertion dans d�bloquer
        INSERT ON DEBLOQUER VALUES
          (
            :New.idjoueur,
            :New.idniveau + 1
          );
      ELSE
        IF (:New.idniveau         + 1 > 50) THEN
          RAISE_APPLICATION_ERROR(-20030,"Le joueur a d�bloqu� tous les niveaux");
        END IF;
        --pour 2 joueur
      ELSE
        requ�te pour savoir quel joueur a gagn� la partie prendre en compte le calcul de l�exp�rience dans le sujet
      END IF;
    ELSE
      RAISE_APPLICATION_ERROR(-20031,"Le joueur n'existe pas");
