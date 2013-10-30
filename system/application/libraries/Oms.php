<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oms {

    function partie_haute( $titre, $css = array(), $js = array() ) {
    
        $CI = & get_instance();
        $CI->load->database();
        $CI->load->model("membre");
        $CI->load->library('session');
        $CI->load->library('form_validation');
        $CI->load->helper( array( 'form', 'url' ) );
              
        $erreur = $this->traiterConnectionMembre();
        $id = $CI->session->userdata('id');
        if($id!=null) {
          $membre = $CI->membre->charger($id);
        }else{
          $membre = null;
        }
        
        $CI->load->view('includes/partie_haute', array( 'titre' => $titre, 'css' => $css, 'js' => $js, 
                                                        'membre'=>$membre, 'erreurConnection' => $erreur ) );
      
    }
         

    function traiterConnectionMembre()  {
        $CI = & get_instance();
        $CI->load->model('membre');
        $CI->load->helper('url');
        $pseudo = $CI->input->post( 'PseudoC', true );
        $mdp = $CI->input->post( 'MotDePasseC', true );
        if( $pseudo &&  $mdp ) {
            $membre = $CI->membre->auth( $pseudo, $mdp );
            if( $membre && $membre->auth ) {
                //Vérifier si le dernier essai de connection dépasse  15 secondes                $difSeconde = time() - $membre->DernEssai;
                if( $difSeconde > 15 ) {
                    //Sauvegarder les données personnelles du membre 
  	                $CI->session->set_userdata( 'id', $membre->Id );
	                $CI->session->set_userdata( 'Pseudo', $membre->Pseudo );
                    $CI->session->set_userdata( 'Nom', $membre->Nom );
	                $CI->session->set_userdata( 'Prenom', $membre->Prenom );
	                $CI->session->set_userdata( 'TypeMembre', $membre->TypeMembre );
                    $CI->session->set_userdata( 'EMail', $membre->EMail );
                    $CI->session->set_userdata( 'TimeStampInscrit', $membre->TimeStampInscrit );
	                $CI->session->set_userdata( 'MotDePasse', $membre->MotDePasse );
	                redirect( uri_string( current_url() ), "location" );
	                die();

 	            } else {
 	                return "Connection suspendu, veuillez rÃ©essayer dans $difSeconde secondes";
 	            }
 	        
   	        } else {
                //Vérifier si le membre existe
                if( $membre ) {
	                //Vérifier si le dernier essai de connection dépasse 15 secondes
	                $difSeconde = $CI->membre->majDernEssai( $membre->DernEssai, $pseudo );
		            if( !$difSeconde  ) {			            return "Pseudo inexistant, ou mot de passe incorrecte";
			        } else {
			            return "Connection suspendu, veuillez rÃ©essayer dans $difSeconde secondes"; 
                    }
		        } else {
		            return "Pseudo inexistant, ou mot de passe incorrecte";  
		        }		 
            }
        } else {
            if( $pseudo === "" || $mdp === "" ){
                return "Pseudo ou mot de passe manquant"; //TODO: Vérifier le language   
            } 
            return ""; 
        }
    }
	
	function verifierUpload($name) {
	     
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
	
	function upload($name, $type, $id) {
	
	  // On peut valider le fichier et le stocker définitivement
 		move_uploaded_file($_FILES[$name]['tmp_name'], "./temp/{$type}{$id}.pdf" );
  	
	}
	
    //Vérifier si l'utilisateur est connecté
    function verifierConnecte() {
    
      //Récupérer une instance de CodeIgniter
      $CI = & get_instance();
      $CI->load->library('session');
	  $id = $CI->session->userdata("id");
	  if( $id == null ) {
          echo $CI->load->view('includes/nonconnecte', '', True);
          die();
      }  
	  
	  return $id;	
	  
	}
	
	//Verifier l'existence d'une spécialité
	function verifSpecialite($id) {
	
	  $CI = & get_instance();
	  $specialite_exist = $CI->specialite->getSpecialite($id);
	  
	  if(!$specialite_exist)
	       show_404();
	       
	  return $specialite_exist; 
	      
	}
	
	//Verifier l'existence d'une année
	function verifAnnee($id) {
	
	  $CI = & get_instance();
	  $annee_exist = $CI->annee->getAnnee($id);
	  
	  if(!$annee_exist)
	      show_404();
	       
	  return $annee_exist;
	       
	}

}

?>
