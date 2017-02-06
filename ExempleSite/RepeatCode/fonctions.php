<?php
    function tabaffich($selection, $page, $action){
        //On affiche les résultats dans le même type de tableau que celui dans modifConsulation.php
        $tab = new tab() ;
        $tab->setTitle() ;
        $tab->beginRow() ;
        $tab->setColumnTitle("Nom") ;
        $tab->setColumnTitle("Sexe") ;
        $tab->setColumnTitle("Action") ;
        $tab->finishRow() ;
        $tab->setBody() ;
        while($data=$selection->fetch()){
            $form = '<form method="post" action="'.$page.'" class="form-horizontal">
                            <div class="form-group">
                                <input type="hidden" name="id" value="'.$data[0].'"><br>
                            </div>
                            <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">' ;
            if ($action == 'supprimer'){
                $form = $form.'<button type="submit" class="btn btn-default" name="suppr">Supprimer</button>
                            </div>
                           </div></form>' ;
            }elseif ($action == 'modifier') {
                $form = $form.'<button type="submit" class="btn btn-default" name="modif">Modifier</button>
                            </div>
                           </div></form>' ;
            }
            if(isset($data[0])){
                $tab->beginRow() ;
                $tab->setCell($data['nom'].' '.$data['prenom']) ;
                $tab->setCell($data['civilite']) ;
                $tab->setCell($form);
                $tab->finishRow() ;
            }else{
                echo'Ce Patient n est pas client du cabinet';
            }
        }
        $tab->getTab() ;
    }