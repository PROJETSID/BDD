package MasterMind.src;

import java.awt.GridLayout;

import javax.swing.JFrame;
import javax.swing.UIManager;


public class Fenetre extends JFrame{

	public static void main(String[] args) {
		JFrame f = new JFrame();
		f.setLayout(new GridLayout(1,1));
		f.add(new VueMastermind());
		f.setTitle("MasterMind");
		f.pack();
		f.setVisible(true);
		f.setSize(400,400);
    }

}
