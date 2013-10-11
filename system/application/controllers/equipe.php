<?php

/* Controlleur de l'équipe du Open Mind Students */

class Equipe extends Controller {

    function Equipe() {
		parent::Controller();	
		$this->load->library('oms');
    }
        
        
    function Deconnection() {
          	$this->oms->Deconnection($this);
    }
        
        
    function index() {
        $this->load->view("equipe");             	
    }
}

?>
