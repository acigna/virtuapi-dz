<?php

/* Controlleur de la partie cours de Open Mind Students */

class Cours extends Controller {

	function Cours()
	{
		parent::Controller();	
		$this->load->library('oms');
	}
        
        
        function Deconnection()
        {
          	$this->oms->Deconnection($this);
        }
        
        function contenu($idannee=0)
        {
            if($idannee==0)
                show_404();
            
            $this->load->database();
            $idannee=mysql_real_escape_string(htmlentities($idannee));
            $annee=mysql_fetch_array(mysql_query("select * from annee where id='$idannee' "));
            
            if(!$idannee) show_404();
            
            $this->oms->partie_haute('./../../../',"Les cours de la {$annee[1]}",$this);	
            
            $cours=array();
            
            // Liste des modules 
            	$module=mysql_query("select id,nommodule from module where idannee='$idannee'");
            
            while(list($id,$nomM)=mysql_fetch_array($module))
            {
              $chapitre=mysql_query("select id,nomchapitre,numchapitre from chapitre where idmodule='$id'");
              
              $chapitres=array();
              
              while(list($id,$nomC,$num)=mysql_fetch_array($chapitre))
              {
                $contenu=mysql_query("select  Id,Type,IdPubliant,TypeFichier,TimeStampPub,TimeStampDernModif from cours where idchapitre='$id' order by type asc");
                
                $contenus=array();
                
                while(list($id,$type,$idpubliant,$typefichier,$pub,$dernModif)=mysql_fetch_array($contenu))
                {
                 $nomP=mysql_fetch_array(mysql_query("select * from membre where id='$idpubliant'"));
                 
                 $contenus[]=array('id'=>$id,'type'=>$type,'publiant'=>$nomP['Pseudo'],'typefichier'=>$typefichier,'pub'=>$pub,
                                   'dernmodif'=> $dernModif);                
                }
                
                $chapitres[]=array('nom'=>$nomC,'num'=>$num,'contenus'=>$contenus);              
              }
              
              $cours[]=array('nom'=>$nomM,'chapitres'=>$chapitres);   
              
              
            }
            
            
            $contenu=$this->load->view("cours",array('nomannee'=> $annee[1], 'cours' => $cours),true);             	
            echo $contenu ;
            
            $this->oms->partie_basse($this);
        }
          
        function annees($idspecialite=0)
        {
              if($idspecialite==0)
                  show_404();
              $this->load->database();

  	      $idspecialite=mysql_real_escape_string(htmlentities($idspecialite));
	      $specialite=mysql_fetch_array(mysql_query("select NomSpecialite from specialite where Id='$idspecialite'"));	
	      
	      if(!$specialite) show_404();
	      
              $this->oms->partie_haute('./../../../',"Les cours de la spécialité {$specialite[0]}",$this);
                      
  	       //Contenu principal ici   
               
               $requete=mysql_query("select * from annee where idspecialite='$idspecialite' order by NomAnnee");
               
	       $annees=array();
	       
	       while(list($id,$nom)=mysql_fetch_array($requete))
 	       {
 	          $annees[$id]=$nom ;
 	       }	
               
               $contenu=$this->load->view("annees",array('type'=>'cours','nom' => $specialite[0], 'annees'=>$annees),true);             	
               echo $contenu ;
               $this->oms->partie_basse($this);

        }
        
        function publier()
        {
                  
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
	  	
	  	
	  	if($_POST['code']!=$_SESSION['code'])
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
          
          $contenu=$this->load->view("cours_publier",array('specialites'=>$specialites, 'modules'=>$modules, 'chapitres' => $chapitres, 'error_upload'=>$upload_verif, 
                                                           'default'=>$default,'error_code'=>$code_verif),true);      
          echo $contenu;
          
          $this->oms->partie_basse($this);
         
        }
        
        
}  

?>
