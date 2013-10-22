<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PublierCoursForm {

    function PublierCoursForm() {
        $CI = & get_instance();
        $CI->load->database();
        $CI->load->helper('form_loader');
        $CI->load->model( 'contenu/coursmodere', 'coursmodere' );
        $CI->load->library('oms');
        $CI->load->library('generateurCode');
        
        $config = array(
                      array(
                          'field' => 'IdChapitre',
                          'label' => 'Chapitre',
                          'rules' => 'required|xss_clean'
                      ),
                      
                      array(
                          'field' => 'Type',
                          'label' => 'Type de contenu',
                          'rules' => 'required|xss_clean'
                      ),
                      array(
                          'field' => 'code',
                          'label' => 'question du formulaire',
                          'rules' => 'callback_checkCaptcha'
                      ),
                      array(
                          'field' => 'Cours',
                          'label' => 'chemin du contenu',
                          'rules' => 'callback_verifierUpload'
                      ),                      
                                                  
                  );
        load_form( $this, $config, '<p style="color:red;">', '</p>', '*Le champs %s est obligatoire.' );
    }
    
    function is_valid() {
        return $this->form_validation->run();
    }
    
    function save() {
        $CI = $this->CI;
        $idcours = $CI->coursmodere->ajouter( $CI->input->post( 'IdChapitre', true ), $CI->input->post( 'Type', true ), 
	                                          $CI->session->userdata('id'), 'pdf' );
	    $CI->oms->upload( "Cours", "Cours", $idcours );    
    }
    
    function checkCaptcha() {
        if( !$this->CI->generateurcode->checkCaptcha() ) {
            $this->form_validation->set_message('checkCaptcha', "*Vous n'avez pas bien répondu à la question du formulaire.");
            return False;
        } else {
            return True;
        }
            
    }
    
    function verifierUpload() {
        $upload_verif = $this->CI->oms->verifierUpload("Cours");
	    if( $upload_verif != "" ) {
	        $this->form_validation->set_message( "verifierUpload", $upload_verif );
            return False;
	    } else {
	        return True;
	    } 
    }


}


?>
