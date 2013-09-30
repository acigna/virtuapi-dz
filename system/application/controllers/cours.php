<?php

/* Controlleur de la partie cours de VirtUAPI-DZ */

class Cours extends Controller {

    function Cours() {
        parent::Controller();
        $this->load->database();
        $this->load->library('oms');
        $this->load->library('generateurCode');
        $this->load->model('catalogue/specialite','specialite');
        $this->load->model('catalogue/annee','annee');	    
        $this->load->model('catalogue/module', 'module');
        $this->load->model('catalogue/chapitre', 'chapitre');
        $this->load->model('contenu/coursaccepte', 'cours');
        $this->load->model('contenu/coursmodere', 'coursmodere');
    }
        
        
    function Deconnection() {
        $this->oms->Deconnection();
    }
        
    function contenu($idannee=0) {
    
        //Vérifier l'existance de l'année
        $annee = $this->oms->verifAnnee($idannee);
        
        //Récupérer la liste des cours de l'année
        $cours = $this->cours->listerCoursAnnee($idannee);
         
        //Afficher la page de contenu de cours
        $contenu = $this->load->view( "cours", array( 'nomannee'=> $annee->nom, 'cours' => $cours ) );             	
    }
          
    function annees($idspecialite=0) {
    
        //Vérifier l'existance de la spécialité, puis la récupérer 
        $specialite = $this->oms->verifSpecialite($idspecialite);

        //Récupérer la liste des années de cette spécialité
        $annees = $this->annee->listerAnnees($idspecialite);
        
        //Afficher la page de liste des années pour la spécialité               
        $contenu = $this->load->view( "annees", array( 'type'=>'cours', 'nom' => $specialite->nom, 'annees'=>$annees ) );             	
    }
        
    function publier() {
    
        //Verfier si l'utilisateur est connecté
        $this->oms->verifierConnecte();  
    
        //Charger les helpers requis.
        $this->load->helper( array( 'form', 'url' ) );
        
        //Validation de formulaire si requête POST
        if( $this->input->post('cours_publier') ) { 
            $this->load->library('contenu/publierCoursForm');
            if( $this->publiercoursform->is_valid() == true ) {
	       
	            //Insérer le cours à modérer dans la base de données et dans le système de fichier
	            $idcours = $this->coursmodere->ajouter( $this->input->post('IdChapitre', true), $this->input->post('Type', true), 
	                                                    $this->session->userdata('id'), 'pdf' );
	            $this->oms->upload( "Cours", "Cours", $idcours );
	        
	            redirect('/cours/publie', 'location');
	            return ;
	        }  
     
        }  
          
	    
	    //Générer la Captcha
        $captcha = $this->generateurcode->getCaptcha();
          
	    //Remplir les années, modules et chapitres par défault
	    $idchapitre = $this->input->post( 'IdChapitre', true );
	    if( $idchapitre ) { 
            $default = $this->chapitre->getCMA($idchapitre);
	    } else {
            $default['chapitre'] = "";
            $default['module'] = "";
            $default['annee'] = "";	   
	    }
	  
	    //Récupérer les années avec leurs spécialités associées, ainsi que l'année à afficher (Par défaut ou le premier)
        $specialites = $this->annee->listerAnneesSpec();
         
        if( count($specialites) != 0 ) {
            if($default['annee'] == "") {  
                $firstA = $specialites[0]["id"];
            } else {
                $firstA = $default['annee'];              
            } 
        }
               
        //Récupérer les modules et le module à afficher (Par défaut ou le premier)
        $modules = $this->module->listerModule($firstA);
        if( count($modules) != 0 ) {
            if( $default['module'] == "" ) {  
                $firstM = $modules[0]["id"];
            } else {
                $firstM = $default['module'];              
            }                     
        }
        
        //Récupérer les chapitres 
        $chapitres = $this->chapitre->listerChapitre($firstM);
        
        //Afficher la page de publication de cours
        $contenu = $this->load->view( "cours_publier", array( 'specialites' => $specialites, 'modules' => $modules, 'chapitres' => $chapitres, 
                                                              'default' => $default, 'captcha' => $captcha ) );      
    }
    
    function publie() {
	    $contenu = $this->load->view( 'cours_publie' );
    }
    
    function checkCaptcha() {
        return $this->publiercoursform->checkCaptcha();   
    }
    
    function verifierUpload() {
        return $this->publiercoursform->verifierUpload();
    }
    
    
        
}  

?>
