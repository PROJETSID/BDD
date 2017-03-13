//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//fonction d'effacement d'une ligne 			
	function effacer() {
		for (colonne=1;colonne <= this.nbcolonnes;colonne++) {
			//réinitialisation des images de la ligne
			img_en_cour='i' + ligne + colonne;
			document[img_en_cour].src='vide.gif';
		};
		//remise de la position de colonne a 1
		colonne=1;
	};