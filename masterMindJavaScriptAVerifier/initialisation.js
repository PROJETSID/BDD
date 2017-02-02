//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//initialisation de la partie 
	function initialisation() {
		//demande du nombre de couleur, colonnes, lignes désirés
		this.nbcolonnes = prompt(' Entrer le nombre de colonnes (4 par défault)',"");
		if (this.nbcolonnes == '') {
			this.nbcolonnes = 4;
		};
		this.nblignes = prompt(' Entrer le nombre de lignes (9 par défault)',"");
		if (this.nblignes == '') {
			this.nblignes = 9;
		};
		this.nbcouleurs = prompt(' Entrer le nombre de couleurs(4 par défault, max 6)',"");
		if (this.nbcouleurs == '') {
			this.nbcouleurs = 4;
		};
		if (this.nbcouleurs >= 7) {
			this.nbcouleurs = 4;
			window.alert("Le max de couleurs est 8 reprise de 4 par défault !");
		};
		//initialisation des objets boules
		for (var i=0;i<=this.nbcolonnes;i++) {
			this.proposition[i] = new UneBoule(0, false);
			this.solution[i] = new UneBoule(Math.round(Math.random()*(this.nbcouleurs-1)+1), false);
		};
		//initialisation des variables de position ligne et colonne
		ligne=1;
		colonne=1;
	};