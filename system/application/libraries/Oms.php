<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oms 
{

    function Deconnection(&$cont)
    {
	$cont->load->library('session');
 	$cont->session->sess_destroy();
 	header("location: ./../../index.php");
    }
    
    function partie_basse(&$cont)
    {
	echo "</div>";
        echo "</div>";
	$footer=$cont->load->view('includes/footer','',true);
        echo $footer.'</body></html>';
    }

    function partie_haute($root,$titre,&$cont)
    {
        $cont->load->database();
	$cont->load->library('session');
	$cont->load->helper(array('form', 'url'));
	$cont->load->library('form_validation');
              
        $erreur=$this->traiterConnectionMembre($cont);
        $entete=$cont->load->view('includes/entete', array('titre' => $titre),true);
	echo $entete;
                
        $menu_haut=$cont->load->view('includes/menu_haut','',true);
        
        $cont->load->model("membre");
        
        $id=$cont->session->userdata('id');
        if($id!=null)
        {
          $membre=$cont->membre->charger($id);
        }else{
          $membre=null;
        }
        
        $menu_gauche=$cont->load->view('includes/menu_gauche', array('membre'=>$membre,'erreurConnection' => $erreur),true);
              
        echo "$menu_haut $menu_gauche" ;
        echo "<div id='colTwo'>";
     }
         

    function traiterConnectionMembre(&$cont)
    {
	if(isset($_POST['PseudoC']) && isset($_POST['MotDePasseC']) && $_POST['PseudoC']!=null && $_POST['MotDePasseC']!=null ){
  	 //Netoyage des variables
   		$SainBD['PseudoC']=mysql_real_escape_string(htmlentities($_POST['PseudoC']));
   		$SainBD['MotDePasseC']=mysql_real_escape_string(htmlentities($_POST['MotDePasseC']));
  	        $MembreRequete=mysql_query("select * from membre where lower(Pseudo)='".strtolower($SainBD['PseudoC'])."'");    
   		$MembreResultat=mysql_fetch_array($MembreRequete);
   		$NombreLigne=mysql_num_rows($MembreRequete) ;
   		
   		$cont->config->load('oms');
   
   if($NombreLigne && $MembreResultat['MotDePasse']==md5(($cont->config->item('salt_gauche')).md5($SainBD['MotDePasseC']).($cont->config->item('salt_droite')))){
     //Vérifier si le dernier essai de connection dépasse  15 secondes
	  $difSeconde=time()-$MembreResultat['DernEssai'];
	 if($difSeconde>15){
     //Sauvegarder les données personnelles du membre 
  	   $cont->session->set_userdata('id',$MembreResultat['Id']);
	   $cont->session->set_userdata('Pseudo',$MembreResultat['Pseudo']);
           $cont->session->set_userdata('Nom',$MembreResultat['Nom']);
	   $cont->session->set_userdata('Prenom',$MembreResultat['Prenom']);
	   $cont->session->set_userdata('TypeMembre',$MembreResultat['TypeMembre']);
           $cont->session->set_userdata('EMail',$MembreResultat['EMail']);
           $cont->session->set_userdata('TimeStampInscrit',$MembreResultat['TimeStampInscrit']);
	   $cont->session->set_userdata('MotDePasse',$MembreResultat['MotDePasse']);

 	  }else return "Connection suspendu, veuillez rÃ©essayer dans $difSeconde secondes";
   	}else{
     
       		if($NombreLigne){
	              //Vérifier si le dernier essai de connection dépasse  15 secondes
		      $difSeconde=time()-$MembreResultat['DernEssai'];
		      if($difSeconde>15){
		       return "Pseudo inexistant, ou mot de passe incorrecte";   
        	       $temps=time();
			       mysql_query("update membre set DernEssai=$temps where lower(Pseudo)='".strtolower($SainBD['PseudoC'])."'");
			 }else return "Connection suspendu, veuillez rÃ©essayer dans $difSeconde secondes"; 
          
		   }else return "Pseudo inexistant, ou mot de passe incorrecte";  		 
   		}
  	  }else if( isset($_POST['PseudoC']) && isset($_POST['MotDePasseC']) && ($_POST['PseudoC']!="" || $_POST['MotDePasseC']!="")){
   	   		return "Pseudo ou mot de passe manquant";   
  
  		} 
	  return ""; 

	}
	
	function verifierUpload($name)
	{
	
	     
	  	if ( $_FILES[$name]['error'] == 0)
 		{
        		 // Testons si le fichier n'est pas trop gros
       			 if ($_FILES[$name]['size'] <= 1000000)
        	 	 {
                		// Testons si l'extension est autorisée
                		$infosfichier = pathinfo($_FILES[$name]['name']);
                		$extension_upload = $infosfichier['extension'];
                		$extensions_autorisees = array('pdf');
                		                		
                		if (in_array(strtolower($extension_upload), $extensions_autorisees))
               			{
               			
        		          return "";
        		                 
                		}else{
                		  return "*Format de fichier non-permis. Vieullez spécifier un format '.pdf'. Pour convertir au format pdf, veuillez utiliser le lien suivant : http://www.conv2pdf.com.";                		
                		}
                		
                		
	                  }else{
	                  	return "*La taille du fichier depasse les 8mo. Vieullez publier un fichier moins volumineux.";	                  
	                  }
		 }else{
		   return "*Une erreur est survenue lors de l'envoi du fichier. Vieullez réessayer la publlication." ; 		 
		 }
	    	return "";
	}
	
	function upload($name,$type,$id)
	{
	  // On peut valider le fichier et le stocker définitivement
 		move_uploaded_file($_FILES[$name]['tmp_name'], "./temp/{$type}{$id}.pdf" );
  	
	}
	
        //Vérifier si l'utilisateur est connecté
        function verifierConnecte(&$cont)
	{
	  $id=$cont->session->userdata("id");
	  
	  
          if($id==null)
          {
          	$contenu=$cont->load->view('includes/nonconnecte',"",true);
          	echo $contenu;
          	$cont->oms->partie_basse($cont);
          	die();
          }  
	  
	  return $id;	
	}
	
	//Verifier l'existence d'une spécialité
	function verifSpecialite(&$cont,$id)
	{
	  $specialite_exist=$cont->specialite->getSpecialite($id);
	  
	  if(!$specialite_exist)
	       show_404();
	       
	  return $specialite_exist[0];     
	}
	
	//Verifier l'existence d'une année
	function verifAnnee(&$cont,$id)
	{
	  $annee_exist=$cont->annee->getAnnee($id);
	  
	  if(!$annee_exist)
	      show_404();
	       
	  return $annee_exist[0];     
	}

}

?>
