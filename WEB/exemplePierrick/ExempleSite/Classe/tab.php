<?php
    class tab {
        //définition des constantes
        //définition des attributs
        private $tab ;
        //définition des méthodes

        /*
         * Constructeur de la classe tab
         * Initiaalise la mise en forme du tableau
         */
        public function __construct() {
            $this->tab = '<div class="container">
            <table class="table table-striped">';
        }

        /*
         * Initialise la ligne contenant les titres de chaque colonne
         */
        public function setTitle(){
           $tabTitle = "<thead>";
           $this->tab = $this->tab.$tabTitle ;
        }

        /*
         * Initialise le contenu du tableau
         */
        public function setBody(){
            $body = "<tbody>";
            $this->tab = $this->tab.$body ;
        }

        /*
         * Début d'une ligne
         */
        public function beginRow(){
            $column = "<tr>";
            $this->tab = $this->tab.$column ;
        }

        /*
         * Fin de la ligne contenant des titres
         */
        public function finishTitle(){
            $column = "</thead>" ;
            $this->tab = $this->tab.$column ;
        }

        /*
         * Fin d'une ligne
         */
        public function finishRow(){
           $column = "</tr>";
            $this->tab = $this->tab.$column ;
        }

        /*
         * Définit le titre d'une colonne
         */
        public function setColumnTitle($Title){
            $columnTitle = "<th>$Title</th>";
            $this->tab = $this->tab.$columnTitle ;
        }

        /*
         * Définit le contenu d'une cellule
         */
        public function setCell($libelle){
           $row = "<td>$libelle</td>";
            $this->tab = $this->tab.$row ;
        }

        /*
         * Affiche le tableau sur la page
         */
        public function getTab(){
                $foot = "</tbody></table></div>";
                $this->tab = $this->tab.$foot ;
                echo $this->tab ;
            }


    }
