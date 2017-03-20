




















Proc�dure fonction test de la combi et de la proposition du joueur
BEFORE INSERT ON Joueur





Insertion joueur�: exp�rience doit �tre OBLIGATOIREMENT � 0 
fonction ?

























-- Si une partie est cr�e et qu�elle comprend des joueurs ont cr��e la premi�re ligne pour que --le joueur puisse la remplir avec des billes
-- Cr�ation de la ligne afin de faire le lien avec la proposition du joueur pour la premi�re ligne
Create Or Replace TRIGGER t_a_i_Partie
After Insert On Partie
For Each Row

DECLARE
vidJoueur Jouer.idJoueur%TYPE;
partie_inexistante exception;
pragma exception_init('partie_inexistante',-2291);

BEGIN
	--on s�lectionne l'id du joueur qui a cr��e la partie
	Select idJoueur Into vidJoueur
	From Jouer
	Where Jouer.idPartie = :new.idpartie;

	--on ins�re la premi�re ligne
	Insert Into Ligne
	Values (Seq_Ligne_idLigneL.nextVal,1,sysdate,:new.idpartie,vidJoueur);

exception
  When NO_DATA_FOUND THEN
    --on annule la cr�ation de la partie
		Rollback;
		RAISE_APPLICATION_ERROR(-20001,"La Partie en cours n'a pas de joueur affect� !");
	When dup_val_on_index Then
		RAISE_APPLICATION_ERROR(-20002,"Cette ligne existe d�j� !");
	when partie_inexistante then
		--l'ereur ne peut que venir de la cl� �trang�re idPartie car l'idJoueur est g�r� dans le no data_found
		RAISE_APPLICATION_ERROR(-20003,"La partie est inexistante !");
	when others then
		--blabla
END;/





-- Trigger :  V�rifier que le nombre de billes jouables soit sup�rieur
-- ou �gal au nombre d'emplacements

CREATE OR REPLACE TRIGGER t_b_i_Partie
BEFORE INSERT ON Partie
FOR EACH
-- Declaration des variables
DECLARE
vnbBilles number;
vnbEmplacementsN Niveau.vnbEmplacementsN%TYPE;

BEGIN

-- Nombre de Billes � disposition du joueur
    SELECT COUNT(DISTINCT idBilles) INTO vnbBilles
    FROM Collection Col, Composer Comp, Niveau Niv
    WHERE Col.idCollection = Comp.idCollection
    AND Col.idCollection = Niv.idCollection
    AND Niv.idNiveau = :NEW.idNiveau
    

-- Nombre d'emplacements pour le niveau
    SELECT nbEmplacementsN INTO vnbEmplacementsN
    FROM Niveau
    WHERE idNiveau = :NEW.idNiveau;

IF vnbEmplacementsN > vnbBilles THEN
	Rollback;
RAISE_APPLICATION_ERROR(-20020,"Le nombre de billes jouables doit �tre sup�rieur
    au nombre d'emplacements");
END IF;
END ;
/


-- PROCEDURE : Cr�er une combinaison avec aucune bille en double
-- PLUTOT UNE FONCTION NON ? Puisque �a retourne des �l�ments

CREATE OR REPLACE PROCEDURE P_creation_combinaison(pidPartie Partie.idPartie%TYPE) IS

DECLARE
vidCollection Collection.idCollection%TYPE;
vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;
vNiveau Niveau.idNiveau%TYPE ;
ecode NUMBER;
emesg VARCHAR(20);
vidPartie NUMBER;
flag NUMBER;
E_partie_a_combinaison EXCEPTION;
cle_etrangere_combinaison EXCEPTION;


BEGIN
-- Une partie ne peut contenir qu'une seule combinaison. Il faut donc v�rifier
-- que la partie n'ait pas de combinaison.
    SELECT DISTINCT COUNT(C.idPartie) into nbidPartie
    FROM Combinaison C
    WHERE C.idPartie = nbidPartie;
    If nbidPartie != 0 THEN RAISE E_partie_a_combinaison;

-- Retrouver le niveau correspondant � la partie
    SELECT P.idNiveau into vNiveau
    FROM PARTIE
    WHERE P.idPartie = pidPartie ;   

-- Selection de la bonne collection de billes pour le niveau et du nombre d'emplacements
    SELECT Niv.idCollection, Niv.nbEmplacementsN INTO vidCollection,vnbEmplacementsN
    FROM Niveau Niv
    WHERE Niv.idNiveau = vNiveau ;

-- Sequence pour l'insertion dans la table Combinaison
    CREATE SEQUENCE Seq_Combinaison_positionBilles START WITH 1 INCREMENT BY 1 NOCYCLE;

-- Curseur permettant de selectionner le bon nombre d'identifiants de billes selon le niveau
    FOR c1_ligne IN
   	 (SELECT idBilles
   	  FROM     (SELECT idBilles
   			 FROM Bille B,Composer Comp
   			 WHERE  B.idBille = Comp.idBille&&
 AND Comp.idCollection = vidCollection
   			 ORDER BY dbms_random.value)
   	  WHERE rownum <= vnbEmplacementsN
   	 ) LOOP
   	 -- Gestion de l'insertion dans la table Combinaison    
   	 INSERT INTO Combinaison VALUES(Seq_Combinaison_positionsBilles.nextval, pidPartie, c1_ligne.idBilles);
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
   	 ELSE IF (SQLERRM LIKE %FK_Combinaison_idPartie%) THEN
   	 	DBMS_OUTPUT.PUT_LINE("La partie n'existe pas");

    -- Gestion des autres erreurs possibles
    WHEN OTHERS THEN
   	 ecode := SQLCODE;
   	 emesg := SQLERRM;
   	 DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);
END;
/

-- le joueur ne peut plus jouer pendant 4h si il a perdu 5 parties en une heure
CREATE OR REPLACE TRIGGER tbi_Partie
BEFORE INSERT ON Partie
FOR EACH ROW
DECLARE
-- 
CURSOR C(PidJoueur Joueur.idJoueur%TYPE) IS (SELECT P.dateP FROM Partie P, jouer J
    WHERE P.resultatP= FALSE AND J.idPartie=P.idPartie AND J.idJoueur=PidJoueur);
vnb NUMBER;
sanction EXCEPTION;
vdate_der_partie Partie.dateP%TYPE ;

BEGIN
--date de la derni�re partie
SELECT P.dateP INTO vdate_der_partie FROM Partie P, jouer J
WHERE J.idPartie=P.idPartie AND P.idPartie= (SELECT MAX (idPartie) );

FOR C_ligne IN C LOOP
    SELECT count(*) INTO vnb FROM Partie P
   	 WHERE (P.resultatP= FALSE) 
 AND (timestamps (vdate_der_partie) � timestamps(C_ligne.dateP)) <  3600);
   	 -- 3600: c'est � dire 3600 secondes => �quivalent � une heure
END LOOP ;
IF (vnb=5) THEN
    WHILE (timestamps (:NEW.dateP) < timestamps (vdate_der_partie + 4*3600)) LOOP
    	RAISE sanction ;
    END IF ;
COMMIT ;
-- A v�rifier
--EXCEPTION
WHEN NO_DATA_FOUND THEN
	DBMS_OUTPUT.PUT_LINE(�Le joueur n�a pas encore jouer de parties�)
WHEN sanction THEN
DBMS_OUTPUT.PUT_LINE (�Vous pourriez plus jouer pendant un moment�);
--pr�ciser l�heure ?
-- Gestion des autres erreurs possibles
    WHEN OTHERS THEN
   	 ecode := SQLCODE;
   	 emesg := SQLERRM;
   	 DBMS_OUTPUT.PUT_LINE(TO_CHAR(ecode)||'-'||emesg);

END;
/