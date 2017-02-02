package MasterMind.src;

import java.awt.GridLayout;

import javax.swing.JApplet;

public class AppletMastermind extends JApplet{
	
	public void init() {
		this.setLayout(new GridLayout(1,1));
		this.add(new VueMastermind());
	}
}

