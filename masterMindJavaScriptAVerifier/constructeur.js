//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//Déclaration de la classe principal mastermind
	function Mastermind(nbcolonnes, nblignes, nbcouleurs, nomvariable) {
		//Déclaration des attributs d'objets
		this.nbcolonnes = nbcolonnes;
		this.nblignes = nblignes;
		this.nbcouleurs = nbcouleurs;
		this.nomvariable = nomvariable;
		this.proposition = new Array();
		this.solution = new Array();
		
		//Déclaration des méthodes d'objets
		this.initialisation = initialisation;
		this.affichage = affichage;
		this.affich_bouttons = affich_bouttons;	
		this.affich_couleurs = affich_couleurs;
		this.affich_tableau = affich_tableau;
		this.affich_soluce = affich_soluce;
		this.placer = placer;
		this.effacer = effacer;
		this.verifier = verifier;
		this.soluce = soluce;
		this.recommencer = recommencer;
		
		//Constructeur principal
		this.initialisation();
		this.affichage();
	
	};	