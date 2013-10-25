<?php

/* Controlleur de la partie cours de VirtUAPI-DZ */

class Sujets extends Controller {

    function Sujets() {
    
        parent::Controller();
        $this->load->database();
        $this->load->library('oms');
        $this->load->model('catalogue/specialite','specialite');
        $this->load->model('catalogue/annee','annee');
        $this->load->model( 'contenu/sujetaccepte', 'sujet' );
        
    }
 	
    function Deconnection() {
        $this->oms->Deconnection($this);
    }
          
    function annees($idspecialite=0) {
    
        //Vérifier l'existance de la spécialité, puis la récupérer 
        $specialite = $this->oms->verifSpecialite($idspecialite);

        //Récupérer la liste des années de cette spécialité
        $annees = $this->annee->listerAnnees($idspecialite);
        
        //Afficher le contenu principal               
        $this->load->view( "contenu/annees", array( 'type'=>'sujets','nom' => $specialite->nom, 'annees'=>$annees ) );  
                   	
    }
        
    function contenu($idannee=0) {
    
        //Vérifier l'existance de l'année
        $annee = $this->oms->verifAnnee($idannee);
        
        //Récupérer la liste des sujets de l'année
        $sujets = $this->sujet->listerSujetsAnnee($idannee);
         
        //Afficher la page de contenu de sujets
        $this->load->view( "contenu/sujets", array( 'nomannee'=> $annee->nom, 'sujets' => $sujets ) );
    }

    function publier() {
	
    }
}





?>
