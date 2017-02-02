package MasterMind.src;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.FlowLayout;
import java.awt.GridLayout;
import java.util.Arrays;
import java.util.HashMap;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class VueMastermind extends JPanel {

	private JTextField[] bpIHM;
	public JTextField[] combinaisonOrdiIHM; //
	private JButton[][] combinaisonsJoueursIHM;
	private JTextField[] mpIHM;
	private int nbCouleurs;
	private static int NBMAX_COMBINAISONS;
	private static JButton[] paletteIHM;
	private static long serialVersionUID;
	private int taille;
	//private HashMap<Integer,Color> couleur;
	private static Color[] couleur= {Color.BLUE,Color.RED,Color.GREEN,Color.YELLOW,Color.CYAN,Color.MAGENTA};

	//on ne fait que manipuler la vue
	
	public VueMastermind() {

		combinaisonsJoueursIHM = new JButton[10][4];
		combinaisonOrdiIHM = new JTextField[4];
		bpIHM = new JTextField[10];
		mpIHM = new JTextField[10];
		nbCouleurs = 6;
		NBMAX_COMBINAISONS = 10;
		paletteIHM = new JButton[6];
		taille = 4;
		
//		couleur = new HashMap<Integer,Color>();
//		couleur.put(1,Color.BLUE);
//		couleur.put(2,Color.RED);
//		couleur.put(3,Color.GREEN);
//		couleur.put(4,Color.YELLOW);
//		couleur.put(5,Color.CYAN);
//		couleur.put(6,Color.MAGENTA);
		
		// panneau general
		this.setLayout(new BorderLayout());
		// sous-panneau haut
		JPanel haut = new JPanel();
		haut.setLayout(new FlowLayout());
		// legende
		JLabel TitreLegende = new JLabel("couleur : ");
		JPanel couleurLegende = new JPanel();
		couleurLegende.setLayout(new GridLayout(1, 6));
		for (int i = 0; i < 6; i++) {
			JButton b = new JButton();
			b.setBackground(this.chiffreEnCouleur(i));
			paletteIHM[i] = b;
			couleurLegende.add(b);
		}
		haut.add(TitreLegende);
		haut.add(couleurLegende);
		this.add(haut, BorderLayout.NORTH);

		// sous-panneau centre
		JPanel centre = new JPanel();
		centre.setLayout(new GridLayout(1, 2));
		// grille
		JPanel grille = new JPanel();
		grille.setLayout(new GridLayout(10, 2));

		for (int j = 0; j < 10; j++) {
			// lignes grille
			JPanel ligneGrille = new JPanel();
			ligneGrille.setLayout(new GridLayout(1, 4));
			for (int k = 0; k < 4; k++) {
				JButton b = new JButton();
				if (j != 0) {
					b.setEnabled(false);
				}
				combinaisonsJoueursIHM[j][k] = b;
				ligneGrille.add(b);
			}
			grille.add(ligneGrille);
			// indications
			JPanel indications = new JPanel();
			indications.setLayout(new GridLayout(2, 2));
			JLabel bm = new JLabel("BM", JLabel.CENTER);
			JLabel bp = new JLabel("BP", JLabel.CENTER);
			JTextField bmValeur = new JTextField();
			bmValeur.setEditable(false);
			mpIHM[j] = bmValeur;
			JTextField bpValeur = new JTextField();
			bpValeur.setEditable(false);
			bpIHM[j] = bpValeur;
			indications.add(bm);
			indications.add(bp);
			indications.add(bmValeur);
			indications.add(bpValeur);
			grille.add(indications);
		}
		centre.add(grille);
		this.add(centre, BorderLayout.CENTER);

		// sous-panneau bas
		JPanel bas = new JPanel();
		bas.setLayout(new GridLayout(1, 2));
		// saisie
		JPanel saisie = new JPanel();
		saisie.setLayout(new GridLayout(1, 4));
		for (int l = 0; l < 4; l++) {
			JTextField combiOrdi = new JTextField();
			combiOrdi.setEditable(false);
			combinaisonOrdiIHM[l] = combiOrdi;
			bas.add(combiOrdi);
		}
		// valider
		JButton b = new JButton("Valider");
		saisie.add(b);
		bas.add(saisie);
		this.add(bas, BorderLayout.SOUTH);
		//ajout écouteur 1 2 3
		ControleurMasterMind controleur = new ControleurMasterMind(this);
		//1 bouttons de la grille
		for (int i = 0; i < 10; i++) {
			for (int j = 0; j < 4; j++) {
				combinaisonsJoueursIHM[i][j].addActionListener(controleur);
			}
		}
		//2 bouttons de la palette
		for (int i = 0; i < 6; i++) {
			paletteIHM[i].addActionListener(controleur);
		}
		//3 boutton valider
		b.addActionListener(controleur);
	}
	public void activerCombinaison(int i) {
		for (int j = 0; j < 4; j++) {
			combinaisonsJoueursIHM[i][j].setEnabled(true);
		}
	}
	public void afficherBP(int i, int nbBP) {
		bpIHM[i].setText("" + nbBP);
		
//		on fait ça dans le modèle !
//		nbBP = 0;
//		for (int j = 0; j < 4; j++) {
//			if (combinaisonOrdiIHM[j].getBackground().equals(
//					combinaisonsJoueursIHM[i][j].getBackground())) {
//				nbBP += 1;
//			}
//		}
//		bpIHM[i].setText("" + nbBP);
	}
	public void afficherCombinaisonOrdinateur(int[] tableauCouleurs) {
		 for (int i = 0; i < 4; i++) {
			 combinaisonOrdiIHM[i].setBackground(this.chiffreEnCouleur(tableauCouleurs[i]));
		 }
	}
	public void afficherMP(int i, int nbMP) {
		mpIHM[i].setText("" + nbMP);
	}
	/**
	 * @param b
	 * @param i
	 * @return
	 */
	public boolean appartientCombinaison(JButton b, int i) {
		for (int j = 0; j < 4; j++) {
			if (b.equals(combinaisonsJoueursIHM[i][j])) {
				return true;
			}
		}
		return false;
	}
	public static boolean appartientPalette(JButton b) {
		for (int j = 0; j < 6; j++) {
			if (b.equals(paletteIHM[j])) {
				return true;
			}
		}
		return false;
	}
	public Color chiffreEnCouleur(int i) {
		return VueMastermind.couleur[i];
	}
	public boolean combinaisonComplete(int i) {
		for (int j = 0; j < 4; j++) {
			if (combinaisonsJoueursIHM[i][j].getBackground().equals(null)){
				return false;
			}
		}
		return true;
	}
	public int[] combinaisonEnEntiers(int i) {
		int[] tabColor = new int[4];
		for (int j = 0; j < 4; j++) {
			tabColor[j] = couleurEnChiffres(combinaisonsJoueursIHM[i][j].getBackground());
		}
		return tabColor;
//		int[] tabColor = new int[4];
//		for (int j = 0; j < 4; j++) {
//			for (int k = 0 ; k < getCouleur().length ; k++){
//				if ((combinaisonsJoueursIHM[i][j].getBackground()).equals(getCouleur()[k])) {
//					tabColor[j] = k;
//				}
//			}
//		}
//		System.out.println("Arrays.toString(tabColor)"+Arrays.toString(tabColor));
//		return tabColor;
	}
	public static int couleurEnChiffres(Color c) {
		for (int i = 0 ; i < getCouleur().length ; i++){
			if(c == getCouleur()[i]){
				return i;
			}
		}
		return 13;
		
//		HashMap<Color,Integer> couleur;
//			couleur = new HashMap<Color,Integer>();
//			couleur.put(Color.BLUE,1);
//			couleur.put(Color.RED,2);
//			couleur.put(Color.GREEN,3);
//			couleur.put(Color.YELLOW,4);
//			couleur.put(Color.CYAN,5);
//			couleur.put(Color.MAGENTA,6);
			
			//plutot une enum
		}
	public void desactiverCombinaison(int i) {
		for (int j = 0; j < 4; j++) {
			combinaisonsJoueursIHM[i][j].setEnabled(false);
		}
	}
	public int getNbCouleurs() {
		return this.nbCouleurs;
	}
	public int getTaille() {
		return this.taille;
	}

	public static Color[] getCouleur() {
		return couleur;
	}

	public static void setCouleur(Color[] couleur) {
		VueMastermind.couleur = couleur;
	}
	public JTextField[] getCombinaisonOrdiIHM() {
		return combinaisonOrdiIHM;
	}
	
	public JButton[][] getCombinaisonsJoueursIHM() {
		return combinaisonsJoueursIHM;
	}
}
