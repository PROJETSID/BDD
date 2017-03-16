//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//fonction recommencer (elle permet de reinialiser tout le tableau et de refaire un tirage de couleur
	//elle est appeller par la bouton recommencer
	function recommencer() {
		//réinitialisation des variables de position
		ligne=1;
		colonne=1;
		//random des couleurs de la solution
		for (var i=1;i<=this.nbcolonnes;i++) {
			this.solution[i].couleur = Math.round(Math.random()*(this.nbcouleurs-1)+1);
			img_en_cour='s'+ i;
			document[img_en_cour].src='sol.gif';
		};
		//réinitialisation des images du tableau a vide.gif et rien.gif 	
		for (var i=1;i<=this.nblignes;i++) {
			for (var j=1;j<=this.nbcolonnes;j++) {
				img_en_cour='i'+ i + j;
				document[img_en_cour].src='vide.gif';
				img_en_cour='p'+ i + j;
				document[img_en_cour].src='rien.gif';
			};
		};
	};
