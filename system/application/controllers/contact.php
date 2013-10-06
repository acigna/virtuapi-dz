<?php

/* Controlleur de contactez-nous du VirtUAPI-DZ */

class Contact extends Controller {

	function Contact() {
		parent::Controller();	
		$this->load->library('oms');
	}
        
    function Deconnection() {
        $this->oms->Deconnection($this);
    }
        
        
    function index() {
  	    //Contenu principal ici   
	    $contenu=$this->load->view("contact");             	
    }
}

?>
