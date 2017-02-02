package MasterMind.src;


public class Application {

	public static void main(String[] args) {
		ModeleMastermind mm = new ModeleMastermind(4,6);
		mm.genererCombinaison();
		int[] combinaison = {1,4,3,6};
		System.out.println("(1,4,3,6)");
		System.out.println(mm.nbChiffresBienPlaces(combinaison));
		System.out.println(mm.nbChiffresMalPlaces(combinaison));
		System.out.println(mm.toString());
	}
	//rajoute des scanners

}
