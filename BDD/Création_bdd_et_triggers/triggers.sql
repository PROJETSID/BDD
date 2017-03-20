
--INSERTION joueur : insertion du niveau 1 dans la table débloquer
CREATE OR REPLACE TRIGGER tai_Joueur
AFTER INSERT ON Joueur
FOR EACH ROW
BEGIN
INSERT INTO Debloquer VALUES (:NEW.idJoueur,1);
END;
/




-- Si une partie est crée et qu’elle comprend des joueurs ont créée la première ligne pour que --le joueur puisse la remplir avec des billes
-- Création de la ligne afin de faire le lien avec la proposition du joueur pour la première ligne
Create Or Replace TRIGGER t_a_i_Partie
After Insert On Partie
For Each Row

DECLARE
vidJoueur Jouer.idJoueur%TYPE;
partie_inexistante exception;
pragma exception_init(partie_inexistante,-22901);

BEGIN
	--on sélectionne l'id du joueur qui a créée la partie
	Select idJoueur Into vidJoueur
	From Jouer
	Where Jouer.idPartie = :new.idpartie;

	--on insère la première ligne
	Insert Into Ligne
	Values (Seq_Ligne_idLigneL.nextval,1,sysdate,'','',:new.idpartie,vidJoueur);

-- le mettre dans un when ?
	IF (NO_DATA_FOUND) THEN
		--on annule la création de la partie
		Rollback;
		RAISE_APPLICATION_ERROR(-20001,"Pas de joueur affecté !");
	END IF;

Exception
	When dup_val_on_index Then
		RAISE_APPLICATION_ERROR(-20002,"Cette ligne existe déjà !");
	when partie_inexistante then
		--l'ereur ne peut que venir de la clé étrangère idPartie car l'idJoueur est géré dans le no data_found
		RAISE_APPLICATION_ERROR(-20003,"La partie est inexistante !");
	WHEN OTHERS THEN
   	 DBMS_OUTPUT.PUT_LINE(SQLCODE||'-'||SQLERRM);
END;
/












-- Trigger :  Vérifier que le nombre de billes jouables soit supérieur
-- ou égal au nombre d'emplacements

CREATE OR REPLACE TRIGGER t_b_i_Partie
BEFORE INSERT ON Partie
FOR EACH ROW
-- Declaration des variables
DECLARE
vnbBilles number;
vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;

BEGIN

-- Nombre de Billes à disposition du joueur
    SELECT COUNT(DISTINCT idBilles) INTO vnbBilles
    FROM Collection Col, Composer Comp, Niveau Niv
    WHERE Col.idCollection = Comp.idCollection
    AND Col.idCollection = Niv.idCollection
    AND Niv.idNiveau = :NEW.idNiveau;
    
-- Nombre d'emplacements pour le niveau
    SELECT nbEmplacementsN INTO vnbEmplacementsN
    FROM Niveau
    WHERE idNiveau = :NEW.idNiveau;
    
  IF vnbEmplacementsN > vnbBilles THEN
    Rollback;
    RAISE_APPLICATION_ERROR(-20004,"Trop peu de billes");
  END IF;
END ;
/










-- PROCEDURE : Créer une combinaison avec aucune bille en double
-- PLUTOT UNE FONCTION NON ? Puisque ça retourne des éléments

CREATE OR REPLACE PROCEDURE P_creation_combinaison (pidPartie Partie.idPartie%TYPE) IS

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
-- Une partie ne peut contenir qu'une seule combinaison. Il faut donc vérifier
-- que la partie n'ait pas de combinaison.
    SELECT DISTINCT COUNT(C.idPartie) into nbidPartie
    FROM Combinaison C
    WHERE C.idPartie = nbidPartie;
    If nbidPartie != 0 THEN RAISE E_partie_a_combinaison;

-- Retrouver le niveau correspondant à la partie
    SELECT P.idNiveau into vNiveau
    FROM PARTIE
    WHERE P.idPartie = pidPartie ;   

-- Selection de la bonne collection de billes pour le niveau et du nombre d'emplacements
    SELECT Niv.idCollection, Niv.nbEmplacementsN INTO vidCollection,vnbEmplacementsN
    FROM Niveau Niv
    WHERE Niv.idNiveau = vNiveau ;

-- Sequence pour l'insertion dans la table Combinaison
    CREATE SEQUENCE Seq_Combinaison_positionBilles START WITH 1 INCREMENT BY 1 NOCYCLE;

-- Curseur permettant de sélectionner le bon nombre d'identifiants de billes selon le niveau
    FOR c1_ligne IN
   	 (SELECT idBille
   	  FROM     (SELECT idBille
   			 FROM Bille B,Composer Comp
   			 WHERE  B.idBille = Comp.idBille
 AND Comp.idCollection = vidCollection
   			 ORDER BY dbms_random.value)
   	  WHERE rownum <= vnbEmplacementsN
   	 ) LOOP
   	 -- Gestion de l'insertion dans la table Combinaison    
   	 INSERT INTO Combinaison VALUES(Seq_Combinaison_positionsBilles.nextval, pidPartie, c1_ligne.idBille);
    END LOOP ;

    DROP Seq_Combinaison_positionBilles ;

    COMMIT ;

-- Gestion des erreurs
EXCEPTION
    -- Une partie ne peut avoir qu'une seule et unique combinaison
    WHEN E_partie_a_combinaison THEN
   	 DBMS_OUTPUT.PUT_LINE("Une combinaison existe déjà pour la partie renseignée");

    -- Une bille ne peut être utilisée qu'une seule fois dans la combinaison pour chaque partie
    -- (problème de clé primaire)
    WHEN DUP_VAL_ON_INDEX THEN
   	 DBMS_OUTPUT.PUT_LINE("La bille est déjà utilisée dans la combinaison pour cette partie");

    -- Problème de clé étrangère : la bille ou la partie n'existe pas (lors du insert)
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










--une ligne doit être complètement remplie pour pouvoir être soumise
/*tester nombre emplacements billes
et nombre effectif de bille*/
Create Or Replace PROCEDURE Test_Ligne_Complète (pidPartie Partie.idPartie%TYPE)IS
DECLARE
vnbEmplacements number;
vnbBilles number;
BEGIN
	--on récupère le nombre d’emplacement disponible
	Select Niv.nbEmplacementsN Into vnbEmplacements 
	From Niveau Niv, Partie P
	Where Niv.idNiveau = P.idNiveau
  And P.idPartie = pidPartie;
	
	--on récupère le nombre de bille placé sur la ligne
	Select count(PropJ.idBille) Into vnbBilles
  From PropositionJoueur PropJ, Ligne L
  Where L.idPartie = PidPartie
  And L.idLigne = PropJ.idLigne
  And L.numeroL = (Select MAX(L.numeroL) From Ligne L);

	IF(vnbEmplacements - vnbBilles >= 0)Then
		RAISE_APPLICATION_ERROR(-20001,"La Ligne n'est pas complète !");
	end if;
END ;/









-- le joueur ne peut plus jouer pendant 4h si il a perdu 5 parties en une heure
CREATE OR REPLACE TRIGGER tbi_Partie
BEFORE INSERT ON Partie
FOR EACH ROW
DECLARE

CURSOR C(PidJoueur Joueur.idJoueur%TYPE) IS (SELECT P.dateP FROM Partie P, jouer J
    WHERE P.resultatP= FALSE AND J.idPartie=P.idPartie AND J.idJoueur=PidJoueur);
vnb NUMBER;
sanction EXCEPTION;
vdate_der_partie Date;

BEGIN
--date de la dernière partie
SELECT P.dateP INTO vdate_der_partie FROM Partie P, jouer J
WHERE J.idPartie=P.idPartie AND P.idPartie= (SELECT MAX (idPartie) );

FOR C_ligne IN C LOOP
    SELECT count(*) INTO vnb FROM Partie P
   	 WHERE (P.resultatP= FALSE) 
 AND (timestamps (vdate_der_partie) – timestamps(C_ligne.dateP)) <  3600);
   	 -- 3600: c'est à dire 3600 secondes => équivalent à une heure
END LOOP ;
IF (vnb=5) THEN
    WHILE (timestamps (:NEW.dateP) < timestamps (vdate_der_partie + 4*3600)) LOOP
    	RAISE sanction ;
    END IF ;
COMMIT ;
-- A vérifier
--EXCEPTION
WHEN NO_DATA_FOUND THEN
	DBMS_OUTPUT.PUT_LINE(‘Le joueur n’a pas encore jouer de parties’);
WHEN sanction THEN
DBMS_OUTPUT.PUT_LINE (‘Vous pourriez plus jouer pendant un moment’);
--préciser l’heure ?
-- Gestion des autres erreurs possibles
    WHEN OTHERS THEN
   	 DBMS_OUTPUT.PUT_LINE(SQLCODE||'-'||SQLERRM);
END;
/








-- les lignes doivent être rejouées dans l'ordre
CREATE OR REPLACE PROCEDURE Rejouer (Pidpartie  Partie.idPartie%TYPE) IS
--gérer le multi Pierrick

CURSOR C1(PidJoueur Joueur.idJoueur%TYPE) IS (SELECT * FROM Ligne L
    WHERE L.idPartie=Pidpartie AND L.idJoueur=PidJoueur ORDER BY L.numeroL) ;

CURSOR C2 (PidLigne Ligne.idLigne%TYPE) IS (SELECT * FROM PropositionJoueur PJ
    WHERE PJ.idLigne=PidLigne ORDER BY positionBilleLigne) ;

BEGIN
FOR C1_ligne IN C1 LOOP
	FOR C2_LIGNE IN C2(C1_ligne.idLigne) LOOP
    	DBMS_OUTPUT.PUT_LINE(C2_ligne.idLigne)
	END LOOP ;
END LOOP ;
END ;
/



--pour un même niveau la combinaison doit être différente de la partie précédente
CREATE OR REPLACE TRIGGER tbi_Combinaison
BEFORE INSERT ON Combinaison

FOR EACH ROW

DECLARE
-- CURSOR retournant la combinaison du niveau correspond à la derniere partie d'un joueur donné

--découper le curseur en plusieurs bouts

CURSOR C1 (PidJoueur Joueur.idJoueur%TYPE) IS ( SELECT positionBilleCombinaison, idBille
	FROM Combinaison C , Niveau N, Partie P,  Jouer J 
	WHERE 	C.idPartie=P.idPartie 
		AND P.idNiveau=N.idNiveau 
		AND P.dateP=( SELECT MAX(UNIX_TIMESTAMP(dateP)) FROM Partie P, Jouer J WHERE J.idPartie=P.idPartie AND J.idJoueur=PidJoueur)
		AND J.idPartie=P.idPartie 
		AND J.idJoueur=PidJoueur) ;

vnb NUMBER :=0;
changer_combinaison EXCEPTION;
vnbEmplacementsN Niveau.nbEmplacementsN%TYPE;

BEGIN

--mettre une contrainte concernant le niveau (pour travailler sur le même niveau)


-- Sélection du nombre d'emplacements du niveau de la partie
SELECT nbEmplacementsN into vnbEmplacementsN  FROM Niveau N, Partie P,  Jouer J
	WHERE N.idNiveau=P.idNiveau
		AND P.idPartie=J.idPartie 
		AND J.idJoueur=PidJoueur
FOR C1_ligne IN C1 LOOP 
-- comparaison des billes de l'ancienne combinaison à la nouvelle
-- incrémenter vnb tant qu'on a une même bille placée à une même position
    WHILE (vnb<C1_ligne.nbEmplacementsN) && (C1_ligne.idBille=:NEW.idBille) &&
     (C1_ligne.positionBilleCombinaison=:NEW.positionBilleCombinaison) LOOP
         vnb=vnb+1
    END LOOP;
    -- Si vnb est égal au nombre d'emplacements alors les deux combinaisons sont identiques
	IF (vnb=C1_ligne.nbEmplacementsN) THEN
		RAISE changer_combinaison;
	END IF;
END LOOP;
EXCEPTION
WHEN changer_combinaison THEN
	-- appeler la procédure créer combinaison avec :NEW.idPartie
	P_creation_combinaison(:NEW.idPartie);
WHEN OTHERS THEN DBMS_OUTPUT.PUT_LINE(SQLCODE||SQLERRM);
END;
/

--faire moins compliqué à lire ?





--yaya
---MOde monoJoueur
-- pour gérer les joueurs créée avec beaucoup d’exp qui n’ont pas encore joué de partie
create or replace trigger t_b_iPartie
before insert on Partie
for each row
DECLARE
vseuilN number;
vexperience number;

begin
    select seuilN into vseuilN
    from Niveau
    Where idNiveau = :NEW.idNiveau;

    select experienceJ INTO  vexperience
    from Jouer Joue, Joueur J
    where joue.idPartie = :new.idPartie and
   	   joue.idJoueur = J.idJoueur ;

IF vseuilN > vexperience THEN
RAISE_APPLICATION_ERROR(-20031,"Niveau pas encore debloquer");
END IF;
END ;


 

 --- mode mutijoueur
create or replace trigger t_b_i_multiJ_Partie
before insert on Partie
for each row
DECLARE
vnbJoueur number;
vExpMinJoueur number;
vseuilN number;
begin
    --- compter le nombre de joueur pour la nouvelle partie crée
    select count(dictinct idJoueur) into vnbJoueur
    from Jouer
    where idPartie=:new.idPartie;
    --- Partie multijoueur
    IF vnbJoueur > 1 THEN
   	 --- Experience minimun de tous les joueurs
   	 select MIN(experienceJ) into vExpMinJoueur
   	 from Jouer Joue, Joueur J
   	 where joue.idPartie = :new.idPartie and
   		   joue.idJoueur = J.idJoueur;
   	 --- Seuil requis pour le niveau nouvellement crée
   	 select seuilexpN into vseuilN
   	 from Niveau
   	 where idNiveau = :new.idNiveau;

   	 IF vseuilN >= vExpMinJoueur THEN
   	 RAISE_APPLICATION_ERROR(-20032,"Niveau pas encore debloquer par tous les joueur");
   	 end IF;
    END IF;
END ;













------------------High Score

-- enrober dans une procédure avec comme paramètre le niveau dont on souhaite connaître les highscores

--les 10 meilleurs du jour

-- même code que semaine mais SANS le IW


--les 10 meilleurs de la semaine
CREATE or REPLACE VIEW HighscoreSemaine AS
SELECT idJoueur, scoreP, count(*) as nb,
FROM Joueur J, Partie P, Jouer Jo
WHERE    J.idJoueur=Jo.idJoueur
    AND Jo.idPartie=P.idPartie
    --SYSDATE renvoie la date et l'heure actuelles définies pour le système d'exploitation sur lequel la base de données réside.
    -- IW permet de récupérer le numéro de la semaine
    AND to_char(to_date(P.dateP,'DD/MM/YYYY'')=to_char(to_date(SYSDATE,'DD/MM/YYYY'))
ORDER BY scoreP DESC
-- On ne récupère que les 10 meilleurs scores de la semaine
HAVING nb<11;

--les 10 meilleurs du mois
CREATE or REPLACE VIEW HighscoreMois AS
SELECT idJoueur, scoreP, count(*) as nb,
FROM Joueur J, Partie P, Jouer Jo
WHERE    J.idJoueur=Jo.idJoueur
    AND Jo.idPartie=P.idPartie
    --SYSDATE renvoie la date et l'heure actuelles définies pour le système d'exploitation sur lequel la base de données réside.
    AND to_char(to_date(P.dateP,'DD/MM/YYYY'))=to_char(to_date(SYSDATE,'DD/MM/YYYY'))
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







----Procédure pour calculer le score de la partie du joueur (plutôt une fonction)
CREATE OR REPLACE FUNCTION CalculScore(PidJoueur Joueur.idJoueur%TYPE, PidPartie Partie.idPartie%TYPE) RETURN NUMBER IS
DECLARE
vnbLigne Ligne.numeroL%TYPE; -- Nombre de lignes de la partie
vnbpionBlanc NUMBER; 	      -- Nombre de billes de la bonne couleur mal placées
-- Nombre de billes de la bonne couleur bien placées
vnbpionRouge NUMBER;
-- heure de debut de la Partie
vtempsDebutPartie Ligne.tempsLigneL%TYPE;
-- heure à laquelle il a joué la dernière ligne de la Partie
vtempsDerniereL Ligne.tempsLigneL%TYPE;
-- Le temps de jeu de la Partie
vtempsPartie Ligne.tempsLigneL%TYPE;
vscore Partie.scoreP%TYPE; -- penser à modifier le TYPE de scoreP en NUMBER
-- bonus d'une bille de la bonne couleur bien placée
bonusPionRouge NUMBER=3;
-- sanction sur le nombre de ligne proposé par le joueur
penaliteNbLigne NUMBER=20;
BEGIN
-- selection du nbre de lignes, du nbre de BilleRouges et du nbre de BilleBlancs de la Partie du joueur
SELECT MAX(numeroL), count(nbindiceRougeL), count(nbindiceBlancL) INTO vnbLigne, vnbpionRouge, vnbpionBlanc FROM Ligne L
WHERE L.idJoueur=PidJoueur AND  L.idPartie=PidPartie;

-- selectionner l'heure à laquelle le joueur a commencé la Partie
select dateP INTO vtempsDebutPartie FROM Partie P, Ligne L
WHERE L.idJoueur=PidJoueur AND L.idPartie=P.idPartie AND  L.idPartie=PidPartie ;

-- selectionner l'heure à laquelle le joueur a joué la dernière ligne de la Partie
select tempsLigneL INTO vtempsDerniereL FROM Ligne L
WHERE L.idJoueur=PidJoueur AND  L.idPartie=PidPartie AND L.numeroL=vnbLigne ;
vtempsPartie=vtempsDerniereL-vtempsPremiereL;
vscore=(vnbpionBlanc+(vnbpionRouge*bonusPionRouge))/(vtempsPartie+(vnbLigne*penaliteNbLigne))
RETURN (vscore);
END;
/

--INSERTION joueur : insertion du niveau 1 dans la table débloquer
CREATE OR REPLACE TRIGGER tai_Joueur
AFTER INSERT ON Joueur
FOR EACH ROW
BEGIN
INSERT INTO Debloquer VALUES (:NEW.idJoueur,1)
END;
/




----yaya
--l'experience du joueur ne peux pas baisser
create or replace trigger t_b_u_expJ
BEFORE UPDATE ON JOUEUR
for each row
BEGIN
    IF :OLD.experienceJ > :NEW.experienceJ THEN    
   	 RAISE_APPLICATION_ERROR(-20033,'L EXPERIENCE DU Joueur NE PEUX PAS BAISSER');
    END if;
END;

---la categorie du joueur ne peux pas baisser
create or replace trigger t_b_u_catJ
BEFORE UPDATE ON JOUEUR
for each row
BEGIN
    IF :OLD.idCat > :NEW.idCat THEN    
   	 RAISE_APPLICATION_ERROR(-20034,'La categorie du joueur ne peux pas baisser');
    END IF;
END;


-- Trigger : Insertion dans débloquer si la partie est gagnée
CREATE OR REPLACE TRIGGER t_a_u_partie
AFTER UPDATE ON partie
FOR EACH ROW
--Declaration de variables
DECLARE
vseuilExpN NUMBER;
vNbIdJoueur NUMBER;


-- compter IDJOUEUR DANS JOUER
SELECT COUNT(IDJOUEUR) INTO vNbIdJoueur
FROM JOUER
WHERE idPartie = :New.idPartie ;

-- Test pour voir si la partie a été gagné et si le joueur n'a pas déjà débloqué tous les niveaux 
--est-ce que la partie est gagnée ?
IF (:New.resultat = 1 ) THEN
	--pour 1 joueur
IF (vNbIdJoueur = 1) THEN
   	 	IF (:New.idniveau + 1 <= 50) THEN

   		 --Selection du seuil pour le niveau à atteindre
   		 SELECT seuilExpN INTO vseuilExpN
   		 FROM Niveau
   		 WHERE idNiveau = :New.idniveau+1 ;

   		 --Update de l'exp du joueur
   		 UPDATE JOUEUR SET experienceJ = vseuilExpN
   		 WHERE idjoueur = :New.idjoueur;

   		 -- Insertion dans débloquer
   		 INSERT ON DEBLOQUER VALUES (:New.idjoueur,:New.idniveau + 1);
   
   	 ELSE IF (:New.idniveau + 1 > 50) THEN
   	 	RAISE_APPLICATION_ERROR(-20030,"Le joueur a débloqué tous les niveaux");
   	 END IF;
--pour 2 joueur
ELSE
requête pour savoir quel joueur a gagné la partie
prendre en compte le calcul de l’expérience dans le sujet

    END IF;
ELSE RAISE_APPLICATION_ERROR(-20031,"Le joueur n'existe pas");


