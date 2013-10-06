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
        $this->load->view( "ajax/ajax_annee", array( 'annees' => $this->annee->listerAnnees($idspecialite) ) );         
    }
     
    function existpseudo($pseudo="") {
        $this->load->view( "ajax/ajax_pseudo", array( 'reponse' => $this->membre->existepseudo($pseudo) ) );    
    }
        
        
    function module($idannee=0) {
        $this->load->view( "ajax/ajax_module", array( 'modules' => $this->module->listerModule($idannee) ) );
    }
        
    function chapitre($idmodule=0) {
        $this->load->view( "ajax/ajax_chapitre", array( 'chapitres' => $this->chapitre->listerChapitre($idmodule) ) );      
    }
  
}


?>
