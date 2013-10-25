<?php

/* Controlleur de contactez-nous du VirtUAPI-DZ */

class Universite_virtuelle extends Controller {

    function Universite_virtuelle() {
		parent::Controller();	
		$this->load->library('oms');
    }
        
    function index() {
        $this->load->view("universite_virtuelle");             	
    }
}

?>
