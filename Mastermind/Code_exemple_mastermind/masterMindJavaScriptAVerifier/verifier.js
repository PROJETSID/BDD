//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//fonction de vérification de la ligne en cours
	function verifier() {	
		//test si toutes les cases on été remplies
		if (colonne<=this.nbcolonnes) {
			window.alert('Remplissez toutes les cases !');
		} else {
			//initialise les boules rouges et les boules grses à 0
			//bouler : bonne couleur bien placer / bouleg : bonne couleur mal placer
			bouler=0;
			bouleg=0;
			//test pour le nombre de boules rouges c'est a dir les boules bien placés de bonne couleur
			for (colonne=1;colonne<=this.nbcolonnes;colonne++) {
				//test si la boule solution et la boule proposition sont égal
				if (this.proposition[colonne].couleur==this.solution[colonne].couleur) {
					//incrémente les boules rouges
					bouler++;
					//blocage des boules pour ne plus les recomparer en mettant l'etat a true
					this.solution[colonne].etat=true;
					this.proposition[colonne].etat=true;
					//placement des boules rouges
					nom_img='p' + ligne + bouler;
					document[nom_img].src='bp.gif';
				};
			};
			
			//test pour le nombre de boules grise qui sont les boules de bonnes couleurs mais mal placés
			for (colonne=1;colonne<=this.nbcolonnes;colonne++) {
				//test si la boule proposé n'a pas encore été testée
				if (this.proposition[colonne].etat==false) {
					for (i=1;i<=this.nbcolonnes;i++) {
						//test si la solution n'a pas encore été testé mais dans une autre boucle
						//test aussi si la proposition n'a pas non plus été testé dans cette boucle
						if (this.solution[i].etat==false && this.proposition[colonne].etat==false) {
							//test si la couleur de la proposition en cour est la meme que la solution
							if (this.proposition[colonne].couleur==this.solution[i].couleur) {
								//incrémente les boules grises
								bouleg++;
								//bloque pour comparaison la boule de solution et la boule de proposition
								this.solution[i].etat=true;
								this.proposition[colonne].etat=true;
								//ajoute aux boules grises les boulesrouges déjà mises
								boule=bouler+bouleg;
								//placement des boules grises
								nom_img='p' + ligne + boule;
								document[nom_img].src='bc.gif';
							};
						};
					};
				};
			};
			//réinitialise les etats des propositions et des solutions pour la prochaine ligne
			for (var i=0;i<=this.nbcolonnes;i++) {
				this.proposition[i].etat=false;
				this.solution[i].etat=false;
			};
			//test si il n'y a que des boules rouges et si oui alert de la victoire
			if (bouler==this.nbcolonnes) {
				//affiche la solution
				this.soluce();
				window.alert("Bravo tu as gagné en "+ligne+" coups");
				ligne=this.nblignes+1;
			//si non test si on est a la fin et que c'est perdu !
			} else if (ligne==this.nblignes) {
				//affiche la solution
				this.soluce();
				window.alert("Désolé, tu as perdu!");
			};
			//changement de la ligne de position (incrémentation) et remise de la colonne a 1
			ligne++;
			colonne=1;
		};
	};
