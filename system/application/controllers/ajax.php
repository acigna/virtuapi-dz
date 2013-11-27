<?php

/* Controlleur pour les requêtes AJAX  */
class Ajax extends Controller {
  
    function Ajax() {
        parent::Controller();
        $this->load->database();
        $this->load->model('catalogue/annee','annee');
        $this->load->model('catalogue/module','module');
        $this->load->model('catalogue/chapitre','chapitre');
        $this->load->model('membre');
    }
        
    function annees($idspecialite=0) {
        echo json_encode( array ( 'annees' => $this->annee->listerAnnees($idspecialite) ) );
    }
     
    function existpseudo($pseudo="") {
        echo json_encode( array ( 'existpseudo' => $this->membre->existepseudo($pseudo) ) );
    }
        
        
    function modules($idannee=0) {
        echo json_encode( array( 'modules' => $this->module->listerModule($idannee) ) );
    }
        
    function chapitres($idmodule=0) {
        echo json_encode( array( 'chapitres' => $this->chapitre->listerChapitre($idmodule) ) );
    }
  
}


?>
