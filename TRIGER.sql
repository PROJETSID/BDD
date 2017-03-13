---MOde monoJoueur

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
		  joue.idJoueur = J.idJoueur


IF vseuilN >= vexperience THEN
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
vseuilN
begin
	--- scompter le nombre de joueur pour la nouvelle partie crée
	select count(dictinct idJoueur) into vnbJoueur
	from Jouer 
	where idPartie=:new.idPartie
	--- Partie multijoueur
	IF nbJoueur > 1 THEN
		--- Experience minimun de tous les joueurs
		select MIN(experienceJ) into vExpMinJoueur
		from Jouer Joue, Joueur J
		where joue.idPartie = :new.idPartie and
			  joue.idJoueur = J.idJoueur
		--- Seuil requis pour le niveau nouvellement crée
		select seuilexpN into vseuilN 
		from Niveau 
		where idNiveau = :new.idNiveau

		IF vseuilN >= vExpMinJoueur THEN
		RAISE_APPLICATION_ERROR(-20032,"Niveau pas encore debloquer par tous les joueur");
		end IF
	END IF;
END ;



---l'experience du joueur ne peux pas baisser
create or replace trigger t_b_u_expJ
BEFORE UPDATE ON JOUEUR
for each row 
BEGIN
	IF :OLD.experienceJ > :NEW.experienceJ THEN	
		RAISE_APPLICATION_ERROR(-20033,'L EXPERIENCE DU Joueur NE PEUX PAS BAISSER')
	END if;
END;

---la categorie du joueur ne peux pas baisser
create or replace trigger t_b_u_catJ
BEFORE UPDATE ON JOUEUR
for each row 
BEGIN
	IF :OLD.idCat > :NEW.idCat THEN	
		RAISE_APPLICATION_ERROR(-20034,'La categorie du joueur ne peux pas baisser')
	END IF;
END;
