<?php
    class form {
        //définition des constantes
        // const CONST = valeur ;
        //définition des attributs
        private $form ;
        //définition des méthodes

        /*
         * Constructeur de la classe form
         * initialise la mise en forme du formulaire
         * $méthode = methode de transmission des données du formulaire
         * $action = page où se trouvera le traitement du formulaire
         * $legend = valeur de la balise <legend>
         */
        public function __construct($methode, $action, $legend) {
            $this->form = "<form method=\"$methode\" action=\"$action\" class=\"form-horizontal\">
                           <fieldset>
                           <legend>$legend</legend>" ;
        }

        /*
         * Ajoute un champ Texte
         * $label = Label du champ
         * $name = nom du champ
         * $placeholder = Exemple de valeur pour le champ
         * $value = Valeur du champ
         * $span = message d'aide permettant de remplir le champ
         */
        public function setText($label, $name, $placeholder, $value, $span){
            $text = "<div class=\"form-group\">
                     <label for=\"inputText3\" class=\"col-sm-2 control-label\">$label</label>
                      <div class=\"col-sm-10\">
                       <input type=\"text\" class=\"form-control\" id=\"inputText3\" placeholder=\"$placeholder\"
                       name=\"$name\" value='$value' required  />
                       <span id=\"helpBlock\" class=\"help-block\">$span</span><br><br>
                      </div>
                     </div>" ;
            $this->form = $this->form.$text;
        }

        /*
         * Ajoute un champ Mot de passe
         * $label = Label du champ
         * $name = nom du champ
         */
        public function setPwd($label, $name){
            $pwd = "<div class=\"form-group\">
                     <label for=\"inputText3\" class=\"col-sm-2 control-label\">$label</label>
                      <div class=\"col-sm-10\">
                       <input type=\"password\" class=\"form-control\" id=\"inputText3\" name=\"$name\" required  /><br><br>
                      </div>
                     </div>" ;
            $this->form = $this->form.$pwd;
        }

        /*
         * Ajoute un Bouton
         * $name = nom du champ
         * $value = Valeur du champ
         */
        public function setSubmit($name, $value){
            $submit = "<div class=\"form-group\">
                        <div class=\"col-sm-offset-2 col-sm-10\">
                         <button type=\"submit\" class=\"btn btn-default\" name=\"$name\">$value</button>
                        </div>
                       </div><br>" ;
            $this->form = $this->form.$submit ;
        }

        /*
         * Ajoute un champ de recherche
         * $label = Label du champ
         * $name = nom du champ
         * $value = Valeur du champ
         * $span = message d'aide permettant de remplir le champ
         */
        public function setSearch($label, $name, $value, $span) {
            $search = "<div class=\"form-group\">
                     <label for=\"inputSearch3\" class=\"col-sm-2 control-label\">$label</label>
                      <div class=\"col-sm-10\">
                       <input type=\"text\" class=\"form-control\" id=\"inputSearch3\" name=\"$name\" value=\"$value\"/>
                       <span id=\"helpBlock\" class=\"help-block\">$span</span><br><br>
                      </div>
                     </div>" ;
            $this->form = $this->form.$search ;
        }

        /*
         * Ajoute trois champs pour des nombres
         * Le premier est pour l'année
         * Le deuxième est pour le mois
         * Le troisième est pour le jour
         * $label = Label du champ
         */
        public function setDate($label){
             $annee = date('Y')-200 ;
            $date = "<div class=\"form-group\">
                     <label for=\"inputDate3\" class=\"col-sm-2 control-label\">$label</label>
                      <div class=\"col-sm-10\">
                       <input type=\"number\" class=\"form-control\" id=\"inputDate3\" name=\"annee\"
                       placeholder=\"année\"  min='$annee' required/>
                       <span id=\"helpBlock\" class=\"help-block\">Année en chiffres</span><br>
                       <input type='number' class='form-control' id='inputDate3' name='mois'
                       placeholder='mois' min='1' max='12' required/>
                       <span id=\"helpBlock\" class=\"help-block\">Mois en chiffres</span><br>
                       <input type='number' class='form-control' id='inputDate3' name='jour'
                       placeholder='jour' min='1' max='31' required/>
                       <span id=\"helpBlock\" class=\"help-block\">Jour en chiffres</span><br>
                      </div>
                     </div><br>" ;
            $this->form = $this->form.$date ;
        }

        /*
         * Ajoute deux champs pour des nombres
         * Le premier pour l'heure
         * Le second pour les minutes
         * $label = Label du champ
         */
        public function setTime($label) {
            $time = "<div class=\"form-group\">
                     <label for=\"inputHeure3\" class=\"col-sm-2 control-label\">$label</label>
                      <div class=\"col-sm-10\">
                       <input type=\"number\" class=\"form-control\" id=\"inputHeure3\" name='heure'
                       placeholder=\"Heure\" min='08'  max='18' required/>
                       <span id=\"helpBlock\" class=\"help-block\">Heure en chiffres</span><br>
                       <input type='number' class='form-control' id='inputHeure3' name='minutes'
                       placeholder='Minutes' min='0' max='59' required>
                       <span id=\"helpBlock\" class=\"help-block\">Minutes en chiffres</span><br>
                      </div>
                     </div><br>" ;
            $this->form = $this->form.$time ;
        }

        /*
         * Ajoute un champ pour les nombre
         * Il représente les minutes de la durée de la consultation
         * $label = Label du champ
         */
        public function setDuree($label) {
            $time = "<div class=\"form-group\">
                     <label for=\"inputHeure3\" class=\"col-sm-2 control-label\">$label</label>
                      <div class=\"col-sm-10\">
                       <input type='number' class='form-control' id='inputHeure3' name='duree'
                       placeholder='Minutes' min='0' max='59' required>
                       <span id=\"helpBlock\" class=\"help-block\">Minutes en chiffres</span><br>
                      </div>
                     </div><br>" ;
            $this->form = $this->form.$time ;
        }

        /*
         * Ajoute une liste déroulante
         * Cette liste ira chercher dans la base de données les informations qu'elle doit contenir
         * La valeur d'une option de la liste sera l'id de cette valeur
         * Cette fonction permettra de récupérer l'id des patients ou médecins
         * Chaque options affichera le prénom puis le nom du patient/médecin
         * $table = Nom de la table contenue dans la bdd
         * $label = Label du champ
         * $name = nom du champ
         */
        public function setSelect($table, $label, $name){
            $login = 'u450364109_loui' ;
            $mdp = 'etudiant' ;

            try {
                $bdd = new PDO('mysql:host=mysql.hostinger.fr; dbname=u450364109_gest', $login , $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)) ;
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            $selectTable = $bdd->query('SELECT * FROM `'.$table.'`') ;

                $select = "<div class=\"form-group\">
                            <label for=\"inputSelected3\" class=\"col-sm-2 control-label\">$label</label>
                            <div class=\"col-sm-10\">
                             <select class=\"form-control\" name='$name' id='inputSelected3'>" ;
                                while($data=$selectTable->fetch()) {
                                    $option = "<option value='$data[0]'>$data[2] $data[1]</option>" ;
                                    $select = $select.$option ;
                               }
                             $selectF = "</select>
                            </div>
                           </div><br><br>";
                            $select = $select.$selectF ;
            $this->form = $this->form.$select ;
        }

        /*
         * Permet de faire une liste déroulante des médecins
         * Par défaut le médecin référant du patient transmis sera proposé
         * $label : label du champ
         * $nom : nom du champ
         * $id : id du patient
         */
        public function setMedecin($label, $name, $id){
            $login = 'u450364109_loui' ;
            $mdp = 'etudiant' ;

            try {
                $bdd = new PDO('mysql:host=mysql.hostinger.fr; dbname=u450364109_gest', $login , $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)) ;

            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            $selectTable = $bdd->query('SELECT * FROM `Medecin`') ;
            $medecinReferant = $bdd->query('Select medecinReferant from Patient where idPatient = \''.$id.'\'') ;
            $dataMedecin = $medecinReferant->fetch() ;

            $select = "<div class=\"form-group\">
                            <label for=\"inputSelect3\" class=\"col-sm-2 control-label\">$label</label>
                            <div class=\"col-sm-10\">
                             <select class=\"form-control\" name='$name' id='inputSelect3'>" ;
            while($data=$selectTable->fetch()) {
                if ($data[0] == $dataMedecin[0]){
                    $option = "<option value='$data[0]' selected='selected'>$data[2] $data[1]</option>" ;
                }else{
                    $option = "<option value='$data[0]'>$data[2] $data[1]</option>" ;
                }
                $select = $select.$option ;
            }
            $selectF = "</select>
                            </div>
                           </div><br><br>";
            $select = $select.$selectF ;
            $this->form = $this->form.$select ;
        }

        /*
         * Ajoute un champ hidden
         * $name = nom du champ
         * $value = Valeur du champ
         */
        public function setHidden($name, $value){
            $hidden = "<div class=\"form-group\">
                       <input type='hidden' name='$name' value='$value'><br>
                      </div><br>" ;
            $this->form = $this->form.$hidden ;
        }

        /*
         * Affiche le formulaire sur la page
         */
        public function getForm(){
            $foot = "</fieldset>
                             </form>" ;
            $this->form = $this->form.$foot ;
            echo $this->form ;
        }

    }
?>