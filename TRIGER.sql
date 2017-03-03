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
	from Joueur 
	Where idJoueur = :NEW.idJoueur;


IF vseuilN >= vexperience THEN
RAISE_APPLICATION_ERROR(-20031,"Niveau pas encore debloquer");
END IF;
END ;


 

 --


