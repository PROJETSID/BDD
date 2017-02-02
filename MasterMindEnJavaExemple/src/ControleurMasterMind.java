package MasterMind.src;

import java.awt.Color;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.Arrays;

import javax.swing.JButton;

public class ControleurMasterMind implements ActionListener{

	private VueMastermind vue; 
	private ModeleMastermind modele;
	private ETAT etatCourant;
	private Color couleurChoisie;
	private int ligneActive;
	
	enum ETAT {
		DEBUT_COMBINAISON,
		CHOIX_COULEUR,
		CHOIX_POSITION,
		FIN
	}
	
	public ControleurMasterMind(VueMastermind vue) {
		this.vue = vue;
		this.modele = new ModeleMastermind(4,6);
		this.modele.genererCombinaison();
		this.etatCourant = ETAT.DEBUT_COMBINAISON;
		this.ligneActive = 0;
		this.vue.activerCombinaison(this.ligneActive);
	}

	//penser à modifier les états du Modèle
	
	@Override
	public void actionPerformed(ActionEvent ae) {
		JButton b = (JButton) ae.getSource();
		if ((this.etatCourant == ETAT.DEBUT_COMBINAISON) && (VueMastermind.appartientPalette(b))){
			System.out.println("trait 2 depuis DEBUT_COMBINAISON");
			this.couleurChoisie = b.getBackground();
			this.etatCourant = ETAT.CHOIX_COULEUR;
		}else if((this.etatCourant == ETAT.CHOIX_COULEUR) && (this.vue.appartientCombinaison(b,this.ligneActive))){
			System.out.println("trait 3 depuis CHOIX_COULEUR");
			b.setBackground(this.couleurChoisie);
			this.etatCourant = ETAT.CHOIX_POSITION;
		}else if((this.etatCourant == ETAT.CHOIX_POSITION) && (VueMastermind.appartientPalette(b))){
			System.out.println("trait 2 depuis CHOIX_POSITION");
			this.couleurChoisie = b.getBackground();
			this.etatCourant = ETAT.CHOIX_COULEUR;
		}else if((this.etatCourant == ETAT.CHOIX_POSITION) && (!this.vue.appartientCombinaison(b,this.ligneActive))&&(!VueMastermind.appartientPalette(b))&&(this.ligneActive<9)){
			System.out.println("trait 4 et 5 depuis CHOIX_POSITION");
			//combinaison non trouvée ?
			this.vue.desactiverCombinaison(this.ligneActive);
			this.etatCourant = ETAT.DEBUT_COMBINAISON;
			//modification du modele
			this.vue.afficherBP(this.ligneActive,modele.nbChiffresBienPlaces(this.vue.combinaisonEnEntiers(this.ligneActive)));
			this.vue.afficherMP(this.ligneActive,modele.nbChiffresMalPlaces(this.vue.combinaisonEnEntiers(this.ligneActive)));
			this.ligneActive += 1;
			this.vue.activerCombinaison(this.ligneActive);
			
			//combinaison trouvée ?
			//||(this.vue.getCombinaisonOrdiIHM()==this.vue.getCombinaisonsJoueursIHM())
		}else if((this.etatCourant == ETAT.CHOIX_POSITION) && (!this.vue.appartientCombinaison(b,this.ligneActive))&&(!VueMastermind.appartientPalette(b))&&(this.vue.combinaisonComplete(this.ligneActive))&&(this.ligneActive>=9)||(modele.nbChiffresBienPlaces(this.vue.combinaisonEnEntiers(this.ligneActive))==4)){
			System.out.println("trait 4 et 6 depuis CHOIX_POSITION");
			this.vue.afficherBP(this.ligneActive, 0);
			this.vue.afficherMP(this.ligneActive, 0);
			this.vue.desactiverCombinaison(this.ligneActive);
			//on ne récupère de la vue que les infos que l'utilisateur fournit
			this.vue.afficherCombinaisonOrdinateur(this.modele.getCombinaison());
			this.etatCourant = ETAT.FIN;
		}
	}
}
