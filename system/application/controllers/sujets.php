<?php

/* Controlleur de la partie cours de VirtUAPI-DZ */

class Sujets extends Controller {

    function Sujets() {
    
        parent::Controller();
        $this->load->database();
        $this->load->library('oms');
        $this->load->library('generateurCode');
        $this->load->model('catalogue/specialite','specialite');
        $this->load->model('catalogue/annee','annee');
        $this->load->model( 'contenu/sujetaccepte', 'sujet' );
        
    }
 	
    //Afficher les années d'une spécialité donnée
    function annees($idspecialite=0) {
    
        //Vérifier l'existance de la spécialité, puis la récupérer 
        $specialite = $this->oms->verifSpecialite($idspecialite);

        //Récupérer la liste des années de cette spécialité
        $annees = $this->annee->listerAnnees($idspecialite);
        
        //Afficher le contenu principal               
        $this->load->view( "contenu/annees", array( 'type'=>'sujets','nom' => $specialite->nom, 'annees'=>$annees ) );  
                   	
    }

    //Afficher le contenu d'une année particulière        
    function contenu($idannee=0) {
    
        //Vérifier l'existance de l'année
        $annee = $this->oms->verifAnnee($idannee);
        
        //Récupérer la liste des sujets de l'année
        $sujets = $this->sujet->listerSujetsAnnee($idannee);
         
        //Afficher la page de contenu de sujets
        $this->load->view( "contenu/sujets", array( 'nomannee'=> $annee->nom, 'sujets' => $sujets ) );
    }

    //Publier un sujet d'examen
    function publier() {
        //Verfier si l'utilisateur est connecté
        $this->oms->verifierConnecte();

        //Générer la Captcha
        $captcha = $this->generateurcode->getCaptcha();

        //Récupérer les années avec leurs spécialités associées, ainsi que l'année à afficher (Par défaut ou le premier)
        $specialites = $this->annee->listerAnneesSpec();
    
        //Charger les helpers requis.
        $this->load->helper('url');

        $this->load->view( 'contenu/sujet_publier', array( 'specialites' => $specialites, 
            'captcha' => $captcha ) );	
    }
}

?>
