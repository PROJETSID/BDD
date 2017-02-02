//Ce mastermind a été réaliser par David De Groote (dadg@freesurf.ch), apprenti informaticien à l'EHMP
	//fonction qui réunit toutes les fonctions d'affichages graphique
	function affichage() {
		this.affich_bouttons();	
		this.affich_couleurs();
		this.affich_tableau();
		this.affich_soluce();
	};
	
	//fonction d'affichage des boutons verifier effacer et recommencer
	function affich_bouttons() {
		//effacer appel la fonction effacer
		document.write("<input type=\"button\" class='s'style='font-weight:bold; color:#000000; background-color:#FFD18C; border-style:outset; border-color:#FFB74D;' name=\"Effacer\" value=\"Effacer la ligne\" onClick=\"" + this.nomvariable + ".effacer()\">");	
		//recommencer appel la fonction recommencer
		document.write("<input type=\"button\" class='s'style='font-weight:bold; color:#000000; background-color:#FFD18C; border-style:outset; border-color:#FFB74D;' name=\"Recommencer\" value=\"Recommencer\" onClick=\"" + this.nomvariable + ".recommencer()\"><p></p>");	
		//verifier appel la fonction verifier
		document.write("<input type=\"button\" class='s'style='font-weight:bold; color:#000000; background-color:#8AD0FF; border-style:outset; border-color:#4DB8FF;' name=\"Verifier\" value=\"Vérifier la ligne\" onClick=\"" + this.nomvariable + ".verifier()\"><p></p>");	
	};
	
	//fonction d'affiche des couleurs pour le choix selon le nombre de couleurs passer en paramètre
	function affich_couleurs() {
		for (i=1;i<=this.nbcouleurs;i++) {
			//affichage des couleurs 
			document.writeln("<a href=\"javascript:;\" onclick=\"" + this.nomvariable + ".placer(" + i + ")\"><img src=" + i + ".gif width=\"30\" height=\"30\"></a>");
		};	
		document.write("<br>");
	};
	
	//fonction d'affichage du tableau
	function affich_tableau() {
		document.write("<table bgcolor=\"#000000\" border=0 cellspacing=1 cellpadding=3>");
		//boucle d'insertion des lignes
		for (i=1;i<=this.nblignes;i++) {
			document.write("<tr>");
			//numero de lignes
			document.write("<td bgcolor=\"#CCCCCC\" width=\"30\" align=\"center\">",i,"</td>");
			//boucle d'insertion des colonnes avec l'image vide.gif dans chaque cellule
			for (j=1;j<=this.nbcolonnes;j++) {
				document.write("<td bgcolor=\"#CCCCCC\"><img src=\"vide.gif\" name=\"i"+i+j+"\" width=\"30\" height=\"30\"></td>");
			};
			//cellule pour les reponses
			document.write("<td bgcolor=\"#F0F0F0\">");
			//boucle d'insertion des images rien.gif pour les reponses 
			for (j=1;j<=this.nbcolonnes;j++) {
				document.write("<img src=\"rien.gif\" name=\"p"+i+j+"\" width=\"15\" height=\"15\">");
				if (j==Math.round(this.nbcolonnes/2)) document.write("<br>");
			};
			document.write("</td>");
			document.write("</tr>");
		};
		document.write("</table>");
	};
	
	//fonction d'affichage des cases pour afficher la solution après !
	function affich_soluce() {
		document.writeln("<br>Solution:<br>");
		for (i=1;i<=this.nbcolonnes;i++) {
			//affichage des cases 
			document.writeln("<img src=sol.gif name=\"s"+i+"\" width=\"30\" height=\"30\">");
		};	
		document.write("<br>");
	}; 