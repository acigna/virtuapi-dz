<?php

/* Controlleur de contactez-nous du VirtUAPI-DZ */

class Contact extends Controller {

	function Contact() {
		parent::Controller();	
		$this->load->library('oms');
	}
        
    function index() {
	    $this->load->view("contact");             	
    }
}

?>
