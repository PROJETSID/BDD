//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//function d'insertion des couleurs dans la soluce !
	function soluce() {
		for (i=1;i<=this.nbcolonnes;i++) {
			img_en_cour='s' + i;
			adresse= + this.solution[i].couleur + '.gif';
			//change l'adresse de l'image
			document[img_en_cour].src=adresse;	
		};
	};