<?php

/* Controlleur de la partie cours de VirtUAPI-DZ */

class Cours extends Controller 
{

    function Cours()
    {
        parent::Controller();
        $this->load->database();
        $this->load->library('oms');
        $this->load->library('generateurCode');
        $this->load->model('catalogue/specialite','specialite');
        $this->load->model('catalogue/annee','annee');
        $this->load->model('contenu/coursaccepte', 'cours');
    }
        
        
    function Deconnection()
    {
        $this->oms->Deconnection($this);
    }
        
    function contenu($idannee=0)
    {
        //Vérifier l'existance de l'année
        $annee = $this->oms->verifAnnee($this, $idannee);
        
        //Afficher la partie haute du site            
        $this->oms->partie_haute('./../../../',"Les cours de la {$annee->nom}",$this);	
        
        //Récupérer la liste des cours de l'année
        $cours = $this->cours->listerCoursAnnee($idannee);
         
        //Afficher le contenu principal
        $contenu=$this->load->view("cours",array('nomannee'=> $annee->nom, 'cours' => $cours),true);             	
        echo $contenu ;
        
        
        //Afficher la partie basse du site
        $this->oms->partie_basse($this);
    }
          
    function annees($idspecialite=0)
    {
        //Vérifier l'existance de la spécialité, puis la récupérer 
        $specialite = $this->oms->verifSpecialite($this, $idspecialite);

        //Afficher la partie haute du site	    
        $this->oms->partie_haute('./../../../',"Les sujets de la spécialité {$specialite->nom}",$this);
        
        //Récupérer la liste des années de cette spécialité
        $annees = $this->annee->listerAnnees($idspecialite);
        
        //Afficher le contenu principal               
        $contenu=$this->load->view("annees",array('type'=>'cours','nom' => $specialite->nom, 'annees'=>$annees),true);             	
        echo $contenu ;
        
        //Afficher la partie basse du site       
        $this->oms->partie_basse($this);
    }
        
        function publier()
        {
          $captcha = $this->generateurcode->getCaptcha();
          
          $this->oms->partie_haute('./../../',"Publier un cours",$this);
                            
          //Verfier si l'utilisateur est connecté
          $this->oms->verifierConnecte($this);         
           
          //Traiter le formulaire.
            
          $this->load->helper(array('form', 'url'));
          $this->load->library('form_validation'); 
          
          if(!isset($_POST['PseudoC']))
	  { 
           	$this->form_validation->set_rules('IdChapitre', 'Chapitre', 'required|xss_clean');
          	$this->form_validation->set_rules('Type', 'Type de contenu', 'required|xss_clean');
          
                $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
          
        	$this->form_validation->set_message('required', '*Le champs %s est obligatoire.');
          }  
          
          
          $upload_verif="";
          $code_verif="";
          
          
          if(isset($_POST['IdChapitre']))
	  {
	  	$upload_verif= $this->oms->verifierUpload("Cours");
	    
	        if($upload_verif!="")
	        {

	          $upload_verif="<p style='color:red;'>".$upload_verif."</p>";
	        }
	  	
	  	
	  	if($this->generateurcode->checkCaptcha())
	  	{
	  	  $code_verif="<p style='color:red;'>*Vous n'avez pas bien répondu à la question du formulaire.</p>";	  	
	  	}
	  
	  }      
          
          if($this->form_validation->run() == TRUE && $upload_verif=="" && $code_verif=="")
	  {
	       
	       $idchapitre=mysql_real_escape_string(htmlentities($_POST['IdChapitre']));
	       $type=mysql_real_escape_string(htmlentities($_POST['Type']));
	       
	       
               mysql_query("Insert into coursamoderer values('','$idchapitre','$type','".$idUser."','pdf',".time().")");
	      
	       
	       $this->oms->upload("Cours","Cours",mysql_insert_id());
	       
	       $contenu=$this->load->view('cours_publiee',"",true);
                echo $contenu;
	       
	       
	       $this->oms->partie_basse($this);
	       
	       return ;
	    
	  }  
	  
	  //Remplir les années, modules et chapitres
	  
	  $default=array();
	  
	  if(isset($_POST['IdChapitre']))
	  { 
	   $defaultchapitre=mysql_real_escape_string(htmlentities($_POST['IdChapitre']));
	   
	   $remplir_cas=mysql_fetch_array(mysql_query("select c.id as idC,m.id as idM,a.id as idA from chapitre c, module m, annee a, specialite s where c.id='$defaultchapitre' and c.idmodule=m.id and m.idannee=a.id"));
	   
	   $default['chapitre']=$remplir_cas['idC'];
	   $default['module']=$remplir_cas['idM'];
	   $default['annee']=$remplir_cas['idA'];
	   
	  }else{
	  
	   $default['chapitre']="";
	   $default['module']="";
	   $default['annee']="";	   
	  
	  }
	  
	  $annee=mysql_query("select a.id,s.NomSpecialite,NomAnnee,IdSpecialite from annee a,specialite s where s.id=a.idspecialite order by s.NomSpecialite ASC,a.NomAnnee ASC");
          
	              
          list($idA,$nomS,$nomA,$idS)=mysql_fetch_array($annee);
          
          
                                       
          $specialites=array();
          
          if($idA!=NULL)
          {
                if($default['annee']=="")
                {  
                  $firstA=$idA;
                }else{
                  $firstA=$default['annee'];              
                } 
                
                $specialites=array(array('nom'=>$nomS,'annees' => array(array('id'=>$idA,'nom'=>$nomA) ) ) );
                
                
          	while(list($idA,$nomS,$nomA,$idS)=mysql_fetch_array($annee))
          	{
                    if($specialites[count($specialites)-1]['nom']==$nomS)
                    {
                    
                      $specialites[count($specialites)-1]['annees'][]=array('id'=>$idA,'nom'=>$nomA) ;
                    
                    }else{
                    
                      $specialites[]=array('nom'=>$nomS,'annees' => array(array('id'=>$idA,'nom'=>$nomA)));
                    }  
          	} 
          }
          
          
          $module=mysql_query("select id,nommodule from module where idannee='$firstA'");
          
          list($id,$nom)=mysql_fetch_array($module);
          
          $modules=array();
          
          if($id!=NULL)
          { 
                if($default['module']=="")
                {  
                  $firstM=$id;
                }else{
                  $firstM=$default['module'];              
                } 
            	
            	$modules=array(array('id'=>$id,'nom'=>$nom) );
            	
          	while(list($id,$nom)=mysql_fetch_array($module))
          	{
                  $modules[]=array('id'=>$id,'nom'=>$nom);            
         	}
         	
         	
          
          }
          
          $chapitre=mysql_query("select id,numchapitre,nomchapitre from chapitre where idmodule='$firstM'");
          
          list($id,$num,$nom)=mysql_fetch_array($chapitre);
          
          $chapitres=array();
          
          if($id!=NULL)
          { 
            	$chapitres=array(array('id'=>$id,'num' => $num,'nom' => $nom) );
            	
          	while(list($id,$num,$nom)=mysql_fetch_array($chapitre))
          	{
                  $chapitres[]=array('id'=>$id,'num' => $num,'nom' => $nom);            
         	}
          
          }
          
          $contenu=$this->load->view("cours_publier",array('specialites'=>$specialites, 'modules'=>$modules, 'chapitres' => $chapitres, 
                                                           'error_upload'=>$upload_verif, 'default'=>$default,'error_code'=>$code_verif, 
                                                           'captcha'=>$captcha),true);      
          echo $contenu;
          
          $this->oms->partie_basse($this);
         
        }
        
        
}  

?>
