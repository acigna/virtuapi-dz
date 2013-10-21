<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PublierCoursForm
{

    function PublierCoursForm() {
        $CI = $this->CI = & get_instance();
        
        $CI->load->database();
        $CI->load->model( 'contenu/coursmodere', 'coursmodere' );
        $CI->load->library('form_validation'); 
        $CI->load->library('oms');
        $CI->load->library('generateurCode');
        $CI->load->helper('form');
        
        $CI->form_validation->set_rules( 'IdChapitre', 'Chapitre', 'required|xss_clean' );
        $CI->form_validation->set_rules( 'Type', 'Type de contenu', 'required|xss_clean' );
        $CI->form_validation->set_rules( 'code', 'question du formulaire', 'callback_checkCaptcha' );
        $CI->form_validation->set_rules( 'Cours', 'chemin du contenu', 'callback_verifierUpload' );
            
        $CI->form_validation->set_error_delimiters( '<p style="color:red;">', '</p>' );
        $CI->form_validation->set_message( 'required', '*Le champs %s est obligatoire.' );   
    }
    
    function is_valid() {
        return $this->CI->form_validation->run();
    }
    
    function save() {
        $CI = $this->CI;
        $idcours = $CI->coursmodere->ajouter( $CI->input->post('IdChapitre', true), $CI->input->post('Type', true), 
	                                          $CI->session->userdata('id'), 'pdf' );
	    $CI->oms->upload( "Cours", "Cours", $idcours );    
    }
    
    function checkCaptcha() {
        if( !$this->CI->generateurcode->checkCaptcha() ) {
            $this->CI->form_validation->set_message('checkCaptcha', "*Vous n'avez pas bien répondu à la question du formulaire.");
            return False;
        } else {
            return True;
        }
            
    }
    
    function verifierUpload() {
        $upload_verif = $this->CI->oms->verifierUpload("Cours");
	    if( $upload_verif != "" ) {
	        $this->CI->form_validation->set_message( "verifierUpload", $upload_verif );
            return False;
	    } else {
	        return True;
	    } 
    }


}


?>
