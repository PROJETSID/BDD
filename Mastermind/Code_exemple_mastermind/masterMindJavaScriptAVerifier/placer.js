//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//fonction de placement des boules dans le tableau
	//elle est appeller quand on click sur une couleur (la couleur y'est passer en paramètres)
	function placer(couleur) {
		//test si la partie est finie ! et dis c'est fini si c'est le cas !
		if (ligne > this.nblignes) {
			window.alert("C'est fini ! Recommencez");
		} else {
			//test si la ligne est complète et averti qu'il faut valider ou effacer si c'est le cas !
			if (colonne > this.nbcolonnes) {
				window.alert('Il faut valider mnt, pour recommencer cette ligne effacer');
			} else {
				//preparation des variables pour le changement d'image
				img_en_cour='i' + ligne + colonne;
				adresse= + couleur + '.gif';
				//change l'adresse de l'image
				document[img_en_cour].src=adresse;
				//met dans l'objet en cour la couleur choisie
				this.proposition[colonne].couleur=couleur;
				//incrémente la variable de position colonne
				colonne++;
			};		
		};
	};