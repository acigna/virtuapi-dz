<?php

/* Controlleur de la partie cours de VirtUAPI-DZ */

class Cours extends Controller 
{
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
        $this->oms->Deconnection($this);
    }
        
    function contenu($idannee=0) {
        //Vérifier l'existance de l'année
        $annee = $this->oms->verifAnnee($this, $idannee);
        
        //Afficher la partie haute du site            
        $this->oms->partie_haute('./../../../',"Les cours de la {$annee->nom}",$this);	
        
        //Récupérer la liste des cours de l'année
        $cours = $this->cours->listerCoursAnnee($idannee);
         
        //Afficher le contenu principal
        $contenu=$this->load->view("cours", array('nomannee'=> $annee->nom, 'cours' => $cours), true);             	
        echo $contenu ;
        
        
        //Afficher la partie basse du site
        $this->oms->partie_basse($this);
    }
          
    function annees($idspecialite=0) {
    
        //Vérifier l'existance de la spécialité, puis la récupérer 
        $specialite = $this->oms->verifSpecialite($this, $idspecialite);

        //Afficher la partie haute du site	    
        $this->oms->partie_haute('./../../../',"Les sujets de la spécialité {$specialite->nom}", $this);
        
        //Récupérer la liste des années de cette spécialité
        $annees = $this->annee->listerAnnees($idspecialite);
        
        //Afficher le contenu principal               
        $contenu=$this->load->view("annees",array('type'=>'cours','nom' => $specialite->nom, 'annees'=>$annees),true);             	
        echo $contenu ;
        
        //Afficher la partie basse du site       
        $this->oms->partie_basse($this);
    }
        
    function publier() {
    
        $captcha = $this->generateurcode->getCaptcha();
          
        $this->oms->partie_haute('./../../',"Publier un cours", $this);
                            
        //Verfier si l'utilisateur est connecté
        $this->oms->verifierConnecte($this);         
           
        //Traiter le formulaire.
        $this->load->helper( array( 'form', 'url' ));
        $this->load->library('form_validation'); 
        
        //Initialization de la validation de formulaire si requête POST
        if(!isset($_POST['PseudoC'])) { 
            $this->form_validation->set_rules('IdChapitre', 'Chapitre', 'required|xss_clean');
          	$this->form_validation->set_rules('Type', 'Type de contenu', 'required|xss_clean');
          
            $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
            $this->form_validation->set_message('required', '*Le champs %s est obligatoire.');
        }  
          
          
        $upload_verif  = "";
        $code_verif = "";
          
          
        if(isset($_POST['IdChapitre'])) {
	  	    $upload_verif= $this->oms->verifierUpload("Cours");
	        if($upload_verif!="") {
                $upload_verif="<p style='color:red;'>".$upload_verif."</p>";
	        }
	  	
	  	
	  	    if($this->generateurcode->checkCaptcha()) {
	  	        $code_verif="<p style='color:red;'>*Vous n'avez pas bien répondu à la question du formulaire.</p>";	  	
	  	    }
	  
	    }      
        
        //Run the form validation
        if($this->form_validation->run() == TRUE && $upload_verif == "" && $code_verif == "") {
	       
	        //Insérer le cours à modérer dans la base de données et dans le système de fichier
	        $idcours = $this->coursmodere->ajouter($idchapitre, $type, $idUser, 'pdf');
	        $this->oms->upload("Cours", "Cours", $idcours);
	        
	        //TODO: Change to redirect
	        $contenu=$this->load->view('cours_publiee', "", true);
            echo $contenu;
	       
	       
	        $this->oms->partie_basse($this);
	       
	        return ;
	    }  
	  
	    //Remplir les années, modules et chapitres par défault
	    if( isset($_POST['IdChapitre']) ) { 
            $default = $this->chapitre->getCMA($_POST['IdChapitre']);
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
          
        $contenu = $this->load->view( "cours_publier", array( 'specialites' => $specialites, 'modules' => $modules, 'chapitres' => $chapitres, 
                                                              'error_upload' => $upload_verif, 'default' => $default,'error_code' => $code_verif, 
                                                              'captcha' => $captcha ), true );      
        echo $contenu;
          
        $this->oms->partie_basse($this);
         
    }
        
        
}  

?>
